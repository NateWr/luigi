<?php
/**
 * The template for displaying single menus
 *
 * @package luigi
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'content', get_post_type() );

			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		endwhile;
		?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
if ( !luigi_menu_has_two_cols() ) {
	get_sidebar();
}
get_footer();
