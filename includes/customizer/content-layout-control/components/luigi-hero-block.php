<?php if ( ! defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'Luigi_CLC_Component_Hero_Block' ) ) {
	include_once( CLC_Content_Layout_Control::$dir . '/components/content-block.php' );
	/**
	 * Hero element with background image and call to action
	 *
	 * @since 0.1
	 */
	class Luigi_CLC_Component_Hero_Block extends CLC_Component_Content_Block {

		/**
		 * Type of component
		 *
		 * @param string
		 * @since 0.1
		 */
		public $type = 'luigi-hero-block';

		/**
		 * A title string that appers above the primary title
		 *
		 * @param string
		 * @since 0.1
		 */
		public $title_line_one = '';

		/**
		 * An optional contact detail to display
		 *
		 * @param string phone|find
		 * @since 0.1
		 */
		public $contact = '';

		/**
		 * A customizable string of text, used for some contact display options
		 *
		 * @param string
		 * @since 0.1
		 */
		public $contact_text = '';

		/**
		 * Image transparency
		 *
		 * @param int 0-100 (0 = opacity: 1.0)
		 * @since 0.1
		 */
		public $image_transparency = 0;

		/**
		 * Settings expected by this component
		 *
		 * @param array Setting keys
		 * @since 0.1
		 */
		public $settings = array( 'title_line_one', 'title', 'links', 'image', 'image_transparency', 'contact', 'contact_text' );

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
			$new_val['contact'] = isset( $val['contact'] ) ? $this->sanitize_contact( $val['contact'] ) : $this->contact;
			$new_val['contact_text'] = isset( $val['contact_text'] ) ? sanitize_text_field( $val['contact_text'] ) : $this->contact_text;
			$new_val['image_transparency'] = isset( $val['image_transparency'] ) ? absint( $val['image_transparency'] ) : $this->image_transparency;

			unset( $new_val['content'] );

			return $new_val;
		}

		/**
		 * Sanitize contact value
		 *
		 * @since 0.1
		 */
		public function sanitize_contact( $val ) {
			return $val == 'phone' || $val == 'find' ? $val : $this->contact;
		}

		/**
		 * Render the layout template and return an HTML blob with the content,
		 * ready to be appended or saved to `post_content`
		 *
		 * @since 0.1
		 */
		public function render_layout() {
			include( get_template_directory() . '/includes/customizer/content-layout-control/components/templates/luigi-hero-block.php' );
		}

		/**
		 * Print the control template. It should be an Underscore.js template
		 * using the same template conventions as core WordPress controls
		 *
		 * @since 0.1
		 */
		public function control_template() {
			include( get_template_directory() . '/assets/js/content-layout-control/templates/components/luigi-hero-block.js' );
		}

		/**
		 * Calculate the opacity value for image_transparency
		 *
		 * @since 0.1
		 */
		public function get_image_opacity() {

			if ( !$this->image_transparency ) {
				return 1;
			}

			if ( $this->image_transparency == 100 ) {
				return 0;
			}

			return ( 100 - $this->image_transparency ) / 100;
		}
	}
}
