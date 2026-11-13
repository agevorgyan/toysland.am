<?php
/**
 * My Addresses for ToysLand
 *
 * @package ToysLand
 */

defined('ABSPATH') || exit;

$customer_id = get_current_user_id();

$get_addresses = apply_filters(
    'woocommerce_my_account_get_addresses',
    [
        'billing'  => 'Վճարման հասցե',
        'shipping' => 'Առաքման հասցե',
    ],
    $customer_id
);
?>

<div class="account-addresses-section">
    <div class="addresses-section-header">
        <h2 class="addresses-heading">Հասցեների կառավարում</h2>
        <p class="addresses-subheading">Ստորև նշված հասցեները լռելյայն կօգտագործվեն պատվերների ձևակերպման ժամանակ:</p>
    </div>

    <div class="addresses-grid">
        <?php foreach ($get_addresses as $name => $address_title) :
            $address = wc_get_account_formatted_address($name);
            $icon = ($name === 'shipping') ? '<i class="fa-solid fa-truck-fast"></i>' : '<i class="fa-solid fa-credit-card"></i>';
        ?>
            <div class="address-card">
                <div class="address-card-header">
                    <div class="address-type">
                        <span class="addr-icon"><?php echo $icon; // phpcs:ignore ?></span>
                        <h3 class="addr-title"><?php echo esc_html($address_title); ?></h3>
                    </div>
                    <a href="<?php echo esc_url(wc_get_endpoint_url('edit-address', $name)); ?>" class="edit-addr-btn">
                        <span><i class="fa-solid fa-pen-to-square"></i> Խմբագրել</span>
                    </a>
                </div>
                <div class="address-card-body">
                    <?php if ($address) : ?>
                        <div class="address-formatted-text">
                            <?php echo wp_kses_post($address); ?>
                        </div>
                    <?php else : ?>
                        <div class="address-empty-text">
                            <span class="empty-hint">Դուք դեռ չեք նշել այս հասցեն:</span>
                            <a href="<?php echo esc_url(wc_get_endpoint_url('edit-address', $name)); ?>" class="add-addr-inline-link">+ Ավելացնել հասցե</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

