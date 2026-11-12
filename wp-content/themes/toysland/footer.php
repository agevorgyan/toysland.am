<?php
/**
 * ToysLand Theme Footer
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
</main><!-- #primary -->

<!-- Main Site Footer -->
<?php get_template_part('template-parts/footer/main-footer'); ?>

<!-- Slide-out Mini Cart Drawer -->
<?php get_template_part('template-parts/modals/mini-cart-drawer'); ?>

<!-- Mobile Navigation Drawer -->
<?php get_template_part('template-parts/modals/mobile-nav-drawer'); ?>

<!-- Mobile Bottom Navigation Bar -->
<?php get_template_part('template-parts/footer/mobile-bottom-bar'); ?>

<?php wp_footer(); ?>
</body>
</html>

