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

    }
    add_action( 'after_setup_theme', 'luigi_setup_theme' );
}

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
        wp_enqueue_style( 'luigi-fonts', '//fonts.googleapis.com/css?family=Bilbo+Swash+Caps|Open+Sans:400,400italic,600,600italic,700,700italic&subset=latin,latin-ext');
    }
    add_action( 'wp_enqueue_scripts', 'luigi_enqueue_assets' );
}
