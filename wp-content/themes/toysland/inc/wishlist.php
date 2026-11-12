<?php
/**
 * ToysLand Wishlist Handler
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_ajax_toysland_get_wishlist_items', 'toysland_get_wishlist_items_callback');
add_action('wp_ajax_nopriv_toysland_get_wishlist_items', 'toysland_get_wishlist_items_callback');

function toysland_get_wishlist_items_callback() {
    $ids = isset($_POST['ids']) ? array_map('absint', (array)$_POST['ids']) : [];

    if (empty($ids)) {
        wp_send_json_success(['html' => '<div class="drawer-empty-cart"><p>Ընտրյալների ցանկը դատարկ է:</p></div>', 'count' => 0]);
    }

    $products = [];
    foreach ($ids as $id) {
        $product = wc_get_product($id);
        if ($product && $product->is_visible()) {
            $products[] = [
                'id'         => $product->get_id(),
                'title'      => $product->get_name(),
                'url'        => $product->get_permalink(),
                'price'      => toysland_price($product->get_price()),
                'image'      => toysland_get_product_image_url($product),
            ];
        }
    }

    wp_send_json_success([
        'products' => $products,
        'count'    => count($products),
    ]);
}

