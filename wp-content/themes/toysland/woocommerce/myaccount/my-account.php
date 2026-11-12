<?php
/**
 * My Account page
 *
 * @package ToysLand
 */

defined('ABSPATH') || exit;
?>

<div class="toysland-myaccount-wrapper">
    <div class="myaccount-layout-grid">
        <aside class="myaccount-sidebar-col">
            <?php do_action('woocommerce_account_navigation'); ?>
        </aside>
        
        <main class="myaccount-main-col">
            <div class="myaccount-content-card">
                <?php do_action('woocommerce_account_content'); ?>
            </div>
        </main>
    </div>
</div>

