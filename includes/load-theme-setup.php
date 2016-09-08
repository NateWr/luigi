<?php
/**
 * Functions used to load the Theme Setup admin page
 *
 * @brief Functions used to load the theme setup library to add a page and
 *  manage demo content.
 *
 * @package    luigi
 */
include_once( get_template_directory() . '/lib/totc-theme-setup/totc-theme-setup.php' );

add_action( 'admin_menu', 'totc_theme_setup_add_menu_page' );
add_action( 'wp_ajax_totc-theme-setup', 'totc_theme_setup_handle_ajax_requests' );
add_action( 'wp_ajax_nopriv_totc-theme-setup', 'totc_theme_setup_handle_nopriv_ajax_requests' );

if ( !function_exists( 'luigi_theme_setup_strings' ) ) {
	function luigi_theme_setup_strings( $strings ) {

		$strings['lib.url_base'] = get_template_directory_uri() . '/lib/totc-theme-setup';
		$strings['page.title'] = __( 'Theme Setup', 'luigi' );
		$strings['page.menu.title'] = __( 'Theme Setup', 'luigi' );
		$strings['page.no.access'] = __( 'You do not have sufficient permissions to access this page.', 'luigi' );
		$strings['page.demo.section'] = __( 'Demo Content', 'luigi' );
		$strings['page.demo.install_plugin'] = __( 'Install', 'luigi' );
		$strings['page.demo.install_plugin.no_permission'] = __( 'You must install this plugin before you can add demo content, but you do not have permission to install plugins. Please contact your web administrator for assistance.', 'luigi' );
		$strings['page.demo.activate_plugin'] = __( 'Activate Plugin', 'luigi' );
		$strings['page.demo.activate_plugin.no_permission'] = __( 'You must activate this plugin before you can add demo content, but you do not have permission to activate plugins. Please contact your web administrator for assistance.', 'luigi' );
		$strings['page.demo.install_demo'] = __( 'Install Demo Content', 'luigi' );
		$strings['page.demo.install_demo.no_permission'] = __( 'You do not have permission to install demo content. Please contact your web administrator for assistance.', 'luigi' );
		$strings['page.demo.view_demo'] = __( 'View Demo', 'luigi' );
		$strings['page.documentation.section'] = __( 'Documentation & Support', 'luigi' );
		$strings['page.documentation.help'] = __( 'Help Documentation', 'luigi' );
		$strings['page.documentation.help.url'] = 'http://doc.themeofthecrop.com/themes/luigi?utm_source=Theme&utm_medium=Theme%20Help&utm_campaign=Luigi';
		$strings['page.documentation.help.description'] = __( 'Read the help guide for this theme', 'luigi' );
		$strings['page.documentation.support'] = __( 'Support', 'luigi' );
		$strings['page.documentation.support.url'] = 'https://themeofthecrop.com/about/support/';
		$strings['page.documentation.support.description'] = sprintf( __( 'Get %sone-on-one support%s if you are having trouble or need customizations done.', 'luigi' ), '<a href="https://themeofthecrop.com/about/support/">', '</a>' );
		$strings['page.documentation.demo'] = __( 'Theme Demo', 'luigi' );
		$strings['page.documentation.demo.url'] = 'https://themeofthecrop.com/demo/luigi'; // @TODO make sure this is correct
		$strings['page.documentation.demo.description'] = __( 'View an online demo of this theme', 'luigi' );
		$strings['ajax.installing'] = __( 'Installing', 'luigi' );
		$strings['ajax.error.nopriv'] = __( 'You have been logged out. Please login again before continuing.', 'luigi' );
		$strings['ajax.error.unknown'] = __( 'An unexpected error occur. Please reload the page and try again.', 'luigi' );
		$strings['ajax.error.route_unknown'] = __( 'Your request could not be processed. Please reload the page and try again', 'luigi' );


		return $strings;
	}
	add_filter( 'totc_theme_setup_strings', 'luigi_theme_setup_strings' );
}

