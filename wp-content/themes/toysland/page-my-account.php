<?php
/**
 * Template Name: My Account Page
 *
 * Modern high-converting My Account Page for ToysLand
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="toysland-myaccount-page">
    <div class="container">
        
        <!-- Breadcrumbs -->
        <nav class="account-breadcrumbs" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Գլխավոր</a>
            <span class="sep">/</span>
            <span class="current">Իմ հաշիվը</span>
        </nav>

        <div class="account-notices-wrap">
            <?php woocommerce_output_all_notices(); ?>
        </div>

        <div class="account-content-container">
            <?php
            while (have_posts()) :
                the_post();
                the_content();
            endwhile;
            ?>
        </div>

    </div>
</div>

<?php
get_footer();

