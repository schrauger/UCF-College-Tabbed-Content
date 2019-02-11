<?php

class ucf_college_tabbed_list_shortcode {
    const shortcode_slug = 'ucf_college_tabbed_list'; // the shortcode text entered by the user (inside square brackets)
    const shortcode_name = 'Tabbed List';
    const shortcode_description = 'Tabbed sections with repeater list';
    //const get_param_group = 'people_group'; // group or category person is in

    function __construct() {
        add_action( 'init', array( $this, 'add_shortcode' ) );
        add_filter( 'query_vars', array($this, 'add_query_vars_filter' )); // tell wordpress about new url parameters
        add_filter( 'ucf_college_shortcode_menu_item', array($this, 'add_ckeditor_shortcode'));
    }

    /**
     * Adds the shortcode to wordpress' index of shortcodes
     */
    function add_shortcode() {
        if ( ! ( shortcode_exists( self::shortcode_slug ) ) ) {
            add_shortcode( self::shortcode_slug, array($this, 'replacement' ));
        }
    }

    /**
     * Adds the shortcode to the ckeditor dropdown menu
     */
    function add_ckeditor_shortcode($shortcode_array){
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
    function add_query_vars_filter($vars){
        //$vars[] = self::get_param_group;
        return $vars;
    }

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
            while (have_rows('tab_repeater')){
                the_row();
                $tab_label = get_sub_field('tab_label');
                $tab_id = sanitize_title_with_dashes($tab_label);
                // output the tab header
                $replacement_data .= "<a class='button toggle' data-id='{$tab_id}' href='#'>{$tab_label}</a>";
            }
            $replacement_data .= "
    </section>";


            // output the tab content (the list of items) in their own sections, not children of the tabs
            reset_rows();
            while (have_rows('tab_repeater')) {
                the_row();
                $tab_label = get_sub_field('tab_label');
                $tab_id = sanitize_title_with_dashes($tab_label);
                $replacement_data .= "
    <section class='menu-expanded' for='{$tab_id}'>";

                if ( have_rows( 'tab_content_group' ) ) {
                    while (have_rows('tab_content_group')) {
                        the_row();
                        $list_label = get_sub_field('list_label');
                        $replacement_data .= "
        <h4>{$list_label}</h4>
        <ul>";
                        if ( have_rows( 'list_content_repeater' ) ) {
                            while ( have_rows( 'list_content_repeater' ) ) {
                                // print out all repeater rows, after the header field
                                the_row();
                                $data   = get_sub_field( 'list_item' );
                                $replacement_data .= "
            <li>{$data}</li>";
                            }
                        }
                        $replacement_data .= "
        </ul>";
                    }





                }
                $replacement_data .= "
    </section>";
            }
            $replacement_data .= "
</div>";
        }
        return $replacement_data;
    }

    /**
     * Only run this on plugin activation, as it's stored in the database
     */
    static function insert_shortcode_term(){
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
    }

    /**
     * Run when plugin is disabled and/or uninstalled. This removes the shortcode from the list of shortcodes in the taxonomy.
     */
    static function delete_shortcode_term(){
        $taxonomy = new ucf_college_shortcode_taxonomy;
        $taxonomy->create_taxonomy();
        wp_delete_term(get_term_by('slug', self::shortcode_slug)->term_id, ucf_college_shortcode_taxonomy::taxonomy_slug);
    }




}

new ucf_college_tabbed_list_shortcode();
