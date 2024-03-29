<?php
/*
Plugin Name: UCF College Tabbed Content
Description: Provides a shortcode for a tabbed content, to be used in the UCF Colleges Theme
Version: 1.4.4
Author: Stephen Schrauger
Plugin URI: https://github.com/schrauger/UCF-College-Tabbed-Content
Github Plugin URI: schrauger/UCF-College-Tabbed-Content
*/

namespace ucf_college_tabbed_content;

if ( ! defined( 'WPINC' ) ) {
    die;
}

//include plugin_dir_path( __FILE__ ) . 'includes/common/tinymce.php';
//include plugin_dir_path( __FILE__ ) . 'includes/common/shortcode-taxonomy.php';
include plugin_dir_path( __FILE__ ) . 'includes/acf-pro-fields.php';
include plugin_dir_path( __FILE__ ) . 'includes/block.php';

class ucf_college_tabbed_content {
    function __construct() {
        // plugin css/js
        add_action('enqueue_block_assets', array($this, 'add_css'));
        add_action('enqueue_block_assets', array($this, 'add_js'));

        // plugin activation hooks
        register_activation_hook( __FILE__, array($this,'activation'));
        register_deactivation_hook( __FILE__, array($this,'deactivation'));
        register_uninstall_hook( __FILE__, array($this,'deactivation'));
    }

    function add_css(){
	    if (file_exists(plugin_dir_path(__FILE__).'/includes/plugin.css')) {
		    wp_enqueue_style(
			    'ucf-college-tabbed-content-style',
			    plugin_dir_url( __FILE__ ) . '/includes/plugin.css',
			    false,
			    filemtime( plugin_dir_path( __FILE__ ) . '/includes/plugin.css' ),
			    false
		    );
	    }
    }

    function add_js(){
	    if (file_exists(plugin_dir_path(__FILE__).'/includes/plugin.js')) {
		    wp_enqueue_script(
			    'ucf-college-tabbed-content-script',
			    plugin_dir_url( __FILE__ ) . 'includes/plugin.js',
			    array( 'jquery' ),
			    filemtime( plugin_dir_path( __FILE__ ) . '/includes/plugin.js' ),
			    false
		    );
	    }
	    if (is_admin()) {
		    if ( file_exists( plugin_dir_path( __FILE__ ) . 'includes/arrive.min.js' ) ) {
			    wp_enqueue_script(
				    'arrive',
				    plugin_dir_url( __FILE__ ) . 'includes/arrive.min.js',
				    array( 'jquery' ),
				    filemtime( plugin_dir_path( __FILE__ ) . '/includes/arrive.min.js' ),
				    false
			    );
		    }
		    if ( file_exists( plugin_dir_path( __FILE__ ) . '/includes/plugin-editor-hide-taxonomy-if-unused.js' ) ) {
			    wp_enqueue_script(
				    'ucf-college-accordion-script-editor-hide-taxonomy-if-unused',
				    plugin_dir_url( __FILE__ ) . 'includes/plugin-editor-hide-taxonomy-if-unused.js',
				    array( 'jquery', 'arrive' ),
				    filemtime( plugin_dir_path( __FILE__ ) . '/includes/plugin-editor-hide-taxonomy-if-unused.js' ),
				    true
			    );
		    }
	    }
    }
    
    


    // run on plugin activation
    function activation(){
        // insert the shortcode for this plugin as a term in the taxonomy
        //ucf_college_tabbed_content_shortcode::insert_shortcode_term();
    }

    // run on plugin deactivation
    function deactivation(){
        //ucf_college_tabbed_content_shortcode::delete_shortcode_term();
    }

    // run on plugin complete uninstall
    function uninstall(){
        //ucf_college_tabbed_content_shortcode::delete_shortcode_term();
    }
}

new ucf_college_tabbed_content();



