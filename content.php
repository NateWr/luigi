<?php
/**
 * The template for displaying a single post's content
 *
 * @package luigi
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( is_single() ? '' : 'post-summary' ); ?>>
	<header class="entry-header">
		<?php
			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
				get_template_part( 'template-parts/post', 'meta' );
			} elseif ( is_archive() || is_home() ) {
				get_template_part( 'template-parts/post', 'meta' );
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			} else {
				get_template_part( 'template-parts/post', 'meta' );
				the_title( '<div class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></div>' );
			}
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			if ( is_single() ) {
				the_content();
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'luigi' ),
					'after'  => '</div>',
				) );
			} else {
				the_excerpt();
			}
		?>
	</div><!-- .entry-content -->

	<?php if ( is_single() ) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'luigi' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-## -->
