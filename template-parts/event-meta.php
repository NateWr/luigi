<?php
/**
 * A single event's meta data
 *
 * @brief Displays a single event's occurrence date
 *
 * @package luigi
 */
?>
<div class="entry-meta">

	<div class="event-meta-item short-date">
		<?php echo luigi_eo_format_brief_date(); ?>
	</div>

	<?php if ( luigi_eo_get_venue() ) : ?>
		<div class="event-meta-item venue">
			<a href="<?php echo esc_url( luigi_eo_get_venue_link() ); ?>">
				<?php luigi_eo_venue_name(); ?>
			</a>
		</div>
	<?php endif; ?>

	<?php if ( luigi_eo_recurs() ) : ?>
		<div class="event-meta-item recurrence-description">
			<?php echo luigi_eo_get_recurrence_description(); ?>
		</div>
	<?php endif; ?>

	<?php
		// Get upcoming dates for recurring events
		if ( luigi_eo_recurs() ) {
			//Event recurs - display dates.
			$upcoming = new WP_Query(array(
				'post_type'         => 'event',
				'event_start_after' => 'today',
				'posts_per_page'    => -1,
				'event_series'      => get_the_ID(),
				'group_events_by'   => 'occurrence',
			));

			if ( $upcoming->have_posts() ) : ?>

				<div class="event-meta-item upcoming-dates">
					<div class="title">
						<?php _e( 'Upcoming Dates', 'luigi' ); ?>
					</div>
					<ul class="eo-upcoming-dates">
						<?php
							while ( $upcoming->have_posts() ) {
								$upcoming->the_post();
								echo '<li>' . luigi_eo_format_event_occurrence() . '</li>';
							};
						?>
					</ul>
				</div>

				<?php
				wp_reset_postdata();
			endif;
			wp_reset_query();
		}
	?>

	<?php do_action( 'eventorganiser_additional_event_meta' ) ?>
</div>
