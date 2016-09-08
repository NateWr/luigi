<?php
/**
 * Functions used to integrate with the Ninja Forms plugin
 *
 * @package    luigi
 */

/**
 * Disable default CSS files in Ninja Forms prior to version 3.0
 *
 * @since 0.1
 */
remove_action( 'ninja_forms_display_css', 'ninja_forms_display_css');

/**
 * Disable default CSS files in Ninja Forms in versions 3.0+
 *
 * @since 1.1.1
 */
function luigi_ninja_forms_dequeue_styles() {
    wp_dequeue_style( 'nf-display' );
}

add_action( 'nf_display_enqueue_scripts', 'luigi_ninja_forms_dequeue_styles' );
