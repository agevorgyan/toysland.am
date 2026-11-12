<?php
/**
 * Order Details override for ToysLand
 *
 * @package ToysLand
 */

defined('ABSPATH') || exit;

// If on thank you page, thankyou.php template already handles complete presentation
if (is_wc_endpoint_url('order-received')) {
    return;
}

$order = wc_get_order($order_id);
if (!$order) {
    return;
}
?>

<div class="toysland-account-order-view" style="margin-top: 20px;">
    <?php wc_get_template('checkout/thankyou.php', array('order' => $order)); ?>
</div>

