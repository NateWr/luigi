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
			name:           '',
			description:    '',
			type:           'luigi-hero-block',
			image:          0,
			title_line_one: '',
			title:          '',
			links:          [],
			contact:        '',
			order:          0
		}
	});

	/**
	 * View class for the Hero Block layout
	 *
	 * @augments wp.customize.ContentLayoutControl.Views.BaseComponentForm
	 * @augments wp.Backbone.View
	 * @since 0.1
	 */
	clc.Views.component_views['luigi-hero-block'] = clc.Views.component_views['content-block'].extend();

} )( jQuery );
