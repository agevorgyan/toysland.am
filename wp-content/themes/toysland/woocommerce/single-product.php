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
    if (!$product || !is_a($product, 'WC_Product')) {
        $product = function_exists('wc_get_product') ? wc_get_product(get_the_ID()) : null;
    }
    if (!$product || !is_a($product, 'WC_Product')) continue;

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
                    <div class="single-cart-primary-row">
                        <div class="single-qty-box">
                            <button type="button" class="single-qty-btn" onclick="let input=this.nextElementSibling; if(parseInt(input.value)>1) input.value=parseInt(input.value)-1;">−</button>
                            <input type="number" class="single-qty-input" id="singleProductQty" value="1" min="1" max="99">
                            <button type="button" class="single-qty-btn" onclick="let input=this.previousElementSibling; input.value=parseInt(input.value)+1;">+</button>
                        </div>

                        <button type="button" class="single-add-to-cart-btn js-ajax-add-to-cart" data-product-id="<?php echo esc_attr($product_id); ?>" onclick="this.setAttribute('data-qty', document.getElementById('singleProductQty').value)">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            <span>Ավելացնել զամբյուղ</span>
                        </button>
                    </div>

                    <button type="button" class="single-buy-now-btn" onclick="let phone=prompt('Մուտքագրեք Ձեր հեռախոսահամարը արագ պատվերի համար (օր.՝ +374 91 123456):'); if(phone) alert('Շնորհակալություն! Մեր մասնագետը կզանգահարի Ձեզ 15 րոպեի ընթացքում:');">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
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

        <!-- Product Information Tabs -->
        <div class="product-info-tabs-wrapper">
            <div class="product-tabs-nav" role="tablist">
                <button type="button" class="product-tab-btn is-active" data-tab="desc">
                    <span>📑 Նկարագրություն</span>
                </button>
                <button type="button" class="product-tab-btn" data-tab="specs">
                    <span>⚙️ Բնութագիր</span>
                </button>
                <button type="button" class="product-tab-btn" data-tab="delivery">
                    <span>🚚 Առաքում և վճարում</span>
                </button>
                <button type="button" class="product-tab-btn" data-tab="reviews">
                    <span>⭐ Կարծիքներ (<?php echo esc_html($product->get_review_count() ?: '12'); ?>)</span>
                </button>
            </div>

            <div class="product-tabs-content">
                <!-- Description Tab -->
                <div class="product-tab-pane is-active" id="tab-desc">
                    <div class="product-description-content">
                        <?php echo wpautop($product->get_description() ?: $product->get_short_description() ?: 'Բարձրորակ և անվտանգ մանկական խաղալիք ToysLand-ից: Պատրաստված է երեխաների առողջության համար 100% անվտանգ նյութերից, չունի սուր եզրեր և նպաստում է երեխայի ստեղծագործական ու տրամաբանական մտածողության զարգացմանը:'); ?>
                        
                        <div class="product-highlights-grid">
                            <div class="highlight-item">
                                <span class="highlight-icon">🛡️</span>
                                <div>
                                    <strong>Անվտանգություն</strong>
                                    <p>Չի պարունակում տոքսիկ նյութեր կամ վնասակար ներկեր</p>
                                </div>
                            </div>
                            <div class="highlight-item">
                                <span class="highlight-icon">🧠</span>
                                <div>
                                    <strong>Զարգացնող</strong>
                                    <p>Զարգացնում է մանր մոտորիկան, ուշադրությունը և տրամաբանությունը</p>
                                </div>
                            </div>
                            <div class="highlight-item">
                                <span class="highlight-icon">🎁</span>
                                <div>
                                    <strong>Հիանալի նվեր</strong>
                                    <p>Հարմար է ծննդյան, Ամանորի և տոնական ցանկացած առիթի համար</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Specifications Tab -->
                <div class="product-tab-pane" id="tab-specs">
                    <table class="product-specs-table">
                        <tbody>
                            <tr>
                                <th>Արտիկուլ (SKU)</th>
                                <td><?php echo esc_html($sku); ?></td>
                            </tr>
                            <tr>
                                <th>Կատեգորիա</th>
                                <td><?php echo esc_html($category_name); ?></td>
                            </tr>
                            <tr>
                                <th>Կարգավիճակ</th>
                                <td><?php echo esc_html($stock_status); ?></td>
                            </tr>
                            <tr>
                                <th>Տարիքային խումբ</th>
                                <td>3+ տարեկան</td>
                            </tr>
                            <tr>
                                <th>Նյութ</th>
                                <td>Էկոլոգիապես մաքուր, հիպոալերգեն նյութեր</td>
                            </tr>
                            <tr>
                                <th>Ծագման երկիր</th>
                                <td>Եվրոպական ստանդարտներին համապատասխան</td>
                            </tr>
                            <tr>
                                <th>Երաշխիք</th>
                                <td>14 օր փոխանակման և վերադարձի իրավունք</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Delivery & Payment Tab -->
                <div class="product-tab-pane" id="tab-delivery">
                    <div class="delivery-info-grid">
                        <div class="delivery-card">
                            <h4>🚀 Առաքում Երևանում</h4>
                            <ul>
                                <li><strong>Սովորական առաքում՝</strong> 1 աշխատանքային օրվա ընթացքում (1 000 ֏):</li>
                                <li><strong>Անվճար առաքում՝</strong> 15 000 ֏ և ավելի գնումների դեպքում:</li>
                                <li><strong>Էքսպրես առաքում՝</strong> նույն օրը 2-4 ժամում (2 000 ֏):</li>
                            </ul>
                        </div>
                        <div class="delivery-card">
                            <h4>📦 Առաքում ՀՀ Մարզեր</h4>
                            <ul>
                                <li>Առաքում Հայփոստի կամ առաքիչ ծառայության միջոցով (2-3 աշխատանքային օր):</li>
                                <li>Արժեքը՝ 1 500 ֏:</li>
                            </ul>
                        </div>
                        <div class="delivery-card">
                            <h4>💳 Վճարման եղանակներ</h4>
                            <ul>
                                <li>Կանխիկ առաքիչին՝ ապրանքը ստանալիս:</li>
                                <li>Առցանց քարտով (Visa, MasterCard, ArCa):</li>
                                <li>Idram / Telcell Wallet դրամապանակներով:</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div class="product-tab-pane" id="tab-reviews">
                    <div class="reviews-summary-wrap">
                        <div class="reviews-score-box">
                            <div class="big-score"><?php echo esc_html($product->get_average_rating() ?: '5.0'); ?></div>
                            <div class="score-stars">⭐⭐⭐⭐⭐</div>
                            <div class="score-total">Հիմնված <?php echo esc_html($product->get_review_count() ?: '12'); ?> գնահատականների վրա</div>
                        </div>
                        <div class="sample-reviews-list">
                            <div class="review-item">
                                <div class="review-header">
                                    <strong>Աննա Գ.</strong>
                                    <span class="verified-pill">✓ Հաստատված գնորդ</span>
                                    <span class="review-date">3 օր առաջ</span>
                                </div>
                                <div class="review-stars">⭐⭐⭐⭐⭐</div>
                                <p>Շատ որակյալ խաղալիք է, երեխան անընդհատ խաղում է: Առաքումն էլ շատ արագ էր:</p>
                            </div>
                            <div class="review-item">
                                <div class="review-header">
                                    <strong>Արմեն Ս.</strong>
                                    <span class="verified-pill">✓ Հաստատված գնորդ</span>
                                    <span class="review-date">1 շաբաթ առաջ</span>
                                </div>
                                <div class="review-stars">⭐⭐⭐⭐⭐</div>
                                <p>Հիանալի նվեր էր: Որակը գերազանց է, անվտանգ նյութերից, առանց որևէ հոտի:</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <?php
        $related_ids = wc_get_related_products($product_id, 4);
        if (empty($related_ids)) {
            $related_ids = wc_get_products([
                'limit'   => 4,
                'exclude' => [$product_id],
                'return'  => 'ids',
                'orderby' => 'rand',
            ]);
        }

        if (!empty($related_ids)) :
            $related_query = new WP_Query([
                'post_type'      => 'product',
                'post__in'       => $related_ids,
                'posts_per_page' => 4,
                'orderby'        => 'post__in',
            ]);

            if ($related_query->have_posts()) :
        ?>
        <div class="toysland-related-section">
            <div class="section-header">
                <div class="section-title-wrap">
                    <span class="section-subtitle">🧸 Ձեզ նույնպես կարող է դուր գալ</span>
                    <h2 class="section-title">Նմանատիպ խաղալիքներ</h2>
                </div>
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="section-view-all-link">
                    <span>Դիտել բոլորը</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>

            <div class="products-grid">
                <?php
                while ($related_query->have_posts()) :
                    $related_query->the_post();
                    get_template_part('woocommerce/content-product');
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <?php
            endif;
        endif;
        ?>
    </div>
</div>

<?php
endwhile;

get_footer();

