<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package luigi
 */
if ( !is_front_page() && is_active_sidebar( 'primary-sidebar' ) ) :
?>

<section id="secondary" class="sidebar-area">
	<div id="sidebar" class="widget-area sidebar-primary-sidebar" role="complementary">
		<?php dynamic_sidebar( 'primary-sidebar' ); ?>
	</div><!-- #sidebar -->
</section><!-- #secondary -->

<?php endif; ?>
