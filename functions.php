<?php
/**
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    luigi
 * @subpackage Functions
 * @version    0.0.1
 * @author     Theme of the Crop <http://themeofthecrop.com>
 * @copyright  Copyright (c) 2015, Theme of the Crop
 * @link       http://themeofthecrop.com
 * @license    GNU General Public License v2.0 or later
 */

if ( !function_exists( 'luigi_setup_theme' ) ) {
	/**
	 * Initialize the theme
     *
	 * @since 0.0.1
	 */
	function luigi_setup_theme() {

		luigi_load_context();

		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
		add_theme_support( 'post-thumbnails', array( 'fdm-menu-item', 'grfwp-review' ) );
		add_theme_support( 'event-organiser' );
		add_theme_support( 'theme-painter', luigi_load_theme_painter() );

		load_theme_textdomain( 'luigi', get_template_directory() . '/languages' );

		register_nav_menus(
			array(
				'primary_menu' => esc_html__( 'Primary Location', 'luigi' ),
				'social_menu'  => esc_html__( 'Social Profiles', 'luigi' ),
			)
		);

		register_sidebar(
			array(
				'name'        => __( 'Primary Sidebar', 'luigi' ),
				'id'          => 'primary-sidebar',
				'description' => __( 'This sidebar will appear beside most pages and posts', 'luigi' ),
			)
		);

		register_sidebar(
			array(
				'name'        => __( 'Footer (full-width)', 'luigi' ),
				'id'          => 'footer-full',
				'description' => __( 'Display full-width widgets (one per row) in the footer.', 'luigi' ),
			)
		);

		register_sidebar(
			array(
				'name'        => __( 'Footer (side-by-side)', 'luigi' ),
				'id'          => 'footer',
				'description' => __( 'Display widgets (many widgets per row) side by side in the footer.', 'luigi' ),
			)
		);

		add_image_size( 'luigi-medium', 450, 450, true );

		// Theme license updater
		include_once( 'lib/updater/theme-updater.php' );
	}
	add_action( 'after_setup_theme', 'luigi_setup_theme' );
}

if ( !function_exists( 'luigi_set_content_width' ) ) {
	/**
	 * Set the $content_width global early so that it's available to other
	 * callbacks attached to `after_setup_theme`.
	 *
	 * @since 0.1
	 */
	function luigi_set_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'luigi_content_width', 1320 );
	}
	add_action( 'after_setup_theme', 'luigi_set_content_width', 0 );
}

if ( !function_exists( 'luigi_load_typecase' ) ) {
	/**
	 * Load files required to integrate with Typecase
	 *
	 * This requires an early hook priority on `after_setup_theme` so it gets
	 * a separate load chain
	 *
	 * @since 0.1
	 */
	function luigi_load_typecase() {
		include_once( 'includes/integrations/typecase.php' );
	}
	add_action( 'after_setup_theme', 'luigi_load_typecase', -1 );
}

if ( !function_exists( 'luigi_load_context' ) ) {
	/**
	 * Load files when required for a given context
	 *
	 * @since 0.0.1
	 */
	function luigi_load_context() {
		add_action( 'get_header', 'luigi_load_frontend' );
		add_action( 'init', 'luigi_load_customizer' );
		add_action( 'widgets_init', 'luigi_load_widgets' );
		add_action( 'admin_init', 'luigi_load_admin' );
		add_action( 'init', 'luigi_load_init', 5 );
	}
}

if ( !function_exists( 'luigi_load_frontend' ) ) {
	/**
	 * Load files required to render the frontend
	 *
	 * @since 0.0.1
	 */
	function luigi_load_frontend() {
		include_once( 'includes/load-frontend.php' );
		include_once( 'lib/WAI-ARIA-Walker_Nav_Menu/aria-walker-nav-menu.php' );
		include_once( 'includes/template-helpers.php' );
		include_once( 'includes/template-shortcodes.php' );
		include_once( 'includes/integrations/restaurant-reservations.php' );
		include_once( 'includes/integrations/food-and-drink-menu.php' );
		include_once( 'includes/integrations/event-organiser.php' );
		include_once( 'includes/integrations/ninja-forms.php' );
	}
}

if ( !function_exists( 'luigi_load_customizer' ) ) {
	/**
	 * Load files required by the customizer
	 *
	 * @since 0.0.1
	 */
	function luigi_load_customizer() {
		include_once( 'includes/load-customizer.php' );
		include_once( 'includes/template-helpers.php' );
		include_once( 'includes/template-shortcodes.php' );
		include_once( 'includes/integrations/business-profile.php' );
		include_once( 'includes/integrations/event-organiser.php' );
	}
}

if ( !function_exists( 'luigi_load_widgets' ) ) {
	/**
	 * Load files handling widgets
	 *
	 * @since 0.0.1
	 */
	function luigi_load_widgets() {
		include_once( 'includes/widgets/luigi-recent-posts.php' );

		unregister_widget( 'WP_Widget_Recent_Posts' );
		register_widget( 'Luigi_Widget_Recent_Posts' );
	}
}

if ( !function_exists( 'luigi_load_admin' ) ) {
	/**
	 * Load files handling admin area
	 *
	 * @since 0.0.1
	 */
	function luigi_load_admin() {
		include_once( 'includes/integrations/restaurant-reservations.php' );
	}
}

if ( !function_exists( 'luigi_load_init' ) ) {
	/**
	 * Load files required globally that need to run during the `init` hook
	 *
	 * @since 0.0.1
	 */
	function luigi_load_init() {
		include_once( 'includes/load-theme-setup.php' );
		include_once( 'includes/integrations/restaurant-reservations.php' );
		include_once( 'includes/integrations/food-and-drink-menu.php' );
		include_once( 'includes/load-plugin-installer.php' );
	}
}

if ( !function_exists( 'luigi_load_theme_painter' ) ) {
	/**
	 * Load files required to work with the theme-painter lib and return
	 * $args for get_theme_support().
	 *
	 * @since 0.0.1
	 */
	function luigi_load_theme_painter() {
		include_once( 'lib/theme-painter/theme-painter.php' );
		include_once( 'includes/integrations/theme-painter.php' );

		return luigi_get_theme_painter_args();
	}
}
