( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * View class for the Mixer form
	 *
	 * @augments wp.customize.ContentLayoutControl.Views.BaseComponentForm
	 * @augments wp.Backbone.View
	 * @since 0.1
	 */
	clc.Views.component_controls['luigi-mixer'] = clc.Views.BaseComponentForm.extend({
        template: wp.template( 'clc-component-luigi-mixer' ),

		events: _.extend({}, clc.Views.BaseComponentForm.prototype.events, {
			'change [data-clc-setting-link]': 'updateLinkedSetting',
			'keyup [data-clc-setting-link]': 'updateTextLive',
		}),

		/**
		 * Update text inputs in the browser without triggering a full
		 * component refresh
		 *
		 * @since 0.1
		 */
		updateTextLive: function( event ) {
			var target = $( event.target );

			wp.customize.previewer.send(
				'component-setting-changed-' + this.model.get( 'id' ) + '.clc',
				{
					setting: target.data( 'clc-setting-link' ),
					val: target.val()
				}
			);
		},
    });

} )( jQuery );
