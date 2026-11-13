<?php
/**
 * Empty Cart Page Template Override
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

?>
<div class="toysland-cart-page" style="padding-top: 10px;">
    <!-- Breadcrumbs -->
    <nav class="cart-breadcrumbs" aria-label="Breadcrumb">
        <a href="<?php echo esc_url(home_url('/')); ?>">Գլխավոր</a>
        <span class="sep">/</span>
        <span class="current">Զամբյուղ</span>
    </nav>

    <div class="cart-notices-wrap">
        <?php woocommerce_output_all_notices(); ?>
    </div>

    <!-- EMPTY CART CARD -->
    <div class="cart-empty-card">
        <div class="empty-icon-wrap">
            <svg width="68" height="68" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1.5"/>
                <circle cx="20" cy="21" r="1.5"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
            </svg>
            <span class="empty-sparkle"><i class="fa-solid fa-wand-magic-sparkles"></i></span>
        </div>
        <h2 class="empty-title">Ձեր զամբյուղը դատարկ է</h2>
        <p class="empty-description">
            Զամբյուղում դեռ ոչ մի ապրանք չկա: Ուսումնասիրեք մեր հարուստ տեսականին և գտեք լավագույն խաղալիքները Ձեր փոքրիկի համար:
        </p>
        <div class="empty-actions">
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="cart-checkout-btn" style="max-width: 280px; margin: 0 auto;">
                <span>Գնալ խանութ</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
        </div>

        <!-- Popular Categories to resume shopping -->
        <div class="empty-popular-cats">
            <h3 class="empty-cats-heading">Հանրաճանաչ կատեգորիաներ</h3>
            <div class="empty-cats-grid">
                <?php
                $popular_cats = [
                    ['slug' => 'soft-toys', 'name' => 'Փափուկ խաղալիքներ', 'icon' => '<i class="fa-solid fa-shapes"></i>'],
                    ['slug' => 'construction', 'name' => 'Կոնստրուկտորներ', 'icon' => '<i class="fa-solid fa-puzzle-piece"></i>'],
                    ['slug' => 'learning', 'name' => 'Ուսուցողական', 'icon' => '<i class="fa-solid fa-brain"></i>'],
                    ['slug' => 'vehicles', 'name' => 'Մեքենաներ', 'icon' => '<i class="fa-solid fa-car"></i>'],
                    ['slug' => 'board-games', 'name' => 'Սեղանի խաղեր', 'icon' => '<i class="fa-solid fa-dice"></i>'],
                    ['slug' => 'outdoor', 'name' => 'Բացօթյա խաղեր', 'icon' => '<i class="fa-solid fa-sun"></i>'],
                ];
                foreach ($popular_cats as $cat_item) :
                    $term = get_term_by('slug', $cat_item['slug'], 'product_cat');
                    $cat_url = $term && !is_wp_error($term) ? get_term_link($term) : wc_get_page_permalink('shop');
                ?>
                    <a href="<?php echo esc_url($cat_url); ?>" class="empty-cat-pill">
                        <span class="empty-cat-emoji"><?php echo $cat_item['icon']; ?></span>
                        <span class="empty-cat-name"><?php echo esc_html($cat_item['name']); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

