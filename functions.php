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
	 * @since 0.0.1
	 */
	function luigi_setup_theme() {

		luigi_load_context();

		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

		register_nav_menus(
			array(
				'primary_menu' => esc_html__( 'Primary Navigation Menu', 'luigi' ),
				'social_menu'  => esc_html__( 'Social Profiles Menu', 'luigi' ),
			)
		);

		register_sidebar(
			array(
				'name'        => __( 'Primary Sidebar', 'luigi' ),
				'id'          => 'primary-sidebar',
				'description' => __( 'This sidebar will appear beside most pages and posts', 'luigi' ),
			)
		);

		add_image_size( 'luigi-medium', 450, 450, true );
	}
	add_action( 'after_setup_theme', 'luigi_setup_theme' );
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
	}
}
