<?php
/**
 * The template for displaying the static front page
 *
 * @package luigi
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php luigi_clc_the_content(); ?>
		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
