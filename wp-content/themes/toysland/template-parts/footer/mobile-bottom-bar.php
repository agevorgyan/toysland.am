<?php
/**
 * Mobile Bottom Navigation Bar Template Part
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

$cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
?>
<nav class="toysland-mobile-bottom-bar" aria-label="Մոբայլ նավիգացիա">
    <div class="mobile-bottom-nav-inner">
        <!-- 1. Home -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-bottom-item <?php echo is_front_page() ? 'is-active' : ''; ?>">
            <div class="mobile-bottom-icon-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <span>Գլխավոր</span>
        </a>

        <!-- 2. Categories -->
        <button type="button" class="mobile-bottom-item mobile-nav-toggle" aria-label="Կատալոգ">
            <div class="mobile-bottom-icon-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="7" height="7" rx="2"/><rect x="14" y="3" width="7" height="7" rx="2"/><rect x="14" y="14" width="7" height="7" rx="2"/><rect x="3" y="14" width="7" height="7" rx="2"/></svg>
            </div>
            <span>Կատալոգ</span>
        </button>

        <!-- 3. Search -->
        <button type="button" class="mobile-bottom-item mobile-search-trigger" aria-label="Որոնում">
            <div class="mobile-bottom-icon-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </div>
            <span>Որոնում</span>
        </button>

        <!-- 4. Wishlist -->
        <a href="<?php echo esc_url(home_url('/wishlist/')); ?>" class="mobile-bottom-item" aria-label="Ընտրյալներ">
            <div class="mobile-bottom-icon-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                <span class="mobile-bottom-badge js-wishlist-count" style="display:none;">0</span>
            </div>
            <span>Ընտրյալ</span>
        </a>

        <!-- 5. Cart -->
        <button type="button" class="mobile-bottom-item js-open-cart-drawer" aria-label="Զամբյուղ">
            <div class="mobile-bottom-icon-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <circle cx="9" cy="21" r="1"/>
                    <circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
                <span class="mobile-bottom-badge js-cart-count"><?php echo esc_html($cart_count); ?></span>
            </div>
            <span>Զամբյուղ</span>
        </button>
    </div>
</nav>

