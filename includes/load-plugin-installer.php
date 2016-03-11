<?php
/**
 * Functions used to load the plugin installer
 *
 * @brief These functions are used to load the TGM Plugin Activation library
 *   and register required and recommended plugins.
 *
 * @package    luigi
 */

require_once get_template_directory() . '/lib/tgmpa/class-tgm-plugin-activation.php';

if ( !function_exists( 'luigi_register_required_plugins' ) ) {
	/**
	 * Register the required plugins for this theme.
	 *
	 * In this example, we register five plugins:
	 * - one included with the TGMPA library
	 * - two from an external source, one from an arbitrary source, one from a GitHub repository
	 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
	 *
	 * The variable passed to tgmpa_register_plugins() should be an array of plugin
	 * arrays.
	 *
	 * This function is hooked into tgmpa_init, which is fired within the
	 * TGM_Plugin_Activation class constructor.
	 */
	function luigi_register_required_plugins() {

		error_log( 'hey there');
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(

			array(
				'name'      => __( 'Food and Drink Menu', 'luigi' ),
				'slug'      => 'food-and-drink-menu',
				'required'  => false,
			),

			array(
				'name'      => __( 'Restaurant Reservations', 'luigi' ),
				'slug'      => 'restaurant-reservations',
				'required'  => false,
			),

			array(
				'name'      => __( 'Business Profile', 'luigi' ),
				'slug'      => 'business-profile',
				'required'  => false,
			),

			array(
				'name'      => __( 'Good Reviews', 'luigi' ),
				'slug'      => 'good-reviews-wp',
				'required'  => false,
			),

			array(
				'name'      => __( 'Event Organiser', 'luigi' ),
				'slug'      => 'event-organiser',
				'required'  => false,
			),

			array(
				'name'      => __( 'Ninja Forms', 'luigi' ),
				'slug'      => 'ninja-forms',
				'required'  => false,
			),

			array(
				'name'      => __( 'WP Featherlight', 'luigi' ),
				'slug'      => 'wp-featherlight',
				'required'  => false,
			),

			array(
				'name'        => 'WordPress SEO by Yoast',
				'slug'        => 'wordpress-seo',
				'required'    => false,
				'is_callable' => 'wpseo_init',
			),
		);

		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 *
		 * Only uncomment the strings in the config array if you want to customize the strings.
		 */
		$config = array(
			'id'           => 'luigi',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'themes.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );
	}
	add_action( 'tgmpa_register', 'luigi_register_required_plugins' );
}
