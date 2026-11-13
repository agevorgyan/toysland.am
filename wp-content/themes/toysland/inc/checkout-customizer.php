<?php
/**
 * ToysLand Checkout Optimization for Armenian Market
 *
 * Configures minimal high-converting fields:
 * Name, Email, Phone (with validation), Address, Postcode, Note
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customize Checkout Fields: Keep only Name, Email, Phone, Address, Post code, Note
 */
add_filter('woocommerce_checkout_fields', 'toysland_custom_checkout_fields', 999);
function toysland_custom_checkout_fields($fields) {
    // 1. Remove unwanted Billing fields
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_state']);

    // 2. Remove all separate Shipping fields (use single delivery address)
    unset($fields['shipping']);

    // 3. Name (Full name)
    $fields['billing']['billing_first_name']['label']       = 'Անուն, Ազգանուն';
    $fields['billing']['billing_first_name']['placeholder'] = 'Օրինակ՝ Աննա Պողոսյան';
    $fields['billing']['billing_first_name']['required']    = true;
    $fields['billing']['billing_first_name']['priority']    = 10;
    $fields['billing']['billing_first_name']['class']       = ['form-row-wide', 'form-group-name'];

    // 4. Email
    $fields['billing']['billing_email']['label']            = 'Էլ. հասցե (Email)';
    $fields['billing']['billing_email']['placeholder']      = 'name@example.com';
    $fields['billing']['billing_email']['required']         = true;
    $fields['billing']['billing_email']['priority']         = 20;
    $fields['billing']['billing_email']['class']            = ['form-row-wide', 'form-group-email'];

    // 5. Phone Number (Armenian)
    $fields['billing']['billing_phone']['label']            = 'Հեռախոսահամար';
    $fields['billing']['billing_phone']['placeholder']      = '+374 91 123456';
    $fields['billing']['billing_phone']['required']         = true;
    $fields['billing']['billing_phone']['priority']         = 30;
    $fields['billing']['billing_phone']['class']            = ['form-row-wide', 'form-group-phone'];

    // 6. Address
    $fields['billing']['billing_address_1']['label']        = 'Առաքման հասցե';
    $fields['billing']['billing_address_1']['placeholder']  = 'Օրինակ՝ Երևան, Թումանյան փողոց 12, բն. 5';
    $fields['billing']['billing_address_1']['required']     = true;
    $fields['billing']['billing_address_1']['priority']     = 40;
    $fields['billing']['billing_address_1']['class']        = ['form-row-wide', 'form-group-address'];

    // 7. Postcode (ZIP)
    $fields['billing']['billing_postcode']['label']         = 'Փոստային դասիչ (Post code)';
    $fields['billing']['billing_postcode']['placeholder']   = 'Օրինակ՝ 0010 (ըստ ցանկության)';
    $fields['billing']['billing_postcode']['required']      = false;
    $fields['billing']['billing_postcode']['priority']      = 50;
    $fields['billing']['billing_postcode']['class']         = ['form-row-wide', 'form-group-postcode'];

    // 8. Order Notes
    if (isset($fields['order']['order_comments'])) {
        $fields['order']['order_comments']['label']       = 'Նշումներ առաքչի համար (Note)';
        $fields['order']['order_comments']['placeholder'] = 'Դոմոֆոնի կոդ, հարկ, առաքման ցանկալի ժամ կամ այլ նշումներ...';
        $fields['order']['order_comments']['required']    = false;
        $fields['order']['order_comments']['class']       = ['form-row-wide', 'form-group-notes'];
    }

    return $fields;
}

/**
 * Remove required flag for removed address fields in WooCommerce validation
 */
add_filter('woocommerce_default_address_fields', 'toysland_custom_default_address_fields', 999);
function toysland_custom_default_address_fields($fields) {
    if (isset($fields['city'])) {
        $fields['city']['required'] = false;
    }
    if (isset($fields['state'])) {
        $fields['state']['required'] = false;
    }
    if (isset($fields['country'])) {
        $fields['country']['required'] = false;
    }
    if (isset($fields['last_name'])) {
        $fields['last_name']['required'] = false;
    }
    if (isset($fields['postcode'])) {
        $fields['postcode']['required'] = false;
    }
    return $fields;
}

/**
 * Auto-fill internal default values during checkout validation
 */
add_action('woocommerce_checkout_process', 'toysland_prepare_checkout_defaults', 5);
function toysland_prepare_checkout_defaults() {
    if (empty($_POST['billing_city'])) {
        $_POST['billing_city'] = 'Yerevan';
    }
    if (empty($_POST['billing_country'])) {
        $_POST['billing_country'] = 'AM';
    }
    if (empty($_POST['billing_state'])) {
        $_POST['billing_state'] = 'AM';
    }
    if (empty($_POST['billing_last_name']) && !empty($_POST['billing_first_name'])) {
        $_POST['billing_last_name'] = '.';
    }
}

/**
 * Set default country and city for calculations
 */
add_filter('default_checkout_billing_country', fn() => 'AM');
add_filter('default_checkout_shipping_country', fn() => 'AM');
add_filter('default_checkout_billing_city', fn() => 'Yerevan');
add_filter('default_checkout_shipping_city', fn() => 'Yerevan');

/**
 * Validate Armenian phone number format
 */
add_action('woocommerce_checkout_process', 'toysland_validate_checkout_phone', 10);
function toysland_validate_checkout_phone() {
    if (empty($_POST['billing_phone'])) {
        wc_add_notice('Խնդրում ենք մուտքագրել հեռախոսահամարը:', 'error');
        return;
    }

    $phone_raw = sanitize_text_field(wp_unslash($_POST['billing_phone']));
    $phone = preg_replace('/[^0-9]/', '', $phone_raw);

    $is_valid = false;
    // 374XXXXXXXX (11 digits)
    if (strpos($phone, '374') === 0 && strlen($phone) === 11) {
        $is_valid = true;
    }
    // 0XXXXXXXX (9 digits)
    elseif (strpos($phone, '0') === 0 && strlen($phone) === 9) {
        $is_valid = true;
    }
    // XXXXXXXX (8 digits)
    elseif (strlen($phone) === 8) {
        $is_valid = true;
    }

    if (!$is_valid) {
        wc_add_notice('Խնդրում ենք մուտքագրել վավեր հայկական հեռախոսահամար (օրինակ՝ +374 91 123456 կամ 091 123456):', 'error');
    } else {
        // Format nicely into +374 XX XXXXXX
        if (strpos($phone, '374') === 0) {
            $local = substr($phone, 3);
        } elseif (strpos($phone, '0') === 0) {
            $local = substr($phone, 1);
        } else {
            $local = $phone;
        }
        $_POST['billing_phone'] = '+374 ' . substr($local, 0, 2) . ' ' . substr($local, 2);
    }
}

/**
 * Armenian Thank You Page Message
 */
add_filter('woocommerce_thankyou_order_received_text', 'toysland_custom_thankyou_text', 10, 2);
function toysland_custom_thankyou_text($text, $order) {
    return 'Շնորհակալություն: Ձեր պատվերը հաջողությամբ ընդունված է: Մեր մասնագետը շուտով կկապնվի Ձեզ հետ՝ առաքման մանրամասները ճշտելու համար:';
}

/**
 * Allow smooth access to Thank You page with order key without email challenge
 */
add_filter('woocommerce_order_email_verification_required', '__return_false');
