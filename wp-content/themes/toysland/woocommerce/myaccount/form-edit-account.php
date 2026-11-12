<?php
/**
 * Edit account form for ToysLand
 *
 * @package ToysLand
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_edit_account_form');
?>

<div class="account-edit-details-section">
    <div class="edit-details-header">
        <h2 class="edit-details-heading">Հաշվի տվյալներ</h2>
        <p class="edit-details-subheading">Կառավարեք Ձեր անձնական տվյալները և թարմացրեք գաղտնաբառը:</p>
    </div>

    <form class="woocommerce-EditAccountForm edit-account toysland-styled-form" action="" method="post" <?php do_action('woocommerce_edit_account_form_tag'); ?>>

        <?php do_action('woocommerce_edit_account_form_start'); ?>

        <div class="form-row-2col">
            <div class="auth-form-group">
                <label for="account_first_name" class="auth-label">
                    Անուն <span class="required">*</span>
                </label>
                <div class="auth-input-wrap">
                    <span class="input-icon">👤</span>
                    <input type="text" class="woocommerce-Input input-text auth-input" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr($user->first_name); ?>" required aria-required="true" />
                </div>
            </div>

            <div class="auth-form-group">
                <label for="account_last_name" class="auth-label">
                    Ազգանուն <span class="required">*</span>
                </label>
                <div class="auth-input-wrap">
                    <span class="input-icon">👤</span>
                    <input type="text" class="woocommerce-Input input-text auth-input" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr($user->last_name); ?>" required aria-required="true" />
                </div>
            </div>
        </div>

        <div class="auth-form-group">
            <label for="account_display_name" class="auth-label">
                Ցուցադրվող անուն <span class="required">*</span>
            </label>
            <div class="auth-input-wrap">
                <span class="input-icon">🏷️</span>
                <input type="text" class="woocommerce-Input input-text auth-input" name="account_display_name" id="account_display_name" value="<?php echo esc_attr($user->display_name); ?>" required aria-required="true" />
            </div>
            <small class="field-hint">Այսպես է Ձեր անունը ցուցադրվելու անձնական էջում և կարծիքներում:</small>
        </div>

        <div class="auth-form-group">
            <label for="account_email" class="auth-label">
                Էլ. հասցե <span class="required">*</span>
            </label>
            <div class="auth-input-wrap">
                <span class="input-icon">✉️</span>
                <input type="email" class="woocommerce-Input input-text auth-input" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr($user->user_email); ?>" required aria-required="true" />
            </div>
        </div>

        <?php do_action('woocommerce_edit_account_form_fields'); ?>

        <!-- Password Change Card -->
        <div class="password-change-card">
            <h3 class="pwd-card-title">🔒 Փոխել գաղտնաբառը</h3>
            <p class="pwd-card-desc">Թողեք դաշտերը դատարկ, եթե չեք ցանկանում փոխել ընթացիկ գաղտնաբառը:</p>

            <div class="auth-form-group">
                <label for="password_current" class="auth-label">Ընթացիկ գաղտնաբառ</label>
                <div class="auth-input-wrap">
                    <span class="input-icon">🔑</span>
                    <input type="password" class="woocommerce-Input input-text auth-input js-password-input" name="password_current" id="password_current" autocomplete="current-password" placeholder="Մուտքագրեք ընթացիկ գաղտնաբառը" />
                    <button type="button" class="password-toggle-btn js-toggle-pwd" aria-label="Ցուցադրել գաղտնաբառը">
                        <span class="pwd-eye-open">👁️</span>
                        <span class="pwd-eye-closed" style="display:none;">🙈</span>
                    </button>
                </div>
            </div>

            <div class="form-row-2col">
                <div class="auth-form-group">
                    <label for="password_1" class="auth-label">Նոր գաղտնաբառ</label>
                    <div class="auth-input-wrap">
                        <span class="input-icon">🔒</span>
                        <input type="password" class="woocommerce-Input input-text auth-input js-password-input" name="password_1" id="password_1" autocomplete="new-password" placeholder="Առնվազն 6 նիշ" />
                        <button type="button" class="password-toggle-btn js-toggle-pwd" aria-label="Ցուցադրել գաղտնաբառը">
                            <span class="pwd-eye-open">👁️</span>
                            <span class="pwd-eye-closed" style="display:none;">🙈</span>
                        </button>
                    </div>
                </div>

                <div class="auth-form-group">
                    <label for="password_2" class="auth-label">Կրկնել նոր գաղտնաբառը</label>
                    <div class="auth-input-wrap">
                        <span class="input-icon">🔒</span>
                        <input type="password" class="woocommerce-Input input-text auth-input js-password-input" name="password_2" id="password_2" autocomplete="new-password" placeholder="Կրկնեք նոր գաղտնաբառը" />
                        <button type="button" class="password-toggle-btn js-toggle-pwd" aria-label="Ցուցադրել գաղտնաբառը">
                            <span class="pwd-eye-open">👁️</span>
                            <span class="pwd-eye-closed" style="display:none;">🙈</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <?php do_action('woocommerce_edit_account_form'); ?>

        <div class="edit-account-actions">
            <?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
            <button type="submit" class="save-changes-btn" name="save_account_details" value="Պահպանել">
                <span>Պահպանել փոփոխությունները ✨</span>
            </button>
            <input type="hidden" name="action" value="save_account_details" />
        </div>

        <?php do_action('woocommerce_edit_account_form_end'); ?>
    </form>
</div>

<?php do_action('woocommerce_after_edit_account_form'); ?>

