<?php
/**
 * Header template file
 *
 * @brief Includes the HTML <head> section as well as the <header> content, including
 *  the logo and primary navigation menu.
 *
 * @package luigi
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 9]>
<html class="ie ie9" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) | !(IE 9)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">

		<header id="masthead" class="site-header" role="banner">
			<div class="row">
				<a href="<?php home_url(); ?>" title="<?php esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php if ( empty( get_theme_mod( 'logo' ) ) ) : ?>
						<?php echo get_bloginfo( 'name', 'display' ); ?>
					<?php else : ?>
						<img src="<?php echo esc_url( get_theme_mod( 'logo' ) ); ?>" class="logo-image" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
					<?php endif; ?>
				</a>

				<?php luigi_print_phone(); ?>

				<?php
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
				?>
			</div>

			<nav id="site-navigation" class="main-navigation" role="navigation">
				<?php
					wp_nav_menu(
						array(
							'theme_location'  => 'primary_menu',
							'container'       => 'div',
							'container_class' => 'primary-menu',
						)
					);
				?>
			</nav><!-- #site-navigation -->
		</header><!-- #masthead -->

		<div id="content" class="site-content">
