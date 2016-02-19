<?php
/**
 * Footer template file
 *
 * @brief Includes the closing <body> tag as well as the <footer> content.
 *
 * @package luigi
 */
?>

		<?php if ( is_active_sidebar( 'footer-full' ) ) : ?>
			<section class="site-footer-widgets-full">
				<ul id="sidebar" class="widget-area footer-full-widget-container">
					<?php dynamic_sidebar( 'footer-full' ); ?>
				</ul>
			</section>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'footer' ) ) : ?>
			<section class="site-footer-widgets ">
				<ul id="sidebar" class="widget-area footer-widget-container">
					<?php dynamic_sidebar( 'footer' ); ?>
				</ul>
			</section>
		<?php endif; ?>


		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="site-footer-container">
				<div class="site-footer-top">
					<div class="identity">
						<a class="home-link" href="<?php echo home_url(); ?>" title="<?php esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
							<?php if( !empty( get_theme_mod( 'footer_logo' ) ) ) : ?>
								<?php luigi_print_footer_logo(); ?>
							<?php else : ?>
								<?php echo get_bloginfo( 'name', 'display' ); ?>
							<?php endif; ?>
						</a>
						<?php if ( empty( get_theme_mod( 'footer_logo' ) ) && !empty( get_bloginfo( 'description' ) ) ) : ?>
							<span class="site-tagline">
								<?php echo get_bloginfo( 'description', 'display' ); ?>
							</span>
						<?php endif; ?>

						<?php if ( get_theme_mod( 'footer_description' ) ) : ?>
							<div class="description">
								<?php echo esc_html( do_shortcode( get_theme_mod( 'footer_description' ) ) ); ?>
							</div>
						<?php endif; ?>
					</div>
					<div class="contact">
						<?php
							echo luigi_shortcode_bpfwp_contact_card(
								apply_filters(
									'luigi-footer-contact-card',
									array(
										'show_name' => true,
										'show_address' => true,
										'show_get_directions' => true,
										'show_phone' => true,
										'show_contact' => true,
										'show_opening_hours' => false,
										'show_map' => false,
										'show_booking_link' => false,
									)
								)
							);
						?>
					</div>
				</div>
				<div class="site-footer-btm">
					<?php get_template_part( 'template-parts/menu', 'social' ); ?>
					<?php if ( get_theme_mod( 'copyright' ) ) : ?>
						<div class="copyright">
							<?php esc_html_e( get_theme_mod( 'copyright' ) ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</footer>
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>
