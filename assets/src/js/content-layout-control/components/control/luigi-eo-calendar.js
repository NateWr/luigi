( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * View class for the Event Organiser Class form
	 *
	 * @augments wp.customize.ContentLayoutControl.Views.BaseComponentForm
	 * @augments wp.Backbone.View
	 * @since 0.1
	 */
	clc.Views.component_controls['luigi-eo-calendar'] = clc.Views.BaseComponentForm.extend({
        template: wp.template( 'clc-component-luigi-eo-calendar' )
    });

} )( jQuery );
