<?php
/**
 * ToysLand AJAX Cart & Mini Cart Drawer Handlers
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_ajax_toysland_add_to_cart', 'toysland_ajax_add_to_cart_callback');
add_action('wp_ajax_nopriv_toysland_add_to_cart', 'toysland_ajax_add_to_cart_callback');

function toysland_ajax_add_to_cart_callback() {
    $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
    $quantity   = isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : 1;

    if (!$product_id) {
        wp_send_json_error(['message' => 'Ապրանքի ID-ն բացակայում է:']);
    }

    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);

    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity)) {
        do_action('woocommerce_ajax_added_to_cart', $product_id);

        ob_start();
        toysland_render_mini_cart_items();
        $drawer_html = ob_get_clean();

        wp_send_json_success([
            'cart_count'     => WC()->cart->get_cart_contents_count(),
            'cart_subtotal'  => WC()->cart->get_cart_subtotal(),
            'cart_total_raw' => WC()->cart->get_subtotal(),
            'drawer_html'    => $drawer_html,
            'message'        => 'Ապրանքը հաջողությամբ ավելացվել է զամբյուղ!',
        ]);
    } else {
        wp_send_json_error(['message' => 'Ապրանքը չհաջողվեց ավելացնել զամբյուղ:']);
    }
}

add_action('wp_ajax_toysland_update_cart_qty', 'toysland_update_cart_qty_callback');
add_action('wp_ajax_nopriv_toysland_update_cart_qty', 'toysland_update_cart_qty_callback');

function toysland_update_cart_qty_callback() {
    $cart_item_key = isset($_POST['cart_item_key']) ? sanitize_text_field($_POST['cart_item_key']) : '';
    $quantity      = isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : 0;

    if (empty($cart_item_key)) {
        wp_send_json_error(['message' => 'Սխալ հարցում']);
    }

    if ($quantity > 0) {
        WC()->cart->set_quantity($cart_item_key, $quantity);
    } else {
        WC()->cart->remove_cart_item($cart_item_key);
    }

    WC()->cart->calculate_totals();

    $cart_item = WC()->cart->get_cart_item($cart_item_key);
    $line_subtotal = '';
    if ($cart_item && !empty($cart_item['data'])) {
        $line_subtotal = WC()->cart->get_product_subtotal($cart_item['data'], $cart_item['quantity']);
    }

    $subtotal_raw = floatval(WC()->cart->get_subtotal());
    $free_shipping_threshold = 15000;
    $remaining = max(0, $free_shipping_threshold - $subtotal_raw);
    $percent = min(100, round(($subtotal_raw / $free_shipping_threshold) * 100));
    $is_free = ($remaining <= 0);

    ob_start();
    toysland_render_mini_cart_items();
    $drawer_html = ob_get_clean();

    wp_send_json_success([
        'cart_count'              => WC()->cart->get_cart_contents_count(),
        'cart_subtotal'           => WC()->cart->get_cart_subtotal(),
        'cart_total'              => WC()->cart->get_total(),
        'cart_total_raw'          => $subtotal_raw,
        'line_subtotal'           => $line_subtotal,
        'is_free_shipping'        => $is_free,
        'free_shipping_percent'   => $percent,
        'free_shipping_remaining' => toysland_price($remaining),
        'shipping_text'           => $is_free ? 'Անվճար' : toysland_price(1000),
        'is_empty'                => WC()->cart->is_empty(),
        'drawer_html'             => $drawer_html,
    ]);
}

/**
 * Render items inside the slide-out mini cart
 */
function toysland_render_mini_cart_items() {
    $cart = WC()->cart;
    if (!$cart || $cart->is_empty()) {
        ?>
        <div class="drawer-empty-cart">
            <svg class="empty-cart-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="9" cy="21" r="1"/>
                <circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
            </svg>
            <h4 class="empty-cart-title">Ձեր զամբյուղը դատարկ է</h4>
            <p class="empty-cart-text">Գտեք հիանալի խաղալիքներ Ձեր փոքրիկների համար և ավելացրեք զամբյուղ:</p>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-primary-large" style="padding: 12px 24px; font-size: 14px;">
                Գնալ խանութ
            </a>
        </div>
        <?php
        return;
    }

    $free_shipping_threshold = 15000;
    $current_subtotal = floatval($cart->get_subtotal());
    $percent = min(100, round(($current_subtotal / $free_shipping_threshold) * 100));
    $remaining = max(0, $free_shipping_threshold - $current_subtotal);
    ?>

    <!-- Free Delivery Meter -->
    <div class="free-shipping-meter-wrap">
        <div class="free-shipping-text">
            <?php if ($remaining > 0) : ?>
                <span>🚚 Մնացել է <strong><?php echo esc_html(toysland_price($remaining)); ?></strong> անվճար առաքման համար!</span>
            <?php else : ?>
                <span>🎉 Շնորհավորում ենք! Դուք ստացել եք <strong>ԱՆՎՃԱՐ ԱՌԱՔՈՒՄ</strong>:</span>
            <?php endif; ?>
        </div>
        <div class="meter-track">
            <div class="meter-fill" style="width: <?php echo esc_attr($percent); ?>%;"></div>
        </div>
    </div>

    <!-- Items List -->
    <div class="drawer-cart-items-list">
        <?php
        foreach ($cart->get_cart() as $cart_item_key => $cart_item) :
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            if (!$_product || !$_product->exists() || $cart_item['quantity'] <= 0) continue;

            $product_name = $_product->get_name();
            $product_price = WC()->cart->get_product_price($_product);
            $product_img = toysland_get_product_image_url($_product);
            $product_url = $_product->get_permalink($cart_item);
        ?>
            <div class="drawer-cart-item" data-key="<?php echo esc_attr($cart_item_key); ?>">
                <img src="<?php echo esc_url($product_img); ?>" alt="<?php echo esc_attr($product_name); ?>" class="drawer-item-thumb">
                <div class="drawer-item-details">
                    <a href="<?php echo esc_url($product_url); ?>" class="drawer-item-name">
                        <?php echo esc_html($product_name); ?>
                    </a>
                    <div class="drawer-item-price"><?php echo wp_kses_post($product_price); ?></div>
                    <div class="drawer-qty-controls">
                        <button type="button" class="qty-btn qty-minus" data-key="<?php echo esc_attr($cart_item_key); ?>" data-qty="<?php echo esc_attr($cart_item['quantity'] - 1); ?>">−</button>
                        <span class="qty-display"><?php echo esc_html($cart_item['quantity']); ?></span>
                        <button type="button" class="qty-btn qty-plus" data-key="<?php echo esc_attr($cart_item_key); ?>" data-qty="<?php echo esc_attr($cart_item['quantity'] + 1); ?>">+</button>
                        <button type="button" class="drawer-remove-item" data-key="<?php echo esc_attr($cart_item_key); ?>" title="Հեռացնել">✕</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
}

