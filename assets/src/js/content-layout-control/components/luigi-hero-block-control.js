( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * Model class for the Luigi Hero Block component
	 *
	 * @augments Backbone.Model
	 * @since 0.1
	 */
	clc.Models.component_models['luigi-hero-block'] = clc.Models.component_models['content-block'].extend({
		defaults: {
			name:           '',
			description:    '',
			type:           'luigi-hero-block',
			image:          0,
			title_line_one: '',
			title:          '',
			links:          [],
			contact:        '',
			order:          0
		}
	});

	/**
	* View class for the Luigi Hero Block form
	*
	* @augments wp.customize.Views.component_views['content-block']
	* @augments wp.customize.ContentLayoutControl.Views.BaseComponentForm
	* @augments wp.Backbone.View
	* @since 0.1
	*/
	clc.Views.component_views['luigi-hero-block'] = clc.Views.component_views['content-block'].extend({
		template: wp.template( 'clc-component-luigi-hero-block' ),

		className: 'clc-component-luigi-hero-block clc-component-content-block',

		events: _.extend({}, clc.Views.component_views['content-block'].prototype.events, {
			'change input[type="radio"]': 'contactChanged'
		}),

		/**
		 * Update when a contact value is selected
		 *
		 * @since 0.1
		 */
		contactChanged: function( event ) {
			this.updateLinkedSetting( event );
			wp.customize.previewer.send( 'component-changed.clc', this.model );
			this.render();
		}
	});

} )( jQuery );
