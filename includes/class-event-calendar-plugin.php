<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/hyltonwalters
 * @since      1.0.0
 *
 * @package    Event_Calendar_Plugin
 * @subpackage Event_Calendar_Plugin/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Event_Calendar_Plugin
 * @subpackage Event_Calendar_Plugin/includes
 * @author     Hylton Walters <hyltonjean@gmail.com>
 */
class Event_Calendar_Plugin {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Event_Calendar_Plugin_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'EVENT_CALENDAR_PLUGIN_VERSION' ) ) {
			$this->version = EVENT_CALENDAR_PLUGIN_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'event-calendar-plugin';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		// Instantiate the search class
		new Event_Calendar_Plugin_Search();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Event_Calendar_Plugin_Loader. Orchestrates the hooks of the plugin.
	 * - Event_Calendar_Plugin_i18n. Defines internationalization functionality.
	 * - Event_Calendar_Plugin_Admin. Defines all hooks for the admin area.
	 * - Event_Calendar_Plugin_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-event-calendar-plugin-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-event-calendar-plugin-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-event-calendar-plugin-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-event-calendar-plugin-public.php';

		/**
		 * The class responsible for handling plugin activation and deactivation.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-event-calendar-plugin-activator.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-event-calendar-plugin-deactivator.php';

		// Include the additional functions file
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/event-calendar-functions.php';
		// Include the meta box file
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/meta-boxes.php';
		// Include the search class
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-event-calendar-plugin-search.php';

		/**
		 * The classes responsible for handling data models.
		 */
//		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/models/class-event-calendar-plugin-event.php';
//		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/models/class-event-calendar-plugin-category.php';
//		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/models/class-event-calendar-plugin-rsvp.php';

		$this->loader = new Event_Calendar_Plugin_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 */
	private function set_locale() {
		$plugin_i18n = new Event_Calendar_Plugin_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Event_Calendar_Plugin_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Add CPT to Admin Menu
		$this->loader->add_action( 'init', $plugin_admin, 'register_event_post_type' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_event_category_taxonomy' );

		// Add custom settings and fields
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 */
	private function define_public_hooks() {
		$plugin_public = new Event_Calendar_Plugin_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Add shortcodes
		$this->loader->add_shortcode( 'event_calendar', $plugin_public, 'display_event_calendar' );
		$this->loader->add_shortcode( 'event_list', $plugin_public, 'display_event_list' );
		$this->loader->add_shortcode( 'single_event', $plugin_public, 'display_event_details' );
		$this->loader->add_shortcode( 'event_search', $plugin_public, 'display_event_search' );
		$this->loader->add_shortcode( 'event_add', $plugin_public, 'display_event_add' );
		$this->loader->add_shortcode( 'event_edit', $plugin_public, 'display_event_edit' );
		$this->loader->add_shortcode( 'event_rsvp', $plugin_public, 'display_event_rsvp' );
		// Add AJAX handlers
		$this->loader->add_action( 'wp_ajax_event_calendar_data', $plugin_public, 'ajax_event_calendar_data' );
		$this->loader->add_action( 'wp_ajax_nopriv_event_calendar_data', $plugin_public, 'ajax_event_calendar_data' );
		$this->loader->add_action( 'wp_ajax_event_search', $plugin_public, 'ajax_event_search' );
		$this->loader->add_action( 'wp_ajax_nopriv_event_search', $plugin_public, 'ajax_event_search' );
		$this->loader->add_action( 'wp_ajax_event_rsvp', $plugin_public, 'ajax_event_rsvp' );
		$this->loader->add_action( 'wp_ajax_nopriv_event_rsvp', $plugin_public, 'ajax_event_rsvp' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
