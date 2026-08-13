<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Handle form submission
function scf_handle_submission() {

    // Only run if our form was submitted
    if ( ! isset( $_POST['scf_action'] ) || $_POST['scf_action'] !== 'submit' ) {
        return;
    }

    // Verify nonce for security
    if ( ! isset( $_POST['scf_nonce'] ) || ! wp_verify_nonce( $_POST['scf_nonce'], 'scf_submit_form' ) ) {
        wp_redirect( add_query_arg( 'scf_error', 'Security check failed. Please try again.', wp_get_referer() ) );
        exit;
    }

    // Sanitize and validate inputs
    $name    = sanitize_text_field( $_POST['scf_name'] ?? '' );
    $email   = sanitize_email( $_POST['scf_email'] ?? '' );
    $subject = sanitize_text_field( $_POST['scf_subject'] ?? '' );
    $message = sanitize_textarea_field( $_POST['scf_message'] ?? '' );

    // Check required fields
    if ( empty( $name ) || empty( $email ) || empty( $subject ) || empty( $message ) ) {
        wp_redirect( add_query_arg( 'scf_error', 'All fields are required.', wp_get_referer() ) );
        exit;
    }

    // Validate email format
    if ( ! is_email( $email ) ) {
        wp_redirect( add_query_arg( 'scf_error', 'Please enter a valid email address.', wp_get_referer() ) );
        exit;
    }

    // Save to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'scf_messages';

    $inserted = $wpdb->insert(
        $table_name,
        array(
            'name'    => $name,
            'email'   => $email,
            'subject' => $subject,
            'message' => $message,
        ),
        array( '%s', '%s', '%s', '%s' )
    );

    if ( ! $inserted ) {
        wp_redirect( add_query_arg( 'scf_error', 'Could not save your message. Please try again.', wp_get_referer() ) );
        exit;
    }

    // Send email notification to admin
    $admin_email = get_option( 'admin_email' );
    $email_subject = 'New Contact Form Message: ' . $subject;
    $email_body  = "You received a new message from your portfolio contact form.\n\n";
    $email_body .= "Name: " . $name . "\n";
    $email_body .= "Email: " . $email . "\n";
    $email_body .= "Subject: " . $subject . "\n\n";
    $email_body .= "Message:\n" . $message . "\n";

    $headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

    wp_mail( $admin_email, $email_subject, $email_body, $headers );

    // Redirect with success message
    wp_redirect( add_query_arg( 'scf_sent', '1', wp_get_referer() ) );
    exit;
}
add_action( 'init', 'scf_handle_submission' );
