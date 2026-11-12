<?php
/**
 * Navigation Bar Template Part
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<nav class="toysland-nav-bar" aria-label="Գլխավոր նավիգացիա">
    <div class="container nav-inner">
        <ul class="nav-links">
            <!-- Mega Menu Category Trigger -->
            <li class="nav-item has-mega-menu">
                <div class="categories-menu-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    <span>Խաղալիքների կատեգորիաներ</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <?php get_template_part('template-parts/header/mega-menu'); ?>
            </li>

            <!-- Sales / Promotions -->
            <li class="nav-item">
                <a href="<?php echo esc_url(add_query_arg('on_sale', '1', wc_get_page_permalink('shop'))); ?>" class="nav-link">
                    <span>Ակցիաներ</span>
                    <span class="nav-badge-pill nav-badge-hot">HOT</span>
                </a>
            </li>

            <!-- New Arrivals -->
            <li class="nav-item">
                <a href="<?php echo esc_url(add_query_arg('orderby', 'date', wc_get_page_permalink('shop'))); ?>" class="nav-link">
                    <span>Նորույթներ</span>
                    <span class="nav-badge-pill nav-badge-new">NEW</span>
                </a>
            </li>

            <!-- Popular Brands -->
            <li class="nav-item">
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="nav-link">
                    <span>Բրենդներ</span>
                </a>
            </li>

            <!-- Gift Ideas -->
            <li class="nav-item">
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="nav-link">
                    <span>Նվերների գաղափարներ</span>
                </a>
            </li>

            <!-- About Us -->
            <li class="nav-item">
                <a href="<?php echo esc_url(home_url('/about/')); ?>" class="nav-link">
                    <span>Մեր մասին</span>
                </a>
            </li>
        </ul>

        <div class="nav-right-callout" style="font-size:13px;font-weight:700;color:var(--color-primary);display:flex;align-items:center;gap:6px;">
            <span>✨ Որակյալ և ապահով խաղալիքներ</span>
        </div>
    </div>
</nav>

