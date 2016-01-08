( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * View class for the Luigi Content Block form
	 *
	 * @augments wp.customize.Views.component_controls['content-block']
	 * @augments wp.customize.ContentLayoutControl.Views.BaseComponentForm
	 * @augments wp.Backbone.View
	 * @since 0.1
	 */
	clc.Views.component_controls['luigi-content-block'] = clc.Views.component_controls['content-block'].extend({
		template: wp.template( 'clc-component-luigi-content-block' ),

		className: 'clc-component-luigi-content-block clc-component-content-block'
	});

} )( jQuery );
