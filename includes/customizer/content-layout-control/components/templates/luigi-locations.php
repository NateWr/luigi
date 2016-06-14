<?php
/**
 * Layout template for the locations component
 *
 * @since 0.1
 */
global $bpfwp_controller;
if ( isset( $bpfwp_controller ) && isset( $bpfwp_controller->cpts ) && isset( $bpfwp_controller->cpts->location_cpt_slug ) ) :

	$locations = new WP_Query(
		array(
			'post_type'      => $bpfwp_controller->cpts->location_cpt_slug,
			'posts_per_page' => 20,
		)
	);

	if ( $locations->have_posts() ) : ?>

		<div class="clc-wrapper">
			<?php while ( $locations->have_posts() ) :
				$locations->the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-summary post-location-summary' ); ?>>
					[contact-card location="<?php echo get_the_ID(); ?>" show_map="0" show_opening_hours="0"]

					<div class="location-more-link">
						<a href="<?php echo esc_url( get_permalink() ); ?>">
							<?php
								// Translators: 1 and 3 are an opening and closing <span> tag. 2 is the post title.
								printf( esc_html__( 'Read More%1$s about the %2$s location%3$s', 'luigi' ), '<span class="screen-reader-text">', get_the_title(), '</span>' );
							?>
						</a>
					</div>
				</article>

			<?php endwhile; ?>

		</div>

	<?php endif;

	wp_reset_postdata();
	wp_reset_query();
endif;
