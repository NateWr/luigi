/*
 * Front-end Javascript for Luigi
 */

/**
 * Counter to throttle events when the window is being resized
 *
 * @since 0.0.1
 */
var luigi_resize_throttle_timer;

jQuery(document).ready(function ($) {

	/**
	 * Open and close navigation menu
	 *
	 * @since 0.0.1
	 */
	var body = $( 'body' );
	var nav_control = $( '#luigi-primary-nav-control' );
	nav_control.click( function() {
		body.toggleClass( 'luigi-menu-open' );
		return false;
	} );

	/**
	 * Disable scrollwheel on the full-screen map for the homepage
	 *
	 * @since 0.1
	 */
	$( '.clc-component-luigi-map .bp-map' ).on( 'bpfwp.map_initialized', function( e, id, map, info_window ) {
		map.setOptions( { scrollwheel: false } );
	} );

	/**
	 * Override default arguments for Event Organiser calendar view
	 *
	 * @since 0.1
	 */
	if ( typeof wp !== 'undefined' && typeof wp.hooks !== 'undefined' && typeof wp.hooks.addFilter !== 'undefined' ) {
		wp.hooks.addFilter( 'eventorganiser.fullcalendar_options', function( args, calendar ) {

			// Remove the default event color so that we don't need to force
			// override it in CSS. The eventColor is useful when full color
			// backgrounds are used because it will switch the text color to
			// white on dark backgrounds. But this theme never uses dark
			// backgrounds.
			delete args.eventColor;

			// This replicates a variable in Event Organiser. We need it to
			// override the responsive view handling to set our own breakpoint.
			var _eoResponsiveViewMap = {
				'agendaDay': 'listDay',
				'basicDay': 'listDay',
				'listDay': 'listDay',
				'agendaWeek': 'listWeek',
				'basicWeek': 'listWeek',
				'listWeek' : 'listWeek',
				'month': 'listMonth',
				'listMonth': 'listMonth',
			};

			// Override the responsive view functions with our own breakpoint at
			// 768px
			args.defaultView = ( $(window).width() < 768 && calendar.responsive )  ? _eoResponsiveViewMap[calendar.defaultview] : calendar.defaultview;
			args.windowResize = function(view) {
				console.log( 'hello there', view );
				if( view.calendar.options.responsive && $(window).width() < 768 ){
					$(this).fullCalendar( 'changeView', _eoResponsiveViewMap[view.calendar.options.previousView] );
				} else {
					$(this).fullCalendar( 'changeView', view.calendar.options.previousView );
				}
			};

			return args;
		} );
	}

	/**
	 * Remove open menu class is window size is bigger now
	 *
	 * @since 0.0.1
	 */
	function window_resized() {
		if( $(window).width() >= 480 ) {
			body.removeClass( 'luigi-menu-open' );
		}
	}

	window.onresize = function() {
		clearTimeout( luigi_resize_throttle_timer );
		luigi_resize_throttle_timer = setTimeout( window_resized, 500 );
	};

});
