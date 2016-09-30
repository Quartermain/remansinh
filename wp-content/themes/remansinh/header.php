<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>
<!DOCTYPE html>
<?php
global $elano_options;
 ?>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<?php if(isset($elano_options['meta_author']) && $elano_options['meta_author']!='') : ?>
<meta name="author" content="<?php echo esc_attr($elano_options['meta_author']); ?>">	
<?php else: ?>
<meta name="author" content="<?php esc_attr(bloginfo('name')); ?>">
<?php endif; ?>
<?php if(isset($elano_options['meta_author']) && $elano_options['meta_desc']!='') : ?>
<meta name="description" content="<?php echo esc_attr($elano_options['meta_desc']); ?>">	
<?php endif; ?>
<?php if(isset($elano_options['meta_author']) && $elano_options['meta_keyword']!='') : ?>
<meta name="keyword" content="<?php echo esc_attr($elano_options['meta_keyword']); ?>">	
<?php endif; ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
<?php if(isset($elano_options['meta_head']) && $elano_options['meta_head']!='') : ?>
<title><?php echo esc_attr($elano_options['meta_head']); ?></title>
<?php else: ?>
<title><?php wp_title('-', true, 'right'); ?></title>
<?php endif; ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php if(isset($elano_options['favicon']['url'])) :  ?>
<link rel="shortcut icon" href="<?php echo esc_url($elano_options['favicon']['url']); ?>">
<?php endif; ?>

<?php
// WordPress Head
wp_head();
?>
</head> 
<!-- BEGIN BODY -->
<body  <?php body_class(); ?>>
 
<?php if ($elano_options['preloader'] == 1) : ?> 
	<div id="load">
	    <div class="loader-container">
	    	<div class="loading-css"></div>
	    	<?php if(isset($elano_options['preloader-logo']['url']) && $elano_options['preloader-logo']['url']!='') : ?>
	        <div class="loader-logo"><img src="<?php echo esc_url($elano_options['preloader-logo']['url']); ?> " data-at2x="<?php echo esc_url($elano_options['preloader-retinalogo']['url']); ?>" alt=""/></div>
	        <?php endif; ?>
	        <?php if($elano_options['preloader-title']==1): ?>
	        <h6 class="loading-heading"><?php echo esc_attr(get_bloginfo('name')); ?></h6>
	   		<?php endif; ?>
	    </div>
	</div>
<?php endif ; ?>

  	
<!-- BEGIN: FULL CONTENT DIV -->
<div class="full-content"> 

<?php
 // Navbar
get_template_part('partials/navbar');

if (!is_page_template('elano-page-builder.php') ) :
	if(get_post_type()!='portfolio'):
	get_template_part('partials/breadcrumb');
	endif;
endif;

?>