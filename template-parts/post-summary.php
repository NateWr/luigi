<?php
/**
 * A single post summary
 *
 * @brief Displays a single post's summary. Expects to be called within the loop
 *
 * @package luigi
 */
?>
<article>
	<header class="entry-header">
		<time class="entry-date published updated" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
			<?php the_date(); ?>
		</time>
		<h3>
			<a href="<?php the_permalink(); ?>" rel="bookmark">
				<?php the_title(); ?>
			</a>
		</h3>
	</header>
	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div>
	<a href="<?php the_permalink(); ?>">
		<?php _e( 'Read More', 'luigi' ); ?>
	</a>
</article>
