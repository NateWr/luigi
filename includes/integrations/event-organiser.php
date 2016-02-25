<?php
/**
 * Functions used to integrate with the Event Organiser plugin
 *
 * @package luigi
 */
if ( !function_exists( 'luigi_eo_customize_archive_title' ) ) {
	/**
	 * Modify the events archive page title
	 *
	 * @since 0.1
	 */
	function luigi_eo_customize_archive_title( $title ) {

		if ( is_post_type_archive( 'event' ) ) {
			return post_type_archive_title( '', false );
		} else if ( is_tax( 'event-category' ) || is_tax( 'event-tag' ) ) {
			return single_term_title( esc_html__( 'Events: ', 'luigi' ), false);
		} else if ( is_tax( 'event-venue' ) ) {
			return single_term_title( '', false );
		}

		return $title;
	}
	add_filter( 'get_the_archive_title', 'luigi_eo_customize_archive_title' );
}

if ( !function_exists( 'luigi_eo_format_brief_date' ) ) {
	/**
	 * Output a brief representation of an event date
	 *
	 * This wrapper prints out a single date or a date range if the event
	 * recurs. Expects to be called during the loop.
	 *
	 * @since 0.1
	 */
	function luigi_eo_format_brief_date() {

		if ( !function_exists( 'eo_format_event_occurrence' ) || !function_exists( 'eo_recurs' ) || !function_exists( 'eo_get_schedule_start' ) || !function_exists( 'eo_get_schedule_last' ) ) {
			return '';
		}

		if ( eo_recurs() ) {
			return sprintf( esc_html_x( '%s&mdash;%s', 'Brief format of start and end dates of recurring events.', 'luigi' ), eo_get_schedule_start( get_option( 'date_format' ) ), eo_get_schedule_last( get_option( 'date_format' ) ) );
		}

		return eo_format_event_occurrence();
	}
}

if ( !function_exists( 'luigi_eo_recurs' ) ) {
	/**
	 * Wrapper for the eo_recurs() function
	 *
	 * @since 0.1
	 */
	function luigi_eo_recurs() {
		return function_exists( 'eo_recurs' ) && eo_recurs();
	}
}

if ( !function_exists( 'luigi_eo_get_recurrence_description' ) ) {
	/**
	 * Compile a description for a recurring event's timeline.
	 *
	 * This returns a string representing the start and end date if the event
	 * still has recurrences in the future. Otherwise it will return a string
	 * saying the event is finished.
	 *
	 * @since 0.1
	 */
	function luigi_eo_get_recurrence_description() {

		if ( !function_exists( 'eo_get_next_occurrence' ) || !function_exists( 'eo_get_event_datetime_format' ) || !function_exists( 'eo_get_schedule_start' ) || !function_exists( 'eo_get_schedule_last' ) ) {
			return '';
		}

		$next = eo_get_next_occurrence( eo_get_event_datetime_format() );

		if ( $next ) {
			$start_date = eo_get_schedule_start( get_option( 'date_format' ) );
			$last_date = eo_get_schedule_last( get_option( 'date_format' ) );
			$next = '<span class="next-occurrence">' . $next . '</span>';

			return sprintf( esc_html__( 'This event will run from %1$s to %2$s. It will happen next on %3$s.', 'luigi' ), $start_date, $last_date, $next );
		}

		return sprintf( esc_html__( 'This event finished on %s', 'luigi' ), eo_get_schedule_last( get_option( 'date_format' ) ) );
	}
}

if ( !function_exists( 'luigi_eo_format_event_occurrence' ) ) {
	/**
	 * Wrapper for the eo_format_event_occurrence() function
	 *
	 * @since 0.1
	 */
	function luigi_eo_format_event_occurrence() {
		return function_exists( 'eo_format_event_occurrence' ) ? eo_format_event_occurrence() : '';
	}
}

if ( !function_exists( 'luigi_eo_maybe_print_venue_map' ) ) {
	/**
	 * Output a venue map
	 *
	 * This wrapper prints the eo_get_venue_map() output after checking to make
	 * sure that a venue exists.
	 *
	 * @since 0.1
	 */
	function luigi_eo_maybe_print_venue_map( $venue = 0, $map_args = array() ) {

		if ( !function_exists( 'eo_get_venue' ) || !function_exists( 'eo_get_venue_map' ) || !function_exists( 'eo_venue_has_latlng' ) ) {
			return '';
		}

		if ( !is_int( $venue ) || !$venue ) {
			$venue = eo_get_venue();
		}

		if ( $venue && eo_venue_has_latlng( $venue ) ) {
			return eo_get_venue_map( $venue, $map_args );
		}

		return '';
	}
}

if ( !function_exists( 'luigi_eo_get_venue' ) ) {
	/**
	 * Wrapper for the eo_get_venue() function
	 *
	 * @since 0.1
	 */
	function luigi_eo_get_venue() {
		return function_exists( 'eo_get_venue' ) && eo_get_venue();
	}
}

if ( !function_exists( 'luigi_eo_venue_link' ) ) {
	/**
	 * Wrapper for the eo_venue_link() function
	 *
	 * @since 0.1
	 */
	function luigi_eo_venue_link() {
	 	if ( function_exists( 'eo_venue_link' ) ) {
			eo_venue_link();
		} else {
			echo '';
		}
	}
}

if ( !function_exists( 'luigi_eo_venue_name' ) ) {
	/**
	 * Wrapper for the eo_venue_name() function
	 *
	 * @since 0.1
	 */
	function luigi_eo_venue_name() {
	 	if ( function_exists( 'eo_venue_name' ) ) {
			eo_venue_name();
		} else {
			echo '';
		}
	}
}

if ( !function_exists( 'luigi_eo_the_posts_navigation' ) ) {
	/**
	 * Swap the language for older/later events
	 *
	 * The event archives are in ASC order rather than DSC order, so page 2
	 * shows events later than page 1. For this reason, the language for
	 * "next" and "prev" pages needs to be reversed.
	 *
	 * @since 0.1
	 */
	function luigi_eo_the_posts_navigation() {
		the_posts_navigation(
			array(
				'next_text' => esc_html__( '&larr; Older events', 'lugi' ),
				'prev_text' => esc_html__( 'Later events &rarr;', 'lugi' ),
			)
		);
	}
}

if ( !function_exists( 'luigi_eo_customizer_load_calendar_handlers' ) ) {
	/**
	 * Print a hidden map using Business Profile's native functions to ensure
	 * that the map handler is loaded and initialized properly. This is used by
	 * the customer to ensure that if a map is loaded in during customization,
	 * it will update properly.
	 *
	 * @since 0.0.1
	 */
	function luigi_eo_customizer_load_calendar_handlers() {
		?>

		<div style="display:none;">
			<?php echo do_shortcode( '[eo_fullcalendar]' ); ?>
		</div>

		<?php
	}
}
