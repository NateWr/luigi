<?php
/**
 * The template for displaying the front page
 *
 * It will show the selected front page or the blog index if no static front
 * page is selected.
 *
 * @package luigi
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php
			while ( have_posts() ) {
				the_post();
				if ( is_home() ) {
					get_template_part( 'content' );
				} else {
					luigi_clc_the_content();
				}
			}
		?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
if ( is_home() ) {
	get_sidebar();
}
get_footer();
