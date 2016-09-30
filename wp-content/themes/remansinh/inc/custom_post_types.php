<?php

// Register Custom Post Type
function testimonial_post_type() {

    $labels = array(
        'name'                => _x( 'Testimonials', 'Post Type General Name', 'elano' ),
        'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'elano' ),
        'menu_name'           => __( 'Testimonial', 'elano' ),
        'parent_item_colon'   => __( 'Parent Testimonial:', 'elano' ),
        'all_items'           => __( 'All Testimonials', 'elano' ),
        'view_item'           => __( 'View Testimonial', 'elano' ),
        'add_new_item'        => __( 'Add New Testimonial', 'elano' ),
        'add_new'             => __( 'Add New', 'elano' ),
        'edit_item'           => __( 'Edit Testimonial', 'elano' ),
        'update_item'         => __( 'Update Testimonial', 'elano' ),
        'search_items'        => __( 'Search Testimonial', 'elano' ),
        'not_found'           => __( 'Not found', 'elano' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'elano' ),
    );
    $args = array(
        'label'               => __( 'testimonial_type', 'elano' ),
        'description'         => __( 'You can create testimonials slider from here.', 'elano' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 60,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'testimonial', $args );

}

function testimonial_add_meta_box() {

    $screens = array( 'testimonial');

    foreach ( $screens as $screen ) {

        add_meta_box(
            'testimonial',
            __( 'Testimonial Details', 'elano' ),
            'testimonial_meta_box_callback',
            $screen
        );
    }
}
add_action( 'add_meta_boxes', 'testimonial_add_meta_box' );

function testimonial_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'testimonial_meta_box', 'testimonial_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $value1 = get_post_meta( $post->ID, 'testimonial_person_name', true );
    $value2 = get_post_meta( $post->ID, 'testimonial_person_post', true );
    $value3 = get_post_meta( $post->ID, 'testimonial_person_image', true );

    echo '<label for="testimonial_new_field">';
    _e( 'Name of the client', 'elano' );
    echo '</label> ';
    echo '<input type="text" id="testimonial_person_name" name="testimonial_person_name" value="' . esc_attr( $value1 ) . '" size="50" />';

    echo '<br><br><label for="testimonial_new_field">';
    _e( 'Post of the client', 'elano' );
    echo '</label> ';
    echo '<input type="text" id="testimonial_person_post" name="testimonial_person_post" value="' . esc_attr( $value2 ) . '" size="50" />';

    echo '<br><br><label for="testimonial_new_field">';
    _e( 'Image of the client', 'elano' );
    echo '</label><br> ';
    ?>

<style> .media-upload h2 { font-weight: bold; } </style>

<script>
jQuery(document).ready(function($){
  var _custom_media = true,
      _orig_send_attachment = wp.media.editor.send.attachment;

  $('.uploader .button').click(function(e) {
    var send_attachment_bkp = wp.media.editor.send.attachment;
    var button = $(this);
    var id = button.attr('id').replace('_button', '');
    _custom_media = true;
    wp.media.editor.send.attachment = function(props, attachment){
      if ( _custom_media ) {
        $("#"+id).val(attachment.url);
      } else {
        return _orig_send_attachment.apply( this, [props, attachment] );
      };
    }

    wp.media.editor.open(button);
    return false;
  });

  $('.add_media').on('click', function(){
    _custom_media = false;
  });
});
</script>

<div class="uploader">
  <input type="text" name="testimonial_person_image" id="testimonial_person_image" value="<?php echo esc_attr( $value3 ); ?>" />
  <input class="button" name="testimonial_person_image_button" id="testimonial_person_image_button" value="Upload" />
</div>

<?php 

}

function admin_scripts()
{
   wp_enqueue_script('media-upload');

}
add_action('admin_enqueue_scripts', 'admin_scripts');


