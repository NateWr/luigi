( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * Model class for the map component
	 *
	 * @augments Backbone.Model
	 * @since 0.1
	 */
	clc.Models.components['luigi-map'] = clc.Models.Component.extend({
		defaults: function() {
			return {
				name:           '',
				description:    '',
				type:           'luigi-map',
				order:          0
			};
		}
	});

} )( jQuery );
