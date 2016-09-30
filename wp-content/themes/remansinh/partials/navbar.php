<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>
<?php  
    global $elano_options;
    global $post;
    if(is_home()){
        $pageid=get_option('page_for_posts');
    } else {
        $pageid=get_the_ID();
    }
    
    if($menu=get_post_meta( $pageid, 'elano_menu_select',true)){
    $menu_object = get_term_by('term_taxonomy_id',$menu[0] , 'nav_menu');
    }
?>

<div class="navbar navbar-default default <?php if($elano_options['menu-style']=='dark') : ?>dark<?php endif; ?> navbar-fixed-top <?php if($elano_options['menu-start']==0 && is_page_template('elano-page-builder.php')) : echo 'hide-on-start navbar-shrik'; else:  echo 'navbar-shrink' ;endif; ?>" role="navigation">
            
            <!-- BEGIN: NAV-CONTAINER -->
            <div class="nav-container container">
                <div class="navbar-header">
                
                    <!-- BEGIN: TOGGLE BUTTON (RESPONSIVE)-->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only"><?php __( 'Toggle navigation', 'elano' ); ?></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- BEGIN: LOGO -->

         
        <?php 
        if ($elano_options['blog_title'] == 1) {
         ?>
            <a class="navbar-brand" href="<?php echo esc_url(site_url()); ?>" title="<?php echo esc_attr(get_bloginfo('name')); ?>">
                <?php echo esc_attr(get_bloginfo('name')); ?><br>     
            </a>

        <?php } else { ?>
          <a class="navbar-brand nav-to logo" href="<?php echo esc_url(site_url()); ?>" title="<?php echo esc_attr(get_bloginfo('name')); ?>">
            <img src="<?php echo esc_url($elano_options['logo']['url']); ?>" data-at2x="<?php echo esc_url($elano_options['retinalogo']['url']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" />
            </a>
        <?php } ?>
                    
                    
                   
                </div>
                
                <!-- BEGIN: MENU -->       
               
                <?php
                    if(isset($menu_object)){
                        $args = array(
                        'menu'            => $menu_object->slug,
                        'items_wrap' => '<div class="collapse navbar-collapse "><ul class="nav navbar-nav navbar-right sm">%3$s</ul></div>',
                        'echo'            => true,
                        'fallback_cb'     => 'wp_page_menu()',
                        'walker'  => new description_walker()
                    );
                    } else {

                        $args = array(
                        'theme_location' => 'primary',
                        'items_wrap' => '<div class="collapse navbar-collapse "><ul class="nav navbar-nav navbar-right sm">%3$s</ul></div>',
                        'echo'            => true,
                        'fallback_cb'     => 'wp_page_menu()',
                        'walker'  => new description_walker()
                    );

                    }
                    wp_nav_menu($args);
                

                ?>
      
               
                <!-- END: MENU -->
            </div>
            <!--END: NAV-CONTAINER -->
        </div>




