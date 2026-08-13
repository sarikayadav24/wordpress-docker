<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register the meta box
 * This adds a custom box on the portfolio edit screen
 */
function spm_add_meta_box() {
    add_meta_box(
        'spm_project_details',       // unique ID for this meta box
        'Project Details',           // title shown on the box
        'spm_render_meta_box',       // function that renders the box content
        'portfolio',                 // which post type to show it on
        'normal',                    // position: normal, side, advanced
        'high'                       // priority: high, core, default, low
    );
}
add_action( 'add_meta_boxes', 'spm_add_meta_box' );

/**
 * Render the meta box HTML
 * This is what the admin sees when editing a portfolio item
 *
 * @param WP_Post $post — the current post object
 */
function spm_render_meta_box( $post ) {

    // get_post_meta( $post_id, $meta_key, $single )
    // $single = true means return a single value, not an array
    $project_url  = get_post_meta( $post->ID, '_spm_project_url',  true );
    $github_url   = get_post_meta( $post->ID, '_spm_github_url',   true );
    $technologies = get_post_meta( $post->ID, '_spm_technologies', true );
    $project_type = get_post_meta( $post->ID, '_spm_project_type', true );

    // Nonce field for security
    // This creates a hidden field WordPress uses to verify the form
    wp_nonce_field( 'spm_save_meta', 'spm_meta_nonce' );

    ?>
    <style>
        .spm-meta-table { width:100%; border-collapse:collapse; }
        .spm-meta-table tr td { padding: 10px 0; }
        .spm-meta-table label { font-weight: 600; display:block; margin-bottom:4px; }
        .spm-meta-table input,
        .spm-meta-table select { width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:4px; }
        .spm-meta-table .description { color:#666; font-size:0.8rem; margin-top:4px; }
    </style>

    <table class="spm-meta-table">

        <!-- Project URL -->
        <tr>
            <td>
                <label for="spm_project_url">🌐 Live Project URL</label>
                <input
                    type="url"
                    id="spm_project_url"
                    name="spm_project_url"
                    value="<?php echo esc_attr( $project_url ); ?>"
                    placeholder="https://example.com"
                >
                <p class="description">The live URL of the project (if available)</p>
            </td>
        </tr>

        <!-- GitHub URL -->
        <tr>
            <td>
                <label for="spm_github_url">🐙 GitHub URL</label>
                <input
                    type="url"
                    id="spm_github_url"
                    name="spm_github_url"
                    value="<?php echo esc_attr( $github_url ); ?>"
                    placeholder="https://github.com/sarikayadav24/project"
                >
                <p class="description">Link to the GitHub repository</p>
            </td>
        </tr>

        <!-- Technologies -->
        <tr>
            <td>
                <label for="spm_technologies">⚙️ Technologies Used</label>
                <input
                    type="text"
                    id="spm_technologies"
                    name="spm_technologies"
                    value="<?php echo esc_attr( $technologies ); ?>"
                    placeholder="PHP, WordPress, CSS, JavaScript"
                >
                <p class="description">Comma separated list of technologies</p>
            </td>
        </tr>

        <!-- Project Type -->
        <tr>
            <td>
                <label for="spm_project_type">📁 Project Type</label>
                <select id="spm_project_type" name="spm_project_type">
                    <option value="">— Select Type —</option>
                    <?php
                    $types = array(
                        'theme'      => 'WordPress Theme',
                        'plugin'     => 'WordPress Plugin',
                        'woocommerce'=> 'WooCommerce',
                        'website'    => 'Full Website',
                        'other'      => 'Other',
                    );

                    // Loop through types and mark selected one
                    foreach ( $types as $value => $label ) {
                        // selected() helper outputs selected="selected" if values match
                        echo '<option value="' . esc_attr( $value ) . '" '
                            . selected( $project_type, $value, false ) . '>'
                            . esc_html( $label )
                            . '</option>';
                    }
                    ?>
                </select>
                <p class="description">What type of project is this?</p>
            </td>
        </tr>

    </table>
    <?php
}

/**
 * Save meta box data when post is saved
 *
 * @param int $post_id — the ID of the post being saved
 */
function spm_save_meta_box( $post_id ) {

    // Verify nonce — security check
    if ( ! isset( $_POST['spm_meta_nonce'] ) ||
         ! wp_verify_nonce( $_POST['spm_meta_nonce'], 'spm_save_meta' ) ) {
        return;
    }

    // Don't save during autosave
    // WordPress autosaves drafts — we don't want to run our code then
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check user has permission to edit this post
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Save each field using update_post_meta()
    // update_post_meta( $post_id, $meta_key, $meta_value )
    // It creates the record if it doesn't exist, updates if it does

    if ( isset( $_POST['spm_project_url'] ) ) {
        update_post_meta(
            $post_id,
            '_spm_project_url',
            esc_url_raw( $_POST['spm_project_url'] )
        );
    }

    if ( isset( $_POST['spm_github_url'] ) ) {
        update_post_meta(
            $post_id,
            '_spm_github_url',
            esc_url_raw( $_POST['spm_github_url'] )
        );
    }

    if ( isset( $_POST['spm_technologies'] ) ) {
        update_post_meta(
            $post_id,
            '_spm_technologies',
            sanitize_text_field( $_POST['spm_technologies'] )
        );
    }

    if ( isset( $_POST['spm_project_type'] ) ) {
        update_post_meta(
            $post_id,
            '_spm_project_type',
            sanitize_text_field( $_POST['spm_project_type'] )
        );
    }
}

// save_post hook runs whenever a post is saved
add_action( 'save_post', 'spm_save_meta_box' );
