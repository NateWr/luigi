var Luigi_Customizer_Ajax;
( function( $ ) {
	/**
	 * Wrapper for $.post() which handles default request parameters and the
	 * dislay of any errors.
	 *
	 * @params object Key/value pairs of data to send with request. Must include
	 *  a `route`. A function assigned to the `callback` key will be executed if
	 *  the response is successful.
	 * @since 0.0.1
	 */
	Luigi_Customizer_Ajax = function( params, callback ) {
		/**
		 * Selector cache to reduce DOM lookups
		 *
		 * @since 0.0.1
		 */
		var cache = Luigi_Selector_Cache;

		/**
		 * Display an error message
		 *
		 * @since 0.0.1
		 */
		function display_error( r ) {
			if ( typeof r.data == 'undefined' || typeof r.data.error == 'undefined' || typeof r.data.msg == 'undefined' ) {
				alert( luigi_theme_customizer_preview.strings.unknown_error );
			} else {
				alert( r.data.msg );
			}
		}

		/**
		 * Whether or not a loading spinner has been requested and can be added
		 *
		 * @since 0.0.1
		 */
		function needs_spinner() {
			if ( typeof params.spinner !== 'undefined' && typeof params.route !== 'undefined' ) {
				return cache.get( params.route, params.spinner ).length;
			}

			return false;
		}

		/**
		 * Attach a loading spinner
		 *
		 * @since 0.0.1
		 */
		function start_spinner() {
			if ( !needs_spinner() ) {
				return;
			}

			cache.get( params.route, params.spinner ).addClass( 'luigi-loading-spinner' );
			cache.clear( params.route );
		}

		/**
		 * Stop the loading spinner
		 *
		 * @since 0.0.1
		 */
		function stop_spinner( selector ) {
			if ( !needs_spinner() ) {
				return;
			}

			cache.get( params.route, params.spinner ).removeClass( 'luigi-loading-spinner' );
			cache.clear( params.route );
		}

		params.action = 'luigi-customizer';
		params.nonce = luigi_theme_customizer_preview.nonce;

		start_spinner();

		$.post(
			wp.ajax.settings.url,
			$.param( params ),
			function( r ) {
				stop_spinner();
				if ( r.success ) {
					if ( typeof r.data === 'undefined' ) {
						display_error( r );
					}

					if ( typeof callback !== 'undefined' ) {
						callback.call( this, r, params );
					}
				} else {
					display_error( r );
				}
			}
		);
	};
} )( jQuery );
