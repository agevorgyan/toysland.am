<?php
/**
 * WooCommerce Checkout Form Template Override for ToysLand
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

// If checkout registration is disabled and not logged in
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo '<div class="woocommerce-notice woocommerce-notice--info woocommerce-info">';
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    echo '</div>';
    return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout toysland-checkout-form" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

    <div class="checkout-main-grid">
        
        <!-- Left Column: Customer Delivery Details & Payment -->
        <div class="checkout-details-column">
            
            <!-- Card 1: Contact & Delivery Info -->
            <div class="checkout-card customer-info-card">
                <div class="checkout-card-header">
                    <div class="card-header-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <div class="card-header-text">
                        <h2 class="card-header-title">Առաքման և կոնտակտային տվյալներ</h2>
                        <p class="card-header-subtitle">Լրացրեք տվյալները՝ պատվերը Ձեզ հասցնելու համար</p>
                    </div>
                </div>

                <div class="checkout-fields-container woocommerce-billing-fields__field-wrapper">
                    <?php
                    $fields = $checkout->get_checkout_fields('billing');
                    foreach ($fields as $key => $field) {
                        woocommerce_form_field($key, $field, $checkout->get_value($key));
                    }
                    ?>
                </div>

                <!-- Order Notes (Note) -->
                <div class="checkout-notes-container">
                    <?php
                    $order_fields = $checkout->get_checkout_fields('order');
                    if (!empty($order_fields['order_comments'])) {
                        woocommerce_form_field('order_comments', $order_fields['order_comments'], $checkout->get_value('order_comments'));
                    }
                    ?>
                </div>
            </div>

            <!-- Card 2: Payment Methods Selection -->
            <div class="checkout-card payment-selection-card">
                <div class="checkout-card-header">
                    <div class="card-header-icon"><i class="fa-solid fa-credit-card"></i></div>
                    <div class="card-header-text">
                        <h2 class="card-header-title">Վճարման եղանակ</h2>
                        <p class="card-header-subtitle">Ընտրեք Ձեզ հարմար վճարման տարբերակը</p>
                    </div>
                </div>

                <div id="payment_section" class="checkout-payment-box">
                    <?php woocommerce_checkout_payment(); ?>
                </div>
            </div>

        </div>

        <!-- Right Column: Order Review Summary (Sticky) -->
        <div class="checkout-summary-column">
            <div class="checkout-card checkout-summary-card">
                
                <div class="checkout-summary-header">
                    <div class="card-header-icon"><i class="fa-solid fa-bag-shopping"></i></div>
                    <div class="card-header-text">
                        <h2 class="card-header-title">
                            Ձեր պատվերը
                            <span class="summary-badge"><?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?> ապրանք</span>
                        </h2>
                    </div>
                </div>

                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php woocommerce_order_review(); ?>
                </div>

                <!-- Trust and Guarantees Box -->
                <div class="checkout-trust-box">
                    <div class="checkout-trust-item">
                        <div class="trust-icon"><i class="fa-solid fa-truck-fast"></i></div>
                        <div class="trust-text">
                            <strong>Արագ առաքում Երևանում</strong>
                            <span>1 աշխատանքային օրվա ընթացքում</span>
                        </div>
                    </div>
                    <div class="checkout-trust-item">
                        <div class="trust-icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <div class="trust-text">
                            <strong>100% Օրիգինալ և անվտանգ</strong>
                            <span>Սերտիֆիկացված էկոլոգիապես մաքուր խաղալիքներ</span>
                        </div>
                    </div>
                    <div class="checkout-trust-item">
                        <div class="trust-icon"><i class="fa-solid fa-lock"></i></div>
                        <div class="trust-text">
                            <strong>Անվտանգ գործարք</strong>
                            <span>256-bit SSL պաշտպանված համակարգ</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</form>
