( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * View class for the Content Block layout
	 *
	 * @augments clc.Views.component_previews['content-block']
	 * @augments wp.customize.ContentLayoutControl.Views.BaseComponentPreview
	 * @augments wp.Backbone.View
	 * @since 0.1
	 */
	clc.Views.component_previews['luigi-content-block'] = clc.Views.component_previews['content-block'].extend({
		/**
		 * Handle individual settings updates
		 *
		 * @since 0.1
		 */
		settingChanged: function( data ) {
			if ( data.setting == 'title' ) {
				this.$el.find( '.' + data.setting ).html( this.wrapFirstWord( data.val ) );
			} else if ( data.setting == 'image-position' ) {
				this.updateImagePosition( data.val );
			} else {
				this.$el.find( '.' + data.setting ).html( data.val );
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
		}
	});

} )( jQuery );
