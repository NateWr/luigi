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
			$location_fieldset = array(
				'legend' => $fields['reservation']['legend'],
				'fields' => array( 'location' => $fields['reservation']['fields']['location'] ),
			);

			unset( $fields['reservation']['legend'] );
			unset( $fields['reservation']['fields']['location'] );

			$fields = array_merge( array( 'location' => $location_fieldset ), $fields );
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
