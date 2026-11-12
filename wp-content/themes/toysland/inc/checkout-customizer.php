<?php
/**
 * ToysLand Checkout Optimization for Armenian Market
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customize Checkout Fields for Armenian Customers
 */
add_filter('woocommerce_checkout_fields', 'toysland_custom_checkout_fields');
function toysland_custom_checkout_fields($fields) {
    // Simplify Billing fields
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_last_name']);

    // Customize First Name (Full Name)
    $fields['billing']['billing_first_name']['label'] = 'Անուն, Ազգանուն';
    $fields['billing']['billing_first_name']['placeholder'] = 'Օրինակ՝ Աննա Պողոսյան';
    $fields['billing']['billing_first_name']['class'] = ['form-group'];

    // Phone Number with Armenian placeholder
    $fields['billing']['billing_phone']['label'] = 'Հեռախոսահամար';
    $fields['billing']['billing_phone']['placeholder'] = '+374 91 000000';
    $fields['billing']['billing_phone']['required'] = true;
    $fields['billing']['billing_phone']['class'] = ['form-group'];

    // Email (Optional for phone orders)
    $fields['billing']['billing_email']['label'] = 'Էլ. հասցե (ըստ ցանկության)';
    $fields['billing']['billing_email']['required'] = false;
    $fields['billing']['billing_email']['placeholder'] = 'name@example.com';
    $fields['billing']['billing_email']['class'] = ['form-group'];

    // Delivery Address
    $fields['billing']['billing_address_1']['label'] = 'Առաքման հասցե (Փողոց, շենք, բնակարան)';
    $fields['billing']['billing_address_1']['placeholder'] = 'Օրինակ՝ Թումանյան փողոց 12, բն. 5';
    $fields['billing']['billing_address_1']['required'] = true;
    $fields['billing']['billing_address_1']['class'] = ['form-group'];

    // City / Region Selection
    $fields['billing']['billing_city']['label'] = 'Քաղաք / Համայնք';
    $fields['billing']['billing_city']['type'] = 'select';
    $fields['billing']['billing_city']['options'] = [
        'Yerevan'     => 'Երևան',
        'Abovyan'     => 'Աբովյան',
        'Gyumri'      => 'Գյումրի',
        'Vanadzor'    => 'Վանաձոր',
        'Vagharshapat'=> 'Էջմիածին',
        'Hrazdan'     => 'Հրազդան',
        'Ashtarak'    => 'Աշտարակ',
        'Armavir'     => 'Արմավիր',
        'Ararat'      => 'Արարատ / Մասիս',
        'Other'       => 'Այլ բնակավայր (ՀՀ Մարզեր)',
    ];
    $fields['billing']['billing_city']['default'] = 'Yerevan';
    $fields['billing']['billing_city']['class'] = ['form-group'];

    // Order Notes
    $fields['order']['order_comments']['label'] = 'Նշումներ առաքչի համար';
    $fields['order']['order_comments']['placeholder'] = 'Դոմոֆոնի կոդ, հարկ, առաքման ցանկալի ժամ...';
    $fields['order']['order_comments']['class'] = ['form-group'];

    return $fields;
}

/**
 * Validate Armenian phone number format
 */
add_action('woocommerce_checkout_process', 'toysland_validate_checkout_phone');
function toysland_validate_checkout_phone() {
    if (isset($_POST['billing_phone'])) {
        $phone = preg_replace('/[^0-9]/', '', sanitize_text_field(wp_unslash($_POST['billing_phone'])));
        // Armenian numbers typically have 8 digits (excluding prefix 374/0) or total length 9-11
        if (strlen($phone) < 8 || strlen($phone) > 13) {
            wc_add_notice('Խնդրում ենք մուտքագրել վավեր հեռախոսահամար (օրինակ՝ +374 91 123456 կամ 091 123456):', 'error');
        }
    }
}

