( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	* View class for the Luigi Hero Block form
	*
	* @augments wp.customize.Views.component_controls['content-block']
	* @augments wp.customize.ContentLayoutControl.Views.BaseComponentForm
	* @augments wp.Backbone.View
	* @since 0.1
	*/
	clc.Views.component_controls['luigi-hero-block'] = clc.Views.component_controls['content-block'].extend({
		template: wp.template( 'clc-component-luigi-hero-block' ),

		className: 'clc-component-luigi-hero-block clc-component-content-block',

		events: _.extend({}, clc.Views.component_controls['content-block'].prototype.events, {
			'change input[type="radio"]': 'contactChanged',
			'change input[type="range"]': 'imageTransparencyChanged',
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
		},

		/**
		 * Update when the image transparency has changed
		 *
		 * @since 0.1
		 */
		imageTransparencyChanged: function( event ) {
			this.updateLinkedSetting( event );

			var target = $( event.target );
			wp.customize.previewer.send(
				'component-setting-changed-' + this.model.get( 'id' ) + '.clc',
				{
					setting: target.data( 'clc-setting-link' ),
					val: target.val()
				}
			);
		}
	});

} )( jQuery );
