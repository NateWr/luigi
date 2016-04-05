( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * Model class for the Luigi Hero Block component
	 *
	 * @augments clc.Models.components['content-block']
	 * @augments Backbone.Model
	 * @since 0.1
	 */
	clc.Models.components['luigi-hero-block'] = clc.Models.components['content-block'].extend({
		defaults: function() {
			return {
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
			};
		}
	});

} )( jQuery );
