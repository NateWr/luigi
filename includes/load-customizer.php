<?php
/**
 * Functions used in the customizer
 *
 * @brief Functions used to define custom controls, add controls to the panel,
 *  and handle live preview.
 *
 * @package    luigi
 */
if ( !function_exists( 'luigi_customizer_add_controls' ) ) {
    /**
     * Add controls to the customizer panel
     *
     * @since 0.0.1
     */
    function luigi_customizer_add_controls( $wp_customize ) {

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
					'label'    => __( 'Logo', 'luigi' ),
					'section'  => 'title_tagline',
					'settings' => 'site_logo',
					'priority' => 1,
					'mime_type' => 'image',
				)
			)
		);
    }
	add_action( 'customize_register', 'luigi_customizer_add_controls' );
}
