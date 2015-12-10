( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * Model class for the Content Block component
	 *
	 * @augments Backbone.Model
	 * @since 0.1
	 */
	clc.Models.component_models['luigi-content-block'] = clc.Models.Component.extend({
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
	clc.Views.component_views['luigi-content-block'] = clc.Views.component_views['content-block'].extend();

} )( jQuery );
