<?php
/**
 * WooCommerce Product Archive / Shop Template
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$current_cat = is_product_category() ? get_queried_object() : null;
$page_title = $current_cat ? $current_cat->name : 'Խաղալիքների կատալոգ';
$categories = get_terms([
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
]);
?>

<div class="toysland-shop-layout">
    <div class="container">
        <!-- Breadcrumbs -->
        <div class="shop-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Գլխավոր</a> &rsaquo; 
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Խանութ</a>
            <?php if ($current_cat) : ?>
                &rsaquo; <span><?php echo esc_html($current_cat->name); ?></span>
            <?php endif; ?>
        </div>

        <div class="shop-main-grid">
            <!-- Sidebar Filters -->
            <aside class="shop-sidebar">
                <!-- Categories Widget -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">Կատեգորիաներ</h3>
                    <ul class="filter-categories-list">
                        <li>
                            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="filter-cat-item <?php if (!$current_cat) echo 'is-active'; ?>">
                                <span>Բոլոր խաղալիքները</span>
                            </a>
                        </li>
                        <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
                            <?php foreach ($categories as $cat) : 
                                if ($cat->slug === 'uncategorized') continue;
                                $is_active = ($current_cat && $current_cat->term_id === $cat->term_id);
                            ?>
                                <li>
                                    <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="filter-cat-item <?php if ($is_active) echo 'is-active'; ?>">
                                        <span><?php echo esc_html($cat->name); ?></span>
                                        <span class="filter-cat-count"><?php echo esc_html($cat->count); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Price Filter Widget -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">Գին (֏)</h3>
                    <form method="get" action="<?php echo esc_url(is_product_category() ? get_term_link($current_cat) : wc_get_page_permalink('shop')); ?>" class="price-filter-wrap">
                        <div class="price-inputs-row">
                            <input type="number" name="min_price" placeholder="Սկսած" value="<?php echo esc_attr($_GET['min_price'] ?? ''); ?>" class="price-input">
                            <span>—</span>
                            <input type="number" name="max_price" placeholder="Մինչև" value="<?php echo esc_attr($_GET['max_price'] ?? ''); ?>" class="price-input">
                        </div>
                        <button type="submit" class="btn-filter-apply">Կիրառել</button>
                    </form>
                </div>

                <!-- Fast Delivery Guarantee Box -->
                <div style="background:var(--color-primary-light);border-radius:var(--radius-md);padding:16px;margin-top:20px;">
                    <div style="font-size:13px;font-weight:800;color:var(--color-primary);margin-bottom:6px;">🚚 Առաքում Երևանում</div>
                    <div style="font-size:12px;color:var(--color-text-main);line-height:1.4;">Պատվիրեք մինչև 15:00-ն և ստացեք նույն կամ հաջորդ աշխատանքային օրը:</div>
                </div>
            </aside>

            <!-- Main Catalog Content -->
            <main class="shop-content-area">
                <!-- Toolbar -->
                <div class="shop-toolbar">
                    <div class="shop-results-count">
                        <?php woocommerce_result_count(); ?>
                    </div>
                    <div>
                        <?php woocommerce_catalog_ordering(); ?>
                    </div>
                </div>

                <!-- Products Grid -->
                <?php if (woocommerce_product_loop()) : 
                    global $wp_query;
                    $paged = max(1, get_query_var('paged'));
                    $max_pages = $wp_query->max_num_pages;
                    $next_url = next_posts($max_pages, false);
                ?>
                    <div class="products-grid js-infinite-scroll-grid"
                         id="shopProductsGrid"
                         data-current-page="<?php echo esc_attr($paged); ?>"
                         data-max-pages="<?php echo esc_attr($max_pages); ?>"
                         data-next-url="<?php echo esc_url($next_url); ?>">
                        <?php
                        while (have_posts()) :
                            the_post();
                            get_template_part('woocommerce/content-product');
                        endwhile;
                        ?>
                    </div>

                    <!-- Infinite Scroll Status & Sentinel -->
                    <?php if ($max_pages > 1) : ?>
                        <div class="infinite-scroll-status" id="infiniteScrollStatus">
                            <div class="infinite-scroll-loader" id="infiniteScrollLoader" style="display: none;">
                                <span class="infinite-spinner-icon"></span>
                                <span class="infinite-loading-text">Բեռնվում են հաջորդ ապրանքները...</span>
                            </div>
                            <div class="infinite-scroll-done" id="infiniteScrollDone" style="<?php echo ($paged >= $max_pages) ? '' : 'display: none;'; ?>">
                                <span>🎉 Դուք դիտել եք բոլոր ապրանքները</span>
                            </div>
                            <div class="infinite-scroll-sentinel" id="infiniteScrollSentinel"></div>
                        </div>

                        <!-- Fallback / SEO Pagination (hidden from view) -->
                        <div class="shop-pagination-wrap" style="display:none;" aria-hidden="true">
                            <?php
                            the_posts_pagination([
                                'prev_text' => '&larr; Նախորդ',
                                'next_text' => 'Հաջորդ &rarr;',
                                'type'      => 'list',
                            ]);
                            ?>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div style="text-align:center;padding:60px 20px;background:var(--color-surface);border-radius:var(--radius-lg);border:1px solid var(--color-border);">
                        <h3>Ապրանքներ չեն գտնվել</h3>
                        <p style="color:var(--color-text-muted);margin:10px 0 20px;">Փորձեք փոխել որոնման պարամետրերը կամ կատեգորիան:</p>
                        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-primary-large" style="padding:12px 24px;font-size:14px;">
                            Բոլոր խաղալիքները
                        </a>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>
</div>

<?php
get_footer();

