<?php
/**
 * The template for displaying a message that posts cannot be found
 *
 * @package luigi
 */
?>

<section class="no-results not-found">
	<header class="entry-header">
		<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'luigi' ); ?></h1>
	</header><!-- .page-header -->

	<div class="entry-content">
		<?php if ( is_search() ) : ?>

			<p>
				<?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'luigi' ); ?>
			</p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p>
				<?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'luigi' ); ?>
			</p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .entry-content -->
</section><!-- .no-results -->
