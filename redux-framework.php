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
    'title'                 => __( 'Basic Text Fields', 'redux-framework' ),
    'header'                => __( 'Redux Text Field Options', 'redux-framework' ),
    'description'           => __( 'Redux Text Field Options', 'redux-framework' ),
    'fields'                => array(
        array(
            'id'            => 'small-text',
            'type'          => 'text',
            'title'         => __( 'Small Text', 'redux-framework' ),
            'sub_title'     => __( 'Small class text field', 'redux-framework' ),
            'description'   => __( 'This field uses the <code>small-text</code> class to produce a small text input.', 'redux-framework' ),
            'args'          => array(
                'classes'       => array('small-text'), 
                'placeholder'   => 'A placeholder value'
            ),
        ),
        array(
            'id'            => 'regular-text',
            'type'          => 'text',
            'title'         => __( 'Regular Text', 'redux-framework' ),
            'sub_title'     => __( 'Regular class text field', 'redux-framework' ),
            'description'   => __( 'This field uses the <code>regular-text</code> class to produce a regular text input. This is the default so you dont even have to provide the class name in the field args.', 'redux-framework' ),
        ),
        array(
            'id'            => 'large-text',
            'type'          => 'text',
            'title'         => __( 'Large Text', 'redux-framework' ),
            'sub_title'     => __( 'Large class text field', 'redux-framework' ),
            'description'   => __( 'This field uses the <code>large-text</code> class to produce a large text input.', 'redux-framework' ),
            'args'          => array(
                'classes'   => array('large-text'),  
            ),
        ),
    )
);


