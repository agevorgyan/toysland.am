<?php
/**
 * Modern Mega Menu Dropdown Template Part
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

$categories = get_terms([
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
    'number'     => 12,
]);

// Color palette for category icon circles
$icon_bg_colors = [
    '#FFF0F5', '#EBF4FF', '#FFF8E7', '#E8F7EE', '#F3E8FF',
    '#FFEAEA', '#E6FAF8', '#FFF3E0', '#F0F4FF', '#FCE7F3'
];
?>
<div class="mega-menu-dropdown" id="megaMenuDropdown" role="menu">
    <div class="mega-menu-header">
        <div class="mega-menu-title-wrap">
            <span class="mega-menu-title">Խաղալիքների բոլոր կատեգորիաները</span>
            <span class="mega-menu-count-badge"><?php echo count($categories); ?> բաժին</span>
        </div>
        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="mega-menu-all-link">
            <span>Դիտել բոլոր ապրանքները</span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
    </div>

    <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
        <div class="mega-menu-grid">
            <?php 
            $i = 0;
            foreach ($categories as $cat) : 
                if ($cat->slug === 'uncategorized') continue;
                $cat_icon = toysland_get_category_icon($cat->slug);
                $cat_url = get_term_link($cat);
                $bg_color = $icon_bg_colors[$i % count($icon_bg_colors)];
                $i++;
            ?>
                <a href="<?php echo esc_url($cat_url); ?>" class="mega-menu-category-card" role="menuitem">
                    <div class="mega-menu-thumb" style="background-color: <?php echo esc_attr($bg_color); ?>;">
                        <img src="<?php echo esc_url($cat_icon); ?>" alt="<?php echo esc_attr($cat->name); ?>" width="28" height="28" loading="lazy">
                    </div>
                    <div class="mega-menu-cat-info">
                        <div class="mega-menu-cat-name"><?php echo esc_html($cat->name); ?></div>
                        <div class="mega-menu-cat-count"><?php echo esc_html($cat->count); ?> ապրանք</div>
                    </div>
                    <svg class="cat-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Mega Menu Bottom Guarantee Strip -->
    <div class="mega-menu-footer">
        <div class="mega-footer-item">
            <span class="mega-footer-icon">🚚</span>
            <span>Անվճար առաքում 15 000 ֏-ից</span>
        </div>
        <div class="mega-footer-item">
            <span class="mega-footer-icon">🛡️</span>
            <span>100% Սերտիֆիկացված խաղալիքներ</span>
        </div>
        <div class="mega-footer-item">
            <span class="mega-footer-icon">🎁</span>
            <span>Անվճար նվերի փաթեթավորում</span>
        </div>
    </div>
</div>

