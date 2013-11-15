<?php

/**
 * @package Redux Framework
 * @version 4.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'Redux_Field' ) ) {
    class Redux_Field{
        
        public static $version = '1.0.0';
        
        public static $_properties = array(
            'id' => '',
            'type' => 'text',
            'multi' => false,
            'supports_multi' => true,
            'sortable' => true,
            'title' => '',
            'sub_title' => '',
            'description' => '',
            'default' => '',
            'sanitize' => array(),
            'validate' => array(),
            'args' => array(
                'multi_add_text' => '',
                'multi_add_class' => 'primary',
                'label_for' => '',
                'multi_show_empty' => false,
                'multi_min' => 0,
                'multi_max' => 0,
                'width' => 'full',
            ),
            'dev_mode' => false,
            
            'name' => '',
            'value' => ''
        );
        
        public $field;
        
        public function __construct( $field ){
            
            $class = 'Redux_Field_Template_' . ucfirst( $field['type'] );
            
            //set some text vars of $_properties
            self::$_properties['args']['multi_remove_text'] = __( 'Remove', 'redux-framework' );
            self::$_properties['args']['multi_add_text'] = __( 'Add Field', 'redux-framework');
            
            //import defaults from field template
            self::$_properties = Redux_Framework::parse_args( $class::$_properties, self::$_properties );
            
            
            $field = Redux_Framework::parse_args( $field, self::$_properties );
            $field['name'] = $field['name'] . '[' . $field['id'] . ']';
            $this->field = $field;
            $this->template = new $class( $this->field );
            
        }
        
        public function get_default_value(){
            return $this->template->get_default_value();   
        }
        
        public function sanitize_value( $value ){
            return $this->template->sanitize_value( $value );  
        }
        
        public function validate_value( $value ){
            return $this->template->validate_value( $value );  
        }
        
        
        
        public function get_requires_data_string(){
            if (!empty($this->field['requires'])) {
                $data = array();
                $data['redux-check-field'] = $this->field['requires'][0];
                $data['redux-check-comparison'] = $this->field['requires'][1];
                $data['redux-check-value'] = $this->field['requires'][2];
                return ' '. Redux_Framework::create_data_string($data);
            }
            return '';
        }
        
        public function render(){
            if( $this->field['multi'] === true && $this->field['supports_multi'] === true ){
                
                $sortable = ( $this->field['sortable'] === true ) ? ' redux-multi-field-sortable' : '';
                
                echo '<div class="redux-field redux-field-' . $this->field['type'] . '" id="redux-field-' . $this->field['id'] . '">';
                    echo '<div class="redux-multi-field'. $sortable . '" id="redux-multi-field-' . $this->field['id'] . '" data-field-id="' . $this->field['id'] . '" data-name="' . $this->field['name'] . '" data-sortable-pattern="' . $this->field['name'] . '[##sortable-index##]' . '" data-multi-min="' . $this->field['args']['multi_min']. '" data-multi-max="' . $this->field['args']['multi_max']. '">';
                
                
                        foreach( (array) $this->field['value'] as $index => $value ){
                            echo '<div class="redux-multi-instance redux-field-' . $this->field['type'] . '" id="redux-field-' . $this->field['id'] . '-index-' . $index . '" data-name="' . $this->field['name'] . '[' . $index . ']">';
                                echo '<a href="javascript:void(0);" class="redux-sortable-handle">#</a>';
                                $this->template->render( $this->field['name'] . '[' . $index . ']', $this->field['value'][$index] );
                            echo '</div>';
                        }
                
                        if( $this->field['args']['multi_show_empty'] == true ){
                
                            $count = ( count( $this->field['value'] ) == 0 ) ? 0 : count( $this->field['value'] );
                    
                            echo '<div class="redux-multi-instance redux-field-' . $this->field['type'] . '" id="redux-field-' . $this->field['id'] . '-index-' . $count . '" data-name="' . $this->field['name'] . '[' . count( $this->field['value'] ) . ']">';
                            echo '<a href="javascript:void(0);" class="redux-sortable-handle">#</a>';
                                $this->template->render( $this->field['name'] . '[' . $count . ']', '' );
                            echo '</div>';
                            
                        }
                
                        echo '<div class="redux-multi-instance-clone redux-field-' . $this->field['type'] . '" id="redux-field-' . $this->field['id'] . '-index-##' . $this->field['id'] . '-index##" data-name="' . $this->field['name'] . '[##' . $this->field['id'] . '-index##]">';
                        echo '<a href="javascript:void(0);" class="redux-sortable-handle">#</a>';
                            $this->template->render( $this->field['name'] . '[##' . $this->field['id'] . '-index##]', '' );
                        echo '</div>';
                        echo '<a href="javascript:void(0);" class="redux-multi-field-clone button-' . $this->field['args']['multi_add_class'] . '" title="' . $this->field['args']['multi_add_text'] . '" data-index-pattern="##' . $this->field['id'] . '-index##">' . $this->field['args']['multi_add_text'] . '</a>';
                    echo '</div>';
                    $this->description();
                    echo '<div class="clearfix"></div>';
                echo '</div>';
            }else{
                echo '<div class="redux-field redux-field-' . $this->field['type'] . '" id="redux-field-' . $this->field['id'] . '">';
                    $this->template->render( $this->field['name'], $this->field['value'] );
                    $this->description();
                    echo '<div class="clearfix"></div>';
                echo '</div>';
            }
            
            if( $this->field['dev_mode'] === true ){
                echo '<pre>' . print_r( $this->field, true ) . '</pre>';   
            }
        }

        
        public function description(){
            $this->template->description();
        }
        
    }
}