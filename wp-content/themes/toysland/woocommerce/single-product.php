<?php
/**
 * WooCommerce Single Product Template
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()) :
    the_post();
    global $product;
    if (!$product) continue;

    $product_id   = $product->get_id();
    $product_name = $product->get_name();
    $product_img  = toysland_get_product_image_url($product);
    $price        = $product->get_price();
    $regular_price= $product->get_regular_price();
    $is_on_sale   = $product->is_on_sale();
    $sku          = $product->get_sku() ?: 'TL-' . $product_id;
    $stock_status = $product->is_in_stock() ? 'Առկա է պահեստում' : 'Սպառված է';
    $gallery_ids  = $product->get_gallery_image_ids();
    $categories   = get_the_terms($product_id, 'product_cat');
    $category_name= (!empty($categories) && !is_wp_error($categories)) ? $categories[0]->name : 'Խաղալիք';
?>

<div class="toysland-single-product-section">
    <div class="container">
        <!-- Breadcrumbs -->
        <div class="shop-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Գլխավոր</a> &rsaquo; 
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Խանութ</a> &rsaquo; 
            <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
                <a href="<?php echo esc_url(get_term_link($categories[0])); ?>"><?php echo esc_html($category_name); ?></a> &rsaquo;
            <?php endif; ?>
            <span><?php echo esc_html($product_name); ?></span>
        </div>

        <div class="single-product-grid">
            <!-- Product Gallery -->
            <div class="single-product-gallery">
                <div class="main-image-wrap">
                    <img src="<?php echo esc_url($product_img); ?>" alt="<?php echo esc_attr($product_name); ?>" class="main-gallery-img" id="mainGalleryImage">
                </div>
                
                <?php if (!empty($gallery_ids)) : ?>
                    <div class="gallery-thumbs-row">
                        <button type="button" class="gallery-thumb-btn is-active" onclick="document.getElementById('mainGalleryImage').src='<?php echo esc_url($product_img); ?>'">
                            <img src="<?php echo esc_url($product_img); ?>" alt="">
                        </button>
                        <?php foreach ($gallery_ids as $gid) : 
                            $thumb_url = wp_get_attachment_image_url($gid, 'medium');
                        ?>
                            <button type="button" class="gallery-thumb-btn" onclick="document.getElementById('mainGalleryImage').src='<?php echo esc_url($thumb_url); ?>'">
                                <img src="<?php echo esc_url($thumb_url); ?>" alt="">
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Product Purchase Details -->
            <div class="single-product-details">
                <div class="single-product-meta">
                    <span class="single-stock-badge">
                        <span>●</span> <?php echo esc_html($stock_status); ?>
                    </span>
                    <span class="single-sku">Արտիկուլ: <strong><?php echo esc_html($sku); ?></strong></span>
                </div>

                <h1 class="single-product-title"><?php echo esc_html($product_name); ?></h1>

                <div class="single-rating-row">
                    <?php echo toysland_render_rating($product->get_average_rating(), $product->get_review_count()); ?>
                    <span style="font-size:13px;color:var(--color-primary);font-weight:700;">• 100% Օրիգինալ խաղալիք</span>
                </div>

                <div class="single-price-box">
                    <span class="single-current-price"><?php echo esc_html(toysland_price($price)); ?></span>
                    <?php if ($is_on_sale && !empty($regular_price)) : ?>
                        <span class="single-old-price"><?php echo esc_html(toysland_price($regular_price)); ?></span>
                    <?php endif; ?>
                </div>

                <div class="single-short-desc">
                    <?php echo wpautop($product->get_short_description() ?: $product->get_description() ?: 'Բարձրորակ և անվտանգ մանկական խաղալիք, որը կպարգևի ուրախություն և զարգացնող ժամանց Ձեր երեխային:'); ?>
                </div>

                <!-- Add to cart & Fast buy form -->
                <form class="single-cart-actions" onsubmit="event.preventDefault();">
                    <div class="single-qty-box">
                        <button type="button" class="single-qty-btn" onclick="let input=this.nextElementSibling; if(parseInt(input.value)>1) input.value=parseInt(input.value)-1;">−</button>
                        <input type="number" class="single-qty-input" id="singleProductQty" value="1" min="1" max="99">
                        <button type="button" class="single-qty-btn" onclick="let input=this.previousElementSibling; input.value=parseInt(input.value)+1;">+</button>
                    </div>

                    <button type="button" class="single-add-to-cart-btn js-ajax-add-to-cart" data-product-id="<?php echo esc_attr($product_id); ?>" onclick="this.setAttribute('data-qty', document.getElementById('singleProductQty').value)">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        <span>Ավելացնել զամբյուղ</span>
                    </button>

                    <button type="button" class="single-buy-now-btn" onclick="let phone=prompt('Մուտքագրեք Ձեր հեռախոսահամարը արագ պատվերի համար (օր.՝ +374 91 123456):'); if(phone) alert('Շնորհակալություն! Մեր մասնագետը կզանգահարի Ձեզ 15 րոպեի ընթացքում:');">
                        <span>Գնել 1 քլիքով</span>
                    </button>
                </form>

                <!-- Delivery & Trust Box -->
                <div class="single-delivery-box">
                    <div class="delivery-box-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="2"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                        <span>Առաքում Երևանում 1 աշխատանքային օրում (1 000 ֏ կամ Անվճար 15 000 ֏-ից)</span>
                    </div>
                    <div class="delivery-box-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <span>100% Սերտիֆիկացված և անվտանգ նյութեր երեխաների համար</span>
                    </div>
                    <div class="delivery-box-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5" rx="1"/><line x1="12" y1="22" x2="12" y2="7"/></svg>
                        <span>Անվճար տոնական նվերների փաթեթավորում ըստ ցանկության</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div style="margin-top:60px;">
            <div class="section-header">
                <div class="section-title-wrap">
                    <span class="section-subtitle">🧸 Ձեզ նույնպես կարող է դուր գալ</span>
                    <h2 class="section-title">Նմանատիպ խաղալիքներ</h2>
                </div>
            </div>
            
            <?php
            woocommerce_related_products([
                'posts_per_page' => 4,
                'columns'        => 4,
                'orderby'        => 'rand',
            ]);
            ?>
        </div>
    </div>
</div>

<?php
endwhile;

get_footer();

