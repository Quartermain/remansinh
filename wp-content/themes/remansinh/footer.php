<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

        </div>
<?php  global $elano_options; ?>
     
       <div class="footer">
               
                <!-- BEGIN BOTTOM FOOTER -->
                <div class="container">
                    
                    <div id="bottom-footer" class="text-center">
                        <?php get_template_part('partials/footer-layout'); ?>          

                        <?php if(isset($elano_options['footer-logo']['url']) && $elano_options['footer-logo']['url']!='') :  ?> 
                        <!-- BEGIN: LOGO FOOTER -->
                        <div class="logo-footer">
                             <img src="<?php echo esc_url($elano_options['footer-logo']['url']); ?>" data-at2x="<?php echo esc_url($elano_options['footer-retinalogo']['url']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" />
                        </div>
                        <?php endif; ?>
                        
                        <!-- BEGIN: ICONS FOOTER -->
                        <div class="socialdiv colored">
                            <ul>
                                <?php if (!empty($elano_options['social_facebook'])) : ?>
                                <li><a class="facebook" href="<?php  echo esc_url($elano_options['social_facebook']); ?>" target="_blank" data-original-title="" title=""></a></li>
                                <?php endif; ?><?php if (!empty($elano_options['social_twitter'])) : ?>
                                <li><a class="twitter" href="<?php  echo esc_url($elano_options['social_twitter']); ?>" target="_blank" data-original-title="" title=""></a></li>
                                <?php endif; ?><?php if (!empty($elano_options['social_googlep'])) : ?>
                                <li><a class="google" href="<?php  echo esc_url($elano_options['social_googlep']); ?>" target="_blank" data-original-title="" title=""></a></li>
                                <?php endif; ?><?php if (!empty($elano_options['social_youtube'])) : ?>
                                <li><a class="youtube" href="<?php  echo esc_url($elano_options['social_youtube']); ?>" target="_blank" data-original-title="" title=""></a></li>
                                <?php endif; ?><?php if (!empty($elano_options['social_linkedin'])) : ?>
                                <li><a class="linkedin" href="<?php  echo esc_url($elano_options['social_linkedin']); ?>" target="_blank" data-original-title="" title=""></a></li>
                                <?php endif; ?><?php if (!empty($elano_options['social_pinterest'])) : ?>
                                <li><a class="pinterest" href="<?php  echo esc_url($elano_options['social_pinterest']); ?>" target="_blank" data-original-title="" title=""></a></li>
                                <?php endif; ?><?php if (!empty($elano_options['social_dribbble'])) : ?>
                                <li><a class="dribbble" href="<?php  echo esc_url($elano_options['social_dribbble']); ?>" target="_blank" data-original-title="" title=""></a></li>
                                <?php endif; ?><?php if (!empty($elano_options['social_skype'])) : ?>
                                <li><a class="skype" href="<?php  echo esc_url($elano_options['social_skype']); ?>" target="_blank" data-original-title="" title=""></a></li>
                                <?php endif; ?><?php if (!empty($elano_options['social_vimeo'])) : ?>
                                <li><a class="vimeo" href="<?php  echo esc_url($elano_options['social_vimeo']); ?>" target="_blank" data-original-title="" title=""></a></li>
                                <?php endif; ?><?php if (!empty($elano_options['social_tumblr'])) : ?>
                                <li><a class="tumblr" href="<?php  echo esc_url($elano_options['social_tumblr']); ?>" target="_blank" data-original-title="" title=""></a></li>
                                <?php endif; ?>
                            </ul>   
                        </div>       
                        <?php if(isset($elano_options['footer_text'])) :  ?> 
                        <!-- BEGIN: COPYRIGHTS -->
                        <div class="b-text">
                            <p><?php  echo wp_kses_post($elano_options['footer_text']); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div><!-- END BOTTOM FOOTER -->        
            </div>

        <p id="back-top"><a href="#home"><i class="fa fa-angle-up"></i></a></p>
        
    </div>  
    </div>
    <?php wp_footer(); ?>
    
    <!-- Don't forget analytics -->
    <?php if(isset($elano_options['meta_javascript']) && $elano_options['meta_javascript']!='') 
    echo $elano_options['meta_javascript']; ?>  
    </body>
</html>