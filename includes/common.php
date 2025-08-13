<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function re7mc_get_normalized_currencies() {
    $currencies = get_option( 're7mc_currencies', [] );
    $normalized = [];
    foreach ( $currencies as $code => $data ) {
        $normalized[$code] = [
            'symbol'   => isset( $data['symbol'] ) ? $data['symbol'] : '',
            'position' => isset( $data['position'] ) ? $data['position'] : 'before',
            'enabled'  => isset( $data['enabled'] ) ? (bool) $data['enabled'] : false
        ];
    }
    return $normalized;
}


function re7mc_set_currency_cookie() {
    if ( isset( $_GET['currency'] ) ) {
        $currency = sanitize_text_field( $_GET['currency'] );

        // Set cookie for 30 days
        setcookie( 're7mc_currency', $currency, time() + 30 * DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );

        // Also update global or transient to use it immediately if needed
        $_COOKIE['re7mc_currency'] = $currency;
    }
}
add_action( 'init', 're7mc_set_currency_cookie' );

function re7mc_get_current_currency() {
    // Priority: GET param > Cookie > Default currency
    if ( isset( $_GET['currency'] ) ) {
        return sanitize_text_field( $_GET['currency'] );
    }
    if ( isset( $_COOKIE['re7mc_currency'] ) ) {
        return sanitize_text_field( $_COOKIE['re7mc_currency'] );
    }
    // Fallback default currency
    return 'USD';
}
