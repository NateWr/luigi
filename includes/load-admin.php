<?php
/**
 * Functions used in the wordPress admin area
 *
 * @brief Functions used to adjust the page editing screen
 *
 * @package    luigi
 */

if ( !function_exists( 'luigi_customizer_clc_maybe_control_post_edit' ) ) {
	/**
	 * Remove the editor from pages that the content-layout-control works with.
	 *
	 * @since 0.1
	 */
	function luigi_customizer_clc_maybe_control_post_edit() {

		if ( !luigi_customizer_clc_is_layout_post() ) {
			return;
		}

		$clc_enabled = apply_filters( 'luigi_enable_clc_post_editor_override', true );
		if ( !$clc_enabled ) {
			return;
		}

		global $post;

		remove_post_type_support( $post->post_type, 'revisions' );
		remove_meta_box( 'pageparentdiv', 'page', 'side' );
		remove_meta_box( 'authordiv', 'page', 'normal' );
		remove_meta_box( 'postcustom', 'page', 'normal' );
		remove_meta_box( 'postexcerpt', 'page', 'normal' );
		remove_meta_box( 'commentsdiv', 'page', 'normal' );
		remove_meta_box( 'postimagediv', 'page', 'side' );
		remove_meta_box( 'trackbacksdiv', 'page', 'normal' );
		remove_meta_box( 'commentsdiv', 'page', 'normal' );
		remove_meta_box( 'commentstatusdiv', 'page', 'normal' );
		remove_meta_box( 'revisionsdiv', 'page', 'normal' );
		remove_meta_box( 'wp_featherlight_options', 'page', 'side' );
		remove_meta_box( 'ninja_forms_selector', 'page', 'side' );

		// If Yoast SEO is not active, we can remove a couple other items
		if ( !defined( 'WPSEO_VERSION' ) ) {
			remove_post_type_support( $post->post_type, 'editor' );
			remove_meta_box( 'submitdiv', 'page', 'side' );
			remove_meta_box( 'slugdiv', 'page', 'normal' );
			remove_meta_box( 'wpseo_meta', 'page', 'normal' );
			$clc_metabox_position = 'side';

		} else {
			// Hide the post editor from view so the user can't make changes
			if ( apply_filters( 'luigi_clc_hide_post_editor_css', true ) ) {
				echo '<style type="text/css">#postdivrich { display: none; }</style>';
			}
			$clc_metabox_position = 'normal';
		}

		add_meta_box(
			'luigi_clc_edit_notice',
			esc_html__( 'Homepage', 'luigi' ),
			'luigi_customizer_clc_print_meta_box',
			null,
			$clc_metabox_position,
			'high'
		);

	}
	add_action( 'admin_head', 'luigi_customizer_clc_maybe_control_post_edit' );
}

if ( !function_exists( 'luigi_customizer_clc_print_meta_box' ) ) {
	/**
	 * Print a small manual meta box under the post title which includes a
	 * link to edit the post in the customizer.
	 *
	 * @since 0.1
	 */
	function luigi_customizer_clc_print_meta_box() {

		global $post;

		$args = array(
			'url' => get_permalink( $post ),
			'return' => get_edit_post_link( $post->ID, 'raw' ),
			'clc_onload_focus_control' => '1',
		);
		$url = admin_url( 'customize.php' ) . '?' . http_build_query( $args );

		?>

			<p>
				<a class="button-primary" href="<?php echo esc_url( $url ); ?>">
					<?php esc_html_e( 'Homepage Editor', 'luigi' ); ?>
				</a>
			</p>
			<p class="description">
				<?php
					printf(
						__( 'Edit your homepage using the Homepage Editor in the Customizer. %sLearn More%s', 'luigi' ),
						'<a href="http://doc.themeofthecrop.com/themes/luigi/user/faq#homepage">',
						'</a>'
					);
				?>
			</p>

		<?php
	}
}

if ( !function_exists( 'luigi_customizer_clc_move_yoast_metabox' ) ) {
	/**
	 * Move the Yoast metabox below the homepage editor metabox
	 *
	 * @since 1.0.1
	 */
	function luigi_customizer_clc_move_yoast_metabox() {

		if ( !luigi_customizer_clc_is_layout_post() ) {
			return 'high';
		}

		$clc_enabled = apply_filters( 'luigi_enable_clc_post_editor_override', true );
		if ( !$clc_enabled ) {
			return 'high';
		}

		return 'default';
	}
	add_action( 'wpseo_metabox_prio', 'luigi_customizer_clc_move_yoast_metabox' );
}

if ( !function_exists( 'luigi_customizer_clc_is_layout_post' ) ) {
	/**
	 * Check if a post is controlled by the content-layout-control
	 *
	 * @since 1.0.1
	 */
	function luigi_customizer_clc_is_layout_post( $post_id = null ) {
		if ( !$post_id ) {
			global $post;
			if ( isset( $post ) && get_class( $post ) == 'WP_Post' ) {
				$post_id = $post->ID;
			}

			if ( !$post_id ) {#
				return;
			}
		}

		$page_on_front = get_option('page_on_front');
		if ( $post_id !== $page_on_front ) {
			return false;
		}

		return true;
	}
}
