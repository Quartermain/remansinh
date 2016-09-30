<?php
/**
 * Elano functions file.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();}

global $elano_options;


if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/ReduxCore/framework.php' ) ) {
    require_once( dirname( __FILE__ ) . '/ReduxCore/framework.php' );
}
if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/ReduxCore/sample-config.php' ) ) {
    require_once( dirname( __FILE__ ) . '/ReduxCore/sample-config.php' );
}

/*********************************************************************
* THEME SETUP
*/

function elano_setup() {

    global $elano_options;

    // Translations support. Find language files in elano/languages
    load_theme_textdomain('elano', get_template_directory().'/languages');
    $locale = get_locale();
    $locale_file = get_template_directory()."/languages/{$locale}.php";
    if(is_readable($locale_file)) { require_once($locale_file); }

    // Set content width
    global $content_width;
    if (!isset($content_width)) $content_width = 720;

    // Editor style (editor-style.css)
    add_editor_style(array('assets/css/editor-style.css'));

    // Load plugin checker
    require(get_template_directory() . '/inc/plugin-activation.php');

    //Include all post types
    require(get_template_directory() . '/inc/custom_post_types.php');



    // Widget areas
    if (function_exists('register_sidebar')) :
        // Sidebar right
        register_sidebar(array(
            'name' => "Blog Sidebar",
            'id' => "elano-widgets-aside-right",
            'description' => __('Widgets placed here will display in the right sidebar', 'elano'),
            'before_widget' => '<div id="%1$s" class="well well-sm widget %2$s">',
            'after_widget'  => '</div>'
        ));

        // Woocommerce sidebar
        register_sidebar(array(
            'name' => "WooCommerce Sidebar",
            'id' => "elano-widgets-woocommerce-sidebar",
            'description' => __('Widgets placed here will display in the product page sidebar', 'elano'),
            'before_widget' => '<div id="%1$s" class="well well-sm widget %2$s">',
            'after_widget'  => '</div>'
        ));
        // Footer Block 1
        register_sidebar(array(
            'name' => "Footer Block 1",
            'id' => "elano-widgets-footer-block-1",
            'description' => __('Widgets placed here will display in the first footer block', 'elano'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ));
        // Footer Block 2
        register_sidebar(array(
            'name' => "Footer Block 2",
            'id' => "elano-widgets-footer-block-2",
            'description' => __('Widgets placed here will display in the second footer block', 'elano'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ));
        // Footer Block 3
        if(isset($elano_options['footer-layout']) && esc_attr($elano_options['footer-layout'])>5) {
        register_sidebar(array(
            'name' => "Footer Block 3",
            'id' => "elano-widgets-footer-block-3",
            'description' => __('Widgets placed here will display in the third footer block', 'elano'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ));
        }

        // Footer Block 4
        if(isset($elano_options['footer-layout']) && esc_attr($elano_options['footer-layout'])>9) {
        register_sidebar(array(
            'name' => "Footer Block 4",
            'id' => "elano-widgets-footer-block-4",
            'description' => __('Widgets placed here will display in the third footer block', 'elano'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ));
        }
       
    endif;

    // Nav Menu (Custom menu support)
    if (function_exists('register_nav_menu')) :
        register_nav_menu('primary', __('Elano Primary Menu', 'elano'));
    endif;

    // Theme Features: Automatic Feed Links
    add_theme_support('automatic-feed-links');

    // Theme Features: woocommerce
    add_theme_support( 'woocommerce' );


    // Theme Features: Post Thumbnails and custom image sizes for post-thumbnails
    add_theme_support('post-thumbnails', array('post', 'page','product','portfolio'));

    // Theme Features: Post Formats
    add_theme_support('post-formats', array( 'gallery', 'image', 'link', 'quote', 'video', 'audio'));


    
}
add_action('after_setup_theme', 'elano_setup');



// The excerpt "more" button
function elano_excerpt($text) {
    return str_replace('[&hellip;]', '[&hellip;]<a class="" title="'. sprintf (__('Read more on %s','elano'), get_the_title()).'" href="'.get_permalink().'">' . __(' Read more','elano') . '</a>', $text);
}
add_filter('the_excerpt', 'elano_excerpt');

function elano_more_link($more_link, $more_link_text) {
    return str_replace($more_link_text, '[&hellip;]<a class="" title="'. sprintf (__('Read more on %s','elano'), get_the_title()).'" href="'.get_permalink().'">' . __(' Read more','elano') . '</a>', $more_link_text );
}
add_filter('the_content_more_link', 'elano_more_link', 10, 2);

// wp_title filter
function elano_title($output) {
    echo $output;
    // Add the blog name
    bloginfo('name');
    // Add the blog description for the home/front page
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page())) echo ' - '.$site_description;
    // Add a page number if necessary
    if (!empty($paged) && ($paged >= 2 || $page >= 2)) echo ' - ' . sprintf(__('Page %s', 'elano'), max($paged, $page));
}
add_filter('wp_title', 'elano_title');

/*********************************************************************
 * Function to load all theme assets (scripts and styles) in header
 */
function elano_load_theme_assets() {

    global $elano_options;
    // HTML5shiv

    // Do not know any method to enqueue a script with conditional tags!
    echo '
    <!--[if lt IE 9]>
      <script src="'. get_template_directory_uri() .'http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>

    <![endif]-->

    ';
     //Enqueue google fonts 
    wp_enqueue_style('googlefont-Raleway', 'http://fonts.googleapis.com/css?family=Raleway:100,300,400,600,800');
    wp_enqueue_style('googlefont-opensans', 'http://fonts.googleapis.com/css?family=Open+Sans:100,300,600,800');
    wp_enqueue_style('googlefont-vollkorn', 'http://fonts.googleapis.com/css?family=Vollkorn:400italic,400');
    if(isset($elano_options['typography-body']['font-family']) && $elano_options['typography-body']['font-family']!=''&& $elano_options['typography-body']['font-weight']!='') {
    wp_enqueue_style('googlefont-custom', 'http://fonts.googleapis.com/css?family='.esc_attr($elano_options['typography-body']['font-family']));
    }
    if(isset($elano_options['typography-h1']['font-family']) && $elano_options['typography-h1']['font-family']!=''&& $elano_options['typography-h1']['font-weight']!='') {
    wp_enqueue_style('googlefont-h1', 'http://fonts.googleapis.com/css?family='.esc_attr($elano_options['typography-h1']['font-family']));
    }
    if(isset($elano_options['typography-h2']['font-family']) && $elano_options['typography-h2']['font-family']!=''&& $elano_options['typography-h2']['font-weight']!='') {
    wp_enqueue_style('googlefont-h2', 'http://fonts.googleapis.com/css?family='.esc_attr($elano_options['typography-h2']['font-family']));
    }
    if(isset($elano_options['typography-h3']['font-family']) && $elano_options['typography-h3']['font-family']!=''&& $elano_options['typography-h3']['font-weight']!='') {
    wp_enqueue_style('googlefont-h3', 'http://fonts.googleapis.com/css?family='.esc_attr($elano_options['typography-h3']['font-family']));
    }
    if(isset($elano_options['typography-h4']['font-family']) && $elano_options['typography-h4']['font-family']!=''&& $elano_options['typography-h4']['font-weight']!='') {
    wp_enqueue_style('googlefont-h4', 'http://fonts.googleapis.com/css?family='.esc_attr($elano_options['typography-h4']['font-family']));
    }
    if(isset($elano_options['typography-h5']['font-family']) && $elano_options['typography-h5']['font-family']!=''&& $elano_options['typography-h5']['font-weight']!='') {
    wp_enqueue_style('googlefont-h5', 'http://fonts.googleapis.com/css?family='.$elano_options['typography-h5']['font-family']);
    }
    if(isset($elano_options['typography-h6']['font-family']) && $elano_options['typography-h6']['font-family']!=''&& $elano_options['typography-h6']['font-weight']!='') {
    wp_enqueue_style('googlefont-h6', 'http://fonts.googleapis.com/css?family='.$elano_options['typography-h6']['font-family']);
    }
    // Enqueue all the theme CSS
    wp_enqueue_style('bootstrap', get_template_directory_uri().'/assets/css/bootstrap.css');
    wp_enqueue_style('main', get_stylesheet_directory_uri().'/style.css');
    wp_enqueue_style('animate', get_template_directory_uri().'/assets/css/animate.css');
    wp_enqueue_style('retina', get_template_directory_uri().'/assets/css/retina.css');
    wp_enqueue_style('font-awesome', get_template_directory_uri().'/assets/libs/font-awesome/css/font-awesome.min.css');
    wp_enqueue_style('owl.carousel', get_template_directory_uri().'/assets/css/owl.carousel.css');
    wp_enqueue_style('YTPlayer', get_template_directory_uri().'/assets/css/YTPlayer.css');
    wp_enqueue_style('cubeportfolio', get_template_directory_uri().'/assets/css/cubeportfolio.css');
    wp_enqueue_style('nivo-lightbox', get_template_directory_uri().'/assets/css/nivo-lightbox.css');
    wp_enqueue_style('nivo_themes', get_template_directory_uri().'/assets/css/nivo_themes/default/default.css');
    wp_enqueue_style('woocm-uxqode', get_template_directory_uri().'/assets/css/woocommerce-ux.css');
    wp_enqueue_style('woo-layout-ux', get_template_directory_uri().'/assets/css/woo-layout-ux.css');
    
    // Enqueue Color variation CSS
    if (!empty($elano_options['css_style']) ) :
        wp_enqueue_style('elano-style-css', get_stylesheet_directory_uri().'/assets/css/color-variations/'.esc_attr($elano_options['css_style']).'.css');
    else :
        wp_enqueue_style('elano-style-css', get_stylesheet_directory_uri().'/assets/css/color-variations/pink.css');
    endif;

    wp_enqueue_style('resize', get_template_directory_uri().'/assets/css/resize.css');

   
   // Enqueue all the js files of theme
    wp_enqueue_script('jquery');
    wp_enqueue_script('utils-js', get_template_directory_uri().'/assets/js/utils.js', array(), FALSE, TRUE);
    wp_enqueue_script('retina-min', get_template_directory_uri().'/assets/js/retina.min.js', array(), FALSE, TRUE);
    wp_enqueue_script('isotope-min', get_template_directory_uri().'/assets/js/isotope-min.js', array(), FALSE, TRUE);
    wp_enqueue_script('queryloader.min', get_template_directory_uri().'/assets/js/queryloader.min.js', array(), FALSE, TRUE);
    wp_enqueue_script('bootstrap.min', get_template_directory_uri().'/assets/js/bootstrap.min.js', array(), FALSE, TRUE);
    wp_enqueue_script('smartmenus.min', get_template_directory_uri().'/assets/js/smartmenus.min.js', array(), FALSE, TRUE);
    wp_enqueue_script('ytplayer', get_template_directory_uri().'/assets/js/ytplayer.js', array(), FALSE, TRUE);
    wp_enqueue_script('animate', get_template_directory_uri().'/assets/js/wow.js', array(), TRUE, TRUE);
    wp_enqueue_script('main-js', get_template_directory_uri().'/assets/js/main.js', array(), FALSE, TRUE);
    wp_enqueue_script('SmoothScroll-js', get_template_directory_uri().'/assets/js/SmoothScroll.js', array(), FALSE, TRUE);
    wp_enqueue_script('nivo-lightbox.min-js', get_template_directory_uri().'/assets/js/nivo-lightbox.min.js', array(), FALSE, TRUE);
    wp_enqueue_script('owl.carousel.min-js', get_template_directory_uri().'/assets/js/owl.carousel.min.js', array(), FALSE, TRUE);
    
    $inline_css='';
     
     if(isset($elano_options['preloader-image']) && $elano_options['preloader-image']!=1){
        $inline_css.='
        #load .loader-container {
        margin-top:-80px;
        }';
     }


    if(isset($elano_options['footer-style2']) && $elano_options['footer-style2']==1) {
    $inline_css.='
    .socialdiv, .socialdiv{
        width: 48%;
        float: right;
        top: 10px;    
    }
    .socialdiv ul li, .socialdiv ul li{
        float: right;
    }
    .logo-footer {
        width: 50%;
        text-align: left;
    }
    .b-text{
        text-align: left;
        padding-left: 15px;
    }
    .team-details{
        text-align: left;
    }
    .cbp-l-filters-alignCenter {
        text-align: left !important;
        font-size: 13px !important;
        background: transparent !important;
        padding: 15px 0 20px 0 !important;
        position: relative;
        top: -30px;
        left: 0;
    }';
    }

    if ( is_admin_bar_showing() ) {
     $inline_css.='
     .navbar {
     margin-top: 32px;
     }
     @media screen and (max-width: 782px){
         .navbar {
         margin-top: 40px;
         }
     }
    ';
    }

   
    if(is_home()){
        $pageid=get_option('page_for_posts');
    } else {
        $pageid=get_the_ID();
    }
    $inline_css.='.pagetitle .section-title h2{';
    if($epcolor=get_post_meta( $pageid, 'elano_pagetitle_color',true)){
         $inline_css.='color:'.$epcolor.' !important;';
    }
     $inline_css.='} .pagetitle {';
    if($epbgcolor=get_post_meta( $pageid, 'elano_pagetitle_bgcolor',true)){
         $inline_css.='background-color:'.$epbgcolor.'!important;';
    }
    if($epbgimage=get_post_meta( $pageid, 'elano_pagetitle_image',true)){
        $inline_css.='background-image:url('.$epbgimage.')!important;';
    }
     $inline_css.='}';
   
    if(isset($elano_options['extra-css'])){
    $inline_css.=$elano_options['extra-css'];  
    }
    wp_add_inline_style( 'main', $inline_css );

    $color_variation ='';
    if(isset($elano_options['custom_color']) && $elano_options['custom_color']!=''){
          $hex = str_replace("#", "", esc_attr($elano_options['custom_color']));

           if(strlen($hex) == 3) {
              $r = hexdec(substr($hex,0,1).substr($hex,0,1));
              $g = hexdec(substr($hex,1,1).substr($hex,1,1));
              $b = hexdec(substr($hex,2,1).substr($hex,2,1));
           } else {
              $r = hexdec(substr($hex,0,2));
              $g = hexdec(substr($hex,2,2));
              $b = hexdec(substr($hex,4,2));
           }
           $new_custom_color = array($r, $g, $b);

    $color_variation='
    .navbar-default.style1 .navbar-nav > .open > a, .navbar-default.style1 .navbar-nav > .open > a:hover, .navbar-default.style1 .navbar-nav > .open > a:focus{color: #fff;}
    a, .pageXofY .pageX, .pricing .bestprice .name, .filter li a:hover, .widget ul li a:hover, #contacts a:hover, .title-color, .ms-staff-carousel .ms-staff-info h4, .filter li a:hover, .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus, .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus, a.go-about:hover, .text_color, .navbar-nav .dropdown-menu a:hover, .profile .profile-name, #elements h4, #contact li a:hover, #agency-slider h5, .ms-showcase1 .product-tt h3, .filter li a.active, .contacts li i, .big-icon i, .navbar-default.dark .navbar-brand:hover,.navbar-default.dark .navbar-brand:focus, a.p-button.border:hover, .navbar-default.default .navbar-nav > li > a.selected, .navbar-default.default .navbar-nav > li > a.selected:hover, .navbar-default.default .navbar-nav > li > a.selected, .navbar-default.default .navbar-nav > .open > a,.navbar-default.default .navbar-nav > .open > a:hover, .navbar-default.default .navbar-nav > .open > a:focus, .default .dropdown-menu > li > a:hover, .default .dropdown-menu > li > a:focus, .navbar-default.dark.default .dropdown-menu > li > a:hover, a.social:hover:before, .symbol.colored i, .icon-nofill, .slidecontent-bi .project-title-bi p a:hover, .grid .figcaption a.thumb-link:hover, .tp-caption a:hover, .btn-1d:hover, .btn-1d:active, #contacts .tweet_text a, #contacts .tweet_time a, .social-font-awesome li a:hover, h2.post-title a:hover, .tags a:hover, .btn-color span, #contacts .form-success p, .center-icon i, .cbp-l-filters-alignCenter .cbp-filter-item-active, .collapse-group .collapse-heading h4 a:hover, .collapse-group .collapse-heading h4 a, .social-icomoon a:hover, .team-details .team-position, .blog-nav a:hover, a:hover .text-inner, .cbp-l-filters-alignCenter .cbp-filter-item:hover, .btn-color{
      color: '.esc_attr($elano_options['custom_color']).';
    }
    a.sf-button.hide-icon, .tabs li.current, .readmore:hover, .navbar-default .navbar-nav > .open > a,.navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus, a.p-button:hover, a.p-button.colored, .navbar-default.style1 .navbar-nav > li > a.selected, .light #contacts a.p-button, .tagcloud a:hover, .rounded.fill, .colored-section, .pricing .bestprice .price, .pricing .bestprice .signup, .signup:hover, .divider.colored, .services-graph li span, .no-touch .hi-icon-effect-1a .hi-icon:hover, .hi-icon-effect-1b .hi-icon:hover, .dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus, .no-touch .hi-icon-effect-1b .hi-icon:hover, .symbol.colored .line-left, .symbol.colored .line-right, .projects-overlay #projects-loader, .panel-group .panel.active .panel-heading, .mail-box, .double-bounce1, .double-bounce2, .btn-color-1d:after, .container1 > div, .container2 > div, .container3 > div, .cbp-l-caption-buttonLeft:hover, .cbp-l-caption-buttonRight:hover, .btn-color:hover, .collapse-group .collapse-heading h4 a:hover .toggle-icon, .collapse-group .collapse-heading h4 a .toggle-icon, .hi-icon-effect-1 .hi-icon, .post-type, .blog-nav span, #back-top a:hover, .btn-color-fill{
        background-color:'.esc_attr($elano_options['custom_color']).';
    }
    .blog-nav span, .blog-nav a:hover{border: 1px solid '.esc_attr($elano_options['custom_color']).';}
    .hi-icon-effect-1 .hi-icon:after{box-shadow: 0 0 0 1px '.esc_attr($elano_options['custom_color']).';}
    .colored-section:after {border: 20px solid '.esc_attr($elano_options['custom_color']).';}
    .filter li a.active, .filter li a:hover, .panel-group .panel.active .panel-heading{border:1px solid '.esc_attr($elano_options['custom_color']).'}
    a.p-button.colored:hover{background-color: '.esc_attr($elano_options['custom_color']).';}
    .navbar-default.default.border .navbar-nav > li > a.selected:before, .navbar-default.default.border .navbar-nav > li > a.selected:hover, .navbar-default.default.border .navbar-nav > li > a.selected{
        border-bottom: 1px solid '.esc_attr($elano_options['custom_color']).';
    }
    .bs-callout-theme-color {
        background-color: '.esc_attr($elano_options['custom_color']).';
        border-color: '.esc_attr($elano_options['custom_color']).';
    }
    .overlay-color, #featured-projects .cbp-caption:hover .cbp-caption-activeWrap, .cbp-caption-zoom .cbp-caption-activeWrap{
        background-color: rgba('.$new_custom_color['0'].','.$new_custom_color['1'].','.$new_custom_color['2'].', 0.9);
    }
    .overlay-color.medium, .cbp-caption-minimal .cbp-caption-activeWrap, .skill-bar-percent, .post-content .featured-image a:hover .hover-image-blog{
        background-color: rgba('.$new_custom_color['0'].','.$new_custom_color['1'].','.$new_custom_color['2'].', 0.80);
    }
    .triangle{border-left-color: '.esc_attr($elano_options['custom_color']).' !important;}
    .overlay-color.soft{
        background-color: rgba('.$new_custom_color['0'].','.$new_custom_color['1'].','.$new_custom_color['2'].', 0.25);
    }
    .cbp-l-filters-alignCenter .cbp-filter-counter{
        background: none repeat scroll 0 0 '.esc_attr($elano_options['custom_color']).';
        border: 1px solid '.esc_attr($elano_options['custom_color']).';
    }
    .cbp-l-filters-alignCenter .cbp-filter-counter:before{
        border-top: 4px solid '.esc_attr($elano_options['custom_color']).';
    }
    .btn-color, a:hover .text-inner{
        border: 1px solid '.esc_attr($elano_options['custom_color']).';
    }
    .appdesign .app-service:hover .icon-container .icon {
        background: '.esc_attr($elano_options['custom_color']).';
        color: #ffffff;  
    }
    .appdesign .app-service .icon-container .icon {
        border: 1px solid '.esc_attr($elano_options['custom_color']).';
        color: '.esc_attr($elano_options['custom_color']).';
    }
    .navbar-default .navbar-nav > li:hover > a::before, .navbar-default .navbar-nav > li.active > a::before {
    border-bottom-color: '.esc_attr($elano_options['custom_color']).';
    }

    #ajax-div #loader, .loading-css, .cbp-loading, .cbp-popup-loadingBox, .nivo-lightbox-theme-default .nivo-lightbox-content.nivo-lightbox-loading{
        border-right: 4px solid '.esc_attr($elano_options['custom_color']).';
        border-top: 4px solid '.esc_attr($elano_options['custom_color']).';
    }
    ';
    }
    wp_add_inline_style( 'elano-style-css', $color_variation );

    $util_array = array( 'url' => get_template_directory_uri() );
    wp_localize_script( 'utils-js', 'UtilParam', $util_array );
    if(isset( $elano_options['twitter_username'])){
    $main_array = array( 'twitter_username' => esc_attr($elano_options['twitter_username']),'twitter_count' => esc_attr($elano_options['twitter_number']) );
    wp_localize_script( 'main-js', 'MainParam', $main_array );
    }

    if(is_page_template('elano-page-builder.php')){
        $main_var = array( 'home_url' => home_url(),'template_active' => 'builder' );
    } else {
        $main_var = array( 'home_url' => home_url(),'template_active' => 'non-builder' );
    }
    wp_localize_script( 'main-js', 'main', $main_var );



}
add_action('wp_enqueue_scripts', 'elano_load_theme_assets');



