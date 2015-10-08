<?php
/**
 * Display the social profiles menu
 *
 * @brief Loads the menu assigned to the social profiles slot with the
 *  appropriate settings.
 *
 * @package luigi
 */
wp_nav_menu(
	array(
		'theme_location'  => 'social_menu',
		'container'       => 'div',
		'container_class' => 'social-menu social-icons',
		'depth'           => 1,
		'link_before'     => '<span class="screen-reader-text">',
		'link_after'      => '</span>',
	)
);
