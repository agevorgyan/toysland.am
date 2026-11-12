<?php
/**
 * Checkout Payment Section Override for ToysLand
 *
 * @package ToysLand
 */

defined('ABSPATH') || exit;

if (!wp_doing_ajax()) {
    do_action('woocommerce_review_order_before_payment');
}
?>

<div id="payment" class="woocommerce-checkout-payment">
    <?php if (WC()->cart && WC()->cart->needs_payment()) : ?>
        <ul class="wc_payment_methods payment_methods methods" aria-label="<?php esc_attr_e('Payment methods', 'woocommerce'); ?>">
            <?php
            if (!empty($available_gateways)) {
                foreach ($available_gateways as $gateway) {
                    wc_get_template('checkout/payment-method.php', array('gateway' => $gateway));
                }
            } else {
                echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">';
                echo 'Խնդրում ենք լրացնել Ձեր տվյալները վերևում՝ հասանելի վճարման եղանակները տեսնելու համար:';
                echo '</li>';
            }
            ?>
        </ul>
    <?php endif; ?>

    <div class="form-row place-order">
        <noscript>
            <p style="color:#ef4444;font-size:13px;margin-bottom:10px;">
                Ձեր բրաուզերում JavaScript-ն անջատված է: Խնդրում ենք սեղմել «Թարմացնել գումարը» կոճակը պատվերը հաստատելուց առաջ:
            </p>
            <button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="Թարմացնել գումարը">Թարմացնել գումարը</button>
        </noscript>

        <?php wc_get_template('checkout/terms.php'); ?>

        <?php do_action('woocommerce_review_order_before_submit'); ?>

        <button type="submit" class="button alt cart-checkout-btn checkout-submit-btn" name="woocommerce_checkout_place_order" id="place_order" value="Հաստատել պատվերը" data-value="Հաստատել պատվերը">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <span>Հաստատել պատվերը</span>
        </button>

        <?php do_action('woocommerce_review_order_after_submit'); ?>

        <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
    </div>
</div>

<?php
if (!wp_doing_ajax()) {
    do_action('woocommerce_review_order_after_payment');
}
