<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register the Portfolio Custom Post Type
 */
function spm_register_portfolio_cpt() {

    // Labels = text shown in WordPress admin for this post type
    $labels = array(
        'name'               => 'Portfolio',           // menu label
        'singular_name'      => 'Portfolio Item',      // single item label
        'add_new'            => 'Add New Project',     // add new button
        'add_new_item'       => 'Add New Project',     // add new page title
        'edit_item'          => 'Edit Project',        // edit page title
        'new_item'           => 'New Project',
        'view_item'          => 'View Project',
        'search_items'       => 'Search Projects',
        'not_found'          => 'No projects found',
        'not_found_in_trash' => 'No projects in trash',
        'menu_name'          => 'Portfolio',           // sidebar menu label
    );

    // Args = settings for this post type
    $args = array(
        'labels'             => $labels,
        'public'             => true,         // visible on frontend
        'show_in_menu'       => true,         // show in admin sidebar
        'menu_position'      => 20,           // position in sidebar
        'menu_icon'          => 'dashicons-portfolio', // icon
        'supports'           => array(
            'title',          // project title field
            'editor',         // content editor
            'thumbnail',      // featured image
        ),
        'has_archive'        => true,         // enable archive page
        'rewrite'            => array(
            'slug' => 'portfolio'             // URL: /portfolio/project-name
        ),
    );

    // register_post_type( $post_type_name, $args )
    register_post_type( 'portfolio', $args );
}

// Hook into WordPress init — runs when WordPress loads
add_action( 'init', 'spm_register_portfolio_cpt' );

/**
 * Register a Portfolio Category Taxonomy
 * Taxonomy = a way to group/categorize post types
 * Just like Post Categories but for Portfolio
 */
function spm_register_portfolio_taxonomy() {

    $labels = array(
        'name'          => 'Project Categories',
        'singular_name' => 'Project Category',
        'add_new_item'  => 'Add New Category',
        'edit_item'     => 'Edit Category',
        'search_items'  => 'Search Categories',
    );

    $args = array(
        'labels'       => $labels,
        'hierarchical' => true,    // true = like categories, false = like tags
        'public'       => true,
        'rewrite'      => array( 'slug' => 'portfolio-category' ),
    );

    // register_taxonomy( $taxonomy_name, $post_type, $args )
    register_taxonomy( 'portfolio_category', 'portfolio', $args );
}

add_action( 'init', 'spm_register_portfolio_taxonomy' );
