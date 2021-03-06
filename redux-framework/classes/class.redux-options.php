<?php

/**
 * @package Redux Framework
 * @version 4.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'Redux_Options' ) ) {
    class Redux_Options{
        
        public static $version = '1.0.0';
        
        private $args;
        
        private $sections;
        
        private $values;
        
        public static $_section_properties = array(
            'type'          => '',
            'icon'          => 'home',  
            'icon_class'    => 'icon-large',
            'title'         => '',
            'header'        => '',
            'description'   => '',
            'fields'        => array()
        );
        
        public function __construct( $args = array(), $sections = array() ){
            
            $defaults = array(
                'option_name' => 'redux',
                'menu_icon' => '',
                'menu_title' => __( 'Options', 'redux-framework' ),
                'menu_position' => null,
                'menu_show_sections' => false,
                'page_title' => __( 'Options', 'redux-framework' ),
                'page_slug' => 'redux',
                'page_cap' => 'manage_options',
                'page_parent' => false,
                'page_icon' => 'icon-themes',
                'dev_mode' => false,
            );
            
            $this->args = Redux_Framework::parse_args( $args, $defaults );
            
            $this->args = apply_filters( 'redux/options/' . $this->args['option_name'] . '/args' , $this->args );
            
            $this->sections = apply_filters( 'redux/options/' . $this->args['option_name'] . '/sections' , $sections );
            
            $this->setup_sections();
            
            //create redux page and add our callback to it
            $page_args = array(
                'menu_icon' => $this->args['menu_icon'],
                'menu_title' => $this->args['menu_title'],
                'menu_position' => $this->args['menu_position'],
                'page_title' => $this->args['page_title'],
                'page_slug' => $this->args['page_slug'],
                'page_cap' => $this->args['page_cap'],
                'page_parent' => $this->args['page_parent'],
                'page_icon' => $this->args['page_icon']
            );
            
            $this->page = new Redux_Page($page_args, array( &$this, 'page_html' ) );
            
            //make sure the option exists
            add_action( 'init', array( &$this, 'set_default_values' ) );
            
            add_action( 'admin_init', array( &$this, 'save_options' ) );
            
            add_action('redux/page/' . $this->args['page_slug'] . '/enqueue', array(&$this, 'enqueue') );
        
        }
        
        private function setup_sections(){
            $this->values = get_option($this->args['option_name']);
            
            $this->values = Redux_Framework::parse_args( $this->values, $this->get_values_array() );
            
            //setup field class within the sections so we we can use it anywhere!
            foreach( $this->sections as $id => $section ){
                
                $this->sections[$id] = Redux_Framework::parse_args($this->sections[$id], self::$_section_properties);
                
                foreach( (array) $section['fields'] as $index => $field ){
                    
                    $this->sections[$id]['fields'][$index] = Redux_Framework::parse_args(
                        $this->sections[$id]['fields'][$index],
                        Redux_Field::$_properties
                    );
                    $this->sections[$id]['fields'][$index]['name'] = $this->args['option_name'];
                    $this->sections[$id]['fields'][$index]['value'] = $this->values[$field['id']];
                    $this->sections[$id]['fields'][$index]['object'] = new Redux_Field($this->sections[$id]['fields'][$index]);
                }
            }
        }
        
        public function enqueue(){
            wp_enqueue_script('jquery-ui-sortable');
            
            wp_enqueue_style('redux-options', Redux_Framework::$url . 'assets/options/css/options.css', false, self::$version);
            
            wp_enqueue_script('redux-options', Redux_Framework::$url . 'assets/options/js/options.js', array('jquery', 'jquery-ui-sortable'), self::$version);
        }
        
        
        public function page_html( $errors = array(), $ajax = false ){
            
            //print_r(get_option($this->args['option_name']));
            
            
            echo ( $ajax == false ) ? '<form method="post" action="" enctype="multipart/form-data" id="redux-form" class="redux-form">' : '';
            
                print_r($errors);
            
                wp_nonce_field('redux-options-ajax-'.$this->args['option_name']);
            
                echo '<input type="hidden" name="redux-action" value="redux-options-ajax-'.$this->args['option_name'].'" />';
            
                echo '<div id="redux-back"></div>';
            
                echo '<div id="redux-columns">';
            
                    echo '<div id="redux-section-tabs"><ul>';
                        reset($this->sections);
                        $first = key($this->sections);
                        $current_tab = ( isset($_GET['tab']) ) ? $_GET['tab'] : $first;
                        foreach( $this->sections as $id => $section ){
                            $class = ($id == $current_tab) ? ' class="active"' : '';
                            echo '<li' . $class . '><a href="#redux-section-' . $id . '" class="redux-section-tab">' . $section['title'] . '</a></li>';
                        }
                    echo '</ul></div>';
            
                    echo '<div id="redux-sidebar"></div>';
                
                    echo '<div id="redux-sections">';
            
                        echo '<p class="redux-save" id="redux-save-top">';
                        submit_button('', 'primary', $this->args['option_name'].'[redux-submit]', false);
                        submit_button(__('Reset to Defaults', 'redux-framework'), 'secondary', $this->args['option_name'].'[redux-defaults]', false);
                        echo '</p>';
            
            
                        foreach( $this->sections as $id => $section ){
                            $class = ($id == $current_tab) ? ' active' : '';
                            echo '<div class="redux-section' . $class . '" id="redux-section-' . $id . '">';
                            
                            if ( $section['title'] != '' ){
                                echo '<h3>' . $section['title'] . '</h3>';
                            }
                            
                            if( $section['description'] != '' ){
                                echo $section['description'];
                            }
                            
                            if( !empty($section['fields']) ){
                                echo '<table class="form-table redux-form-table">';
                                    foreach( $section['fields'] as $index => $field ){
                                        
                                        $th = ( isset( $field['sub_title'] ) ) ? $field['title'] . '<span class="redux-row-description description">' . $field['sub_title'] . '</span>' : $field['title'];
                                        
                                        $data_string = $field['object']->get_requires_data_string();
                                        
                                        echo '<tr valign="top" id="redux-field-row-' . $field['id'] . '" class="redux-field-row" data-id="' . $field['id'] . '"' . $data_string . '>';
                                            if ( !empty($field['args']['label_for']) ){
                                                echo '<th scope="row"><label for="' . esc_attr( $field['args']['label_for'] ) . '">' . $th . '</label></th>';
                                            }else{
                                                echo '<th scope="row"><label for="' . esc_attr( $field['id'] ) . '">' . $th . '</label></th>';
                                            }
                                            echo '<td>';
                                                $field['object']->render();
                                            echo '</td>';
                                        echo '</tr>';
                                    }
                                echo '</table>';
                            }
                            echo '</div>';
                        }
                        echo '<p class="redux-save">';
                        submit_button('', 'primary', $this->args['option_name'].'[redux-submit]', false);
                        submit_button(__('Reset to Defaults', 'redux-framework'), 'secondary', $this->args['option_name'].'[redux-defaults]', false);
                        echo '</p>';
        
                    echo '</div>';
            
                echo '</div>';
            
            echo ( $ajax == false ) ? '</form>' : '';
        }
        
        public function set_default_values(){
            if( !get_option( $this->args['option_name'] ) || get_option( $this->args['option_name'] ) == '' ){
                update_option( $this->args['option_name'], $this->get_default_values() );
            }   
        }
        
        public function get_values_array(){
            $array = array();
            foreach( $this->sections as $key => $section ){
               foreach( (array) $section['fields'] as $index => $field ){
                   $array[$field['id']] = $this->get_field_values_array( $field );
               }
            }
            return $array;
        }
        
        private function get_field_values_array( $field ){
            $array = '';
            
            if( isset( $field['multi'] ) && $field['multi'] === true ){
                $array = array();
                if( isset( $field['fields'] ) ){
                    foreach( $field['fields'] as $_field ){
                        $array[0][$_field['id']] = $this->get_field_values_array( $_field );   
                    }
                }
            }else{
                if( isset( $field['fields'] ) ){
                    foreach( $field['fields'] as $_field ){
                        $array[$_field['id']] = $this->get_field_values_array( $_field );   
                    }
                }
            }
            
            return $array;
        }
        
        public function get_default_values(){
            
            $values = array();
            
            foreach( $this->sections as $id => $section ){
                foreach( (array) $section['fields'] as $index => $field ){
                    $values[$field['id']] = $field['object']->get_default_value();   
                }
            }
            
            $values = Redux_Framework::parse_args( $values, $this->get_values_array() );
            
            return $values;
        }
        
        private function validate_options( $old_options ){
            
            if( !empty( $old_options['redux-defaults'] ) ){
                $new_options = $this->get_default_values();
            }else{
                
                $new_options = $this->remove_clones( $old_options );
                
                $errors = array();
                
                foreach( $this->sections as $id => $section ){
                    if( $section['type'] == 'divide' ) { continue; }
                    if( !empty( $section['fields'] ) ){
                        foreach( $section['fields'] as $index => $field ){
                            if( isset( $new_options[$field['id']] ) ){
                                $new_options[$field['id']] = $field['object']->sanitize_value( $new_options[$field['id']] );
                                $error = $field['object']->validate_value( $new_options[$field['id']] );
                                if($error != ''){
                                    $errors[$id][$field['id']] = $error;
                                }
                            }else{
                                $new_options[$field['id']] = '';
                            }
                        }
                    }
                }
                
            }
            
            $new_options = apply_filters('redux/options/' . $this->args['option_name'] . '/save', $new_options );
            
            $new_options['redux-updated'] = time();
            
            unset( $new_options['redux-submit'] );
            
            $new_options['errors'] = $errors;
            
            return $new_options;
        }
        
        public function save_options(){
            if( isset( $_POST['redux-action'] ) && $_POST['redux-action'] == 'redux-options-ajax-'.$this->args['option_name'] ){
                 if( isset($_POST['_wpnonce']) && wp_verify_nonce( $_POST['_wpnonce'], 'redux-options-ajax-'.$this->args['option_name'] ) && isset( $_POST[$this->args['option_name']] ) ){
                     $options = $this->validate_options( $_POST[$this->args['option_name']] );
                     $errors = array();
                     if( isset( $options['errors'] ) ){
                         $errors = $options['errors'];
                         unset( $options['errors'] );
                     }
                     update_option( $this->args['option_name'], $options );
                     $this->setup_sections();
                     ob_start("ob_gzhandler");
                     $this->page_html( $errors, true );
                     exit();
                 }
            }
        }
        
        private function remove_clones( $old_options = array() ){
            $new_options = array();
            foreach( $old_options as $key => $value ){
                if( strpos( $key, 'index##' ) === false ){
                    if( is_array( $value ) ){
                        $new_options[$key] = $this->remove_clones( $value );
                    }else{
                        $new_options[$key] = $value;   
                    }
                }
            }
            return $new_options;
        }
        
    }
}