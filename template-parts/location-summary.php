<?php
/**
 * A single location summary view
 *
 * @package luigi
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-summary post-location-summary' ); ?>>

	<?php echo luigi_bp_maybe_print_map( get_the_ID() ); ?>

	<?php
		echo bpwfwp_print_contact_card(
			array(
				'location'           => get_the_ID(),
				'show_opening_hours' => false,
				'show_map'           => false,
			)
		);
	?>

	<div class="location-more-link">
		<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php
				// Translators: 1 and 3 are an opening and closing <span> tag. 2 is the post title.
				printf( esc_html__( 'Read More%1$s about the %2$s location%3$s', 'luigi' ), '<span class="screen-reader-text">', get_the_title(), '</span>' );
			?>
		</a>
	</div>
</article>
