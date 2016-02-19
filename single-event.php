<?php
/**
 * The template for displaying all singular posts and pages
 *
 * This is the template that displays all single post or page requests.
 *
 * @package luigi
 */

get_header(); ?>

<?php echo luigi_eo_maybe_print_venue_map( eo_get_venue(), array( 'scrollwheel' => false, 'class' => 'event-single-venue-map' ) ); ?>

<div id="content" class="site-content">
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
</div><!-- #content -->

<?php
get_footer();
