<?php

namespace ucf_college_tabbed_content\block;

const shortcode_slug = 'ucf_college_tabbed_content'; // the shortcode text entered by the user (inside square brackets)


/**
 * Adds the shortcode to wordpress' index of shortcodes.
 * Deprecated, but kept for nursing until all pages use blocks.
 */
function add_shortcode() {
    if ( ! ( shortcode_exists( shortcode_slug ) ) ) {
	    \add_shortcode( shortcode_slug, __NAMESPACE__ . '\\replacement' );
    }
}
add_action( 'init', __NAMESPACE__ . '\\add_shortcode' );


/**
 * Returns the replacement html that WordPress uses in place of the shortcode
 * @param null $attrs
 *
 * @return mixed
 */
function replacement( $attrs = null ){
    $replacement_data = ''; //string of html to return

    if (have_rows('tab_repeater')){
        $replacement_data .= "
<div class='container tabs'>
<section class='button-menu'>";

        // print out all tabs (just the labels)
        $is_first = true;
        while (have_rows('tab_repeater')){
            if ($is_first){
                $class = 'button toggle tab-active';
            } else {
                $class = 'button toggle';
            }
            the_row();
            $tab_label = get_sub_field('tab_label');
            $tab_id = sanitize_title_with_dashes($tab_label);
            // output the tab header
            $replacement_data .= "<a class='{$class}' data-id='{$tab_id}' href='#'>{$tab_label}</a>";
            $is_first = false;
        }
        $replacement_data .= "
</section>";


        // output the tab content (the contentof items) in their own sections, not children of the tabs
        reset_rows();
        $is_first = true;
        while (have_rows('tab_repeater')) {
            if ($is_first){
				$style = 'display: block;';
            } else {
                $style = 'display: none;';
            }
            the_row();
            $tab_label = get_sub_field('tab_label');
            $tab_content = get_sub_field('tab_content');
            $tab_id = sanitize_title_with_dashes($tab_label);
            $is_first = false;
            $replacement_data .= "
<section class='menu-expanded' for='{$tab_id}' style='{$style}'>
<div class='tab-content'>{$tab_content}</div>
</section>
";
        }
        $replacement_data .= "
</div>";
    }
    return $replacement_data;
}

function replacement_print() {
	echo replacement();
}




