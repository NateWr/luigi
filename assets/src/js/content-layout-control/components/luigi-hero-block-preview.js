( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * Model class for the Hero Block component
	 *
	 * @augments Backbone.Model
	 * @since 0.1
	 */
	clc.Models.component_models['luigi-hero-block'] = clc.Models.Component.extend({
		defaults: {
			name:               '',
			description:        '',
			type:               'luigi-hero-block',
			image:              0,
			image_transparency: 0,
			title_line_one:     '',
			title:              '',
			links:              [],
			contact:            '',
			order:              0
		}
	});

	/**
	 * View class for the Hero Block layout
	 *
	 * @augments wp.customize.ContentLayoutControl.Views.BaseComponentForm
	 * @augments wp.Backbone.View
	 * @since 0.1
	 */
	clc.Views.component_views['luigi-hero-block'] = clc.Views.component_views['luigi-content-block'].extend({
		/**
		 * Handle individual settings updates
		 *
		 * @since 0.1
		 */
		settingChanged: function( data ) {
			if ( data.setting == 'image_transparency' ) {
				this.updateBackgroundTransparency( data.val );
				return;
			}

			clc.Views.component_views['luigi-content-block'].prototype.settingChanged( data );
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
