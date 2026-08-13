<?php
/**
 * Plugin Name: Sarika Booking System
 * Plugin URI:  https://github.com/sarikayadav24/sarika-booking-system
 * Description: A multi-step appointment booking plugin with admin management panel.
 * Version:     1.0.0
 * Author:      Sarika
 * License:     GPL2
 * Text Domain: sarika-booking-system
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define constants
define( 'SBS_PATH', plugin_dir_path( __FILE__ ) );
define( 'SBS_URL',  plugin_dir_url( __FILE__ ) );

// Load all our include files
require_once SBS_PATH . 'includes/database.php';
require_once SBS_PATH . 'includes/shortcode.php';
require_once SBS_PATH . 'includes/ajax-handler.php';
require_once SBS_PATH . 'includes/admin-page.php';

// Run database setup when plugin is activated
register_activation_hook( __FILE__, 'sbs_create_table' );

// Enqueue our CSS and JS files on the frontend
function sbs_enqueue_assets() {
    wp_enqueue_style(
        'sbs-style',
        SBS_URL . 'assets/booking.css',
        array(),
        '1.0.0'
    );

    wp_enqueue_script(
        'sbs-script',
        SBS_URL . 'assets/booking.js',
        array(),
        '1.0.0',
        true
    );

    // Pass PHP data to JavaScript
    wp_localize_script( 'sbs-script', 'sbsData', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'sbs_nonce' ),
    ));
}
add_action( 'wp_enqueue_scripts', 'sbs_enqueue_assets' );
