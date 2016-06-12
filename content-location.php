<?php
/**
 * The template for displaying a single location's content
 *
 * @package luigi
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( is_single() ? 'post-single-location' : 'post-summary' ); ?>  itemscope itemtype="http://schema.org/<?php echo bpfwp_setting( 'schema-type', get_the_ID() ); ?>">

	<?php if ( is_single() ) : ?>

		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>
		</header>

		<div class="location-sidebar">
			<?php get_template_part( 'template-parts/location', 'sidebar' ); ?>
		</div>

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

	<?php else : ?>

		<header class="entry-header">
			<?php
				if ( is_archive() ) {
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url"><span itemprop="name">', '</span></a></h2>' );
				} else {
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