$sections['groups'] = array(
    'icon'                  => 'group',  
    'icon_class'            => 'icon-large',
    'title'                 => __( 'Group Fields', 'redux-framework' ),
    'header'                => __( 'Group fields allow you to group settings for better organisation. Nested fields are not only displayed inside the group, but they are also nested in the option values. Group fields can be nested within each other too!', 'redux-framework' ),
    'description'           => __( 'Group fields allow you to group settings for better organisation. Nested fields are not only displayed inside the group, but they are also nested in the option values. Group fields can be nested within each other too!', 'redux-framework' ),
    'fields'                => array(
        array(
            'id'            => 'group',
            'type'          => 'group',
            'title'         => __( 'Group Field', 'redux-framework' ),
            'sub_title'     => __( 'This is a standard group field with nested fields.', 'redux-framework' ),
            'description'   => __( 'This is a standard group field with nested fields.', 'redux-framework' ),
            'args'          => array(
                'group_title'           => __( 'You can define custom group titles, with shortcodes for nested field values: [text2], [text3]', 'redux-framework' ),
                'group_description'     => __( 'Here you can define a group description which will be displayed before the nested fields.', 'redux-framework' ),
            ),
            'fields'        => array(
                array(
                    'id'            => 'group-text',
                    'type'          => 'text',
                    'title'         => __( 'Text Field', 'redux-framework' ),
                    'sub_title'     => __( '', 'redux-framework' ),
                    'description'   => __( 'Every nested field is defined just like a top level field.', 'redux-framework' ),
                ),
                array(
                    'id'            => 'group-text2',
                    'type'          => 'text',
                    'title'         => __( 'Text Field 2', 'redux-framework' ),
                    'sub_title'     => __( 'You can create unlimited nested fields!', 'redux-framework' ),
                    'description'   => __( 'You can create unlimited nested fields!', 'redux-framework' ),
                ),
            )
        ),
        array(
            'id'            => 'nested-group',
            'type'          => 'group',
            'title'         => __( 'Top Level Group Field', 'redux-framework' ),
            'sub_title'     => __( 'This group field has nested group fields!', 'redux-framework' ),
            'description'   => __( 'This group field has nested group fields!', 'redux-framework' ),
            'args'          => array(
                'group_title'           => __( 'The Top Level Group Title', 'redux-framework' ),
                'group_description'     => __( 'The Group Description', 'redux-framework' ),
            ),
            'fields'        => array(
                array(
                    'id'            => 'nested-group1',
                    'type'          => 'group',
                    'multi' => true,
                    'title'         => __( 'SubLevel Group Field', 'redux-framework' ),
                    'sub_title'     => __( 'This is a sublevel group field, which is also repeatable!', 'redux-framework' ),
                    'description'   => __( 'This is a sublevel group field, which is also repeatable!', 'redux-framework' ),
                    'args' => array(
                        'group_title'       => 'my nested grpup title with dynamic values in the title: [text4]',
                    ),
                    'fields'        => array(
                        array(
                            'id'            => 'text4',
                            'type'          => 'text',
                            'multi' => true,
                            'title'         => __( 'Text Field', 'redux-framework' ),
                            'sub_title'     => __( 'Nested text field which is repeatable!', 'redux-framework' ),
                            'description'   => __( 'All features of top level fields are also available to nested fields.', 'redux-framework' ),
                            'default'       => array(
                                'multiple',
                                'text',
                                'values'
                            ),
                        ),
                        array(
                            'id'            => 'text5',
                            'type'          => 'text',
                            'title'         => __( 'Text Field', 'redux-framework' ),
                            'sub_title'     => __( 'Nested text field which is NOT repeatable.', 'redux-framework' ),
                            'description'   => __( '', 'redux-framework' ),
                        ),
                    )
                ),
            )
        ),
        array(
            'id'            => 'group-multi',
            'type'          => 'group',
            'multi'         => true,
            'title'         => __( 'Group Field', 'redux-framework' ),
            'sub_title'     => __( 'Repeatable group field.', 'redux-framework' ),
            'description'   => __( 'Repeatable group field.', 'redux-framework' ),
            'args'          => array(
                'group_title'   => __('Dynamic values in the group title: [text6]', 'redux-framework' ),
            ),
            'fields'        => array(
                array(
                    'id'            => 'text6',
                    'type'          => 'text',
                    'title'         => __( 'Text Field Half', 'redux-framework' ),
                    'sub_title'     => __( 'This field has a width attribute of "half".', 'redux-framework' ),
                    'description'   => __( '', 'redux-framework' ),
                    'args'          => array(
                        'width'         => 'half',
                        'classes'       => array('small-text'),
                    ),
                ),
                array(
                    'id'            => 'text7',
                    'type'          => 'text',
                    'title'         => __( 'Text Field Quarter', 'redux-framework' ),
                    'sub_title'     => __( 'This field has a width attribute of "quarter".', 'redux-framework' ),
                    'description'   => __( '', 'redux-framework' ),
                    'args'          => array(
                        'width'         => 'quarter',
                        'classes'       => array('small-text'),
                    ),
                ),
                array(
                    'id'            => 'text8',
                    'type'          => 'text',
                    'title'         => __( 'Text Field Quarter', 'redux-framework' ),
                    'sub_title'     => __( 'This field has a width attribute of "quarter".', 'redux-framework' ),
                    'description'   => __( '', 'redux-framework' ),
                    'args'          => array(
                        'width'         => 'quarter',
                        'classes'       => array('small-text'),
                    ),
                ),
                array(
                    'id'            => 'text9',
                    'type'          => 'text',
                    'title'         => __( 'Text Field Third', 'redux-framework' ),
                    'sub_title'     => __( 'This field has a width attribute of "third".', 'redux-framework' ),
                    'description'   => __( '', 'redux-framework' ),
                    'args'          => array(
                        'width'         => 'third',
                        'classes'       => array('small-text'),
                    ),
                ),
                array(
                    'id'            => 'text10',
                    'type'          => 'text',
                    'title'         => __( 'Text Field Third', 'redux-framework' ),
                    'sub_title'     => __( 'This field has a width attribute of "third".', 'redux-framework' ),
                    'description'   => __( '', 'redux-framework' ),
                    'args'          => array(
                        'width'         => 'third',
                        'classes'       => array('small-text'),
                    ),
                ),
                array(
                    'id'            => 'text11',
                    'type'          => 'text',
                    'title'         => __( 'Text Field Third', 'redux-framework' ),
                    'sub_title'     => __( 'This field has a width attribute of "third".', 'redux-framework' ),
                    'description'   => __( '', 'redux-framework' ),
                    'args'          => array(
                        'width'         => 'third',
                        'classes'       => array('small-text'),
                    ),
                ),
            )
        ),   
    )
);