/*********************************************************************
 * RETINA SUPPORT
 */
add_filter('wp_generate_attachment_metadata', 'elano_retina_support_attachment_meta', 10, 2);
function elano_retina_support_attachment_meta($metadata, $attachment_id) {

    // Create first image @2
    elano_retina_support_create_images(get_attached_file($attachment_id), 0, 0, false);

    foreach ($metadata as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $image => $attr) {
                if (is_array($attr))
                    elano_retina_support_create_images(get_attached_file($attachment_id), $attr['width'], $attr['height'], true);
            }
        }
    }

    return $metadata;
}

function elano_retina_support_create_images($file, $width, $height, $crop = false) {

    $resized_file = wp_get_image_editor($file);
    if (!is_wp_error($resized_file)) {

        if ($width || $height) {
            $filename = $resized_file->generate_filename($width . 'x' . $height . '@2x');
            $resized_file->resize($width * 2, $height * 2, $crop);
        } else {
            $filename = str_replace('-@2x','@2x',$resized_file->generate_filename('@2x'));
        }
        $resized_file->save($filename);

        $info = $resized_file->get_size();

        return array(
            'file' => wp_basename($filename),
            'width' => $info['width'],
            'height' => $info['height'],
        );
    }

    return false;
}

add_filter('delete_attachment', 'elano_delete_retina_support_images');
function elano_delete_retina_support_images($attachment_id) {
    $meta = wp_get_attachment_metadata($attachment_id);
    if(is_array($meta)){
        $upload_dir = wp_upload_dir();
        $path = pathinfo($meta['file']);

        // First image (without width-height specified
        $original_filename = $upload_dir['basedir'] . '/' . $path['dirname'] . '/' . wp_basename($meta['file']);
        $retina_filename = substr_replace($original_filename, '@2x.', strrpos($original_filename, '.'), strlen('.'));
        if (file_exists($retina_filename)) unlink($retina_filename);

        foreach ($meta as $key => $value) {
            if ('sizes' === $key) {
                foreach ($value as $sizes => $size) {
                    $original_filename = $upload_dir['basedir'] . '/' . $path['dirname'] . '/' . $size['file'];
                    $retina_filename = substr_replace($original_filename, '@2x.', strrpos($original_filename, '.'), strlen('.'));
                    if (file_exists($retina_filename))
                        unlink($retina_filename);
                }
            }
        }
    }
}

