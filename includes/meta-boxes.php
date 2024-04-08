<?php
// Register meta boxes for event custom post type
function event_calendar_plugin_add_meta_boxes() {
    add_meta_box(
        'event-date-time',
        __( 'Event Date & Time', 'event-calendar-plugin' ),
        'event_calendar_plugin_event_date_time_meta_box',
        'event',
        'normal',
        'default'
    );

    add_meta_box(
        'event-location',
        __( 'Event Location', 'event-calendar-plugin' ),
        'event_calendar_plugin_event_location_meta_box',
        'event',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes', 'event_calendar_plugin_add_meta_boxes' );

// Callback function to display meta box content for event date and time
function event_calendar_plugin_event_date_time_meta_box( $post ) {
    // Add nonce for security
    wp_nonce_field( basename( __FILE__ ), 'event_calendar_plugin_event_nonce' );

    // Retrieve existing values from the database
    $event_start_date = get_post_meta( $post->ID, 'event_start_date', true );
    $event_start_time = get_post_meta( $post->ID, 'event_start_time', true );
    $event_end_date = get_post_meta( $post->ID, 'event_end_date', true );
    $event_end_time = get_post_meta( $post->ID, 'event_end_time', true );

    // Display fields
    ?>
    <label for="event-start-date"><?php esc_html_e( 'Start Date', 'event-calendar-plugin' ); ?></label>
    <input type="date" name="event-start-date" id="event-start-date" value="<?php echo esc_attr( $event_start_date ); ?>" />

    <label for="event-start-time"><?php esc_html_e( 'Start Time', 'event-calendar-plugin' ); ?></label>
    <input type="time" name="event-start-time" id="event-start-time" value="<?php echo esc_attr( $event_start_time ); ?>" />

    <label for="event-end-date"><?php esc_html_e( 'End Date', 'event-calendar-plugin' ); ?></label>
    <input type="date" name="event-end-date" id="event-end-date" value="<?php echo esc_attr( $event_end_date ); ?>" />

    <label for="event-end-time"><?php esc_html_e( 'End Time', 'event-calendar-plugin' ); ?></label>
    <input type="time" name="event-end-time" id="event-end-time" value="<?php echo esc_attr( $event_end_time ); ?>" />
    <?php
}

// Callback function to display meta box content for event location
function event_calendar_plugin_event_location_meta_box( $post ) {
    // Add nonce for security
    wp_nonce_field( basename( __FILE__ ), 'event_calendar_plugin_event_nonce' );

    // Retrieve existing value from the database
    $event_location = get_post_meta( $post->ID, 'event_location', true );

    // Display field
    ?>
    <label for="event-location"><?php esc_html_e( 'Location', 'event-calendar-plugin' ); ?></label>
    <input type="text" name="event-location" id="event-location" value="<?php echo esc_attr( $event_location ); ?>" />
    <?php
}

// Save custom field data when event is saved or updated
function event_calendar_plugin_save_event_meta( $post_id ) {
	// Check nonce and verify if it's not an autosave
	if ( ! isset( $_POST['event_calendar_plugin_event_nonce'] ) || ! wp_verify_nonce( $_POST['event_calendar_plugin_event_nonce'], basename( __FILE__ ) ) ) {
		return;
	}

	// Check post type and permissions
	if ( isset( $_POST['post_type'] ) && 'event' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	// Save custom field data
	if ( isset( $_POST['event-start-date'] ) ) {
		update_post_meta( $post_id, 'event_start_date', sanitize_text_field( $_POST['event-start-date'] ) );
	}
	if ( isset( $_POST['event-start-time'] ) ) {
		update_post_meta( $post_id, 'event_start_time', sanitize_text_field( $_POST['event-start-time'] ) );
	}
	if ( isset( $_POST['event-end-date'] ) ) {
		update_post_meta( $post_id, 'event_end_date', sanitize_text_field( $_POST['event-end-date'] ) );
	}
	if ( isset( $_POST['event-end-time'] ) ) {
		update_post_meta( $post_id, 'event_end_time', sanitize_text_field( $_POST['event-end-time'] ) );
	}
	if ( isset( $_POST['event-location'] ) ) {
		update_post_meta( $post_id, 'event_location', sanitize_text_field( $_POST['event-location'] ) );
	}
	if ( isset( $_POST['event-image-id'] ) ) {
		update_post_meta( $post_id, '_thumbnail_id', absint( $_POST['event-image-id'] ) );
	}
	// Save event categories
	if ( isset( $_POST['event-category'] ) ) {
		$event_categories = array_map( 'intval', $_POST['event-category'] );
		wp_set_object_terms( $post_id, $event_categories, 'event_keyword' );
	}
}
add_action( 'save_post', 'event_calendar_plugin_save_event_meta' );
