<?php
/**
 * Logo or title text template file
 *
 * @brief Includes the logo or, if no logo exists, the title and tagline of
 *  this site.
 *
 * @package luigi
 */
?>
<a class="home-link" href="<?php echo home_url(); ?>" title="<?php esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
	<?php if ( empty( get_option( 'site_logo' ) ) ) : ?>
		<?php echo get_bloginfo( 'name', 'display' ); ?>
	<?php else : ?>
		<?php luigi_print_logo(); ?>
	<?php endif; ?>
</a>
<?php if ( empty( get_option( 'site_logo' ) ) && !empty( get_bloginfo( 'description' ) ) ) : ?>
	<span class="site-tagline">
		<?php echo get_bloginfo( 'description', 'display' ); ?>
	</span>
<?php endif; ?>
