( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * Model class for the Luigi Review component
	 *
	 * @augments wp.customize.Models.components['luigi-post']
	 * @augments wp.customize.ContentLayoutControl.Models.Component
	 * @augments Backbone.Model
	 * @since 0.1
	 */
	clc.Models.components['luigi-post-review'] = clc.Models.components['luigi-post'].extend({
		defaults: {
			name:           '',
			description:    '',
			type:           'luigi-post-review',
			post_id:        0,
			order:          0
		}
	});

	/**
	* View class for the Luigi Review form
	*
	* @augments wp.customize.Views.component_controls['luigi-post']
	* @augments wp.customize.ContentLayoutControl.Views.BaseComponentForm
	* @augments wp.Backbone.View
	* @since 0.1
	*/
	clc.Views.component_controls['luigi-post-review'] = clc.Views.component_controls['luigi-post'].extend({
		template: wp.template( 'clc-component-luigi-post-review' ),

		className: 'clc-component-luigi-post-review',
	});

} )( jQuery );
