<?php
/**
 * WooCommerce Product Card Loop Item
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;

if (empty($product) || !is_a($product, 'WC_Product')) {
    $product = function_exists('wc_get_product') ? wc_get_product(get_the_ID()) : null;
}

if (empty($product) || !$product->is_visible()) {
    return;
}

$product_id   = $product->get_id();
$product_name = $product->get_name();
$product_url  = $product->get_permalink();
$product_img  = toysland_get_product_image_url($product);
$is_on_sale   = $product->is_on_sale();
$regular_price = $product->get_regular_price();
$sale_price   = $product->get_sale_price();
$categories   = get_the_terms($product_id, 'product_cat');
$category_name = (!empty($categories) && !is_wp_error($categories)) ? $categories[0]->name : 'Խաղալիք';
$category_link = (!empty($categories) && !is_wp_error($categories)) ? get_term_link($categories[0]) : wc_get_page_permalink('shop');

// Calculate discount percentage
$discount_percent = 0;
if ($is_on_sale && $regular_price > 0 && $sale_price > 0) {
    $discount_percent = round((($regular_price - $sale_price) / $regular_price) * 100);
}
?>

<div class="product-card" data-product-id="<?php echo esc_attr($product_id); ?>">
    <!-- Thumbnail Container -->
    <div class="product-thumb-container">
        <!-- Badges -->
        <div class="product-badge-group">
            <?php if ($is_on_sale && $discount_percent > 0) : ?>
                <span class="badge-sale">-<?php echo esc_html($discount_percent); ?>%</span>
            <?php elseif (time() - strtotime(get_the_date('Y-m-d', $product_id)) < (30 * DAY_IN_SECONDS)) : ?>
                <span class="badge-new">ՆՈՐ</span>
            <?php endif; ?>
        </div>

        <!-- Wishlist Button -->
        <button type="button" class="product-wishlist-btn" data-product-id="<?php echo esc_attr($product_id); ?>" aria-label="Ավելացնել ընտրյալներում">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </button>

        <a href="<?php echo esc_url($product_url); ?>" class="product-thumb-link">
            <img src="<?php echo esc_url($product_img); ?>" alt="<?php echo esc_attr($product_name); ?>" class="product-thumb-img" loading="lazy">
        </a>
    </div>

    <!-- Category -->
    <a href="<?php echo esc_url($category_link); ?>" class="product-category-link">
        <?php echo esc_html($category_name); ?>
    </a>

    <!-- Title -->
    <h3 class="product-title">
        <a href="<?php echo esc_url($product_url); ?>">
            <?php echo esc_html($product_name); ?>
        </a>
    </h3>

    <!-- Star Ratings -->
    <?php echo toysland_render_rating($product->get_average_rating(), $product->get_review_count()); ?>

    <!-- Price Box -->
    <div class="product-price-box">
        <span class="current-price"><?php echo esc_html(toysland_price($product->get_price())); ?></span>
        <?php if ($is_on_sale && !empty($regular_price)) : ?>
            <span class="regular-price-old"><?php echo esc_html(toysland_price($regular_price)); ?></span>
        <?php endif; ?>
    </div>

    <!-- Actions (AJAX Add to Cart) -->
    <div class="product-actions-wrap">
        <button type="button" class="btn-add-to-cart js-ajax-add-to-cart" data-product-id="<?php echo esc_attr($product_id); ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            <span>Ավելացնել</span>
        </button>
        <a href="<?php echo esc_url($product_url); ?>" class="btn-quick-buy" title="Դիտել">
            <span><i class="fa-solid fa-eye"></i></span>
        </a>
    </div>
</div>

