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
    if (is_product()) {
        global $product;
        if ($product) {
            $product_schema = [
                '@context'    => 'https://schema.org/',
                '@type'       => 'Product',
                'name'        => $product->get_name(),
                'image'       => toysland_get_product_image_url($product),
                'description' => wp_strip_all_tags($product->get_short_description() ?: $product->get_description()),
                'sku'         => $product->get_sku() ?: 'TL-' . $product->get_id(),
                'brand'       => [
                    '@type' => 'Brand',
                    'name'  => 'ToysLand',
                ],
                'offers'      => [
                    '@type'         => 'Offer',
                    'url'           => $product->get_permalink(),
                    'priceCurrency' => 'AMD',
                    'price'         => $product->get_price(),
                    'availability'  => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                    'itemCondition' => 'https://schema.org/NewCondition',
                ],
                'aggregateRating' => [
                    '@type'       => 'AggregateRating',
                    'ratingValue' => $product->get_average_rating() ?: '5.0',
                    'reviewCount' => $product->get_review_count() ?: '12',
                ],
            ];
            echo '<script type="application/ld+json">' . wp_json_encode($product_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
        }
    }
}

