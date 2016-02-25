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
					'label' => 'Base Font',
					'selector' => join( ',', apply_filters( 'luigi_typecase_base_font', array( 'html', 'body' ) ) ),
					'default' => '"Open Sans", "Trebuchet MS", Helvetica, Arial, sans-serif'
				),
				array(
					'label' => 'Accent Font',
					'selector' => luigi_typecase_get_alt_font_selector(),
					'default' => '"Bilbo Swash Caps", "Palatino Linotype", "Book Antiqua", Palatino, "Times New Roman", serif'
				),
			)
		);

		return apply_filters( 'luigi_typecase_settings', $args );
	}
}

add_theme_support( 'typecase', luigi_typecase_get_settings() );
