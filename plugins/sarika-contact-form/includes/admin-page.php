<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Add menu item in WordPress admin
function scf_add_admin_menu() {
    add_menu_page(
        'Contact Messages',        // Page title
        'Contact Messages',        // Menu title
        'manage_options',          // Capability required
        'scf-messages',            // Menu slug
        'scf_render_admin_page',   // Callback function
        'dashicons-email-alt',     // Icon
        30                         // Position
    );
}
add_action( 'admin_menu', 'scf_add_admin_menu' );

// Render the admin page
function scf_render_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'scf_messages';

    // Handle mark as read
    if ( isset( $_GET['mark_read'] ) && is_numeric( $_GET['mark_read'] ) ) {
        $wpdb->update( $table_name, array( 'is_read' => 1 ), array( 'id' => intval( $_GET['mark_read'] ) ) );
    }

    // Handle delete message
    if ( isset( $_GET['delete_msg'] ) && is_numeric( $_GET['delete_msg'] ) ) {
        $wpdb->delete( $table_name, array( 'id' => intval( $_GET['delete_msg'] ) ) );
    }

    // Fetch all messages newest first
    $messages = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY submitted_at DESC" );
    $total    = count( $messages );
    $unread   = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE is_read = 0" );
    ?>

    <div class="wrap">
        <h1>📬 Contact Messages</h1>
        <p>Total: <strong><?php echo $total; ?></strong> &nbsp;|&nbsp; Unread: <strong style="color:#d63638;"><?php echo $unread; ?></strong></p>

        <?php if ( empty( $messages ) ) : ?>
            <p>No messages yet.</p>
        <?php else : ?>
            <table class="widefat fixed striped" style="margin-top:16px;">
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $messages as $msg ) : ?>
                        <tr style="<?php echo $msg->is_read ? '' : 'font-weight:bold; background:#fff8e1;'; ?>">
                            <td><?php echo esc_html( $msg->id ); ?></td>
                            <td><?php echo esc_html( $msg->name ); ?></td>
                            <td><a href="mailto:<?php echo esc_attr( $msg->email ); ?>"><?php echo esc_html( $msg->email ); ?></a></td>
                            <td><?php echo esc_html( $msg->subject ); ?></td>
                            <td><?php echo nl2br( esc_html( $msg->message ) ); ?></td>
                            <td><?php echo esc_html( $msg->submitted_at ); ?></td>
                            <td><?php echo $msg->is_read ? '<span style="color:green;">Read</span>' : '<span style="color:red;">Unread</span>'; ?></td>
                            <td>
                                <?php if ( ! $msg->is_read ) : ?>
                                    <a href="<?php echo esc_url( add_query_arg( array( 'page' => 'scf-messages', 'mark_read' => $msg->id ), admin_url( 'admin.php' ) ) ); ?>" class="button button-small">Mark Read</a>
                                    &nbsp;
                                <?php endif; ?>
                                <a href="<?php echo esc_url( add_query_arg( array( 'page' => 'scf-messages', 'delete_msg' => $msg->id ), admin_url( 'admin.php' ) ) ); ?>" class="button button-small button-link-delete" onclick="return confirm('Are you sure you want to delete this message?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <?php
}
