( function( $ ) {

	var clc = wp.customize.ContentLayoutControl;

	/**
	 * View class for the Event Organiser calendar layout
	 *
	 * @augments wp.customize.ContentLayoutControl.Views.BaseComponentPreview
	 * @augments wp.Backbone.View
	 * @since 0.1
	 */
	clc.Views.component_previews['luigi-eo-calendar'] = clc.Views.BaseComponentPreview.extend({

		/**
		* Inject HTML into the dom
		*
		* @since 0.1
		*/
		injectHTML: function( html ) {
			html += '<a href="#" class="clc-edit-component">' + CLC_Preview_Settings.i18n.edit_component + '</a>';
			this.$el.html( html );

			var calendars = this.$el.find( '.eo-fullcalendar' );
			if ( typeof calendars.fullCalendar !== 'undefined' && typeof luigi_eo_calendar_args !== 'undefined' ) {
				calendars.fullCalendar( luigi_eo_calendar_args );
			}
		},
	});

} )( jQuery );
