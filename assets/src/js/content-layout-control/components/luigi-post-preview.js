( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * Model class for the Post component
	 *
	 * @augments clc.Models.Component
	 * @augments Backbone.Model
	 * @since 0.1
	 */
	clc.Models.components['luigi-post'] = clc.Models.Component.extend({
		defaults: {
			name:               '',
			description:        '',
			type:               'luigi-post',
			post_id:            0,
			order:              0
		}
	});

	/**
	 * View class for the Hero Block layout
	 *
	 * @augments wp.customize.ContentLayoutControl.Views.BaseComponentPreview
	 * @augments wp.Backbone.View
	 * @since 0.1
	 */
	clc.Views.component_previews['luigi-post'] = clc.Views.BaseComponentPreview.extend();

} )( jQuery );
