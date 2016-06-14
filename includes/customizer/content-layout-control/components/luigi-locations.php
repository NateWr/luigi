<?php if ( ! defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'Luigi_CLC_Component_Locations' ) ) {
	/**
	 * Locations component that displays locations from Business Profile
	 *
	 * @since 0.1
	 */
	class Luigi_CLC_Component_Locations extends CLC_Component{

		/**
		 * Type of component
		 *
		 * @param string
		 * @since 0.1
		 */
		public $type = 'luigi-locations';

		/**
		 * Settings expected by this component
		 *
		 * @param array Setting keys
		 * @since 0.1
		 */
		public $settings = array();

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
		public function render_layout() {
			include( get_template_directory() . '/includes/customizer/content-layout-control/components/templates/luigi-locations.php' );
		}

		/**
		 * Print the control template. It should be an Underscore.js template
		 * using the same template conventions as core WordPress controls
		 *
		 * @since 0.1
		 */
		public function control_template() {
			include( get_template_directory() . '/assets/js/content-layout-control/templates/components/luigi-locations.js' );
		}
	}
}
