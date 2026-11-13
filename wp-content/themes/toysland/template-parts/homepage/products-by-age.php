<?php
/**
 * Products by Age Section Template Part
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

$age_groups = [
    ['slug' => 'all',   'name' => 'Բոլոր տարիքները', 'icon' => '<i class="fa-solid fa-users"></i>'],
    ['slug' => '0-1',   'name' => '0–1 տարեկան',     'icon' => '<i class="fa-solid fa-baby-carriage"></i>'],
    ['slug' => '1-3',   'name' => '1–3 տարեկան',     'icon' => '<i class="fa-solid fa-shapes"></i>'],
    ['slug' => '3-5',   'name' => '3–5 տարեկան',     'icon' => '<i class="fa-solid fa-palette"></i>'],
    ['slug' => '5-8',   'name' => '5–8 տարեկան',     'icon' => '<i class="fa-solid fa-rocket"></i>'],
    ['slug' => '8-12',  'name' => '8–12 տարեկան',    'icon' => '<i class="fa-solid fa-puzzle-piece"></i>'],
    ['slug' => '12plus','name' => '12+ տարեկան',     'icon' => '<i class="fa-solid fa-gamepad"></i>'],
];

$query = new WP_Query([
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'orderby'        => 'rand',
]);
?>
<section class="toysland-age-section">
    <div class="container">
        <div class="section-header" style="justify-content:center;text-align:center;">
            <div class="section-title-wrap">
                <span class="section-subtitle"><i class="fa-solid fa-bullseye"></i> Խաղալիքներ ըստ տարիքի</span>
                <h2 class="section-title">Ընտրեք Ձեր երեխայի տարիքը</h2>
            </div>
        </div>

        <div class="age-tabs-bar">
            <?php foreach ($age_groups as $index => $group) : ?>
                <button type="button" class="age-tab-btn <?php echo $index === 0 ? 'is-active' : ''; ?>" data-age="<?php echo esc_attr($group['slug']); ?>">
                    <span class="age-icon"><?php echo $group['icon']; ?></span>
                    <span><?php echo esc_html($group['name']); ?></span>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="products-grid age-products-grid">
            <?php
            $sample_ages = ['0-1', '1-3', '3-5', '5-8', '8-12', '12plus'];
            $i = 0;
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    $product = wc_get_product(get_the_ID());
                    if (!$product) continue;
                    $assigned_age = $sample_ages[$i % count($sample_ages)];
                    $i++;
                    ?>
                    <div class="age-product-card age-<?php echo esc_attr($assigned_age); ?>" data-age="<?php echo esc_attr($assigned_age); ?>">
                        <?php get_template_part('woocommerce/content-product'); ?>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>

