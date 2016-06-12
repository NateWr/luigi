<?php
/**
 * Functions used to integrate with the Restaurant Reservations plugin
 *
 * @package    luigi
 */
if ( !function_exists( 'luigi_move_message_field' ) ) {
	/**
	 * Move the message field into its own fieldset
	 *
	 * @since 0.1
	 */
	function luigi_move_message_field( $fields, $request ) {

		if ( isset( $fields['reservation']['fields']['location'] ) ) {
			$fields['location'] = array(
				'legend' => $fields['reservation']['legend'],
				'fields' => array( 'location' => $fields['reservation']['fields']['location'] ),
			);

			unset( $fields['reservation']['legend'] );
			unset( $fields['reservation']['fields']['location'] );
		}

		$fields['message-set'] = array(
			'fields'	=> array(
				'add-message'	=> $fields['contact']['fields']['add-message'],
				'message'		=> $fields['contact']['fields']['message'],
			)
		);

		unset( $fields['contact']['fields']['add-message'] );
		unset( $fields['contact']['fields']['message'] );

		return array_filter( $fields );
	}
	add_filter( 'rtb_booking_form_fields', 'luigi_move_message_field', 10, 2 );
}

if ( !function_exists( 'luigi_rtb_maybe_print_booking_link' ) ) {
	/**
	 * Print a link to the booking form if it exists
	 *
	 * @since 1.1
	 */
	function luigi_rtb_maybe_print_booking_link() {

		global $rtb_controller;

		if ( empty( $rtb_controller ) ) {
			return '';
		}

		$booking_page = $rtb_controller->settings->get_setting( 'booking-page'  );

		if ( empty( $booking_page ) ) {
			return '';
		}

		return '<a href="' . esc_url( get_permalink( $booking_page ) ) . '">' . esc_html( 'Book a table', 'luigi' ) . '</a>';
	}
}