if ( !function_exists( 'luigi_theme_setup_demos' ) ) {
	function luigi_theme_setup_demos( $demos ) {

		include_once( get_template_directory() . '/lib/totc-theme-setup/includes/Demo.class.php' );
		include_once( get_template_directory() . '/lib/totc-theme-setup/includes/Demo.food-and-drink-menu.class.php' );
		include_once( get_template_directory() . '/lib/totc-theme-setup/includes/Demo.restaurant-reservations.class.php' );
		include_once( get_template_directory() . '/lib/totc-theme-setup/includes/Demo.business-profile.class.php' );
		include_once( get_template_directory() . '/lib/totc-theme-setup/includes/Demo.good-reviews-wp.class.php' );
		include_once( get_template_directory() . '/lib/totc-theme-setup/includes/Demo.event-organiser.class.php' );

		// Food and Drink Menu
		$demos[] = new totcThemeSetupDemoFoodAndDrinkMenu(
			array(
				'title' => __( 'Food and Drink Menu', 'luigi' ),
				'strings' => array(
					'menu.title' => _x( 'Demo Menu', 'This phrase is used in the Food and Drink Menu demo content installed from the Theme Setup page.', 'luigi' ),
					'section.starters' => _x( 'Starters', 'This phrase is used in the Food and Drink Menu demo content installed from the Theme Setup page.', 'luigi' ),
					'section.entrees' => _x( 'Entrees', 'This phrase is used in the Food and Drink Menu demo content installed from the Theme Setup page.', 'luigi' ),
					'section.desserts' => _x( 'Desserts', 'This phrase is used in the Food and Drink Menu demo content installed from the Theme Setup page.', 'luigi' ),
					'item.title' => _x( 'Demo Menu Dish %s', 'This phrase is used in the Food and Drink Menu demo content installed from the Theme Setup page.', 'luigi' ),
					'item.description' => _x( 'A delicious dish made of the finest, carefully selected ingredients.', 'This phrase is used in the Food and Drink Menu demo content installed from the Theme Setup page.', 'luigi' ),
					'item.price' => _x( '$12.99', 'This phrase is used in the Food and Drink Menu demo content installed from the Theme Setup page.', 'luigi' ),
				),
			)
		);

		$demos[] = new totcThemeSetupDemoRestaurantReservations(
			array(
				'title' => __( 'Restaurant Reservations', 'luigi' ),
				'strings' => array(
					'post.content' => _x( 'This is a demo of the Restaurant Reservations booking form', 'This phrase is used in the Restaurant Reservations demo content installed from the Theme Setup page.', 'luigi' ),
					'post.title' => _x( 'Booking Form Demo', 'This phrase is used in the Restaurant Reservations demo content installed from the Theme Setup page.', 'luigi' ),
				),
			)
		);

		$demos[] = new totcThemeSetupDemoBusinessProfile(
			array(
				'title' => __( 'Business Profile', 'luigi' ),
				'strings' => array(
					'title' => _x( 'Contact Card Demo', 'This phrase is used in the Restaurant Reservations demo content installed from the Theme Setup page.', 'luigi' ),
					'address' => _x( "1600 Amphitheatre Parkway\nMountain View, CA 94043", 'This phrase is used in the Restaurant Reservations demo content installed from the Theme Setup page.', 'luigi' ),
					'phone' => _x( '(123) 456-7890', 'This phrase is used in the Restaurant Reservations demo content installed from the Theme Setup page.', 'luigi' ),
					'email' => _x( 'contact@example.com', 'This phrase is used in the Restaurant Reservations demo content installed from the Theme Setup page.', 'luigi' ),
				),
			)
		);

		$demos[] = new totcThemeSetupDemoGoodReviewsForWordPress(
			array(
				'title' => __( 'Good Reviews for WordPress', 'luigi' ),
				'strings' => array(
					'page.title' => _x( 'Good Reviews Demo', 'This phrase is used in the Good Reviews for WordPress demo content installed from the Theme Setup page.', 'luigi' ),
					'post.content' => _x( "This is a fabulous review! We were so excited by this website that we just had to go back for more. We've been three times now!", 'This phrase is used in the Good Reviews for WordPress demo content installed from the Theme Setup page.', 'luigi' ),
					'post.title' => _x( 'Reviewer Name %s', 'This phrase is used in the Good Reviews for WordPress demo content installed from the Theme Setup page.', 'luigi' ),
					'post.review_url' => _x( 'http://example.com', 'This phrase is used in the Good Reviews for WordPress demo content installed from the Theme Setup page.', 'luigi' ),
					'post.reviewer_org' => _x( 'Critic Magazine', 'This phrase is used in the Good Reviews for WordPress demo content installed from the Theme Setup page.', 'luigi' ),
					'post.reviewer_url' => _x( 'http://example.com', 'This phrase is used in the Good Reviews for WordPress demo content installed from the Theme Setup page.', 'luigi' ),
				),
			)
		);

		$demos[] = new totcThemeSetupDemoEventOrganiser(
			array(
				'title' => __( 'Event Organiser', 'luigi' ),
				'strings' => array(
					'calendar.title' => _x( 'Event Calendar Demo', 'This phrase is used in the Restaurant Reservations demo content installed from the Theme Setup page.', 'luigi' ),
					'event.title' => _x( 'Demo Event %s', 'This phrase is used in the Restaurant Reservations demo content installed from the Theme Setup page.', 'luigi' ),
					'event.content' => _x( 'This is a sample event created with the Event Organiser plugin.', 'This phrase is used in the Restaurant Reservations demo content installed from the Theme Setup page.', 'luigi' ),
				),
			)
		);

		return $demos;
	}
	add_filter( 'totc_theme_setup_demo_handlers', 'luigi_theme_setup_demos' );
}
