( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * Model class for the Luigi Content Block component
	 *
	 * @augments Backbone.Model
	 * @since 0.1
	 */
	clc.Models.components['luigi-content-block'] = clc.Models.components['content-block'].extend({
		defaults: {
			name:           '',
			description:    '',
			type:           'luigi-content-block',
			image:          0,
			image_position: 'left',
			title_line_one: '',
			title:          '',
			content:        '',
			links:          [],
			order:          0
		}
	});

} )( jQuery );
