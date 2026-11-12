<?php
/**
 * Review order table override for ToysLand
 *
 * @package ToysLand
 */

defined('ABSPATH') || exit;
?>

<table class="shop_table woocommerce-checkout-review-order-table">
    <thead>
        <tr>
            <th class="product-name">Ապրանք</th>
            <th class="product-total">Գումար</th>
        </tr>
    </thead>
    <tbody>
        <?php
        do_action('woocommerce_review_order_before_cart_contents');

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
                $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                $product_img  = toysland_get_product_image_url($_product);
                $product_url  = $_product->get_permalink($cart_item);
                $terms        = get_the_terms($_product->get_id(), 'product_cat');
                $primary_cat  = (!empty($terms) && !is_wp_error($terms)) ? $terms[0]->name : '';
                ?>
                <tr class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                    <td class="product-name">
                        <div class="checkout-review-product">
                            <div class="checkout-thumb-wrap">
                                <img src="<?php echo esc_url($product_img); ?>" alt="<?php echo esc_attr($product_name); ?>" class="checkout-product-thumb">
                                <span class="checkout-qty-badge"><?php echo esc_html($cart_item['quantity']); ?></span>
                            </div>
                            <div class="checkout-product-details">
                                <?php if ($primary_cat) : ?>
                                    <span class="checkout-product-cat"><?php echo esc_html($primary_cat); ?></span>
                                <?php endif; ?>
                                <span class="checkout-product-title"><?php echo esc_html($product_name); ?></span>
                            </div>
                        </div>
                    </td>
                    <td class="product-total">
                        <span class="checkout-item-total">
                            <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
                        </span>
                    </td>
                </tr>
                <?php
            }
        }

        do_action('woocommerce_review_order_after_cart_contents');
        ?>
    </tbody>
    <tfoot>
        <!-- Subtotal -->
        <tr class="cart-subtotal">
            <th>Ապրանքների գումար</th>
            <td><?php wc_cart_totals_subtotal_html(); ?></td>
        </tr>

        <!-- Shipping -->
        <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
            <?php
            $subtotal_raw = floatval(WC()->cart->get_subtotal());
            $is_free = ($subtotal_raw >= 15000);
            ?>
            <tr class="woocommerce-shipping-totals shipping">
                <th>
                    Առաքում
                    <span class="checkout-shipping-note">Երևանում 1 աշխ. օր</span>
                </th>
                <td data-title="Առաքում">
                    <?php if ($is_free) : ?>
                        <span class="shipping-free-pill">Անվճար</span>
                    <?php else : ?>
                        <span class="shipping-rate-amount"><?php echo esc_html(toysland_price(1000)); ?></span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endif; ?>

        <!-- Coupons -->
        <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
            <tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
                <th>Կտրոն: <strong><?php echo esc_html($code); ?></strong></th>
                <td class="coupon-discount-val">-<?php wc_cart_totals_coupon_html($coupon); ?></td>
            </tr>
        <?php endforeach; ?>

        <!-- Fees -->
        <?php foreach (WC()->cart->get_fees() as $fee) : ?>
            <tr class="fee">
                <th><?php echo esc_html($fee->name); ?></th>
                <td><?php wc_cart_totals_fee_html($fee); ?></td>
            </tr>
        <?php endforeach; ?>

        <?php do_action('woocommerce_review_order_before_order_total'); ?>

        <!-- Order Total -->
        <tr class="order-total">
            <th>Ընդհանուր վճարման</th>
            <td>
                <span class="checkout-grand-total">
                    <?php wc_cart_totals_order_total_html(); ?>
                </span>
            </td>
        </tr>

        <?php do_action('woocommerce_review_order_after_order_total'); ?>
    </tfoot>
</table>
