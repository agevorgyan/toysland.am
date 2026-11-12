<?php
/**
 * Categories Grid Template Part
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

$categories = get_terms([
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
    'number'     => 10,
]);
?>
<section class="toysland-categories-section">
    <div class="container">
        <div class="section-header">
            <div class="section-title-wrap">
                <span class="section-subtitle">🎨 Ընտրեք ըստ թեմայի</span>
                <h2 class="section-title">Խաղալիքների կատեգորիաներ</h2>
            </div>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="section-view-all-link">
                <span>Բոլոր կատեգորիաները</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>

        <div class="categories-grid">
            <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
                <?php foreach ($categories as $cat) : 
                    if ($cat->slug === 'uncategorized') continue;
                    $cat_icon = toysland_get_category_icon($cat->slug);
                    $cat_url = get_term_link($cat);
                ?>
                    <a href="<?php echo esc_url($cat_url); ?>" class="category-card">
                        <div class="category-card-bg-glow"></div>
                        <div class="category-img-wrap">
                            <img src="<?php echo esc_url($cat_icon); ?>" alt="<?php echo esc_attr($cat->name); ?>" width="64" height="64" loading="lazy">
                        </div>
                        <h3 class="category-name"><?php echo esc_html($cat->name); ?></h3>
                        <span class="category-count"><?php echo esc_html($cat->count); ?> ապրանք</span>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

