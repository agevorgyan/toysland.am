<?php
/**
 * WooCommerce Cart Template Override
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

$cart = WC()->cart;
$is_empty = !$cart || $cart->is_empty();

$free_shipping_threshold = 15000;
$subtotal_raw = $cart ? floatval($cart->get_subtotal()) : 0;
$remaining = max(0, $free_shipping_threshold - $subtotal_raw);
$percent = min(100, round(($subtotal_raw / $free_shipping_threshold) * 100));
$is_free_shipping = ($remaining <= 0);
$items_count = $cart ? $cart->get_cart_contents_count() : 0;
?>

<div class="toysland-cart-page" style="padding-top: 10px;">
    <!-- Breadcrumbs -->
    <nav class="cart-breadcrumbs" aria-label="Breadcrumb">
        <a href="<?php echo esc_url(home_url('/')); ?>">Գլխավոր</a>
        <span class="sep">/</span>
        <span class="current">Զամբյուղ</span>
    </nav>

    <!-- Notices -->
    <div class="cart-notices-wrap">
        <?php woocommerce_output_all_notices(); ?>
    </div>

    <?php if ($is_empty) : ?>
        <!-- EMPTY CART STATE -->
        <div class="cart-empty-card">
            <div class="empty-icon-wrap">
                <svg width="68" height="68" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1.5"/>
                    <circle cx="20" cy="21" r="1.5"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
                <span class="empty-sparkle">✨</span>
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
        </div>

    <?php else : ?>

        <!-- Page Header -->
        <div class="cart-page-header">
            <div class="cart-header-title-wrap">
                <h1 class="cart-page-title">
                    Զամբյուղ
                    <span class="cart-count-badge js-cart-badge-count"><?php echo esc_html($items_count); ?> ապրանք</span>
                </h1>
            </div>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="cart-continue-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                <span>Շարունակել գնումները</span>
            </a>
        </div>

        <!-- Free Shipping Banner -->
        <div class="cart-shipping-banner js-shipping-banner <?php echo $is_free_shipping ? 'is-free-unlocked' : ''; ?>">
            <div class="cart-shipping-banner-top">
                <div class="cart-shipping-icon-box">
                    <span class="shipping-icon js-shipping-icon"><?php echo $is_free_shipping ? '🎉' : '🚚'; ?></span>
                </div>
                <div class="cart-shipping-info">
                    <div class="cart-shipping-msg js-shipping-msg">
                        <?php if ($is_free_shipping) : ?>
                            <strong>Շնորհավորո՜ւմ ենք:</strong> Դուք ստացել եք <strong>ԱՆՎՃԱՐ ԱՌԱՔՈՒՄ</strong> Երևանում:
                        <?php else : ?>
                            Ավելացրեք ևս <strong class="js-shipping-remain"><?php echo esc_html(toysland_price($remaining)); ?></strong>-ի ապրանք՝ <strong>ԱՆՎՃԱՐ ԱՌԱՔՄԱՆ</strong> համար (Երևանում 15 000 ֏-ից):
                        <?php endif; ?>
                    </div>
                </div>
                <span class="cart-shipping-percent-tag js-shipping-percent"><?php echo esc_html($percent); ?>%</span>
            </div>
            <div class="cart-shipping-track">
                <div class="cart-shipping-fill js-shipping-fill" style="width: <?php echo esc_attr($percent); ?>%;"></div>
            </div>
        </div>

        <!-- Form -->
        <form class="toysland-cart-form woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
            <div class="cart-main-grid">
                
                <!-- Left: Items Card -->
                <div class="cart-items-column">
                    <div class="cart-items-card">
                        
                        <div class="cart-items-table-header">
                            <div class="col-head col-product">Ապրանք</div>
                            <div class="col-head col-price">Գին</div>
                            <div class="col-head col-qty">Քանակ</div>
                            <div class="col-head col-subtotal">Ընդհանուր</div>
                            <div class="col-head col-action"></div>
                        </div>

                        <div class="cart-items-list js-cart-items-list">
                            <?php
                            foreach ($cart->get_cart() as $cart_item_key => $cart_item) :
                                $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                                if (!$_product || !$_product->exists() || $cart_item['quantity'] <= 0 || !apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                                    continue;
                                }

                                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                                $product_name      = $_product->get_name();
                                $product_img       = toysland_get_product_image_url($_product);
                                $item_price        = $cart->get_product_price($_product);
                                $item_subtotal     = apply_filters('woocommerce_cart_item_subtotal', $cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                                $remove_url        = wc_get_cart_remove_url($cart_item_key);
                                $terms             = get_the_terms($product_id, 'product_cat');
                                $primary_cat       = (!empty($terms) && !is_wp_error($terms)) ? $terms[0]->name : '';
                            ?>
                                <div class="cart-item-row js-cart-item-row" data-key="<?php echo esc_attr($cart_item_key); ?>">
                                    <div class="col-cell col-product">
                                        <a href="<?php echo esc_url($product_permalink); ?>" class="cart-item-thumb-link">
                                            <img src="<?php echo esc_url($product_img); ?>" alt="<?php echo esc_attr($product_name); ?>" class="cart-item-thumb">
                                        </a>
                                        <div class="cart-item-meta">
                                            <?php if ($primary_cat) : ?>
                                                <span class="cart-item-category"><?php echo esc_html($primary_cat); ?></span>
                                            <?php endif; ?>
                                            <a href="<?php echo esc_url($product_permalink); ?>" class="cart-item-title">
                                                <?php echo esc_html($product_name); ?>
                                            </a>
                                            <div class="cart-item-stock-tag">
                                                <span class="stock-dot"></span> Առկա է
                                            </div>
                                            <div class="cart-item-mobile-price">
                                                <span class="mobile-unit-price"><?php echo wp_kses_post($item_price); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-cell col-price">
                                        <span class="cart-item-unit-price"><?php echo wp_kses_post($item_price); ?></span>
                                    </div>

                                    <!-- Mobile & Desktop Controls Wrap -->
                                    <div class="cart-item-controls-wrap">
                                        <div class="col-cell col-qty">
                                            <div class="cart-qty-stepper">
                                                <button type="button" class="cart-stepper-btn js-cart-minus" data-key="<?php echo esc_attr($cart_item_key); ?>" aria-label="Նվազեցնել">−</button>
                                                <input type="number" 
                                                       name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]" 
                                                       value="<?php echo esc_attr($cart_item['quantity']); ?>" 
                                                       min="1" 
                                                       max="<?php echo esc_attr($_product->get_max_purchase_quantity()); ?>" 
                                                       class="cart-qty-input js-cart-qty-input" 
                                                       data-key="<?php echo esc_attr($cart_item_key); ?>" 
                                                       readonly>
                                                <button type="button" class="cart-stepper-btn js-cart-plus" data-key="<?php echo esc_attr($cart_item_key); ?>" aria-label="Ավելացնել">+</button>
                                            </div>
                                        </div>

                                        <div class="col-cell col-subtotal">
                                            <span class="cart-item-line-total js-item-subtotal"><?php echo wp_kses_post($item_subtotal); ?></span>
                                        </div>

                                        <div class="col-cell col-action">
                                            <a href="<?php echo esc_url($remove_url); ?>" 
                                               class="cart-item-remove-btn js-cart-remove-item" 
                                               data-key="<?php echo esc_attr($cart_item_key); ?>" 
                                               title="Հեռացնել ապրանքը"
                                               aria-label="Հեռացնել ապրանքը">
                                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="cart-items-card-footer">
                            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="cart-footer-back-link">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                                <span>Շարունակել գնումները</span>
                            </a>
                            <button type="submit" class="cart-update-btn button" name="update_cart" value="Թարմացնել զամբյուղը">
                                Թարմացնել զամբյուղը
                            </button>
                            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                        </div>

                    </div>
                </div>

                <!-- Right: Summary Card -->
                <div class="cart-summary-column">
                    <div class="cart-summary-card">
                        
                        <h3 class="cart-summary-title">
                            <span>Պատվերի ամփոփում</span>
                            <span class="summary-badge js-summary-badge"><?php echo esc_html($items_count); ?> ապրանք</span>
                        </h3>

                        <div class="cart-summary-breakdown">
                            <div class="summary-row">
                                <span class="summary-label">Ապրանքների գումար</span>
                                <span class="summary-value js-summary-subtotal"><?php echo wp_kses_post($cart->get_cart_subtotal()); ?></span>
                            </div>

                            <div class="summary-row summary-shipping-row">
                                <div class="summary-label-wrap">
                                    <span class="summary-label">Առաքում</span>
                                    <span class="summary-sublabel">Երևանում 1 աշխ. օրվա ընթացքում</span>
                                </div>
                                <span class="summary-value js-summary-shipping">
                                    <?php if ($is_free_shipping) : ?>
                                        <span class="shipping-free-pill">Անվճար</span>
                                    <?php else : ?>
                                        <span><?php echo esc_html(toysland_price(1000)); ?></span>
                                    <?php endif; ?>
                                </span>
                            </div>

                            <?php if ($cart->get_coupons()) : ?>
                                <?php foreach ($cart->get_coupons() as $code => $coupon) : ?>
                                    <div class="summary-row summary-coupon-row">
                                        <span class="summary-label">
                                            Կտրոն: <strong><?php echo esc_html($code); ?></strong>
                                            <a href="<?php echo esc_url(wc_get_cart_remove_coupon_url($code)); ?>" class="remove-coupon-link" title="Հեռացնել կտրոնը">✕</a>
                                        </span>
                                        <span class="summary-value coupon-discount-val">
                                            -<?php echo wp_kses_post(wc_price($cart->get_coupon_discount_amount($code))); ?>
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <?php if (wc_coupons_enabled()) : ?>
                            <div class="cart-coupon-box">
                                <button type="button" class="coupon-toggle-btn js-coupon-toggle">
                                    <span class="coupon-toggle-text">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                                        Ունե՞ք պրոմո կոդ կամ կտրոն
                                    </span>
                                    <svg class="coupon-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </button>
                                <div class="coupon-form-inner js-coupon-panel">
                                    <input type="text" name="coupon_code" class="coupon-input" id="coupon_code" value="" placeholder="Մուտքագրեք կոդը">
                                    <button type="submit" class="coupon-apply-btn" name="apply_coupon" value="Կիրառել">Կիրառել</button>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="summary-divider"></div>

                        <div class="summary-grand-total-row">
                            <div class="grand-total-label-wrap">
                                <span class="grand-total-label">Ընդհանուր վճարման ենթակա</span>
                                <span class="grand-total-tax-note">Ներառյալ բոլոր հարկերը</span>
                            </div>
                            <span class="grand-total-amount js-summary-total"><?php echo wp_kses_post($cart->get_total()); ?></span>
                        </div>

                        <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="cart-checkout-btn">
                            <span>Անցնել պատվերի ձևակերպմանը</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </a>

                        <div class="cart-trust-badges">
                            <div class="trust-badge-item">
                                <div class="trust-badge-icon">🚚</div>
                                <div class="trust-badge-text">
                                    <strong>Արագ առաքում Երևանում</strong>
                                    <span>1 աշխատանքային օրվա ընթացքում</span>
                                </div>
                            </div>
                            <div class="trust-badge-item">
                                <div class="trust-badge-icon">🛡️</div>
                                <div class="trust-badge-text">
                                    <strong>100% Որակյալ և ապահով</strong>
                                    <span>Սերտիֆիկացված էկոլոգիապես մաքուր խաղալիքներ</span>
                                </div>
                            </div>
                            <div class="trust-badge-item">
                                <div class="trust-badge-icon">🔄</div>
                                <div class="trust-badge-text">
                                    <strong>Հետվերադարձի երաշխիք</strong>
                                    <span>14 օրվա ընթացքում անխոչընդոտ փոխանակում</span>
                                </div>
                            </div>
                        </div>

                        <div class="cart-payment-methods-box">
                            <span class="payment-methods-title">Վճարման եղանակներ</span>
                            <div class="payment-badges-list">
                                <span class="payment-badge-pill">Idram</span>
                                <span class="payment-badge-pill">Telcell</span>
                                <span class="payment-badge-pill">ArCa</span>
                                <span class="payment-badge-pill">Visa</span>
                                <span class="payment-badge-pill">Mastercard</span>
                                <span class="payment-badge-pill">Կանխիկ</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </form>

    <?php endif; ?>
</div>
