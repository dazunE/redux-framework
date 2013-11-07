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
                'class' => 'regular-text',
            ),
        );
        
    }
}