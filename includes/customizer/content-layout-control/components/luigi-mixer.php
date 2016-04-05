<?php if ( ! defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'Luigi_CLC_Component_Mixer' ) ) {
	/**
	 * Mixer element to select from various left/right content options
	 *
	 * @since 0.1
	 */
	class Luigi_CLC_Component_Mixer extends CLC_Component{

		/**
		 * Type of component
		 *
		 * @param string
		 * @since 0.1
		 */
		public $type = 'luigi-mixer';

		/**
		 * Left panel selection
		 *
		 * @param string
		 * @since 0.1
		 * @see $valid_options
		 */
		public $left = '';

		/**
		 * Left panel title
		 *
		 * @param string
		 * @since 0.1
		 */
		public $left_title = '';

		/**
		 * Right panel selecton
		 *
		 * @param string
		 * @since 0.1
		 * @see $valid_options
		 */
		public $right = '';

		/**
		 * Right panel title
		 *
		 * @param string
		 * @since 0.1
		 */
		public $right_title = '';

		/**
		 * Valid selection options
		 *
		 * @param array
		 * @since 0.1
		 */
		public $valid_options = array();

		/**
		 * Settings expected by this component
		 *
		 * @param array Setting keys
		 * @since 0.1
		 */
		public $settings = array( 'left', 'right', 'left_title', 'right_title' );

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

			return array(
				'id'             => isset( $val['id'] ) ? absint( $val['id'] ) : 0,
				'left'           => isset( $val['left'] ) ? $this->sanitize_option( $val['left'] ) : $this->left,
				'right'          => isset( $val['right'] ) ? $this->sanitize_option( $val['right'] ) : $this->right,
				'left_title'     => isset( $val['left_title'] ) ? sanitize_text_field( $val['left_title'] ) : $this->left_title,
				'right_title'    => isset( $val['right_title'] ) ? sanitize_text_field( $val['right_title'] ) : $this->right_title,
				'order'          => isset( $val['order'] ) ? absint( $val['order'] ) : 0,
				'type'           => $this->type, // Don't allow this to be modified
			);
		}

		/**
		 * Sanitize contact value
		 *
		 * @since 0.1
		 */
		public function sanitize_option( $val ) {
			return array_key_exists( $val, $this->valid_options ) ? $val : '';
		}

		/**
		 * Get meta attributes
		 *
		 * @return array
		 * @since 0.1
		 */
		public function get_meta_attributes() {

			$atts = parent::get_meta_attributes();
			$atts['valid_options'] = $this->valid_options;

			return $atts;
		}

		/**
		 * Render the layout template and return an HTML blob with the content,
		 * ready to be appended or saved to `post_content`
		 *
		 * @since 0.1
		 */
		public function render_layout() {
			include( get_template_directory() . '/includes/customizer/content-layout-control/components/templates/luigi-mixer.php' );
		}

		/**
		 * Print the control template. It should be an Underscore.js template
		 * using the same template conventions as core WordPress controls
		 *
		 * @since 0.1
		 */
		public function control_template() {
			include( get_template_directory() . '/assets/js/content-layout-control/templates/components/luigi-mixer.js' );
		}
	}
}
