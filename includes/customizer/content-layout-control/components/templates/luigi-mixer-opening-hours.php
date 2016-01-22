<?php
/**
 * Layout template for the mixer component's opening_hours option
 *
 * @since 0.1
 */
global $bpfwp_controller;
if ( !isset( $bpfwp_controller ) ) {
	return;
}
?>

[contact-card show_name=0 show_address=0 show_get_directions=0 show_phone=0 show_contact=0 show_map=0 show_booking_link=0]

<?php if ( luigi_rtb_setting_exists( 'booking-page' ) ) : global $rtb_controller; ?>
	<a href="<?php echo esc_url( get_permalink( $rtb_controller->settings->get_setting( 'booking-page' ) ) ); ?>" class="booking">
		<?php _e( 'Make a Reservation', 'luigi' ); ?>
	</a>
<?php endif;
