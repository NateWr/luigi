<?php
/**
 * Functions used only on the frontend
 *
 * @brief These functions are only used on the frontend and so only need to be
 *  loaded for those requests.
 *
 * @package    luigi
 */
if ( !function_exists( 'luigi_enqueue_assets' ) ) {
	/**
	 * Enqueue the theme's assets
	 *
	 * @since 0.0.1
	 */
	function luigi_enqueue_assets() {

		// Auto-load the parent theme's style if a child theme is active
		if ( is_child_theme() ) {
			wp_enqueue_style( 'luigi-parent', trailingslashit( get_template_directory_uri() ) . 'style.css' );
		}

		// Enqueue active theme's CSS stylesheet
		wp_enqueue_style( 'luigi', get_stylesheet_uri() );

		// Load fonts
		$font_uri = apply_filters(
			/**
			* Filter the URL to load fonts. Modify this to load different
			* fonts, weights or subsets from Google.
			*
			* @since 0.0.1
			*
			* @param string $url The URL to the font definitions
			*/
			'luigi_font_uri',
			'//fonts.googleapis.com/css?family=Bilbo+Swash+Caps|Open+Sans:300,400,400italic,600,600italic,700,700italic&subset=latin,latin-ext'
		);
		wp_enqueue_style( 'luigi-fonts', $font_uri );

		// Maybe load minified scripts
		$min = WP_DEBUG ? '' : 'min.';

		// Enqueue frontend script
		wp_enqueue_script( 'luigi-js', get_stylesheet_directory_uri() . '/assets/js/frontend.' . $min . 'js', array( 'jquery' ), '0.0.1', true );
		wp_localize_script(
			'luigi-js',
			'luigi_js_data',
			array(
				'ajax_url' => admin_url('admin-ajax.php'),
			)
		);
	}
	add_action( 'wp_enqueue_scripts', 'luigi_enqueue_assets' );
}

if ( !function_exists( 'luigi_dequeue_footer_assets' ) ) {
	/**
	 * Dequeue styles from plugins we don't need in the footer
	 *
	 * @since 0.0.1
	 */
	function luigi_dequeue_footer_assets() {
		wp_dequeue_style( 'bpfwp-default' );
		wp_dequeue_style( 'gr-reviews' );
		wp_dequeue_style( 'rtb-booking-form' );
		wp_dequeue_style( 'fdm-css-base' );
		wp_dequeue_style( 'fdm-css-classic' );
		wp_dequeue_style( 'fdm-css-base-pro' );
	}
	add_action( 'wp_footer', 'luigi_dequeue_footer_assets' );
}

if ( !function_exists( 'luigi_add_body_classes' ) ) {
	/**
	 * Add conditional classes to the <body> tag
	 *
	 * @since 0.0.1
	 */
	function luigi_add_body_classes( $classes ) {

		// Add class if sidebar is not shown
		if ( ( is_front_page() && !is_home() ) ||
				is_page_template( 'page-full-width.php' ) ||
				!is_active_sidebar( 'primary-sidebar' ) ||
				( get_post_type() == 'fdm-menu' && luigi_menu_has_two_cols() ) ||
				( get_post_type() == 'event' && is_single() )
			) {
			$classes[] = 'luigi-primary-sidebar-inactive';
		}

		// Add class if this is a page where we want to display a narrow
		// content column
		$narrow_content = false;
		if ( is_single() ) {
			if ( get_post_type() == 'post' || get_post_type() == 'fdm-menu-item' ||
					( get_post_type() == 'fdm-menu' && !luigi_menu_has_two_cols() ) ||
					( is_page() && !is_page_template( 'page-full-width.php' ) ) ) {
				$narrow_content = true;
			}
		} elseif ( is_archive() ) {
			if ( get_post_type() !== 'grfwp-review' ) {
				$narrow_content = true;
			}
		} elseif ( is_home() ) {
			$narrow_content = true;
		} elseif ( is_page() && !is_front_page() && !is_page_template( 'page-full-width.php' ) ) {
			$narrow_content = true;
		}
		if ( $narrow_content ) {
			$classes[] = 'narrow-content-page';
		}

		return $classes;
	}
	add_action( 'body_class', 'luigi_add_body_classes' );
}

if ( !function_exists( 'luigi_set_map_options' ) ) {
	/**
	 * Define a custom style for Google Maps
	 *
	 * Used to alter maps from Business Profile and Event Organiser.
	 *
	 * @since 0.1
	 */
	function luigi_set_map_options( $opts ) {

		// Don't override styles set by any other code
		// @TODO use color for theme mods
		if ( empty( $opts['styles'] ) ) {
			$opts['styles'] = array(
				array(
					'stylers' => array(
						array( 'hue' => '#9a8f45' )
					)
				),
				array(
					'featureType' => 'water',
					'stylers' => array(
						array( 'hue' => '#0000ff' )
					)
				),
			);
		}

		return $opts;
	}
	add_filter( 'bpfwp_google_map_options', 'luigi_set_map_options' );
	add_filter( 'eventorganiser_venue_map_options', 'luigi_set_map_options' );
}

/**
 * Return an empty font URI to prevent loading the default fonts
 *
 * @since 0.1
 */
if ( !function_exists( 'luigi_font_uri_empty' ) ) {
	function luigi_font_uri_empty() {
		return '';
	}
}

/**
 * Return a font URI that does not include Open Sans
 *
 * @since 0.1
 */
if ( !function_exists( 'luigi_font_uri_no_open_sans' ) ) {
	function luigi_font_uri_no_open_sans() {
		return '//fonts.googleapis.com/css?family=Bilbo+Swash+Caps&subset=latin,latin-ext';
	}
}

/**
 * Return a font URI that does not include Bilbo Swash Caps
 *
 * @since 0.1
 */
if ( !function_exists( 'luigi_font_uri_no_bilbo' ) ) {
	function luigi_font_uri_no_bilbo() {
		return '//fonts.googleapis.com/css?family=Open+Sans:300,400,400italic,600,600italic,700,700italic&subset=latin,latin-ext';
	}
}
