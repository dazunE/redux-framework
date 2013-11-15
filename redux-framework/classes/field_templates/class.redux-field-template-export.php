<?php

/**
 * @package Redux Framework
 * @version 4.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'Redux_Field_Template_Export' ) ) {
    class Redux_Field_Template_Export extends Redux_Field_Template{
        
        public static $version = '1.0.0';
        
        public static $_properties = array(
            'supports_multi' => false,
        );
        
        public function __construct( $field ){
            
            parent::__construct( $field );
            
            add_action( 'admin_init', array( &$this, 'export_options' ) );
        }
        
        public function render( $name, $value ){
            echo '<input type="hidden" name="'.$name.'" value=""/>';
            $opt_name = explode('[', $name);
            $opt_name = $opt_name[0];
            
            echo '<a href="' . wp_nonce_url( add_query_arg( array( 'redux-action' => 'redux-options-export', 'option_name' => $opt_name ) ), 'redux-options-export-' . $opt_name ) . '" class="button-primary" title="' . __( 'Export', 'redux-framework' ) . '">' . __( 'Export', 'redux-framework' ) . '</a>';
            
        }
        
        public function export_options(){
            
            if(
                isset( $_GET['redux-action'] ) && 
                $_GET['redux-action'] == 'redux-options-export' && 
                isset($_GET['option_name']) && 
                isset($_GET['_wpnonce']) && 
                wp_verify_nonce( $_GET['_wpnonce'], 'redux-options-export-' . $_GET['option_name'] )
            ){
                $options = json_encode( get_option( $_GET['option_name'] ) );
                $filename = 'export-' . $_GET['option_name'] . '-' . date('d-m-Y H:i:s') . '.txt';
                
                header( 'Content-disposition: attachment; filename=' . $filename );
                header( 'Content-type: text/plain' );
                
                exit($options);
            }
        }
        
    }
}