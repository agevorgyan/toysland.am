<?php
/**
 * Hero Slider Template Part
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

$theme_uri = get_template_directory_uri();
?>
<section class="toysland-hero-section">
    <div class="container">
        <div class="hero-slider-wrapper">
            <div class="hero-slides">
                <!-- Slide 1 -->
                <div class="hero-slide is-active">
                    <img src="<?php echo esc_url($theme_uri . '/assets/images/hero-toys-1.jpg'); ?>" alt="Խաղալ, սովորել, զարգանալ" class="hero-slide-bg" loading="eager">
                    <div class="hero-slide-overlay"></div>
                    <div class="hero-slide-content">
                        <span class="hero-tag"><i class="fa-solid fa-star"></i> Նոր Հավաքածու 2026</span>
                        <h1 class="hero-title">Խաղալ, սովորել, <span>զարգանալ</span>՝ ամեն օր</h1>
                        <p class="hero-desc">Զարգացնող խաղեր, փայտե կոնստրուկտորներ և ստեղծագործական հավաքածուներ, որոնք զարգացնում են երեխայի միտքն ու երևակայությունը:</p>
                        <div class="hero-cta-group">
                            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-primary-large">
                                <span>Դիտել խաղալիքները</span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                            <a href="<?php echo esc_url(add_query_arg('on_sale', '1', wc_get_page_permalink('shop'))); ?>" class="btn-secondary-large">
                                <span>Տեսնել ակցիաները</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="hero-slide">
                    <img src="<?php echo esc_url($theme_uri . '/assets/images/hero-toys-2.jpg'); ?>" alt="Փափուկ ընկերներ և տիկնիկներ" class="hero-slide-bg" loading="lazy">
                    <div class="hero-slide-overlay"></div>
                    <div class="hero-slide-content">
                        <span class="hero-tag"><i class="fa-solid fa-shapes"></i> Սիրելի Փափուկ Խաղալիքներ</span>
                        <h2 class="hero-title">Փափուկ ընկերներ և <span>կախարդական</span> տիկնիկներ</h2>
                        <p class="hero-desc">Ամենաջերմ, անվտանգ արջուկներն ու նորաձև տիկնիկների հավաքածուները՝ ստեղծված անսահման գրկախառնությունների և ուրախ խաղերի համար:</p>
                        <div class="hero-cta-group">
                            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-primary-large">
                                <span>Բացահայտել հավաքածուն</span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="hero-slide">
                    <img src="<?php echo esc_url($theme_uri . '/assets/images/hero-toys-3.jpg'); ?>" alt="Արագություն և արկածներ" class="hero-slide-bg" loading="lazy">
                    <div class="hero-slide-overlay"></div>
                    <div class="hero-slide-content">
                        <span class="hero-tag"><i class="fa-solid fa-car-burst"></i> Hot Wheels & LEGO</span>
                        <h2 class="hero-title">Արագություն, <span>արկածներ</span> և տեխնիկա</h2>
                        <p class="hero-desc">Հեռակառավարվող մեքենաներ, մրցարշավային ուղիներ և LEGO կոնստրուկտորներ ապագա ինժեներների համար:</p>
                        <div class="hero-cta-group">
                            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-primary-large">
                                <span>Դիտել նորույթները</span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Arrows -->
            <div class="hero-slider-arrows">
                <button type="button" class="slider-arrow slider-arrow-prev" aria-label="Նախորդ սլայդ">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <button type="button" class="slider-arrow slider-arrow-next" aria-label="Հաջորդ սլայդ">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>

            <!-- Dots -->
            <div class="hero-slider-dots">
                <span class="slider-dot is-active" data-index="0"></span>
                <span class="slider-dot" data-index="1"></span>
                <span class="slider-dot" data-index="2"></span>
            </div>
        </div>
    </div>
</section>

