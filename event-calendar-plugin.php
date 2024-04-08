<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/hyltonwalters
 * @since             1.0.0
 * @package           Event_Calendar_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Event Calendar Plugin
 * Plugin URI:        https://github.com/hyltonwalters
 * Description:       A simple event calendar plugin to add, edit and manage events with a user-friendly front-end for visitors to view upcoming events.
 * Version:           1.0.0
 * Author:            Hylton Walters
 * Author URI:        https://github.com/hyltonwalters/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       event-calendar-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'EVENT_CALENDAR_PLUGIN_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-event-calendar-plugin-activator.php
 */
function activate_event_calendar_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-event-calendar-plugin-activator.php';
	Event_Calendar_Plugin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-event-calendar-plugin-deactivator.php
 */
function deactivate_event_calendar_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-event-calendar-plugin-deactivator.php';
	Event_Calendar_Plugin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_event_calendar_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_event_calendar_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-event-calendar-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_event_calendar_plugin() {

	$plugin = new Event_Calendar_Plugin();
	$plugin->run();

}
run_event_calendar_plugin();
