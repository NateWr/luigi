<?php
/**
 * Logo or title text template file
 *
 * @brief Includes the logo or, if no logo exists, the title and tagline of
 *  this site.
 *
 * @package luigi
 */
$brand_element = is_front_page() ? 'h1' : 'div';
?>

<<?php echo $brand_element; ?> class="brand">
	<a class="home-link" href="<?php echo home_url(); ?>" title="<?php esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
		<?php if ( get_theme_mod( 'site_logo' ) ) : ?>
			<?php echo get_bloginfo( 'name', 'display' ); ?>
		<?php else : ?>
			<?php luigi_print_logo(); ?>
		<?php endif; ?>
	</a>
	<?php if ( get_theme_mod( 'site_logo' ) && !get_bloginfo( 'description' ) ) : ?>
		<span class="site-tagline">
			<?php echo get_bloginfo( 'description', 'display' ); ?>
		</span>
	<?php endif; ?>
</<?php echo $brand_element; ?>>
