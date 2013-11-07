<?php

/**
 * @package Redux Framework
 * @version 4.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

// Don't duplicate me!
if (!class_exists('Redux_Sidebars')) {
    class Redux_Sidebars {
        
        public static $version = '1.0.0';
        
        private $args;
        
        private $sidebars;
        
        private $default_sidebars;
        
        private $option_name;
        
        public static $_properties = array(
          'option_name' => '', 
          'sidebars' => array()
        );
        
        public function __construct( $args = array(), $sidebars = array() ) {
            
            $args     = array();
            $defaults = array(
                'option_name' => 'redux_sidebars'
            );
            
            $this->args = Redux_Framework::parse_args( $args, $defaults );
            
            $this->args = apply_filters( 'redux/sidebars/' . $this->args['option_name'] . '/args', $this->args );
            
            $this->default_sidebars = $sidebars; // Default sidebars set by the $sidebars array. Cannot delete.
            
            $this->sidebars = wp_parse_args( get_option( $this->args['option_name'] ), $this->default_sidebars );
            
            $this->sidebars = apply_filters( 'redux/sidebars/' . $this->args['option_name'] . '/sidebars', $this->sidebars );

            // Load the page assets on the widget page
            add_action('load-widgets.php', array(
                &$this,
                'load_assets'
            ), 5);
            
            // Init the custom sidebars on widget init
            add_action('widgets_init', array(
                &$this,
                'register_custom_sidebars'
            ), 1000);
            
            // Register the custom ajax hook for deleting
            add_action('wp_ajax_redux_sidebars_'.$this->args['option_name'].'_delete', array(
                &$this,
                'delete_sidebar_area'
            ), 1000);
            
        }
        
        public function load_assets() {
            // Add the new widget area form
            add_action( 'admin_print_scripts', array(
                &$this,
                'add_new_widget_area_box'
            ) );
            // Add the already set widget areas
            add_action( 'load-widgets.php', array(
                &$this,
                'add_sidebar_area'
            ), 100 );
            // Enqueu the needed files
            add_action( 'load-widgets.php', array(
                &$this,
                'enqueue'
            ), 100 );
        }
        
        public function add_new_widget_area_box() {
            $nonce = wp_create_nonce( 'redux/sidebars/' . $this->args['option_name'] . '/delete' );
          ?>
          <script type="text/html" id="redux-add-widget-template">
            <input type="hidden" name="redux-nonce" value="<?php echo $nonce; ?>" />
            <div id="redux-add-widget" class="widgets-holder-wrap">
              <div class="sidebar-name" style="cursor: inherit;">
                <h3><?php echo $this->title; ?> <span class="spinner"></span></h3>
              </div>
              <div id="redux-add-box" class="ui-sortable">
                <form action="" method="post">
                  <div class="widget-content">
                    <p style="font-weight: bold;"><label for="redux-add-widget-input"><?php echo __('New Widget Name', 'redux-framework'); ?>:</label>
                    <input id="redux-add-widget-input" name="redux-add-widget-input" type="text" class="regular-text" title="<?php echo __('New Widget Name', 'redux-framework'); ?>" />
                  </div>
                  <div class="widget-control-actions">
                    <div class="aligncenter">
                      <input class="button-primary" type="submit" value="<?php echo __('Create New Widget', 'redux-framework'); ?>" />
                    </div>
                    <br class="clear">
                  </div>
                </form>
              </div>
            </div>
          </script>
        <?php
        }
        
        /**
         * Function to create a new sidebar
         *
         * @since     1.0.0
         *
         * @param    string    Name of the sidebar to be deleted.
         *
         * @return    string     'sidebar-deleted' if successful.
         *
         */
        function add_sidebar_area() {
            if ( !empty( $_POST['redux-add-widget-input'] ) ) {
                $this->sidebars = get_option( $this->args['option_name'] );
                $name           = $this->check_sidebar_name( $_POST['redux-add-widget-input'] );
                if ( empty( $this->sidebars ) ) {
                    $this->sidebars = array(
                        $name
                    );
                } else {
                    $this->sidebars = array_merge( $this->sidebars, array(
                        $name
                    ) );
                }
                update_option( $this->args['option_name'], $this->sidebars );
                wp_redirect( admin_url( 'widgets.php' ) );
                die();
            }
        }
        
        /**
         * Before we create a new sidebar, verify it doesn't already exist. If it does, append a number to the name.
         *
         * @since     1.0.0
         *
         * @param    string    Name of the sidebar to be deleted.
         *
         * @return    string     'sidebar-deleted' if successful.
         *
         */
        function delete_sidebar_area() {
            check_ajax_referer( 'redux/sidebars/' . $this->args['option_name'] . '/delete' );
            if ( !empty( $_POST['name'] ) ) {
                $name           = stripslashes( $_POST['name'] );
                $this->sidebars = get_option( $this->args['option_name'] );
                if ( ( $key = array_search( $name, $this->sidebars ) ) !== false ) {
                    unset( $this->sidebars[$key] );
                    update_option( $this->args['option_name'], $this->sidebars );
                }
                echo "deleted";
                die();
            }
            die(-1);
        }
        
        /**
         * Before we create a new sidebar, verify it doesn't already exist. If it does, append a number to the name.
         *
         * @since     1.0.0
         *
         * @param    string    $name    Name of the sidebar to be created.
         *
         * @return    name     $name           Name of the new sidebar just created.
         *
         */
        function check_sidebar_name($name) {
            if ( empty( $GLOBALS['wp_registered_sidebars'] ) ) {
                return $name;
            }
            
            $taken = array();
            foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
                $taken[] = $sidebar['name'];
            }
            
            if ( empty( $this->sidebars ) ) {
                $this->sidebars = array();
            }
            
            $taken = array_merge( $taken, $this->sidebars );
            
            if ( in_array( $name, $taken ) ) {
                $counter  = substr($name, -1);
                $new_name = "";
                
                if ( !is_numeric( $counter ) ) {
                    $new_name = $name . " 1";
                } else {
                    $new_name = substr( $name, 0, -1 ) . ( (int) $counter + 1);
                }
                
                $name = $this->check_sidebar_name( $new_name );
            }
            
            return $name;
        }
        
        /**
         * Register and display the custom sidebar areas we have set.
         *
         * @since     1.0.0
         *
         */
        function register_custom_sidebars() {
            if ( empty( $this->sidebars ) )
                $this->sidebars = get_option( $this->args['option_name'] );
            
            $options = array(
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>',
                'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
                'after_widget' => '</div>'
            );
            
            $options = apply_filters( 'simple_custom_widget_args', $options );
            
            if ( is_array( $this->sidebars ) ) {
                foreach ( $this->sidebars as $sidebar ) {
                    if ( !in_array( $sidebar, $this->default_sidebars ) ) {
                        $options['class'] = 'redux-custom';
                    } else {
                        $options['class'] = 'redux-default';
                    }
                    $options['name'] = $sidebar;
                    register_sidebar( $options );
                }
            }
        }
        
        /**
         * Enqueue the necessary CSS and JS files
         *
         * @since     1.0.0
         *
         */
        public function enqueue() {
            wp_enqueue_style( 'redux-sidebars-css', Redux_Framework::$url . '/assets/sidebars/css/style.css', array(), self::$version);
            wp_enqueue_script( 'redux-sidebars-js', Redux_Framework::$url . '/assets/sidebars/js/script.js', array(
                'jquery'
            ), self::$version );
            $array = array(
                'some_string' => __('Some string to translate'),
                'a_value' => '10'
            );
            wp_localize_script( 'redux-sidebars-js', 'redux_sidebars', array(
                'args' => $this->args,
                'sidebars' => $this->sidebars
            ) );
        }
        
    }
}