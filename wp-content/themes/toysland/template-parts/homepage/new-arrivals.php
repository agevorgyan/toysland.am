<?php
/**
 * New Arrivals Section Template Part
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
    'orderby'        => 'date',
    'order'          => 'DESC',
];

$query = new WP_Query($args);
?>
<section class="toysland-products-section">
    <div class="container">
        <div class="section-header">
            <div class="section-title-wrap">
                <span class="section-subtitle"><i class="fa-solid fa-wand-magic-sparkles"></i> Թարմ համալրում</span>
                <h2 class="section-title">Նորույթներ</h2>
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
            else :
                echo '<p>Նորույթներ դեռ չկան:</p>';
            endif;
            ?>
        </div>
    </div>
</section>