function testimonial_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['testimonial_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['testimonial_meta_box_nonce'], 'testimonial_meta_box' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */
    
    // Sanitize user input.
    $my_data1 = sanitize_text_field( $_POST['testimonial_person_name'] );
    $my_data2 = sanitize_text_field( $_POST['testimonial_person_post'] );
    $my_data3 = sanitize_text_field( $_POST['testimonial_person_image'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, 'testimonial_person_name', $my_data1 );
    update_post_meta( $post_id, 'testimonial_person_post', $my_data2 );
    update_post_meta( $post_id, 'testimonial_person_image', $my_data3);
}
add_action( 'save_post', 'testimonial_save_meta_box_data' );


// Hook into the 'init' action
add_action( 'init', 'testimonial_post_type', 0 );

if ( ! function_exists( 'testimonial_shortcode' ) ) {
 
    function testimonial_shortcode( $atts ) {
        extract( shortcode_atts(
                array(
                    // category slug attribute - defaults to blank
                    'category' => '',
                    // full content or excerpt attribute - defaults to full content
                    'excerpt' => 'false',
                ), $atts )
        );
         
        $output = '';
         
        // set the query arguments
        $query_args = array(
            // show all posts matching this query
            'posts_per_page'    =>   -1,
            // show the 'testimonial' custom post type
            'post_type'         =>   'testimonial',
            // tell WordPress that it doesn't need to count total rows - this little trick reduces load on the database if you don't need pagination
            'no_found_rows'     =>   true,
        );
         
        // get the posts with our query arguments
        $testimonial_posts = get_posts( $query_args );
        $output .= '<div id="testimonials-slider" class="flexslider"><ul class="slides styled-list">';
         
        // handle our custom loop
        foreach ( $testimonial_posts as $post ) {
            setup_postdata( $post );
            $testimonial_item_title = get_the_title( $post->ID );
            $testimonial_item_name =esc_attr(get_post_meta( $post->ID, 'testimonial_person_name', true ));
            $testimonial_item_post =esc_attr(get_post_meta( $post->ID, 'testimonial_person_post', true ));
            $testimonial_item_image =esc_url(get_post_meta( $post->ID, 'testimonial_person_image', true ));
            $testimonial_item_content = get_the_content();
            $output .= '
                                
                                        <!-- SLIDE #01 -->
                                        <li class="testimonials-slide">
                                            <div class="testimonials-slide-content container">
                                                <!-- CLIENT IMAGE HERE -->
                                                <div class="img-container">
                                                    <img title="" src="' . $testimonial_item_image . '" alt="">
                                                </div>
                                                
                                                <div class="t-author"><p><b>' . $testimonial_item_name . ', ' . $testimonial_item_post . '</b></p></div>
                                                
                                                <!-- CLIENT TESTIMONIAL HERE -->
                                                <div class="text-container">
                                                    <!-- AUTHOR -->
                                                    <p><i class="fa fa-quote-left"></i> ' . $testimonial_item_content . ' <i class="fa fa-quote-right"></i></p>
                                                </div>
                                            </div>
                                        </li>
                                   ';
               
        }
         
        wp_reset_postdata();
        $output .= ' </ul></div>';      
         
        return $output;
    }
 
    add_shortcode( 'testimonial_slider', 'testimonial_shortcode' );
}


/* Portfolio as custom post type */

function portfolio_post_type() {

    $labels = array(
        'name'                => _x( 'Projects', 'Post Type General Name', 'elano' ),
        'singular_name'       => _x( 'Project', 'Post Type Singular Name', 'elano' ),
        'menu_name'           => __( 'Project', 'elano' ),
        'parent_item_colon'   => __( 'Parent Project:', 'elano' ),
        'all_items'           => __( 'All Projects', 'elano' ),
        'view_item'           => __( 'View Project', 'elano' ),
        'add_new_item'        => __( 'Add New Project', 'elano' ),
        'add_new'             => __( 'Add New', 'elano' ),
        'edit_item'           => __( 'Edit Project', 'elano' ),
        'update_item'         => __( 'Update Project', 'elano' ),
        'search_items'        => __( 'Search Project', 'elano' ),
        'not_found'           => __( 'Not found', 'elano' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'elano' ),
    );
    $args = array(
        'label'               => __( 'portfolio_type', 'elano' ),
        'description'         => __( 'You can create portfolios slider from here.', 'elano' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor','thumbnail'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 60,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'portfolio', $args );

}


// Register Custom Taxonomy
function portfolio_category() {

    $labels = array(
        'name'                       => _x( 'Filters', 'Taxonomy General Name', 'elano' ),
        'singular_name'              => _x( 'Filter', 'Taxonomy Singular Name', 'elano' ),
        'menu_name'                  => __( 'Filter', 'elano' ),
        'all_items'                  => __( 'All Items', 'elano' ),
        'parent_item'                => __( 'Parent Item', 'elano' ),
        'parent_item_colon'          => __( 'Parent Item:', 'elano' ),
        'new_item_name'              => __( 'New Item Name', 'elano' ),
        'add_new_item'               => __( 'Add New Item', 'elano' ),
        'edit_item'                  => __( 'Edit Item', 'elano' ),
        'update_item'                => __( 'Update Item', 'elano' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'elano' ),
        'search_items'               => __( 'Search Items', 'elano' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'elano' ),
        'choose_from_most_used'      => __( 'Choose from the most used items', 'elano' ),
        'not_found'                  => __( 'Not Found', 'elano' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => false,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'portfolio_filter', array( 'portfolio' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'portfolio_category', 0 );

// Hook into the 'init' action
add_action( 'init', 'portfolio_category', 0 );


function portfolio_add_meta_box() {

    $screens = array( 'portfolio');

    foreach ( $screens as $screen ) {

        add_meta_box(
            'portfolio',
            __( 'Portfolio Details', 'elano' ),
            'portfolio_meta_box_callback',
            $screen
        );
    }
}
add_action( 'add_meta_boxes', 'portfolio_add_meta_box' );

function portfolio_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'portfolio_meta_box', 'portfolio_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $portfolio_name = get_post_meta( $post->ID, 'portfolio_person_name', true );
    $portfolio_url = get_post_meta( $post->ID, 'portfolio_person_url', true );
    $portfolio_height = get_post_meta( $post->ID, 'portfolio_image_height', true );



    echo '<label for="portfolio_person_name">';
    _e( 'Name of the client', 'elano' );
    echo '</label> ';
    echo '<input type="text" id="portfolio_person_name" name="portfolio_person_name" value="' . esc_attr( $portfolio_name ) . '" size="50" />';

    echo '<br><br><label for="portfolio_person_url">';
    _e( 'Url of the client', 'elano' );
    echo '</label> ';
    echo '<input type="text" id="portfolio_person_url" name="portfolio_person_url" value="' . esc_attr( $portfolio_url ) . '" size="50" />'; 

     echo '<br><br><label for="portfolio_image_height">';
    _e( 'Image Height for Masonry Layout', 'elano' );
    echo '</label> ';
    echo '<select id="portfolio_image_height" name="portfolio_image_height" />'; 
    echo '<option selected="selected" value ="'.$portfolio_height.'">';
    if($portfolio_height==1){echo __( 'Portrait', 'elano' ); } elseif($portfolio_height==2){ echo __( 'Camera', 'elano' ); }elseif($portfolio_height==3){echo __( 'Landscape', 'elano' );; } else { echo __( 'Choose option', 'elano' );;}
    echo '</option>';
    if($portfolio_height!=1) {
    echo '<option value="1" />'.__( 'Portrait', 'elano' ).'</option>';  
    } 
    if($portfolio_height!=2) {
    echo '<option value="2" />'.__( 'Camera', 'elano' ).'</option>';  
    }
    if($portfolio_height!=3) {
    echo '<option value="3" />'.__( 'Landscape', 'elano' ).'</option>';   
    } 

    echo '</select>';   

}



function portfolio_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['portfolio_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['portfolio_meta_box_nonce'], 'portfolio_meta_box' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }
    /* OK, it's safe for us to save the data now. */
    
    // Sanitize user input.
    $portfolio_name = sanitize_text_field( $_POST['portfolio_person_name'] );
    $portfolio_url = sanitize_text_field( $_POST['portfolio_person_url'] );
    $portfolio_height = sanitize_text_field( $_POST['portfolio_image_height'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, 'portfolio_person_name', $portfolio_name );
    update_post_meta( $post_id, 'portfolio_person_url', $portfolio_url );
    update_post_meta( $post_id, 'portfolio_image_height', $portfolio_height );
}
add_action( 'save_post', 'portfolio_save_meta_box_data' );


// Hook into the 'init' action
add_action( 'init', 'portfolio_post_type', 0 );

if ( ! function_exists( 'portfolio_shortcode' ) ) {
 
    function portfolio_shortcode( $attr , $content) {

        global $post;

         if (!empty($content) && is_array($content)) {
        $attr = $content;
        if (!empty($attr[0])) $content = $attr[0];
        else $content = '';
        }

        $output = $content; 

        // set the query arguments
        $query_args = array(
            // show all posts matching this query
            'posts_per_page'    =>   -1,
            // show the 'portfolio' custom post type
            'post_type'         =>   'portfolio',
            // tell WordPress that it doesn't need to count total rows - this little trick reduces load on the database if you don't need pagination
            'no_found_rows'     =>   true,
        );
         
        // get the posts with our query arguments
        $portfolio_posts = get_posts( $query_args );

        if($attr['pstyle']=='ajax'):
        $output .='<div id="ajax-div">     
                <div class="container clearfix"> 
                
                    <!-- Close Button --> 
                    <div class="center-elements">
                        <div id="closeProject">
                            <a href="#loader"></a>               
                        </div> 
                    </div>
                 
                    <!-- LOADING -->
                    <div id="loader"></div>
                     
                    <!-- AJAX CONTENT -->
                    <div id="content-ajax">
                        <div id="maincontent-ajax"></div>
                    </div>
                      
                </div><!-- END CONTAINER -->
        
           </div>';
        endif;
        $output .='<div id="loader"></div>';
        $output .=' <div id="filters-container" class="cbp-l-filters-alignCenter">';
        $output .= '<div data-filter="*" class="cbp-filter-item">all</div>';

        $taxonomies = get_object_taxonomies( 'portfolio', 'objects' );
            foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){
            
            $terms[]=get_terms('portfolio_filter','');
        }

        foreach($terms as $item){
            foreach($item as $single){
             $output .= '<div data-filter=".'.$single->slug.'" class="cbp-filter-item">'.$single->name.'</div>';
            }
        }
        if($attr['playout']=="box"):
        wp_enqueue_script('jquery.cubeportfolio.min-js', get_template_directory_uri().'/assets/js/jquery.cubeportfolio.min.js', array(), FALSE, TRUE);    
        wp_enqueue_script('portfolio-js', get_template_directory_uri().'/assets/js/portfolio-video.js', array(), FALSE, TRUE);
        else:
        wp_enqueue_script('jquery.cubeportfolio.min-js', get_template_directory_uri().'/assets/js/jquery.cubeportfolio.min.js', array(), FALSE, TRUE);    
        wp_enqueue_script('portfolio-js', get_template_directory_uri().'/assets/js/portfolio-parallax.js', array(), FALSE, TRUE);
        endif;

        $output .='</div>';

        $output .= ' 
        <div><div id="grid-container" class="cbp-l-grid-'.esc_attr($attr['playout']).'">
        <ul>';
         
        // handle our custom loop
        foreach ( $portfolio_posts as $post ) {
            setup_postdata( $post );
            $portfolio_item_title = get_the_title( $post->ID );
            $portfolio_item_name =esc_attr(get_post_meta( $post->ID, 'portfolio_person_name', true ));
            $portfolio_item_post =esc_url(get_post_meta( $post->ID, 'portfolio_person_url', true ));
            $portfolio_item_height =esc_attr(get_post_meta( $post->ID, 'portfolio_image_height', true ));
            $portfolio_item_content = get_the_content();
            $thumb =  wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
            $filters =   get_object_taxonomies( $post->ID, 'portfolio_filter' );
            $terms = get_the_terms( $post->ID, 'portfolio_filter' );          
            if ( $terms && ! is_wp_error( $terms ) ) : 

                $term_links = array();
                $term_names = array();
                foreach ( $terms as $term ) {
                    $term_links[] = $term->slug;
                    $term_names[] = $term->name;
                }
                                    
                $filters = join( " / ", $term_names );
                $classes = join( " ", $term_links );
            endif;    
            
            if($attr['pstyle']=='light') :
            $output .= '
                                <li class="cbp-item '.$classes.' cbp-l-grid-masonry-height'.$portfolio_item_height.'">
                                <a id="portfolio_'.$post->ID.'" class="main cbp-caption cbp-lightbox " data-title="'.$portfolio_item_title.'" href="'.$thumb.'">
                                    <!-- Thumbnail -->
                                    <div class="cbp-caption-defaultWrap">
                                         '.get_the_post_thumbnail($post->ID, 'large', array('class' => 'image-blog')).'
                                    </div>
                                    
                                    <!-- Caption -->
                                    <div class="cbp-caption-activeWrap">
                                        <div class="cbp-l-caption-alignCenter">
                                            <div class="cbp-l-caption-body">
                                                <div class="cbp-l-caption-title">'.$portfolio_item_title.'</div>
                                                <div class="cbp-l-grid-projects-desc text-center">'.$filters.'</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                </li>

                                   ';
            elseif($attr['pstyle']=='ajax'):

             $output .= '

                            <li class="cbp-item '.$classes.' cbp-l-grid-masonry-height'.$portfolio_item_height.'">
                            <a id="portfolio_'.$post->ID.'" class="main cbp-caption portfolio-slider" data-title="'.$portfolio_item_title.'" href="javascript:;">
                                <!-- Thumbnail -->
                                <div class="cbp-caption-defaultWrap">
                                     '.get_the_post_thumbnail($post->ID, 'large', array('class' => 'image-blog')).'
                                </div>
                                
                                <!-- Caption -->
                                <div class="cbp-caption-activeWrap">
                                    <div class="cbp-l-caption-alignCenter">
                                        <div class="cbp-l-caption-body">
                                            <div class="cbp-l-caption-title">'.$portfolio_item_title.'</div>
                                            <div class="cbp-l-grid-projects-desc text-center">'.$filters.'</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </li>

                               ';

             else:

             $output .= '
                            <li class="cbp-item '.$classes.' cbp-l-grid-masonry-height'.$portfolio_item_height.'">
                            <!-- Add class "cbp-lightbox" for overlay effect -->
                            <a id="portfolio_'.$post->ID.'" class="main cbp-caption portfolio-slider" data-title="'.$portfolio_item_title.'" href="'.$post->guid.'">
                                <!-- Thumbnail -->
                                <div class="cbp-caption-defaultWrap">
                                     '.get_the_post_thumbnail($post->ID, 'large', array('class' => 'image-blog')).'
                                </div>
                                
                                <!-- Caption -->
                                <div class="cbp-caption-activeWrap">
                                    <div class="cbp-l-caption-alignCenter">
                                        <div class="cbp-l-caption-body">
                                            <div class="cbp-l-caption-title">'.$portfolio_item_title.'</div>
                                            <div class="cbp-l-grid-projects-desc text-center">'.$filters.'</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </li>

                               ';



            endif;
               
        }
         
        wp_reset_postdata();
        $output .= ' </ul></div>
        ';      
         
        if($attr['pstyle']=='ajax'){

             $output .='
                <script>
                jQuery(document).ready(function($) {
                    $( ".main.cbp-caption, .ajax.cbp-l-caption-body" ).on( "click", function() {
                        $( "div#loader" ).show();
                        var data = {
                          "action": "portfolio",
                          "id": $(this).attr("id"),
                        };


                        $.post("'.home_url().'/wp-admin/admin-ajax.php", data, function(response) {
                            $( "div#loader" ).hide();
                            $( "#maincontent-ajax" ).css({"height":"0","opacity":"0"});   
                            $( "#maincontent-ajax" ).html(response); 
                            jQuery("html,body").stop().animate({scrollTop: ($( "#maincontent-ajax" ).offset().top-120)+"px"},800,"easeOutExpo", function(){                                           
                                $( "#closeProject" ).children().show();
                                projectContainer=$( "#maincontent-ajax" );
                                wrapperHeight = $("#ajaxpage").outerHeight()+"px";
                                projectContainer.animate({opacity:1,height:wrapperHeight}, function(){
                                    jQuery(".container").fitVids();
                                $(this).fadeIn();
                                });

                            });
                            

                            jQuery(".flexslider").flexslider({
                                animation: "fade",
                                slideDirection: "horizontal",
                                slideshow: true,
                                slideshowSpeed: 3500,
                                animationDuration: 500,
                                directionNav: true,
                                controlNav: true
                                
                            });

                            jQuery("#closeProject a").on("click",function () {
                                $( "#maincontent-ajax" ).animate({opacity:0,height:0},function(){
                                $( "#closeProject" ).children().hide();
                                $("#maincontent-ajax").children().remove();
                                  
                                });
                             
                                
                                
                            });
         
                        });
                            
                    });
                });
                </script>';
               
            }
        return $output;
}
    add_shortcode( 'portfolio_block', 'portfolio_shortcode' );
}

add_action( 'wp_ajax_portfolio', 'portfolio_callback' );
add_action('wp_ajax_nopriv_portfolio', 'portfolio_callback');

function portfolio_callback() {

  global $wpdb; // this is how you get access to the database


        $postid = substr($_POST['id'], 10);
        $post = get_post($postid); 
        $portfolio_item_title = get_the_title( $post->ID ); 
        $portfolio_item_name =esc_attr(get_post_meta( $post->ID, 'portfolio_person_name', true ));
        $portfolio_item_url =esc_url(get_post_meta( $post->ID, 'portfolio_person_url', true ));
        $postContentStr = apply_filters('the_content', strip_shortcodes($post->post_content));
        $gallery=0;
        $filters = '';
           $terms = get_the_terms( $post->ID, 'portfolio_filter' );          
            if ( $terms && ! is_wp_error( $terms ) ) : 

                $term_links = array();
                foreach ( $terms as $term ) {
                    $term_links[] = $term->name;
                }
                                    
                $filters = join( " / ", $term_links );
            endif;    
        ?>
        <div class="container"> 
        <div class="row">

                <div id="ajaxpage" class="left-slider">
    
                    <div class="space"></div>
                    <div class="space"></div>
                   
                    <!-- START PROJECT MEDIA -->
                    <div class="col-xs-12 col-sm-12 col-md-8 text-center">
                        

                        <?php if ( get_post_gallery($post->ID) ) : ?>
                        <div class="project-media">    
                           <?php echo get_post_gallery($post->ID); ?>
                        </div>   
                        <?php $gallery=1; endif; ?>

                        <?php if ( has_post_thumbnail($post->ID) && $gallery==0 ) : ?>
                        <div class="project-media"> </div>
                        <?php echo get_the_post_thumbnail($post->ID, 'large', array('class' => 'image-blog')); ?>
                        <?php endif; ?>

                   </div>
                    <!-- END PROJECT MEDIA -->
                    
                   <div class="col-xs-12 col-sm-12 col-md-4"> 
                        <!-- START PROJECT INFO --> 
                        <div class="project-info">
                            
                            <h1 class="title-open-proj"><?php echo $portfolio_item_title;?></h1>

                            <ul class="proj-tags">
                                <li><p><span><?php _e( 'Client','elano' ); ?></span>: <a href="<?php echo $portfolio_item_url; ?>"><?php echo $portfolio_item_name; ?></a></p></li>
                                <li><p><span><?php _e( 'Categories','elano' ); ?></span> : <?php echo $filters; ?></p></li>
                            </ul>
                            <div class="project-description">
                                <h5><?php _e( 'Project Description','elano' ); ?></h5>
                                
                                <p><?php echo $postContentStr; ?></p>
                            </div>
                           
                        </div>
                   </div>
                   
                   <div class="space"></div>
                   
                </div><!-- END AJAX PAGE --> 
        </div>
        </div>
          
     <div class="clear"></div>

        <?php

  die(); // this is required to return a proper result
}

if ( ! function_exists( 'portfolio_slider_shortcode' ) ) {
 
    function portfolio_slider_shortcode( $attr , $content ) {
       
        if (!empty($content) && is_array($content)) {
        $attr = $content;
        if (!empty($attr[0])) $content = $attr[0];
        else $content = '';
        }

        $output = $content; 

        // set the query arguments
        $query_args = array(
            // show all posts matching this query
            'posts_per_page'    =>   isset($attr['slidesnum']) ? $attr['slidesnum'] : '-1',
            // show the 'portfolio' custom post type
            'post_type'         =>   'portfolio',
            // tell WordPress that it doesn't need to count total rows - this little trick reduces load on the database if you don't need pagination
            'no_found_rows'     =>   true,
        );
         
        // get the posts with our query arguments
        $portfolio_posts = get_posts( $query_args );
       
        if(isset($attr['portfolio_button']) && $attr['portfolio_button']==1) {
        $output .=' <div class="text-center">
                    <a href="#portfolio" class="nav-to btn-color btn-color-fill btn-color-1d"><span>VIEW PORTFOLIO</span></a>
                    </div>
                ';
        }
      
        $output .= '<div id="featured-projects" class="owl-carousel cbp-caption-zoom portfolio-entries light-text">';
         
        // handle our custom loop
        foreach ( $portfolio_posts as $post ) {
            setup_postdata( $post );
            $portfolio_item_title = get_the_title( $post->ID );
            $portfolio_item_name =esc_attr(get_post_meta( $post->ID, 'portfolio_person_name', true ));
            $portfolio_item_url =esc_url(get_post_meta( $post->ID, 'portfolio_person_url', true ));
            $portfolio_item_content = get_the_content();
            $thumb =  wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
            $filters =   get_object_taxonomies( $post->ID, 'portfolio_filter' );
            $terms = get_the_terms( $post->ID, 'portfolio_filter' );          
            if ( $terms && ! is_wp_error( $terms ) ) : 

                $term_links = array();
                foreach ( $terms as $term ) {
                    $term_links[] = $term->name;
                }
                                    
                $filters = join( " / ", $term_links );
                $classes = join( " ", $term_links );
            endif;  
        
           if($attr['pstyle']=='light'):
            $output .= '
            <div class="carousel-item">
                        <div class="cbp-caption">
                            <div class="cbp-caption-defaultWrap">
                               '.get_the_post_thumbnail($post->ID, 'large', array('class' => 'image-blog')).'
                            </div>
                            <div class="cbp-caption-activeWrap">
                                <div class="cbp-l-caption-alignCenter">
                                    <a id="portfolia_'.$post->ID.'" class="cbp-l-caption-body cbp-caption cbp-lightbox" href="'.$thumb.'">
                                        <div class="cbp-l-grid-projects-title text-center">'.$portfolio_item_title.'</div>
                                        <div class="cbp-l-grid-projects-desc text-center">'.$filters.'</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>';
            elseif($attr['pstyle']=='ajax'):

             $output .= '
            <div class="carousel-item">
                        <div class="cbp-caption">
                            <div class="cbp-caption-defaultWrap">
                               '.get_the_post_thumbnail($post->ID, 'large', array('class' => 'image-blog')).'
                            </div>
                            <div class="cbp-caption-activeWrap">
                                <div class="cbp-l-caption-alignCenter">
                                    <a id="portfolia_'.$post->ID.'" class=" ajax cbp-l-caption-body "  href="javascript:;">
                                        <div class="cbp-l-grid-projects-title text-center">'.$portfolio_item_title.'</div>
                                        <div class="cbp-l-grid-projects-desc text-center">'.$filters.'</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> ';
            else:

            $output .= '
            <div class="carousel-item">
                        <div class="cbp-caption">
                            <div  class="cbp-caption-defaultWrap">
                               '.get_the_post_thumbnail($post->ID, 'large', array('class' => 'image-blog')).'
                            </div>
                            <div class="cbp-caption-activeWrap">
                                <div class="cbp-l-caption-alignCenter">
                                    <a id="portfolia_'.$post->ID.'" class="cbp-l-caption-body" href="'.$post->guid.'">
                                        <div class="cbp-l-grid-projects-title text-center">'.$portfolio_item_title.'</div>
                                        <div class="cbp-l-grid-projects-desc text-center">'.$filters.'</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> ';

            endif;


               
        }
         
        wp_reset_postdata();
        $output .= ' </div>';      
         
        return $output;
    }
 
    add_shortcode( 'portfolio_slider', 'portfolio_slider_shortcode' );
}
global $metaboxes;
$metaboxes = array(
    'link_url' => array(
        'title' => __('Link Settings', 'elano'),
        'applicableto' => 'post',
        'location' => 'normal',
        'display_condition' => 'post-format-link',
        'priority' => 'high',
        'fields' => array(
            'l_url' => array(
                'title' => __('link url:', 'elano'),
                'type' => 'text',
                'description' => '',
                'size' => 60
            )
        )
    ),
    
    'video_code' => array(
        'title' => __('Video Settings', 'elano'),
        'applicableto' => 'post',
        'location' => 'normal',
        'display_condition' => 'post-format-video',
        'priority' => 'high',
        'fields' => array(
            'video_id' => array(
                'title' => __('Video url:', 'elano'),
                'type' => 'text',
                'description' => '',
                'size' => 60
            )
        )
    ),
    
    'audio_code' => array(
        'title' => __('Audio Settings', 'elano'),
        'applicableto' => 'post',
        'location' => 'normal',
        'display_condition' => 'post-format-audio',
        'priority' => 'high',
        'fields' => array(
            'audio_id' => array(
                'title' => __('Audio url:', 'elano'),
                'type' => 'text',
                'description' => '',
                'size' => 60
            )
        )
    ),

    'quote_author' => array(
        'title' => __('Quote Settings', 'elano'),
        'applicableto' => 'post',
        'location' => 'normal',
        'display_condition' => 'post-format-quote',
        'priority' => 'high',
        'fields' => array(
            'q_author' => array(
                'title' => __('quote author:', 'elano'),
                'type' => 'text',
                'description' => '',
                'size' => 20
            )
        )
    )
);

add_action( 'add_meta_boxes', 'elano_add_post_format_metabox' );
 
function elano_add_post_format_metabox() {
    global $metaboxes;
 
    if ( ! empty( $metaboxes ) ) {
        foreach ( $metaboxes as $id => $metabox ) {
            add_meta_box( $id, $metabox['title'], 'elano_show_metaboxes', $metabox['applicableto'], $metabox['location'], $metabox['priority'], $id );
        }
    }
}

function elano_show_metaboxes( $post, $args ) {
    global $metaboxes;
 
    $custom = get_post_custom( $post->ID );
    $fields = $tabs = $metaboxes[$args['id']]['fields'];
 
    /** Nonce **/
    $output = '<input type="hidden" name="post_format_meta_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';
 
    if ( sizeof( $fields ) ) {
        foreach ( $fields as $id => $field ) {
            switch ( $field['type'] ) {
                default:
                case "text":
                    if(isset($custom[$id][0])) {
                    $output .= '<label for="' . $id . '">' . $field['title'] . '</label><input id="' . $id . '" type="text" name="' . $id . '" value="' . $custom[$id][0] . '" size="' . $field['size'] . '" />';
                    } else {
                    $output .= '<label for="' . $id . '">' . $field['title'] . '</label><input id="' . $id . '" type="text" name="' . $id . '" value="" size="' . $field['size'] . '" />';
                    }
                    break;
            }
        }
    }
 
    echo $output;
}


add_action( 'save_post', 'elano_save_metaboxes' );
 
function elano_save_metaboxes( $post_id ) {
    global $metaboxes;
 
    // verify nonce
    
    if(isset($_POST['post_format_meta_box_nonce'])){
    if ( ! wp_verify_nonce( $_POST['post_format_meta_box_nonce'], basename( __FILE__ ) ) )
        return $post_id;
    }

    // check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;
 
    // check permissions
    if ( isset( $_POST['post_type'] ) &&  'page' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) )
            return $post_id;
    } elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }
 
    $post_type = get_post_type();

    // loop through fields and save the data
    foreach ( $metaboxes as $id => $metabox ) {
        // check if metabox is applicable for current post type
        if ( $metabox['applicableto'] == $post_type ) {
            $fields = $metaboxes[$id]['fields'];
 
            foreach ( $fields as $id => $field ) {
                $old = get_post_meta( $post_id, $id, true );
                if(isset($_POST[$id])) {
                    $new = $_POST[$id];
     
                    if ( $new && $new != $old ) {
                        update_post_meta( $post_id, $id, $new );
                    }
                    elseif ( '' == $new && $old || ! isset( $_POST[$id] ) ) {
                        delete_post_meta( $post_id, $id, $old );
                    }
                }
            }
        }
    }
}


add_action( 'admin_print_scripts', 'elano_display_metaboxes', 1000 );
function elano_display_metaboxes() {
    global $metaboxes;
    if ( get_post_type() == "post" ) :
        ?>
        <script type="text/javascript">// <![CDATA[
            $ = jQuery;
 
            <?php
            $formats = $ids = array();
            foreach ( $metaboxes as $id => $metabox ) {
                array_push( $formats, "'" . $metabox['display_condition'] . "': '" . $id . "'" );
                array_push( $ids, "#" . $id );
            }
            ?>
 
            var formats = { <?php echo implode( ',', $formats );?> };
            var ids = "<?php echo implode( ',', $ids ); ?>";
             function displayMetaboxes() {
                // Hide all post format metaboxes
                $(ids).hide();
                // Get current post format
                var selectedElt = $("input[name='post_format']:checked").attr("id");
 
                // If exists, fade in current post format metabox
                if ( formats[selectedElt] )
                    $("#" + formats[selectedElt]).fadeIn();
            }
 
            $(function() {
                // Show/hide metaboxes on page load
                displayMetaboxes();
 
                // Show/hide metaboxes on change event
                $("input[name='post_format']").change(function() {
                    displayMetaboxes();
                });
            });
 
        // ]]></script>
        <?php
    endif;
}

function be_attachment_field_credit( $form_fields, $post ) {
    $form_fields['destination_url'] = array(
        'label' => 'Destination',
        'input' => 'text',
        'value' => get_post_meta( $post->ID, 'destination_url', true ),
        'helps' => 'Add destination URL',
    );
    return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'be_attachment_field_credit', 10, 2 );

function be_attachment_field_credit_save( $post, $attachment ) {
    if( isset( $attachment['destination_url'] ) )
    update_post_meta( $post['ID'], 'destination_url', esc_url( $attachment['destination_url'] ) );
    return $post;
}
add_filter( 'attachment_fields_to_save', 'be_attachment_field_credit_save', 10, 2 );

?>