( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * View class for the Mixer layout
	 *
	 * @augments wp.customize.ContentLayoutControl.Views.BaseComponentPreview
	 * @augments wp.Backbone.View
	 * @since 0.1
	 */
	clc.Views.component_previews['luigi-mixer'] = clc.Views.BaseComponentPreview.extend({

		/**
		 * Update the text settings immediately in the browser
		 *
		 * @since 0.1
		 */
		settingChanged: function( data ) {
			if ( data.setting == 'left_title' || data.setting == 'right_title' ) {
				this.$el.find( '.' + data.setting ).html( this.wrapFirstWord( data.val ) );
			} else {
				this.load();
			}
		},

		/**
		 * Inject HTML into the dom
		 *
		 * @since 0.1
		 */
		injectHTML: function( html ) {

			html += '<a href="#" class="clc-edit-component">' + CLC_Preview_Settings.i18n.edit_component + '</a>';
			this.$el.html( html );

			// Assign a unique ID to this map (since each map is loaded in its
			// own request, they all come back with #bp-map-0 )
			$( '.bp-map' ).each( function( i ) {
				$(this).attr( 'id', 'bp-map-' + i.toString() );
			} );

			// Re-initialize any maps which may have been added
			if ( typeof bp_initialize_map !== 'undefined' && typeof google !== 'undefined' && typeof google.maps != 'undefined' ) {
				bp_initialize_map();
			}
		},

		/**
		 * Wrap the first word of a string in a span for styling
		 *
		 * @since 0.1
		 */
		wrapFirstWord: function( string ) {
			string = string.split( ' ' );
			var first = string.splice( 0, 1 );
			return '<span class="luigi-first-word">' + first[0] + '</span>' + string.join( ' ' );
		},
	});

} )( jQuery );
