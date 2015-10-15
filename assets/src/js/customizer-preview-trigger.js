var Luigi_Preview_Trigger;
( function( $ ) {
	/**
	 * Create buttons which can appear in the customizer window to open
	 * specific controls.
	 *
	 * @param string id A unique id for this trigger
	 * @param jQuery container A jQuery object pointing to the element within
	 *  the preview to which this trigger should be attached.
	 * @param string control_id The control id which this trigger should open
	 * @since 0.0.1
	 */
	Luigi_Preview_Trigger = function( id, container, control_id ) {

		if ( !container.length || !wp || !wp.customize.preview ) {
			return;
		}

		id = 'luigi-preview-trigger-' + id;

		container.addClass( 'luigi-preview-trigger-container' );
		container.append( '<button href="#" id="' + id + '" class="luigi-preview-trigger"></button>' );

		$( '#' + id ).on( 'click', function(e) {
			e.preventDefault();
			e.stopPropagation();

			wp.customize.preview.send( 'customizer-focus.luigi', { control_id: control_id } );
		});

		return true;
	};
} )( jQuery );
