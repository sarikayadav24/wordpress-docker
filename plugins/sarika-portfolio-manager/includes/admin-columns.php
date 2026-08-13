<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add custom columns to the Portfolio admin list
 *
 * @param array $columns — existing columns
 * @return array — modified columns
 */
function spm_add_admin_columns( $columns ) {

    // Start with an empty array
    $new_columns = array();

    // Add checkbox column first (WordPress requires this)
    $new_columns['cb'] = $columns['cb'];

    // Add thumbnail column
    $new_columns['thumbnail'] = 'Thumbnail';

    // Add title column
    $new_columns['title'] = 'Project Title';

    // Add our custom columns
    $new_columns['project_type']  = 'Type';
    $new_columns['technologies']  = 'Technologies';
    $new_columns['github_url']    = 'GitHub';
    $new_columns['project_url']   = 'Live URL';

    // Add date column last
    $new_columns['date'] = 'Date';

    return $new_columns;
}

// manage_{post_type}_posts_columns filter
// The {post_type} part is replaced with our CPT name "portfolio"
add_filter( 'manage_portfolio_posts_columns', 'spm_add_admin_columns' );

/**
 * Fill in the custom column values for each row
 *
 * @param string $column  — current column name
 * @param int    $post_id — current post ID
 */
function spm_fill_admin_columns( $column, $post_id ) {

    // Switch statement — runs different code based on column name
    switch ( $column ) {

        case 'thumbnail':
            // Show featured image thumbnail
            if ( has_post_thumbnail( $post_id ) ) {
                echo get_the_post_thumbnail( $post_id, array( 60, 60 ) );
            } else {
                echo '<span style="color:#999;">No image</span>';
            }
            break;

        case 'project_type':
            $type = get_post_meta( $post_id, '_spm_project_type', true );
            if ( $type ) {
                // Show colored badge based on type
                $colors = array(
                    'theme'       => '#6c63ff',
                    'plugin'      => '#22c55e',
                    'woocommerce' => '#96588a',
                    'website'     => '#f59e0b',
                    'other'       => '#64748b',
                );
                $color = $colors[ $type ] ?? '#64748b';
                echo '<span style="background:' . $color . ';color:white;padding:3px 10px;border-radius:20px;font-size:0.8rem;">'
                    . esc_html( ucfirst( $type ) )
                    . '</span>';
            } else {
                echo '—';
            }
            break;

        case 'technologies':
            $tech = get_post_meta( $post_id, '_spm_technologies', true );
            if ( $tech ) {
                // Split by comma and show each as a small tag
                $tech_array = array_map( 'trim', explode( ',', $tech ) );
                foreach ( $tech_array as $t ) {
                    echo '<span style="background:#f0f0f0;color:#333;padding:2px 8px;border-radius:4px;font-size:0.75rem;margin:2px;display:inline-block;">'
                        . esc_html( $t )
                        . '</span>';
                }
            } else {
                echo '—';
            }
            break;

        case 'github_url':
            $url = get_post_meta( $post_id, '_spm_github_url', true );
            if ( $url ) {
                echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer">View →</a>';
            } else {
                echo '—';
            }
            break;

        case 'project_url':
            $url = get_post_meta( $post_id, '_spm_project_url', true );
            if ( $url ) {
                echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer">View →</a>';
            } else {
                echo '—';
            }
            break;
    }
}

// manage_{post_type}_posts_custom_column action
add_action( 'manage_portfolio_posts_custom_column', 'spm_fill_admin_columns', 10, 2 );

/**
 * Make Type and Date columns sortable
 */
function spm_sortable_columns( $columns ) {
    $columns['project_type'] = 'project_type';
    $columns['date']         = 'date';
    return $columns;
}

add_filter( 'manage_edit-portfolio_sortable_columns', 'spm_sortable_columns' );
