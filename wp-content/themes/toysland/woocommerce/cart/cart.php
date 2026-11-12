<?php
/**
 * WooCommerce Cart Template
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="toysland-cart-layout" style="padding: 40px 0 70px;">
    <div class="container">
        <h1 style="font-size:32px;font-weight:900;margin-bottom:28px;">Գնումների զամբյուղ</h1>

        <?php if (WC()->cart->is_empty()) : ?>
            <div style="background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--radius-xl);padding:60px 20px;text-align:center;">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 20px;color:var(--color-text-light);"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <h3 style="font-size:22px;margin-bottom:10px;">Ձեր զամբյուղը դատարկ է</h3>
                <p style="color:var(--color-text-muted);margin-bottom:24px;">Բացահայտեք մեր զարմանահրաշ խաղալիքները և ուրախացրեք Ձեր փոքրիկներին:</p>
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-primary-large">
                    Վերադառնալ խանութ
                </a>
            </div>
        <?php else : ?>
            <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                <div style="display:grid;grid-template-columns:1.5fr 1fr;gap:36px;">
                    <!-- Items Card -->
                    <div style="background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--radius-xl);padding:30px;box-shadow:var(--shadow-sm);">
                        <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0" style="width:100%;border-collapse:collapse;">
                            <thead>
                                <tr style="border-bottom:2px solid var(--color-border);text-align:left;font-size:13px;color:var(--color-text-muted);">
                                    <th style="padding-bottom:14px;">Ապրանք</th>
                                    <th style="padding-bottom:14px;">Գին</th>
                                    <th style="padding-bottom:14px;">Քանակ</th>
                                    <th style="padding-bottom:14px;">Ընդհանուր</th>
                                    <th style="padding-bottom:14px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                                    $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                                        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                                        $product_name = $_product->get_name();
                                        $product_img  = toysland_get_product_image_url($_product);
                                        ?>
                                        <tr style="border-bottom:1px solid var(--color-border);">
                                            <td style="padding:16px 0;display:flex;align-items:center;gap:14px;">
                                                <img src="<?php echo esc_url($product_img); ?>" alt="" style="width:60px;height:60px;border-radius:var(--radius-sm);object-fit:cover;background:var(--color-surface-soft);">
                                                <a href="<?php echo esc_url($product_permalink); ?>" style="font-weight:700;color:var(--color-text-main);font-size:14px;">
                                                    <?php echo esc_html($product_name); ?>
                                                </a>
                                            </td>
                                            <td style="padding:16px 0;font-weight:700;color:var(--color-text-main);">
                                                <?php echo WC()->cart->get_product_price($_product); ?>
                                            </td>
                                            <td style="padding:16px 0;">
                                                <?php
                                                if ($_product->is_sold_individually()) {
                                                    $min_quantity = 1;
                                                    $max_quantity = 1;
                                                } else {
                                                    $min_quantity = 0;
                                                    $max_quantity = $_product->get_max_purchase_quantity();
                                                }

                                                $product_quantity = woocommerce_quantity_input([
                                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                                    'input_value'  => $cart_item['quantity'],
                                                    'max_value'    => $max_quantity,
                                                    'min_value'    => $min_quantity,
                                                    'product_name' => $product_name,
                                                ], $_product, false);

                                                echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                                                ?>
                                            </td>
                                            <td style="padding:16px 0;font-weight:900;color:var(--color-primary);">
                                                <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
                                            </td>
                                            <td style="padding:16px 0;text-align:right;">
                                                <?php
                                                echo apply_filters(
                                                    'woocommerce_cart_item_remove_link',
                                                    sprintf(
                                                        '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s" style="color:var(--color-coral);font-weight:bold;font-size:18px;">&times;</a>',
                                                        esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                        esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), $product_name)),
                                                        esc_attr($product_id),
                                                        esc_attr($_product->get_sku())
                                                    ),
                                                    $cart_item_key
                                                );
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:20px;">
                            <button type="submit" class="button" name="update_cart" value="Թարմացնել զամբյուղը" style="background:var(--color-surface-soft);border:1px solid var(--color-border);padding:10px 20px;border-radius:var(--radius-full);font-weight:700;">
                                Թարմացնել զամբյուղը
                            </button>
                            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                        </div>
                    </div>

                    <!-- Cart Totals Card -->
                    <div style="background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--radius-xl);padding:30px;box-shadow:var(--shadow-sm);height:fit-content;">
                        <h3 style="font-size:20px;font-weight:800;margin-bottom:20px;">Պատվերի ամփոփում</h3>
                        <?php woocommerce_cart_totals(); ?>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();

