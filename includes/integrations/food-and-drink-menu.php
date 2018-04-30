<?php
/**
 * Functions used to integrate with the Food and Drink Menu plugin
 *
 * @package luigi
 */
if ( !function_exists( 'luigi_fdm_move_item_image' ) ) {
	/**
	 * Move the image and specials locations in the item template
	 *
	 * @since 0.1
	 */
	function luigi_fdm_move_item_image( $elements, $view ) {

		if ( isset( $elements['image'] ) ) {
			$elements['image'] = 'header';
		}

		if ( isset( $elements['special'] ) ) {
			$elements['special'] = 'body';
		}

		return $elements;
	}
	add_filter( 'fdm_menu_item_elements', 'luigi_fdm_move_item_image', 10, 2 );
}

if ( !function_exists( 'luigi_fdm_remove_style_settings' ) ) {
	/**
	 * Remove style-related settings for Food and Drink Menu
	 *
	 * @since 0.1
	 */
	function luigi_fdm_remove_style_settings( $sap ) {
		unset( $sap->pages['food-and-drink-menu-settings']->sections['fdm-style-settings'] );
		unset( $sap->pages['food-and-drink-menu-settings']->sections['fdm-advanced-settings'] );

		return $sap;
	}
	add_filter( 'fdm_settings_page', 'luigi_fdm_remove_style_settings', 200 );
}

if ( !function_exists( 'luigi_fdm_remove_taxonomy_frontend_urls' ) ) {
	/**
	 * Remove Menu Section and Item Flag taxonomy archives on the frontend
	 *
	 * @since 0.1
	 */
	function luigi_fdm_remove_taxonomy_frontend_urls( $args ) {
		$args['fdm-menu-section']['public'] = false;
		$args['fdm-menu-section']['show_ui'] = true;

		if ( isset( $args['fdm-menu-item-flag'] ) ) {
			$args['fdm-menu-item-flag']['public'] = false;
			$args['fdm-menu-item-flag']['show_ui'] = true;
		}

		return $args;
	}
	add_filter( 'fdm_menu_item_taxonomies', 'luigi_fdm_remove_taxonomy_frontend_urls', 20 );
}

if ( !function_exists( 'luigi_fdm_exclude_menu_item_from_search' ) ) {
	/**
	 * Exclude menu item post type from search
	 *
	 * @since 0.1
	 */
	function luigi_fdm_exclude_menu_item_from_search( $args ) {
		$args['exclude_from_search'] = true;

		return $args;
	}
	add_filter( 'fdm_menu_item_args', 'luigi_fdm_exclude_menu_item_from_search' );
}

if ( !function_exists( 'luigi_fdmp_get_plugin_version' ) ) {
	/**
	 * Get the current version of Food and DRink Menu Pro, or false if it's not
	 * active.
	 *
	 * @since 1.1.4
	 */
	function luigi_fdmp_get_plugin_version() {

		if ( !defined( 'FDMP_PLUGIN_FNAME' ) ) {
			return false;
		}

		$fdmp = get_plugin_data( FDMP_PLUGIN_FPATH );
		return $fdmp['Version'];
	}
}

if ( !function_exists( 'luigi_fdmp_trigger_icon_font' ) ) {
	/**
	 * Initiate a call to load the item flag icon font when a menu is printed
	 *
	 * @param string $output HTML output of the menu
	 * @param fdmViewMenu $menu Menu view object
	 * @since 1.1.4
	 */
	function luigi_fdmp_trigger_icon_font( $output, $menu ) {

		include_once(ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( is_plugin_active( 'food-and-drink-menu-pro/food-and-drink-menu-pro.php' ) ) {
			add_action( 'wp_footer', 'luigi_fdmp_load_icon_font' );
		}

		return $output;
	}
	add_filter( 'fdm_menu_output', 'luigi_fdmp_trigger_icon_font', 10, 2 );
}

if ( !function_exists( 'luigi_fdmp_load_icon_font' ) ) {
	/**
	 * Enqueue the item flag icon font
	 *
	 * @since 1.1.4
	 */
	function luigi_fdmp_load_icon_font() {

		$fdmp_version = luigi_fdmp_get_plugin_version();
		if ( !$fdmp_version || version_compare( $fdmp_version, '1.4', '<' ) || !defined( 'FDMP_PLUGIN_URL' ) ) {
			return;
		}

		?>
		<style type="text/css">
			@font-face {
				font-family: 'food-and-drink-menu-icons';
				src: url('<?php echo FDMP_PLUGIN_URL; ?>/assets/fonts/food-and-drink-menu-icons.eot?4zwtn9');
				src: url('<?php echo FDMP_PLUGIN_URL; ?>/assets/fonts/food-and-drink-menu-icons.eot?4zwtn9#iefix') format('embedded-opentype'),
					url('<?php echo FDMP_PLUGIN_URL; ?>/assets/fonts/food-and-drink-menu-icons.ttf?4zwtn9') format('truetype'),
					url('<?php echo FDMP_PLUGIN_URL; ?>/assets/fonts/food-and-drink-menu-icons.woff?4zwtn9') format('woff'),
					url('<?php echo FDMP_PLUGIN_URL; ?>/assets/fonts/food-and-drink-menu-icons.svg?4zwtn9#food-and-drink-menu-icons') format('svg');
				font-weight: normal;
				font-style: normal;
			}
		</style>
		<?php
	}
}

if ( !function_exists( 'luigi_fdmp_body_class_deprecated_icons' ) ) {
	/**
	 * Add a body class to load the deprecated icons if Food and Drink Menu Pro
	 * has not been updated
	 *
	 * @param array $classes Classes to add to the body tag
	 * @since 1.1.4
	 */
	function luigi_fdmp_body_class_deprecated_icons( $classes ) {

		include_once(ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( !is_plugin_active( 'food-and-drink-menu-pro/food-and-drink-menu-pro.php' ) ) {
			return $classes;
		}

		$fdmp_version = luigi_fdmp_get_plugin_version();
		if ( !$fdmp_version || version_compare( $fdmp_version, '1.4', '<' ) ) {
			$classes[] = 'fdmp-deprecated-item-flag-icons';
		}

		return $classes;
	}
	add_filter( 'body_class', 'luigi_fdmp_body_class_deprecated_icons' );
}
