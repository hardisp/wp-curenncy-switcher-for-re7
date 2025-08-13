<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function re7mc_format_price( $price ) {
    $currency = re7mc_get_current_currency();
    $currencies = get_option( 're7mc_currencies', [] );

    if ( isset( $currencies[$currency] ) ) {
        $symbol = $currencies[$currency]['symbol'];
        $position = $currencies[$currency]['position'];
        $rate = isset($currencies[$currency]['rate']) ? floatval($currencies[$currency]['rate']) : 1;

        // Convert price
        $converted_price = $price * $rate;

        if ( $position === 'before' ) {
            return $symbol . number_format_i18n( $converted_price, 0 );
        } else {
            return number_format_i18n( $converted_price, 0 ) . $symbol;
        }
    }

    return number_format_i18n( $price, 0 );
}

function re7mc_enqueue_styles() {
    wp_enqueue_style(
        're7mc-public-style',
        plugin_dir_url( __FILE__ ) . 'css/style.css?v=1.24',
        [],
        '1.0'
    );
}
add_action( 'wp_enqueue_scripts', 're7mc_enqueue_styles' );

if ( ! function_exists( 'ct_listing_price' ) ) {
	function ct_listing_price( $echo = true ) {
		global $post;
		global $ct_options;

		$price = '';

		$ct_currency_placement = isset( $ct_options['ct_currency_placement'] ) ? esc_attr( $ct_options['ct_currency_placement'] ): '';
		$ct_currency_decimal   = isset( $ct_options['ct_currency_decimal'] ) ? esc_attr( $ct_options['ct_currency_decimal'] ) : '';

		$price_prefix  = get_post_meta( get_the_ID(), '_ct_price_prefix', true );
		$price_postfix = get_post_meta( get_the_ID(), '_ct_price_postfix', true );

		$price_meta = get_post_meta( get_the_ID(), '_ct_price', true );
		$price_meta = preg_replace( '/[\$,]/', '', $price_meta );
		$price_meta = floatval( $price_meta ); // ensure numeric

		$ct_display_listing_price = get_post_meta( get_the_ID(), '_ct_display_listing_price', true );

		if ( $price_meta == 0 || $price_meta == '' ) {
			$price = '';
		} else {
			// Apply RE7 multi-currency formatting
			$converted_price = re7mc_format_price( $price_meta );

			if ( $ct_currency_placement === 'after' ) {
				if ( ! empty( $price_prefix ) ) {
					$price .= "<span class='listing-price-prefix'>" . esc_html( $price_prefix ) . ' </span>';
				}
				if ( ! empty( $price_meta ) && $ct_display_listing_price !== 'no' ) {
					$price .= "<span class='listing-price'>" . $converted_price . "</span>";
				}
				if ( ! empty( $price_postfix ) ) {
					$price .= "<span class='listing-price-postfix'> " . esc_html( $price_postfix ) . "</span>";
				}
			} else {
				if ( ! empty( $price_prefix ) ) {
					$price .= "<span class='listing-price-prefix'>" . esc_html( $price_prefix ) . ' </span>';
				}
				if ( ! empty( $price_meta ) && $ct_display_listing_price !== 'no' ) {
					$price .= "<span class='listing-price'>" . $converted_price . "</span>";
				}
				if ( ! empty( $price_postfix ) ) {
					$price .= "<span class='listing-price-postfix'> " . esc_html( $price_postfix ) . "</span>";
				}
			}
		}

		if ( $echo ) {
			echo ct_sanitize_output( $price );
		} else {
			return $price;
		}
	}
}


function ct_listing_price_switched($listingID)
{
	if (empty($listingID)) {
		$listingID = get_the_ID();
	}

	$price = '';

	$price_meta = get_post_meta($listingID, '_ct_price', true); 

	if ($price_meta == '0' || $price_meta == '') {
		$price = 'Contact For Price';
	} else {
        $price = re7mc_format_price( $price_meta );

	}

	return $price;

}

function re7mc_enqueue_currency_script() {
    wp_enqueue_script(
        're7mc-currency-sync',
        plugin_dir_url( __FILE__ ) . '/switcher.js',
        array(), // no dependencies
        null,    // no version (or add your own)
        true     // load in footer
    );
}
add_action( 'wp_enqueue_scripts', 're7mc_enqueue_currency_script' );

function re7mc_activate() {
    if ( false === get_option( 're7mc_enable_dropdown' ) ) {
        update_option( 're7mc_enable_dropdown', 1 );
    }
    // also initialize currencies here if needed
}
register_activation_hook( __FILE__, 're7mc_activate' );
function re7mc_add_euro_currency() {
    $currencies = get_option('re7mc_currencies', []);

    // Add EUR only if it doesn't exist yet
    if ( ! isset( $currencies['EUR'] ) ) {
        $currencies['EUR'] = [
            'symbol' => '€',
            'position' => 'before',
            'enabled' => 1,
            'rate' => 0.91,
        ];

        update_option('re7mc_currencies', $currencies);
    }
}
register_activation_hook( __FILE__, 're7mc_add_euro_currency' );
add_action('admin_init', 're7mc_add_euro_currency');