<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD Sample Theme
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

$theme = wp_get_theme( 'luigi' );

// Loads the updater classes
$updater = new EDD_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://themeofthecrop.com', // Site where EDD is hosted
		'item_name' => 'Luigi', // Name of theme
		'theme_slug' => 'luigi', // Theme slug
		'version' => $theme->get( 'Version' ), // The current version of this theme
		'author' => 'Theme of the Crop', // The author of this theme
		'download_id' => 13087, // Optional, used for generating a license renewal link
		'renew_url' => '' // Optional, allows for a custom license renewal link
	),

	// Strings
	$strings = array(
		'theme-license' => __( 'Theme License', 'luigi' ),
		'enter-key' => __( 'Enter your theme license key.', 'luigi' ),
		'license-key' => __( 'License Key', 'luigi' ),
		'license-action' => __( 'License Action', 'luigi' ),
		'deactivate-license' => __( 'Deactivate License', 'luigi' ),
		'activate-license' => __( 'Activate License', 'luigi' ),
		'status-unknown' => __( 'License status is unknown.', 'luigi' ),
		'renew' => __( 'Renew?', 'luigi' ),
		'unlimited' => __( 'unlimited', 'luigi' ),
		'license-key-is-active' => __( 'License key is active.', 'luigi' ),
		'expires%s' => __( 'Expires %s.', 'luigi' ),
		'%1$s/%2$-sites' => __( 'You have %1$s / %2$s sites activated.', 'luigi' ),
		'license-key-expired-%s' => __( 'License key expired %s.', 'luigi' ),
		'license-key-expired' => __( 'License key has expired.', 'luigi' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'luigi' ),
		'license-is-inactive' => __( 'License is inactive.', 'luigi' ),
		'license-key-is-disabled' => __( 'License key is disabled.', 'luigi' ),
		'site-is-inactive' => __( 'Site is inactive.', 'luigi' ),
		'license-status-unknown' => __( 'License status is unknown.', 'luigi' ),
		'update-notice' => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'luigi' ),
		'update-available' => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'luigi' )
	)

);
