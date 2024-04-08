<?php
/**
 * The template for displaying the event add form.
 *
 * @package Event_Calendar_Plugin
 */
?>

<div class="event-calendar-plugin">
    <h2><?php esc_html_e( 'Add New Event', 'event-calendar-plugin' ); ?></h2>

    <form id="event-add-form" method="post" action="" enctype="multipart/form-data">
        <label for="event-title"><?php esc_html_e( 'Title', 'event-calendar-plugin' ); ?></label>
        <input type="text" name="event-title" id="event-title" required />

        <label for="event-description"><?php esc_html_e( 'Description', 'event-calendar-plugin' ); ?></label>
        <textarea name="event-description" id="event-description" required></textarea>

        <label for="event-date"><?php esc_html_e( 'Start Date', 'event-calendar-plugin' ); ?></label>
        <input type="date" name="event-date" id="event-date" required />

        <label for="event-time"><?php esc_html_e( 'Start Time', 'event-calendar-plugin' ); ?></label>
        <input type="time" name="event-time" id="event-time" required />

        <label for="event-end-date"><?php esc_html_e( 'End Date', 'event-calendar-plugin' ); ?></label>
        <input type="date" name="event-end-date" id="event-end-date" required />

        <label for="event-end-time"><?php esc_html_e( 'End Time', 'event-calendar-plugin' ); ?></label>
        <input type="time" name="event-end-time" id="event-end-time" required />

        <label for="event-location"><?php esc_html_e( 'Location', 'event-calendar-plugin' ); ?></label>
        <input type="text" name="event-location" id="event-location" required />

        <label for="event-image"><?php esc_html_e( 'Event Image', 'event-calendar-plugin' ); ?></label>
        <input type="file" name="event-image" id="event-image" accept="image/*" />

        <label for="event-category"><?php esc_html_e( 'Category', 'event-calendar-plugin' ); ?></label>
        <select name="event-category" id="event-category">
			<?php
			// Retrieve and display the list of event categories
			$categories = get_event_categories();

			foreach ( $categories as $category ) {
				echo '<option value="' . $category->id . '">' . $category->name . '</option>';
			}
			?>
        </select>

        <label for="event-keywords"><?php esc_html_e( 'Keywords', 'event-calendar-plugin' ); ?></label>
        <input type="text" name="event-keywords" id="event-keywords" placeholder="<?php esc_attr_e( 'Enter keywords separated by commas', 'event-calendar-plugin' ); ?>" />

        <button type="submit"><?php esc_html_e( 'Add Event', 'event-calendar-plugin' ); ?></button>
    </form>
</div>
