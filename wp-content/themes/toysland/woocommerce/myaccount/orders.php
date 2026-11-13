<?php
/**
 * Orders template for ToysLand
 *
 * @package ToysLand
 */

defined('ABSPATH') || exit;

$has_orders = !empty($has_orders);

do_action('woocommerce_before_account_orders', $has_orders);

// Armenian status mappings with Font Awesome icons
$status_map = [
    'completed'  => ['label' => 'Կատարված', 'class' => 'status-completed', 'icon' => '<i class="fa-solid fa-circle-check"></i>'],
    'processing' => ['label' => 'Մշակվում է', 'class' => 'status-processing', 'icon' => '<i class="fa-solid fa-hourglass-half"></i>'],
    'on-hold'    => ['label' => 'Սպասման մեջ', 'class' => 'status-onhold', 'icon' => '<i class="fa-solid fa-circle-pause"></i>'],
    'pending'    => ['label' => 'Սպասում է վճարման', 'class' => 'status-pending', 'icon' => '<i class="fa-solid fa-credit-card"></i>'],
    'cancelled'  => ['label' => 'Չեղարկված', 'class' => 'status-cancelled', 'icon' => '<i class="fa-solid fa-circle-xmark"></i>'],
    'refunded'   => ['label' => 'Վերադարձված', 'class' => 'status-refunded', 'icon' => '<i class="fa-solid fa-rotate-left"></i>'],
    'failed'     => ['label' => 'Չհաջողված', 'class' => 'status-failed', 'icon' => '<i class="fa-solid fa-triangle-exclamation"></i>'],
];
?>

<div class="account-orders-section">
    <div class="orders-section-header">
        <h2 class="orders-heading">Իմ պատվերները</h2>
        <p class="orders-subheading">Ձեր կատարած բոլոր գնումների պատմությունը և առաքման կարգավիճակը</p>
    </div>

    <?php if ($has_orders) : ?>
        
        <div class="toysland-orders-list">
            <?php foreach ($customer_orders->orders as $customer_order) :
                $order       = wc_get_order($customer_order);
                $item_count  = $order->get_item_count() - $order->get_item_count_refunded();
                $status_key  = $order->get_status();
                $status_info = $status_map[$status_key] ?? ['label' => wc_get_order_status_name($status_key), 'class' => 'status-default', 'icon' => '<i class="fa-solid fa-box-open"></i>'];
                $order_date  = $order->get_date_created();
                $date_str    = $order_date ? $order_date->date_i18n('d M Y, H:i') : '';
            ?>
                <div class="order-card-item">
                    <div class="order-card-header">
                        <div class="order-meta-info">
                            <span class="order-number-tag">Պատվեր #<?php echo esc_html($order->get_order_number()); ?></span>
                            <span class="order-date-text"><i class="fa-solid fa-calendar-days"></i> <?php echo esc_html($date_str); ?></span>
                        </div>
                        <div class="order-status-badge <?php echo esc_attr($status_info['class']); ?>">
                            <span class="status-icon"><?php echo $status_info['icon']; ?></span>
                            <span class="status-text"><?php echo esc_html($status_info['label']); ?></span>
                        </div>
                    </div>

                    <div class="order-card-body">
                        <!-- Order Items Preview -->
                        <div class="order-items-preview">
                            <span class="items-count-badge"><i class="fa-solid fa-box-open"></i> <?php echo sprintf(_n('%d ապրանք', '%d ապրանք', $item_count, 'toysland'), $item_count); ?></span>
                            <div class="order-items-names-list">
                                <?php 
                                $items = $order->get_items();
                                $item_names = [];
                                foreach (array_slice($items, 0, 3) as $item) {
                                    $item_names[] = esc_html($item->get_name()) . ' × ' . $item->get_quantity();
                                }
                                echo implode(' • ', $item_names);
                                if (count($items) > 3) {
                                    echo ' • <span class="more-items">+ ևս ' . (count($items) - 3) . '</span>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Order Total Price -->
                        <div class="order-total-price">
                            <span class="price-label">Ընդհանուր՝</span>
                            <span class="price-val"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></span>
                        </div>
                    </div>

                    <div class="order-card-footer">
                        <div class="order-payment-method">
                            <span class="payment-icon"><i class="fa-solid fa-credit-card"></i></span>
                            <span><?php echo esc_html($order->get_payment_method_title() ?: 'Առցանց / Կանխիկ'); ?></span>
                        </div>
                        <div class="order-action-links">
                            <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="view-order-btn">
                                <span>Դիտել պատվերը</span>
                                <span class="btn-arrow"><i class="fa-solid fa-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (1 < $customer_orders->max_num_pages) : ?>
            <div class="toysland-pagination">
                <?php if (1 !== $current_page) : ?>
                    <a class="page-nav prev" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page - 1)); ?>">← Նախորդ</a>
                <?php endif; ?>
                <span class="page-current">Էջ <?php echo esc_html($current_page); ?> / <?php echo esc_html($customer_orders->max_num_pages); ?></span>
                <?php if (intval($customer_orders->max_num_pages) !== $current_page) : ?>
                    <a class="page-nav next" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page + 1)); ?>">Հաջորդ →</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    <?php else : ?>
        
        <div class="empty-orders-card">
            <div class="empty-orders-icon"><i class="fa-solid fa-box-open" style="color:#cbd5e1;font-size:52px;"></i></div>
            <h3 class="empty-orders-title">Դուք դեռ չունեք կատարված պատվերներ</h3>
            <p class="empty-orders-desc">Ձեր բոլոր ապագա պատվերները կհայտնվեն այստեղ: Ժամանակն է բացահայտելու մեր կախարդական խաղալիքների տեսականին:</p>
            <a href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>" class="shop-now-btn">
                <span><i class="fa-solid fa-bag-shopping"></i> Գնալ խանութ</span>
            </a>
        </div>

    <?php endif; ?>
</div>

<?php do_action('woocommerce_after_account_orders', $has_orders); ?>
