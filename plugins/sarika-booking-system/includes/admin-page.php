<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function sbs_add_admin_menu() {
    add_menu_page(
        'Sarika Bookings',
        'Bookings',
        'manage_options',
        'sbs-bookings',
        'sbs_render_admin_page',
        'dashicons-calendar-alt',
        25
    );
}
add_action( 'admin_menu', 'sbs_add_admin_menu' );

function sbs_handle_status_update() {
    if ( ! isset( $_GET['sbs_update_status'] ) ) { return; }
    $id      = intval( $_GET['booking_id'] );
    $status  = sanitize_text_field( $_GET['sbs_update_status'] );
    $allowed = array( 'pending', 'confirmed', 'cancelled' );
    if ( ! in_array( $status, $allowed ) ) { return; }
    global $wpdb;
    $wpdb->update( $wpdb->prefix . 'sbs_bookings', array( 'status' => $status ), array( 'id' => $id ), array( '%s' ), array( '%d' ) );
}
add_action( 'admin_init', 'sbs_handle_status_update' );

function sbs_render_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sbs_bookings';

    if ( isset( $_GET['sbs_delete'] ) && is_numeric( $_GET['sbs_delete'] ) ) {
        $wpdb->delete( $table_name, array( 'id' => intval( $_GET['sbs_delete'] ) ) );
    }

    $bookings  = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY created_at DESC" );
    $total     = count( $bookings );
    $pending   = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status='pending'" );
    $confirmed = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status='confirmed'" );
    $cancelled = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status='cancelled'" );
    ?>
    <div class="wrap">
        <h1>📅 Booking Management</h1>
        <div style="display:flex;gap:16px;margin:20px 0;flex-wrap:wrap;">
            <div style="background:#fff;padding:16px 24px;border-radius:8px;border-left:4px solid #6c63ff;min-width:120px;">
                <div style="font-size:1.8rem;font-weight:700;color:#6c63ff;"><?php echo $total; ?></div>
                <div style="color:#666;font-size:0.85rem;">Total</div>
            </div>
            <div style="background:#fff;padding:16px 24px;border-radius:8px;border-left:4px solid #f59e0b;min-width:120px;">
                <div style="font-size:1.8rem;font-weight:700;color:#f59e0b;"><?php echo $pending; ?></div>
                <div style="color:#666;font-size:0.85rem;">Pending</div>
            </div>
            <div style="background:#fff;padding:16px 24px;border-radius:8px;border-left:4px solid #22c55e;min-width:120px;">
                <div style="font-size:1.8rem;font-weight:700;color:#22c55e;"><?php echo $confirmed; ?></div>
                <div style="color:#666;font-size:0.85rem;">Confirmed</div>
            </div>
            <div style="background:#fff;padding:16px 24px;border-radius:8px;border-left:4px solid #ef4444;min-width:120px;">
                <div style="font-size:1.8rem;font-weight:700;color:#ef4444;"><?php echo $cancelled; ?></div>
                <div style="color:#666;font-size:0.85rem;">Cancelled</div>
            </div>
        </div>

        <?php if ( empty( $bookings ) ) : ?>
            <p>No bookings yet. Add <code>[sarika_booking]</code> shortcode to a page.</p>
        <?php else : ?>
        <table class="widefat fixed striped" style="margin-top:8px;">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $bookings as $booking ) : ?>
                <tr>
                    <td><?php echo esc_html( $booking->id ); ?></td>
                    <td><?php echo esc_html( $booking->service ); ?></td>
                    <td><?php echo esc_html( $booking->booking_date ); ?></td>
                    <td><?php echo esc_html( $booking->booking_time ); ?></td>
                    <td><?php echo esc_html( $booking->name ); ?></td>
                    <td><a href="mailto:<?php echo esc_attr( $booking->email ); ?>"><?php echo esc_html( $booking->email ); ?></a></td>
                    <td><?php echo esc_html( $booking->phone ); ?></td>
                    <td>
                        <?php
                        $colors = array( 'pending' => '#f59e0b', 'confirmed' => '#22c55e', 'cancelled' => '#ef4444' );
                        $color  = $colors[ $booking->status ] ?? '#999';
                        ?>
                        <span style="background:<?php echo $color; ?>;color:white;padding:3px 10px;border-radius:20px;font-size:0.8rem;">
                            <?php echo ucfirst( esc_html( $booking->status ) ); ?>
                        </span>
                    </td>
                    <td>
                        <?php if ( $booking->status !== 'confirmed' ) : ?>
                        <a href="<?php echo esc_url( add_query_arg( array( 'page' => 'sbs-bookings', 'sbs_update_status' => 'confirmed', 'booking_id' => $booking->id ), admin_url('admin.php') ) ); ?>" class="button button-small" style="color:#22c55e;">✅ Confirm</a>
                        <?php endif; ?>
                        <?php if ( $booking->status !== 'cancelled' ) : ?>
                        <a href="<?php echo esc_url( add_query_arg( array( 'page' => 'sbs-bookings', 'sbs_update_status' => 'cancelled', 'booking_id' => $booking->id ), admin_url('admin.php') ) ); ?>" class="button button-small" style="color:#ef4444;">❌ Cancel</a>
                        <?php endif; ?>
                        <a href="<?php echo esc_url( add_query_arg( array( 'page' => 'sbs-bookings', 'sbs_delete' => $booking->id ), admin_url('admin.php') ) ); ?>" class="button button-small button-link-delete" onclick="return confirm('Delete this booking?')">🗑️ Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    <?php
}
