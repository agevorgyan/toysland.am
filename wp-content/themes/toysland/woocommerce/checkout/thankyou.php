<?php
/**
 * Thankyou page override for ToysLand
 *
 * Modern high-converting Order Received template
 *
 * @package ToysLand
 * @var WC_Order $order
 */

defined('ABSPATH') || exit;

// Remove legacy unstyled table if still hooked
remove_action('woocommerce_thankyou', 'woocommerce_order_details_table', 10);
?>

<div class="toysland-thankyou-page">
    <?php if ($order) : ?>
        
        <?php if ($order->has_status('failed')) : ?>
            <!-- FAILED ORDER STATE -->
            <div class="thankyou-hero-card is-failed">
                <div class="hero-icon-box"><i class="fa-solid fa-circle-xmark"></i></div>
                <h1 class="hero-title">Ցավոք, պատվերը չհաջողվեց հաստատել</h1>
                <p class="hero-subtitle">
                    Գործարքը մերժվել է բանկի կամ վճարային համակարգի կողմից: Խնդրում ենք փորձել կրկին կամ ընտրել այլ վճարման եղանակ:
                </p>
                <div class="hero-actions">
                    <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="cart-checkout-btn">
                        Վճարել կրկին
                    </a>
                </div>
            </div>
        <?php else : ?>
            <!-- SUCCESSFUL ORDER CELEBRATION HERO -->
            <div class="thankyou-hero-card">
                <div class="hero-celebration-wrap">
                    <div class="hero-icon-circle">
                        <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <span class="hero-sparkle-left"><i class="fa-solid fa-wand-magic-sparkles"></i></span>
                    <span class="hero-sparkle-right"><i class="fa-solid fa-gift"></i></span>
                </div>

                <div class="hero-status-pill">
                    <span class="status-dot"></span>
                    <span>Պատվերն ընդունված է / Պատրաստվում է առաքման</span>
                </div>

                <h1 class="hero-title">Շնորհակալությո՜ւն, Ձեր պատվերն ընդունված է:</h1>
                <p class="hero-subtitle">
                    Պատվերի համար՝ <strong class="order-num-highlight">#<?php echo esc_html($order->get_order_number()); ?></strong>: 
                    Մեր մասնագետը շուտով կկապնվի Ձեզ հետ՝ առաքման մանրամասները ճշտելու համար:
                </p>
            </div>

            <!-- 4 Order Overview Tiles -->
            <div class="thankyou-overview-grid">
                <!-- Tile 1: Order Number -->
                <div class="overview-tile">
                    <div class="tile-icon"><i class="fa-solid fa-hashtag"></i></div>
                    <div class="tile-content">
                        <span class="tile-label">Պատվերի համար</span>
                        <strong class="tile-value">#<?php echo esc_html($order->get_order_number()); ?></strong>
                    </div>
                </div>

                <!-- Tile 2: Date -->
                <div class="overview-tile">
                    <div class="tile-icon"><i class="fa-solid fa-calendar-days"></i></div>
                    <div class="tile-content">
                        <span class="tile-label">Ամսաթիվ</span>
                        <strong class="tile-value">
                            <?php
                            $months = [
                                1 => 'Հունվարի', 2 => 'Փետրվարի', 3 => 'Մարտի', 4 => 'Ապրիլի',
                                5 => 'Մայիսի', 6 => 'Հունիսի', 7 => 'Հուլիսի', 8 => 'Օգոստոսի',
                                9 => 'Սեպտեմբերի', 10 => 'Հոկտեմբերի', 11 => 'Նոյեմբերի', 12 => 'Դեկտեմբերի'
                            ];
                            $date_obj = $order->get_date_created();
                            if ($date_obj) {
                                $ts = $date_obj->getTimestamp();
                                echo date('j', $ts) . ' ' . $months[(int)date('n', $ts)] . ' ' . date('Y', $ts);
                            } else {
                                echo esc_html(date('d.m.Y'));
                            }
                            ?>
                        </strong>
                    </div>
                </div>

                <!-- Tile 3: Payment Method -->
                <div class="overview-tile">
                    <div class="tile-icon"><i class="fa-solid fa-credit-card"></i></div>
                    <div class="tile-content">
                        <span class="tile-label">Վճարման եղանակ</span>
                        <strong class="tile-value"><?php echo wp_kses_post($order->get_payment_method_title() ?: 'Կանխիկ'); ?></strong>
                    </div>
                </div>

                <!-- Tile 4: Total -->
                <div class="overview-tile tile-highlight">
                    <div class="tile-icon"><i class="fa-solid fa-wallet"></i></div>
                    <div class="tile-content">
                        <span class="tile-label">Ընդհանուր գումար</span>
                        <strong class="tile-value tile-total-price"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></strong>
                    </div>
                </div>
            </div>

            <!-- Main Content 2-Column Grid -->
            <div class="thankyou-main-grid">
                
                <!-- Left: Ordered Products Card -->
                <div class="thankyou-card products-card">
                    <div class="thankyou-card-header">
                        <div class="header-icon-box"><i class="fa-solid fa-bag-shopping"></i></div>
                        <div class="header-title-box">
                            <h2 class="card-title">Պատվիրված ապրանքներ</h2>
                            <span class="card-badge"><?php echo esc_html($order->get_item_count()); ?> ապրանք</span>
                        </div>
                    </div>

                    <!-- Products List -->
                    <div class="thankyou-items-list">
                        <?php
                        foreach ($order->get_items() as $item_id => $item) :
                            $product = $item->get_product();
                            $name    = $item->get_name();
                            $qty     = $item->get_quantity();
                            $total   = $order->get_formatted_line_subtotal($item);
                            $img     = $product ? toysland_get_product_image_url($product) : '';
                            $url     = $product ? $product->get_permalink() : '';
                            $terms   = $product ? get_the_terms($product->get_id(), 'product_cat') : [];
                            $cat     = (!empty($terms) && !is_wp_error($terms)) ? $terms[0]->name : '';
                        ?>
                            <div class="thankyou-item-row">
                                <div class="item-thumb-box">
                                    <?php if ($url) : ?>
                                        <a href="<?php echo esc_url($url); ?>">
                                            <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($name); ?>" class="item-thumb-img">
                                        </a>
                                    <?php else : ?>
                                        <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($name); ?>" class="item-thumb-img">
                                    <?php endif; ?>
                                    <span class="item-qty-tag">× <?php echo esc_html($qty); ?></span>
                                </div>
                                <div class="item-info-box">
                                    <?php if ($cat) : ?>
                                        <span class="item-category"><?php echo esc_html($cat); ?></span>
                                    <?php endif; ?>
                                    <?php if ($url) : ?>
                                        <a href="<?php echo esc_url($url); ?>" class="item-name"><?php echo esc_html($name); ?></a>
                                    <?php else : ?>
                                        <span class="item-name"><?php echo esc_html($name); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="item-price-box">
                                    <span class="item-price"><?php echo wp_kses_post($total); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Totals Breakdown -->
                    <div class="thankyou-totals-box">
                        <div class="total-row">
                            <span class="row-label">Ապրանքների գումար</span>
                            <span class="row-value"><?php echo wp_kses_post(toysland_price($order->get_subtotal())); ?></span>
                        </div>

                        <div class="total-row">
                            <span class="row-label">Առաքում (Երևանում 1 աշխ. օր)</span>
                            <span class="row-value">
                                <?php
                                $shipping_cost = floatval($order->get_shipping_total());
                                if ($shipping_cost <= 0) {
                                    echo '<span class="shipping-free-pill">Անվճար</span>';
                                } else {
                                    echo esc_html(toysland_price($shipping_cost));
                                }
                                ?>
                            </span>
                        </div>

                        <?php if ($order->get_total_discount() > 0) : ?>
                            <div class="total-row discount-row">
                                <span class="row-label">Զեղչ</span>
                                <span class="row-value">-<?php echo wp_kses_post(toysland_price($order->get_total_discount())); ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="total-divider"></div>

                        <div class="total-row grand-total-row">
                            <span class="row-label">Ընդհանուր վճարման ենթակա</span>
                            <span class="row-value grand-total-price"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></span>
                        </div>
                    </div>

                </div>

                <!-- Right: Delivery Details & Quick Help -->
                <div class="thankyou-sidebar-column">
                    
                    <!-- Customer & Delivery Card -->
                    <div class="thankyou-card delivery-info-card">
                        <div class="thankyou-card-header">
                            <div class="header-icon-box"><i class="fa-solid fa-location-dot"></i></div>
                            <div class="header-title-box">
                                <h2 class="card-title">Առաքման տվյալներ</h2>
                            </div>
                        </div>

                        <div class="delivery-details-list">
                            <?php if ($order->get_billing_first_name()) : ?>
                                <div class="detail-row">
                                    <span class="detail-icon"><i class="fa-solid fa-user"></i></span>
                                    <div class="detail-text">
                                        <span class="detail-label">Ստացող</span>
                                        <strong class="detail-val"><?php echo esc_html($order->get_billing_first_name()); ?></strong>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($order->get_billing_phone()) : ?>
                                <div class="detail-row">
                                    <span class="detail-icon"><i class="fa-solid fa-phone"></i></span>
                                    <div class="detail-text">
                                        <span class="detail-label">Հեռախոսահամար</span>
                                        <strong class="detail-val"><?php echo esc_html($order->get_billing_phone()); ?></strong>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($order->get_billing_email()) : ?>
                                <div class="detail-row">
                                    <span class="detail-icon"><i class="fa-solid fa-envelope"></i></span>
                                    <div class="detail-text">
                                        <span class="detail-label">Էլ. հասցե</span>
                                        <strong class="detail-val"><?php echo esc_html($order->get_billing_email()); ?></strong>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($order->get_billing_address_1()) : ?>
                                <div class="detail-row">
                                    <span class="detail-icon"><i class="fa-solid fa-house"></i></span>
                                    <div class="detail-text">
                                        <span class="detail-label">Առաքման հասցե</span>
                                        <strong class="detail-val"><?php echo esc_html($order->get_billing_address_1()); ?></strong>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($order->get_billing_postcode()) : ?>
                                <div class="detail-row">
                                    <span class="detail-icon"><i class="fa-solid fa-signs-post"></i></span>
                                    <div class="detail-text">
                                        <span class="detail-label">Փոստային դասիչ</span>
                                        <strong class="detail-val"><?php echo esc_html($order->get_billing_postcode()); ?></strong>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($order->get_customer_note()) : ?>
                                <div class="detail-row notes-row">
                                    <span class="detail-icon"><i class="fa-solid fa-clipboard-check"></i></span>
                                    <div class="detail-text">
                                        <span class="detail-label">Նշումներ առաքչի համար</span>
                                        <p class="detail-val note-content"><?php echo esc_html($order->get_customer_note()); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Need Help & Support Card -->
                    <div class="thankyou-card support-card">
                        <div class="support-content">
                            <span class="support-badge"><i class="fa-solid fa-comment-dots"></i> Օգնությո՞ւն է պետք</span>
                            <h3 class="support-title">Հարցերի դեպքում մենք կողքիդ ենք</h3>
                            <p class="support-desc">Մեր թիմը սիրով կպատասխանի Ձեր ցանկացած հարցին:</p>
                            <div class="support-contacts">
                                <a href="tel:+37410123456" class="support-contact-item">
                                    <span class="contact-icon"><i class="fa-solid fa-phone"></i></span>
                                    <span>+374 (10) 12-34-56</span>
                                </a>
                                <a href="mailto:info@toysland.am" class="support-contact-item">
                                    <span class="contact-icon"><i class="fa-solid fa-envelope"></i></span>
                                    <span>info@toysland.am</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Card -->
                    <div class="thankyou-actions-box">
                        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="cart-checkout-btn">
                            <span>Շարունակել գնումները</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </a>
                        <button type="button" onclick="window.print()" class="thankyou-print-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                            <span>Տպել անդորրագիրը</span>
                        </button>
                    </div>

                </div>

            </div>

        <?php endif; ?>

    <?php else : ?>
        <p class="woocommerce-notice woocommerce-notice--info woocommerce-info">
            Շնորհակալություն: Ձեր պատվերն ընդունված է:
        </p>
    <?php endif; ?>
</div>

