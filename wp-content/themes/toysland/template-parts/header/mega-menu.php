<?php
/**
 * Mega Menu Template Part
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
?>
<div class="mega-menu-dropdown">
    <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
        <?php foreach ($categories as $cat) : 
            if ($cat->slug === 'uncategorized') continue;
            $cat_icon = toysland_get_category_icon($cat->slug);
            $cat_url = get_term_link($cat);
        ?>
            <a href="<?php echo esc_url($cat_url); ?>" class="mega-menu-category-card">
                <div class="mega-menu-thumb">
                    <img src="<?php echo esc_url($cat_icon); ?>" alt="<?php echo esc_attr($cat->name); ?>" width="36" height="36">
                </div>
                <div>
                    <div class="mega-menu-cat-name"><?php echo esc_html($cat->name); ?></div>
                    <div class="mega-menu-count"><?php echo esc_html($cat->count); ?> ապրանք</div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

