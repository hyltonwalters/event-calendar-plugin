<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/hyltonwalters
 * @since      1.0.0
 *
 * @package    Event_Calendar_Plugin
 * @subpackage Event_Calendar_Plugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Event_Calendar_Plugin
 * @subpackage Event_Calendar_Plugin/public
 * @author     Hylton Walters <hyltonjean@gmail.com>
 */
class Event_Calendar_Plugin_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->enqueue_styles();
		$this->enqueue_scripts();

		// Hook into the template_include filter
		add_filter( 'template_include', array( $this, 'load_single_event_template' ) );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/event-calendar-plugin-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/event-calendar-plugin-public.js', array( 'jquery' ), $this->version, false );
	}

	// Add the template_include filter to load single-event.php for event posts
	public function load_single_event_template( $template ) {
		if ( is_singular( 'event' ) && file_exists( plugin_dir_path( __FILE__ ) . '../templates/single.php' ) ) {
			return plugin_dir_path( __FILE__ ) . '../templates/single.php';
		}
		return $template;
	}
	/**
	 * Render the event calendar shortcode.
	 */
	public function display_event_calendar( $atts ) {
		ob_start();
		include plugin_dir_path( __FILE__ ) . '../templates/event-calendar.php';
		return ob_get_clean();
	}

	/**
	 * Render the event list shortcode.
	 */
	public function display_event_list( $atts ) {
		// Retrieve and display the list of upcoming events
		ob_start();
		include plugin_dir_path( __FILE__ ) . '../templates/event-list.php';
		return ob_get_clean();
	}

	/**
	 * Handle AJAX request for event list.
	 */
	public function ajax_event_list() {
		ob_start();
		include plugin_dir_path( __FILE__ ) . '../templates/event-list.php';
		$content = ob_get_clean();
		echo $content;
		wp_die();
	}

	/**
	 * Render the event add shortcode.
	 */
	public function display_event_add( $atts ) {
		// Display the form for adding a new event
		ob_start();
		include plugin_dir_path( __FILE__ ) . '../templates/event-add.php';
		return ob_get_clean();
	}

	/**
	 * Render the event edit shortcode.
	 */
	public function display_event_edit( $atts ) {
		// Display the form for editing an existing event
		ob_start();
		include plugin_dir_path( __FILE__ ) . '../templates/event-edit.php';
		return ob_get_clean();
	}

	/**
	 * Render the event RSVP shortcode.
	 */
	public function display_event_rsvp( $atts ) {
		// Display the form for RSVPing to an event
		ob_start();
		include plugin_dir_path( __FILE__ ) . '../templates/event-rsvp.php';
		return ob_get_clean();
	}

	/**
	 * Handle AJAX request for event search.
	 */
	public function ajax_event_search() {
		// Process the AJAX request for event search
		// ...
	}

	/**
	 * Handle AJAX request for event RSVP.
	 */
	public function ajax_event_rsvp() {
		// Process the AJAX request for event RSVP
		// ...
	}

	/**
	 * Get the link to the event details page.
	 *
	 * @param int $event_id The ID of the event.
	 * @return string
	 */
	public function get_event_details_link( $event_id ) {
		$permalink = get_permalink();
		$base_url  = untrailingslashit( $permalink );

		return $base_url . '?event_id=' . $event_id;
	}

	/**
	 * Retrieve event data for the calendar.
	 *
	 * @return array
	 */
	public function get_event_data_for_calendar() {
		$args = array(
			'post_type'      => 'event',
			'posts_per_page' => -1, // Retrieve all events
			'post_status'    => 'publish',
		);

		$events = get_posts( $args );

		$event_data = array();
		foreach ( $events as $event ) {
			$event_data[] = array(
				'id'          => $event->ID,
				'title'       => $event->post_title,
				'description' => $event->post_content,
				'start'       => get_post_meta( $event->ID, 'event_date', true ) . 'T' . get_post_meta( $event->ID, 'event_time', true ),
				'url'         => get_permalink( $event->ID ),
			);
		}

		return $event_data;
	}

	public function ajax_event_calendar_data() {
		$events = []; // Initialize empty array to store event data
		// Query to retrieve events from WordPress database
		$args = array(
			'post_type' => 'event',
			'posts_per_page' => -1, // Retrieve all events
		);
		$query = new WP_Query($args);
		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				// Format event data
				$event    = array(
					'title' => get_the_title(),
					'start' => get_post_meta(get_the_ID(), 'event_start_date', true) . 'T' . get_post_meta(get_the_ID(), 'event_start_time', true),
					'end' => get_post_meta(get_the_ID(), 'event_end_date', true) . 'T' . get_post_meta(get_the_ID(), 'event_end_time', true),
					'url' => get_permalink(), // Link to the event page
				);
				$events[] = $event;
			}
		}
		wp_reset_postdata();
		echo json_encode($events); // Output event data as JSON
		wp_die();
	}
}
