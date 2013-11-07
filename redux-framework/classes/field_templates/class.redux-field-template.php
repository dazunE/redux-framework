<?php

/**
 * @package Redux Framework
 * @version 4.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'Redux_Field_Template' ) ) {
    abstract class Redux_Field_Template{
        
        public static $version = '1.0.0';
        
        public static $_properties = array(
        );
        
        public $field;
        
        public function __construct( $field ){
            $field = Redux_Framework::parse_args( $field, static::$_properties );
            $this->field = $field;
        }
        
        public function get_default_value(){
            return $this->field['default'];   
        }
        
        public function sanitize_value( $value ){
            return $value;   
        }
        
        public function render( $name, $value ){
            //print_r($this->field);
            echo '<input type="text" id="' . $this->field['id'] . '" name="' . $name . '" value="' . $value . '" />';
        }
        
        public function description(){
            echo '<span class="redux-field-description description">' . $this->field['description'] . '</span>';
        }
        
    }
}