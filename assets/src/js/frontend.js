/*
 * Front-end Javascript for Luigi
 */

/**
 * Counter to throttle events when the window is being resized
 *
 * @since 0.0.1
 */
var luigi = luigi || {};

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
		clearTimeout( luigi.resize_throttle_timer );
		luigi.resize_throttle_timer = setTimeout( window_resized, 500 );
	};

	/**
	 * Add content to a modal and open it
	 *
	 * @since 0.1
	 */
	luigi.openModal = function( content, invoker ) {
		$( 'body' ).addClass( 'luigi-modal-is-visible' )
			.find( '.luigi-modal' ).addClass( 'is-visible' )
			.find( '.luigi-modal-content' ).html( content );

		setTimeout( function() {
			$( '.luigi-modal-close' ).focus();
		}, 300 );

		if ( typeof invoker !== 'undefined' ) {
			luigi.modal_invoker = invoker;
		}
	};

	/**
	 * Close the modal and remove the content
	 *
	 * @since 0.1
	 */
	luigi.closeModal = function() {
		$( 'body' ).removeClass( 'luigi-modal-is-visible' )
			.find( '.luigi-modal' ).removeClass( 'is-visible' )
			.find( '.luigi-modal-content' ).empty();

		if ( typeof luigi.modal_invoker !== 'undefind' ) {
			luigi.modal_invoker.focus();
		}
	};
	$( '.luigi-modal' ).click( function(e) {
		var target = $( e.target );
		if ( target.is( '.luigi-modal' ) || target.is( '.luigi-modal-close' ) ) {
			luigi.closeModal();
		}
	} );

	/**
	 * Load a contact card modal
	 *
	 * @since 0.1
	 */
	$( 'body' ).on( 'click', '.luigi-load-contact-card', function(e) {

		e.preventDefault();

		luigi.openModal( '<span class="luigi-loading-spinner"></span>', $( e.currentTarget ) );

		var params = {
			action: 'luigi-bpfwp-get-contact-card-modal'
		};

		$.post(
			luigi_js_data.ajax_url,
			$.param( params ),
			function( r ) {

				if ( r.success ) {
					if ( typeof r.data === 'undefined' || typeof r.data.output === 'undefined' ) {
						alert( r );
						luigi.closeModal();
					}

					// Assign a unique ID to this map (since this map is loaded in its
					// own request, it will come back with #bp-map-0 which might clash
					// with an existing map)
					var i = $( '.bp-map' ).length;
					var el = $( r.data.output );
					el.find( '#bp-map-0' ).attr( 'id', 'bp-map-' + i.toString() );


					luigi.openModal( el );

					if ( typeof bpfwp_map === 'undefined' && typeof r.data.script_data !== 'undefined' ) {
						$( 'body' ).append( $( '<script type="text/javascript"></script>' ).html(
								'/* <![CDATA[ */' +
								'var bpfwp_map = ' + JSON.stringify( r.data.script_data ) +
								'/* ]]> */'
							)
						);
					}

					if ( typeof bp_initialize_map === 'undefined' && typeof r.data.script !== 'undefined' ) {
						$( 'body' ).append( $( '<script type="text/javascript"></script>' ).attr( 'src', r.data.script ) );
					} else {
						bp_initialize_map();
					}

				} else {
					alert( r );
					luigi.closeModal();
				}

			}
		);
	} );

});
