<?php

/**
 * Plugin Name:       SVG media library support
 * Plugin URI:        https://benchmark.co.uk
 * Description:       Add support for SVG files (includes Media Library preview) - based on this article: https://www.sitepoint.com/wordpress-svg/
 * Version:           1.0.0
 * Author:            Benchmark
 * Author URI:        https://benchmark.co.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       svg-media-library-support
 */


/**
 * Add SVG to allowed file uploads
 *
 * @param array $file_types
 * @return array
 */ 

function add_file_types_to_uploads( $file_types ) {
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge( $file_types, $new_filetypes );

    return $file_types;
}

add_action( 'upload_mimes', 'add_file_types_to_uploads' );


/**
 * Called via AJAX. returns the full URL of a media attachment (SVG) 
 *
 * @return void
 */

function get_attachment_url_media_library() {

    $url = '';
	$attachmentID = isset( $_REQUEST['attachmentID'] ) ? $_REQUEST['attachmentID'] : '';
	
    if ( $attachmentID ) {
        $url = wp_get_attachment_url( $attachmentID );
    }

    echo $url;
    die();
}

add_action( 'wp_ajax_svg_get_attachment_url', 'get_attachment_url_media_library' );


/**
 * Enqueue styles
 */

function svgmls_styles() {
	wp_enqueue_style( 'svgmls-styles', plugin_dir_url( __FILE__ ) . 'style.css', array(), '1.0.0', 'all' );
}

add_action( 'admin_enqueue_scripts', 'svgmls_styles' );


/** 
 * Enqueue scripts
 */

function svgmls_scripts() {
	wp_enqueue_script( 'svgmls-scripts', plugin_dir_url( __FILE__ ) . 'script.js', array( 'jquery' ), null, true );
}

add_action( 'admin_enqueue_scripts', 'svgmls_scripts' );