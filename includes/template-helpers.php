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

if ( !function_exists( 'luigi_wrap_first_word' ) ) {
	/**
	 * Wrap the first word of a string in a <span> tag for styling
	 *
	 * @since 0.0.1
	 */
	function luigi_wrap_first_word( $string ) {

		$words = explode( ' ', $string );
		$first = $words[0];

		$rest = '';
		if ( count( $words ) > 1 ) {
			$rest = join( ' ', array_splice( $words, 1 ) );
		}

		return '<span class="luigi-first-word">' . $first . '</span>' . $rest;
	}
}

if ( !function_exists( 'luigi_bp_setting_exists' ) ) {
	/**
	 * Check if a phone number exists in the system
	 *
	 * @since 0.0.1
	 */
	function luigi_bp_setting_exists( $setting ) {

		global $bpfwp_controller;
		if ( !isset( $bpfwp_controller ) ) {
			return false;
		}

		$setting = $bpfwp_controller->settings->get_setting( $setting );
		return !empty( $setting );
	}
}

if ( !function_exists( 'luigi_print_hero_contact' ) ) {
	/**
	 * Check if we have the information we need to print the contact setting in
	 * the hero block.
	 *
	 * @since 0.0.1
	 */
	function luigi_print_hero_contact( $contact ) {
		if ( empty( $contact ) ) {
			return false;
		}

		if ( $contact == 'phone' ) {
			return luigi_bp_setting_exists( 'phone' );
		} elseif ( $contact == 'find' ) {
			return luigi_bp_setting_exists( 'address' );
		}

		return false;
	}
}

if ( !function_exists( 'luigi_get_attachment_img_src_url' ) ) {
	/**
	 * Retrive the URL for an attachment image
	 *
	 * @since 0.0.1
	 */
	function luigi_get_attachment_img_src_url( $attachment_id, $size ) {
		$img = wp_get_attachment_image_src( $attachment_id, $size );
		return $img[0];
	}
}

if ( !function_exists( 'luigi_clc_the_content' ) ) {
	/**
	 * Print `the_content` without the `wpautop` filter. Designed to be used
	 * to print the content from the `content-layout-control` lib.
	 *
	 * @since 0.0.1
	 */
	function luigi_clc_the_content() {
		remove_filter( 'the_content', 'wpautop' );
		the_content();
		add_filter( 'the_content', 'wpauto' );
	}
}
