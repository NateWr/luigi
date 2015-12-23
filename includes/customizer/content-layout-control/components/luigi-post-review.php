<?php if ( ! defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'Luigi_CLC_Component_Review' ) ) {
	include_once( get_stylesheet_directory() . '/includes/customizer/content-layout-control/components/luigi-post.php' );
	/**
	 * Select and render a review
	 *
	 * Requires the plugin `good-reviews-wp`
	 *
	 * @since 0.1
	 */
	class Luigi_CLC_Component_Review extends Luigi_CLC_Component_Post {

		/**
		 * Type of component
		 *
		 * @param string
		 * @since 0.1
		 */
		public $type = 'luigi-post-review';

		/**
		 * WP_Query arguments when searching
		 *
		 * @param array
		 * @since 0.1
		 */
		public $query_args = array(
			'post_type'      => GRFWP_REVIEW_POST_TYPE,
			'posts_per_page' => 50,
		);

		/**
		 * Sanitize settings
		 *
		 * @param array val Values to be sanitized
		 * @return array
		 * @since 0.1
		 */
		public function sanitize( $val ) {
			return parent::sanitize( $val );
		}

		/**
		 * Render the layout template and return an HTML blob with the content,
		 * ready to be appended or saved to `post_content`
		 *
		 * @since 0.1
		 */
		public function render_layout() {
			include( get_template_directory() . '/includes/customizer/content-layout-control/components/templates/luigi-post.php' );
		}

		/**
		 * Print the control template. It should be an Underscore.js template
		 * using the same template conventions as core WordPress controls
		 *
		 * @since 0.1
		 */
		public function control_template() {
			include( get_template_directory() . '/assets/js/content-layout-control/templates/components/luigi-post.js' );
		}

		/**
		 * Register custom endpoint to search reviews
		 *
		 * @since 0.1
		 */
		public function register_endpoints() {
			register_rest_route(
				'content-layout-control/v1',
				'/components/luigi-post-review/post/(?P<search>.+)',
				array(
					'methods'   => 'GET',
					'callback' => array( $this, 'api_get_posts' ),
					'permission_callback' => array( CLC_Content_Layout_Control(), 'current_user_can' ),
				)
			);
		}

		/**
		 * Compile the post object to return with the post search endpoint
		 *
		 * Child classes can overwrite this to deliver unique post objects.
		 *
		 * @since 0.1
		 */
		public function compile_post_result() {
			return array(
				'ID' => get_the_ID(),
				'permalink' => get_the_permalink(),
				'title' => get_the_title(),
				'author' => get_the_author(),
			);
		}
	}
}
