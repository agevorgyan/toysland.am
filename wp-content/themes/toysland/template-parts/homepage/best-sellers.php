<?php
/**
 * Best Sellers Section Template Part
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

$args = [
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'meta_key'       => 'total_sales',
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC',
];

$query = new WP_Query($args);

// Fallback to random if total_sales is not yet populated
if (!$query->have_posts()) {
    $args = [
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 8,
        'orderby'        => 'rand',
    ];
    $query = new WP_Query($args);
}
?>
<section class="toysland-products-section" style="background:var(--color-surface-soft);">
    <div class="container">
        <div class="section-header">
            <div class="section-title-wrap">
                <span class="section-subtitle">🔥 Ամենապահանջված</span>
                <h2 class="section-title">Լավագույն վաճառքներ</h2>
            </div>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="section-view-all-link">
                <span>Դիտել բոլորը</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>

        <div class="products-grid">
            <?php
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    $product = wc_get_product(get_the_ID());
                    if (!$product) continue;
                    get_template_part('woocommerce/content-product');
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>

