<?php
/**
 * Display the primary navigation menu
 *
 * @brief Loads the menu assigned to the primary menu slot with the appropriate
 *  settings.
 *
 * @package luigi
 */
wp_nav_menu(
	array(
		'theme_location'  => 'primary_menu',
		'container'       => 'div',
		'container_class' => 'primary-menu',
		'walker'          => new Aria_Walker_Nav_Menu(),
	)
);
