<?php if ( ! defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'Luigi_CLC_Component_Content_Block' ) ) {
	include_once( CLC_Content_Layout_Control::$dir . '/components/content-block.php' );
	/**
	 * Single-block photo/text layout component extended to support two title
	 * lines
	 *
	 * @since 0.1
	 */
	class Luigi_CLC_Component_Content_Block extends CLC_Component_Content_Block {

		/**
		 * Type of component
		 *
		 * @param string
		 * @since 0.1
		 */
		public $type = 'luigi-content-block';

		/**
		 * A title string that appers above the primary title
		 *
		 * @param string
		 * @since 0.1
		 */
		public $title_line_one = '';

		/**
		 * Settings expected by this component
		 *
		 * @param array Setting keys
		 * @since 0.1
		 */
		public $settings = array( 'title_line_one', 'title', 'content', 'links', 'image', 'image_position' );

		/**
		 * Initialize
		 *
		 * @since 0.1
		 */
		public function __construct( $args ) {
			parent::__construct( $args );
		}

		/**
		 * Sanitize settings
		 *
		 * @param array val Values to be sanitized
		 * @return array
		 * @since 0.1
		 */
		public function sanitize( $val ) {

			$new_val = parent::sanitize( $val );
			$new_val['title_line_one'] = isset( $val['title_line_one'] ) ? sanitize_text_field( $val['title_line_one'] ) : $this->title_line_one;

			return $new_val;
		}

		/**
		 * Render the layout template and return an HTML blob with the content,
		 * ready to be appended or saved to `post_content`
		 *
		 * @since 0.1
		 */
		public function render_layout() {
			include( get_template_directory() . '/includes/customizer/content-layout-control/components/templates/luigi-content-block.php' );
		}

		/**
		 * Print the control template. It should be an Underscore.js template
		 * using the same template conventions as core WordPress controls
		 *
		 * @since 0.1
		 */
		public function control_template() {
			include( get_template_directory() . '/assets/js/content-layout-control/templates/components/luigi-content-block.js' );
		}
	}
}
