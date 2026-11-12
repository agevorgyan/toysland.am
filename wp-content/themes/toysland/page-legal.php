<?php
/**
 * Template Name: Իրավական / Տեղեկատվական էջ (Legal & Info Page)
 *
 * Modern high-converting policy template for ToysLand:
 * Delivery, Returns, Privacy Policy, Terms & Conditions.
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$post_slug = get_post_field('post_name', get_post());

// Configuration per page
$legal_pages_meta = [
    'delivery' => [
        'icon'      => '🚚',
        'badge'     => 'Առաքում և Վճարում',
        'subtitle'  => 'Արագ, ապահով և հարմարավետ առաքում Երևանում և ՀՀ բոլոր մարզերում: Վճարեք այնպես, ինչպես Ձեզ է հարմար:',
        'read_time' => '3 րոպե',
    ],
    'returns' => [
        'icon'      => '🔄',
        'badge'     => 'Վերադարձ և Երաշխիք',
        'subtitle'  => '14 օրվա վերադարձի և փոխանակման երաշխիք: Մենք ապահովում ենք 100% անվտանգ, հուսալի և թափանցիկ գնումներ:',
        'read_time' => '3 րոպե',
    ],
    'privacy-policy' => [
        'icon'      => '🔒',
        'badge'     => 'Գաղտնիության Քաղաքականություն',
        'subtitle'  => 'Ձեր անձնական տվյալների գաղտնիությունն ու անվտանգությունը մեր առաջնահերթությունն է: Պաշտպանված գնումներ ToysLand-ում:',
        'read_time' => '4 րոպե',
    ],
    'terms' => [
        'icon'      => '📜',
        'badge'     => 'Օգտագործման Պայմաններ',
        'subtitle'  => 'ToysLand.am առցանց խանութից օգտվելու, գնումների ձևակերպման և համագործակցության պաշտոնական դրույթները:',
        'read_time' => '4 րոպե',
    ],
];

$page_info = $legal_pages_meta[$post_slug] ?? [
    'icon'      => '📄',
    'badge'     => 'Տեղեկատվություն',
    'subtitle'  => 'Կարևոր տեղեկատվություն մեր սպասարկման և կանոնների վերաբերյալ:',
    'read_time' => '3 րոպե',
];

$modified_date = get_the_modified_date('d F Y');
// Format month to Armenian
$months_en = ['January','February','March','April','May','June','July','August','September','October','November','December'];
$months_am = ['Հունվարի','Փետրվարի','Մարտի','Ապրիլի','Մայիսի','Հունիսի','Հուլիսի','Օգոստոսի','Սեպտեմբերի','Հոկտեմբերի','Նոյեմբերի','Դեկտեմբերի'];
$formatted_date = str_replace($months_en, $months_am, $modified_date);

// Sibling links
$sibling_pages = [
    'delivery'       => ['icon' => '🚚', 'title' => 'Առաքում և վճարում', 'url' => home_url('/delivery/')],
    'returns'        => ['icon' => '🔄', 'title' => 'Վերադարձ և երաշխիք', 'url' => home_url('/returns/')],
    'privacy-policy' => ['icon' => '🔒', 'title' => 'Գաղտնիության քաղաքականություն', 'url' => home_url('/privacy-policy/')],
    'terms'          => ['icon' => '📜', 'title' => 'Օգտագործման պայմաններ', 'url' => home_url('/terms/')],
];
?>

<div class="toysland-legal-page">
    <div class="container">
        
        <!-- Breadcrumbs -->
        <nav class="account-breadcrumbs" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Գլխավոր</a>
            <span class="sep">/</span>
            <span class="current"><?php the_title(); ?></span>
        </nav>

        <!-- Hero Banner Header -->
        <div class="legal-hero-banner">
            <div class="legal-hero-content">
                <div class="hero-top-badges">
                    <span class="legal-icon-circle"><?php echo esc_html($page_info['icon']); ?></span>
                    <span class="legal-badge-pill"><?php echo esc_html($page_info['badge']); ?></span>
                </div>
                <h1 class="legal-hero-title"><?php the_title(); ?></h1>
                <p class="legal-hero-subtitle"><?php echo esc_html($page_info['subtitle']); ?></p>

                <div class="legal-meta-row">
                    <span class="meta-item">
                        <span class="meta-icon">📅</span>
                        <span>Թարմացվել է՝ <strong><?php echo esc_html($formatted_date); ?></strong></span>
                    </span>
                    <span class="meta-item">
                        <span class="meta-icon">⏱️</span>
                        <span>Ընթերցման ժամանակը՝ <strong><?php echo esc_html($page_info['read_time']); ?></strong></span>
                    </span>
                    <span class="meta-item meta-verified">
                        <span class="meta-icon">🛡️</span>
                        <span>ՀՀ Օրենսդրությանը համապատասխան</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- 2-Column Layout Grid -->
        <div class="legal-layout-grid">
            
            <!-- Sticky Sidebar: Related Policy Links & Contact -->
            <aside class="legal-sidebar-col">
                <div class="legal-sidebar-sticky">
                    
                    <!-- Sibling Pages Navigation -->
                    <div class="legal-sidebar-card">
                        <h3 class="sidebar-block-title">📚 Իրավական բաժիններ</h3>
                        <nav class="legal-nav-menu" aria-label="Իրավական էջեր">
                            <?php foreach ($sibling_pages as $slug => $item) : 
                                $is_active = ($slug === $post_slug);
                            ?>
                                <a href="<?php echo esc_url($item['url']); ?>" class="legal-nav-item <?php echo $is_active ? 'is-active' : ''; ?>">
                                    <span class="nav-item-icon"><?php echo esc_html($item['icon']); ?></span>
                                    <span class="nav-item-text"><?php echo esc_html($item['title']); ?></span>
                                    <span class="nav-item-arrow">→</span>
                                </a>
                            <?php endforeach; ?>
                        </nav>
                    </div>

                    <!-- Customer Support Card -->
                    <div class="legal-support-card">
                        <div class="support-icon-wrap">💬</div>
                        <h4 class="support-card-title">Հարցեր ունե՞ք</h4>
                        <p class="support-card-desc">Մեր թիմը սիրով կպարզաբանի ցանկացած մանրամասն:</p>
                        <div class="support-quick-links">
                            <a href="tel:+37410123456" class="support-quick-link">
                                <span class="link-icon">📞</span>
                                <span>+374 (10) 12-34-56</span>
                            </a>
                            <a href="mailto:info@toysland.am" class="support-quick-link">
                                <span class="link-icon">✉️</span>
                                <span>info@toysland.am</span>
                            </a>
                            <div class="support-hours">
                                <span>⏰ Ամեն օր՝ 09:00 - 21:00</span>
                            </div>
                        </div>
                    </div>

                </div>
            </aside>

            <!-- Main Content Card -->
            <main class="legal-main-col">
                <article id="post-<?php the_ID(); ?>" class="legal-content-card">
                    
                    <div class="legal-article-body">
                        <?php
                        while (have_posts()) :
                            the_post();
                            the_content();
                        endwhile;
                        ?>
                    </div>

                    <!-- Bottom Support CTA Banner -->
                    <div class="legal-bottom-cta">
                        <div class="cta-text-box">
                            <span class="cta-badge">🧸 ToysLand Խաղալիքների Աշխարհ</span>
                            <h3 class="cta-title">Մենք միշտ պատրաստ ենք օգնել Ձեզ</h3>
                            <p class="cta-desc">Եթե ունեք հավելյալ հարցեր պատվերների, առաքման կամ երաշխիքային պայմանների վերաբերյալ, դիմեք մեր մասնագետներին:</p>
                        </div>
                        <div class="cta-buttons-box">
                            <a href="tel:+37410123456" class="cta-btn primary">
                                <span>📞 Զանգահարել հիմա</span>
                            </a>
                            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="cta-btn secondary">
                                <span>🛍️ Գնալ խանութ</span>
                            </a>
                        </div>
                    </div>

                </article>
            </main>

        </div>

    </div>
</div>

<?php
get_footer();

