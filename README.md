# Event Calendar Plugin

A simple event calendar plugin to add, edit and manage events with a user-friendly front-end for visitors to view upcoming events.

## Installation

1. Upload the `event-calendar-plugin` folder to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Navigate to the 'Event Calendar' menu item in the WordPress admin area to manage events and settings.

## Usage

### Adding Events

1. Go to the 'Event Calendar' menu in the WordPress admin area.
2. Click on the 'Add New Event' button.
3. Fill in the required fields: Title, Description, Date, Time, Location, Image, Category, and Keywords.
4. Click on the 'Add Event' button to save the event.

### Editing Events

1. Go to the 'Event Calendar' menu in the WordPress admin area.
2. Click the 'Edit' link next to the event you want to modify.
3. Update the event details as needed.
4. Click on the 'Update Event' button to save the changes.

### Displaying Calendar

To display the calendar, use the following shortcode in your WordPress pages or posts:

`[event_calendar]`


### Displaying Events

To display the list of upcoming events, use the following shortcode in your WordPress pages or posts:

`[event_list]`


To display the details of a specific event, use the following shortcode with the appropriate event ID:

`[event_details id="123"]`

Replace `123` with the actual ID of the event you want to display.

To display the event search form, use the following shortcode:

`[event_search]`


### Additional Shortcodes

- `[event_add]`: Displays the form for adding a new event.
- `[event_edit id="123"]`: Displays the form for editing an existing event (replace `123` with the event ID).
- `[event_rsvp id="123"]`: Displays the form for RSVPing to an event (replace `123` with the event ID).

## Filters and Actions

The Event Calendar Plugin provides various filters and actions that allow developers to extend and customize the plugin's functionality. Here are a few examples:

### Filters

- `event_calendar_plugin_event_data`: Filter the event data before saving or updating.
- `event_calendar_plugin_category_data`: Filter the category data before saving or updating.
- `event_calendar_plugin_rsvp_data`: Filter the RSVP data before saving or updating.
- `event_calendar_plugin_event_list_query`: Filter the query arguments for retrieving the list of upcoming events.

### Actions

- `event_calendar_plugin_before_event_save`: Triggered before saving a new event or updating an existing one.
- `event_calendar_plugin_after_event_save`: Triggered after saving a new event or updating an existing one.
- `event_calendar_plugin_before_event_delete`: Triggered before deleting an event.
- `event_calendar_plugin_after_event_delete`: Triggered after deleting an event.

Developers can hook into these filters and actions to modify the plugin's behaviour or integrate it with other systems or plugins.

## Contributing

If you find any issues or have suggestions for improvement, please open an issue or submit a pull request on the plugin's GitHub repository.

## License

The Event Calendar Plugin is released under the [GNU General Public License v2 or later](https://www.gnu.org/licenses/gpl-2.0.html).
