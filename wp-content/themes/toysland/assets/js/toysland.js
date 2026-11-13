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
      this.initInfiniteScroll();
      this.initProductTabs();
      this.initMegaMenu();
      this.initCartPage();
      this.initCheckoutPage();
      this.initAuthAndAccount();
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
        $btn.html('<span class="spinner-inline"><i class="fa-solid fa-spinner fa-spin"></i></span> Ավելացվում է...');

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
    },

    /* ==========================================================================
       8. Catalog Infinite Scroll
       ========================================================================== */
    initInfiniteScroll: function() {
      const $grid = $('.js-infinite-scroll-grid');
      if (!$grid.length) return;

      let currentPage = parseInt($grid.data('current-page'), 10) || 1;
      const maxPages = parseInt($grid.data('max-pages'), 10) || 1;
      let nextUrl = $grid.data('next-url');
      let isLoading = false;

      const $loader = $('#infiniteScrollLoader');
      const $done = $('#infiniteScrollDone');
      const sentinel = document.getElementById('infiniteScrollSentinel');

      if (currentPage >= maxPages || !sentinel) {
        if ($done.length && maxPages > 1) $done.show();
        return;
      }

      const self = this;

      const loadNextPage = function() {
        if (isLoading || currentPage >= maxPages || !nextUrl) return;

        isLoading = true;
        $loader.css('display', 'inline-flex');

        fetch(nextUrl, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
          .then(function(res) {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.text();
          })
          .then(function(html) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newGrid = doc.querySelector('.js-infinite-scroll-grid') || doc.querySelector('.products-grid');

            if (newGrid) {
              const newCards = newGrid.querySelectorAll('.product-card');
              if (newCards.length > 0) {
                newCards.forEach(function(card) {
                  card.style.opacity = '0';
                  card.style.transform = 'translateY(16px)';
                  card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                  $grid[0].appendChild(card);

                  requestAnimationFrame(function() {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                  });
                });

                // Re-bind wishlist button state on newly loaded products
                self.initWishlist();

                currentPage++;
                $grid.attr('data-current-page', currentPage);

                // Update browser address bar without reload
                if (window.history && window.history.replaceState) {
                  window.history.replaceState({}, '', nextUrl);
                }

                // Discover next page URL from fetched content
                const fetchedGrid = doc.querySelector('.js-infinite-scroll-grid');
                if (fetchedGrid && fetchedGrid.dataset.nextUrl) {
                  nextUrl = fetchedGrid.dataset.nextUrl;
                } else {
                  const nextLink = doc.querySelector('.shop-pagination-wrap .next, .pagination .next, .nav-links .next');
                  nextUrl = nextLink ? nextLink.getAttribute('href') : null;
                }

                if (currentPage >= maxPages || !nextUrl) {
                  $loader.hide();
                  $done.show();
                  if (observer && sentinel) observer.unobserve(sentinel);
                }
              } else {
                $loader.hide();
                $done.show();
                if (observer && sentinel) observer.unobserve(sentinel);
              }
            } else {
              $loader.hide();
              $done.show();
            }
          })
          .catch(function(err) {
            console.warn('Infinite scroll request failed:', err);
            $loader.hide();
          })
          .finally(function() {
            isLoading = false;
            if (currentPage < maxPages && nextUrl) {
              $loader.hide();
            }
          });
      };

      let observer = null;
      if ('IntersectionObserver' in window) {
        observer = new IntersectionObserver(function(entries) {
          entries.forEach(function(entry) {
            if (entry.isIntersecting) {
              loadNextPage();
            }
          });
        }, {
          root: null,
          rootMargin: '400px 0px',
          threshold: 0.05
        });

        observer.observe(sentinel);
      } else {
        $(window).on('scroll.infiniteScroll', function() {
          if (!sentinel) return;
          const rect = sentinel.getBoundingClientRect();
          if (rect.top <= window.innerHeight + 400) {
            loadNextPage();
          }
        });
      }
    },

    /* ==========================================================================
       9. Single Product Interactive Tabs
       ========================================================================== */
    initProductTabs: function() {
      $(document).on('click', '.product-tab-btn', function(e) {
        e.preventDefault();
        const $btn = $(this);
        const tabId = $btn.data('tab');

        $('.product-tab-btn').removeClass('is-active');
        $btn.addClass('is-active');

        $('.product-tab-pane').removeClass('is-active');
        $('#tab-' + tabId).addClass('is-active');
      });
    },

    /* ==========================================================================
       10. Desktop Mega Menu Interactions
       ========================================================================== */
    initMegaMenu: function() {
      const $menuItem = $('#navCategoriesItem');
      const $btn = $('#categoriesMenuBtn');
      if (!$menuItem.length || !$btn.length) return;

      $btn.on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const isOpen = $menuItem.hasClass('is-open');
        $menuItem.toggleClass('is-open', !isOpen);
        $btn.attr('aria-expanded', !isOpen);
      });

      // Close mega menu on outside click or Esc key
      $(document).on('click', function(e) {
        if (!$(e.target).closest('#navCategoriesItem').length) {
          $menuItem.removeClass('is-open');
          $btn.attr('aria-expanded', 'false');
        }
      });

      $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
          $menuItem.removeClass('is-open');
          $btn.attr('aria-expanded', 'false');
        }
      });
    },

    /* ==========================================================================
       11. Cart Page Interactive Stepper & AJAX Sync
       ========================================================================== */
    initCartPage: function() {
      const self = this;
      const $cartPage = $('.toysland-cart-page');
      if (!$cartPage.length) return;

      // Coupon toggle
      $(document).on('click', '.js-coupon-toggle', function(e) {
        e.preventDefault();
        $(this).toggleClass('is-active');
        $('.js-coupon-panel').toggleClass('is-open');
      });

      // Quantity Plus / Minus
      $(document).on('click', '.js-cart-plus, .js-cart-minus', function(e) {
        e.preventDefault();
        const $btn = $(this);
        const key = $btn.data('key');
        const isPlus = $btn.hasClass('js-cart-plus');
        const $row = $btn.closest('.js-cart-item-row');
        const $input = $row.find('.js-cart-qty-input');
        let currentQty = parseInt($input.val(), 10) || 1;
        let newQty = isPlus ? currentQty + 1 : currentQty - 1;

        if (newQty < 1) return;

        $input.val(newQty);
        $row.css('opacity', '0.6');

        $.ajax({
          url: toyslandData.ajaxUrl,
          type: 'POST',
          data: {
            action: 'toysland_update_cart_qty',
            cart_item_key: key,
            quantity: newQty
          },
          success: function(res) {
            $row.css('opacity', '1');
            if (res.success) {
              const data = res.data;
              if (data.line_subtotal) {
                $row.find('.js-item-subtotal').html(data.line_subtotal);
              }
              self.updateCartPageUI(data);
              self.refreshCartUI(data);
            }
          },
          error: function() {
            $row.css('opacity', '1');
          }
        });
      });

      // Cart Item Remove
      $(document).on('click', '.js-cart-remove-item', function(e) {
        e.preventDefault();
        const $btn = $(this);
        const key = $btn.data('key');
        const $row = $btn.closest('.js-cart-item-row');

        $row.css('opacity', '0.4');

        $.ajax({
          url: toyslandData.ajaxUrl,
          type: 'POST',
          data: {
            action: 'toysland_update_cart_qty',
            cart_item_key: key,
            quantity: 0
          },
          success: function(res) {
            if (res.success) {
              const data = res.data;
              $row.slideUp(250, function() {
                $(this).remove();
                if (data.is_empty || $('.js-cart-item-row').length === 0) {
                  window.location.reload();
                }
              });
              self.updateCartPageUI(data);
              self.refreshCartUI(data);
            } else {
              $row.css('opacity', '1');
            }
          },
          error: function() {
            $row.css('opacity', '1');
          }
        });
      });
    },

    updateCartPageUI: function(data) {
      // Update item count badges
      $('.js-cart-badge-count').text(data.cart_count + ' ապրանք');
      $('.js-summary-badge').text(data.cart_count + ' ապրանք');

      // Update Order Summary Subtotal & Total
      if (data.cart_subtotal) {
        $('.js-summary-subtotal').html(data.cart_subtotal);
      }
      if (data.cart_total) {
        $('.js-summary-total').html(data.cart_total);
      }

      // Update Shipping
      if (data.is_free_shipping) {
        $('.js-summary-shipping').html('<span class="shipping-free-pill">Անվճար</span>');
      } else {
        $('.js-summary-shipping').html('<span>' + data.shipping_text + '</span>');
      }

      // Update Free Shipping Progress Banner
      const $banner = $('.js-shipping-banner');
      if ($banner.length) {
        if (data.is_free_shipping) {
          $banner.addClass('is-free-unlocked');
          $banner.find('.js-shipping-icon').html('<i class="fa-solid fa-award"></i>');
          $banner.find('.js-shipping-msg').html('<strong>Շնորհավորո՜ւմ ենք:</strong> Դուք ստացել եք <strong>ԱՆՎՃԱՐ ԱՌԱՔՈՒՄ</strong> Երևանում:');
          $banner.find('.js-shipping-percent').text('100%');
          $banner.find('.js-shipping-fill').css('width', '100%');
        } else {
          $banner.removeClass('is-free-unlocked');
          $banner.find('.js-shipping-icon').html('<i class="fa-solid fa-truck-fast"></i>');
          $banner.find('.js-shipping-msg').html('Ավելացրեք ևս <strong class="js-shipping-remain">' + data.free_shipping_remaining + '</strong>-ի ապրանք՝ <strong>ԱՆՎՃԱՐ ԱՌԱՔՄԱՆ</strong> համար (Երևանում 15 000 ֏-ից):');
          $banner.find('.js-shipping-percent').text(data.free_shipping_percent + '%');
          $banner.find('.js-shipping-fill').css('width', data.free_shipping_percent + '%');
        }
      }
    },

    /* ==========================================================================
       12. Checkout Page Enhancements
       ========================================================================== */
    initCheckoutPage: function() {
      const $checkoutPage = $('.toysland-checkout-page');
      if (!$checkoutPage.length) return;

      // Phone Input Auto-Formatting for Armenia
      $(document).on('input', '#billing_phone', function() {
        let val = $(this).val().replace(/[^\d+]/g, '');
        if (val.startsWith('0') && val.length > 1) {
          val = '+374 ' + val.substring(1);
        } else if (val.startsWith('374') && !val.startsWith('+374')) {
          val = '+' + val;
        } else if (!val.startsWith('+374') && val.length > 0 && !val.startsWith('+')) {
          val = '+374 ' + val;
        }
        $(this).val(val);
      });

      // Payment Method Click Highlight
      $(document).on('change', 'input[name="payment_method"]', function() {
        $('.wc_payment_method').removeClass('is-chosen');
        $(this).closest('.wc_payment_method').addClass('is-chosen');
      });
    },

    /* ==========================================================================
       13. Authentication & My Account Tabs & Interactions
       ========================================================================== */
    initAuthAndAccount: function() {
      // Tab switching on Login/Register
      $(document).on('click', '.js-auth-tab', function(e) {
        e.preventDefault();
        const targetId = $(this).data('target');
        
        $('.js-auth-tab').removeClass('is-active');
        $(this).addClass('is-active');

        $('.js-auth-panel').removeClass('is-active');
        $(targetId).addClass('is-active');

        // Focus first input
        $(targetId).find('input:visible:first').focus();
      });

      // Password Visibility Toggle
      $(document).on('click', '.js-toggle-pwd', function(e) {
        e.preventDefault();
        const $btn = $(this);
        const $wrap = $btn.closest('.auth-input-wrap');
        const $input = $wrap.find('.js-password-input');
        const $openEye = $btn.find('.pwd-eye-open');
        const $closedEye = $btn.find('.pwd-eye-closed');

        if ($input.attr('type') === 'password') {
          $input.attr('type', 'text');
          $openEye.hide();
          $closedEye.show();
        } else {
          $input.attr('type', 'password');
          $openEye.show();
          $closedEye.hide();
        }
      });
    }
  };

  $(document).ready(function() {
    ToysLand.init();
  });

})(jQuery);

