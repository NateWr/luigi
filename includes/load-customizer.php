<?php
/**
 * Functions used in the customizer
 *
 * @brief Functions used to define custom controls, add controls to the panel,
 *  and handle live preview.
 *
 * @package    luigi
 */
include( 'customizer/ajax-handler.php' );

if ( !function_exists( 'luigi_customizer_add_controls' ) ) {
	/**
	 * Add controls to the customizer panel
	 *
	 * @since 0.0.1
	 */
	function luigi_customizer_add_controls( $wp_customize ) {
		include( 'customizer/WP_Customize_Scaled_Image_Control.php' );
		$wp_customize->register_control_type( 'Luigi_WP_Customize_Scaled_Image_Control' );

		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
		$wp_customize->get_section( 'title_tagline' )->title = esc_html__( 'Logo, Site Title and Tagline', 'luigi' );

		$wp_customize->add_setting(
			'site_logo',
			array(
				'sanitize_callback' => 'absint',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_setting(
			'site_logo_scale',
			array(
				'default'           => 93,
				'sanitize_callback' => 'absint',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Luigi_WP_Customize_Scaled_Image_Control(
				$wp_customize,
				'site_logo',
				array(
					'label'     => __( 'Logo', 'luigi' ),
					'section'   => 'title_tagline',
					'settings'  => array(
						'site_logo' => 'site_logo',
						'site_logo_scale' => 'site_logo_scale',
					),
					'priority'  => 1,
					'mime_type' => 'image',
					'min'       => 50,
					'max'       => 200,
				)
			)
		);
	}
	add_action( 'customize_register', 'luigi_customizer_add_controls' );
}

if ( !function_exists( 'luigi_customizer_enqueue_preview_assets' ) ) {
	/**
	 * Load assets to handle the customizer preview panel
	 *
	 * @since 0.0.1
	 */
	function luigi_customizer_enqueue_preview_assets() {

		wp_enqueue_style( 'luigi-customizer-preview', get_stylesheet_directory_uri() . '/assets/css/customizer-preview.css', '0.0.1' );

		// Maybe load minified scripts
		$min = WP_DEBUG ? '' : 'min.';

		wp_enqueue_script( 'luigi-customizer-preview-js', get_stylesheet_directory_uri() . '/assets/js/customizer-preview.' . $min . 'js', array( 'jquery', 'luigi-js' ), '0.0.1', true );

		$upload_dir = wp_upload_dir();
		wp_localize_script( 'luigi-customizer-preview-js', 'luigi_theme_customizer', array(
			'nonce'          => wp_create_nonce( 'luigi-customizer-ajax' ),
			'upload_dir_url' => $upload_dir['baseurl'],
			'strings'        => array(
				'unknown_error' => __( 'An unknown error occurred. Please try again. If the problem continues, please refresh the page.', 'luigi' ),
			),
		) );
	}
	add_action( 'customize_preview_init', 'luigi_customizer_enqueue_preview_assets' );
}

if ( !function_exists( 'luigi_customizer_enqueue_control_assetes' ) ) {
	/**
	 * Load assets to handle the customizer control panel
	 *
	 * @since 0.0.1
	 */
	function luigi_customizer_enqueue_control_assetes() {

		wp_enqueue_style( 'luigi-customizer-control', get_stylesheet_directory_uri() . '/assets/css/customizer-control.css', '0.0.1' );

		// Maybe load minified scripts
		$min = WP_DEBUG ? '' : 'min.';

		wp_enqueue_script( 'luigi-customizer-control-js', get_stylesheet_directory_uri() . '/assets/js/customizer-control.' . $min . 'js', array( 'customize-controls' ), '0.0.1', true );
	}
	add_action( 'customize_controls_enqueue_scripts', 'luigi_customizer_enqueue_control_assetes' );
}
