<?php if ( ! defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'Luigi_CLC_Component_Review' ) ) {
	include_once( CLC_Content_Layout_Control::$dir . '/components/posts.php' );
	/**
	 * Select and render reviews
	 *
	 * Requires the plugin `good-reviews-wp`
	 *
	 * @since 0.1
	 */
	class Luigi_CLC_Component_Reviews extends CLC_Component_Posts {

		/**
		 * Type of component
		 *
		 * @param string
		 * @since 0.1
		 */
		public $type = 'luigi-posts-reviews';

		/**
		 * Limit number of reviews allowed
		 *
		 * @param int
		 * @since 0.1
		 */
		public $limit_posts = 1;

		/**
		 * Post types to allow
		 *
		 * @since 0.1
		 */
		public $post_types = 'grfwp-review';

		/**
		 * Render the layout template
		 *
		 * @since 0.1
		 */
		public function render_layout() {
			include( get_template_directory() . '/includes/customizer/content-layout-control/components/templates/luigi-posts-reviews.php' );
		}

		/**
		 * Print the control template
		 *
		 * @since 0.1
		 */
		public function control_template() {
			include( get_template_directory() . '/assets/js/content-layout-control/templates/components/luigi-posts-reviews.js' );
		}
	}
}
