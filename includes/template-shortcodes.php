<?php
/**
 * Shortcodes
 *
 * @brief These shortcodes provide access to display markup for dynamic content,
 *  in rare cases where a shortcode is needed to store a reference in
 *  post_content. Because these shortcodes don't travel "with" the theme, they
 *  are only used in limited ways specific to this theme, such as the
 *  content-layout-control component for the customizer.
 *
 * @package    luigi
 */

if ( !function_exists( 'luigi_shortcode_recent_posts' ) ) {
	/**
	 * Print the logo
	 *
	 * @since 0.0.1
	 */
	function luigi_shortcode_recent_posts( $args = array() ) {

		$defaults = array(
			'posts' => 3,
		);

		$atts = shortcode_atts( $defaults, $args, 'luigi-recent-posts' );

		ob_start();

		the_widget(
			'Luigi_Widget_Recent_Posts',
			array(
				'number' => (int) $atts['posts'],
				'show_date' => true,
			),
			array(
				'before_widget' => '',
				'after_widget' => '',
			)
		);

		return ob_get_clean();
	}
	add_shortcode( 'luigi-recent-posts', 'luigi_shortcode_recent_posts' );
}

if ( !function_exists( 'luigi_shortcode_bpfwp_contact_card' ) ) {
	/**
	 * Overwrite the [contact-card] shortcode from Business Profile to allow
	 * particular formatting and styling.
	 *
	 * @since 0.0.1
	 */
	function luigi_shortcode_bpfwp_contact_card( $args = array() ) {

		// Define shortcode attributes
		$defaults = array(
			'show_name'                => true,
			'show_address'             => true,
			'show_get_directions'      => true,
			'show_phone'               => true,
			'show_contact'             => true,
			'show_opening_hours'       => true,
			'show_opening_hours_brief' => false,
			'show_map'                 => true,
		);

		$defaults = apply_filters( 'bpwfp_contact_card_defaults', $defaults );

		global $bpfwp_controller;
		if ( empty( $bpfwp_controller ) ) {
			return '';
		}

		$bpfwp_controller->display_settings = shortcode_atts( $defaults, $args, 'contact-card' );

		// Setup components and callback functions to render them
		$data = array();

		if ( $bpfwp_controller->settings->get_setting( 'name' ) ) {
			$data['name'] = 'bpwfwp_print_name';
		}

		if ( $bpfwp_controller->settings->get_setting( 'address' ) ) {
			$data['address'] = 'bpwfwp_print_address';
		}

		if ( $bpfwp_controller->settings->get_setting( 'phone' ) ) {
			$data['phone'] = 'bpwfwp_print_phone';
		}

		if ( $bpfwp_controller->display_settings['show_contact'] &&
				( $bpfwp_controller->settings->get_setting( 'contact-email' ) || $bpfwp_controller->settings->get_setting( 'contact-page' ) ) ) {
			$data['contact'] = 'bpwfwp_print_contact';
		}

		if ( $bpfwp_controller->settings->get_setting( 'opening-hours' ) ) {
			$data['opening_hours'] = 'bpwfwp_print_opening_hours';
		}

		if ( $bpfwp_controller->display_settings['show_map'] && $bpfwp_controller->settings->get_setting( 'address' ) ) {
			$data['map'] = 'bpwfwp_print_map';
		}

		$data = apply_filters( 'bpwfwp_component_callbacks', $data );

		ob_start();
		?>

		<address class="bp-contact-card" itemscope itemtype="http://schema.org/<?php echo $bpfwp_controller->settings->get_setting( 'schema_type' ); ?>">

			<?php if ( $bpfwp_controller->display_settings['show_name'] || $bpfwp_controller->display_settings['show_address'] ) : ?>
				<div class="luigi-contact-card-address-wrapper">
			<?php endif; ?>

				<?php if ( array_key_exists( 'name', $data ) ) : call_user_func( $data['name'] ); endif; ?>
				<?php
					if ( array_key_exists( 'address', $data ) ) {

						// Don't show the get directions link in the address
						$show_get_directions = $bpfwp_controller->display_settings['show_get_directions'];
						$bpfwp_controller->display_settings['show_get_directions'] = false;

						call_user_func( $data['address'] );

						$bpfwp_controller->display_settings['show_get_directions'] = $show_get_directions;
					}
				?>

			<?php if ( $bpfwp_controller->display_settings['show_name'] || $bpfwp_controller->display_settings['show_address'] ) : ?>
				</div>
			<?php endif; ?>

			<?php if ( $bpfwp_controller->display_settings['show_phone'] || $bpfwp_controller->display_settings['show_contact'] ) : ?>
				<div class="luigi-contact-card-contact-wrapper">
			<?php endif; ?>

				<?php if ( array_key_exists( 'phone', $data ) ) : call_user_func( $data['phone'] ); endif; ?>
				<?php if ( array_key_exists( 'contact', $data ) ) : call_user_func( $data['contact'] ); endif; ?>

			<?php if ( $bpfwp_controller->display_settings['show_phone'] || $bpfwp_controller->display_settings['show_contact'] ) : ?>
				</div>
			<?php endif; ?>

			<?php if ( $bpfwp_controller->display_settings['show_get_directions'] || ( isset( $bpfwp_controller->display_settings['show_booking_link'] ) && $bpfwp_controller->display_settings['show_booking_link'] ) ) : ?>
				<div class="luigi-contact-card-links">
					<?php if ( $bpfwp_controller->display_settings['show_get_directions'] && $bpfwp_controller->settings->get_setting( 'address'  ) ) : $address = $bpfwp_controller->settings->get_setting( 'address'  ); ?>
						<div class="bp-directions">
							<a href="//maps.google.com/maps?saddr=current+location&daddr=<?php echo urlencode( esc_attr( $address['text'] ) ); ?>"><?php _e( 'Get directions', 'luigi' ); ?></a>
						</div>
					<?php endif; ?>
					<?php if ( array_key_exists( 'booking_page', $data ) ) : ?>
						<?php call_user_func( $data['booking_page'] ); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php foreach ( $data as $data => $callback ) : ?>
				<?php if ( $data == 'name' || $data == 'address' || $data == 'phone' || $data == 'contact' || $data == 'booking_page' ) { continue; } ?>
				<?php call_user_func( $callback ); ?>
			<?php endforeach; ?>
		</address>

		<?php
		$output = ob_get_clean();

		return apply_filters( 'bpwfwp_contact_card_output', $output );
	}
	add_shortcode( 'contact-card', 'luigi_shortcode_bpfwp_contact_card' );
}
