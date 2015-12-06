<?php
if ( !class_exists( 'Luigi_Customier_Ajax_Handler' ) ) {
	/**
	 * Ajax handler for the customizer
	 *
	 * @brief This class validates ajax requests issued by the customizer
	 * preview, routes the request, and returns the requested data.
	 *
	 * @package    luigi
	 * @since 0.0.01
	 */
	class Luigi_Customizer_Ajax_Handler {

		/**
		 * Initialize hooks
		 *
		 * @since 0.0.1
		 */
		public function __construct() {
			add_action( 'wp_ajax_nopriv_luigi-customizer', array( $this, 'nopriv' ) );
			add_action( 'wp_ajax_luigi-customizer', array( $this, 'route' ) );
			add_action( 'luigi_customizer_route_site_logo', array( $this, 'site_logo' ) );
		}

		/**
		 * Return an error when an ajax request is made without authorization
		 *
		 * @return null Prints a JSON-formatted array and kills execution
		 * @since 0.0.1
		 */
		public function nopriv() {
			wp_send_json_error(
				array(
					'error' => 'logged_out',
					'msg'   => __( 'You have been logged out. Please login again to customize your site.', 'luigi' ),
				)
			);
		}

		/**
		 * Return an error when an ajax request is missing required data
		 *
		 * @param string msg Error message intended for display
		 * @return null Prints a JSON-formatted array and kills execution
		 * @since 0.0.1
		 */
		public function send_error_missing_data( $msg ) {
			wp_send_json_error(
				array(
					'error' => 'missing_data',
					'msg'   => $msg,
				)
			);
		}

		/**
		 * Validate and route an ajax request
		 *
		 * @since 0.0.1
		 */
		public function route() {

			// Authenticate request and check user has required capabilities
			if ( !check_ajax_referer( 'luigi-customizer-ajax', 'nonce', false ) || !current_user_can( 'edit_theme_options' ) ) {
				wp_send_json_error(
					array(
						'error' => 'no_priv',
						'msg'   => __( 'You do not have permission to modify the theme settings. Please login to an administrator account to edit the theme settings.', 'luigi' ),
					)
				);
			}

			// Run hook to execute request
			do_action( 'luigi_customizer_route_' . sanitize_key( $_POST['route'] ) );

			// If we're still here, the route wasn't processed
			wp_send_json_error(
				array(
					'error' => 'invalid_route',
					'msg' => __( 'The request was not recognized. Please try another option.', 'luigi' ),
				)
			);
		}

		/**
		 * Retrieve site logo details
		 *
		 * @since 0.0.1
		 */
		public function site_logo() {

			$missing_msg = __( 'The site logo could not be loaded because an image ID could not be found. Please try to reset your logo.', 'luigi' );

			if ( empty( $_POST['site_logo'] ) ) {
				$this->send_error_missing_data( $missing_msg );
			}

			$attachment = wp_get_attachment_metadata( absint( $_POST['site_logo'] ) );
			if ( empty( $attachment ) ) {
				$this->send_error_missing_data( $missing_msg );
			}

			wp_send_json_success( $attachment );
		}
	}

	new Luigi_Customizer_Ajax_Handler();
}
