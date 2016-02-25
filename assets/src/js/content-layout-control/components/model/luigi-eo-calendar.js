( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * Model class for the Event Organiser calendar component
	 *
	 * @augments Backbone.Model
	 * @since 0.1
	 */
	clc.Models.components['luigi-eo-calendar'] = clc.Models.Component.extend({
		defaults: {
			name:           '',
			description:    '',
			type:           'luigi-eo-calendar',
			order:          0
		}
	});

} )( jQuery );
