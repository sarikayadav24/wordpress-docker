<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Show a delivery/shipping info notice on all single product pages
 */
function swt_product_delivery_notice() {
    echo '
    <div class="swt-delivery-notice">
        <ul>
            <li>🚚 <strong>Free shipping</strong> on orders over $50</li>
            <li>↩️ <strong>Easy returns</strong> within 30 days</li>
            <li>🔒 <strong>Secure checkout</strong> — SSL encrypted</li>
            <li>📦 <strong>Fast dispatch</strong> — ships within 24 hours</li>
        </ul>
    </div>
    ';
}
add_action( 'woocommerce_single_product_summary', 'swt_product_delivery_notice', 35 );

/**
 * Show a notice on the cart page if cart total is below free shipping threshold
 */
function swt_cart_free_shipping_notice() {
    $threshold   = 50;
    $cart_total  = WC()->cart->get_subtotal();
    $remaining   = $threshold - $cart_total;

    if ( $remaining > 0 ) {
        echo '<div class="swt-cart-notice">
            🛒 Add <strong>' . wc_price( $remaining ) . '</strong> more to get <strong>FREE shipping!</strong>
        </div>';
    } else {
        echo '<div class="swt-cart-notice swt-cart-notice--success">
            ✅ You qualify for <strong>FREE shipping!</strong>
        </div>';
    }
}
add_action( 'woocommerce_before_cart_table', 'swt_cart_free_shipping_notice' );
