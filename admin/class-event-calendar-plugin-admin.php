<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/hyltonwalters
 * @since      1.0.0
 *
 * @package    Event_Calendar_Plugin
 * @subpackage Event_Calendar_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Event_Calendar_Plugin
 * @subpackage Event_Calendar_Plugin/admin
 * @author     Hylton Walters <hyltonjean@gmail.com>
 */
class Event_Calendar_Plugin_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Event_Calendar_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Event_Calendar_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/event-calendar-plugin-admin.css', [],
			$this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Event_Calendar_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Event_Calendar_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/event-calendar-plugin-admin.js',
			[ 'jquery' ], $this->version, false );
		wp_enqueue_script( 'fullcalendar', 'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js',
			[ 'jquery' ], $this->version, true );
	}
	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 */
//	public function add_plugin_admin_menu() {
//		include_once '../includes/class-event-calendar-plugin-post-types.php';
//	}

	/**
	 * Register the "Event" custom post type.
	 */
	public static function register_event_post_type() {
		$labels = array(
			'name'                  => _x( 'Events', 'Post Type General Name', 'event-calendar-plugin' ),
			'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'event-calendar-plugin' ),
			'menu_name'             => __( 'Events', 'event-calendar-plugin' ),
			'name_admin_bar'        => __( 'Event', 'event-calendar-plugin' ),
			'archives'              => __( 'Event Archives', 'event-calendar-plugin' ),
			'attributes'            => __( 'Event Attributes', 'event-calendar-plugin' ),
			'parent_item_colon'     => __( 'Parent Event:', 'event-calendar-plugin' ),
			'all_items'             => __( 'All Events', 'event-calendar-plugin' ),
			'add_new_item'          => __( 'Add New Event', 'event-calendar-plugin' ),
			'add_new'               => __( 'Add New', 'event-calendar-plugin' ),
			'new_item'              => __( 'New Event', 'event-calendar-plugin' ),
			'edit_item'             => __( 'Edit Event', 'event-calendar-plugin' ),
			'update_item'           => __( 'Update Event', 'event-calendar-plugin' ),
			'view_item'             => __( 'View Event', 'event-calendar-plugin' ),
			'view_items'            => __( 'View Events', 'event-calendar-plugin' ),
			'search_items'          => __( 'Search Event', 'event-calendar-plugin' ),
			'not_found'             => __( 'Not found', 'event-calendar-plugin' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'event-calendar-plugin' ),
			'featured_image'        => __( 'Event Image', 'event-calendar-plugin' ),
			'set_featured_image'    => __( 'Set event image', 'event-calendar-plugin' ),
			'remove_featured_image' => __( 'Remove event image', 'event-calendar-plugin' ),
			'use_featured_image'    => __( 'Use as event image', 'event-calendar-plugin' ),
			'insert_into_item'      => __( 'Insert into event', 'event-calendar-plugin' ),
			'uploaded_to_this_item' => __( 'Uploaded to this event', 'event-calendar-plugin' ),
			'items_list'            => __( 'Events list', 'event-calendar-plugin' ),
			'items_list_navigation' => __( 'Events list navigation', 'event-calendar-plugin' ),
			'filter_items_list'     => __( 'Filter events list', 'event-calendar-plugin' ),
		);
		$args = array(
			'label'                 => __( 'Event', 'event-calendar-plugin' ),
			'description'           => __( 'Event Description', 'event-calendar-plugin' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail' ),
			'taxonomies'            => array(),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 26,
			'menu_icon'             => 'dashicons-calendar-alt',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
		);
		register_post_type( 'event', $args );
	}

	/**
	 * Register the "Taxonomy" custom post type.
	 */
	public static function register_event_category_taxonomy() {
		$labels = [
			'name'          => _x( 'Event Keywords', 'taxonomy general name', 'event-calendar-plugin' ),
			'singular_name' => _x( 'Event Keyword', 'taxonomy singular name', 'event-calendar-plugin' ),
			'search_items'  => __( 'Search Event Keywords', 'event-calendar-plugin' ),
			'all_items'     => __( 'All Event Keywords', 'event-calendar-plugin' ),
			'edit_item'     => __( 'Edit Event Keyword', 'event-calendar-plugin' ),
			'update_item'   => __( 'Update Event Keyword', 'event-calendar-plugin' ),
			'add_new_item'  => __( 'Add New Event Keyword', 'event-calendar-plugin' ),
			'new_item_name' => __( 'New Event Keyword Name', 'event-calendar-plugin' ),
			'menu_name'     => __( 'Event Keywords', 'event-calendar-plugin' ),
		];

		$args = [
			'labels'            => $labels,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'hierarchical'      => true,
			'rewrite'           => [ 'slug' => 'event-keyword' ],
		];

		register_taxonomy( 'event_keyword', 'event', $args );
	}

/**
 * Render the settings page for this plugin.
	 */
	public function display_plugin_admin_dashboard() {
		include_once 'partials/event-calendar-plugin-admin-display.php';
	}

	/**
	 * Render the "View Calendar" page.
	 */
	public function display_view_calendar_page() {
		include_once 'partials/event-calendar-plugin-view-calendar.php';
	}

	/**
	 * Register the settings and fields for this plugin.
	 */
	public function register_settings() {
		// Register settings and fields
		// ...
	}
}
