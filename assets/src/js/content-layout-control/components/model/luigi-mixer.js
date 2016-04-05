( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * Model class for the mixer component
	 *
	 * @augments Backbone.Model
	 * @since 0.1
	 */
	clc.Models.components['luigi-mixer'] = clc.Models.Component.extend({
		defaults: function() {
			return {
				name:           '',
				description:    '',
				type:           'luigi-mixer',
				left:           '',
				right:          '',
				left_title:     '',
				right_title:    '',
				valid_options:  [],
				order:          0
			};
		}
	});

} )( jQuery );
