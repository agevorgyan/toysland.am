/**
 * ToysLand Main Client Interactive Script
 *
 * @package ToysLand
 */

(function($) {
  'use strict';

  // Global State
  const ToysLand = {
    wishlist: JSON.parse(localStorage.getItem('toysland_wishlist') || '[]'),

    init: function() {
      this.initAjaxSearch();
      this.initCartDrawer();
      this.initAjaxAddToCart();
      this.initHeroSlider();
      this.initWishlist();
      this.initAgeFilter();
      this.initMobileNav();
      this.updateWishlistCount();
    },

    /* ==========================================================================
       1. Live AJAX Search Engine
       ========================================================================== */
    initAjaxSearch: function() {
      const $searchInput = $('.search-input');
      const $resultsContainer = $('.ajax-search-results');
      const $catSelect = $('.search-category-select');
      let searchTimeout = null;

      if (!$searchInput.length) return;

      $searchInput.on('input', function() {
        const keyword = $(this).val().trim();
        const category = $catSelect.val() || '';

        clearTimeout(searchTimeout);

        if (keyword.length < 2) {
          $resultsContainer.removeClass('is-open').html('');
          return;
        }

        searchTimeout = setTimeout(function() {
          $resultsContainer.html('<div style="padding:16px;text-align:center;color:#6E6887;">' + toyslandData.i18n.searching + '</div>').addClass('is-open');

          $.ajax({
            url: toyslandData.ajaxUrl,
            type: 'GET',
            data: {
              action: 'toysland_ajax_search',
              keyword: keyword,
              category: category
            },
            success: function(response) {
              if (response.success && response.data.results.length > 0) {
                let html = '<div class="search-results-list">';
                response.data.results.forEach(function(item) {
                  html += `
                    <a href="${item.url}" class="search-result-item">
                      <img src="${item.image}" alt="${item.title}" class="search-result-thumb">
                      <div class="search-result-info">
                        <div class="search-result-title">${item.title}</div>
                        <div class="search-result-category">${item.category}</div>
                      </div>
                      <div class="search-result-price">${item.price}</div>
                    </a>
                  `;
                });
                html += '</div>';
                html += `<a href="${response.data.view_all_url}" class="search-view-all">${toyslandData.i18n.viewAllResults} (${response.data.count})</a>`;
                $resultsContainer.html(html).addClass('is-open');
              } else {
                $resultsContainer.html('<div style="padding:20px;text-align:center;color:#6E6887;">' + toyslandData.i18n.noResults + '</div>').addClass('is-open');
              }
            },
            error: function() {
              $resultsContainer.removeClass('is-open');
            }
          });
        }, 280);
      });

      // Close on click outside
      $(document).on('click', function(e) {
        if (!$(e.target).closest('.header-search-container').length) {
          $resultsContainer.removeClass('is-open');
        }
      });
    },

    /* ==========================================================================
       2. Slide-out Mini Cart Drawer
       ========================================================================== */
    initCartDrawer: function() {
      const self = this;
      const $backdrop = $('.toysland-drawer-backdrop');

      // Open drawer triggers
      $(document).on('click', '.js-open-cart-drawer, .header-cart-btn, .mobile-cart-trigger', function(e) {
        e.preventDefault();
        self.openCartDrawer();
      });

      // Close drawer triggers
      $(document).on('click', '.drawer-close-btn', function(e) {
        e.preventDefault();
        self.closeCartDrawer();
      });

      $backdrop.on('click', function(e) {
        if ($(e.target).hasClass('toysland-drawer-backdrop')) {
          self.closeCartDrawer();
        }
      });

      // Qty +/- in Cart Drawer
      $(document).on('click', '.qty-btn', function(e) {
        e.preventDefault();
        const $btn = $(this);
        const key = $btn.data('key');
        const qty = parseInt($btn.data('qty'), 10);

        self.updateCartQty(key, qty);
      });

      // Remove item in Cart Drawer
      $(document).on('click', '.drawer-remove-item', function(e) {
        e.preventDefault();
        const key = $(this).data('key');
        self.updateCartQty(key, 0);
      });
    },

    openCartDrawer: function() {
      $('.toysland-drawer-backdrop').addClass('is-open');
      $('body').css('overflow', 'hidden');
    },

    closeCartDrawer: function() {
      $('.toysland-drawer-backdrop').removeClass('is-open');
      $('body').css('overflow', '');
    },

    updateCartQty: function(key, qty) {
      const self = this;
      const $drawerBody = $('.drawer-cart-body');
      $drawerBody.css('opacity', '0.6');

      $.ajax({
        url: toyslandData.ajaxUrl,
        type: 'POST',
        data: {
          action: 'toysland_update_cart_qty',
          cart_item_key: key,
          quantity: qty
        },
        success: function(res) {
          $drawerBody.css('opacity', '1');
          if (res.success) {
            self.refreshCartUI(res.data);
          }
        },
        error: function() {
          $drawerBody.css('opacity', '1');
        }
      });
    },

    /* ==========================================================================
       3. AJAX Add to Cart
       ========================================================================== */
    initAjaxAddToCart: function() {
      const self = this;

      $(document).on('click', '.js-ajax-add-to-cart', function(e) {
        e.preventDefault();
        const $btn = $(this);
        const productId = $btn.data('product-id');
        const qty = $btn.data('qty') || 1;

        if (!productId) return;

        $btn.addClass('is-loading').prop('disabled', true);
        const originalText = $btn.html();
        $btn.html('<span class="spinner-inline">⏳</span> Ավելացվում է...');

        $.ajax({
          url: toyslandData.ajaxUrl,
          type: 'POST',
          data: {
            action: 'toysland_add_to_cart',
            product_id: productId,
            quantity: qty
          },
          success: function(res) {
            $btn.removeClass('is-loading').prop('disabled', false).html(originalText);
            if (res.success) {
              self.refreshCartUI(res.data);
              self.openCartDrawer();
            } else {
              alert(res.data.message || toyslandData.i18n.errorAdding);
            }
          },
          error: function() {
            $btn.removeClass('is-loading').prop('disabled', false).html(originalText);
            alert(toyslandData.i18n.errorAdding);
          }
        });
      });
    },

    refreshCartUI: function(data) {
      // Update badge counters
      $('.js-cart-count').text(data.cart_count).show();
      $('.js-cart-subtotal').html(data.cart_subtotal);

      // Update Drawer content
      if (data.drawer_html) {
        $('.drawer-cart-body').html(data.drawer_html);
      }

      // Hide or show drawer footer
      if (data.cart_count === 0) {
        $('.drawer-footer').hide();
      } else {
        $('.drawer-footer').show();
      }
    },

    /* ==========================================================================
       4. Hero Carousel
       ========================================================================== */
    initHeroSlider: function() {
      const $slider = $('.hero-slider-wrapper');
      if (!$slider.length) return;

      const $slides = $slider.find('.hero-slide');
      const $dots = $slider.find('.slider-dot');
      let currentIdx = 0;
      let timer = null;
      const count = $slides.length;

      function goToSlide(idx) {
        if (idx < 0) idx = count - 1;
        if (idx >= count) idx = 0;
        currentIdx = idx;

        $slides.removeClass('is-active').eq(currentIdx).addClass('is-active');
        $dots.removeClass('is-active').eq(currentIdx).addClass('is-active');
      }

      function startTimer() {
        stopTimer();
        timer = setInterval(function() {
          goToSlide(currentIdx + 1);
        }, 5500);
      }

      function stopTimer() {
        if (timer) clearInterval(timer);
      }

      $slider.find('.slider-arrow-next').on('click', function() {
        goToSlide(currentIdx + 1);
        startTimer();
      });

      $slider.find('.slider-arrow-prev').on('click', function() {
        goToSlide(currentIdx - 1);
        startTimer();
      });

      $dots.on('click', function() {
        const idx = $(this).data('index');
        goToSlide(idx);
        startTimer();
      });

      $slider.on('mouseenter', stopTimer).on('mouseleave', startTimer);
      startTimer();
    },

    /* ==========================================================================
       5. Wishlist System
       ========================================================================== */
    initWishlist: function() {
      const self = this;

      // Update button states on page load
      $('.product-wishlist-btn').each(function() {
        const id = $(this).data('product-id');
        if (self.wishlist.includes(id)) {
          $(this).addClass('is-active');
        }
      });

      // Toggle Wishlist item
      $(document).on('click', '.product-wishlist-btn', function(e) {
        e.preventDefault();
        const $btn = $(this);
        const id = $btn.data('product-id');

        if (!id) return;

        const idx = self.wishlist.indexOf(id);
        if (idx > -1) {
          self.wishlist.splice(idx, 1);
          $btn.removeClass('is-active');
        } else {
          self.wishlist.push(id);
          $btn.addClass('is-active');
        }

        localStorage.setItem('toysland_wishlist', JSON.stringify(self.wishlist));
        self.updateWishlistCount();
      });
    },

    updateWishlistCount: function() {
      const count = this.wishlist.length;
      const $badge = $('.js-wishlist-count');
      if (count > 0) {
        $badge.text(count).show();
      } else {
        $badge.text('0').hide();
      }
    },

    /* ==========================================================================
       6. Age Filter Tabs
       ========================================================================== */
    initAgeFilter: function() {
      $('.age-tab-btn').on('click', function() {
        $('.age-tab-btn').removeClass('is-active');
        $(this).addClass('is-active');

        const ageSlug = $(this).data('age');
        const $products = $('.age-product-card');

        if (ageSlug === 'all') {
          $products.show();
        } else {
          $products.each(function() {
            const itemAge = $(this).data('age');
            if (itemAge === ageSlug || $(this).hasClass('age-' + ageSlug)) {
              $(this).fadeIn(200);
            } else {
              $(this).fadeOut(150);
            }
          });
        }
      });
    },

    /* ==========================================================================
       7. Mobile Navigation & Modals
       ========================================================================== */
    initMobileNav: function() {
      $('.mobile-nav-toggle').on('click', function() {
        $('.toysland-mobile-drawer').addClass('is-open');
        $('body').css('overflow', 'hidden');
      });

      $('.mobile-drawer-close, .mobile-drawer-backdrop').on('click', function() {
        $('.toysland-mobile-drawer').removeClass('is-open');
        $('body').css('overflow', '');
      });

      // Mobile search trigger
      $('.mobile-search-trigger').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 300);
        setTimeout(function() {
          $('.search-input').focus();
        }, 350);
      });
    }
  };

  $(document).ready(function() {
    ToysLand.init();
  });

})(jQuery);

