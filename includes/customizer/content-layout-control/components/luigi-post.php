<?php if ( ! defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'Luigi_CLC_Component_Post' ) ) {
	/**
	 * A base component for finding, selecting and rendering a post.
	 *
	 * @since 0.1
	 */
	class Luigi_CLC_Component_Post extends CLC_Component {

		/**
		 * Type of component
		 *
		 * @param string
		 * @since 0.1
		 */
		public $type = 'post';

		/**
		 * Post ID
		 *
		 * @param int
		 * @since 0.1
		 */
		public $post_id = 0;

		/**
		 * WP_Query arguments when searching
		 *
		 * @param array
		 * @since 0.1
		 */
		public $query_args = array(
			'post_type'      => 'any',
			'posts_per_page' => 50,
		);

		/**
		 * Settings expected by this component
		 *
		 * @param array Setting keys
		 * @since 0.1
		 */
		public $settings = array( 'post_id' );

		/**
		 * Initialize
		 *
		 * @since 0.1
		 */
		public function __construct( $args ) {
			parent::__construct( $args );

			add_action( 'customize_controls_print_footer_scripts', array( $this, 'add_post_selection_templates' ) );
		}

		/**
		 * Sanitize settings
		 *
		 * @param array val Values to be sanitized
		 * @return array
		 * @since 0.1
		 */
		public function sanitize( $val ) {

			return array(
				'id'             => isset( $val['id'] ) ? absint( $val['id'] ) : 0,
				'post_id'        => isset( $val['image'] ) ? absint( $val['image'] ) : $this->image,
				'order'          => isset( $val['order'] ) ? absint( $val['order'] ) : 0,
				'type'           => $this->type, // Don't allow this to be modified
			);
		}

		/**
		 * Render the layout template and return an HTML blob with the content,
		 * ready to be appended or saved to `post_content`
		 *
		 * @since 0.1
		 */
		public function render_layout() {}

		/**
		 * Print the control template. It should be an Underscore.js template
		 * using the same template conventions as core WordPress controls
		 *
		 * @since 0.1
		 */
		public function control_template() {}

		/**
		 * Add link selection templates to the control frame
		 *
		 * @since 0.1
		 */
		public function add_post_selection_templates() {
			?>
			<script type="text/html" id="tmpl-clc-component-luigi-post-post-selection"><?php include( get_template_directory() . '/assets/js/content-layout-control/templates/components/luigi-post-post-selection.js' ); ?></script>
			<script type="text/html" id="tmpl-clc-component-luigi-post-post-summary"><?php include( get_template_directory() . '/assets/js/content-layout-control/templates/components/luigi-post-post-summary.js' ); ?></script>
			<?php
		}

		/**
		 * Register custom endpoint to search posts
		 *
		 * @since 0.1
		 */
		public function register_endpoints() {
			register_rest_route(
				'content-layout-control/v1',
				'/components/luigi-post/post/(?P<search>.+)',
				array(
					'methods'   => 'GET',
					'callback' => array( $this, 'api_get_posts' ),
					'permission_callback' => array( CLC_Content_Layout_Control(), 'current_user_can' ),
				)
			);
		}

		/**
		 * API endpoint: retrieve a list of potential posts matching search
		 * query
		 *
		 * @since 0.1
		 */
		public function api_get_posts( WP_REST_Request $request ) {

			if ( !isset( $request['search'] ) ) {
				return array();
			}

			$search = sanitize_text_field( $request['search'] );

			$args = $this->query_args();
			$args['s'] = $search;

			$query = new WP_Query( $args );

			$posts = array();
			while ( $query->have_posts() ) {
				$query->the_post();

				$post_type = get_post_type_object( get_post_type() );
				$posts[] = $this->compile_post_result();
			}

			return array(
				'search' => $search,
				'links'  => $links,
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
				'post_type_label' => $post_type->labels->singular_name,
			);
		}
	}
}
