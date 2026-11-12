<?php
/**
 * View Order for ToysLand
 *
 * @package ToysLand
 */

defined('ABSPATH') || exit;

$notes       = $order->get_customer_order_notes();
$status_key  = $order->get_status();
$status_name = wc_get_order_status_name($status_key);
$date_placed = $order->get_date_created() ? $order->get_date_created()->date_i18n('d F Y, H:i') : '';
?>

<div class="account-view-order-section">
    <div class="view-order-nav-header">
        <a href="<?php echo esc_url(wc_get_endpoint_url('orders')); ?>" class="back-orders-btn">
            ← Վերադառնալ պատվերներին
        </a>
    </div>

    <div class="view-order-hero-banner">
        <div class="banner-main-info">
            <span class="order-id-badge">Պատվեր #<?php echo esc_html($order->get_order_number()); ?></span>
            <h2 class="view-order-title">Պատվերի մանրամասները</h2>
            <p class="order-placed-note">
                Գրանցվել է՝ <strong><?php echo esc_html($date_placed); ?></strong>:
            </p>
        </div>
        <div class="banner-status-pill status-<?php echo esc_attr($status_key); ?>">
            <span>Կարգավիճակ՝ <?php echo esc_html($status_name); ?></span>
        </div>
    </div>

    <?php if ($notes) : ?>
        <div class="order-updates-card">
            <h3 class="updates-heading">Պատվերի նորությունները</h3>
            <ol class="woocommerce-OrderUpdates commentlist notes order-updates-list">
                <?php foreach ($notes as $note) : ?>
                    <li class="woocommerce-OrderUpdate comment note update-item">
                        <div class="update-content">
                            <span class="update-date"><?php echo esc_html(date_i18n('d M Y, H:i', strtotime($note->comment_date))); ?></span>
                            <div class="update-text"><?php echo wp_kses_post(wpautop(wptexturize($note->comment_content))); ?></div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    <?php endif; ?>

    <div class="view-order-details-wrapper">
        <?php do_action('woocommerce_view_order', $order_id); ?>
    </div>
</div>

