<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register the shortcode [sarika_contact_form]
function scf_render_form( $atts ) {
    // Check if form was just submitted and show message
    $success = isset( $_GET['scf_sent'] ) && $_GET['scf_sent'] === '1';
    $error   = isset( $_GET['scf_error'] ) ? sanitize_text_field( $_GET['scf_error'] ) : '';

    ob_start();
    ?>

    <div class="scf-wrapper">

        <?php if ( $success ) : ?>
            <div class="scf-alert scf-success">
                ✅ Thank you! Your message has been sent successfully.
            </div>
        <?php endif; ?>

        <?php if ( $error ) : ?>
            <div class="scf-alert scf-error">
                ❌ <?php echo esc_html( $error ); ?>
            </div>
        <?php endif; ?>

        <form class="scf-form" method="POST" action="">
            <?php wp_nonce_field( 'scf_submit_form', 'scf_nonce' ); ?>
            <input type="hidden" name="scf_action" value="submit">

            <div class="scf-field">
                <label for="scf_name">Your Name <span>*</span></label>
                <input type="text" id="scf_name" name="scf_name" placeholder="Enter your name" required>
            </div>

            <div class="scf-field">
                <label for="scf_email">Email Address <span>*</span></label>
                <input type="email" id="scf_email" name="scf_email" placeholder="Enter your email" required>
            </div>

            <div class="scf-field">
                <label for="scf_subject">Subject <span>*</span></label>
                <input type="text" id="scf_subject" name="scf_subject" placeholder="What is this about?" required>
            </div>

            <div class="scf-field">
                <label for="scf_message">Message <span>*</span></label>
                <textarea id="scf_message" name="scf_message" rows="6" placeholder="Write your message here..." required></textarea>
            </div>

            <div class="scf-field">
                <button type="submit" class="scf-submit">Send Message</button>
            </div>

        </form>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode( 'sarika_contact_form', 'scf_render_form' );