// Enqueue comment-reply script if comments_open and singular
function elano_enqueue_comment_reply() {
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
                wp_enqueue_script( 'comment-reply' );
        }
}
add_action( 'wp_enqueue_scripts', 'elano_enqueue_comment_reply' );


/* GALLERY SHORTCODE FILTER FOR CAROUSEL

Usage: [elano_carousel include="123,456,789"]content[/elano_carousel]
(*) 123,456,789 are the Media attachments IDs you want to be displayed

*/
add_shortcode('clients','clients_carousel');
function clients_carousel ($attr, $content) {

    global $post;

    // Little fix as the order of arguments is not the same when
    // in "gallery" post formats
    if (!empty($content) && is_array($content)) {
        $attr = $content;
        if (!empty($attr[0])) $content = $attr[0];
        else $content = '';
    }

    $output = $content;

       $orderby = 'post__in';
    if (!empty($attr['orderby']))
        $orderby = sanitize_sql_orderby ($attr['orderby']);

    // If we got an include attr
    if (!empty($attr['ids']))
        $images = get_posts(array('include' => $attr['ids'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => $orderby));

    // If we do not have images yet...
    if (empty($images)) :
        // Get Post Images
        $images = get_children(array(
            'post_parent' => $post->ID,
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'numberposts' => 100,
            'orderby' => $orderby,
            'order' => 'DESC'
        ));
    endif;

    // If images are found, proceed
    if (!empty($images)) :

        $indicators = '';
        $items = '';

        $i=0; foreach ($images as $image) :

            $act = ($i==0) ? 'active' : '';
            $rand=rand();
            if(get_post_meta( $image->ID, 'destination_url', true )) :
            $items .= '
            <div class="carousel-item">
                <a href="'.esc_url(get_post_meta( $image->ID, 'destination_url', true )).'"><img alt="" src="'. $image->guid.'"></a>
            </div>
            ';
            else :
                $items .= '
            <div class="carousel-item">
                <img alt="" src="'. $image->guid.'">
            </div>
            ';
            endif;

        $i++; endforeach;

        // BEGIN OUTPUT

        $output .= '<div class="container-logos"> ';

            // ITEMS
            $output .= '<div id="logos-carousel" class="owl-carousel light-text">' .$items. '</div>
            ';

      
 
        // END OUTPUT

        return $output;

    endif;

    // Return nothing
    return;
}

add_shortcode('elano_carousel','elano_shortcode_carousel');
function elano_shortcode_carousel ($attr, $content) {

    global $post;

    // Little fix as the order of arguments is not the same when
    // in "gallery" post formats
    if (!empty($content) && is_array($content)) {
        $attr = $content;
        if (!empty($attr[0])) $content = $attr[0];
        else $content = '';
    }

    $output = $content;

    // OrderBy
    $orderby = 'post__in';
    if (!empty($attr['orderby']))
        $orderby = sanitize_sql_orderby ($attr['orderby']);

    // If we got an include attr
    if (!empty($attr['ids']))
        $images = get_posts(array('include' => $attr['ids'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => $orderby));

    // If we do not have images yet...
    if (empty($images)) :
        // Get Post Images
        $images = get_children(array(
            'post_parent' => $post->ID,
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'numberposts' => 100,
            'orderby' => $orderby,
            'order' => 'DESC'
        ));
    endif;

    // If images are found, proceed
    if (!empty($images)) :

        $indicators = '';
        $items = '';

        $i=0; foreach ($images as $image) :

            $act = ($i==0) ? 'active' : '';
            $rand=rand();
            

            $items .= '

            <li><img src="'. $image->guid.'" alt="'.get_the_title($image->ID).'"/></li>
            ';

        $i++; endforeach;

        // BEGIN OUTPUT

        $output .= '<div id="slider2" class="flexslider">';
        // ITEMS
        $output .= '<ul class="slides">' .$items. '</ul>';

        $output .= '</div>';

        // END OUTPUT

        return $output;

    endif;

    // Return nothing
    return;
}

/* To automatically execute carousel shortcode when post type is "gallery" */
add_action('post_gallery', 'elano_shortcode_carousel', 10, 2);

// Elano Pagination
// Code taken from: http://wp-snippets.com/pagination-for-twitter-bootstrap/
function elano_pagination ($before = '', $after = '') {

    global $elano_options;

    echo $before;

    

        global $wpdb, $wp_query;

        $request = $wp_query->request;
        $posts_per_page = intval(get_query_var('posts_per_page'));
        $paged = intval(get_query_var('paged'));
        $numposts = $wp_query->found_posts;
        $max_page = $wp_query->max_num_pages;

        if ($numposts <= $posts_per_page) return;
        if (empty($paged) || $paged == 0) $paged = 1;

        $pages_to_show = 7;
        $pages_to_show_minus_1 = $pages_to_show - 1;
        $half_page_start = floor($pages_to_show_minus_1 / 2);
        $half_page_end = ceil($pages_to_show_minus_1 / 2);
        $start_page = $paged - $half_page_start;

        if ($start_page <= 0) $start_page = 1;
        $end_page = $paged + $half_page_end;
        if (($end_page - $start_page) != $pages_to_show_minus_1) {
            $end_page = $start_page + $pages_to_show_minus_1;
        }
        if ($end_page > $max_page) {
            $start_page = $max_page - $pages_to_show_minus_1;
            $end_page = $max_page;
        }
        if ($start_page <= 0) $start_page = 1;

        echo '<div class="space"></div>
              <div class="space"></div>';
        echo ' <div class="blog-nav">';

        echo previous_posts_link( __( '<i class="fa fa-angle-left"></i>', 'elano' ) );

        for ($i = $start_page; $i <= $end_page; $i++) {
            if ($i == $paged)
                echo ' <span>' . $i . '</span>';
            else
                echo ' <a href="'.get_pagenum_link($i).'">' . $i . '</a>';
        }

        echo next_posts_link( __( '<i class="fa fa-angle-right"></i>', 'elano' ) );
        echo '</div>';

  

    echo $after;

    return;
}


/* Code for font-awesome support in Menu*/

add_action('wp_update_nav_menu_item', 'elano_nav_update',10, 3);
function elano_nav_update($menu_id, $menu_item_db_id, $args ) {
   if (isset($_REQUEST['menu-item-faicon']) ) {
     $custom_faicon= $_REQUEST['menu-item-faicon'][$menu_item_db_id];
     update_post_meta( $menu_item_db_id, '_menu_item_faicon', $custom_faicon);  
     }

}
add_filter( 'wp_setup_nav_menu_item','elano_nav_item' );

function elano_nav_item($menu_item) {
$menu_item->faicon = get_post_meta( $menu_item->ID, '_menu_item_faicon', true );  
return $menu_item;
}

add_filter( 'wp_edit_nav_menu_walker', 'elano_nav_edit_walker',10,2 );
function elano_nav_edit_walker($walker,$menu_id) {
    return 'Walker_Nav_Menu_Edit_Custom';
}


class Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu  {

function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0 ) {
    global $_wp_nav_menu_max_depth;
    $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

    ob_start();
    $item_id = esc_attr( $item->ID );
    $removed_args = array(
        'action',
        'customlink-tab',
        'edit-menu-item',
        'menu-item',
        'page-tab',
        '_wpnonce',
    );

    $original_title = '';
    if ( 'taxonomy' == $item->type ) {
        $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
        if ( is_wp_error( $original_title ) )
            $original_title = false;
    } elseif ( 'post_type' == $item->type ) {
        $original_object = get_post( $item->object_id );
        $original_title = $original_object->post_title;
    }

    $classes = array(
        'menu-item menu-item-depth-' . $depth,
        'menu-item-' . esc_attr( $item->object ),
        'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
    );

    $title = $item->title;

    if ( ! empty( $item->_invalid ) ) {
        $classes[] = 'menu-item-invalid';
        /* translators: %s: title of menu item which is invalid */
        $title = sprintf( __( '%s (Invalid)','elano' ), $item->title );
    } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
        $classes[] = 'pending';
        /* translators: %s: title of menu item in draft status */
        $title = sprintf( __('%s (Pending)','elano'), $item->title );
    }

    $title = empty( $item->label ) ? $title : $item->label;

    ?>
    <li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
        <dl class="menu-item-bar">
            <dt class="menu-item-handle">
                <span class="item-title"><?php echo esc_html( $title ); ?></span>
                <span class="item-controls">
                    <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                    <span class="item-order hide-if-js">
                        <a href="<?php
                            echo wp_nonce_url(
                                add_query_arg(
                                    array(
                                        'action' => 'move-up-menu-item',
                                        'menu-item' => $item_id,
                                    ),
                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                ),
                                'move-menu_item'
                            );
                        ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up'); ?>">&#8593;</abbr></a>
                        |
                        <a href="<?php
                            echo wp_nonce_url(
                                add_query_arg(
                                    array(
                                        'action' => 'move-down-menu-item',
                                        'menu-item' => $item_id,
                                    ),
                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                ),
                                'move-menu_item'
                            );
                        ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down'); ?>">&#8595;</abbr></a>
                    </span>
                    <a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item'); ?>" href="<?php
                        echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
                    ?>"><?php _e( 'Edit Menu Item','elano' ); ?></a>
                </span>
            </dt>
        </dl>

        <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
            <?php if( 'custom' == $item->type ) : ?>
                <p class="field-url description description-wide">
                    <label for="edit-menu-item-url-<?php echo $item_id; ?>">
                        <?php _e( 'URL' ,'elano'); ?><br />
                        <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                    </label>
                </p>
            <?php endif; ?>
            <p class="description description-thin">
                <label for="edit-menu-item-title-<?php echo $item_id; ?>">
                    <?php _e( 'Navigation Label','elano' ); ?><br />
                    <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                </label>
            </p>

 

            <p class="description description-thin">
                <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
                    <?php _e( 'Title Attribute','elano' ); ?><br />
                    <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                </label>
            </p>

            <p class="field-link-target description">
                <label for="edit-menu-item-target-<?php echo $item_id; ?>">
                    <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]" <?php checked( $item->target, '_blank' ); ?> />
                    <?php _e( 'Open link in a new window/tab','elano' ); ?>
                </label>
            </p>

          

            <?php $iconfa=esc_attr($item->faicon); ?>
            <p class="description description-thin">
                            <label for="edit-menu-item-fafa fa-<?php echo $item_id; ?>">
                                <?php _e( 'Icon of the menu','elano' ); ?><br />
                                <select id="edit-menu-item-fa fa-<?php echo $item_id; ?>" class="widefat edit-menu-item-faicon" name="menu-item-faicon[<?php echo $item_id; ?>]"> 
            <?php $icons = array("","adjust", "align-center", "align-justify", "align-left", "align-right", "ambulance", "angle-down", "angle-left", "angle-right", "angle-up", "arrow-down", "arrow-left", "arrow-right", "arrow-up", "asterisk", "backward", "ban-circle", "bar-chart", "barcode", "beaker", "beer", "bell", "bell-alt", "bold", "bolt", "book", "bookmark", "bookmark-empty", "briefcase", "building", "bullhorn", "calendar", "calendar-empty", "camera", "camera-retro", "caret-down", "caret-left", "caret-right", "caret-up", "certificate", "check", "check-empty", "chevron-down", "chevron-left", "chevron-right", "chevron-up", "circle", "circle-arrow-down", "circle-arrow-left", "circle-arrow-right", "circle-arrow-up", "circle-blank", "cloud", "cloud-download", "cloud-upload", "code", "code-fork", "coffee", "cog", "cogs", "collapse-alt", "columns", "comment", "comment-alt", "comments", "comments-alt", "copy", "credit-card", "crop", "cut", "dashboard", "desktop", "double-angle-down", "double-angle-left", "double-angle-right", "double-angle-up", "download", "download-alt", "edit", "eject", "envelope", "envelope-alt", "eraser", "exchange", "exclamation", "exclamation-sign", "expand-alt", "external-link", "eye-close", "eye-open", "facebook", "facebook-sign", "facetime-video", "fast-backward", "fast-forward", "fighter-jet", "file", "file-alt", "film", "filter", "fire", "fire-extinguisher", "flag", "flag-alt", "flag-checkered", "folder-close", "folder-close-alt", "folder-open", "folder-open-alt", "font", "food", "forward", "frown", "fullscreen", "gamepad", "gift", "github", "github-alt", "github-sign", "glass", "globe", "google-plus", "google-plus-sign", "group", "h-sign", "hand-down", "hand-left", "hand-right", "hand-up", "hdd", "headphones", "heart", "heart-empty", "home", "hospital", "inbox", "indent-left", "indent-right", "info", "info-sign", "italic", "key", "keyboard", "laptop", "leaf", "legal", "lemon", "lightbulb", "link", "linkedin", "linkedin-sign", "list", "list-alt", "list-ol", "list-ul", "location-arrow", "lock", "magic", "magnet", "mail-reply-all", "map-marker", "maxcdn", "medkit", "meh", "microphone", "microphone-off", "minus", "minus-sign", "mobile-phone", "money", "move", "music", "off", "ok", "ok-circle", "ok-sign", "paper-clip", "paste", "pause", "pencil", "phone", "phone-sign", "picture", "pinterest", "pinterest-sign", "plane", "play", "play-circle", "plus", "plus-sign", "plus-sign-alt", "print", "pushpin", "puzzle-piece", "qrcode", "question", "question-sign", "quote-left", "quote-right", "random", "refresh", "remove", "remove-circle", "remove-sign", "reorder", "repeat", "reply", "reply-all", "resize-full", "resize-horizontal", "resize-small", "resize-vertical", "retweet", "road", "rocket", "rss", "save", "screenshot", "search", "share", "share-alt", "shield", "shopping-cart", "sign-blank", "signal", "signin", "signout", "sitemap", "smile", "sort", "sort-down", "sort-up", "spinner", "star", "star-empty", "star-half", "star-half-empty", "step-backward", "step-forward", "stethoscope", "stop", "strikethrough", "subscript", "suitcase", "superscript", "table", "tablet", "tag", "tags", "tasks", "terminal", "text-height", "text-width", "th", "th-large", "th-list", "thumbs-down", "thumbs-up", "time", "tint", "trash", "trophy", "truck", "twitter", "twitter-sign", "umbrella", "underline", "undo", "unlink", "unlock", "upload", "upload-alt", "user", "user-md", "volume-down", "volume-off", "volume-up", "warning-sign", "wrench", "zoom-in", "zoom-out") ; ?>

            <?php if($iconfa!='') { ?>
            <option selected="selected" value="<?php echo $iconfa?>" ><i class="fa fa-<?php echo $iconfa;?>"><?php echo $iconfa;?></option>
            <?php } else { ?>
            <option selected="selected" value="<?php echo $iconfa?>" ><i class="fa fa-<?php echo $iconfa;?>"><?php echo $iconfa;?></option>
            <?php } foreach($icons as $icon) { 
                if($icon!=$iconfa) { ?>
            <option value="<?php echo $icon?>" ><i class="fa fa-<?php echo $icon;?>"><?php echo $icon;?></option>
            <?php } }?>

            </select>

            </label>
            </p>


            <p class="field-css-classes description description-thin">
                <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
                    <?php _e( 'CSS Classes (optional)','elano' ); ?><br />
                    <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                </label>
            </p>
            <p class="field-xfn description description-thin">
                <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
                    <?php _e( 'Link Relationship (XFN)','elano' ); ?><br />
                    <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                </label>
            </p>
            <p class="field-description description description-wide">
                <label for="edit-menu-item-description-<?php echo $item_id; ?>">
                    <?php _e( 'Description' ,'elano'); ?><br />
                    <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                    <span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.','elano'); ?></span>
                </label>
            </p>        
           

            <?php
            /*
             * end added field
             */
            ?>
            <div class="menu-item-actions description-wide submitbox">
                <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
                    <p class="link-to-original">
                        <?php printf( __('Original: %s','elano'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                    </p>
                <?php endif; ?>
                <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
                echo wp_nonce_url(
                    add_query_arg(
                        array(
                            'action' => 'delete-menu-item',
                            'menu-item' => $item_id,
                        ),
                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                    ),
                    'delete-menu_item_' . $item_id
                ); ?>"><?php _e('Remove','elano'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
                    ?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel','elano'); ?></a>
            </div>

            <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
            <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
            <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
            <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
            <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
            <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
        </div><!-- .menu-item-settings-->
        <ul class="menu-item-transport"></ul>
    <?php
    $output .= ob_get_clean();
    }
}

Class Description_Walker extends Walker_Nav_Menu {

    function start_lvl( &$output , $depth = 0 , $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"dropdown-menu \">\n";
    }



   function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0)
      {
           global $wp_query;
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

           $class_names = $value = '';

           $classes = empty( $item->classes ) ? array() : (array) $item->classes;

           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
          
           $class_names = ' '. esc_attr( $class_names ) . '';
           
           $output .= $indent . '<li >';
           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
           $prepend='';
           if($item->faicon!=''){
           $prepend = '<i class=" fa fa-'.$item->faicon.'" ></i> ';
            }
           $append = '';
           $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';
          

            $item_output = $args->before;
            if($depth<1){
                $item_output .= '<a class="nav-to '.esc_attr( $class_names ).'" '. $attributes .'>';
            } else {
                $item_output .= '<a class="'.esc_attr( $class_names ).'" '. $attributes .'>';
            }
            $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
            $item_output .= $description.$args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
       
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );



            }

}



