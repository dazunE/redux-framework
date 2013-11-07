<?php

/**
 * @package Redux Framework
 * @version 4.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'Redux_Page' ) ) {
    class Redux_Page{
        
        public static $version = '1.0.0';
        
        private $args;
        
        private $callback;
        
        private $page;
        
        public function __construct( $args, $callback = '__return_false' ){
            
            $defaults = array(
                'menu_icon' => '',
                'menu_title' => __( 'Options', 'redux-framework' ),
                'menu_position' => null,
                'page_title' => __( 'Options', 'redux-framework' ),
                'page_slug' => 'redux',
                'page_cap' => 'manage_options',
                'page_parent' => false,
                'page_icon' => 'icon-themes'
            );
            
            $this->args = Redux_Framework::parse_args( $args, $defaults );
            
            $this->args = apply_filters( 'redux/page/' . $this->args['page_slug'] . '/args' , $this->args );
            
            $this->callback = $callback;
            
            // Register page
            add_action( 'admin_menu', array( &$this, 'page_setup' ) );
        
        }
        
        
        public function page_setup(){
               
            if( false !== $this->args['page_parent'] ) {
                $this->page = add_submenu_page(
                    $this->args['page_parent'],
                    $this->args['page_title'],
                    $this->args['menu_title'],
                    $this->args['page_cap'],
                    $this->args['page_slug'],
                    array( &$this, 'page_html' )
                );
            } else {
                $this->page = add_menu_page(
                    $this->args['page_title'],
                    $this->args['menu_title'],
                    $this->args['page_cap'],
                    $this->args['page_slug'],
                    array( &$this, 'page_html' ),
                    $this->args['menu_icon'],
                    $this->args['menu_position']
                );
            }
            
            add_action( 'admin_print_styles-' . $this->page, array( &$this, 'enqueue' ) );
            
            add_action( 'load-' . $this->page, array( &$this, 'load_page' ) );
            
        }
        
        public function page_html(){
            if ( !current_user_can( 'manage_options' ) )  {
                wp_die( __( 'You do not have sufficient permissions to access this page.', 'redux-framework' ) );
                return;
            }
            echo '<div class="wrap">';
                echo '<div id="'.$this->args['page_icon'].'" class="icon32"><br/></div>';
                echo '<h2>'.get_admin_page_title().'</h2>';
                call_user_func( $this->callback );
            echo '</div>';
        }
        
        public function enqueue(){
            do_action('redux/page/' . $this->args['page_slug'] . '/enqueue' );
        }
        
        public function load_page(){
            do_action('redux/page/' . $this->args['page_slug'] . '/load' );
        }
        
    }
}