<?php
/**
Plugin Name: G Support
*/

    add_action( 'wp_enqueue_scripts', 'my_kewl_plugin_footer_js' );
    function my_kewl_plugin_footer_js(){
        wp_enqueue_script( 'my-kewl-plugin-footer', plugins_url( '/js/script-support.js', __FILE__ ), array(), filemtime( plugin_dir_path( __FILE__ ) . 'js/ghost-support.js', true );
    }
?>