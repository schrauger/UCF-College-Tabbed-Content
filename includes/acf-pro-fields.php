<?php

/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 2019-02-01
 * Time: 1:47 PM
 */

namespace ucf_college_tabbed_content\acf_pro_fields;

const shortcode = 'ucf_college_tabbed_content';

const acf_group_key = 'group_5c59e0b493529';

    add_action( 'acf/init', __NAMESPACE__ . '\\create_fields' );


function create_fields() {
    if ( function_exists( 'acf_add_local_field_group' ) ) {

        if( function_exists('acf_register_block') ) {
	        // register a testimonial block
	        acf_register_block(array(
		                           'name'				=> 'ucf_college_tabbed_content',
		                           'title'				=> __('Tabbed Content'),
		                           'description'		=> __('Tabbed sections with repeater content.'),
		                           'render_callback'	=> 'ucf_college_tabbed_content\\block\\replacement_print',
		                           'category'			=> 'layout',
		                           'icon'				=> 'index-card',
		                           'keywords'			=> array( 'ucf', 'college','tabbed','content' ),
		                           'mode'               => 'edit',
	                           ));
        }

        acf_add_local_field_group(
            array(
                'key'                   => acf_group_key,
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
		                    'param'    => 'block',
		                    'operator' => '==',
		                    'value'    => 'acf/ucf-college-tabbed-content',
	                    ),
                    ),
                    array(
                        array(
                            'param'    => 'post_taxonomy',
                            'operator' => '==',
                            'value'    => 'ucf_college_shortcode_category:' . shortcode,
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
