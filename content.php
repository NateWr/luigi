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
				?>

				<a href="<?php echo esc_url( get_permalink() ); ?>" class="more">
					<?php
					    // Translators: 1 and 3 are an opening and closing <span> tag. 2 is the post title.
					    printf( esc_html__( 'Read More%1$s about %2$s%3$s', 'luigi' ), '<span class="screen-reader-text">', get_the_title(), '</span>' );
					?>
				</a>

				<?php
			}
		?>
	</div><!-- .entry-content -->

	<?php if ( is_single() ) : ?>
		<footer class="entry-footer">

			<?php
			if ( 'post' === get_post_type() ) {
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( esc_html__( ', ', 'luigi' ) );
				if ( $categories_list && luigi_categorized_blog() ) {
					printf( '<div class="cat-links">' . esc_html__( 'Posted in: %1$s', 'luigi' ) . '</div>', $categories_list );
				}
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', esc_html__( ', ', 'luigi' ) );
				if ( $tags_list ) {
					printf( '<div class="tags-links">' . esc_html__( 'Tagged: %1$s', 'luigi' ) . '</div>', $tags_list );
				}
			}

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
	<?php endif; ?>
</article><!-- #post-## -->
