( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * Model class for the Review component
	 *
	 * @augments clc.Models.components.posts
	 * @augments Backbone.Model
	 * @since 0.1
	 */
	clc.Models.components['luigi-post-review'] = clc.Models.components.posts.extend({
		defaults: {
			name:               '',
			description:        '',
			type:               'luigi-post-review',
			post_id:            0,
			order:              0
		}
	});

	/**
	 * View class for the Review layout
	 *
	 * @augments clc.Views.component_previews.posts
	 * @augments wp.customize.ContentLayoutControl.Views.BaseComponentPreview
	 * @augments wp.Backbone.View
	 * @since 0.1
	 */
	clc.Views.component_previews['luigi-post-review'] = clc.Views.component_previews.posts.extend();

} )( jQuery );
