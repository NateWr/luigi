<?php
/**
 * Functions used to integrate with the Business Profile plugin
 *
 * @package    luigi
 */
if ( !function_exists( 'luigi_customizer_load_bpfwp_map_handlers' ) ) {
	/**
	 * Print a hidden map using Business Profile's native functions to ensure
	 * that the map handler is loaded and initialized properly. This is used by
	 * the customer to ensure that if a map is loaded in during customization,
	 * it will update properly.
	 *
	 * @since 0.0.1
	 */
	function luigi_customizer_load_bpfwp_map_handlers() {

		if ( !function_exists( 'bpwfwp_print_map' ) ) {
			return;
		}

		?>

		<div style="display:none;">
			<?php bpwfwp_print_map(); ?>
		</div>

		<?php
	}
}
