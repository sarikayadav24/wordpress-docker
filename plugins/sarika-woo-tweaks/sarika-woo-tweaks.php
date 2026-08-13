<?php
/**
 * Plugin Name: Sarika WooCommerce Tweaks
 * Plugin URI:  https://github.com/sarikayadav24/sarika-woo-tweaks
 * Description: Custom WooCommerce tweaks — sale badge, cart button text, product notice, and login to see price.
 * Version:     1.0.0
 * Author:      Sarika
 * License:     GPL2
 * Text Domain: sarika-woo-tweaks
 * Requires Plugins: woocommerce
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Check WooCommerce is active before loading
function swt_init() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        add_action( 'admin_notices', function() {
            echo '<div class="notice notice-error"><p><strong>Sarika WooCommerce Tweaks</strong> requires WooCommerce to be installed and active.</p></div>';
        });
        return;
    }

    // Load all tweaks
    require_once plugin_dir_path( __FILE__ ) . 'includes/sale-badge.php';
    require_once plugin_dir_path( __FILE__ ) . 'includes/cart-button.php';
    require_once plugin_dir_path( __FILE__ ) . 'includes/product-notice.php';
    require_once plugin_dir_path( __FILE__ ) . 'includes/price-login.php';

    // Enqueue styles
    add_action( 'wp_enqueue_scripts', function() {
        wp_enqueue_style( 'swt-style', plugin_dir_url( __FILE__ ) . 'assets/woo-tweaks.css', array(), '1.0.0' );
    });
}
add_action( 'plugins_loaded', 'swt_init' );
