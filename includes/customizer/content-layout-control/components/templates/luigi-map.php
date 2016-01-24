<?php
/**
 * Layout template for the map component
 *
 * @since 0.1
 */
if ( luigi_bp_setting_exists( 'address' ) ) :
?>

<div class="clc-wrapper">
	[contact-card show_name=0 show_address=0 show_get_directions=0 show_phone=0 show_contact=0 show_opening_hours=0 show_booking_link=0]
</div>

<?php
endif;
