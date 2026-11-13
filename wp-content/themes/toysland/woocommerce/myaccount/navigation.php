<?php
/**
 * My Account navigation for ToysLand
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

$current_user  = wp_get_current_user();
$display_name  = !empty($current_user->display_name) ? $current_user->display_name : $current_user->user_login;
$user_email    = $current_user->user_email;
$avatar_letter = !empty($display_name) ? mb_strtoupper(mb_substr($display_name, 0, 1, 'UTF-8'), 'UTF-8') : '<i class="fa-solid fa-user"></i>';

// Map endpoint to Font Awesome icons
$item_icons = [
    'dashboard'       => '<i class="fa-solid fa-house"></i>',
    'orders'          => '<i class="fa-solid fa-box-open"></i>',
    'edit-address'    => '<i class="fa-solid fa-location-dot"></i>',
    'edit-account'    => '<i class="fa-solid fa-gear"></i>',
    'customer-logout' => '<i class="fa-solid fa-right-from-bracket"></i>',
];

do_action('woocommerce_before_account_navigation');
?>

<nav class="woocommerce-MyAccount-navigation" aria-label="Հաշվի բաժիններ">
    
    <!-- User Profile Header Card -->
    <div class="account-user-profile-header">
        <div class="user-avatar-badge">
            <span class="avatar-initial"><?php echo $avatar_letter; ?></span>
        </div>
        <div class="user-info-text">
            <h3 class="user-name">Բարև, <?php echo esc_html($display_name); ?> <i class="fa-solid fa-hand" style="color:#f59e0b;font-size:14px;"></i></h3>
            <p class="user-email"><?php echo esc_html($user_email); ?></p>
        </div>
    </div>

    <!-- Navigation Menu Items -->
    <ul class="account-nav-list">
        <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : 
            $is_active = wc_is_current_account_menu_item($endpoint);
            $icon = $item_icons[$endpoint] ?? '<i class="fa-solid fa-star"></i>';
            $classes = wc_get_account_menu_item_classes($endpoint);
            if ($is_active && strpos($classes, 'is-active') === false) {
                $classes .= ' is-active';
            }
        ?>
            <li class="account-nav-item <?php echo esc_attr($classes); ?>">
                <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>" class="account-nav-link" <?php echo $is_active ? 'aria-current="page"' : ''; ?>>
                    <span class="nav-item-icon"><?php echo $icon; ?></span>
                    <span class="nav-item-label"><?php echo esc_html($label); ?></span>
                    <span class="nav-item-arrow"><i class="fa-solid fa-arrow-right"></i></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Quick Help Card -->
    <div class="account-sidebar-help">
        <div class="help-icon"><i class="fa-solid fa-comment-dots"></i></div>
        <div class="help-text">
            <strong>Օգնության կարի՞ք ունեք</strong>
            <p>Մեր սպասարկման թիմը սիրով կօգնի Ձեզ:</p>
            <a href="tel:+37410123456" class="help-phone-link"><i class="fa-solid fa-phone"></i> +374 (10) 12-34-56</a>
        </div>
    </div>

</nav>

<?php do_action('woocommerce_after_account_navigation'); ?>
