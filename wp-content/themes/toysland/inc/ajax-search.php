<?php
/**
 * ToysLand AJAX Live Search Handler
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_ajax_toysland_ajax_search', 'toysland_ajax_search_callback');
add_action('wp_ajax_nopriv_toysland_ajax_search', 'toysland_ajax_search_callback');

function toysland_ajax_search_callback() {
    $keyword = isset($_GET['keyword']) ? sanitize_text_field(wp_unslash($_GET['keyword'])) : '';
    $category = isset($_GET['category']) ? sanitize_text_field(wp_unslash($_GET['category'])) : '';

    if (empty($keyword) || mb_strlen($keyword, 'UTF-8') < 2) {
        wp_send_json_success(['results' => [], 'count' => 0]);
    }

    $args = [
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 8,
        's'              => $keyword,
    ];

    if (!empty($category)) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $category,
            ],
        ];
    }

    $query = new WP_Query($args);
    $results = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $product = wc_get_product(get_the_ID());
            if (!$product) continue;

            $cats = wc_get_product_category_list($product->get_id(), ', ');

            $results[] = [
                'id'         => $product->get_id(),
                'title'      => $product->get_name(),
                'url'        => $product->get_permalink(),
                'price_html' => $product->get_price_html(),
                'price'      => toysland_price($product->get_price()),
                'image'      => toysland_get_product_image_url($product),
                'category'   => strip_tags($cats),
            ];
        }
        wp_reset_postdata();
    }

    wp_send_json_success([
        'results' => $results,
        'count'   => count($results),
        'view_all_url' => add_query_arg('s', urlencode($keyword), wc_get_page_permalink('shop')),
    ]);
}