$sections['sanitize'] = array(
    'icon'                  => 'cog',  
    'icon_class'            => 'icon-large',
    'title'                 => __( 'Sanitize Values', 'redux-framework' ),
    'header'                => __( 'Redux allows you to sanitize field values! This is seperate to validation and allows you to format the input before validation is run on the values. Sanitize functions can be anything that are provided the value and returns the value back formatted as desired. Multiple functions can be provided too and will be run in order as defined.', 'redux-framework' ),
    'description'           => __( 'Redux allows you to sanitize field values! This is seperate to validation and allows you to format the input before validation is run on the values. Sanitize functions can be anything that are provided the value and returns the value back formatted as desired. Multiple functions can be provided too and will be run in order as defined.', 'redux-framework' ),
    'fields'                => array(
        array(
            'id'            => 'sanitize-text',
            'type'          => 'text',
            'title'         => __( 'Sanitize Title Text', 'redux-framework' ),
            'sub_title'     => __( '', 'redux-framework' ),
            'description'   => __( 'This field will be sanitized with the WordPress <code>sanitize_title</code> function.', 'redux-framework' ),
            'sanitize'      => array(
                'sanitize_title'
            ),
        ),
        array(
            'id'            => 'sanitize-group',
            'type'          => 'group',
            'multi' => false,
            'title'         => __( 'Sanitize Group Field', 'redux-framework' ),
            'sub_title'     => __( 'Sub fields within groups can also be sanitized!', 'redux-framework' ),
            'description'   => __( 'Sub fields within groups can also be sanitized!', 'redux-framework' ),
            'args'          => array(
                'group_title'           => __( 'Sub fields within groups can also be sanitized!', 'redux-framework' ),
                'group_description'     => __( 'Sub fields within groups can also be sanitized!', 'redux-framework' ),
            ),
            'fields'        => array(
                array(
                    'id'                => 'group-sanitize-text',
                    'type'              => 'text',
                    'title'             => __( 'Sanitize Uppercase Text Field', 'redux-framework' ),
                    'sub_title'         => __( 'This field will be converted to uppercase values.', 'redux-framework' ),
                    'description'       => __( 'This field will be converted to uppercase values with the <code>strtoupper</code> function.', 'redux-framework' ),
                    'sanitize'          => array(
                        'strtoupper'
                    ),
                ),
            )
        ),
    )
);

