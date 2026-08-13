<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Hide price and Add to Cart button for non-logged-in users
 * Show "Login to see price" message instead
 */

// Hide price for guests
function swt_hide_price_for_guests( $price, $product ) {
    if ( ! is_user_logged_in() ) {
        $login_url = wp_login_url( get_permalink() );
        return '<a href="' . esc_url( $login_url ) . '" class="swt-login-price">🔒 Login to see price</a>';
    }
    return $price;
}
add_filter( 'woocommerce_get_price_html', 'swt_hide_price_for_guests', 10, 2 );

// Hide Add to Cart button for guests on shop/archive pages
function swt_hide_cart_button_for_guests() {
    if ( ! is_user_logged_in() ) {
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
    }
}
add_action( 'woocommerce_before_shop_loop', 'swt_hide_cart_button_for_guests' );

// Replace Add to Cart button with login link on single product page for guests
function swt_replace_cart_button_for_guests() {
    if ( is_user_logged_in() ) {
        return;
    }

    // Remove default add to cart button
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

    // Add login message instead
    add_action( 'woocommerce_single_product_summary', function() {
        $login_url = wp_login_url( get_permalink() );
        echo '<div class="swt-login-to-buy">
            <p>🔒 Please <a href="' . esc_url( $login_url ) . '">login</a> to view the price and purchase this product.</p>
        </div>';
    }, 30 );
}
add_action( 'woocommerce_before_single_product', 'swt_replace_cart_button_for_guests' );
