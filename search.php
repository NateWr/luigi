<?php
/**
 * The template for displaying search results
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package luigi
 */

get_header(); ?>

<div id="content" class="site-content">
	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="entry-header">
					<h1 class="entry-title">
						<?php printf( esc_html__( 'Search Results for: %s', 'luigi' ), '<span>' . get_search_query() . '</span>' ); ?>
					</h1>
				</header><!-- .entry-header -->

				<?php
				while ( have_posts() ) : the_post();
					get_template_part( 'content', 'search' );
				endwhile;

				luigi_the_posts_navigation();

			else :
				get_template_part( 'content', 'none' );

			endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- #content -->

<?php
get_footer();
