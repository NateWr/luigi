<?php
/**
 * The template for displaying the events archive page
 *
 * @package luigi
 */

get_header(); ?>

<div id="content" class="site-content">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>

				<header>
					<?php the_archive_title( '<h1 class="entry-title">', '</h1>' ); ?>
					<?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
				</header>

				<?php while ( have_posts() ) : the_post();
					get_template_part( 'content', get_post_type() );
				endwhile;

				luigi_eo_the_posts_navigation();

			else :
				get_template_part( 'content', 'none' );

			endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- #content -->

<?php
get_footer();
