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
        
        public function render( $name, $value ){
            echo '<input type="hidden" name="'.$name.'" value=""/>';
            $opt_name = explode('[', $name);
            $opt_name = $opt_name[0];
            $options = json_encode(get_option($opt_name));
            echo '<textarea id="' . $this->field['id'] . '" class="large-text" cols="60" rows="8">'.$options.'</textarea><br/>';
        }
        
    }
}