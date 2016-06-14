( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * Model class for the locations component
	 *
	 * @augments Backbone.Model
	 * @since 0.1
	 */
	clc.Models.components['luigi-locations'] = clc.Models.Component.extend({
		defaults: function() {
			return {
				name:           '',
				description:    '',
				type:           'luigi-locations',
				order:          0
			};
		}
	});

} )( jQuery );
