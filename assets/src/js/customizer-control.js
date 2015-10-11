/**
 * Handle the customizer controls
 */
( function( $ ) {

	/**
	 * A control that extends the media modal to add a scale control.
	 *
	 * @class
	 * @augments wp.customize.MediaControl
	 * @augments wp.customize.Control
	 * @augments wp.customize.Class
	 */
	wp.customize.ScaledImageControl = wp.customize.MediaControl.extend({

		/**
		 * Initialize events when the DOM is ready
		 *
		 * This should be a nearly exact copy of MediaControl.ready. It only
		 * adds a bit of code at the end to update the scale setting when the
		 * value changes.
		 *
		 * @since 0.0.1
		 */
		ready: function() {
			/**
			 * ------
			 * START: code below should be an exact copy of wp.customize.MediaControl.ready()
			 * ------
			 */
			var control = this;
			// Shortcut so that we don't have to use _.bind every time we add a callback.
			_.bindAll( control, 'restoreDefault', 'removeFile', 'openFrame', 'select', 'pausePlayer' );

			// Bind events, with delegation to facilitate re-rendering.
			control.container.on( 'click keydown', '.upload-button', control.openFrame );
			control.container.on( 'click keydown', '.upload-button', control.pausePlayer );
			control.container.on( 'click keydown', '.thumbnail-image img', control.openFrame );
			control.container.on( 'click keydown', '.default-button', control.restoreDefault );
			control.container.on( 'click keydown', '.remove-button', control.pausePlayer );
			control.container.on( 'click keydown', '.remove-button', control.removeFile );
			control.container.on( 'click keydown', '.remove-button', control.cleanupPlayer );

			// Resize the player controls when it becomes visible (ie when section is expanded)
			wp.customize.section( control.section() ).container
				.on( 'expanded', function() {
					if ( control.player ) {
						control.player.setControlsSize();
					}
				})
				.on( 'collapsed', function() {
					control.pausePlayer();
				});

			/**
			 * ------
			 * END: code above should be an exact copy of wp.customize.MediaControl.ready(),
			 * except for a modification of the next lin.
			 * ------
			 */
			// Re-render whenever the control's setting changes.
			control.setting.bind( function () {
				control.maybeResetScale(); // Reset before rendering
				control.renderContent();
			} );

			// Bind the `scale_value` param to update with any changes to the
			// scale setting so that it's updated in the template when the
			// control is re-rendered (on image selection/removal)
			var scale_setting = control.params.scale_setting;
			control.settings[scale_setting].bind( function() {
				control.params.scale_value = control.settings[scale_setting].get();
			} );

			// Update scale setting value when changed
			control.container.on( 'change input propertychange', '[data-customize-setting-link]', function() {
				var $this = $(this);
				control.settings[$this.data( 'customize-setting-link' )]( $this.val() );
			} );
		},

		/**
		 * Reset the scale when an image has been removed
		 *
		 * @since 0.0.1
		 */
		maybeResetScale: function() {

			// Reset scale and hide control if a logo has been removed
			if ( this.setting.get() === '' ) {
				this.settings[this.params.scale_setting]( this.params.scale_default );
				this.container.find( '> .scale' ).removeClass( 'is-visible' );

			// Show the scale control if a logo has been added
			} else {
				this.container.find( '> .scale' ).addClass( 'is-visible');
			}
		}


	});

	// Register the media control with the scaled_image control type
	wp.customize.controlConstructor.scaled_image = wp.customize.ScaledImageControl;

} )( jQuery );
