<?php
/*
 * Template Name: Blog Template tieubieu
 *
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); ?>
<?php
//$cat_id_custom = get_post_meta($post->ID, 'category_id', true);
//?>

<?php //query_posts('post_type=post&cat=&post_status=publish&paged='. get_query_var('paged')); ?>
<?php //get_query_var( $var, $default ) ?>

    <section id="blog" class="light-section nopaddingbottom ">

        <!-- BEGIN BLOG WIDTH | OPTION: "big", "medium" container -->
        <div class="container">

            <!-- BEGIN BLOG POSTS -->
            <div class="journal iso isotope" data-columns="3" data-gutter-space="0.25">
                <?php if (have_posts()) : ?>

                    <?php while (have_posts()) : the_post(); ?>

                        <?php get_template_part('partials/article-tieubieu'); ?>

                    <?php endwhile; ?>

                <?php else : ?>

                    <?php get_template_part('partials/nothing-found'); ?>

                <?php endif; ?>

            </div>
            <div class="center-elements">
                <?php if ($wp_query->max_num_pages>1) : ?>

                    <?php elano_pagination(); ?>

                <?php endif; ?>
            </div>
            <!-- END journal -->


        </div>
        <!-- END: BLOG CONTAINER -->
    </section>



<?php get_footer(); ?>