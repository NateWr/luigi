<?php
/**
 * Functions used in the customizer
 *
 * @brief Functions used to define custom controls, add controls to the panel,
 *  and handle live preview.
 *
 * @package    luigi
 */
include_once( 'customizer/ajax-handler.php' );

// Initialize the content-layout-control library
include_once( get_template_directory() . '/lib/content-layout-control/content-layout-control.php' );
CLC_Content_Layout_Control(
	array(
		'url' => get_template_directory_uri() . '/lib/content-layout-control',
		'i18n' => array(
			'close' => __( 'Close', 'luigi' ),
			'control-toggle' => __( 'Open/close this component', 'luigi' ),
		),
	)
);

if ( !function_exists( 'luigi_customizer_add_controls' ) ) {
	/**
	 * Add controls to the customizer panel
	 *
	 * @since 0.0.1
	 */
	function luigi_customizer_add_controls( $wp_customize ) {
		include_once( 'customizer/WP_Customize_Scaled_Image_Control.php' );
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

		$wp_customize->add_section(
			'content_layout_control',
			array(
				'capability' => 'edit_posts',
				'title'      => __( 'Homepage Layout', 'luigi' ),
			)
		);

		$wp_customize->add_setting(
			'content_layout_control',
			array(
				'sanitize_callback' => 'CLC_Content_Layout_Control::sanitize',
				'transport'         => 'postMessage',
				'type'              => 'content_layout',
			)
		);

		$wp_customize->add_control(
			new CLC_WP_Customize_Content_Layout_Control(
				$wp_customize,
				'content_layout_control',
				array(
					'section'    => 'content_layout_control',
					'priority'   => 1,
					'components' => array( 'content-block' ),
					'i18n' => array(
						'add_component'  => esc_html( 'Add Component', 'luigi' ),
						'edit_component' => esc_html( 'Edit', 'luigi' ),
					),
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

		wp_enqueue_script( 'luigi-customizer-preview-js', get_stylesheet_directory_uri() . '/assets/js/customizer-preview.' . $min . 'js', array( 'luigi-js', 'customize-preview' ), '0.0.1', true );

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

if ( !function_exists( 'luigi_customizer_enqueue_control_assets' ) ) {
	/**
	 * Load assets to handle the customizer control panel
	 *
	 * @since 0.0.1
	 */
	function luigi_customizer_enqueue_control_assets() {

		wp_enqueue_style( 'luigi-customizer-control', get_stylesheet_directory_uri() . '/assets/css/customizer-control.css', '0.0.1' );

		// Maybe load minified scripts
		$min = WP_DEBUG ? '' : 'min.';

		wp_enqueue_script( 'luigi-customizer-control-js', get_stylesheet_directory_uri() . '/assets/js/customizer-control.' . $min . 'js', array( 'customize-controls' ), '0.0.1', true );
	}
	add_action( 'customize_controls_enqueue_scripts', 'luigi_customizer_enqueue_control_assets' );
}

if ( !function_exists( 'luigi_customizer_register_content_layout_control_components' ) ) {
	/**
	 * Register layout control components for the content-layout-control lib
	 *
	 * @since 0.0.1
	 */
	function luigi_customizer_register_content_layout_control_components( $components ) {

		if ( !isset( $components['content-block'] ) ) {
			$components['content-block'] = array(
				'file'        => CLC_Content_Layout_Control::$dir . '/components/content-block.php',
				'class'       => 'CLC_Component_Content_Block',
				'name'        => __( 'Content Block', 'luigi' ),
				'description' => __( 'A simple content block with an image, title, text and links.', 'luigi' ),
				'i18n'        => array(
					'title'                         => esc_attr__( 'Title', 'luigi' ),
					'content'                       => esc_attr__( 'Content', 'luigi' ),
					'image'                         => esc_attr__( 'Image', 'luigi' ),
					'image_placeholder'             => esc_attr__( 'No image selected', 'luigi' ),
					'image_position'                => esc_attr__( 'Image Position', 'luigi' ),
					'image_position_left'           => esc_attr__( 'Left', 'luigi' ),
					'image_position_right'          => esc_attr__( 'Right', 'luigi' ),
					'image_position_background'     => esc_attr__( 'Background', 'luigi' ),
					'image_select_button'           => esc_attr__( 'Select Image', 'luigi' ),
					'image_change_button'           => esc_attr__( 'Change Image', 'luigi' ),
					'image_remove_button'           => esc_attr__( 'Remove', 'luigi' ),
					'links'                         => esc_attr__( 'Links', 'luigi' ),
					'links_add_button'              => esc_attr__( 'Add Link', 'luigi' ),
					'links_remove_button'           => esc_attr__( 'Remove', 'luigi' ),
					'links_url'                     => esc_attr__( 'URL', 'luigi' ),
					'links_text'                    => esc_attr__( 'Link Text', 'luigi' ),
					'links_search_existing_content' => esc_attr__( 'Search existing content', 'luigi' ),
				)
			);
		}

		return $components;
	}
	add_filter( 'clc_register_components', 'luigi_customizer_register_content_layout_control_components' );
}
