<?php
/**
 * The template for displaying all singular posts and pages
 *
 * This is the template that displays all single post or page requests.
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
		?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
