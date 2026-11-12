<?php
/**
 * Main Template File
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="container" style="padding: 40px 20px;">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1 style="font-size:32px;font-weight:900;margin-bottom:20px;"><?php the_title(); ?></h1>
                <div style="font-size:16px;line-height:1.7;color:var(--color-text-main);">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        endwhile;
    endif;
    ?>
</div>

<?php
get_footer();

