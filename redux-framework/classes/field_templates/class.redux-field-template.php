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
            'supports_multi' => true,
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
            
            
            if( isset( $this->field['multi'] ) && $this->field['multi'] === true ){
                $value = array_values( array_filter( $value ) );
                foreach( $value as $key => $val ){
                    foreach( $this->field['sanitize'] as $function ){
                        if(function_exists($function)){
                            $value[$key] = call_user_func( $function, $val );
                        }
                    }   
                }
            }else{
                foreach( $this->field['sanitize'] as $function ){
                    if(function_exists($function)){
                        $value = call_user_func( $function, $value );
                    }
                } 
            }

            return $value;   
        }
        
        public function validate_value( $value = '' ){
            
            try{
                if( isset( $this->field['multi'] ) && $this->field['multi'] === true ){
                    foreach( $value as $key => $val ){
                        foreach( $this->field['validate'] as $function => $args ){
                            if( strpos( $function, '::') !== false ){
                                    $func = explode('::', $function);
                            }
                            
                            if(function_exists($function) || method_exists( $func[0], $func[1] ) ){
                                call_user_func( $function, $val, $args );
                            }
                        }   
                    }
                }else{
                    foreach( $this->field['validate'] as $function => $args ){
                        if( strpos( $function, '::') !== false ){
                                $func = explode('::', $function);
                        }
                        
                        if(function_exists($function) || method_exists( $func[0], $func[1] ) ){
                            call_user_func( $function, $value, $args );
                        }
                    } 
                }
            }catch( Redux_Validation_Exception $e ){
               return $e->getMessage(); 
            }
            
        }
        
        public function render( $name, $value ){
            //print_r($this->field);
            echo '<input type="text" id="' . $this->field['id'] . '" name="' . $name . '" value="' . $value . '" />';
            if($this->field['multi'] == true ){
                echo '<a href="javascript:void(0);" class="redux-multi-remove">'.$this->field['args']['multi_remove_text'].'</a>';
            }
        }
        
        public function description(){
            echo '<span class="redux-field-description description">' . $this->field['description'] . '</span>';
        }
        
    }
}