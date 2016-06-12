<?php
/**
 * A single location's sidebar
 *
 * @package luigi
 */
?>

<div class="location-sidebar">
	<?php
		$address = bpfwp_setting( 'address', get_the_ID() );
		if ( !empty( $address['text'] ) ) {
			bpwfwp_print_address( get_the_ID() );
		}
		if ( bpfwp_setting( 'phone', get_the_ID() ) ) {
			bpwfwp_print_phone( get_the_ID() );
		}
		if ( bpfwp_setting( 'contact-email', get_the_ID() ) || bpfwp_setting( 'contact-page', get_the_ID() )) {
			bpwfwp_print_contact( get_the_ID() );
		}
		if ( bpfwp_setting( 'opening-hours', get_the_ID() ) ) {
			bpwfwp_print_opening_hours( get_the_ID() );
		}
	?>
</div>
