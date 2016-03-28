<?php
/**
 * Helper functions for the templates
 *
 * @brief These functions help reduce the amount of logic required in the
 *  template files.
 *
 * @package    luigi
 */

if ( !function_exists( 'luigi_print_logo' ) ) {
	/**
	 * Print the logo
	 *
	 * @since 0.0.1
	 */
	function luigi_print_logo( $logo_setting = 'site_logo', $scale_setting = 'site_logo_scale' ) {

		$logo_url = wp_get_attachment_url( get_theme_mod( $logo_setting ) );
		if ( !$logo_url ) {
			return;
		}

		$scale = get_theme_mod( $scale_setting, 93 );
		$scale = $scale == 93 ? '' : ' style="max-height: ' . absint( $scale ) . 'px"';
		?>

		<img src="<?php echo esc_url( $logo_url ); ?>" class="logo-image" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"<?php echo $scale; ?>>

		<?php
	}
}

if ( !function_exists( 'luigi_print_footer_logo' ) ) {
	/**
	 * Print the footer logo
	 *
	 * @since 0.0.1
	 */
	function luigi_print_footer_logo() {
		luigi_print_logo( 'footer_logo', 'footer_logo_scale' );
	}
}

if ( !function_exists( 'luigi_print_phone' ) ) {
	/**
	 * Print the phone number from their Business Profile
	 *
	 * @since 0.0.1
	 */
	function luigi_print_phone() {
		if ( function_exists( 'bpwfwp_print_contact_card' ) ) {
			echo bpwfwp_print_contact_card(
				array(
					'show_name'                 => false,
					'show_address'              => false,
					'show_get_directions'       => false,
					'show_phone'                => true,
					'show_contact'              => false,
					'show_opening_hours'        => false,
					'show_opening_hours_brief'  => false,
					'show_map'                  => false,
					'show_booking_link'         => false,
				)
			);
		}
	}
}

if ( !function_exists( 'luigi_wrap_first_word' ) ) {
	/**
	 * Wrap the first word of a string in a <span> tag for styling
	 *
	 * @since 0.0.1
	 */
	function luigi_wrap_first_word( $string ) {

		$words = explode( ' ', $string );
		$first = $words[0];

		$rest = '';
		if ( count( $words ) > 1 ) {
			$rest = join( ' ', array_splice( $words, 1 ) );
		}

		return '<span class="luigi-first-word">' . $first . '</span>' . $rest;
	}
}

if ( !function_exists( 'luigi_bp_setting_exists' ) ) {
	/**
	 * Check if a setting in exists in their business profile
	 *
	 * @since 0.0.1
	 */
	function luigi_bp_setting_exists( $setting ) {

		global $bpfwp_controller;
		if ( !isset( $bpfwp_controller ) ) {
			return false;
		}

		$setting = $bpfwp_controller->settings->get_setting( $setting );
		return !empty( $setting );
	}
}

if ( !function_exists( 'luigi_rtb_setting_exists' ) ) {
	/**
	 * Check if a setting exists in restaurant reservations
	 *
	 * @since 0.0.1
	 */
	function luigi_rtb_setting_exists( $setting ) {

		global $rtb_controller;
		if ( !isset( $rtb_controller ) ) {
			return false;
		}

		$setting = $rtb_controller->settings->get_setting( $setting );
		return !empty( $setting );
	}
}

if ( !function_exists( 'luigi_print_hero_contact' ) ) {
	/**
	 * Check if we have the information we need to print the contact setting in
	 * the hero block.
	 *
	 * @since 0.0.1
	 */
	function luigi_print_hero_contact( $contact ) {
		if ( empty( $contact ) ) {
			return false;
		}

		if ( $contact == 'phone' ) {
			return luigi_bp_setting_exists( 'phone' );
		} elseif ( $contact == 'find' ) {
			return luigi_bp_setting_exists( 'address' );
		}

		return false;
	}
}

