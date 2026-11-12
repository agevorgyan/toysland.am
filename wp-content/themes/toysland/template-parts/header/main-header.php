<?php
/**
 * Main Header Template Part
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

$cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
$cart_subtotal = WC()->cart ? WC()->cart->get_cart_subtotal() : '0 ֏';
$logo_url = get_template_directory_uri() . '/assets/images/logo.png';
?>
<div class="toysland-main-header">
    <div class="container header-inner">
        <!-- Mobile Hamburger -->
        <button type="button" class="mobile-nav-toggle" aria-label="Բացել մենյուն">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- ToysLand Brand Logo -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="header-logo" rel="home">
            <img src="<?php echo esc_url($logo_url); ?>" alt="ToysLand — Խաղալիքների Խանութ" width="220" height="68">
        </a>

        <!-- Large AJAX Live Search -->
        <div class="header-search-container">
            <form role="search" method="get" class="search-form-wrapper" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="search" class="search-input" name="s" placeholder="Փնտրել խաղալիքներ, բրենդներ, ապրանքներ..." autocomplete="off">
                <input type="hidden" name="post_type" value="product">
                
                <?php
                $categories = get_terms([
                    'taxonomy'   => 'product_cat',
                    'hide_empty' => true,
                ]);
                if (!empty($categories) && !is_wp_error($categories)) :
                ?>
                <select name="product_cat" class="search-category-select" aria-label="Ընտրել կատեգորիան">
                    <option value="">Բոլոր կատեգորիաները</option>
                    <?php foreach ($categories as $cat) : ?>
                        <option value="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></option>
                    <?php endforeach; ?>
                </select>
                <?php endif; ?>

                <button type="submit" class="search-submit-btn" aria-label="Որոնել">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </button>
            </form>
            <!-- Live AJAX Search Dropdown Results -->
            <div class="ajax-search-results"></div>
        </div>

        <!-- Header Actions: Account, Wishlist, Cart -->
        <div class="header-actions">
            <!-- Account -->
            <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="action-btn" title="Իմ հաշիվը">
                <span class="action-icon-wrap">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </span>
                <span class="action-label">Մուտք</span>
            </a>

            <!-- Wishlist -->
            <a href="<?php echo esc_url(home_url('/wishlist/')); ?>" class="action-btn header-wishlist-btn" title="Ընտրյալներ">
                <span class="action-icon-wrap">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    <span class="action-badge js-wishlist-count" style="display: none;">0</span>
                </span>
                <span class="action-label">Ընտրյալներ</span>
            </a>

            <!-- Mini Cart Trigger -->
            <button type="button" class="action-btn cart-btn-primary js-open-cart-drawer" title="Զամբյուղ">
                <span class="action-icon-wrap">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    <span class="action-badge js-cart-count"><?php echo esc_html($cart_count); ?></span>
                </span>
                <span class="cart-amount-label js-cart-subtotal"><?php echo wp_kses_post($cart_subtotal); ?></span>
            </button>
        </div>
    </div>
</div>

