<?php

/**
 * @package Redux Framework
 * @version 4.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'Redux_Validation' ) ) {
    class Redux_Validation{
        
        public static function email( $value, $args = array() ){
            $args = Redux_Framework::parse_args($args, array( 'message' => __( 'Not a valid email!', 'redux-framework' ) ) );
            if($value != '' && !is_email($value)){
                throw new Redux_Validation_Exception($args['message']);   
            }
        }
        
        public static function number( $value, $args = array() ){
            $args = Redux_Framework::parse_args($args, array( 'message' => __( 'Not a valid number!', 'redux-framework' ) ) );
            if($value != '' && !is_numeric($value)){
                throw new Redux_Validation_Exception($args['message']);   
            }
        }
        
        public static function required( $value, $args = array() ){
            $args = Redux_Framework::parse_args($args, array( 'message' => __( 'This field is required!', 'redux-framework' ) ) );
            if( $value == '' ){
                throw new Redux_Validation_Exception($args['message']);
            }
        }

    }
}