if ( !function_exists( 'luigi_get_attachment_img_src_url' ) ) {
	/**
	 * Retrive the URL for an attachment image
	 *
	 * @since 0.0.1
	 */
	function luigi_get_attachment_img_src_url( $attachment_id, $size ) {
		$img = wp_get_attachment_image_src( $attachment_id, $size );
		return $img[0];
	}
}

if ( !function_exists( 'luigi_clc_the_content' ) ) {
	/**
	 * Print `the_content` without the `wpautop` filter. Designed to be used
	 * to print the content from the `content-layout-control` lib.
	 *
	 * @since 0.0.1
	 */
	function luigi_clc_the_content() {
		remove_filter( 'the_content', 'wpautop' );
		the_content();
		add_filter( 'the_content', 'wpautop' );
	}
}

if ( !function_exists( 'luigi_print_mixer_content' ) ) {
	/**
	 * Print requested content in the Mixer component for the
	 * `content-layout-control` lib.
	 *
	 * @since 0.0.1
	 */
	function luigi_print_mixer_content( $type ) {

		ob_start();

		switch( $type ) {
			case 'blog':
				echo '[luigi-recent-posts posts=2]';
				break;
			case 'opening_hours':
				include( get_template_directory() . '/includes/customizer/content-layout-control/components/templates/luigi-mixer-opening-hours.php' );
				break;
			case 'contact':
				echo '[contact-card show_opening_hours=0]';
				break;
			case 'map':
				echo '[contact-card show_name=0 show_address=0 show_get_directions=0 show_phone=0 show_contact=0 show_opening_hours=0 show_booking_link=0]';
				break;
			case 'booking_form':
				echo '[booking-form]';
				break;
		}

		echo apply_filters( 'luigi_print_mixer_content', ob_get_clean() );
	}
}

if ( !function_exists( 'luigi_categorized_blog' ) ) {
	/**
	 * Returns true if a blog has more than 1 category.
	 *
	 * Helper function taken from _s: https://github.com/Automattic/_s/
	 *
	 * @return bool
	 * @since 0.0.1
	 */
	function luigi_categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'luigi_categories' ) ) ) {
			$all_the_cool_cats = get_categories( array(
				'fields'     => 'ids',
				'hide_empty' => 1,
				'number'     => 2,
			) );
			$all_the_cool_cats = count( $all_the_cool_cats );
			set_transient( 'luigi_categories', $all_the_cool_cats );
		}
		return $all_the_cool_cats > 1;
	}
}

if ( !function_exists( 'luigi_category_transient_flusher' ) ) {
	/**
	 * Flush out the transients used in luigi_categorized_blog
	 *
	 * @since 0.0.1.
	 */
	function luigi_category_transient_flusher() {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		delete_transient( 'luigi_categories' );
	}
	add_action( 'edit_category', 'luigi_category_transient_flusher' );
	add_action( 'save_post',     'luigi_category_transient_flusher' );
}

if ( !function_exists( 'luigi_menu_has_two_cols' ) ) {
	/**
	 * Check if a menu has two columns
	 *
	 * @since 0.1
	 */
	function luigi_menu_has_two_cols( $id = 0 ) {
		$id = $id ? $id : get_the_ID();
		$has_two_cols = get_post_meta( get_the_ID(), 'fdm_menu_column_two', true );

		return !empty( $has_two_cols );
	}
}

if ( !function_exists( 'luigi_the_posts_navigation' ) ) {
	/**
	 * Wrapper for the_posts_navigation which defines the locale strings in one
	 * place.
	 *
	 * @since 0.1
	 */
	function luigi_the_posts_navigation() {
		the_posts_navigation(
			array(
				'prev_text' => esc_html__( '&larr; Older posts', 'luigi' ),
				'next_text' => esc_html__( 'Newer posts &rarr;', 'luigi' ),
			)
		);
	}
}
