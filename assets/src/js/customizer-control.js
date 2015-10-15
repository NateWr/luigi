/**
 * Handle customizer control panel
 */
( function( $ ) {

	// Respond to focus request events from the previewer
	$( function () {
		wp.customize.previewer.bind( 'customizer-focus.luigi', function( data ) {
			wp.customize.control( data.control_id ).focus();
		});
	} );

} )( jQuery );
