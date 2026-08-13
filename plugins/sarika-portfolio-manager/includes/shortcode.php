<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders portfolio items in a grid
 * Shortcode: [sarika_portfolio]
 *
 * Supports attributes:
 * [sarika_portfolio count="6" type="plugin"]
 */
function spm_render_portfolio( $atts ) {

    // shortcode_atts() merges user-provided attributes with defaults
    // This means [sarika_portfolio count="3"] works
    $atts = shortcode_atts( array(
        'count' => 10,    // default: show 10 items
        'type'  => '',    // default: show all types
    ), $atts );

    // Build WP_Query arguments
    $args = array(
        'post_type'      => 'portfolio',
        'posts_per_page' => intval( $atts['count'] ),
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_status'    => 'publish',  // only show published items
    );

    // If type filter is set add a meta query
    // meta_query = filter posts by their custom field values
    if ( ! empty( $atts['type'] ) ) {
        $args['meta_query'] = array(
            array(
                'key'     => '_spm_project_type',          // meta key
                'value'   => sanitize_text_field( $atts['type'] ), // value to match
                'compare' => '=',                          // exact match
            )
        );
    }

    // Run the query
    $query = new WP_Query( $args );

    // Start capturing output
    ob_start();

    // Check if we have any posts
    if ( $query->have_posts() ) : ?>

        <div class="spm-portfolio-grid">

            <?php
            // The Loop — WordPress's way of iterating through posts
            while ( $query->have_posts() ) :
                $query->the_post();  // sets up global $post variable

                // Get this post's ID
                $post_id = get_the_ID();

                // Get custom meta fields for this post
                $project_url  = get_post_meta( $post_id, '_spm_project_url',  true );
                $github_url   = get_post_meta( $post_id, '_spm_github_url',   true );
                $technologies = get_post_meta( $post_id, '_spm_technologies', true );
                $project_type = get_post_meta( $post_id, '_spm_project_type', true );

                // Convert comma-separated technologies into an array
                // "PHP, WordPress, CSS" → array( 'PHP', 'WordPress', 'CSS' )
                $tech_array = ! empty( $technologies )
                    ? array_map( 'trim', explode( ',', $technologies ) )
                    : array();
            ?>

                <div class="spm-portfolio-card">

                    <!-- Featured Image -->
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="spm-card-image">
                            <?php the_post_thumbnail( 'medium' ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="spm-card-body">

                        <!-- Project Type Badge -->
                        <?php if ( $project_type ) : ?>
                            <span class="spm-type-badge">
                                <?php echo esc_html( ucfirst( $project_type ) ); ?>
                            </span>
                        <?php endif; ?>

                        <!-- Title -->
                        <h3 class="spm-card-title">
                            <?php the_title(); ?>
                        </h3>

                        <!-- Excerpt — short description -->
                        <?php if ( has_excerpt() ) : ?>
                            <p class="spm-card-excerpt">
                                <?php the_excerpt(); ?>
                            </p>
                        <?php endif; ?>

                        <!-- Technologies -->
                        <?php if ( ! empty( $tech_array ) ) : ?>
                            <div class="spm-tech-tags">
                                <?php foreach ( $tech_array as $tech ) : ?>
                                    <span class="spm-tech-tag">
                                        <?php echo esc_html( $tech ); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Links -->
                        <div class="spm-card-links">
                            <?php if ( $github_url ) : ?>
                                <a href="<?php echo esc_url( $github_url ); ?>"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="spm-btn spm-btn-github">
                                    GitHub
                                </a>
                            <?php endif; ?>

                            <?php if ( $project_url ) : ?>
                                <a href="<?php echo esc_url( $project_url ); ?>"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="spm-btn spm-btn-live">
                                    Live Demo
                                </a>
                            <?php endif; ?>
                        </div>

                    </div><!-- end .spm-card-body -->

                </div><!-- end .spm-portfolio-card -->

            <?php endwhile; ?>

        </div><!-- end .spm-portfolio-grid -->

    <?php else : ?>

        <p class="spm-no-projects">
            No portfolio projects found. Add some from the
            <a href="<?php echo admin_url('post-new.php?post_type=portfolio'); ?>">
                Portfolio admin panel
            </a>.
        </p>

    <?php
    endif;

    // IMPORTANT: Always reset post data after a custom WP_Query
    // This prevents conflicts with the main WordPress query
    wp_reset_postdata();

    return ob_get_clean();
}

// Register the shortcode
add_shortcode( 'sarika_portfolio', 'spm_render_portfolio' );
