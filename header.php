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
				<?php get_template_part( 'template-parts/logo' ); ?>
				<?php luigi_print_phone(); ?>
				<?php get_template_part( 'template-parts/menu', 'social' ); ?>
			</div>

			<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Main Menu', 'luigi' ); ?>">
				<?php get_template_part( 'template-parts/menu', 'primary' ); ?>
			</nav><!-- #site-navigation -->

			<a href="#" id="luigi-primary-nav-control" aria-controls="masthead">
				<?php esc_attr_e( 'Browse', 'luigi' ); ?>
			</a>
		</header><!-- #masthead -->
