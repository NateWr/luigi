( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * View class for the Map layout
	 *
	 * @augments wp.customize.ContentLayoutControl.Views.BaseComponentPreview
	 * @augments wp.Backbone.View
	 * @since 0.1
	 */
	clc.Views.component_previews['luigi-map'] = clc.Views.BaseComponentPreview.extend({

		/**
		* Inject HTML into the dom
		*
		* @since 0.1
		*/
		injectHTML: function( html ) {
			html += '<a href="#" class="clc-edit-component">' + CLC_Preview_Settings.i18n.edit_component + '</a>';
			this.$el.html( html );

			// Re-initialize any maps which may have been added
			if ( typeof bp_initialize_map !== 'undefined' && typeof typeof google !== 'undefined' || typeof google.maps != 'undefined' ) {
				bp_initialize_map();
			}
		},
	});

} )( jQuery );
