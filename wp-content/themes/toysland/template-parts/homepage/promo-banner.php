<?php
/**
 * Promotional Campaign Banner Template Part
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

$theme_uri = get_template_directory_uri();
?>
<section class="toysland-promo-banner-section">
    <div class="container">
        <div class="campaign-banner-box">
            <div class="campaign-banner-content">
                <span class="campaign-tag">🎉 Հատուկ Առաջարկ</span>
                <h2 class="campaign-title">Ծննդյան տոների և նվերների սեզոն՝ մինչև 30% զեղչ</h2>
                <p class="campaign-desc">Պատվիրեք Ձեր երեխայի երազանքի խաղալիքը, իսկ մենք այն կփաթեթավորենք գեղեցիկ նվերային թղթով և կառաքենք ուղիղ Ձեր դռան մոտ:</p>
                <div class="campaign-code-box">
                    <span class="campaign-code-label">Պրոմո կոդ՝</span>
                    <span class="campaign-code-value">TOYSLAND2026</span>
                </div>
                <div>
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-primary-large" style="background:#FFFFFF;color:var(--color-primary);box-shadow:0 8px 24px rgba(0,0,0,0.15);">
                        <span>Օգտվել զեղչից</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                </div>
            </div>
            <div class="campaign-banner-img">
                <img src="<?php echo esc_url($theme_uri . '/assets/images/products/toy-blocks.svg'); ?>" alt="Խաղալիքների տոնական հավաքածու" width="320" height="320">
            </div>
        </div>
    </div>
</section>

