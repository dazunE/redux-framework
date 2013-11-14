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

$sections['text'] = array(
    'icon'                  => 'cog',  
    'icon_class'            => 'icon-large',
    'title'                 => __( 'Text Fields', 'redux-framework' ),
    'header'                => __( 'Redux Text Field Options', 'redux-framework' ),
    'description'           => __( 'Redux Text Field Options', 'redux-framework' ),
    'fields'                => array(
        array(
            'id'            => 'small-text',
            'type'          => 'text',
            'title'         => __( 'Small Text', 'redux-framework' ),
            'sub_title'     => __( 'Small class text field', 'redux-framework' ),
            'description'   => __( 'Description area', 'redux-framework' ),
            'args' => array(
                'classes' => array('small-text'),  
            ),
        ),
        array(
            'id'            => 'regular-text',
            'type'          => 'text',
            'title'         => __( 'Regular Text', 'redux-framework' ),
            'sub_title'     => __( 'Regular class text field', 'redux-framework' ),
            'description'   => __( 'Description area', 'redux-framework' ),
            'args' => array(
                'classes' => array('regular-text'),  
            ),
        ),
        array(
            'id'            => 'large-text',
            'type'          => 'text',
            'title'         => __( 'Large Text', 'redux-framework' ),
            'sub_title'     => __( 'Large class text field', 'redux-framework' ),
            'description'   => __( 'Description area', 'redux-framework' ),
            'args' => array(
                'classes' => array('large-text'),  
            ),
        ),
    )
);


$sections['sanitize'] = array(
    'icon'                  => 'cog',  
    'icon_class'            => 'icon-large',
    'title'                 => __( 'Sanitize Values', 'redux-framework' ),
    'header'                => __( 'Redux Sanitization Options', 'redux-framework' ),
    'description'           => __( 'Redux Sanitization Options', 'redux-framework' ),
    'fields'                => array(
        array(
            'id'            => 'sanitize-text',
            'type'          => 'text',
            'title'         => __( 'Sanitize Text', 'redux-framework' ),
            'sub_title'     => __( 'Small class text field', 'redux-framework' ),
            'description'   => __( 'Description area', 'redux-framework' ),
            'sanitize' => array(
                'sanitize_title',
                'strtoupper'
            ),
        ),
        array(
            'id'            => 'sanitize-group',
            'type'          => 'group',
            'multi' => false,
            'title'         => __( 'Sanitize Group Field', 'redux-framework' ),
            'sub_title'     => __( 'Sub Title', 'redux-framework' ),
            'description'   => __( 'Description', 'redux-framework' ),
            'args'          => array(
                'group_title'   => __( 'Sub fields can be sanitized', 'redux-framework' ),
                'group_description'   => __( 'The Group Description', 'redux-framework' ),
            ),
            'fields'        => array(
                array(
                    'id'            => 'group-sanitize-text',
                    'type'          => 'text',
                    'title'         => __( 'Text Field', 'redux-framework' ),
                    'sub_title'     => __( 'Sub Title', 'redux-framework' ),
                    'description'   => __( 'Description', 'redux-framework' ),
                    'sanitize' => array(
                        'sanitize_title',
                        'strtoupper'
                    ),
                ),
                array(
                    'id'            => 'group-sanitize-text2',
                    'type'          => 'text',
                    'title'         => __( 'Text Field', 'redux-framework' ),
                    'sub_title'     => __( 'Sub Title', 'redux-framework' ),
                    'description'   => __( 'Description', 'redux-framework' ),
                    'sanitize' => array(
                        'sanitize_title',
                        'strtoupper'
                    ),
                ),
            )
        ),
    )
);


