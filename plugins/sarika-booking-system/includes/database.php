<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function sbs_create_table() {
    global $wpdb;
    $table_name      = $wpdb->prefix . 'sbs_bookings';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id           INT          NOT NULL AUTO_INCREMENT,
        service      VARCHAR(100) NOT NULL,
        booking_date DATE         NOT NULL,
        booking_time VARCHAR(20)  NOT NULL,
        name         VARCHAR(100) NOT NULL,
        email        VARCHAR(100) NOT NULL,
        phone        VARCHAR(20)  NOT NULL,
        message      TEXT,
        status       VARCHAR(20)  DEFAULT 'pending',
        created_at   DATETIME     DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
}
