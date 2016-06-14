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

<?php else :
	get_template_part( 'template-parts/location', 'summary' );

endif;
