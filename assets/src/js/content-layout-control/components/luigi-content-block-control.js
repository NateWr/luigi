( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * Model class for the Luigi Content Block component
	 *
	 * @augments Backbone.Model
	 * @since 0.1
	 */
	clc.Models.component_models['luigi-content-block'] = clc.Models.component_models['content-block'].extend({
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

	/**
	* View class for the Luigi Content Block form
	*
	* @augments wp.customize.Views.component_views['content-block']
	* @augments wp.customize.ContentLayoutControl.Views.BaseComponentForm
	* @augments wp.Backbone.View
	* @since 0.1
	*/
	clc.Views.component_views['luigi-content-block'] = clc.Views.component_views['content-block'].extend({
		template: wp.template( 'clc-component-luigi-content-block' ),

		className: 'clc-component-luigi-content-block clc-component-content-block'
	});

} )( jQuery );
