<?php
/**
 * Mini Cart Drawer Template Part
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

$cart = WC()->cart;
$cart_count = $cart ? $cart->get_cart_contents_count() : 0;
$cart_subtotal = $cart ? $cart->get_cart_subtotal() : '0 ֏';
?>
<div class="toysland-drawer-backdrop" aria-hidden="true">
    <div class="toysland-cart-drawer" role="dialog" aria-label="Գնումների զամբյուղ">
        <!-- Drawer Header -->
        <div class="drawer-header">
            <h3 class="drawer-title">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <span>Ձեր զամբյուղը</span>
                <span class="action-badge js-cart-count" style="position:static;"><?php echo esc_html($cart_count); ?></span>
            </h3>
            <button type="button" class="drawer-close-btn" aria-label="Փակել զամբյուղը">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <!-- Drawer Content Body (Refreshed via AJAX) -->
        <div class="drawer-cart-body" style="flex:1;overflow-y:auto;display:flex;flex-direction:column;">
            <?php toysland_render_mini_cart_items(); ?>
        </div>

        <!-- Drawer Footer (Subtotal + Checkout) -->
        <div class="drawer-footer" <?php if ($cart_count === 0) echo 'style="display:none;"'; ?>>
            <div class="drawer-subtotal-row">
                <span class="subtotal-label">Ընդամենը՝</span>
                <span class="subtotal-amount js-cart-subtotal"><?php echo wp_kses_post($cart_subtotal); ?></span>
            </div>
            <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="drawer-checkout-btn">
                <span>Ձևակերպել պատվերը</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="drawer-view-cart-link">
                Դիտել ամբողջական զամբյուղը
            </a>
        </div>
    </div>
</div>