$sections['requires'] = array(
    'icon'                  => 'cog',  
    'icon_class'            => 'icon-large',
    'title'                 => __( 'Required Fields', 'redux-framework' ),
    'header'                => __( 'Required fields can be 1=1 or chainable. and nested fields also work too!', 'redux-framework' ),
    'description'           => __( 'Required fields can be 1=1 or chainable. and nested fields also work too!', 'redux-framework' ),
    'fields'                => array(
        array(
            'id'            => 'required-text',
            'type'          => 'text',
            'title'         => __( 'Required Text', 'redux-framework' ),
            'description'   => __( 'This text must be "required" for the next field to show.', 'redux-framework' ),
        ),
        array(
            'id'            => 'requires-text',
            'type'          => 'text',
            'title'         => __( 'Requires Text', 'redux-framework' ),
            'description'   => __( 'The above field must be "required" for this to be displayed. The next field will only show if this field value is "required2".', 'redux-framework' ),
            'requires' => array('required-text', '=', 'required'),
        ),
        array(
            'id'            => 'requires-text-2',
            'type'          => 'text',
            'title'         => __( 'Requires Text chainable', 'redux-framework' ),
            'description'   => __( 'The above field must be "required2" for this to be displayed.', 'redux-framework' ),
            'requires' => array('requires-text', '=', 'required2'),
        ),
    )
);

$sections['dev'] = array(
    'icon'                  => 'cog',  
    'icon_class'            => 'icon-large',
    'title'                 => __( 'Dev Fields and Properties', 'redux-framework' ),
    'header'                => __( 'This section details some of the dev settings for the options page.', 'redux-framework' ),
    'description'           => __( 'This section details some of the dev settings for the options page.', 'redux-framework' ),
    'fields'                => array(
        array(
            'id'            => 'dev-mode',
            'type'          => 'text',
            'title'         => __( 'Dev mode', 'redux-framework' ),
            'sub_title'     => __( '', 'redux-framework' ),
            'description'   => __( 'On any field you can define <code>\'dev_mode\' => true</code> in the field array to get all the details stored for this field. This list includes what you define for the field. and the values inheritted from the field template.', 'redux-framework' ),
            'args' => array(
                'classes' => array('regular-text'),  
            ),
            'dev_mode' => true
        ),
        array(
            'id'            => 'dev-template',
            'type'          => 'dev',
            'title'         => __( 'Dev mode', 'redux-framework' ),
            'sub_title'     => __( '', 'redux-framework' ),
            'description'   => __( '', 'redux-framework' ),
        ),
    )
);

$sections['import-export'] = array(
    'icon'                  => 'cog',  
    'icon_class'            => 'icon-large',
    'title'                 => __( 'Import/Export', 'redux-framework' ),
    'header'                => __( 'This section details the import/export field types.', 'redux-framework' ),
    'description'           => __( 'This section details the import/export field types.', 'redux-framework' ),
    'fields'                => array(
        array(
            'id'            => 'export',
            'type'          => 'export',
            'title'         => __( 'Export', 'redux-framework' ),
            'sub_title'     => __( '', 'redux-framework' ),
            'description'   => __( 'This field details the options AS THERE ARE BEFORE ALTERATIONS on this page load.', 'redux-framework' ),
        ),
    )
);

$sections['groups'] = array(
    'icon'                  => 'group',  
    'icon_class'            => 'icon-large',
    'title'                 => __( 'Group Fields', 'redux-framework' ),
    'header'                => __( 'Section heading', 'redux-framework' ),
    'description'           => __( 'Section Description', 'redux-framework' ),
    'fields'                => array(
        
        array(
            'id'            => 'group',
            'type'          => 'group',
            'multi' => false,
            'title'         => __( 'Group Field - not repeatable', 'redux-framework' ),
            'sub_title'     => __( 'Sub Title', 'redux-framework' ),
            'description'   => __( 'Description', 'redux-framework' ),
            'args'          => array(
                'group_title'   => __( 'The Group Title field: [text2], [text3]', 'redux-framework' ),
                'group_description'   => __( 'The Group Description', 'redux-framework' ),
            ),
            'fields'        => array(
                array(
                    'id'            => 'group-text',
                    'type'          => 'text',
                    'title'         => __( 'Text Field', 'redux-framework' ),
                    'sub_title'     => __( 'Sub Title', 'redux-framework' ),
                    'description'   => __( 'Description', 'redux-framework' ),
                ),
                array(
                    'id'            => 'group-text2',
                    'type'          => 'text',
                    'title'         => __( 'Text Field', 'redux-framework' ),
                    'sub_title'     => __( 'Sub Title', 'redux-framework' ),
                    'description'   => __( 'Description', 'redux-framework' ),
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