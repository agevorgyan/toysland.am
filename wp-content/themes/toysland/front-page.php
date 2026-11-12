<?php
/**
 * ToysLand Front Page Template
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<!-- 1. Hero Carousel -->
<?php get_template_part('template-parts/homepage/hero-slider'); ?>

<!-- 2. Trust Benefits -->
<?php get_template_part('template-parts/homepage/benefits'); ?>

<!-- 3. Categories Grid -->
<?php get_template_part('template-parts/homepage/categories-grid'); ?>

<!-- 4. Featured Brands (LEGO, Barbie, Hot Wheels) -->
<?php get_template_part('template-parts/homepage/featured-brands'); ?>

<!-- 5. New Arrivals -->
<?php get_template_part('template-parts/homepage/new-arrivals'); ?>

<!-- 6. Promotional Campaign Banner -->
<?php get_template_part('template-parts/homepage/promo-banner'); ?>

<!-- 7. Best Sellers -->
<?php get_template_part('template-parts/homepage/best-sellers'); ?>

<!-- 8. Products By Age -->
<?php get_template_part('template-parts/homepage/products-by-age'); ?>

<!-- 9. Newsletter Subscription -->
<?php get_template_part('template-parts/homepage/newsletter'); ?>

<?php
get_footer();

