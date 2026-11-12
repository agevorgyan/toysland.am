<?php
/**
 * Featured Brand Banners Template Part
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

$theme_uri = get_template_directory_uri();
?>
<section class="toysland-brands-section">
    <div class="container">
        <div class="section-header">
            <div class="section-title-wrap">
                <span class="section-subtitle">⭐ Համաշխարհային բրենդներ</span>
                <h2 class="section-title">Սիրված ապրանքանիշներ</h2>
            </div>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="section-view-all-link">
                <span>Բոլոր բրենդները</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>

        <div class="brands-banners-grid">
            <!-- 1. LEGO -->
            <div class="brand-banner-card brand-card-lego">
                <div>
                    <img src="<?php echo esc_url($theme_uri . '/assets/images/brands/lego.svg'); ?>" alt="LEGO Խաղալիքներ" class="brand-banner-logo" width="120" height="60">
                    <h3 class="brand-banner-title">Կառուցիր Քո աշխարհը</h3>
                    <p class="brand-banner-subtitle">Քաղաքներ, մեքենաներ, տիեզերանավեր և սիրելի հերոսներ LEGO հավաքածուներում:</p>
                </div>
                <a href="<?php echo esc_url(add_query_arg('s', 'lego', wc_get_page_permalink('shop'))); ?>" class="brand-cta-btn">
                    <span>Դիտել LEGO-ն</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>

            <!-- 2. Barbie -->
            <div class="brand-banner-card brand-card-barbie">
                <div>
                    <img src="<?php echo esc_url($theme_uri . '/assets/images/brands/barbie.svg'); ?>" alt="Barbie Տիկնիկներ" class="brand-banner-logo" width="140" height="55">
                    <h3 class="brand-banner-title">Կարող ես լինել ամեն ինչ</h3>
                    <p class="brand-banner-subtitle">Օրիգինալ Barbie տիկնիկներ, նորաձև հագուստներ և կախարդական տնակներ:</p>
                </div>
                <a href="<?php echo esc_url(add_query_arg('s', 'տիկնիկ', wc_get_page_permalink('shop'))); ?>" class="brand-cta-btn">
                    <span>Դիտել Barbie-ն</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>

            <!-- 3. Hot Wheels -->
            <div class="brand-banner-card brand-card-hotwheels">
                <div>
                    <img src="<?php echo esc_url($theme_uri . '/assets/images/brands/hotwheels.svg'); ?>" alt="Hot Wheels Մեքենաներ" class="brand-banner-logo" width="170" height="50">
                    <h3 class="brand-banner-title">Անհավանական արագություն</h3>
                    <p class="brand-banner-subtitle">Լեգենդար մետաղական մեքենաներ, թեքահարթակներ և մրցարշավային թրեքեր:</p>
                </div>
                <a href="<?php echo esc_url(add_query_arg('s', 'մեքենա', wc_get_page_permalink('shop'))); ?>" class="brand-cta-btn">
                    <span>Դիտել Hot Wheels-ը</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

