<?php
if ( !class_exists( 'Luigi_WP_Customize_Notice_Control' ) ) {
	/**
	 * A dummy control to display placeholder text in the customizer
	 *
	 * @see WP_Customize_Control
	 * @since 0.0.1
	 */
	class Luigi_WP_Customize_Notice_Control extends WP_Customize_Control {
		/**
		 * Control type
		 *
		 * @since 0.0.1
		 */
		public $type = 'notice';

		/**
		 * HTML content to display
		 *
		 * @since 0.0.1
		 */
		public $content = '';

		public function render_content() {
			if ( !empty( $this->label ) ) :	?>
				<div class="customize-control-title">
					<?php echo esc_html( $this->label ); ?>
				</div>
			<?php endif; ?>
			<div class="customize-notice-content">
				<?php echo $this->content; ?>
			</div>
			<?php
		}
	}
}
