( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * Model class for the Content Block component
	 *
	 * @augments Backbone.Model
	 * @since 0.1
	 */
	clc.Models.components['luigi-content-block'] = clc.Models.Component.extend({
		defaults: {
			name:           '',
			description:    '',
			type:           'content-block',
			image:          0,
			image_position: 'left',
			title_line_one: '',
			title:          '',
			content:        '',
			order:          0
		}
	});

	/**
	 * View class for the Content Block layout
	 *
	 * @augments wp.customize.ContentLayoutControl.Views.BaseComponentForm
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
