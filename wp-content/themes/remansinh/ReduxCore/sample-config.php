<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('Redux_Framework_sample_config')) {

    class Redux_Framework_sample_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {


            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();
            +
            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'elano'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'elano'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'elano'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'elano'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'elano'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'elano') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'elano'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                Redux_Functions::initWpFilesystem();
                
                global $wp_filesystem;

                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'title'     => __('Home Settings', 'elano'),
                'icon'      => 'el-icon-home',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    => array(

                    array(
                        'id'        => 'logo',
                        'type'      => 'media',
                        'title'     => __('Logo Normal', 'elano'),
                        'compiler'  => 'true',
                        'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'subtitle'  => __('Upload header logo for your website', 'elano'),
                        
                    ),

			array(
                        'id'        => 'retinalogo',
                        'type'      => 'media',
                        'title'     => __('Logo Retina', 'elano'),
                        'compiler'  => 'true',
                        'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'subtitle'  => __('Upload header logo for your website', 'elano'),
                        
                    ),

                    array(
                        'id'        => 'blog_title',
                        'type'      => 'switch',
                        'title'     => __('Logo Text', 'elano'),
                        'subtitle'  => __('Display Site Title from WP General Settings', 'elano'),
                        'default'   => '1',
                    ),
                    
                    
                    array(
                        'id'        => 'menu-style',
                        'type'      => 'select',
                        'multi'     => false,
                        'title'     => __('Menu style', 'elano'),
                        'subtitle'  => __('Choose the style of menu', 'elano'),
                        
                        //Must provide key => value pairs for radio options
                        'options'   => array(
                            'light' => 'Light', 
                            'dark' => 'Dark', 
                        ), 
                        'default'   => array('light')
                    ),


                    array(
                        'id'        => 'menu-start',
                        'type'      => 'switch',
                        'title'     => __('Menu display', 'elano'),
                        'subtitle'  => __('Hide/Show Menu on start', 'elano'),
                        'default'   => '1',
                    ),
                    
                    
                    array(
                        'id'        => 'preloader',
                        'type'      => 'switch',
                        'title'     => __('Activate preloader', 'elano'),
                        'subtitle'  => __('Smooth page loader for your site', 'elano'),
                        'default'   => '1',
                    ),

                    array(
                        'id'        => 'preloader-logo',
                        'type'      => 'media',
                        'title'     => __('Logo in the Preloader', 'elano'),
                        'compiler'  => 'true',
                        'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'subtitle'  => __('Upload logo to be displayed on prelaoder', 'elano'),
                        
                    ),
			array(
                        'id'        => 'preloader-retinalogo',
                        'type'      => 'media',
                        'title'     => __('Retina Logo in the Preloader', 'elano'),
                        'compiler'  => 'true',
                        'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'subtitle'  => __('Upload logo to be displayed on prelaoder', 'elano'),
                        
                    ),
                    array(
                        'id'        => 'preloader-image',
                        'type'      => 'switch',
                        'title'     => __('Preloader Logo', 'elano'),
                        'subtitle'  => __('Do you wan to show logo on preloader?', 'elano'),
                        'default'   => '0',
                    ),

                    array(
                        'id'        => 'preloader-title',
                        'type'      => 'switch',
                        'title'     => __('Preloader Title', 'elano'),
                        'subtitle'  => __('Do you want to show site title on preloader?', 'elano'),
                        'default'   => '0',
                    ),

                    
                    array(
                        'id'        => 'favicon',
                        'type'      => 'media',
                        'title'     => __('Favicon', 'elano'),
                        'compiler'  => 'true',
                        'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'subtitle'  => __('Upload favicon for your website', 'elano'),
                        
                    ),
                    
                    
                    array(
                        'id'        => 'article_author',
                        'type'      => 'switch',
                        'title'     => __('Article Author', 'elano'),
                        'subtitle'  => __('Display article author on blog post', 'elano'),
                        'default'   => '1',
                    ),

                    array(
                        'id'        => 'article_related',
                        'type'      => 'switch',
                        'title'     => __('Related Article', 'elano'),
                        'subtitle'  => __('Display related article on blog post', 'elano'),
                        'default'   => '1', 
                    ),

                    

                ),
            );
            
            $this->sections[] = array(
                'icon'      => 'el-icon-th',
                'title'     => __('Footer Options', 'elano'),
                'fields'    => array(
                    	 array(
                        'id'        => 'footer-logo',
                        'type'      => 'media',
                        'title'     => __('Logo in Footer', 'elano'),
                        'compiler'  => 'true',
                        'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'subtitle'  => __('Upload logo to be dispalyed on the footer', 'elano'),
                        
                    ),

			array(
                        'id'        => 'footer-retinalogo',
                        'type'      => 'media',
                        'title'     => __('Retina Logo in Footer', 'elano'),
                        'compiler'  => 'true',
                        'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'subtitle'  => __('Upload logo to be dispalyed on the footer', 'elano'),
                        
                    ),

                    array(
                        'id'        => 'footer_text',
                        'type'      => 'editor',
                        'title'     => __('Footer Text', 'elano'),
                        'subtitle'  => __('The text written here will be display in footer', 'elano'),
                        'default'   => 'Copyright 2014, Elano',
                    ),

                    array(
                        'id'        => 'footer-social',
                        'type'      => 'switch',
                        'title'     => __('Social Icons', 'elano'),
                        'subtitle'  => __('Display social icons on footer', 'elano'),
                        'default'   => '1',
                    ),
                    array(
                        'id'        => 'footer-style2',
                        'type'      => 'switch',
                        'title'     => __('Footer Style 2', 'elano'),
                        'subtitle'  => __('Try our alternative footer style?', 'elano'),
                        'default'   => '0',
                    ),


                    array(
                        'id'        => 'footer-layout',
                        'type'      => 'image_select',
                        'title'     => __('Option for Footer Layout', 'redux-framework-demo'),
                        
                        //Must provide key => value(array:title|img) pairs for radio options
                        'options'   => array(
                            '1' => array('alt' => '1 Column',        'img' => ReduxFramework::$_url . 'assets/img/ft-1cl.png'),
                            '2' => array('alt' => '2 Column',        'img' => ReduxFramework::$_url . 'assets/img/ft-2cl.png'),
                            '3' => array('alt' => '2 Column Left',   'img' => ReduxFramework::$_url . 'assets/img/ft-2cl2.png'),
                            '4' => array('alt' => '2 Column Right',  'img' => ReduxFramework::$_url . 'assets/img/ft-2cl3.png'),
                            '5' => array('alt' => '2 Column Middle', 'img' => ReduxFramework::$_url . 'assets/img/ft-2cl4.png'),
                            '6' => array('alt' => '3 Column       ', 'img' => ReduxFramework::$_url . 'assets/img/ft-3cl.png'),
                            '7' => array('alt' => '3 Column Left',   'img' => ReduxFramework::$_url . 'assets/img/ft-3cl2.png'),
                            '8' => array('alt' => '3 Column Right',  'img' => ReduxFramework::$_url . 'assets/img/ft-3cl3.png'),
                            '9' => array('alt' => '3 Column middle','img' => ReduxFramework::$_url . 'assets/img/ft-3cl4.png'),
                            '10' => array('alt' => '4 Column      ',  'img' => ReduxFramework::$_url . 'assets/img/ft-4cl.png')
                        ), 
                        'default' => '2'
                    ),
                )
            );
            
            
            $this->sections[] = array(
                'icon'      => 'el-icon-website',
                'title'     => __('Styling Options', 'elano'),
                'fields'    => array(
                    array(
                        'id'        => 'css_style',
                        'type'      => 'select',
                        'title'     => __('Theme Stylesheet', 'elano'),
                        'subtitle'  => __('Select an predefined color scheme.', 'elano'),
                        'options'   => array('pink' => 'pink', 'emerald' => 'emerald', 'nature' => 'nature', 'ocean' => 'ocean', 'orange' => 'orange', 'red' => 'red', 'river' => 'river', 'silver' => 'silver', 'sun' => 'sun', 'turquoise' => 'turquoise'),
                        'default'   => 'pink',
                    ),
                    
                    
                    array( 
					    'id'       => 'custom_color',
					    'type'     => 'color',
					    'title'    => __('Your Custom Color', 'redux-framework-demo'),
					    'subtitle' => __('Select an custom color scheme.', 'elano'),
					),
					

                    
                    array(
                        'id'        => 'background',
                        'type'      => 'background',
                        'output'    => array('body'),
                        'title'     => __('Body Background', 'elano'),
                        'subtitle'  => __('Body background with image, color, etc.', 'elano'),
                        'default'   => '#FFFFFF',
                    ),
                    array(
                        'id'        => 'background-footer',
                        'type'      => 'background',
                        'output'    => array('.footer'),
                        'title'     => __('Footer Background Color', 'elano'),
                        'subtitle'  => __('Pick a background color for the footer (default: #dd9933).', 'elano'),
                        'default'   => '#100f0f',
                    ),
                                 
                    array(
                        'id'        => 'link-color',
                        'type'      => 'link_color',
                        'title'     => __('Links Color Option', 'elano'),
                        'subtitle'  => __('Only color validation can be done on this field type', 'elano'),
                        //'regular'   => false, // Disable Regular Color
                        //'hover'     => false, // Disable Hover Color
                        //'active'    => false, // Disable Active Color
                        //'visited'   => true,  // Enable Visited Color
                        'default'   => array(
                            'regular'   => '#aaa',
                            'hover'     => '#bbb',
                            'active'    => '#ccc',
                        )
                    ),
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-eye-open',
                'title'     => __('Theme fonts (typography)', 'elano'),
                'desc'      => __('<p class="description">You can change theme fonts.</p>', 'elano'),
                'fields'    => array(
                    array(
                        'id'        => 'typography-body',
                        'type'      => 'typography',
                        'output'    => array('body'),
                        'title'     => __('Body Font', 'elano'),
                        'subtitle'  => __('Specify the body font properties.', 'elano'),
                        'google'    => TRUE,
                    ),

                    array(
                        'id'        => 'typography-menu',
                        'type'      => 'typography',
                        'output'    => array('.navbar-nav > li > a'),
                        'title'     => __('Menu Font', 'elano'),
                        'subtitle'  => __('Specify the Menu font properties.', 'elano'),
                        'google'    => TRUE,
                    ),

                    array(
                        'id'        => 'typography-h1',
                        'type'      => 'typography',
                        'output'    => array('h1'),
                        'title'     => __('H1 Font', 'elano'),
                        'subtitle'  => __('Specify the font properties.', 'elano'),
                        'google'    => TRUE,
                    ),
                    array(
                        'id'        => 'typography-h2',
                        'type'      => 'typography',
                        'output'    => array('h2'),
                        'title'     => __('H2 Font', 'elano'),
                        'subtitle'  => __('Specify the font properties.', 'elano'),
                        'google'    => true,
                    ),
                    array(
                        'id'        => 'typography-h3',
                        'type'      => 'typography',
                        'output'    => array('h3'),
                        'title'     => __('H3 Font', 'elano'),
                        'subtitle'  => __('Specify the font properties.', 'elano'),
                        'google'    => true,
                    ),
                    array(
                        'id'        => 'typography-h4',
                        'type'      => 'typography',
                        'output'    => array('h4'),
                        'title'     => __('H4 Font', 'elano'),
                        'subtitle'  => __('Specify the font properties.', 'elano'),
                        'google'    => true,
                    ),
                    array(
                        'id'        => 'typography-h5',
                        'type'      => 'typography',
                        'output'    => array('h5'),
                        'title'     => __('H5 Font', 'elano'),
                        'subtitle'  => __('Specify the font properties.', 'elano'),
                        'google'    => true,
                    ),
                    array(
                        'id'        => 'typography-h6',
                        'type'      => 'typography',
                        'output'    => array('h6'),
                        'title'     => __('H6 Font', 'elano'),
                        'subtitle'  => __('Specify the font properties.', 'elano'),
                        'google'    => true,
                    ),

                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-eye-open',
                'title'     => __('Inner Pages Options', 'elano'),
                'desc'      => __('<p class="description">You can change inner page title section and menu .</p>', 'elano'),
                'fields'    => array(
                   
                    array(
                        'id'        => 'ptitle-typo',
                        'type'      => 'typography',
                        'title'     => __('Page title topography', 'elano'),
                        'output'    => array('.light-text .section-title h2'),
                        'google'    => true,
                    ),

                     array(
                        'id'        => 'ptitle-back',
                        'type'      => 'background',
                        'output'    => array('.pagetitle'),
                        'title'     => __('Page title Background', 'elano'),
                    ),

                     array(
                        'id'        => 'ptitle-parallax',
                        'type'      => 'switch',
                        'title'     => __('Parallax background', 'elano'),
                        'subtitle'  => __('Do you want to parallax background on page title?', 'elano'),
                        'default'   => '0',
                    ),




                )
            );


            $this->sections[] = array(
                'icon'      => 'el-icon-bullhorn',
                'title'     => __('Social Icons', 'elano'),
                'desc'      => __('<p class="description">You need to provide social details to display the social icons on footer.</p>', 'elano'),
                'fields'    => array(
                    array(
                        'id'        => 'social_facebook',
                        'type'      => 'text',
                        'title'     => __('Facebook URL', 'elano'),
                        'validate'  => 'url',
                    ),
                    array(
                        'id'        => 'social_twitter',
                        'type'      => 'text',
                        'title'     => __('Twitter URL', 'elano'),
                        'validate'  => 'url',
                    ),
                    array(
                        'id'        => 'social_googlep',
                        'type'      => 'text',
                        'title'     => __('Google Plus URL', 'elano'),
                        'validate'  => 'url',
                    ),
                    array(
                        'id'        => 'social_linkedin',
                        'type'      => 'text',
                        'title'     => __('LinkedIn URL', 'elano'),
                        'validate'  => 'url',
                    ),
                    array(
                        'id'        => 'social_pinterest',
                        'type'      => 'text',
                        'title'     => __('Pinterest URL', 'elano'),
                        'validate'  => 'url',
                    ),
                    array(
                        'id'        => 'social_skype',
                        'type'      => 'text',
                        'title'     => __('Skype URL', 'elano'),
                        'validate'  => 'url',
                    ),
                    array(
                        'id'        => 'social_dribbble',
                        'type'      => 'text',
                        'title'     => __('Dribbble URL', 'elano'),
                        'validate'  => 'url',
                    ),
                    array(
                        'id'        => 'social_tumblr',
                        'type'      => 'text',
                        'title'     => __('Tumblr URL', 'elano'),
                        'validate'  => 'url',
                    ),
                    array(
                        'id'        => 'social_youtube',
                        'type'      => 'text',
                        'title'     => __('Youtube URL', 'elano'),
                        'validate'  => 'url',
                    ),
                    array(
                        'id'        => 'social_vimeo',
                        'type'      => 'text',
                        'title'     => __('Vimeo URL', 'elano'),
                        'validate'  => 'url',
                    ),
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-twitter',
                'title'     => __('Twitter Settings', 'elano'),
                'desc'      => __('<p class="description">Add your twitter details for displaying tweet slides.</p>', 'elano'),
                'fields'    => array(
                    array(
                        'id'        => 'twitter_username',
                        'type'      => 'text',
                        'title'     => __('Twitter Username', 'elano'),
                    ),
                    array(
                        'id'        => 'twitter_consumer_key',
                        'type'      => 'text',
                        'title'     => __('Twitter App Consumer Key', 'elano'),
                    ),
                    array(
                        'id'        => 'twitter_secret_key',
                        'type'      => 'text',
                        'title'     => __('Twitter App Secret Key', 'elano'),
                    ),
                    array(
                        'id'        => 'twitter_token',
                        'type'      => 'text',
                        'title'     => __('Twitter App Access Token', 'elano'),
                    ),
                    array(
                        'id'        => 'twitter_token_secret',
                        'type'      => 'text',
                        'title'     => __('Twitter App  Token Secret Key', 'elano'),
                    ),
                    array(
                        'id'        => 'twitter_number',
                        'type'      => 'text',
                        'title'     => __('Number Tweets to Show', 'elano'),
                        'validate'  => 'numeric',
                        'default'   => '5',
                    ),
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-signal',
                'title'     => __('SEO options', 'elano'),
                'desc'      => __('<p class="description">We consider your online presense.</p>', 'elano'),
                'fields'    => array(
                    
                    array(
                        'id'        => 'meta_javascript',
                        'type'      => 'textarea',
                        'title'     => __('Tracking Code', 'elano'),
                        'subtitle'  => __('Paste your <b>Google Analytics</b> (or other) tracking code here. This will be added into the footer template of your theme.', 'elano'),
                           
                    ),
                    
                    array(
                        'id'        => 'meta_head',
                        'type'      => 'textarea',
                        'title'     => __('Meta Heading', 'elano'),
                        'validate'  => 'no_html',

                    ),
                    array(
                        'id'        => 'meta_author',
                        'type'      => 'text',
                        'title'     => __('Meta Author', 'elano'),

                    ),

                    array(
                        'id'        => 'meta_desc',
                        'type'      => 'textarea',
                        'title'     => __('Meta Description', 'elano'),
                        'validate'  => 'no_html',

                    ),

                    array(
                        'id'        => 'meta_keyword',
                        'type'      => 'textarea',
                        'title'     => __('Meta Keyword', 'elano'),
                        'validate'  => 'no_html',
                        'subtitle'  => __('Enter the wordpress seperated by comma.', 'elano'),

                    ),

                    

                )
            );



            $this->sections[] = array(
                'icon'      => 'el-icon-check',
                'title'     => __('Custom CSS', 'elano'),
                'desc'      => __('<p class="description">You can add custom CSS to override existing theme design.</p>', 'elano'),
                'fields'    => array(
                   array(
                        'id'        => 'extra-css',
                        'type'      => 'ace_editor',
                        'title'     => __('CSS Code', 'elano'),
                        'subtitle'  => __('Paste your CSS code here.', 'elano'),
                        'mode'      => 'css',
                        'theme'     => 'monokai',
                        'desc'      => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
                    ),
                 

                )
            );
            
            $theme_info  = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . __('<strong>Theme URL:</strong> ', 'elano') . '<a href="' . $this->theme->get('ThemeURI') . '" target="_blank">' . $this->theme->get('ThemeURI') . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . __('<strong>Author:</strong> ', 'elano') . $this->theme->get('Author') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . __('<strong>Version:</strong> ', 'elano') . $this->theme->get('Version') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . __('<strong>Tags:</strong> ', 'elano') . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

            if (file_exists(dirname(__FILE__) . '/../README.md')) {
                $this->sections['theme_docs'] = array(
                    'icon'      => 'el-icon-list-alt',
                    'title'     => __('Documentation', 'elano'),
                    'fields'    => array(
                        array(
                            'id'        => '17',
                            'type'      => 'raw',
                            'markdown'  => true,
                            'content'   => file_get_contents(dirname(__FILE__) . '/../README.md')
                        ),
                    ),
                );
            }
            
           

            $this->sections[] = array(
                'title'     => __('Import / Export', 'elano'),
                'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', 'elano'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );                     
                    
            $this->sections[] = array(
                'type' => 'divide',
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => __('Theme Information', 'elano'),
                'desc'      => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'elano'),
                'fields'    => array(
                    array(
                        'id'        => 'opt-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
                    )
                ),
            );

            if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', 'elano'),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'elano'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'elano')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'elano'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'elano')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'elano');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'elano_options',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => 'ELANO',     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Theme Options', 'elano'),
                'page_title'        => __('Theme Options', 'elano'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                 'footer_credit'     => 'Elano Theme Optional Panel',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el-icon-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el-icon-linkedin'
            );


            // Add content after the form.
            $this->args['footer_text'] = __('<p>Please get to us if you have any suggestions.</p>', 'elano');
        }

    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
