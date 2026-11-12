<?php
/**
 * Template Name: Wishlist Page
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="toysland-wishlist-page" style="padding: 40px 0 70px;">
    <div class="container">
        <h1 style="font-size:32px;font-weight:900;margin-bottom:24px;">Իմ ընտրյալները (Wishlist)</h1>
        
        <div id="wishlistContainer" style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;">
            <div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--color-text-muted);">
                Բեռնվում է ընտրյալների ցանկը...
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const list = JSON.parse(localStorage.getItem('toysland_wishlist') || '[]');
    const container = document.getElementById('wishlistContainer');
    
    if (list.length === 0) {
        container.innerHTML = `
            <div style="grid-column:1/-1;text-align:center;padding:60px 20px;background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--radius-xl);">
                <div style="font-size:48px;margin-bottom:14px;">❤️</div>
                <h3 style="font-size:20px;margin-bottom:8px;">Դուք դեռ չունեք ընտրյալ խաղալիքներ</h3>
                <p style="color:var(--color-text-muted);margin-bottom:20px;">Սեղմեք սրտիկի վրա ցանկացած խաղալիքի քարտում՝ այն այստեղ պահպանելու համար:</p>
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-primary-large" style="display:inline-flex;">Գնալ խանութ</a>
            </div>
        `;
        return;
    }

    // Fetch wishlist items via AJAX
    jQuery.ajax({
        url: toyslandData.ajaxUrl,
        type: 'POST',
        data: {
            action: 'toysland_get_wishlist_items',
            ids: list
        },
        success: function(res) {
            if (res.success && res.data.products && res.data.products.length > 0) {
                let html = '';
                res.data.products.forEach(p => {
                    html += `
                        <div class="product-card" data-product-id="${p.id}">
                            <div class="product-thumb-container">
                                <a href="${p.url}" class="product-thumb-link">
                                    <img src="${p.image}" alt="${p.title}" class="product-thumb-img">
                                </a>
                            </div>
                            <h3 class="product-title"><a href="${p.url}">${p.title}</a></h3>
                            <div class="product-price-box"><span class="current-price">${p.price}</span></div>
                            <button type="button" class="btn-add-to-cart js-ajax-add-to-cart" data-product-id="${p.id}">
                                <span>Ավելացնել զամբյուղ</span>
                            </button>
                        </div>
                    `;
                });
                container.innerHTML = html;
            } else {
                container.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:40px;">Ընտրյալներ չեն գտնվել:</div>';
            }
        }
    });
});
</script>

<?php
get_footer();

