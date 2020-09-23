<?php

class ucf_college_tabbed_content_shortcode {
    const shortcode_slug = 'ucf_college_tabbed_content'; // the shortcode text entered by the user (inside square brackets)
    const shortcode_name = 'Tabbed Content (deprecated - use blocks)';
    const shortcode_description = 'Tabbed sections with repeater content';
    //const get_param_group = 'people_group'; // group or category person is in

    function __construct() {
//        add_action( 'init', array( $this, 'add_shortcode' ) );
//        add_filter( 'query_vars', array($this, 'add_query_vars_filter' )); // tell wordpress about new url parameters
//        add_filter( 'ucf_college_shortcode_menu_item', array($this, 'add_ckeditor_shortcode'));
    }

    /**
     * Adds the shortcode to wordpress' index of shortcodes
     */
    static function add_shortcode() {
        if ( ! ( shortcode_exists( self::shortcode_slug ) ) ) {
            add_shortcode( self::shortcode_slug, array('ucf_college_tabbed_content_shortcode', 'replacement' ));
        }
    }

    /**
     * Adds the shortcode to the ckeditor dropdown menu
     */
    static function add_ckeditor_shortcode($shortcode_array){
        $shortcode_array[] = array(
            'slug' => self::shortcode_slug,
            'name' => self::shortcode_name,
            'description' => self::shortcode_description            
        );
        return $shortcode_array;
    }

    /**
     * Tells wordpress to listen for the 'people_group' parameter in the url. Used to filter down to specific profiles.
     * @param $vars
     *
     * @return array
     */
    static function add_query_vars_filter($vars){
        //$vars[] = self::get_param_group;
        return $vars;
    }

    /**
     * Returns the replacement html that WordPress uses in place of the shortcode
     * @param null $attrs
     *
     * @return mixed
     */
    static function replacement( $attrs = null ){
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

	static function replacement_print() {
		echo self::replacement();
	}

    /**
     * Only run this on plugin activation, as it's stored in the database
     */
	/*static function insert_shortcode_term(){
        $taxonomy = new ucf_college_shortcode_taxonomy;
        $taxonomy->create_taxonomy();
        wp_insert_term(
            self::shortcode_name,
            ucf_college_shortcode_taxonomy::taxonomy_slug,
            array(
                'description' => self::shortcode_description,
                'slug' => self::shortcode_slug
            )
        );
    }*/

    /**
     * Run when plugin is disabled and/or uninstalled. This removes the shortcode from the contentof shortcodes in the taxonomy.
     */
    /*static function delete_shortcode_term(){
        $taxonomy = new ucf_college_shortcode_taxonomy;
        $taxonomy->create_taxonomy();
        wp_delete_term(get_term_by('slug', self::shortcode_slug)->term_id, ucf_college_shortcode_taxonomy::taxonomy_slug);
    }*/




}

add_action( 'init', array( 'ucf_college_tabbed_content_shortcode', 'add_shortcode' ) );
add_filter( 'query_vars', array('ucf_college_tabbed_content_shortcode', 'add_query_vars_filter' )); // tell wordpress about new url parameters
//add_filter( 'ucf_college_shortcode_menu_item', array('ucf_college_tabbed_content_shortcode', 'add_ckeditor_shortcode'));

//new ucf_college_tabbed_content_shortcode();