$sections['validate'] = array(
    'icon'                  => 'cog',  
    'icon_class'            => 'icon-large',
    'title'                 => __( 'Validate Values', 'redux-framework' ),
    'header'                => __( 'Redux Validation allows you to define callbacks which will be run on the supplied value. And allow you to throw an exception if the value isn\'t valid. As with sanitization multiple functions can be provided.', 'redux-framework' ),
    'description'           => __( 'Redux Validation allows you to define callbacks which will be run on the supplied value. And allow you to throw an exception if the value isn\'t valid. As with sanitization multiple functions can be provided.', 'redux-framework' ),
    'fields'                => array(
        array(
            'id'            => 'validate-text',
            'type'          => 'text',
            'title'         => __( 'Validate Text as Email', 'redux-framework' ),
            'sub_title'     => __( 'This field must be an email address. You can also provide custom args to  the callback, including a custom error message!', 'redux-framework' ),
            'description'   => __( 'This field must be an email address. You can also provide custom args to  the callback, including a custom error message!', 'redux-framework' ),
            'validate'      => array(
                'Redux_Validation::email'       => array( 'message' => __( 'This is a custom validation error message.', 'redux-framework' ) )
            ),
        ),
        array(
            'id'            => 'validate-text2',
            'type'          => 'text',
            'title'         => __( 'Validate Text as Required', 'redux-framework' ),
            'sub_title'     => __( 'This field requires a value to validate.', 'redux-framework' ),
            'description'   => __( 'This field requires a value to validate.', 'redux-framework' ),
            'validate'      => array(
                'Redux_Validation::required'    => array()
            ),
        ),
        array(
            'id'            => 'validate-text3',
            'type'          => 'text',
            'title'         => __( 'Validate Text as Email and Required', 'redux-framework' ),
            'sub_title'     => __( 'Multiple functions can be provided.', 'redux-framework' ),
            'description'   => __( 'Multiple functions can be provided.', 'redux-framework' ),
            'validate'      => array(
                'Redux_Validation::email'       => array(),
                'Redux_Validation::required'    => array()
            ),
        ),
        array(
            'id'            => 'validate-group',
            'type'          => 'group',
            'title'         => __( 'Validate Group Field', 'redux-framework' ),
            'sub_title'     => __( 'Group Sub Fields can also be validated!', 'redux-framework' ),
            'description'   => __( 'Group Sub Fields can also be validated!', 'redux-framework' ),
            'args'          => array(
                'group_title'           => __( 'Group Sub Fields can also be validated!', 'redux-framework' ),
                'group_description'     => __( 'Group Sub Fields can also be validated!', 'redux-framework' ),
            ),
            'fields'        => array(
                array(
                    'id'            => 'group-validate-text',
                    'type'          => 'text',
                    'title'         => __( 'Validated Email Group Field', 'redux-framework' ),
                    'sub_title'     => __( 'Works the same as top level fields.', 'redux-framework' ),
                    'description'   => __( 'Works the same as top level fields.', 'redux-framework' ),
                    'validate'      => array(
                        'Redux_Validation::email'       => array()
                    ),
                ),
                array(
                    'id'            => 'group-validate-text2',
                    'type'          => 'text',
                    'title'         => __( 'Validate Required Group Field', 'redux-framework' ),
                    'sub_title'     => __( 'Works the same as top level fields.', 'redux-framework' ),
                    'description'   => __( 'Works the same as top level fields.', 'redux-framework' ),
                    'validate'      => array(
                        'Redux_Validation::required'    => array()
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
            'description'   => __( 'This text must be "required" for the next field to show. Type "required" into the text field for the next field to show.', 'redux-framework' ),
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

$sections['default'] = array(
    'icon'                  => 'cog',  
    'icon_class'            => 'icon-large',
    'title'                 => __( 'Default Values', 'redux-framework' ),
    'header'                => __( 'Any field type can be given a default value. These values will be used on first activation, and if the reset to defaults button is used.', 'redux-framework' ),
    'description'           => __( 'Any field type can be given a default value. These values will be used on first activation, and if the reset to defaults button is used.', 'redux-framework' ),
    'fields'                => array(
        array(
            'id'            => 'default-text',
            'type'          => 'text',
            'title'         => __( 'Default Text', 'redux-framework' ),
            'description'   => __( 'This text field has a default value of "http://reduxframework.com".', 'redux-framework' ),
            'default'       => 'http://reduxframework.com',
        ),
    )
);

$sections['multi'] = array(
    'icon'                  => 'cog',  
    'icon_class'            => 'icon-large',
    'title'                 => __( 'Multi Fields', 'redux-framework' ),
    'header'                => __( 'Most (but not all) fields can be defined as "multi" fields. These fields can be repeated!', 'redux-framework' ),
    'description'           => __( 'Most (but not all) fields can be defined as "multi" fields. These fields can be repeated!', 'redux-framework' ),
    'fields'                => array(
        array(
            'id'            => 'multi-text',
            'type'          => 'text',
            'title'         => __( 'Multi Text', 'redux-framework' ),
            'description'   => __( 'This text field can be repeated! By default multi fields are also sortable.', 'redux-framework' ),
            'multi'         => true,
        ),
        array(
            'id'            => 'multi-text-not-sortable',
            'type'          => 'text',
            'title'         => __( 'Multi Text Not Sortable', 'redux-framework' ),
            'description'   => __( 'This text field can be repeated! By adding <code>\'sortable\' => false</code> you can prevent it being sortable..', 'redux-framework' ),
            'multi'         => true,
            'sortable'      => false
        ),
    )
);

$sections['import-export'] = array(
    'icon'                  => 'cog',  
    'icon_class'            => 'icon-large',
    'title'                 => __( 'Import/Export Fields', 'redux-framework' ),
    'header'                => __( 'This section details the import/export field types.', 'redux-framework' ),
    'description'           => __( 'This section details the import/export field types.', 'redux-framework' ),
    'fields'                => array(
        array(
            'id'            => 'export',
            'type'          => 'export',
            'title'         => __( 'Export', 'redux-framework' ),
            'sub_title'     => __( 'Export options page values', 'redux-framework' ),
            'description'   => __( 'This field allows you to download an export file for the options on the page.', 'redux-framework' ),
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
            'description'   => __( 'On any field you can define <code>\'dev_mode\' => true</code> in the field array to get all the details stored for this field. This list includes what you define for the field. And the values inheritted from the field template.', 'redux-framework' ),
            'dev_mode'      => true
        ),
        array(
            'id'            => 'dev-template',
            'type'          => 'dev',
            'title'         => __( 'Dev Object', 'redux-framework' ),
            'sub_title'     => __( 'This field type will display the entire Options page object so you can inspect the properties.', 'redux-framework' ),
            'description'   => __( 'This field type will display the entire Options page object so you can inspect the properties.', 'redux-framework' ),
        ),
    )
);

$options = new Redux_Options( $options_args, $sections );
//$sidebars = new Redux_Sidebars( null, array( 'Lee', 'Dan', 'Dovy' ) );