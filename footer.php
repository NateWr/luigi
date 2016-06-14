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
						<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
							<?php if( get_theme_mod( 'footer_logo' ) ) : ?>
								<?php luigi_print_footer_logo(); ?>
							<?php else : ?>
								<?php echo get_bloginfo( 'name', 'display' ); ?>
							<?php endif; ?>
						</a>
						<?php if ( !get_theme_mod( 'footer_logo' ) && get_bloginfo( 'description' ) ) : ?>
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
							echo bpwfwp_print_contact_card(
								apply_filters(
									'luigi-footer-contact-card',
									array(
										'show_opening_hours' => false,
										'show_map' => false,
									)
								)
							);

							if ( post_type_exists( 'location' ) ) :
								?>
								<div class="luigi-contact-card-links">
									<div class="bp-locations">
										<a href="<?php echo esc_url( get_post_type_archive_link( 'location' ) ); ?>">
											<?php esc_html_e( 'All Locations', 'luigi' ); ?>
										</a>
									</div>
									<?php
										if ( function_exists( 'rtb_bp_print_booking_link' ) ) {
											rtb_bp_print_booking_link();
										}
									?>
								</div>
								<?php
							endif;
						?>
					</div>
				</div>
				<div class="site-footer-btm">
					<?php get_template_part( 'template-parts/menu', 'social' ); ?>
					<?php if ( get_theme_mod( 'copyright' ) ) : ?>
						<div class="copyright">
							<?php echo esc_html( get_theme_mod( 'copyright' ) ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</footer>
	</div><!-- #page -->

	<div class="luigi-modal">
		<div class="luigi-modal-panel">
			<a href="#" class="luigi-modal-close">
				<?php esc_html_e( 'Close', 'luigi' ); ?>
			</a>
			<div class="luigi-modal-content"></div>
		</div>
	</div>

	<?php wp_footer(); ?>
</body>
</html>
