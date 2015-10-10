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
        wp_enqueue_style(
			'luigi-fonts',
			apply_filters(
				/**
				 * Filter the URL to load fonts. Modify this to load different
				 * fonts, weights or subsets from Google.
				 *
				 * @since 0.0.1
				 *
				 * @param string $url The URL to the font definitions
				 */
				'luigi_font_uri',
				'//fonts.googleapis.com/css?family=Bilbo+Swash+Caps|Open+Sans:400,400italic,600,600italic,700,700italic&subset=latin,latin-ext'
			)
		);

        // Maybe load minified scripts
        $min = WP_DEBUG ? '' : 'min.';

        // Enqueue frontend script
        wp_enqueue_script( 'luigi-js', get_stylesheet_directory_uri() . '/assets/js/frontend.' . $min . 'js', array( 'jquery' ), '0.0.1', true );
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
    }
	add_action( 'wp_footer', 'luigi_dequeue_footer_assets' );
}
