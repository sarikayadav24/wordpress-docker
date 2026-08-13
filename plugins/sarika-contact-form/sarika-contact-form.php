<?php
/**
 * Plugin Name: Sarika Contact Form
 * Plugin URI:  https://github.com/sarikayadav24/sarika-contact-form
 * Description: A custom contact form plugin that saves messages to the database and notifies via email.
 * Version:     1.0.0
 * Author:      Sarika
 * License:     GPL2
 * Text Domain: sarika-contact-form
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin constants
define( 'SCF_PATH', plugin_dir_path( __FILE__ ) );
define( 'SCF_URL', plugin_dir_url( __FILE__ ) );

// Include required files
require_once SCF_PATH . 'includes/form-handler.php';
require_once SCF_PATH . 'includes/shortcode.php';
require_once SCF_PATH . 'includes/admin-page.php';

// Create database table on plugin activation
function scf_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'scf_messages';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        subject VARCHAR(200) NOT NULL,
        message TEXT NOT NULL,
        submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        is_read TINYINT(1) DEFAULT 0,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
}
register_activation_hook( __FILE__, 'scf_create_table' );

// Enqueue plugin styles
function scf_enqueue_styles() {
    wp_enqueue_style( 'scf-style', SCF_URL . 'assets/contact-form.css', array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'scf_enqueue_styles' );
