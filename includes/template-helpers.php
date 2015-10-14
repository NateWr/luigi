<?php
/**
 * Helper functions for the templates
 *
 * @brief These functions help reduce the amount of logic required in the
 *  template files.
 *
 * @package    luigi
 */

if ( !function_exists( 'luigi_print_logo' ) ) {
	/**
	 * Print the logo
	 *
	 * @since 0.0.1
	 */
	function luigi_print_logo() {

		$logo_url = wp_get_attachment_url( get_theme_mod( 'site_logo' ) );
		if ( !$logo_url ) {
			return;
		}

		$scale = get_theme_mod( 'site_logo_scale', 93 );
		$scale = $scale == 93 ? '' : ' style="max-height: ' . absint( $scale ) . 'px"';
		?>

		<img src="<?php echo $logo_url; ?>" class="logo-image" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"<?php echo $scale; ?>>

		<?php
	}
}

if ( !function_exists( 'luigi_print_phone' ) ) {
	/**
	 * Print the phone number from their Business Profile
	 *
	 * @since 0.0.1
	 */
	function luigi_print_phone() {
		if ( function_exists( 'bpwfwp_print_contact_card' ) ) {
			echo bpwfwp_print_contact_card(
				array(
					'show_name'                 => false,
					'show_address'              => false,
					'show_get_directions'       => false,
					'show_phone'                => true,
					'show_contact'              => false,
					'show_opening_hours'        => false,
					'show_opening_hours_brief'  => false,
					'show_map'                  => false,
					'show_booking_link'         => false,
				)
			);
		}
	}
}
