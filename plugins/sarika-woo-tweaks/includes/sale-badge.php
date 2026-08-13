<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Replace default "Sale!" badge with "X% OFF" calculated automatically
 */
function swt_custom_sale_badge( $html, $post, $product ) {

    if ( ! $product->is_on_sale() ) {
        return $html;
    }

    $percentage = '';

    // Calculate discount percentage for simple products
    if ( $product->is_type( 'simple' ) ) {
        $regular_price = (float) $product->get_regular_price();
        $sale_price    = (float) $product->get_sale_price();

        if ( $regular_price > 0 && $sale_price > 0 ) {
            $percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
        }
    }

    // Calculate discount for variable products (use highest discount)
    if ( $product->is_type( 'variable' ) ) {
        $max_percent = 0;

        foreach ( $product->get_children() as $child_id ) {
            $variation     = wc_get_product( $child_id );
            $regular_price = (float) $variation->get_regular_price();
            $sale_price    = (float) $variation->get_sale_price();

            if ( $regular_price > 0 && $sale_price > 0 ) {
                $percent     = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
                $max_percent = max( $max_percent, $percent );
            }
        }

        $percentage = $max_percent > 0 ? $max_percent : '';
    }

    // Build the badge
    if ( $percentage ) {
        return '<span class="swt-sale-badge">-' . $percentage . '% OFF</span>';
    }

    return '<span class="swt-sale-badge">Sale!</span>';
}
add_filter( 'woocommerce_sale_flash', 'swt_custom_sale_badge', 10, 3 );