function elano_body_classes( $classes ) {
    if (!is_page_template('elano-page-builder.php') ) :
    $classes[] = 'multipage';
    endif;  
    return $classes;
}
add_filter( 'body_class', 'elano_body_classes' );



add_action( 'tgmpa_register', 'elano_register_required_plugins' );

function elano_register_required_plugins() {
 
    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
 
        // This is an example of how to include a plugin pre-packaged with a theme.
        array(
            'name'               => 'Mero Page Builder', // The plugin name.
            'slug'               => 'merobuilder', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/inc/plugins/merobuilder.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ),
        array(
            'name'               => 'Contact Form 7', // The plugin name.
            'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/inc/plugins/contact-form-7.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ), 
        array(
            'name'               => 'Really simple captcha', // The plugin name.
            'slug'               => 'really-simple-captcha', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/inc/plugins/really-simple-captcha.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ), 
        array(
            'name'               => 'Revolution Slider', // The plugin name.
            'slug'               => 'revslider', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/inc/plugins/revslider.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ), 
        array(
            'name'               => 'MailChimp for WordPress', // The plugin name.
            'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/inc/plugins/mailchimp-for-wp.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ), 
 
    );
 
    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
            'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
            'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );
 
    tgmpa( $plugins, $config );
 
}

/**
 * Configure the SiteOrigin page builder settings.
 * 
 * @param $settings
 * @return mixed
 */


/**
 * Add row styles.
 *
 * @param $styles
 * @return mixed
 */
function elano_panels_row_styles($styles) {
    $styles['wide'] = __('Wide', 'elano');
    $styles['container'] = __('Container', 'elano');
    $styles['overlay'] = __('Image Overlay', 'elano');
    $styles['parallax'] = __('Parallax', 'elano');
    $styles['parallax-overlay'] = __('Parallax Overlay', 'elano');
    $styles['parallax-overlay-wide'] = __('Parallax Overlay Wide', 'elano');
    $styles['video'] = __('Video background Overlay', 'elano');
    $styles['video-wide'] = __('Video background Overlay Wide', 'elano');
    return $styles;
}
add_filter('siteorigin_panels_row_styles', 'elano_panels_row_styles');


function elano_panels_row_style_fields($fields) {

    $fields['background_image'] = array(
        'name' => __('Background Image', 'elano'),
        'type' => 'url',
    );

    $fields['background_image_repeat'] = array(
        'name' => __('Repeat Background Image', 'elano'),
        'type' => 'checkbox',
    );

    $fields['background'] = array(
        'name' => __('Background Color', 'vantage'),
        'type' => 'color',
    );

    $fields['extra_top_margin'] = array(
        'name' => __('Extra Top Margin', 'elano'),
        'type' => 'text',
    );

    $fields['extra_bottom_margin'] = array(
        'name' => __('Extra Bottom Margin', 'elano'),
        'type' => 'text',
    );

    $fields['div_id'] = array(
        'name' => __('ID for Section/div', 'elano'),
        'type' => 'text',
    );

    return $fields;
}
add_filter('siteorigin_panels_row_style_fields', 'elano_panels_row_style_fields');

function elano_panels_panels_row_style_attributes($attr, $style) {
    $attr['style'] = '';

    if(!empty($style['div_id']))  $attr['id'] = esc_attr($style['div_id']);
    if(!empty($style['top_border'])) $attr['style'] .= 'border-top: 1px solid '.esc_attr($style['top_border']).'; ';
    if(!empty($style['bottom_border'])) $attr['style'] .= 'border-bottom: 1px solid '.esc_attr($style['bottom_border']).'; ';
    if(!empty($style['background'])) $attr['style'] .= 'background-color: '.esc_attr($style['background']).'; ';
    if(!empty($style['background_image'])) $attr['style'] .= 'background-image: url('.esc_url($style['background_image']).');background-position:50% 50%; ';
    if(!empty($style['background_image_repeat'])) $attr['style'] .= 'background-repeat: repeat; ';
    if(!empty($style['extra_top_margin'])) $attr['style'] .= 'padding-top: '.esc_attr($style['extra_top_margin']).'px; ';
    if(!empty($style['extra_bottom_margin'])) $attr['style'] .= 'padding-bottom: '.esc_attr($style['extra_bottom_margin']).'px; ';

    if(empty($attr['style'])) unset($attr['style']);
    return $attr;
}
add_filter('siteorigin_panels_row_style_attributes', 'elano_panels_panels_row_style_attributes', 10, 2);


function elano_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
?>
    <<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
    <article class="comment">

    <div class="comment-author vcard">
    <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
    <?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?>
    </div>


    <div class="comment-block">
    <?php if ( $comment->comment_approved == '0' ) : ?>
        <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.','elano' ); ?></em>
        <br />
    <?php endif; ?>
    <?php comment_text(); ?>

        <div class="metas">
            <div class="date">
                <p><i class="fa fa-calendar"></i> <?php
                /* translators: 1: date, 2: time */
                printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)' ), '  ', '' );
            ?></p> 
            </div>
            
            <div class="comments">
                <a class="comment-reply-link" href="#"><i class="fa fa-plus"></i> REPLY</a>
            </div><!-- .reply -->
    </div>
    
    </div>

    </article>



   
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
<?php
}

