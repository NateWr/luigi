<?php
/**
 * Functions used to integrate with the Typecase plugin
 *
 * @package    luigi
 */

if ( !function_exists( 'luigi_typecase_get_alt_font_selector' ) ) {
	/**
	 * CSS selectors for text styled with the accent font
	 *
	 * @since 0.1
	 */
	function luigi_typecase_get_alt_font_selector() {

		$selectors = array(
			'.site-header .home-link',
			'.site-footer .home-link',
			'.clc-component-layout .title_line_one',
		);

		return join( ',', apply_filters( 'luigi_typecase_alt_font', $selectors ) );
	}
}

if ( !function_exists( 'luigi_typecase_get_settings' ) ) {
	/**
	 * Retrieve settings array for Typecase support
	 *
	 * @since 0.1
	 */
	function luigi_typecase_get_settings() {

		$args = array(
			'simple' => array(
				array(
					'label' => esc_html__( 'Base Font', 'luigi' ),
					'selector' => join( ',', apply_filters( 'luigi_typecase_base_font', array( 'html', 'body' ) ) ),
					'default' => '"Open Sans", "Trebuchet MS", Helvetica, Arial, sans-serif'
				),
				array(
					'label' => esc_html__( 'Accent Font', 'luigi' ),
					'selector' => luigi_typecase_get_alt_font_selector(),
					'default' => '"Bilbo Swash Caps", "Palatino Linotype", "Book Antiqua", Palatino, "Times New Roman", serif'
				),
			)
		);

		return apply_filters( 'luigi_typecase_settings', $args );
	}
}

if ( !function_exists( 'luigi_typecase_dequeue_default_fonts' ) ) {
	/**
	 * Dequeue default fonts if they're overridden by typecase
	 *
	 * @since 0.1
	 */
	function luigi_typecase_dequeue_default_fonts() {

		$font_locations = get_theme_support( 'typecase' );

		if ( empty( $font_locations ) || !is_array( $font_locations ) || empty( $font_locations[0] ) ) {
			return;
		}

		$fonts = get_option( 'typecase_fonts' );

		if ( empty( $fonts ) ) {
			return;
		}

		$load_open_sans = true;
		$load_bilbo = true;
		foreach( $font_locations[0]['simple'] as $font_location ) {

			$slug = sanitize_title( $font_location['label'] );
			$font = get_theme_mod( $slug, $font_location['default'] );

			if ( empty( $font ) || $font == $font_location['default'] ) {
				continue;
			}

			if ( $font_location['default'] == '"Open Sans", "Trebuchet MS", Helvetica, Arial, sans-serif' ) {
				$load_open_sans = false;
			} elseif ( $font_location['default'] == '"Bilbo Swash Caps", "Palatino Linotype", "Book Antiqua", Palatino, "Times New Roman", serif' ) {
				$load_bilbo = false;
			}
		}

		if ( $load_open_sans && $load_bilbo ) {
			return;
		}

		if ( !$load_open_sans && !$load_bilbo ) {
			add_filter( 'luigi_font_uri', 'luigi_font_uri_empty' );
		} elseif( !$load_open_sans ) {
			add_filter( 'luigi_font_uri', 'luigi_font_uri_no_open_sans' );
		} elseif( !$load_bilbo ) {
			add_filter( 'luigi_font_uri', 'luigi_font_uri_no_bilbo' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'luigi_typecase_dequeue_default_fonts', 1 );
}

// Add theme support
add_theme_support( 'typecase', luigi_typecase_get_settings() );
