<?php
/**
 * Functions used to integrate with the Ninja Forms plugin
 *
 * @package    luigi
 */

/**
 * Disable default CSS files in Ninja Forms
 *
 * @since 0.1
 */
remove_action( 'ninja_forms_display_css', 'ninja_forms_display_css');
