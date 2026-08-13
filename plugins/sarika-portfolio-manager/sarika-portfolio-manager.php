<?php
/**
 * Plugin Name: Sarika Portfolio Manager
 * Plugin URI:  https://github.com/sarikayadav24/sarika-portfolio-manager
 * Description: Manages portfolio projects using a Custom Post Type with meta fields and shortcode display.
 * Version:     1.0.0
 * Author:      Sarika
 * License:     GPL2
 * Text Domain: sarika-portfolio-manager
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define constants
define( 'SPM_PATH', plugin_dir_path( __FILE__ ) );
define( 'SPM_URL',  plugin_dir_url( __FILE__ ) );

// Load all includes
require_once SPM_PATH . 'includes/cpt.php';
require_once SPM_PATH . 'includes/meta-boxes.php';
require_once SPM_PATH . 'includes/shortcode.php';
require_once SPM_PATH . 'includes/admin-columns.php';

// Enqueue frontend styles
function spm_enqueue_styles() {
    wp_enqueue_style(
        'spm-style',
        SPM_URL . 'assets/portfolio.css',
        array(),
        '1.0.0'
    );
}
add_action( 'wp_enqueue_scripts', 'spm_enqueue_styles' );
