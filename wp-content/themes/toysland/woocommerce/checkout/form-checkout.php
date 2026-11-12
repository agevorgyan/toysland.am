<?php
/**
 * WooCommerce Checkout Form Template
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// If checkout registration is disabled and not logged in, the user cannot checkout
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    get_footer();
    return;
}
?>

<div class="toysland-checkout-layout">
    <div class="container">
        <h1 style="font-size:32px;font-weight:900;margin-bottom:28px;">Պատվերի ձևակերպում</h1>

        <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

            <div class="checkout-grid">
                <!-- Left: Delivery Information -->
                <div class="checkout-form-card">
                    <h2 class="checkout-section-title">
                        <span>📍 Առաքման տվյալներ</span>
                    </h2>

                    <?php if ($checkout->get_checkout_fields()) : ?>
                        <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                        <div class="woocommerce-billing-fields__field-wrapper">
                            <?php
                            $fields = $checkout->get_checkout_fields('billing');
                            foreach ($fields as $key => $field) {
                                woocommerce_form_field($key, $field, $checkout->get_value($key));
                            }
                            ?>
                        </div>

                        <div class="woocommerce-shipping-fields">
                            <h3 style="font-size:16px;font-weight:800;margin:20px 0 10px;">Լրացուցիչ նշումներ</h3>
                            <?php
                            $order_fields = $checkout->get_checkout_fields('order');
                            foreach ($order_fields as $key => $field) {
                                woocommerce_form_field($key, $field, $checkout->get_value($key));
                            }
                            ?>
                        </div>

                        <?php do_action('woocommerce_checkout_after_customer_details'); ?>
                    <?php endif; ?>
                </div>

                <!-- Right: Order Review & Payment -->
                <div class="checkout-summary-card">
                    <h2 class="checkout-section-title">
                        <span>🛍️ Ձեր պատվերը</span>
                    </h2>

                    <div id="order_review" class="woocommerce-checkout-review-order">
                        <?php do_action('woocommerce_checkout_order_review'); ?>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<?php
get_footer();

