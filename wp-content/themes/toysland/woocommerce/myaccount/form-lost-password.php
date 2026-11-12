<?php
/**
 * Lost password form for ToysLand
 *
 * @package ToysLand
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_lost_password_form');
?>

<div class="toysland-lost-password-wrapper">
    <div class="lost-pwd-card">
        
        <div class="lost-pwd-header">
            <div class="lock-icon-badge">🔑</div>
            <h2 class="lost-pwd-title">Վերականգնել գաղտնաբառը</h2>
            <p class="lost-pwd-subtitle">
                Մուտքագրեք Ձեր էլ. հասցեն կամ օգտանունը: Մենք կուղարկենք հղում, որի միջոցով կկարողանաք ստեղծել նոր գաղտնաբառ:
            </p>
        </div>

        <form method="post" class="woocommerce-ResetPassword lost_reset_password lost-pwd-form">
            
            <div class="auth-form-group">
                <label for="user_login" class="auth-label">
                    Մուտքանուն կամ էլ. հասցե <span class="required">*</span>
                </label>
                <div class="auth-input-wrap">
                    <span class="input-icon">✉️</span>
                    <input class="woocommerce-Input woocommerce-Input--text input-text auth-input" 
                           type="text" 
                           name="user_login" 
                           id="user_login" 
                           autocomplete="username" 
                           placeholder="օրինակ՝ name@example.am"
                           required 
                           aria-required="true" />
                </div>
            </div>

            <?php do_action('woocommerce_lostpassword_form'); ?>

            <div class="lost-pwd-actions">
                <input type="hidden" name="wc_reset_password" value="true" />
                <button type="submit" class="lost-pwd-submit-btn" value="Վերականգնել">
                    <span>Ուղարկել հղումը ✉️</span>
                </button>
            </div>

            <?php wp_nonce_field('lost_password', 'woocommerce-lost-password-nonce'); ?>

            <div class="back-to-login">
                <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="back-login-link">
                    ← Վերադառնալ մուտքի էջ
                </a>
            </div>

        </form>

    </div>
</div>

<?php
do_action('woocommerce_after_lost_password_form');

