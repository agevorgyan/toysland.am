<?php
/**
 * ToysLand My Account Customizer & Localization
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Filter WooCommerce Account Navigation Menu Items
 * - Remove unused endpoints (e.g. downloads)
 * - Translate labels into clean Armenian
 */
add_filter('woocommerce_account_menu_items', 'toysland_custom_account_menu_items', 99);
function toysland_custom_account_menu_items($items) {
    unset($items['downloads']);

    return [
        'dashboard'       => 'Գլխավոր',
        'orders'          => 'Իմ պատվերները',
        'edit-address'    => 'Առաքման հասցե',
        'edit-account'    => 'Հաշվի տվյալներ',
        'customer-logout' => 'Դուրս գալ',
    ];
}

/**
 * Custom validation for registration password confirmation
 */
add_action('woocommerce_register_post', 'toysland_validate_registration_fields', 10, 3);
function toysland_validate_registration_fields($username, $email, $errors) {
    if (isset($_POST['password_2'])) {
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $password_2 = $_POST['password_2'];

        if (empty($password_2)) {
            $errors->add('password_2_error', 'Խնդրում ենք կրկնել գաղտնաբառը:');
        } elseif ($password !== $password_2) {
            $errors->add('password_mismatch_error', 'Մուտքագրված գաղտնաբառերը չեն համընկնում:');
        }
    }
}

/**
 * Redirect user to My Account after login/registration
 */
add_filter('woocommerce_login_redirect', 'toysland_account_redirect', 10, 2);
add_filter('woocommerce_registration_redirect', 'toysland_account_redirect', 10, 1);
function toysland_account_redirect($redirect, $user = null) {
    return wc_get_page_permalink('myaccount');
}

/**
 * Filter order status names to Armenian
 */
add_filter('wc_order_statuses', 'toysland_armenian_order_statuses');
function toysland_armenian_order_statuses($statuses) {
    $armenian_map = [
        'wc-pending'    => 'Սպասում է վճարման',
        'wc-processing' => 'Մշակվում է',
        'wc-on-hold'    => 'Սպասման մեջ',
        'wc-completed'  => 'Կատարված',
        'wc-cancelled'  => 'Չեղարկված',
        'wc-refunded'   => 'Վերադարձված',
        'wc-failed'     => 'Չհաջողված',
    ];

    foreach ($armenian_map as $key => $label) {
        if (isset($statuses[$key])) {
            $statuses[$key] = $label;
        }
    }

    return $statuses;
}

