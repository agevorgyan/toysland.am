<?php
/**
 * ToysLand Theme Functions and Definitions
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

define('TOYSLAND_VERSION', '1.0.0');
define('TOYSLAND_DIR', get_template_directory());
define('TOYSLAND_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function toysland_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    // WooCommerce Support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Navigation Menus
    register_nav_menus([
        'primary'    => 'Գլխավոր Մենյու (Main Menu)',
        'categories' => 'Կատեգորիաների Մենյու (Categories Mega Menu)',
        'footer_1'   => 'Ֆուտեր 1 (Օգտակար հղումներ)',
        'footer_2'   => 'Ֆուտեր 2 (Հաճախորդներին)',
    ]);

    // Disable emoji bloat for faster performance
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('after_setup_theme', 'toysland_setup');

/**
 * Enqueue Scripts and Styles
 */
function toysland_scripts() {
    // Google Fonts (Nunito + Inter)
    wp_enqueue_style(
        'toysland-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Nunito:wght@600;700;800;900&display=swap',
        [],
        null
    );

    // Font Awesome 6 Icons
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        [],
        '6.5.1'
    );

    // Main Stylesheet
    wp_enqueue_style('toysland-style', get_stylesheet_uri(), ['toysland-fonts', 'font-awesome'], TOYSLAND_VERSION);

    // Main Interactive JS
    wp_enqueue_script(
        'toysland-app',
        TOYSLAND_URI . '/assets/js/toysland.js',
        ['jquery'],
        TOYSLAND_VERSION,
        true
    );

    // Localize Script with AJAX URL and Nonces
    wp_localize_script('toysland-app', 'toyslandData', [
        'ajaxUrl'     => admin_url('admin-ajax.php'),
        'homeUrl'     => home_url('/'),
        'currency'    => '֏',
        'freeShipMin' => 15000,
        'i18n'        => [
            'addedToCart'    => 'Ապրանքն ավելացվեց զամբյուղ!',
            'errorAdding'    => 'Տեղի ունեցավ սխալ:',
            'searching'      => 'Փնտրում ենք...',
            'noResults'      => 'Արդյունքներ չեն գտնվել:',
            'viewAllResults' => 'Դիտել բոլոր արդյունքները →',
        ],
    ]);
}
add_action('wp_enqueue_scripts', 'toysland_scripts');

/**
 * Include Modular Features
 */
require_once TOYSLAND_DIR . '/inc/template-tags.php';
require_once TOYSLAND_DIR . '/inc/ajax-search.php';
require_once TOYSLAND_DIR . '/inc/ajax-cart.php';
require_once TOYSLAND_DIR . '/inc/wishlist.php';
require_once TOYSLAND_DIR . '/inc/checkout-customizer.php';
require_once TOYSLAND_DIR . '/inc/myaccount-customizer.php';
require_once TOYSLAND_DIR . '/inc/seo-schema.php';

/**
 * Set Armenian Currency Symbol in WooCommerce
 */
add_filter('woocommerce_currency_symbol', 'toysland_custom_currency_symbol', 10, 2);
function toysland_custom_currency_symbol($symbol, $currency) {
    if ($currency === 'AMD') {
        return '֏';
    }
    return $symbol;
}

/**
 * Filter products count per page in shop
 */
add_filter('loop_shop_per_page', function($cols) {
    return 16;
}, 20);

