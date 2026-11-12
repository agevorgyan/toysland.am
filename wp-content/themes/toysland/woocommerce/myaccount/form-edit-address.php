<?php
/**
 * Edit address form for ToysLand
 *
 * @package ToysLand
 */

defined('ABSPATH') || exit;

$page_title = ('billing' === $load_address) ? 'Վճարման հասցե' : 'Առաքման հասցե';

do_action('woocommerce_before_edit_account_address_form'); ?>

<?php if (!$load_address) : ?>
    <?php wc_get_template('myaccount/my-address.php'); ?>
<?php else : ?>

    <div class="account-edit-address-section">
        <div class="edit-address-header">
            <h2 class="edit-address-heading">✏️ Խմբագրել <?php echo esc_html(mb_strtolower($page_title, 'UTF-8')); ?>ն</h2>
            <p class="edit-address-subheading">Լրացրեք հասցեի տվյալները՝ պատվերները ճիշտ վայր առաքելու համար:</p>
        </div>

        <form method="post" class="toysland-address-form" novalidate>

            <div class="woocommerce-address-fields">
                <?php do_action("woocommerce_before_edit_address_form_{$load_address}"); ?>

                <div class="woocommerce-address-fields__field-wrapper">
                    <?php
                    foreach ($address as $key => $field) {
                        woocommerce_form_field($key, $field, wc_get_post_data_by_key($key, $field['value']));
                    }
                    ?>
                </div>

                <?php do_action("woocommerce_after_edit_address_form_{$load_address}"); ?>

                <div class="edit-address-actions">
                    <?php wp_nonce_field('woocommerce-edit_address', 'woocommerce-edit-address-nonce'); ?>
                    <button type="submit" class="save-changes-btn" name="save_address" value="Պահպանել">
                        <span>Պահպանել հասցեն 💾</span>
                    </button>
                    <input type="hidden" name="action" value="edit_address" />
                    <a href="<?php echo esc_url(wc_get_endpoint_url('edit-address')); ?>" class="cancel-link">
                        Չեղարկել
                    </a>
                </div>
            </div>

        </form>
    </div>

<?php endif; ?>

<?php do_action('woocommerce_after_edit_account_address_form'); ?>

