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
<a class="home-link" href="<?php home_url(); ?>" title="<?php esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
	<?php if ( empty( get_theme_mod( 'logo' ) ) ) : ?>
		<?php echo get_bloginfo( 'name', 'display' ); ?>
	<?php else : ?>
		<img src="<?php echo esc_url( get_theme_mod( 'logo' ) ); ?>" class="logo-image" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
	<?php endif; ?>
</a>
<?php if ( empty( get_theme_mod( 'logo' ) ) && !empty( get_bloginfo( 'description' ) ) ) : ?>
	<span class="description">
		<?php echo get_bloginfo( 'description', 'display' ); ?>
	</span>
<?php endif; ?>
