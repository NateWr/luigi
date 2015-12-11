/**
 * Render the customizer preview
 */
( function( $, Luigi_Selector_Cache ) {

	/**
	 * Selector cache to reduce DOM lookups
	 *
	 * @since 0.0.1
	 */
	var cache = Luigi_Selector_Cache;

	/**
	 * Function to execute ajax requests
	 *
	 * @since 0.0.1
	 */
	var ajax = Luigi_Customizer_Ajax;

	/**
	 * Function to register control focus triggers in the preview
	 *
	 * @since 0.0.1
	 */
	var add_trigger = Luigi_Preview_Trigger;

	/**
	 * Check if a logo is being used
	 *
	 * @since 0.0.1
	 */
	function has_logo() {
		return typeof wp.customize.get().site_logo !== 'undefined' && wp.customize.get().site_logo !== '0' && wp.customize.get().site_logo !== '';
	}

	/**
	 * Update the site title if it's being displayed
	 *
	 * @since 0.0.1
	 */
	wp.customize( 'blogname', function( val ) {
		val.bind( function( to ) {
			if ( !has_logo() ) {
				cache.get( 'home_link', '#masthead .home-link' ).text( to );
			}
		} );
	} );

	/**
	 * Update the site tagline if it's being displayed
	 *
	 * @since 0.0.1
	 */
	wp.customize( 'blogdescription', function( val ) {
		val.bind( function( to ) {
			if ( !has_logo() ) {
				if ( cache.get( 'tagline', '#masthead .site-tagline' ).length ) {
					cache.get( 'tagline', '#masthead .site-tagline' ).text( to );
				} else {
					cache.get( 'home_link', '#masthead .home-link' ).after(
						$( '<span class="site-tagline"></span>' ).text( to )
					);
				}
			}
		} );
	} );

	/**
	 * Update the site logo
	 *
	 * @since 0.0.1
	 */
	wp.customize( 'site_logo', function( val ) {
		val.bind( function( to ) {
			cache.clear( 'logo' );

			// Logo removed
			if ( !to ) {
				cache.get( 'home_link', '#masthead .home-link' ).text( wp.customize.get().blogname );
				cache.clear( 'home_link' );

				if ( !cache.get( 'tagline', '#masthead .site-tagline' ).length ) {
					cache.get( 'home_link', '#masthead .home-link' ).after(
						$( '<span class="site-tagline"></span>' ).text( wp.customize.get().blogdescription )
					);
					cache.clear( 'tagline' );
				}

			// Logo added
			} else {
				ajax(
					{
						route: 'site_logo',
						site_logo: to,
						spinner: '#masthead .home-link'
					},
					function( response, params ) {
						var img = $( '<img src="' + luigi_theme_customizer_preview.upload_dir_url + '/' + response.data.file + '" class="logo-image">' );
						if ( wp.customize.get().site_logo_scale != 93 ) {
							img.css( 'max-height', wp.customize.get().site_logo_scale + 'px' );
						}
						cache.get( 'home_link', '#masthead .home-link' ).html( img );
						cache.get( 'tagline', '#masthead .site-tagline' ).remove();
						cache.clear( 'tagline' );
						cache.clear( 'home_link' );
						cache.clear( 'logo' );
					}
				);
			}
		} );
	} );

	/**
	 * Update the site logo scale
	 *
	 * @since 0.0.1
	 */
	wp.customize( 'site_logo_scale', function( val ) {
		val.bind( function( to ) {
			cache.get( 'logo', '#masthead .logo-image' ).css( 'max-height', to + 'px' );
		} );
	} );

	/**
	 * Add buttons to load controls directly from the preview
	 *
	 * @since 0.0.1
	 */
	$( function() {
		wp.customize.preview.bind( 'active', function() {
			add_trigger( 'header_logo', cache.get( 'header_brand', '#masthead .brand' ), 'site_logo' );
		});
	} );

} )( jQuery, Luigi_Selector_Cache );
