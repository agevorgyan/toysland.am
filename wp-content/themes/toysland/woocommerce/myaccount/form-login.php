<?php
/**
 * Modern Login & Register Forms for ToysLand
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_customer_login_form');

$enable_registration = ('yes' === get_option('woocommerce_enable_myaccount_registration'));
$is_register_active  = (!empty($_POST['register']) || (isset($_GET['action']) && $_GET['action'] === 'register'));
?>

<div class="toysland-auth-container">
    <div class="auth-layout-grid <?php echo !$enable_registration ? 'no-registration' : ''; ?>">
        
        <!-- Left: Authentication Form Card -->
        <div class="auth-card">
            
            <?php if ($enable_registration) : ?>
                <!-- Auth Tabs Switcher -->
                <div class="auth-tabs-nav">
                    <button type="button" class="auth-tab-btn js-auth-tab <?php echo !$is_register_active ? 'is-active' : ''; ?>" data-target="#loginTab">
                        <span class="tab-icon">👤</span>
                        <span>Մուտք գործել</span>
                    </button>
                    <button type="button" class="auth-tab-btn js-auth-tab <?php echo $is_register_active ? 'is-active' : ''; ?>" data-target="#registerTab">
                        <span class="tab-icon">✍️</span>
                        <span>Գրանցվել</span>
                    </button>
                </div>
            <?php endif; ?>

            <!-- LOGIN TAB PANEL -->
            <div id="loginTab" class="auth-tab-panel js-auth-panel <?php echo !$is_register_active ? 'is-active' : ''; ?>">
                
                <div class="auth-header">
                    <h2 class="auth-title">Բարի գալուստ ToysLand</h2>
                    <p class="auth-subtitle">Մուտք գործեք Ձեր հաշիվ՝ պատվերները տեսնելու և գնումներ կատարելու համար:</p>
                </div>

                <form class="woocommerce-form woocommerce-form-login login auth-form" method="post">
                    
                    <?php do_action('woocommerce_login_form_start'); ?>

                    <!-- Username or Email -->
                    <div class="auth-form-group">
                        <label for="username" class="auth-label">
                            Մուտքանուն կամ էլ. հասցե <span class="required">*</span>
                        </label>
                        <div class="auth-input-wrap">
                            <span class="input-icon">👤</span>
                            <input type="text" 
                                   class="woocommerce-Input input-text auth-input" 
                                   name="username" 
                                   id="username" 
                                   autocomplete="username" 
                                   placeholder="Մուտքագրեք օգտանունը կամ էլ. հասցեն"
                                   value="<?php echo (!empty($_POST['username']) && is_string($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" 
                                   required />
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="auth-form-group">
                        <label for="password" class="auth-label">
                            Գաղտնաբառ <span class="required">*</span>
                        </label>
                        <div class="auth-input-wrap">
                            <span class="input-icon">🔒</span>
                            <input class="woocommerce-Input input-text auth-input js-password-input" 
                                   type="password" 
                                   name="password" 
                                   id="password" 
                                   autocomplete="current-password" 
                                   placeholder="Մուտքագրեք գաղտնաբառը"
                                   required />
                            <button type="button" class="password-toggle-btn js-toggle-pwd" aria-label="Ցուցադրել գաղտնաբառը">
                                <span class="pwd-eye-open">👁️</span>
                                <span class="pwd-eye-closed" style="display:none;">🙈</span>
                            </button>
                        </div>
                    </div>

                    <?php do_action('woocommerce_login_form'); ?>

                    <!-- Remember & Lost Password -->
                    <div class="auth-form-meta">
                        <label class="remember-label">
                            <input class="remember-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
                            <span>Հիշել ինձ</span>
                        </label>
                        <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="lost-pwd-link">
                            Մոռացե՞լ եք գաղտնաբառը:
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                    <button type="submit" class="cart-checkout-btn auth-submit-btn" name="login" value="Մուտք գործել">
                        <span>Մուտք գործել</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </button>

                    <?php if ($enable_registration) : ?>
                        <div class="auth-switch-footer">
                            <span>Դեռ չունե՞ք հաշիվ:</span>
                            <button type="button" class="auth-switch-link js-auth-tab" data-target="#registerTab">Գրանցվել հիմա</button>
                        </div>
                    <?php endif; ?>

                    <?php do_action('woocommerce_login_form_end'); ?>

                </form>
            </div>

            <?php if ($enable_registration) : ?>
                <!-- REGISTER TAB PANEL -->
                <div id="registerTab" class="auth-tab-panel js-auth-panel <?php echo $is_register_active ? 'is-active' : ''; ?>">
                    
                    <div class="auth-header">
                        <h2 class="auth-title">Ստեղծել նոր հաշիվ</h2>
                        <p class="auth-subtitle">Գրանցվեք և բացահայտեք մանկական խաղալիքների կախարդական աշխարհը:</p>
                    </div>

                    <form method="post" class="woocommerce-form woocommerce-form-register register auth-form" <?php do_action('woocommerce_register_form_tag'); ?>>

                        <?php do_action('woocommerce_register_form_start'); ?>

                        <!-- Username -->
                        <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>
                            <div class="auth-form-group">
                                <label for="reg_username" class="auth-label">
                                    Մուտքանուն (Username) <span class="required">*</span>
                                </label>
                                <div class="auth-input-wrap">
                                    <span class="input-icon">👤</span>
                                    <input type="text" 
                                           class="woocommerce-Input input-text auth-input" 
                                           name="username" 
                                           id="reg_username" 
                                           autocomplete="username" 
                                           placeholder="Օրինակ՝ anna_poghosyan"
                                           value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" 
                                           required />
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Email -->
                        <div class="auth-form-group">
                            <label for="reg_email" class="auth-label">
                                Էլեկտրոնային հասցե (Email) <span class="required">*</span>
                            </label>
                            <div class="auth-input-wrap">
                                <span class="input-icon">✉️</span>
                                <input type="email" 
                                       class="woocommerce-Input input-text auth-input" 
                                       name="email" 
                                       id="reg_email" 
                                       autocomplete="email" 
                                       placeholder="Օրինակ՝ name@example.com"
                                       value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" 
                                       required />
                            </div>
                        </div>

                        <!-- Password -->
                        <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>
                            <div class="auth-form-group">
                                <label for="reg_password" class="auth-label">
                                    Գաղտնաբառ <span class="required">*</span>
                                </label>
                                <div class="auth-input-wrap">
                                    <span class="input-icon">🔒</span>
                                    <input type="password" 
                                           class="woocommerce-Input input-text auth-input js-password-input" 
                                           name="password" 
                                           id="reg_password" 
                                           autocomplete="new-password" 
                                           placeholder="Ստեղծեք ապահով գաղտնաբառ"
                                           required />
                                    <button type="button" class="password-toggle-btn js-toggle-pwd" aria-label="Ցուցադրել գաղտնաբառը">
                                        <span class="pwd-eye-open">👁️</span>
                                        <span class="pwd-eye-closed" style="display:none;">🙈</span>
                                    </button>
                                </div>
                            </div>
                        <?php else : ?>
                            <p style="font-size:13px;color:#7a7191;margin-bottom:18px;">
                                Գաղտնաբառը ստեղծելու հղումը կուղարկվի Ձեր նշած էլեկտրոնային հասցեին:
                            </p>
                        <?php endif; ?>

                        <?php do_action('woocommerce_register_form'); ?>

                        <!-- Security note -->
                        <div class="auth-privacy-notice">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            <span>Ձեր տվյալները պաշտպանված են համաձայն գաղտնիության քաղաքականության:</span>
                        </div>

                        <!-- Submit Button -->
                        <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                        <button type="submit" class="cart-checkout-btn auth-submit-btn" name="register" value="Գրանցվել">
                            <span>Ստեղծել հաշիվ</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </button>

                        <div class="auth-switch-footer">
                            <span>Արդեն ունե՞ք հաշիվ:</span>
                            <button type="button" class="auth-switch-link js-auth-tab" data-target="#loginTab">Մուտք գործել</button>
                        </div>

                        <?php do_action('woocommerce_register_form_end'); ?>

                    </form>
                </div>
            <?php endif; ?>

        </div>

        <!-- Right: ToysLand Perks & Benefits Card -->
        <div class="auth-perks-card">
            <div class="perks-badge">
                <span>🎈 ToysLand Club</span>
            </div>
            <h3 class="perks-heading">Ինչո՞ւ ունենալ հաշիվ ToysLand-ում</h3>
            <p class="perks-subheading">Գրանցվեք և օգտվեք մեր բոլոր առավելություններից ու հատուկ ակցիաներից:</p>

            <div class="perks-list">
                <div class="perk-item">
                    <div class="perk-icon">🎁</div>
                    <div class="perk-text">
                        <strong>Անհատական զեղչեր</strong>
                        <span>Հատուկ նվերներ ծննդյան օրվա առթիվ և բոնուսային միավորներ</span>
                    </div>
                </div>

                <div class="perk-item">
                    <div class="perk-icon">⚡</div>
                    <div class="perk-text">
                        <strong>Արագ գնումներ</strong>
                        <span>Պահպանեք Ձեր հասցեն և ձևակերպեք պատվերները 1 քլիքով</span>
                    </div>
                </div>

                <div class="perk-item">
                    <div class="perk-icon">📦</div>
                    <div class="perk-text">
                        <strong>Պատվերների պատմություն</strong>
                        <span>Հետևեք Ձեր բոլոր առաքումների ընթացքին իրական ժամանակում</span>
                    </div>
                </div>

                <div class="perk-item">
                    <div class="perk-icon">❤️</div>
                    <div class="perk-text">
                        <strong>Ընտրյալների ցանկ (Wishlist)</strong>
                        <span>Պահպանեք երեխայի նախընտրած խաղալիքները ապագա գնումների համար</span>
                    </div>
                </div>
            </div>

            <div class="perks-social-proof">
                <div class="stars-row">⭐⭐⭐⭐⭐</div>
                <div class="proof-text">Ավելի քան <strong>2 500</strong> երջանիկ փոքրիկներ և գոհունակ ծնողներ Հայաստանում:</div>
            </div>
        </div>

    </div>
</div>

<?php do_action('woocommerce_after_customer_login_form'); ?>

