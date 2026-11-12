<?php
/**
 * Import ToysLand Catalog into WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

$categories_json = file_get_contents(ABSPATH . 'store_categories.json');
$products_json   = file_get_contents(ABSPATH . 'store_products.json');

$categories = json_decode($categories_json, true);
$products   = json_decode($products_json, true);

echo "Importing categories...\n";
$cat_map = [];

foreach ($categories as $cat) {
    if ($cat['slug'] === 'uncategorized') continue;

    $term = get_term_by('name', $cat['name'], 'product_cat');
    if (!$term) {
        $result = wp_insert_term($cat['name'], 'product_cat', [
            'slug' => $cat['slug'],
        ]);
        if (!is_wp_error($result)) {
            $cat_map[$cat['id']] = $result['term_id'];
            echo "Created category: {$cat['name']} (ID: {$result['term_id']})\n";
        }
    } else {
        $cat_map[$cat['id']] = $term->term_id;
        echo "Existing category: {$cat['name']} (ID: {$term->term_id})\n";
    }
}

echo "\nImporting products...\n";
$count = 0;

foreach ($products as $p) {
    // Check if product already exists by title
    $existing = get_page_by_title($p['name'], OBJECT, 'product');
    if ($existing) {
        echo "Product already exists: {$p['name']}\n";
        continue;
    }

    $product = new WC_Product_Simple();
    $product->set_name($p['name']);
    $product->set_status('publish');
    $product->set_catalog_visibility('visible');
    $product->set_sku($p['sku'] ?: ('TOY-' . rand(1000, 9999)));

    // Prices
    $price = intval($p['prices']['price'] ?? 5000);
    $product->set_regular_price($price);

    // Randomize some sales
    if ($count % 3 === 0) {
        $discount = round($price * 0.85); // 15% off
        $product->set_sale_price($discount);
        $product->set_price($discount);
    } else {
        $product->set_price($price);
    }

    $product->set_manage_stock(false);
    $product->set_stock_status('instock');

    if (!empty($p['short_description'])) {
        $product->set_short_description($p['short_description']);
    }
    if (!empty($p['description'])) {
        $product->set_description($p['description']);
    }

    // Assign categories
    $term_ids = [];
    if (!empty($p['categories'])) {
        foreach ($p['categories'] as $c) {
            if (isset($cat_map[$c['id']])) {
                $term_ids[] = $cat_map[$c['id']];
            } else {
                $t = get_term_by('name', $c['name'], 'product_cat');
                if ($t) $term_ids[] = $t->term_id;
            }
        }
    }
    if (!empty($term_ids)) {
        $product->set_category_ids($term_ids);
    }

    $product_id = $product->save();
    echo "Created product: {$p['name']} (ID: {$product_id})\n";
    $count++;
}

echo "\nCatalog import completed! Total imported: {$count} products.\n";

