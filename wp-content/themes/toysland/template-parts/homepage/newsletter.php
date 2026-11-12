<?php
/**
 * Newsletter Section Template Part
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<section class="toysland-newsletter-section">
    <div class="container">
        <div class="newsletter-card">
            <h2 class="newsletter-title">Միացիր <span>ToysLand</span> ընտանիքին</h2>
            <p class="newsletter-desc">Ստացիր նորությունների, զեղչերի և հատուկ առաջարկների մասին տեղեկություններ, ինչպես նաև <strong>5% զեղչի պրոմո կոդ</strong> առաջին պատվերի համար:</p>
            <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Շնորհակալություն բաժանորդագրվելու համար: Ձեր պրոմո կոդն է՝ TOYSLAND5');">
                <input type="email" class="newsletter-input" placeholder="Մուտքագրեք Ձեր էլ. հասցեն..." required>
                <button type="submit" class="newsletter-submit-btn">
                    <span>Բաժանորդագրվել</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                </button>
            </form>
        </div>
    </div>
</section>

