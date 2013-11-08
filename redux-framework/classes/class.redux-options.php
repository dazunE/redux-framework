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
            
            $this->values = get_option($this->args['option_name']);
            
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
            
            // Register settings
            add_action( 'admin_init', array( &$this, 'register_settings' ) );
            
            add_action('redux/page/' . $this->args['page_slug'] . '/enqueue', array(&$this, 'enqueue') );
        
        }
        
        public function enqueue(){
            wp_enqueue_script('jquery-ui-sortable');   
        }
        
        
        public function page_html(){
            
            print_r(get_option($this->args['option_name']));
            
            echo '<form method="post" action="options.php" enctype="multipart/form-data" id="redux-form" class="redux-form">';
                
                settings_fields($this->args['option_name'].'_group');
            
                foreach( $this->sections as $id => $section ){
                    //do_settings_sections( $this->args['option_name'] . '_' . $id . '_section_group' );
                    
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

                }
            
                submit_button('', 'primary', $this->args['option_name'].'[redux-submit]', false);
                submit_button(__('Reset to Defaults', 'redux-framework'), 'secondary', $this->args['option_name'].'[redux-defaults]', false);
        
            echo '</form>';
            
            ?>

            <style type="text/css">
                .redux-multi-instance-clone{
                    display: none;
                }
                .redux-sortable-drop{
                    background: #e9e9e9;
                    border: 4px dashed #ccc;
                }
                .redux-group-title{
                    padding: 10px;
                    background: #ccc;
                    margin-bottom: 0px;
                }
                .redux-group-fields{
                    padding: 20px;
                    border: 1px solid #ccc;
                    display: none;
                    clear: both;
                }
                .redux-multi-field-clone{
                    margin-top: 20px;
                }
                .redux-field-width-full{
                    width: 100%;
                    clear: both;
                }
                .redux-field-width-half{
                    float: left;
                    width: 49.9%;
                }
                .redux-field-width-third{
                    float: left;
                    width: 33.3%;
                }
                .redux-field-width-quarter{
                    float: left;
                    width: 24.9%;
                }
                
                .clearfix{  
                    clear:both;  
                }
            </style>

            <script>
                jQuery.fn.outerHTML = function(){
             
                    // IE, Chrome & Safari will comply with the non-standard outerHTML, all others (FF) will have a fall-back for cloning
                    return (!this.length) ? this : (this[0].outerHTML || (
                      function(el){
                          var div = document.createElement('div');
                          div.appendChild(el.cloneNode(true));
                          var contents = div.innerHTML;
                          div = null;
                          return contents;
                    })(this[0]));
 
                }
                
                jQuery.fn.reduxReIndexFields = function(){
                    var parent = jQuery(this);
                    var pattern = parent.attr('data-sortable-pattern');
                    jQuery(' > .redux-multi-instance', parent).each(function(index, element){

                        var id = jQuery(element).attr('id').split(/[-]+/);
                        
                        //get the old values
                        var old_id = jQuery(element).attr('id');
                        var old_index = id.pop();
                        var old_name = pattern.replace('##sortable-index##', old_index);
                        var old_html = jQuery(element).outerHTML();
                        
                        //construct new values
                        //id = id.slice(0, -1);
                        id[id.length] = index;
                        new_id = id.join('-');
                        var new_name = pattern.replace('##sortable-index##', index);
                        
                        //replace values
                        var new_html = old_html;
                        //escape old id for regex
                        old_name = old_name.replace(/(\[|\])/g,'\\$1');
                        var re = new RegExp(old_name,"g");
                        var re2 = new RegExp(old_id,"g");
                        new_html = new_html.replace(re, new_name).replace(re2, new_id);
                        
                        jQuery(element).replaceWith(new_html);
                        
                    });  
                }
                
                jQuery.fn.reduxRemoveFields = function(){
                    var tobeindexed = jQuery(this).closest('.redux-multi-field');
                    var min = jQuery(tobeindexed).attr('data-multi-min');
                    var items = jQuery(' > .redux-multi-instance', tobeindexed).length - 1;
                    if(items >= min){
                        var instance = jQuery(this).closest('.redux-multi-instance');
                        jQuery(instance).fadeOut('slow', function(){
                            jQuery(this).remove();
                            jQuery(tobeindexed).reduxReIndexFields();
                        });
                    }else{
                        //need to localize this
                        alert('minimun needed: min:' + min + ' items:'+items);   
                    }
                }
                
                jQuery.fn.reduxCloneFields = function(){
                    var instance = jQuery(this).closest('.redux-multi-field');
                    var max = jQuery(instance).attr('data-multi-max');
                    
                    if(max != 0){
                        var items = jQuery(' > .redux-multi-instance', instance).length;
                        if( items == max ){
                            //need to localize
                            alert('too many!');
                            return;
                        }
                    }
                    
                    
                    var clone = jQuery(' > .redux-multi-instance-clone', instance);
                    var pattern = jQuery(this).attr('data-index-pattern');
                    
                    // get unique index
                    var indexes = [];
                    jQuery(' > .redux-multi-instance', instance).each(function(index, element){                            
                        name = jQuery(element).attr('id').split(/[-]+/).pop();
                        
                        indexes[parseInt(name)] = parseInt(name);
                    });
                    
                    var index = 0;
                    while( jQuery.inArray( index, indexes) > -1 ){
                        index++;   
                    }
                    //get unique index
                    
                    //var index = jQuery(' > .redux-multi-instance', instance).length;
                    //this would work with our reindexing, but use above to be sure
                    
                    
                    var template = jQuery(clone).outerHTML();
                    var re = new RegExp(pattern,"g");
                    template = template.replace(re, index);
                    jQuery(template).insertBefore( clone ).addClass('redux-multi-instance').removeClass('redux-multi-instance-clone');
                }
                
                
                jQuery.fn.reduxRequires = function( usefade ){
                    var fieldtocheck = jQuery(this).attr('data-redux-check-field');
                    var operator = jQuery(this).attr('data-redux-check-comparison');
                    var value1 = jQuery(this).attr('data-redux-check-value');
                    
                    var value2 = jQuery('#' + fieldtocheck).val();
                    
                    var show = false;
                    
                    if(value2){
                    
                        switch(operator){
                            case '=':
                            case 'equals':
                                    //if value was array
                                    if (value2.toString().indexOf('|') !== -1){
                                            var value2_array = value2.split('|');
                                            if($.inArray( value1, value2_array ) != -1){
                                                    show = true;
                                            }
                                    }else{
                                        if(value1 == value2) 
                                                show = true;
                                    }
                                break;
                            case '!=':    
                            case 'not':
                                    //if value was array
                                    if (value2.indexOf('|') !== -1){
                                            var value2_array = value2.split('|');
                                            if($.inArray( value1, value2_array ) == -1){
                                                    show = true;
                                            }
                                    }else{
                                        if(value1 != value2) 
                                                show = true;
                                    }
                                break;
                            case '>':    
                            case 'greater':    
                            case 'is_larger':
                                if(parseFloat(value1) >  parseFloat(value2)) 
                                        show = true;
                                break;
                            case '<':
                            case 'less':    
                            case 'is_smaller':
                                if(parseFloat(value1) < parseFloat(value2)) 
                                        show = true;
                                break;
                            case 'contains':
                                if(value1.indexOf(value2) != -1) 
                                        show = true;
                                break;
                            case 'doesnt_contain':
                                if(value1.indexOf(value2) == -1) 
                                        show = true;
                                break;
                            case 'is_empty_or':
                                if(value1 == "" || value1 == value2) 
                                        show = true;
                                break;
                            case 'not_empty_and':
                                if(value1 != "" && value1 != value2) 
                                        show = true;
                                break;
                        }
                        
                    }
                    
                    if(show == false){
                        if(usefade == true){
                            jQuery(this).fadeOut('slow');
                        }else{
                            jQuery(this).hide();   
                        }
                    }else{
                        if(usefade == true){
                            jQuery(this).fadeIn('slow');
                        }else{
                            jQuery(this).show();   
                        }
                    }
                    
                }
                
                
                jQuery(document).ready(function(){
                    
                    //requires
                    jQuery('[data-redux-check-field]').each(function(index, element){
                        jQuery(this).reduxRequires(false);
                    });
                    
                    jQuery('.redux-form').on('change', 'input, select, radio, checkbox, textarea', function(e){
                        jQuery('[data-redux-check-field="'+this.id+'"]').each(function(index, element){
                            jQuery(this).reduxRequires(true);
                        });
                    });
                    
                    
                    jQuery('.redux-field-group').on('change', 'input, select, radio, checkbox, textarea', function(){
                        //var group = jQuery(this).closest('.redux-multi-instance.redux-field-group');
                        //if(typeof group === 'undefined'){
                            var group = jQuery(this).closest('.redux-field-group');   
                        //}
                        var group_title = jQuery(' > .redux-group-title', group);
                        var val = jQuery(this).val();
                        jQuery(' > #redux-group-title-' + this.id, group_title).text(val);
                        //alert(group_title.text());
                    });
                    
                    
                    
                    //sortable
                    jQuery( ".redux-multi-field.redux-multi-field-sortable" ).sortable({
                        update: function(event, ui){
                            jQuery(ui.item).closest('.redux-multi-field').reduxReIndexFields();
                        },
                        placeholder: "redux-sortable-drop",
                        forcePlaceholderSize: true
                    });
                    
                    //multi remove
                    jQuery('.redux-form').on('click', '.redux-multi-remove', function(){
                        jQuery(this).reduxRemoveFields();
                    });
                    
                    //multi add
                    jQuery('.redux-form').on('click', '.redux-multi-field-clone', function(){
                        jQuery(this).reduxCloneFields();
                    });
                    
                    //slide groups
                    jQuery('.redux-form').on('click', '.redux-group-title', function(){
                        jQuery(this).next('.redux-group-fields').slideToggle('slow');   
                    });
                    
                });
            </script>

            <?php
        }
        
        public function set_default_values(){
            if( !get_option( $this->args['option_name'] ) || get_option( $this->args['option_name'] ) == '' ){
                update_option( $this->args['option_name'], $this->get_default_values() );
            }   
        }
        
        public function get_default_values(){
            
            $values = array();
            
            foreach( $this->sections as $id => $section ){
                foreach( (array) $section['fields'] as $index => $field ){
                    $values[$field['id']] = $field['object']->get_default_value();   
                }
            }
            
            return $values;
        }
        
        public function register_settings(){
            
            register_setting( $this->args['option_name'] . '_group', $this->args['option_name'], array( &$this, 'validate_options' ) );
            
        }
        
        public function validate_options( $old_options ){
            
            if( !empty( $old_options['redux-defaults'] ) ){
                $old_options = array();
                $old_options = $this->get_default_values();
            }else{
                
                $old_options = $this->remove_clones( $old_options );
                
                foreach( $this->sections as $id => $section ){
                    if( $section['type'] == 'divide' ) { continue; }
                    foreach( (array) $section['fields'] as $index => $field ){
                        if( isset( $old_options[$index] ) ){
                            $old_options[$index] = $field['object']->sanitize_value( $old_options[$index] );
                        }else{
                            $old_options[$index] = '';
                        }
                    }
                }
                
                
                unset($old_options['redux-submit']);
            }
            
            $old_options['redux-updated'] = time();
            
            return $old_options;
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