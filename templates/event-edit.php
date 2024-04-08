<?php
/**
 * The template for editing an event.
 *
 * @package Event_Calendar_Plugin
 */
?>

<div class="event-calendar-plugin">
	<h2><?php esc_html_e( 'Edit Event', 'event-calendar-plugin' ); ?></h2>

	<?php
	// Check if event ID is provided
	if ( isset( $_GET['event_id'] ) ) {
		$event_id = intval( $_GET['event_id'] );
		$event = get_post( $event_id ); // Retrieve event by ID

		// Proceed if event exists
		if ( $event && $event->post_type === 'event' ) {
			?>
			<form id="event-edit-form" method="post" action="" enctype="multipart/form-data">
				<input type="hidden" name="event_id" value="<?php echo $event_id; ?>" />

				<label for="event-title"><?php esc_html_e( 'Title', 'event-calendar-plugin' ); ?></label>
				<input type="text" name="event-title" id="event-title" value="<?php echo esc_attr( $event->post_title ); ?>" required />

				<label for="event-description"><?php esc_html_e( 'Description', 'event-calendar-plugin' ); ?></label>
				<textarea name="event-description" id="event-description" required><?php echo esc_textarea( $event->post_content ); ?></textarea>

				<?php
				// Event Date & Time Meta Box
				event_calendar_plugin_event_date_time_meta_box( $event );

				// Event Location Meta Box
				event_calendar_plugin_event_location_meta_box( $event );
				?>

				<button type="submit"><?php esc_html_e( 'Update Event', 'event-calendar-plugin' ); ?></button>
			</form>
			<?php
		} else {
			echo '<p>' . esc_html__( 'Event not found.', 'event-calendar-plugin' ) . '</p>';
		}
	} else {
		echo '<p>' . esc_html__( 'Event ID not provided.', 'event-calendar-plugin' ) . '</p>';
	}
	?>
</div>
