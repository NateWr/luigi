<?php
/**
 * A single location's sidebar
 *
 * @package luigi
 */
?>

<div class="location-sidebar">
	<?php
		if ( defined( 'BPFWP_VERSION' ) && version_compare( BPFWP_VERSION, '1.1', '>=' ) ) {
			bpwfwp_print_address( get_the_ID() );
			bpwfwp_print_phone( get_the_ID() );
			bpwfwp_print_contact( get_the_ID() );
			bpwfwp_print_opening_hours( get_the_ID() );

			if ( function_exists( 'rtb_bp_print_booking_link' ) ) {
				bpfwp_set_display( 'show_booking_link', false );
				rtb_bp_print_booking_link( get_the_ID() );
			}
		}
	?>
</div>
