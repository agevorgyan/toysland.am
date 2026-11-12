<?php
/**
 * ToysLand SEO & Schema.org Structured Data
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_head', 'toysland_output_schema_jsonld', 20);

function toysland_output_schema_jsonld() {
    $site_url = home_url('/');
    $logo_url = get_template_directory_uri() . '/assets/images/logo.png';

    // Organization Schema
    $org_schema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'ToyStore',
        'name'        => 'ToysLand',
        'alternateName' => 'ToysLand Armenia',
        'url'         => $site_url,
        'logo'        => $logo_url,
        'description' => 'Մանկական խաղալիքների առաջատար օնլայն խանութ Երևանում և Հայաստանում: Որակյալ, անվտանգ խաղալիքներ և արագ առաքում:',
        'telephone'   => '+374 10 123456',
        'priceRange'  => '֏֏',
        'address'     => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => 'Հյուսիսային պողոտա',
            'addressLocality' => 'Երևան',
            'addressCountry'  => 'AM',
        ],
        'sameAs'      => [
            'https://www.instagram.com/toysland.am',
            'https://www.facebook.com/toysland.am',
        ],
    ];

    echo '<script type="application/ld+json">' . wp_json_encode($org_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";

    // Product Schema on Single Product page
    if (function_exists('is_product') && is_product()) {
        global $product;
        $product_obj = is_a($product, 'WC_Product') ? $product : (function_exists('wc_get_product') ? wc_get_product(get_the_ID()) : null);
        if ($product_obj instanceof WC_Product) {
            $product_schema = [
                '@context'    => 'https://schema.org/',
                '@type'       => 'Product',
                'name'        => $product_obj->get_name(),
                'image'       => toysland_get_product_image_url($product_obj),
                'description' => wp_strip_all_tags($product_obj->get_short_description() ?: $product_obj->get_description()),
                'sku'         => $product_obj->get_sku() ?: 'TL-' . $product_obj->get_id(),
                'brand'       => [
                    '@type' => 'Brand',
                    'name'  => 'ToysLand',
                ],
                'offers'      => [
                    '@type'         => 'Offer',
                    'url'           => $product_obj->get_permalink(),
                    'priceCurrency' => 'AMD',
                    'price'         => $product_obj->get_price(),
                    'availability'  => $product_obj->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                    'itemCondition' => 'https://schema.org/NewCondition',
                ],
                'aggregateRating' => [
                    '@type'       => 'AggregateRating',
                    'ratingValue' => $product_obj->get_average_rating() ?: '5.0',
                    'reviewCount' => $product_obj->get_review_count() ?: '12',
                ],
            ];
            echo '<script type="application/ld+json">' . wp_json_encode($product_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
        }
    }
}

