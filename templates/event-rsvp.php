<?php
/**
 * The template for displaying the event RSVP form.
 *
 * @package Event_Calendar_Plugin
 */
?>

<div class="event-calendar-plugin">
	<h2><?php esc_html_e( 'RSVP for Event', 'event-calendar-plugin' ); ?></h2>

	<?php
	// Retrieve the event details
	$event = get_event( $event_id );

	if ( $event ) {
		?>
		<h3><?php echo esc_html( $event->title ); ?></h3>
		<p><?php echo esc_html( $event->date . ' ' . $event->time . ' | ' . $event->location ); ?></p>

		<form id="event-rsvp-form">
			<input type="hidden" name="event_id" value="<?php echo esc_attr( $event->id ); ?>" />

			<label for="rsvp-name"><?php esc_html_e( 'Name', 'event-calendar-plugin' ); ?></label>
			<input type="text" name="name" id="rsvp-name" required />

			<label for="rsvp-email"><?php esc_html_e( 'Email', 'event-calendar-plugin' ); ?></label>
			<input type="email" name="email" id="rsvp-email" required />

			<label for="rsvp-guests"><?php esc_html_e( 'Number of Guests', 'event-calendar-plugin' ); ?></label>
			<input type="number" name="guests" id="rsvp-guests" min="0" value="0" />

			<button type="submit"><?php esc_html_e( 'RSVP', 'event-calendar-plugin' ); ?></button>
		</form>
		<?php
	} else {
		echo '<p>' . esc_html__( 'Event not found.', 'event-calendar-plugin' ) . '</p>';
	}
	?>
</div>
