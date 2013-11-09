<?php

/**
 * @package Redux Framework
 * @version 4.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'Redux_Field_Template_Dev' ) ) {
    class Redux_Field_Template_Dev extends Redux_Field_Template{
        
        public static $version = '1.0.0';
        
        public static $_properties = array();
        
        public function render( $name, $value ){
            echo '<input type="hidden" name="'.$name.'" value=""/>';
            $backtrace = debug_backtrace();
            foreach( $backtrace as $trace ){
                if( $trace['class'] == 'Redux_Options' ){
                    $object = $trace['object'];
                    break;
                }
            }
            
            echo '<pre id="'.$this->field['id'].'">'.print_r($object, true).'</pre>';
        }
        
    }
}