<?php
/**
 * Lost password confirmation for ToysLand
 *
 * @package ToysLand
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_lost_password_confirmation_message');
?>

<div class="toysland-lost-password-wrapper">
    <div class="lost-pwd-card confirmation-card">
        <div class="lock-icon-badge success"><i class="fa-solid fa-envelope-circle-check"></i></div>
        <h2 class="lost-pwd-title">Հղումն ուղարկված է</h2>
        <p class="lost-pwd-subtitle">
            Գաղտնաբառը վերականգնելու հրահանգներով նամակն ուղարկվել է Ձեր էլ. հասցեին: Խնդրում ենք ստուգել մուտքային նամակները (նաև Spam / Թափոն բաժինը):
        </p>
        <div class="back-to-login">
            <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="back-login-btn">
                <i class="fa-solid fa-arrow-left"></i> Վերադառնալ մուտքի էջ
            </a>
        </div>
    </div>
</div>

<?php
do_action('woocommerce_after_lost_password_confirmation_message');
