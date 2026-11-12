<?php
/**
 * Main Footer Template Part
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

$logo_url = get_template_directory_uri() . '/assets/images/logo.png';
?>
<footer class="toysland-main-footer" role="contentinfo">
    <div class="container">
        <div class="footer-grid">
            <!-- 1. Brand Column -->
            <div class="footer-brand-col">
                <img src="<?php echo esc_url($logo_url); ?>" alt="ToysLand" class="footer-logo">
                <p class="footer-about-text">
                    ToysLand-ը մանկական ժպիտների, ապահով խաղերի և երևակայության կախարդական աշխարհն է: Մենք առաջարկում ենք միջազգային առաջատար ապրանքանիշերի սերտիֆիկացված և անվտանգ խաղալիքներ:
                </p>
                <div class="footer-social-links">
                    <a href="https://instagram.com" target="_blank" rel="noopener" class="social-icon-btn" aria-label="Instagram">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                    <a href="https://facebook.com" target="_blank" rel="noopener" class="social-icon-btn" aria-label="Facebook">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    </a>
                    <a href="https://tiktok.com" target="_blank" rel="noopener" class="social-icon-btn" aria-label="TikTok">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"/></svg>
                    </a>
                </div>
            </div>

            <!-- 2. Customer Care -->
            <div>
                <h4 class="footer-col-title">Հաճախորդներին</h4>
                <ul class="footer-nav-list">
                    <li><a href="<?php echo esc_url(home_url('/delivery/')); ?>">Առաքում և վճարում</a></li>
                    <li><a href="<?php echo esc_url(home_url('/returns/')); ?>">Վերադարձ և երաշխիք</a></li>
                    <li><a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">Իմ հաշիվը</a></li>
                    <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Գաղտնիության քաղաքականություն</a></li>
                    <li><a href="<?php echo esc_url(home_url('/terms/')); ?>">Օգտագործման պայմաններ</a></li>
                </ul>
            </div>

            <!-- 3. Categories -->
            <div>
                <h4 class="footer-col-title">Կատեգորիաներ</h4>
                <ul class="footer-nav-list">
                    <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Փափուկ խաղալիքներ</a></li>
                    <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Կոնստրուկտորներ</a></li>
                    <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Մեքենաներ և տրանսպորտ</a></li>
                    <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Տիկնիկներ և տնակներ</a></li>
                    <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Ուսուցողական խաղեր</a></li>
                </ul>
            </div>

            <!-- 4. Contacts -->
            <div>
                <h4 class="footer-col-title">Կապ մեզ հետ</h4>
                <div class="footer-contacts-list">
                    <div class="footer-contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <div>
                            <div><strong>+374 (10) 12-34-56</strong></div>
                            <div style="font-size:12px;opacity:0.75;">Ամեն օր՝ 09:00 - 21:00</div>
                        </div>
                    </div>
                    <div class="footer-contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <span>info@toysland.am</span>
                    </div>
                    <div class="footer-contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span>ք. Երևան, Հայաստան</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="footer-bottom-bar">
            <div>
                © <?php echo esc_html(date('Y')); ?> ToysLand Armenia. Բոլոր իրավունքները պաշտպանված են:
            </div>
            <div class="payment-badges-row">
                <span class="payment-badge">Idram</span>
                <span class="payment-badge">Telcell</span>
                <span class="payment-badge">ArCa</span>
                <span class="payment-badge">Visa</span>
                <span class="payment-badge">Mastercard</span>
                <span class="payment-badge">Կանխիկ</span>
            </div>
        </div>
    </div>
</footer>

