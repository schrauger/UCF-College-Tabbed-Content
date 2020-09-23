<?php

/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 2019-02-01
 * Time: 1:47 PM
 */
class ucf_college_tabbed_content_acf_pro_fields {

    const shortcode = 'ucf_college_tabbed_content';

    function __construct() {
        add_action( 'acf/init', array( 'ucf_college_tabbed_content_acf_pro_fields', 'create_fields' ) );
    }

    static function create_fields() {
        if ( function_exists( 'acf_add_local_field_group' ) ) {
            acf_add_local_field_group(
                array(
                    'key'                   => 'group_5c59e0b493529',
                    'title'                 => 'Tabbed content',
                    'fields'                => array(
                        array(
                            'key'               => 'field_5c59e0bbe2bc5',
                            'label'             => 'Tab (repeater)',
                            'name'              => 'tab_repeater',
                            'type'              => 'repeater',
                            'instructions'      => '',
                            'required'          => 1,
                            'conditional_logic' => 0,
                            'wrapper'           => array(
                                'width' => '',
                                'class' => '',
                                'id'    => '',
                            ),
                            'collapsed'         => 'field_5c59e0e7e2bc6',
                            'min'               => 1,
                            'max'               => 6,
                            'layout'            => 'block',
                            'button_label'      => 'Add tab',
                            'sub_fields'        => array(
                                array(
                                    'key'               => 'field_5c59e0e7e2bc6',
                                    'label'             => 'Tab label',
                                    'name'              => 'tab_label',
                                    'type'              => 'text',
                                    'instructions'      => '',
                                    'required'          => 1,
                                    'conditional_logic' => 0,
                                    'wrapper'           => array(
                                        'width' => '',
                                        'class' => '',
                                        'id'    => '',
                                    ),
                                    'default_value'     => '',
                                    'placeholder'       => '',
                                    'prepend'           => '',
                                    'append'            => '',
                                    'maxlength'         => '',
                                ),

                                array(
                                    'key'               => 'field_5c59e175e2bca',
                                    'label'             => 'Tab content',
                                    'name'              => 'tab_content',
                                    'type'              => 'wysiwyg',
                                    'instructions'      => '',
                                    'required'          => 0,
                                    'conditional_logic' => 0,
                                    'wrapper'           => array(
                                        'width' => '',
                                        'class' => '',
                                        'id'    => '',
                                    ),
                                    'default_value'     => '',
                                    'placeholder'       => '',
                                    'prepend'           => '',
                                    'append'            => '',
                                    'maxlength'         => '',

                                ),
                            ),
                        ),
                    ),
                    'location'              => array(
                        array(
                            array(
                                'param'    => 'post_taxonomy',
                                'operator' => '==',
                                'value'    => 'ucf_college_shortcode_category:' . self::shortcode,
                            ),
                        ),
                    ),
                    'menu_order'            => 0,
                    'position'              => 'normal',
                    'style'                 => 'default',
                    'label_placement'       => 'top',
                    'instruction_placement' => 'label',
                    'hide_on_screen'        => '',
                    'active'                => 1,
                    'description'           => '',
                ) );
        }
    }
}

new ucf_college_tabbed_content_acf_pro_fields();