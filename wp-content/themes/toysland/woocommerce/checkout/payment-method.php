<?php
/**
 * Output a single payment method for ToysLand
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<li class="wc_payment_method payment_method_<?php echo esc_attr($gateway->id); ?> <?php echo $gateway->chosen ? 'is-chosen' : ''; ?>">
    <label for="payment_method_<?php echo esc_attr($gateway->id); ?>" class="payment-method-label">
        <input id="payment_method_<?php echo esc_attr($gateway->id); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr($gateway->id); ?>" <?php checked($gateway->chosen, true); ?> data-order_button_text="<?php echo esc_attr($gateway->order_button_text); ?>" />
        
        <span class="custom-radio-circle"></span>

        <span class="payment-method-info">
            <span class="payment-method-title">
                <?php if ($gateway->id === 'bacs') : ?>
                    <span class="method-icon"><i class="fa-solid fa-credit-card"></i></span>
                <?php else : ?>
                    <span class="method-icon"><i class="fa-solid fa-money-bill-wave"></i></span>
                <?php endif; ?>
                <strong><?php echo $gateway->get_title(); ?></strong>
            </span>

            <?php if ($gateway->id === 'bacs') : ?>
                <span class="payment-method-pills">
                    <span class="pay-pill">Idram</span>
                    <span class="pay-pill">Telcell</span>
                    <span class="pay-pill">ArCa</span>
                    <span class="pay-pill">Visa / Master</span>
                </span>
            <?php endif; ?>
        </span>
    </label>

    <?php if ($gateway->has_fields() || $gateway->get_description()) : ?>
        <div class="payment_box payment_method_<?php echo esc_attr($gateway->id); ?>" <?php if (!$gateway->chosen) : ?>style="display:none;"<?php endif; ?>>
            <?php $gateway->payment_fields(); ?>
        </div>
    <?php endif; ?>
</li>
