<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

<?php if (get_next_post_link('&laquo; %link', '%title', 1) OR get_previous_post_link('%link &raquo;', '%title', 1)) : ?>


       <div class="prev-next-btn">

                <?php if($prevPost = get_previous_post(true)) :?>
                <a href="<?php echo $prevPost->guid; ?>" class="previous-post"><i class="fa fa-arrow-circle-left"> </i><?php _e('Previous Post', 'elano'); ?> </a>
                <?php endif; ?>


                <?php if($nextPost = get_next_post(true)) : ?>
                <a href="<?php echo $nextPost->guid; ?>" class="next-post"> <?php _e('Next Post', 'elano'); ?> <i class="fa fa-arrow-circle-right"></i></a>
                <?php endif; ?>

        </div>
 

<?php endif; ?>

