( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * Model class for the Reviews component
	 *
	 * @augments Backbone.Model
	 * @since 0.1
	 */
	clc.Models.components['luigi-posts-reviews'] = clc.Models.components.posts.extend({
		defaults: {
			name:           '',
			description:    '',
			type:           'luigi-posts-reviews',
			title:          '',
			posts:          [],
			limit_posts:    1,
			post_types:     'grfwp-review',
			order:          0
		}
	});

} )( jQuery );
