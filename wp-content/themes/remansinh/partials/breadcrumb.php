<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} 
global $elano_options;
?>
<div class="pagetitle black-section light-text <?php if(isset($elano_options['ptitle-parallax']) && $elano_options['ptitle-parallax']==1) { echo 'panel-row-style-parallax'; } ?>">
            
    <div class="title">
        <div class="section-title container light">
            
            <?php if (is_home()) :?>
            <h2><?php _e('BLOG', 'elano'); ?></h2>
            <?php elseif (is_single()) :?>
            <h2><?php echo get_the_title(); ?></h2>
            <?php elseif (is_page()) : ?>
            <h2><?php echo get_the_title(); ?></h2>
            <?php elseif (is_author()) : ?>
            <h2><?php _e('AUTHOR', 'elano'); ?></h2>
            <?php elseif (is_search()) : ?>
            <h2><?php _e('SEARCH', 'elano'); ?></h2>
            <?php elseif (is_category()) : ?>
            <h2>&#8216;<?php single_cat_title(); ?>&#8217;<?php _e('', 'elano'); ?></h2>
            <?php elseif (is_tag()) : ?>
            <h2>&#8216;<?php single_tag_title(); ?>&#8217;<?php _e('', 'elano'); ?></h2>
            <?php elseif (is_archive()) : ?>
            <?php if (get_post_type() == 'product') : ?>
            <h2><?php _e('Sản Phẩm', 'elano'); ?></h2>
            <?php else: ?>
            <h2><?php _e('ARCHIVE', 'elano'); ?></h2>
            <?php endif; ?>
            <?php elseif (get_post_type() == 'product') : ?>
            <h2><?php _e('Sản Phẩm', 'elano'); ?></h2>
            <?php endif; ?>
            </h2>
        </div>
    </div>                    
</div>