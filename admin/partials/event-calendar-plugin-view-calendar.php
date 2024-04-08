<?php
/**
 * Provide a admin area view for the event calendar.
 *
 * @package Event_Calendar_Plugin
 */
?>

<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<!-- Display the event calendar here -->
	<?php echo do_shortcode( '[event_calendar]' ); ?>
</div>
