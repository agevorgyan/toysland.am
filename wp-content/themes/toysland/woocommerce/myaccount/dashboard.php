<?php
/**
 * My Account Dashboard for ToysLand
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

$current_user = wp_get_current_user();
$display_name = !empty($current_user->display_name) ? $current_user->display_name : $current_user->user_login;

// Fetch customer orders counts
$customer_id = get_current_user_id();
$all_orders = wc_get_orders([
    'customer' => $customer_id,
    'limit'    => -1,
    'return'   => 'ids',
]);
$total_orders = is_array($all_orders) ? count($all_orders) : 0;

$processing_orders_arr = wc_get_orders([
    'customer' => $customer_id,
    'status'   => ['processing', 'on-hold', 'pending'],
    'limit'    => -1,
    'return'   => 'ids',
]);
$processing_orders = is_array($processing_orders_arr) ? count($processing_orders_arr) : 0;

$completed_orders_arr = wc_get_orders([
    'customer' => $customer_id,
    'status'   => ['completed'],
    'limit'    => -1,
    'return'   => 'ids',
]);
$completed_orders = is_array($completed_orders_arr) ? count($completed_orders_arr) : 0;
?>

<div class="account-dashboard-content">
    
    <!-- Welcome Greeting Hero -->
    <div class="dashboard-hero-banner">
        <div class="hero-text-wrap">
            <span class="hero-badge">🧸 Բարի գալուստ Ձեր անձնական էջ</span>
            <h2 class="hero-title">Ողջույն, <?php echo esc_html($display_name); ?>! 👋</h2>
            <p class="hero-desc">Այստեղ կարող եք արագ հետևել Ձեր պատվերների կարգավիճակին, կառավարել առաքման հասցեները և թարմացնել անձնական տվյալները:</p>
        </div>
        <div class="hero-cta-wrap">
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="hero-shop-btn">
                <span>🛍️ Գնալ խանութ</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards Grid -->
    <div class="dashboard-stats-grid">
        
        <div class="stat-card">
            <div class="stat-icon-wrap stat-icon-blue">📦</div>
            <div class="stat-content">
                <span class="stat-value"><?php echo esc_html($total_orders); ?></span>
                <span class="stat-label">Ընդհանուր պատվերներ</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrap stat-icon-orange">⏳</div>
            <div class="stat-content">
                <span class="stat-value"><?php echo esc_html($processing_orders); ?></span>
                <span class="stat-label">Ընթացքի մեջ</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrap stat-icon-green">✅</div>
            <div class="stat-content">
                <span class="stat-value"><?php echo esc_html($completed_orders); ?></span>
                <span class="stat-label">Կատարված պատվերներ</span>
            </div>
        </div>

    </div>

    <!-- Quick Actions Shortcuts -->
    <div class="dashboard-shortcuts-section">
        <h3 class="section-title">Արագ գործողություններ</h3>
        
        <div class="shortcuts-grid">
            
            <a href="<?php echo esc_url(wc_get_endpoint_url('orders')); ?>" class="shortcut-card">
                <div class="shortcut-icon">📦</div>
                <div class="shortcut-body">
                    <h4 class="shortcut-title">Իմ պատվերները</h4>
                    <p class="shortcut-desc">Դիտել պատվերների պատմությունն ու առաքման ընթացքը</p>
                </div>
                <div class="shortcut-action">→</div>
            </a>

            <a href="<?php echo esc_url(wc_get_endpoint_url('edit-address')); ?>" class="shortcut-card">
                <div class="shortcut-icon">📍</div>
                <div class="shortcut-body">
                    <h4 class="shortcut-title">Առաքման հասցեներ</h4>
                    <p class="shortcut-desc">Կառավարել գրանցված հասցեներն արագ գնումների համար</p>
                </div>
                <div class="shortcut-action">→</div>
            </a>

            <a href="<?php echo esc_url(wc_get_endpoint_url('edit-account')); ?>" class="shortcut-card">
                <div class="shortcut-icon">⚙️</div>
                <div class="shortcut-body">
                    <h4 class="shortcut-title">Հաշվի տվյալներ</h4>
                    <p class="shortcut-desc">Փոփոխել անունը, էլ. հասցեն կամ գաղտնաբառը</p>
                </div>
                <div class="shortcut-action">→</div>
            </a>

            <a href="<?php echo esc_url(home_url('/wishlist/')); ?>" class="shortcut-card">
                <div class="shortcut-icon">❤️</div>
                <div class="shortcut-body">
                    <h4 class="shortcut-title">Ընտրյալների ցանկ</h4>
                    <p class="shortcut-desc">Դիտել պահպանված խաղալիքները</p>
                </div>
                <div class="shortcut-action">→</div>
            </a>

        </div>
    </div>

</div>

<?php
do_action('woocommerce_account_dashboard');

