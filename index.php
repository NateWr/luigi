<?php
/**
 * The main template file.
 *
 * This template will be loaded whenever an appropriate template file could not
 * be found. This template should never be used but is here to provide a safe
 * fallback.
 *
 * @package luigi
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'content', get_post_type() );
		endwhile;

		luigi_the_posts_navigation();
		?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
