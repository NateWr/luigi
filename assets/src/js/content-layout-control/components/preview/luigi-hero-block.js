( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * View class for the Hero Block layout
	 *
	 * @augments clc.Views.component_previews['luigi-content-block']
	 * @augments wp.customize.ContentLayoutControl.Views.BaseComponentPreview
	 * @augments wp.Backbone.View
	 * @since 0.1
	 */
	clc.Views.component_previews['luigi-hero-block'] = clc.Views.component_previews['luigi-content-block'].extend({
		/**
		 * Handle individual settings updates
		 *
		 * @since 0.1
		 */
		settingChanged: function( data ) {
			if ( data.setting == 'image_transparency' ) {
				this.updateBackgroundTransparency( data.val );
			} else if ( data.setting == 'title' ) {
				this.$el.find( '.' + data.setting ).html( this.wrapFirstWord( data.val ) );
			} else {
				this.$el.find( '.' + data.setting ).html( data.val );
			}
		},

		/**
		 * Update the background image transparency
		 *
		 * @since 0.1
		 */
		updateBackgroundTransparency: function( val ) {
			var bg = this.$el.find( '.background' );
			if ( !bg.length ) {
				return;
			}

			val = 100 - parseInt( val, 10 );
			if ( val === 0 ) {
				bg.css( 'opacity', 0 );
			} else {
				bg.css( 'opacity', val / 100 );
			}
		}

	});

} )( jQuery );
