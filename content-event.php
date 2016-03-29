<?php
/**
 * The template for displaying a single event's content
 *
 * @package luigi
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( is_single() ? 'post-single-event' : 'post-summary' ); ?>  itemscope itemtype="http://schema.org/Event">

	<?php if ( is_single() ) : ?>

		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>
		</header>

		<div class="event-sidebar">
			<?php get_template_part( 'template-parts/event', 'meta' ); ?>
		</div>

		<div class="event-content">
			<div class="entry-content" itemprop="description">
				<?php the_content(); ?>

				<?php
					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'luigi' ),
						'after'  => '</div>',
					) );
				?>
			</div><!-- .entry-content -->

			<footer class="entry-footer">

				<?php
					echo get_the_term_list(
						get_the_ID(),
						'event-category',
						'<div class="cat-links">' . esc_html( 'Categories: ', 'luigi' ),
						esc_html_x( ', ', 'Comma separating items in list of event categories', 'luigi' ),
						'</div>'
					);
				?>

				<?php
					echo get_the_term_list(
						get_the_ID(),
						'event-tag',
						'<div class="tag-links">' . esc_html( 'Tags: ', 'luigi' ),
						esc_html_x( ', ', 'Comma separating items in list of event tags', 'luigi' ),
						'</div>'
					);
				?>

				<?php
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'luigi' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<div class="edit-link">',
					'</div>'
				);
				?>
			</footer><!-- .entry-footer -->
		</div>

	<?php else : ?>

		<header class="entry-header">
			<?php
				if ( is_archive() || is_home() ) {
					get_template_part( 'template-parts/event', 'meta-short-date' );
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url"><span itemprop="name">', '</span></a></h2>' );
				} else {
					get_template_part( 'template-parts/event', 'meta-short-date' );
					the_title( '<div class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url"><span itemprop="name">', '</span></a></div>' );
				}
			?>
		</header><!-- .entry-header -->

		<div class="entry-content" itemprop="description">
			<?php the_excerpt(); ?>

			<a href="<?php echo esc_url( get_permalink() ); ?>" class="more">
				<?php
				    // Translators: 1 and 3 are an opening and closing <span> tag. 2 is the post title.
				    printf( esc_html__( 'Read More%1$s about %2$s%3$s', 'luigi' ), '<span class="screen-reader-text">', get_the_title(), '</span>' );
				?>
			</a>
		</div><!-- .entry-content -->

	<?php endif; ?>
</article><!-- #post-## -->
