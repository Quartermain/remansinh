<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>
<div class="space"></div>
<h4><?php _e('About the Author', 'elano'); ?></h4>
<div class="about-author">
					    
					    <div class="img-container">
						    
						     <?php echo str_replace('avatar-80', 'avatar-80', get_avatar(get_the_author_meta('email'), 80)); ?>
			            </div>
			            <h5> <?php the_author(); ?></h5>
					    <p><?php the_author_meta('description'); ?></p>
				    </div>





