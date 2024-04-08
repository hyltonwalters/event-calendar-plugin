<?php
/**
 * Event Calendar Plugin Functions
 *
 * @package Event_Calendar_Plugin
 */

/**
 * Retrieve and return a list of upcoming events.
 *
 * @return array List of upcoming events.
 */
function get_upcoming_events() {
	// Define query arguments to retrieve upcoming events
	$args = array(
		'post_type'      => 'event',
		'posts_per_page' => -1, // Retrieve all events
		'post_status'    => 'publish',
		'orderby'        => 'meta_value',
		'meta_key'       => 'event_date',
		'order'          => 'ASC',
		'meta_query'     => array(
			'relation' => 'AND',
			array(
				'key'     => 'event_date',
				'value'   => date( 'Y-m-d' ), // Retrieve events starting from today
				'compare' => '>=',
				'type'    => 'DATE',
			),
		),
	);

	// Query events
	$events_query = new WP_Query( $args );

	// Initialize an array to store event data
	$events = array();

	// Loop through events and format data
	if ( $events_query->have_posts() ) {
		while ( $events_query->have_posts() ) {
			$events_query->the_post();

			// Get event data
			$event_data = array(
				'title'       => get_the_title(),
				'description' => get_the_content(),
				'date'        => get_post_meta( get_the_ID(), 'event_date', true ),
				'time'        => get_post_meta( get_the_ID(), 'event_time', true ),
				'location'    => get_post_meta( get_the_ID(), 'event_location', true ),
			);

			// Add event data to events array
			$events[] = (object) $event_data;
		}
		wp_reset_postdata();
	}

	return $events;
}

/**
 * Retrieve and return a list of upcoming events filtered by event type (category).
 *
 * @param int $category_id The ID of the event type (category) to filter by.
 * @return array List of upcoming events filtered by event type.
 */
function get_upcoming_events_by_category($category_id) {
	// Define query arguments to retrieve upcoming events filtered by category
	$args = array(
		'post_type'      => 'event',
		'posts_per_page' => -1, // Retrieve all events
		'post_status'    => 'publish',
		'meta_query'     => array(
			'relation' => 'AND',
			array(
				'key'     => 'event_start_date',
				'value'   => date('Y-m-d'), // Retrieve events starting from today
				'compare' => '>=',
				'type'    => 'DATE',
			),
		),
		'tax_query'      => array(
			array(
				'taxonomy' => 'event_keyword',
				'field'    => 'term_id', // Use 'term_id' to filter by term ID
				'terms'    => $category_id, // Filter events by the provided category ID
			),
		),
	);

	// Query events
	$events_query = new WP_Query($args);

	// Initialize an array to store event data
	$events = array();

	// Loop through events and format data
	if ($events_query->have_posts()) {
		while ($events_query->have_posts()) {
			$events_query->the_post();

			// Get event data
			$event_data = array(
				'title'       => get_the_title(), // Retrieve event title
				'description' => get_the_content(),
				'start'       => get_post_meta(get_the_ID(), 'event_start_date', true),
				'end'         => get_post_meta(get_the_ID(), 'event_end_date', true),
				'url'         => get_permalink(), // URL to event details page
			);

			// Add event data to events array
			$events[] = (object)$event_data;
		}
		wp_reset_postdata();
	}

	return $events;
}

/**
 * Retrieve and return event categories.
 *
 * @return array|false An array of event categories, or false if no categories are found.
 */
function get_event_categories() {
	$categories = get_terms( array(
		'taxonomy'   => 'event_keyword',
		'hide_empty' => false,
	) );

	return $categories;
}