/* Code for popular post widget*/
class WP_Widget_Post_Tabs_Elano extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( "A tab showing recent,popluar and random posts in sidebar.","flatty") );
        parent::__construct('popular-posts-elano', __('Post Tabs (Elano)','elano'), $widget_ops);
        $this->alt_option_name = 'widget_post_tabs';

        add_action( 'save_post', array($this, 'flush_widget_cache') );
        add_action( 'deleted_post', array($this, 'flush_widget_cache') );
        add_action( 'switch_theme', array($this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {
        $cache = wp_cache_get('widget_post_tabs', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }

        ob_start();
        extract($args);
        
        $title='';
        echo $before_widget; 
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 2;
        ?>
        <div id="blog-tabs">
        <ul class="tabs">
                            <li id="tab_two1"><?php echo __('Popular','elano');?></li>
                            <li id="tab_two2"><?php echo __('Recent','elano');?></li>
                            <li id="tab_two3"><?php echo __('Random','elano');?></li>
        </ul>
        
        <div class="contents">
            <div id="content_two1" class="tabscontent">
            <ul class="posts">
        <?php
        $r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'orderby' => 'comment_count','no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
        if ($r->have_posts()) :
        ?>
            
            <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                <li>
                      <a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail($r->post->ID,array(70,70));?></a>
                      <p><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></p>
                      <div class="date">
                          <p><i class="fa fa-calendar"></i> <?php the_time('F jS, Y') ?> <i class="fa fa-comment"></i> <?php comments_number('0','1','%'); ?></p>
                          <div class="inner_text">
                          <?php echo substr(get_the_excerpt(), 0,90).' ...'; ?>
                          </div>
                      </div>
                      
                </li>
            <?php endwhile; ?>
        <?php echo $after_widget; ?>
        <?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();
        endif;
        ?>
            </ul>
            <div id="content_two2" class="tabscontent">
            <ul class="posts">
        <?php
        $r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
        if ($r->have_posts()) :
        ?>

            <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                <li>
                      <a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail($r->post->ID,array(70,70));?></a>
                      <p><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></p>
                      <div class="date">
                          <p><i class="fa fa-calendar"></i> <?php the_time('F jS, Y') ?> <i class="fa fa-comment"></i> <?php comments_number('0','1','%'); ?></p>
                          <div class="inner_text">
                          <?php echo substr(get_the_excerpt(), 0,90).' ...'; ?>
                          </div>
                      </div>
                      
                </li>
            <?php endwhile; ?>
            
        <?php echo $after_widget; ?>
        <?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();
        endif;
        ?>
        </ul>

        <div id="content_two3" class="tabscontent">
            <ul class="posts">
        
                <?php
        $r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'orderby' => 'rand','no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
        if ($r->have_posts()) :
        ?>
            
            <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                <li>
                      <a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail($r->post->ID,array(70,70));?></a>
                      <p><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></p>
                      <div class="date">
                          <p><i class="fa fa-calendar"></i> <?php the_time('F jS, Y') ?> <i class="fa fa-comment"></i> <?php comments_number('0','1','%'); ?></p>
                          <div class="inner_text">
                          <?php echo substr(get_the_excerpt(), 0,90).' ...'; ?>
                          </div>
                      </div>
                      
                </li>
            <?php endwhile; ?>
           
        <?php echo $after_widget; ?>
        <?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();
        endif;
        ?>
         </ul>
        </div>
        </div>
        <?php echo $after_widget; ?>
        <?php
        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_posts', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['number'] = (int) $new_instance['number'];
       $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_recent_entries']) )
            delete_option('widget_recent_entries');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_recent_posts', 'widget');
    }

    function form( $instance ) {
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 2;
        ?>
        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:','flatty' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
    <?php
    }   
}
register_widget('WP_Widget_Post_Tabs_Elano');

add_filter('loop_shop_columns', 'elano_product_loop_columns');
function elano_product_loop_columns() {
    return 3; // 3 products per row
}

add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 9;' ), 20 );

add_filter( 'cmb_meta_boxes', 'elano_cmb_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function elano_cmb_metaboxes( array $meta_boxes ) {

    $prefix = 'elano_';

     $meta_boxes['page_metabox'] = array(
        'id'         => 'page_metabox',
        'title'      => __( 'Elano Page Settings', 'elano' ),
        'pages'      => array( 'page', ), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields'     => array(
           array(
                'name'    => __( 'Page Title Color', 'elano' ),
                'id'      => $prefix . 'pagetitle_color',
                'type'    => 'colorpicker',
            ),


           array(
                'name'    => __( 'Page Title Background Color', 'elano' ),
                'id'      => $prefix . 'pagetitle_bgcolor',
                'type'    => 'colorpicker',
            ),

           array(
                'name' => __( 'Page tite Background', 'elano' ),
                'desc' => __( 'Upload an image or enter a URL.', 'elano' ),
                'id'   => $prefix . 'pagetitle_image',
                'type' => 'file',
            ),

           
        )
    );

 
    $meta_boxes['menu_metabox'] = array(
        'id'         => 'menu_metabox',
        'title'      => __( 'Menu Option', 'elano' ),
        'pages'      => array( 'page', ), // Post type
        'context'    => 'side',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'name'     => __( 'Menus', 'elano' ),
                'desc'     => __( 'Select menu for this page', 'elano' ),
                'id'       => $prefix . 'menu_select',
                'type'     => 'taxonomy_select',
                'taxonomy' => 'nav_menu', // Taxonomy Slug
            ),
        )
    );

    return $meta_boxes;
}

add_action( 'init', 'elano_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function elano_initialize_cmb_meta_boxes() {

    if ( ! class_exists( 'cmb_Meta_Box' ) )
        require_once 'inc/cmb/init.php';

}


add_filter( 'woocommerce_enqueue_styles', '__return_false' );