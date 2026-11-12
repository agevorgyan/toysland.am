<?php
/**
 * Page Template
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

$post_slug = get_post_field('post_name', get_post());
$legal_slugs = ['delivery', 'returns', 'privacy-policy', 'terms'];

if (in_array($post_slug, $legal_slugs, true)) {
    include locate_template('page-legal.php');
    return;
}

get_header();
?>

<div class="container" style="padding: 40px 20px 60px;">
    <?php
    while (have_posts()) : the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h1 style="font-size:32px;font-weight:900;margin-bottom:24px;"><?php the_title(); ?></h1>
            <div class="page-content" style="font-size:16px;line-height:1.7;color:var(--color-text-main);">
                <?php the_content(); ?>
            </div>
        </article>
        <?php
    endwhile;
    ?>
</div>

<?php
get_footer();

