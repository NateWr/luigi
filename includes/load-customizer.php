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

		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		$wp_customize->add_setting(
			'site_logo',
			array(
				'type'              => 'option',
				'sanitize_callback' => 'absint',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				'site_logo',
				array(
					'label'     => __( 'Logo', 'luigi' ),
					'section'   => 'title_tagline',
					'settings ' => 'site_logo',
					'priority'  => 1,
					'mime_type' => 'image',
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

		wp_enqueue_script( 'luigi-customizer-preview-js', get_stylesheet_directory_uri() . '/assets/js/customizer-preview.js', array( 'jquery', 'luigi-js' ), '0.0.1', true );

		$upload_dir = wp_upload_dir();
		wp_localize_script( 'luigi-customizer-preview-js', 'luigi_theme_customizer', array(
			'nonce'          => wp_create_nonce( 'luigi-customizer-ajax' ),
			'upload_dir_url' => $upload_dir['baseurl'],
		) );
	}
	add_action( 'customize_preview_init', 'luigi_customizer_enqueue_preview_assets' );
}
