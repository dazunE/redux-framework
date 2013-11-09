<?php

/**
 * @package Redux Framework
 * @version 4.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'Redux_Field_Template_Text' ) ) {
    class Redux_Field_Template_Text extends Redux_Field_Template{
        
        public static $version = '1.0.0';
        
        public static $_properties = array(
            'args' => array(
                'classes' => array('regular-text'),
                'placeholder' => '',
            ),
        );
        
        public function render( $name, $value ){
            //print_r($this->field);
            echo '<input type="text" id="' . $this->field['id'] . '" class="' . implode(' ', $this->field['args']['classes'] ). '" name="' . $name . '" value="' . $value . '" placeholder="' . $this->field['args']['placeholder'] . '" />';
            if($this->field['multi'] == true ){
                echo '<a href="javascript:void(0);" class="redux-multi-remove">'.$this->field['args']['multi_remove_text'].'</a>';
            }
            echo '<br/>';
        }
        
    }
}