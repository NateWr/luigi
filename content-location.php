<?php
/**
 * The template for displaying a single location's content
 *
 * @package luigi
 */
?>

<?php if ( is_single() ) : ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-single-location' ); ?>  itemscope itemtype="http://schema.org/<?php echo bpfwp_setting( 'schema-type', get_the_ID() ); ?>">

		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>
		</header>

		<?php get_template_part( 'template-parts/location', 'sidebar' ); ?>

		<div class="location-content">
			<div class="entry-content" itemprop="description">
				<?php the_content(); ?>

				<?php
					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'luigi' ),
						'after'  => '</div>',
					) );
				?>
			</div><!-- .entry-content -->
			<meta itemprop="url" content="<?php echo esc_url( get_permalink() ); ?>">
		</div>
	</article>

<?php else : ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-summary post-location-summary' ); ?>>

		<?php echo luigi_bp_maybe_print_map( get_the_ID() ); ?>

		<?php
			echo bpwfwp_print_contact_card(
				array(
					'location'           => get_the_ID(),
					'show_opening_hours' => false,
					'show_map'           => false,
				)
			);
		?>

		<div class="location-more-link">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php
				    // Translators: 1 and 3 are an opening and closing <span> tag. 2 is the post title.
				    printf( esc_html__( 'Read More%1$s about the %2$s location%3$s', 'luigi' ), '<span class="screen-reader-text">', get_the_title(), '</span>' );
				?>
			</a>
		</div>
	</article>

<?php endif; ?>
