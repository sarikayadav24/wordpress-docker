<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function sbs_handle_booking() {

    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'sbs_nonce' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed. Please refresh the page.' ) );
    }

    $service = sanitize_text_field( $_POST['service'] ?? '' );
    $date    = sanitize_text_field( $_POST['date']    ?? '' );
    $time    = sanitize_text_field( $_POST['time']    ?? '' );
    $name    = sanitize_text_field( $_POST['name']    ?? '' );
    $email   = sanitize_email(      $_POST['email']   ?? '' );
    $phone   = sanitize_text_field( $_POST['phone']   ?? '' );
    $message = sanitize_textarea_field( $_POST['message'] ?? '' );

    if ( empty( $service ) || empty( $date ) || empty( $time ) ||
         empty( $name ) || empty( $email ) || empty( $phone ) ) {
        wp_send_json_error( array( 'message' => 'Please fill in all required fields.' ) );
    }

    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Please enter a valid email address.' ) );
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'sbs_bookings';

    $inserted = $wpdb->insert(
        $table_name,
        array(
            'service'      => $service,
            'booking_date' => $date,
            'booking_time' => $time,
            'name'         => $name,
            'email'        => $email,
            'phone'        => $phone,
            'message'      => $message,
            'status'       => 'pending',
        ),
        array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' )
    );

    if ( ! $inserted ) {
        wp_send_json_error( array( 'message' => 'Could not save booking. Please try again.' ) );
    }

    $admin_email   = get_option( 'admin_email' );
    $admin_subject = 'New Booking Request: ' . $service;
    $admin_body    = "New booking received!\n\nService: $service\nDate: $date\nTime: $time\nName: $name\nEmail: $email\nPhone: $phone\nMessage: $message";
    wp_mail( $admin_email, $admin_subject, $admin_body );

    $user_subject = 'Booking Confirmed — ' . $service;
    $user_body    = "Hi $name,\n\nYour booking has been confirmed!\n\nService: $service\nDate: $date\nTime: $time\n\nThanks,\nSarika";
    wp_mail( $email, $user_subject, $user_body );

    wp_send_json_success( array( 'message' => 'Your booking has been confirmed!' ) );
}

add_action( 'wp_ajax_sbs_book',        'sbs_handle_booking' );
add_action( 'wp_ajax_nopriv_sbs_book', 'sbs_handle_booking' );
