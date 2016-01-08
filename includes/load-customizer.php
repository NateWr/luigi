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
			'delete'                        => esc_attr__( 'Delete', 'luigi' ),
			'control-toggle'                => esc_attr__( 'Open/close this component', 'luigi' ),
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
					'components' => array( 'luigi-hero-block', 'luigi-content-block', 'luigi-posts-reviews' ),
					'i18n' => array(
						'add_component'                 => esc_html__( 'Add Component', 'luigi' ),
						'edit_component'                => esc_html__( 'Edit', 'luigi' ),
						'close'                         => esc_attr__( 'Close', 'luigi' ),
						'post_search_label'             => esc_html__( 'Search content', 'luigi' ),
						'links_add_button'              => esc_html__( 'Add Link', 'luigi' ),
						'links_url'                     => esc_html__( 'URL', 'luigi' ),
						'links_text'                    => esc_html__( 'Link Text', 'luigi' ),
						'links_search_existing_content' => esc_html__( 'Search existing content &rarr;', 'luigi' ),
						'links_back'                    => esc_html__( '&larr; Back to link form', 'luigi' ),
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

		wp_enqueue_script( 'luigi-customizer-preview-js', get_stylesheet_directory_uri() . '/assets/js/customizer-preview.' . $min . 'js', array( 'luigi-js', 'customize-preview', 'content-layout-preview-js' ), '0.0.1', true );

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

		wp_enqueue_script( 'luigi-customizer-control-js', get_stylesheet_directory_uri() . '/assets/js/customizer-control.' . $min . 'js', array( 'customize-controls', 'content-layout-control-js' ), '0.0.1', true );

		wp_localize_script( 'luigi-customizer-control-js', 'luigi_theme_customizer_control', array(
			'business_profile_active' => defined( 'BPFWP_VERSION' ),
		) );
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

		$content_block_i18n = array(
			'title'                         => esc_html__( 'Title', 'luigi' ),
			'content'                       => esc_html__( 'Content', 'luigi' ),
			'image'                         => esc_html__( 'Image', 'luigi' ),
			'image_placeholder'             => esc_html__( 'No image selected', 'luigi' ),
			'image_position'                => esc_html__( 'Image Position', 'luigi' ),
			'image_position_left'           => esc_html__( 'Left', 'luigi' ),
			'image_position_right'          => esc_html__( 'Right', 'luigi' ),
			'image_select_button'           => esc_html__( 'Select Image', 'luigi' ),
			'image_change_button'           => esc_html__( 'Change Image', 'luigi' ),
			'image_remove_button'           => esc_html__( 'Remove', 'luigi' ),
			'links'                         => esc_html__( 'Links', 'luigi' ),
			'links_add_button'              => esc_html__( 'Add Link', 'luigi' ),
			'links_remove_button'           => esc_html__( 'Remove', 'luigi' ),
		);

		$components['luigi-hero-block'] = array(
			'file'        => get_template_directory() . '/includes/customizer/content-layout-control/components/luigi-hero-block.php',
			'class'       => 'Luigi_CLC_Component_Hero_Block',
			'name'        => __( 'Hero Block', 'luigi' ),
			'description' => __( 'A prominent call to action on a full-width background image.', 'luigi' ),
			'i18n'        => array_merge(
				$content_block_i18n,
				array(
					'title_line_one'                => esc_attr__( 'Title (top)', 'luigi' ),
					'title'                         => esc_attr__( 'Title (bottom)', 'luigi' ),
					'contact'                       => esc_attr__( 'Contact Detail', 'luigi' ),
					'none'                          => esc_attr__( 'None', 'luigi' ),
					'phone'                         => esc_attr__( 'Phone Number', 'luigi' ),
					'find'                          => esc_attr__( 'Contact Popup', 'luigi' ),
					'find_text_default'             => esc_attr__( 'Find Us', 'luigi' ),
					'image_transparency'            => esc_attr__( 'Darken Image', 'luigi' ),
				)
			),
		);

		$components['luigi-content-block'] = array(
			'file'        => get_template_directory() . '/includes/customizer/content-layout-control/components/luigi-content-block.php',
			'class'       => 'Luigi_CLC_Component_Content_Block',
			'name'        => esc_html__( 'Content Block', 'luigi' ),
			'description' => esc_html__( 'A simple content block with an image, title, text and links.', 'luigi' ),
			'i18n'        => array_merge(
				$content_block_i18n,
				array(
					'title_line_one' => esc_attr__( 'Title (top)', 'luigi' ),
					'title' => esc_attr__( 'Title (bottom)', 'luigi' ),
				)
			),
		);

		$components['luigi-posts-reviews'] = array(
			'file'        => get_template_directory() . '/includes/customizer/content-layout-control/components/luigi-posts-reviews.php',
			'class'       => 'Luigi_CLC_Component_Reviews',
			'name'        => esc_html__( 'Review', 'luigi' ),
			'description' => esc_html__( 'Select a review to display.', 'luigi' ),
			'limit_posts' => 3,
			'i18n'        => array(
				'posts_loading' => esc_html__( 'Loading', 'luigi' ),
				'posts_remove_button' => esc_html__( 'Remove', 'luigi' ),
				'placeholder'         => esc_html__( 'No review selected.', 'luigi' ),
				'posts_add_button'    => esc_html__( 'Add Review', 'luigi' ),
			),
		);

		return $components;
	}
	add_filter( 'clc_register_components', 'luigi_customizer_register_content_layout_control_components' );
}
