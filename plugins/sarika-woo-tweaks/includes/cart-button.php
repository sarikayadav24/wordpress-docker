<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Customize Add to Cart button text based on product type
 */
function swt_custom_cart_button_text( $text, $product ) {

    if ( ! $product ) {
        return $text;
    }

    // Out of stock
    if ( ! $product->is_in_stock() ) {
        return '⚠️ Out of Stock';
    }

    // By product type
    switch ( $product->get_type() ) {
        case 'simple':
            return '🛒 Add to Cart';

        case 'variable':
            return '🔍 Select Options';

        case 'grouped':
            return '👁️ View Products';

        case 'external':
            return '🔗 Buy Now';

        default:
            return '🛒 Add to Cart';
    }
}
add_filter( 'woocommerce_product_add_to_cart_text', 'swt_custom_cart_button_text', 10, 2 );
add_filter( 'woocommerce_product_single_add_to_cart_text', 'swt_custom_cart_button_text', 10, 2 );

/**
 * Add a low stock warning message on single product pages
 */
function swt_low_stock_notice() {
    global $product;

    if ( ! $product || ! $product->is_in_stock() ) {
        return;
    }

    $stock_quantity = $product->get_stock_quantity();

    // Show warning if stock is 5 or fewer
    if ( $stock_quantity !== null && $stock_quantity <= 5 && $stock_quantity > 0 ) {
        echo '<p class="swt-low-stock-notice">🔥 Only <strong>' . esc_html( $stock_quantity ) . '</strong> left in stock — order soon!</p>';
    }
}
add_action( 'woocommerce_single_product_summary', 'swt_low_stock_notice', 25 );
