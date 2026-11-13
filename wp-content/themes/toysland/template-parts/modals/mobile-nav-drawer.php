<?php
/**
 * Mobile Navigation Drawer Template Part
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
<div class="toysland-mobile-drawer" style="position:fixed;inset:0;z-index:2100;pointer-events:none;transition:all 0.3s ease;">
    <div class="mobile-drawer-backdrop" style="position:absolute;inset:0;background:rgba(37,33,58,0.5);opacity:0;transition:opacity 0.3s ease;"></div>
    
    <div class="mobile-drawer-panel" style="position:absolute;top:0;left:0;bottom:0;width:300px;background:var(--color-surface);box-shadow:8px 0 24px rgba(0,0,0,0.15);transform:translateX(-100%);transition:transform 0.35s cubic-bezier(0.16,1,0.3,1);display:flex;flex-direction:column;pointer-events:auto;overflow-y:auto;padding:24px 20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;padding-bottom:16px;border-bottom:1px solid var(--color-border);">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>" alt="ToysLand" style="height:44px;width:auto;">
            <button type="button" class="mobile-drawer-close" aria-label="Փակել" style="width:36px;height:36px;border-radius:50%;background:var(--color-surface-soft);display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:bold;"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <div style="font-size:12px;font-weight:800;color:var(--color-primary);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:12px;">Կատեգորիաներ</div>
        <ul style="display:flex;flex-direction:column;gap:8px;margin-bottom:24px;">
            <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
                <?php foreach ($categories as $cat) : 
                    if ($cat->slug === 'uncategorized') continue;
                    $cat_icon = toysland_get_category_icon($cat->slug);
                    $cat_url = get_term_link($cat);
                ?>
                    <li>
                        <a href="<?php echo esc_url($cat_url); ?>" style="display:flex;align-items:center;gap:12px;padding:8px 10px;border-radius:10px;font-weight:700;font-size:14px;color:var(--color-text-main);">
                            <img src="<?php echo esc_url($cat_icon); ?>" alt="" width="24" height="24">
                            <span><?php echo esc_html($cat->name); ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <div style="font-size:12px;font-weight:800;color:var(--color-primary);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:12px;">Մենյու</div>
        <ul style="display:flex;flex-direction:column;gap:10px;margin-bottom:24px;border-top:1px solid var(--color-border);padding-top:16px;">
            <li><a href="<?php echo esc_url(add_query_arg('on_sale', '1', wc_get_page_permalink('shop'))); ?>" style="font-weight:700;color:var(--color-pink);display:flex;align-items:center;gap:8px;"><i class="fa-solid fa-fire"></i> Ակցիաներ</a></li>
            <li><a href="<?php echo esc_url(add_query_arg('orderby', 'date', wc_get_page_permalink('shop'))); ?>" style="font-weight:700;color:var(--color-text-main);display:flex;align-items:center;gap:8px;"><i class="fa-solid fa-wand-magic-sparkles"></i> Նորույթներ</a></li>
            <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" style="font-weight:700;color:var(--color-text-main);display:flex;align-items:center;gap:8px;"><i class="fa-solid fa-star"></i> Բրենդներ</a></li>
            <li><a href="<?php echo esc_url(home_url('/about/')); ?>" style="font-weight:700;color:var(--color-text-main);display:flex;align-items:center;gap:8px;"><i class="fa-solid fa-circle-info"></i> Մեր մասին</a></li>
        </ul>

        <div style="margin-top:auto;border-top:1px solid var(--color-border);padding-top:16px;font-size:13px;color:var(--color-text-muted);">
            <div style="font-weight:700;color:var(--color-text-main);margin-bottom:4px;display:flex;align-items:center;gap:6px;"><i class="fa-solid fa-phone"></i> Կապ մեզ հետ</div>
            <div>+374 (10) 12-34-56</div>
            <div>Երևան, Հայաստան</div>
        </div>
    </div>
</div>

<style>
.toysland-mobile-drawer.is-open {
    pointer-events: auto !important;
}
.toysland-mobile-drawer.is-open .mobile-drawer-backdrop {
    opacity: 1 !important;
}
.toysland-mobile-drawer.is-open .mobile-drawer-panel {
    transform: translateX(0) !important;
}
</style>

