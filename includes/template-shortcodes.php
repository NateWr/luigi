<?php
/**
 * Shortcodes
 *
 * @brief These shortcodes provide access to display markup for dynamic content,
 *  in rare cases where a shortcode is needed to store a reference in
 *  post_content. Because these shortcodes don't travel "with" the theme, they
 *  are only used in limited ways specific to this theme, such as the
 *  content-layout-control component for the customizer.
 *
 * @package    luigi
 */

if ( !function_exists( 'luigi_shortcode_recent_posts' ) ) {
	/**
	 * Print the logo
	 *
	 * @since 0.0.1
	 */
	function luigi_shortcode_recent_posts( $args = array() ) {

		$defaults = array(
			'posts' => 3,
		);

		$atts = shortcode_atts( $defaults, $args, 'luigi-recent-posts' );

		ob_start();

		the_widget(
			'Luigi_Widget_Recent_Posts',
			array(
				'number' => (int) $atts['posts'],
			),
			array(
				'before_widget' => '',
				'after_widget' => '',
			)
		);

		return ob_get_clean();
	}
	add_shortcode( 'luigi-recent-posts', 'luigi_shortcode_recent_posts' );
}
