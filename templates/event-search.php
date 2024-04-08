<?php
/**
 * The template for displaying the event search form.
 *
 * @package Event_Calendar_Plugin
 */
?>

<div class="event-calendar-plugin">
	<h2><?php esc_html_e( 'Search Events', 'event-calendar-plugin' ); ?></h2>

	<form id="event-search-form">
		<input type="text" name="search" placeholder="<?php esc_attr_e( 'Search events...', 'event-calendar-plugin' ); ?>" />
		<button type="submit"><?php esc_html_e( 'Search', 'event-calendar-plugin' ); ?></button>
	</form>

	<div id="event-search-results"></div>
</div>
