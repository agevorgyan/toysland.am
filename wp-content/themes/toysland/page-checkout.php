<?php
/**
 * Template Name: Checkout Page
 *
 * Modern high-converting Checkout Page for ToysLand
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$is_thank_you = is_wc_endpoint_url('order-received');
$cart = WC()->cart;
$is_empty = !$is_thank_you && (!$cart || $cart->is_empty());
?>

<div class="toysland-checkout-page">
    <div class="container">
        
        <!-- Breadcrumbs -->
        <nav class="checkout-breadcrumbs" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Գլխավոր</a>
            <span class="sep">/</span>
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>">Զամբյուղ</a>
            <span class="sep">/</span>
            <span class="current"><?php echo $is_thank_you ? 'Պատվերի հաստատում' : 'Պատվերի ձևակերպում'; ?></span>
        </nav>

        <!-- Checkout Steps Progress Bar -->
        <div class="checkout-steps-bar">
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="step-pill step-completed">
                <span class="step-icon"><i class="fa-solid fa-check"></i></span>
                <span class="step-name">1. Զամբյուղ</span>
            </a>
            <span class="step-separator">→</span>
            <?php if ($is_thank_you) : ?>
                <div class="step-pill step-completed">
                    <span class="step-icon"><i class="fa-solid fa-check"></i></span>
                    <span class="step-name">2. Ձևակերպում</span>
                </div>
                <span class="step-separator">→</span>
                <div class="step-pill step-current">
                    <span class="step-icon">3</span>
                    <span class="step-name">3. Հաստատված է <i class="fa-solid fa-award"></i></span>
                </div>
            <?php else : ?>
                <div class="step-pill step-current">
                    <span class="step-icon">2</span>
                    <span class="step-name">2. Ձևակերպում</span>
                </div>
                <span class="step-separator">→</span>
                <div class="step-pill step-future">
                    <span class="step-icon">3</span>
                    <span class="step-name">3. Հաստատում</span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Notices -->
        <div class="checkout-notices-wrap">
            <?php woocommerce_output_all_notices(); ?>
        </div>

        <?php if ($is_empty) : ?>
            <div class="cart-empty-card" style="margin: 20px auto 40px;">
                <div class="empty-icon-wrap">
                    <svg width="68" height="68" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1.5"/>
                        <circle cx="20" cy="21" r="1.5"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                </div>
                <h2 class="empty-title">Ձեր զամբյուղը դատարկ է</h2>
                <p class="empty-description">
                    Պատվեր ձևակերպելու համար նախ անհրաժեշտ է ապրանքներ ավելացնել զամբյուղ: Ուսումնասիրեք մեր տեսականին և գտեք լավագույն խաղալիքները:
                </p>
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="cart-checkout-btn" style="max-width: 280px; margin: 0 auto;">
                    <span>Գնալ խանութ</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
            </div>
        <?php else : ?>
            <?php echo do_shortcode('[woocommerce_checkout]'); ?>
        <?php endif; ?>

    </div>
</div>

<?php
get_footer();
