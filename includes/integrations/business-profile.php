<?php
/**
 * Functions used to integrate with the Business Profile plugin
 *
 * @package luigi
 */
if ( !function_exists( 'luigi_bp_set_map_options' ) ) {
	/**
	 * Define a custom style for the map printed by Business Profile
	 *
	 * @since 0.1
	 */
	function luigi_bp_set_map_options( $opts ) {

		// Don't override styles set by any other code
		// @TODO use color for theme mods
		if ( !isset( $opts['styles'] ) ) {
			$opts['styles'] = array(
				array(
					'stylers' => array(
						array( 'hue' => '#9a8f45' )
					)
				),
				array(
					'featureType' => 'water',
					'stylers' => array(
						array( 'hue' => '#0000ff' )
					)
				),
			);
		}

		return $opts;
	}
	add_filter( 'bpfwp_google_map_options', 'luigi_bp_set_map_options' );
}
