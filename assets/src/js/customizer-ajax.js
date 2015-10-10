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
		 * Display an error message
		 *
		 * @since 0.0.1
		 */
		function display_error( r ) {

			// A request that fails without providing an error message
			if ( typeof r.data == 'undefined' || typeof r.data.error == 'undefined' || typeof r.data.msg == 'undefined' ) {
				console.log( r );
				return;
			}

			console.log( r ); // @todo display the error visibly
		}

		params.action = 'luigi-customizer';
		params.nonce = luigi_theme_customizer.nonce;

		$.post(
			wp.ajax.settings.url,
			$.param( params ),
			function( r ) {
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
