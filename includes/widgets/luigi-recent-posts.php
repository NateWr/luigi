<?php
/**
 * Extended Recent Posts widget with custom output
 *
 * @brief Changes from core widget: calls a custom template for actual post
 *  output and shows no title if the title is empty.
 *
 * @package    luigi
 */
class Luigi_Widget_Recent_Posts extends WP_Widget_Recent_Posts {

	/**
	 * Outputs the content for the current Recent Posts widget instance.
	 *
	 * @since 0.1
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Recent Posts widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		/**
		 * Filter the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );

		if ($r->have_posts()) :
		?>
		<?php echo $args['before_widget']; ?>
		<?php if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>
		<ul>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<li>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-summary' ); ?>>
					<header class="entry-header">
						<?php
							if ( $show_date ) {
								get_template_part( 'template-parts/post', 'meta' );
							}
							the_title( '<div class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></div>' );
						?>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php the_excerpt(); ?>
					</div><!-- .entry-content -->

					<a href="<?php echo esc_url( get_permalink() ); ?>" class="more">
						<?php printf( esc_html__( 'Read More%s about %s%s', 'luigi' ), '<span class="screen-reader-text">', get_the_title(), '</span>' ); ?>
					</a>
				</article><!-- #post-## -->

			</li>
		<?php endwhile; ?>
		</ul>
		<?php echo $args['after_widget']; ?>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;
	}
}
