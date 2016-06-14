<?php
/**
 * Template for a contact card
 *
 * See the template file in the Business Profile plugin for more information on
 * how to customize this file.
 *
 * https://github.com/NateWr/business-profile/blob/master/templates/contact-card.php
 *
 */
global $bpfwp_controller; ?>

<address class="bp-contact-card" itemscope itemtype="http://schema.org/<?php echo bpfwp_setting( 'schema-type', bpfwp_get_display( 'location' ) ); ?>">

	<?php if ( bpfwp_get_display( 'show_name' ) || bpfwp_get_display( 'show_address' ) ) : ?>
		<div class="luigi-contact-card-address-wrapper">
	<?php endif; ?>

		<?php if ( isset( $data->name ) ) : call_user_func( $data->name, bpfwp_get_display( 'location' ) ); endif; ?>
		<?php
			if ( isset( $data->address ) ) {

				// Don't show the get directions link in the address
				$show_get_directions = bpfwp_get_display( 'show_get_directions' );
				bpfwp_set_display( 'show_get_directions', false );

				call_user_func( $data->address, bpfwp_get_display( 'location' ) );

				bpfwp_set_display( 'show_get_directions', $show_get_directions );
			}
		?>

	<?php if ( bpfwp_get_display( 'show_name' ) || bpfwp_get_display( 'show_address' ) ) : ?>
		</div>
	<?php endif; ?>

	<?php if ( bpfwp_get_display( 'show_phone' ) || bpfwp_get_display( 'show_contact' ) ) : ?>
		<div class="luigi-contact-card-contact-wrapper">
	<?php endif; ?>

		<?php if ( isset( $data->phone ) ) : call_user_func( $data->phone ); endif; ?>
		<?php if ( isset( $data->contact ) ) : call_user_func( $data->contact ); endif; ?>

	<?php if ( bpfwp_get_display( 'show_phone' ) || bpfwp_get_display( 'show_contact' ) ) : ?>
		</div>
	<?php endif; ?>

	<?php if ( bpfwp_get_display( 'show_get_directions' ) || bpfwp_get_display( 'show_booking_link' ) ) : ?>
		<div class="luigi-contact-card-links">
			<?php if ( bpfwp_get_display( 'show_get_directions' ) && bpfwp_setting( 'address', bpfwp_get_display( 'location' )  ) ) : $address = bpfwp_setting( 'address', bpfwp_get_display( 'location' )  ); ?>
				<div class="bp-directions">
					<a href="//maps.google.com/maps?saddr=current+location&daddr=<?php echo urlencode( esc_attr( $address['text'] ) ); ?>"><?php _e( 'Get directions', 'luigi' ); ?></a>
				</div>
			<?php endif; ?>
			<?php if ( isset( $data->booking_page ) ) : ?>
				<?php call_user_func( $data->booking_page, bpfwp_get_display( 'location' ) ); ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php foreach ( $data as $slug => $callback ) : ?>
		<?php if ( $slug == 'name' || $slug == 'address' || $slug == 'phone' || $slug == 'contact' || $slug == 'booking_page' ) { continue; } ?>
		<?php call_user_func( $callback ); ?>
	<?php endforeach; ?>
</address>
