<?php
/**
 * Functions used in the customizer
 *
 * @brief Functions used to define custom controls, add controls to the panel,
 *  and handle live preview.
 *
 * @package    luigi
 */
include_once( 'customizer/ajax-handler.php' );

// Initialize the content-layout-control library
include_once( get_template_directory() . '/lib/content-layout-control/dist/content-layout-control.php' );
CLC_Content_Layout_Control(
	array(
		'url' => get_template_directory_uri() . '/lib/content-layout-control/dist',
		'i18n' => array(
			'delete'                        => esc_attr__( 'Delete', 'luigi' ),
			'control-toggle'                => esc_attr__( 'Open/close this component', 'luigi' ),
		),
	)
);

if ( !function_exists( 'luigi_customizer_add_controls' ) ) {
	/**
	 * Add controls to the customizer panel
	 *
	 * @since 0.0.1
	 */
	function luigi_customizer_add_controls( $wp_customize ) {
		include_once( 'customizer/WP_Customize_Scaled_Image_Control.php' );
		$wp_customize->register_control_type( 'Luigi_WP_Customize_Scaled_Image_Control' );

		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
		$wp_customize->get_section( 'title_tagline' )->title = esc_html__( 'Logo, Site Title and Tagline', 'luigi' );

		// Logo
		$wp_customize->add_setting(
			'site_logo',
			array(
				'sanitize_callback' => 'absint',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_setting(
			'site_logo_scale',
			array(
				'default'           => 93,
				'sanitize_callback' => 'absint',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Luigi_WP_Customize_Scaled_Image_Control(
				$wp_customize,
				'site_logo',
				array(
					'label'     => __( 'Logo', 'luigi' ),
					'section'   => 'title_tagline',
					'settings'  => array(
						'site_logo' => 'site_logo',
						'site_logo_scale' => 'site_logo_scale',
					),
					'priority'  => 1,
					'mime_type' => 'image',
					'min'       => 50,
					'max'       => 200,
				)
			)
		);

		// Content Layout Control
		$wp_customize->add_section(
			'content_layout_control',
			array(
				'capability' => 'edit_posts',
				'title'      => __( 'Homepage Editor', 'luigi' ),
			)
		);

		$wp_customize->add_setting(
			'content_layout_control',
			array(
				'sanitize_callback' => 'CLC_Content_Layout_Control::sanitize',
				'transport'         => 'postMessage',
				'type'              => 'content_layout',
			)
		);

		$wp_customize->add_control(
			new CLC_WP_Customize_Content_Layout_Control(
				$wp_customize,
				'content_layout_control',
				array(
					'section'    => 'content_layout_control',
					'priority'   => 1,
					'components' => array( 'luigi-hero-block', 'luigi-content-block', 'luigi-posts-reviews', 'luigi-mixer', 'luigi-map', 'luigi-eo-calendar' ),
					'active_callback' => 'luigi_customizer_clc_active_callback',
					'i18n' => array(
						'add_component'                 => esc_html__( 'Add Component', 'luigi' ),
						'edit_component'                => esc_html__( 'Edit', 'luigi' ),
						'close'                         => esc_attr__( 'Close', 'luigi' ),
						'post_search_label'             => esc_html__( 'Search content', 'luigi' ),
						'links_add_button'              => esc_html__( 'Add Link', 'luigi' ),
						'links_url'                     => esc_html__( 'URL', 'luigi' ),
						'links_text'                    => esc_html__( 'Link Text', 'luigi' ),
						'links_search_existing_content' => esc_html__( 'Search existing content &rarr;', 'luigi' ),
						'links_back'                    => esc_html__( '&larr; Back to link form', 'luigi' ),
					),
				)
			)
		);

		// Footer
		$wp_customize->add_section(
			'footer',
			array(
				'capability' => 'edit_theme_options',
				'title'      => __( 'Footer', 'luigi' ),
			)
		);

		$wp_customize->add_setting(
			'footer_logo',
			array(
				'sanitize_callback' => 'absint',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_setting(
			'footer_logo_scale',
			array(
				'default'           => 72,
				'sanitize_callback' => 'absint',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Luigi_WP_Customize_Scaled_Image_Control(
				$wp_customize,
				'footer_logo',
				array(
					'label'     => __( 'Logo', 'luigi' ),
					'section'   => 'footer',
					'settings'  => array(
						'footer_logo' => 'footer_logo',
						'footer_logo_scale' => 'footer_logo_scale',
					),
					'priority'  => 1,
					'mime_type' => 'image',
					'min'       => 40,
					'max'       => 150,
				)
			)
		);

		$wp_customize->add_setting(
			'footer_description',
			array(
				'default'           => '',
				'sanitize_callback' => 'wp_kses_post',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'footer_description',
			array(
				'label'          => __( 'Site Description', 'luigi' ),
				'section'        => 'footer',
				'type'           => 'textarea',
			)
		);

		$wp_customize->add_setting(
			'copyright',
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'copyright',
			array(
				'label'          => __( 'Copyright', 'luigi' ),
				'section'        => 'footer',
				'type'           => 'text',
			)
		);
	}
	add_action( 'customize_register', 'luigi_customizer_add_controls' );
}

if ( !function_exists( 'luigi_customizer_enqueue_preview_assets' ) ) {
	/**
	 * Load assets to handle the customizer preview panel
	 *
	 * @since 0.0.1
	 */
	function luigi_customizer_enqueue_preview_assets() {


		// Maybe load minified scripts
		$min = SCRIPT_DEBUG ? '' : 'min.';

		wp_enqueue_style( 'luigi-customizer-preview', get_stylesheet_directory_uri() . '/assets/css/customizer-preview.' . $min . 'css', '0.0.1' );
		wp_enqueue_script( 'luigi-customizer-preview-js', get_stylesheet_directory_uri() . '/assets/js/customizer-preview.' . $min . 'js', array( 'luigi-js', 'customize-preview', 'content-layout-preview-js' ), '0.0.1', true );

		$upload_dir = wp_upload_dir();
		wp_localize_script( 'luigi-customizer-preview-js', 'luigi_theme_customizer', array(
			'nonce'          => wp_create_nonce( 'luigi-customizer-ajax' ),
			'upload_dir_url' => $upload_dir['baseurl'],
			'strings'        => array(
				'unknown_error' => __( 'An unknown error occurred. Please try again. If the problem continues, please refresh the page.', 'luigi' ),
			),
		) );

		// Load maps handler for Business Profile
		add_action( 'wp_footer', 'luigi_customizer_load_bpfwp_map_handlers' );
		add_action( 'wp_footer', 'luigi_eo_customizer_load_calendar_handlers', 1 );
	}
	add_action( 'customize_preview_init', 'luigi_customizer_enqueue_preview_assets' );
}

if ( !function_exists( 'luigi_customizer_enqueue_control_assets' ) ) {
	/**
	 * Load assets to handle the customizer control panel
	 *
	 * @since 0.0.1
	 */
	function luigi_customizer_enqueue_control_assets() {


		// Maybe load minified scripts
		$min = SCRIPT_DEBUG ? '' : 'min.';

		wp_enqueue_style( 'luigi-customizer-control', get_stylesheet_directory_uri() . '/assets/css/customizer-control.' . $min . 'css', '0.0.1' );
		wp_enqueue_script( 'luigi-customizer-control-js', get_stylesheet_directory_uri() . '/assets/js/customizer-control.' . $min . 'js', array( 'customize-controls', 'content-layout-control-js' ), '0.0.1', true );

		wp_localize_script( 'luigi-customizer-control-js', 'luigi_theme_customizer_control', array(
			'business_profile_active' => defined( 'BPFWP_VERSION' ),

		) );
	}
	add_action( 'customize_controls_enqueue_scripts', 'luigi_customizer_enqueue_control_assets' );
}

if ( !function_exists( 'luigi_customizer_register_content_layout_control_components' ) ) {
	/**
	 * Register layout control components for the content-layout-control lib
	 *
	 * @since 0.0.1
	 */
	function luigi_customizer_register_content_layout_control_components( $components ) {

		$content_block_i18n = array(
			'title'                         => esc_html__( 'Title', 'luigi' ),
			'content'                       => esc_html__( 'Content', 'luigi' ),
			'image'                         => esc_html__( 'Image', 'luigi' ),
			'image_placeholder'             => esc_html__( 'No image selected', 'luigi' ),
			'image_position'                => esc_html__( 'Image Position', 'luigi' ),
			'image_position_left'           => esc_html__( 'Left', 'luigi' ),
			'image_position_right'          => esc_html__( 'Right', 'luigi' ),
			'image_select_button'           => esc_html__( 'Select Image', 'luigi' ),
			'image_change_button'           => esc_html__( 'Change Image', 'luigi' ),
			'image_remove_button'           => esc_html__( 'Remove', 'luigi' ),
			'links'                         => esc_html__( 'Links', 'luigi' ),
			'links_add_button'              => esc_html__( 'Add Link', 'luigi' ),
			'links_remove_button'           => esc_html__( 'Remove', 'luigi' ),
		);

		$components['luigi-hero-block'] = array(
			'file'        => get_template_directory() . '/includes/customizer/content-layout-control/components/luigi-hero-block.php',
			'class'       => 'Luigi_CLC_Component_Hero_Block',
			'name'        => __( 'Hero Block', 'luigi' ),
			'description' => __( 'A prominent call to action on a full-width background image.', 'luigi' ),
			'i18n'        => array_merge(
				$content_block_i18n,
				array(
					'title_line_one'                => esc_attr__( 'Title (top)', 'luigi' ),
					'title'                         => esc_attr__( 'Title (bottom)', 'luigi' ),
					'contact'                       => esc_attr__( 'Contact Detail', 'luigi' ),
					'none'                          => esc_attr__( 'None', 'luigi' ),
					'phone'                         => esc_attr__( 'Phone Number', 'luigi' ),
					'find'                          => esc_attr__( 'Contact Popup', 'luigi' ),
					'find_text_default'             => esc_attr__( 'Find Us', 'luigi' ),
					'image_transparency'            => esc_attr__( 'Darken Image', 'luigi' ),
				)
			),
		);

		$components['luigi-content-block'] = array(
			'file'        => get_template_directory() . '/includes/customizer/content-layout-control/components/luigi-content-block.php',
			'class'       => 'Luigi_CLC_Component_Content_Block',
			'name'        => esc_html__( 'Content Block', 'luigi' ),
			'description' => esc_html__( 'A simple content block with an image, title, text and links.', 'luigi' ),
			'i18n'        => array_merge(
				$content_block_i18n,
				array(
					'title_line_one' => esc_attr__( 'Title (top)', 'luigi' ),
					'title' => esc_attr__( 'Title (bottom)', 'luigi' ),
				)
			),
		);

		global $grfwp_controller;
		if ( isset( $grfwp_controller ) ) {
			$components['luigi-posts-reviews'] = array(
				'file'        => get_template_directory() . '/includes/customizer/content-layout-control/components/luigi-posts-reviews.php',
				'class'       => 'Luigi_CLC_Component_Reviews',
				'name'        => esc_html__( 'Review', 'luigi' ),
				'description' => esc_html__( 'Display one or more reviews.', 'luigi' ),
				'limit_posts' => 3,
				'i18n'        => array(
					'posts_loading' => esc_html__( 'Loading', 'luigi' ),
					'posts_remove_button' => esc_html__( 'Remove', 'luigi' ),
					'placeholder'         => esc_html__( 'No review selected.', 'luigi' ),
					'posts_add_button'    => esc_html__( 'Add Review', 'luigi' ),
				),
			);
		}

		global $bpfwp_controller;
		if ( isset( $bpfwp_controller ) ) {
			$components['luigi-map'] = array(
				'file'          => get_template_directory() . '/includes/customizer/content-layout-control/components/luigi-map.php',
				'class'         => 'Luigi_CLC_Component_Map',
				'name'          => esc_html__( 'Map', 'luigi' ),
				'description'   => esc_html__( 'A full-width map identifying your location.', 'luigi' ),
				'i18n'          => array(
					'description' => sprintf( esc_html__( 'To change the address, edit your %sBusiness Profile%s.', 'luigi' ), '<a href="' . esc_url( admin_url( 'admin.php?page=bpfwp-settings' ) ) . '">', '</a>' ),
				),
			);
		}

		if ( defined( 'EVENT_ORGANISER_VER' ) && strnatcmp( EVENT_ORGANISER_VER, '3' ) >= 0 ) {
			$components['luigi-eo-calendar'] = array(
				'file'          => get_template_directory() . '/includes/customizer/content-layout-control/components/luigi-eo-calendar.php',
				'class'         => 'Luigi_CLC_Component_EO_Calendar',
				'name'          => esc_html__( 'Event Calendar', 'luigi' ),
				'description'   => esc_html__( 'A monthly calendar displaying your upcoming events.', 'luigi' ),
				'i18n'          => array(
					'description' => sprintf( esc_html__( 'Add and edit events from your %sevents management page%s.', 'luigi' ), '<a href="' . esc_url( admin_url( 'edit.php?post_type=event' ) ) . '">', '</a>' ),
				),
			);
		}

		global $rtb_controller;
		if ( isset( $bpfwp_controller ) || $rtb_controller ) {
			$components['luigi-mixer'] = array(
				'file'          => get_template_directory() . '/includes/customizer/content-layout-control/components/luigi-mixer.php',
				'class'         => 'Luigi_CLC_Component_Mixer',
				'name'          => esc_html__( 'Mix-and-Match', 'luigi' ),
				'description'   => esc_html__( 'Pair two items in a row. Select from opening hours, a map, latest posts and more.', 'luigi' ),
				'valid_options' => luigi_customizer_clc_mixer_options(),
				'i18n'          => array(
					'left'  => esc_html__( 'Left Content', 'luigi' ),
					'right' => esc_html__( 'Right Content', 'luigi' ),
					'left_title'  => esc_html__( 'Left Title', 'luigi' ),
					'right_title' => esc_html__( 'Right Title', 'luigi' ),
				),
			);
		}

		return $components;
	}
	add_filter( 'clc_register_components', 'luigi_customizer_register_content_layout_control_components' );
}

if ( !function_exists( 'luigi_customizer_clc_mixer_options' ) ) {
	/**
	 * Compile the list of valid options for the mixer component based on
	 * active plugins and settings
	 *
	 * @since 0.1
	 */
	function luigi_customizer_clc_mixer_options() {

		$options = array( 'blog' => __( 'Latest Blog Posts', 'luigi' ) );

		if ( luigi_bp_setting_exists( 'opening-hours' ) ) {
			$options['opening_hours'] = __( 'Opening Hours', 'luigi' );
		}

		global $bpfwp_controller;
		if ( isset( $bpfwp_controller ) ) {
			$options['contact'] = __( 'Contact Card', 'luigi' );

			$address = $bpfwp_controller->settings->get_setting( 'address' );
			if ( !empty( $address['text'] ) || ( !empty( $address['lat'] ) && !empty( $address['lon'] ) ) ) {
				$options['map'] = __( 'Map', 'luigi' );
			}
		}

		global $rtb_controller;
		if ( isset( $rtb_controller ) ) {
			$options['booking_form'] = __( 'Booking Form', 'luigi' );
		}

		return $options;
	}
}

if ( !function_exists( 'luigi_customizer_clc_active_callback' ) ) {
	/**
	 * Active callback function for displaying the content layout control
	 *
	 * @since 0.1
	 */
	function luigi_customizer_clc_active_callback() {
		return is_page() && is_front_page();
	}
}

if ( !function_exists( 'luigi_customizer_clc_maybe_control_post_edit' ) ) {
	/**
	 * Remove the editor from pages that the content-layout-control works with.
	 *
	 * @since 0.1
	 */
	function luigi_customizer_clc_maybe_control_post_edit() {

		global $post;
		if ( !is_a( $post, 'WP_Post' ) || $post->post_type !== 'page' ) {
			return;
		}

		$page_on_front = get_option('page_on_front');
		if ( $post->ID !== $page_on_front ) {
			return;
		}

		$clc_enabled = apply_filters( 'luigi_enable_clc_post_editor_override', true );
		if ( !$clc_enabled ) {
			return;
		}

		remove_post_type_support( $post->post_type, 'editor' );
		remove_post_type_support( $post->post_type, 'revisions' );
		remove_meta_box( 'submitdiv', 'page', 'side' );
		remove_meta_box( 'pageparentdiv', 'page', 'side' );
		remove_meta_box( 'authordiv', 'page', 'normal' );
		remove_meta_box( 'postcustom', 'page', 'normal' );
		remove_meta_box( 'postexcerpt', 'page', 'normal' );
		remove_meta_box( 'commentsdiv', 'page', 'normal' );
		remove_meta_box( 'postimagediv', 'page', 'side' );
		remove_meta_box( 'slugdiv', 'page', 'normal' );
		remove_meta_box( 'trackbacksdiv', 'page', 'normal' );
		remove_meta_box( 'commentsdiv', 'page', 'normal' );
		remove_meta_box( 'commentstatusdiv', 'page', 'normal' );
		remove_meta_box( 'revisionsdiv', 'page', 'normal' );
		remove_meta_box( 'wp_featherlight_options', 'page', 'side' );
		remove_meta_box( 'ninja_forms_selector', 'page', 'side' );
		remove_meta_box( 'wpseo_meta', 'page', 'normal' );

		add_meta_box(
			'luigi_clc_edit_notice',
			esc_html__( 'Homepage', 'luigi' ),
			'luigi_customizer_clc_print_meta_box',
			null,
			'side'
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
