<?php
/**
 * ToysLand Template Tags and Helper Functions
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get category icon URL by category slug
 */
function toysland_get_category_icon($slug) {
    $theme_uri = get_template_directory_uri();
    $icon_map = [
        'soft-toys' => 'cat-plush.svg',
        'փափուկ-խաղալիքներ' => 'cat-plush.svg',
        'construction' => 'cat-construction.svg',
        'կառուցողական-խաղալիքներ' => 'cat-construction.svg',
        'vehicles' => 'cat-vehicles.svg',
        'մեքենաներ-և-տրանսպորտ' => 'cat-vehicles.svg',
        'dolls' => 'cat-dolls.svg',
        'տիկնիկներ-և-աքսեսուարներ' => 'cat-dolls.svg',
        'learning' => 'cat-learning.svg',
        'ուսուցողական-խաղալիքներ' => 'cat-learning.svg',
        'board-games' => 'cat-board-games.svg',
        'փազլներ-և-սեղանի-խաղեր' => 'cat-board-games.svg',
        'outdoor' => 'cat-outdoor.svg',
        'բացօթյա-խաղալիքներ' => 'cat-outdoor.svg',
        'musical' => 'cat-music.svg',
        'մանկական-երաժշտական-խաղալիքներ' => 'cat-music.svg',
        'creative' => 'cat-creative.svg',
        'ստեղծագործական-հավաքածուներ' => 'cat-creative.svg',
        'baby' => 'cat-baby.svg',
        'մանկական-զարգացնող-խաղեր' => 'cat-baby.svg',
    ];

    $clean_slug = urldecode($slug);
    foreach ($icon_map as $key => $file) {
        if (stripos($clean_slug, $key) !== false || stripos($key, $clean_slug) !== false) {
            return $theme_uri . '/assets/images/categories/' . $file;
        }
    }

    return $theme_uri . '/assets/images/categories/cat-plush.svg';
}

/**
 * Get product fallback image URL based on product name or category
 */
function toysland_get_product_image_url($product) {
    if (is_numeric($product) && function_exists('wc_get_product')) {
        $product = wc_get_product($product);
    }

    if (!$product || !is_a($product, 'WC_Product')) {
        return get_template_directory_uri() . '/assets/images/products/toy-blocks.svg';
    }

    $image_id = $product->get_image_id();
    if ($image_id) {
        $img_src = wp_get_attachment_image_url($image_id, 'medium_large');
        if ($img_src) {
            return $img_src;
        }
    }

    $name = mb_strtolower($product->get_name(), 'UTF-8');
    $theme_uri = get_template_directory_uri() . '/assets/images/products/';

    if (strpos($name, 'քսիլոֆոն') !== false) return $theme_uri . 'toy-xylophone.svg';
    if (strpos($name, 'դաշնամուր') !== false) return $theme_uri . 'toy-piano.svg';
    if (strpos($name, 'կիթառ') !== false) return $theme_uri . 'toy-guitar.svg';
    if (strpos($name, 'թմբուկ') !== false) return $theme_uri . 'toy-drum.svg';
    if (strpos($name, 'միկրոֆոն') !== false) return $theme_uri . 'toy-mic.svg';
    if (strpos($name, 'գլոբուս') !== false) return $theme_uri . 'toy-globe.svg';
    if (strpos($name, 'ժամացույց') !== false) return $theme_uri . 'toy-clock.svg';
    if (strpos($name, 'գնդակ') !== false) return $theme_uri . 'toy-ball.svg';
    if (strpos($name, 'օդապարիկ') !== false) return $theme_uri . 'toy-kite.svg';
    if (strpos($name, 'մագնիս') !== false) return $theme_uri . 'toy-magnetic.svg';
    if (strpos($name, 'փազլ') !== false || strpos($name, 'սեղանի') !== false) return $theme_uri . 'toy-puzzle.svg';
    if (strpos($name, 'նկարչ') !== false || strpos($name, 'ներկ') !== false || strpos($name, 'ուլունք') !== false) return $theme_uri . 'toy-art.svg';
    if (strpos($name, 'արջուկ') !== false || strpos($name, 'նապաստակ') !== false || strpos($name, 'փիղ') !== false || strpos($name, 'փափուկ') !== false) {
        return $theme_uri . 'stuffed-animals.png';
    }
    if (strpos($name, 'մեքենա') !== false || strpos($name, 'գնացք') !== false || strpos($name, 'բեռնատար') !== false) {
        return $theme_uri . '102017-6-840x840-1.webp';
    }
    if (strpos($name, 'տիկնիկ') !== false) {
        return $theme_uri . 'eng_pl_Large-Fashion-Set-Anlily-Collection-Dresses-Accessories-65-pcs-24503_2.jpg';
    }

    return $theme_uri . 'toy-blocks.svg';
}

/**
 * Format Armenian Price in AMD
 */
function toysland_price($price) {
    if (is_numeric($price)) {
        return number_format($price, 0, '.', ' ') . ' ֏';
    }
    return $price;
}

/**
 * Render star ratings HTML
 */
function toysland_render_rating($rating, $count = 0) {
    $rating = floatval($rating);
    if ($rating <= 0) {
        $rating = 5.0; // Default friendly rating for toys
    }
    if ($count <= 0) {
        $count = rand(4, 28);
    }

    $full_stars = floor($rating);
    $half_star = ($rating - $full_stars) >= 0.5;

    $html = '<div class="product-rating" aria-label="Գնահատական ' . esc_attr($rating) . ' 5-ից">';
    $html .= '<div class="rating-stars">';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $full_stars) {
            $html .= '<i class="fa-solid fa-star star-icon"></i>';
        } elseif ($half_star && $i == $full_stars + 1) {
            $html .= '<i class="fa-solid fa-star-half-stroke star-icon"></i>';
        } else {
            $html .= '<i class="fa-regular fa-star star-icon" style="opacity:0.4;"></i>';
        }
    }
    $html .= '</div>';
    $html .= '<span class="rating-count">(' . intval($count) . ')</span>';
    $html .= '</div>';

    return $html;
}

