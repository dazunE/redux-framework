<?php
/*
Plugin Name: Redux Framework V4 - plugin
Plugin URI: #
Description: #
Author: Redux Dev Team
Version: 4.0.0
Author URI: #
*/

/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @author      Daniel J Griffiths (Ghost1227)
 * @author      Dovy Paukstys (dovy)
 * @author      Lee Mason (leemason)
 * @version     4.0.0
 */


/**
 * @package Redux Framework
 * @version 4.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

require( dirname( __FILE__ ) . '/redux-framework/redux-framework.php' );

//print_r(Redux_Framework::get_instance());

$options_args = array(
    'option_name'           => 'redux',
    'menu_icon'             => 'path/to/img.jpg',
    'menu_title'            => __( 'Options', 'redux-framework' ),
    'menu_position'         => null,
    'menu_show_sections'    => false,
    'page_title'            => __( 'Options', 'redux-framework' ),
    'page_slug'             => 'redux_demo',
    'page_cap'              => 'manage_options',
    'page_parent'           => 'themes.php',
    'page_icon'             => 'icon-themes',
    'dev_mode'              => true,
);

$sections = array();

$sections['test'] = array(
    'icon'                  => 'cog',  
    'icon_class'            => 'icon-large',
    'title'                 => __( 'Test', 'redux-framework' ),
    'header'                => __( 'Section heading', 'redux-framework' ),
    'description'           => __( 'Section Description', 'redux-framework' ),
    'fields'                => array()
);

$sections['general'] = array(
    'icon'                  => 'home',  
    'icon_class'            => 'icon-large',
    'title'                 => __( 'General Settings', 'redux-framework' ),
    'header'                => __( 'Section heading', 'redux-framework' ),
    'description'           => __( 'Section Description', 'redux-framework' ),
    'fields'                => array(
        array(
            'id'            => 'field1',
            'type'          => 'text',
            'title'         => __( 'Field 1', 'redux-framework' ),
            'sub_title'     => __( 'Sub Title', 'redux-framework' ),
            'description'   => __( 'Description', 'redux-framework' ),
            'args' => array(
                'classes' => array('large-text'),  
            ),
        ),
        
        array(
            'id'            => 'field2',
            'type'          => 'text',
            'requires' => array('field1', '=', 'twenty'),
            'title'         => __( 'Field 2', 'redux-framework' ),
            'sub_title'     => __( 'Sub Title', 'redux-framework' ),
            'description'   => __( 'Description', 'redux-framework' ),
        ),
        
        
        
        
        
        array(
            'id'            => 'text',
            'type'          => 'text',
            'multi' => true,
            //'sortable' => false,
            //'requires' => array('something', '=', '2'),
            'title'         => __( 'Text Field - repeatable', 'redux-framework' ),
            'sub_title'     => __( 'Sub Title', 'redux-framework' ),
            'description'   => __( 'Description', 'redux-framework' ),
            'default'       => array(
                0 => 'a string',
                1 => 'new string'
            ),
            'sanitize'      => array(
                'sanitize_email',
                'sanitize_something',
            ),
            //'sanitize'    => 'santize_email|sanitize_something',
            'validate'      => array(
                'is_email',
                'is_something',
            ),
            //'validate'    => 'is_email|is_something',
            'args'          => array(
                'class'         => 'regular-text',
                'placeholder'   => 'a placeholder',
                'multi_min' => 2,
                'multi_max' => 4,
            ),
            'dev_mode' => true
        ),
        
        array(
            'id'            => 'group',
            'type'          => 'group',
            'multi' => false,
            'title'         => __( 'Group Field - not repeatable', 'redux-framework' ),
            'sub_title'     => __( 'Sub Title', 'redux-framework' ),
            'description'   => __( 'Description', 'redux-framework' ),
            'args'          => array(
                'group_title'   => __( 'The Group Title field: [text2], [text3] and nothing here: [text4]', 'redux-framework' ),
                'group_description'   => __( 'The Group Description', 'redux-framework' ),
            ),
            'fields'        => array(
                array(
                    'id'            => 'text2',
                    'type'          => 'text',
                    'title'         => __( 'Text Field', 'redux-framework' ),
                    'sub_title'     => __( 'Sub Title', 'redux-framework' ),
                    'description'   => __( 'Description', 'redux-framework' ),
                    'default'       => 'group field 1',
                    //'requires' => array('somethingelse', '=', '4'),
                    'sanitize'      => array(
                        'sanitize_email',
                        'sanitize_something',
                    ),
                    //'sanitize'    => 'santize_email|sanitize_something',
                    'validate'      => array(
                        'is_email',
                        'is_something',
                    ),
                    //'validate'    => 'is_email|is_something',
                    'args'          => array(
                        'class'         => 'regular-text',
                        'placeholder'   => 'a placeholder',
                    ),
                ),
                array(
                    'id'            => 'text3',
                    'type'          => 'text',
                    'title'         => __( 'Text Field', 'redux-framework' ),
                    'sub_title'     => __( 'Sub Title', 'redux-framework' ),
                    'description'   => __( 'Description', 'redux-framework' ),
                    'default'       => 'group field 2',
                    'sanitize'      => array(
                        'sanitize_email',
                        'sanitize_something',
                    ),
                    //'sanitize'    => 'santize_email|sanitize_something',
                    'validate'      => array(
                        'is_email',
                        'is_something',
                    ),
                    //'validate'    => 'is_email|is_something',
                    'args'          => array(
                        'class'         => 'regular-text',
                        'placeholder'   => 'a placeholder',
                    ),
                ),
            )
        ),
        
        
        array(
            'id'            => 'nestedgroup',
            'type'          => 'group',
            'multi' => false,
            'title'         => __( 'Top Level Group Field - with nested group', 'redux-framework' ),
            'sub_title'     => __( 'Sub Title', 'redux-framework' ),
            'description'   => __( 'Description', 'redux-framework' ),
            'args'          => array(
                'group_title'   => __( 'The Top Level Group Title', 'redux-framework' ),
                'group_description'   => __( 'The Group Description', 'redux-framework' ),
            ),
            'fields'        => array(
                array(
                    'id'            => 'nestedgroup1',
                    'type'          => 'group',
                    'multi' => true,
                    'title'         => __( 'SubLevel Group Field - the nested group', 'redux-framework' ),
                    'sub_title'     => __( 'Sub Title', 'redux-framework' ),
                    'description'   => __( 'Description', 'redux-framework' ),
                    'args' => array(
                        'group_title' => 'my nested grpup title: [text4]',
                    ),
                    'fields'        => array(
                        array(
                            'id'            => 'text4',
                            'type'          => 'text',
                            'multi' => true,
                            'title'         => __( 'Text Field nested text field which is repeatable', 'redux-framework' ),
                            'sub_title'     => __( 'Sub Title', 'redux-framework' ),
                            'description'   => __( 'Description', 'redux-framework' ),
                            'default'       => array(
                                'multiple',
                                'text',
                                'values'
                            ),
                            'sanitize'      => array(
                                'sanitize_email',
                                'sanitize_something',
                            ),
                            //'sanitize'    => 'santize_email|sanitize_something',
                            'validate'      => array(
                                'is_email',
                                'is_something',
                            ),
                            //'validate'    => 'is_email|is_something',
                            'args'          => array(
                                'class'         => 'regular-text',
                                'placeholder'   => 'a placeholder',
                            ),
                        ),
                        array(
                            'id'            => 'text5',
                            'type'          => 'text',
                            'title'         => __( 'Text Field - nested text field not repeatable', 'redux-framework' ),
                            'sub_title'     => __( 'Sub Title', 'redux-framework' ),
                            'description'   => __( 'Description', 'redux-framework' ),
                            'default'       => 'single value',
                            'requires' => array('field1', '=', 'thirty'),
                            'sanitize'      => array(
                                'sanitize_email',
                                'sanitize_something',
                            ),
                            //'sanitize'    => 'santize_email|sanitize_something',
                            'validate'      => array(
                                'is_email',
                                'is_something',
                            ),
                            //'validate'    => 'is_email|is_something',
                            'args'          => array(
                                'class'         => 'regular-text',
                                'placeholder'   => 'a placeholder',
                            ),
                        ),
                    )
                ),
            )
        ),
        
        
        
        array(
            'id'            => 'groupmulti',
            'type'          => 'group',
            'multi' => true,
            'title'         => __( 'Group Field - repeatable with non repeatable sub fields', 'redux-framework' ),
            'sub_title'     => __( 'Sub Title', 'redux-framework' ),
            'description'   => __( 'Description', 'redux-framework' ),
            'args'          => array(
                'group_title' => __('each group title with a value: [text6]', 'redux-framework' ),
            ),
            'fields'        => array(
                array(
                    'id'            => 'text6',
                    'type'          => 'text',
                    'title'         => __( 'Text Field half', 'redux-framework' ),
                    'sub_title'     => __( 'Sub Title', 'redux-framework' ),
                    'description'   => __( 'Description', 'redux-framework' ),
                    'sanitize'      => array(
                        'sanitize_email',
                        'sanitize_something',
                    ),
                    //'sanitize'    => 'santize_email|sanitize_something',
                    'validate'      => array(
                        'is_email',
                        'is_something',
                    ),
                    //'validate'    => 'is_email|is_something',
                    'args'          => array(
                        'class'         => 'regular-text',
                        'placeholder'   => 'a placeholder',
                        'width' => 'half',
                    ),
                ),
                array(
                    'id'            => 'text7',
                    'type'          => 'text',
                    'title'         => __( 'Text Field half', 'redux-framework' ),
                    'sub_title'     => __( 'Sub Title', 'redux-framework' ),
                    'description'   => __( 'Description', 'redux-framework' ),
                    'sanitize'      => array(
                        'sanitize_email',
                        'sanitize_something',
                    ),
                    //'sanitize'    => 'santize_email|sanitize_something',
                    'validate'      => array(
                        'is_email',
                        'is_something',
                    ),
                    //'validate'    => 'is_email|is_something',
                    'args'          => array(
                        'class'         => 'regular-text',
                        'placeholder'   => 'a placeholder',
                        'width' => 'half',
                    ),
                ),
                array(
                    'id'            => 'text8',
                    'type'          => 'text',
                    'title'         => __( 'Text Field third', 'redux-framework' ),
                    'sub_title'     => __( 'Sub Title', 'redux-framework' ),
                    'description'   => __( 'Description', 'redux-framework' ),
                    'sanitize'      => array(
                        'sanitize_email',
                        'sanitize_something',
                    ),
                    //'sanitize'    => 'santize_email|sanitize_something',
                    'validate'      => array(
                        'is_email',
                        'is_something',
                    ),
                    //'validate'    => 'is_email|is_something',
                    'args'          => array(
                        'class'         => 'regular-text',
                        'placeholder'   => 'a placeholder',
                        'width' => 'third',
                    ),
                ),
                array(
                    'id'            => 'text9',
                    'type'          => 'text',
                    'title'         => __( 'Text Field third', 'redux-framework' ),
                    'sub_title'     => __( 'Sub Title', 'redux-framework' ),
                    'description'   => __( 'Description', 'redux-framework' ),
                    'sanitize'      => array(
                        'sanitize_email',
                        'sanitize_something',
                    ),
                    //'sanitize'    => 'santize_email|sanitize_something',
                    'validate'      => array(
                        'is_email',
                        'is_something',
                    ),
                    //'validate'    => 'is_email|is_something',
                    'args'          => array(
                        'class'         => 'regular-text',
                        'placeholder'   => 'a placeholder',
                        'width' => 'third',
                    ),
                ),
                array(
                    'id'            => 'text10',
                    'type'          => 'text',
                    'title'         => __( 'Text Field third', 'redux-framework' ),
                    'sub_title'     => __( 'Sub Title', 'redux-framework' ),
                    'description'   => __( 'Description', 'redux-framework' ),
                    'sanitize'      => array(
                        'sanitize_email',
                        'sanitize_something',
                    ),
                    //'sanitize'    => 'santize_email|sanitize_something',
                    'validate'      => array(
                        'is_email',
                        'is_something',
                    ),
                    //'validate'    => 'is_email|is_something',
                    'args'          => array(
                        'class'         => 'regular-text',
                        'placeholder'   => 'a placeholder',
                        'width' => 'third',
                    ),
                ),
                array(
                    'id'            => 'text11',
                    'type'          => 'text',
                    'title'         => __( 'Text Field quarter', 'redux-framework' ),
                    'sub_title'     => __( 'Sub Title', 'redux-framework' ),
                    'description'   => __( 'Description', 'redux-framework' ),
                    'sanitize'      => array(
                        'sanitize_email',
                        'sanitize_something',
                    ),
                    //'sanitize'    => 'santize_email|sanitize_something',
                    'validate'      => array(
                        'is_email',
                        'is_something',
                    ),
                    //'validate'    => 'is_email|is_something',
                    'args'          => array(
                        'class'         => 'regular-text',
                        'placeholder'   => 'a placeholder',
                        'width' => 'quarter',
                    ),
                ),
                array(
                    'id'            => 'text12',
                    'type'          => 'text',
                    'title'         => __( 'Text Field half', 'redux-framework' ),
                    'sub_title'     => __( 'Sub Title', 'redux-framework' ),
                    'description'   => __( 'Description', 'redux-framework' ),
                    'sanitize'      => array(
                        'sanitize_email',
                        'sanitize_something',
                    ),
                    //'sanitize'    => 'santize_email|sanitize_something',
                    'validate'      => array(
                        'is_email',
                        'is_something',
                    ),
                    //'validate'    => 'is_email|is_something',
                    'args'          => array(
                        'class'         => 'regular-text',
                        'placeholder'   => 'a placeholder',
                        'width' => 'half',
                    ),
                ),
                array(
                    'id'            => 'text13',
                    'type'          => 'text',
                    'title'         => __( 'Text Field quarter', 'redux-framework' ),
                    'sub_title'     => __( 'Sub Title', 'redux-framework' ),
                    'description'   => __( 'Description', 'redux-framework' ),
                    'sanitize'      => array(
                        'sanitize_email',
                        'sanitize_something',
                    ),
                    //'sanitize'    => 'santize_email|sanitize_something',
                    'validate'      => array(
                        'is_email',
                        'is_something',
                    ),
                    //'validate'    => 'is_email|is_something',
                    'args'          => array(
                        'class'         => 'regular-text',
                        'placeholder'   => 'a placeholder',
                        'width' => 'quarter',
                    ),
                ),
            )
        ),
        

        
    )
);

$options = new Redux_Options( $options_args, $sections );
$sidebars = new Redux_Sidebars( null, array( 'Lee', 'Dan', 'Dovy' ) );

//print_r($options);
//exit();