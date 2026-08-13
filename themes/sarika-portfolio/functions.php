<?php

// Theme Setup
function sarika_theme_setup() {
    // Title tag support
    add_theme_support( 'title-tag' );

    // Featured images
    add_theme_support( 'post-thumbnails' );

    // HTML5 support
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ) );

    // Register navigation menu
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'sarika-portfolio' ),
    ) );
    // WooCommerce support
add_theme_support( 'woocommerce' );

}
add_action( 'after_setup_theme', 'sarika_theme_setup' );

// Enqueue Styles and Scripts
function sarika_enqueue_assets() {
    // Main stylesheet
    wp_enqueue_style( 'sarika-style', get_stylesheet_uri(), array(), '1.0.0' );

    // Main CSS
    wp_enqueue_style( 'sarika-main-css', get_template_directory_uri() . '/main.css', array(), '1.0.0' );

    // Google Fonts
    wp_enqueue_style( 'sarika-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap', array(), null );

    // Main JS
    wp_enqueue_script( 'sarika-main-js', get_template_directory_uri() . '/main.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'sarika_enqueue_assets' );
