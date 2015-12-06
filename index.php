<?php // Silence is golden

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

	<?php /* Start the Loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<?php the_content(); ?>
	<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
