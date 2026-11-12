<?php
/**
 * Modern Navigation Bar Template Part
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

$shop_url = wc_get_page_permalink('shop');
$sale_url = add_query_arg('on_sale', '1', $shop_url);
$new_url  = add_query_arg('orderby', 'date', $shop_url);
?>
<nav class="toysland-nav-bar" aria-label="Գլխավոր նավիգացիա">
    <div class="container nav-inner">
        <ul class="nav-links">
            <!-- Mega Menu Category Trigger -->
            <li class="nav-item has-mega-menu" id="navCategoriesItem">
                <button type="button" class="categories-menu-btn" id="categoriesMenuBtn" aria-expanded="false" aria-haspopup="true">
                    <span class="categories-icon-bars">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                    <span class="categories-btn-text">Խաղալիքների կատալոգ</span>
                    <svg class="chevron-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <?php get_template_part('template-parts/header/mega-menu'); ?>
            </li>

            <!-- Sales / Promotions -->
            <li class="nav-item <?php echo (isset($_GET['on_sale']) && $_GET['on_sale'] == '1') ? 'is-active' : ''; ?>">
                <a href="<?php echo esc_url($sale_url); ?>" class="nav-link nav-link-hot">
                    <span class="nav-link-icon">🔥</span>
                    <span>Ակցիաներ</span>
                    <span class="nav-badge-pill nav-badge-hot">HOT</span>
                </a>
            </li>

            <!-- New Arrivals -->
            <li class="nav-item <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'date') ? 'is-active' : ''; ?>">
                <a href="<?php echo esc_url($new_url); ?>" class="nav-link">
                    <span class="nav-link-icon">✨</span>
                    <span>Նորույթներ</span>
                    <span class="nav-badge-pill nav-badge-new">NEW</span>
                </a>
            </li>

            <!-- Popular Brands -->
            <li class="nav-item">
                <a href="<?php echo esc_url($shop_url); ?>" class="nav-link">
                    <span class="nav-link-icon">🏷️</span>
                    <span>Բրենդներ</span>
                </a>
            </li>

            <!-- Gift Ideas -->
            <li class="nav-item">
                <a href="<?php echo esc_url($shop_url); ?>" class="nav-link">
                    <span class="nav-link-icon">🎁</span>
                    <span>Նվերների գաղափարներ</span>
                </a>
            </li>

            <!-- About Us -->
            <li class="nav-item <?php echo is_page('about') ? 'is-active' : ''; ?>">
                <a href="<?php echo esc_url(home_url('/about/')); ?>" class="nav-link">
                    <span class="nav-link-icon">ℹ️</span>
                    <span>Մեր մասին</span>
                </a>
            </li>
        </ul>

        <!-- Right Callout Perk -->
        <div class="nav-right-callout">
            <span class="pulse-dot"></span>
            <span class="callout-text">Արագ առաքում Երևանում 1 օրում</span>
        </div>
    </div>
</nav>

