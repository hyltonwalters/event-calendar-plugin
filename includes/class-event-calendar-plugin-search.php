<?php
class Event_Calendar_Plugin_Search {
	public function __construct() {
		// Hook into WordPress search query
		add_action('pre_get_posts', array($this, 'modify_search_query'));
	}

	// Modify search query to include events
	public function modify_search_query($query) {
		if (!is_admin() && $query->is_search && $query->is_main_query()) {
			$query->set('post_type', array('post', 'event')); // Include 'event' post type in search
		}
	}
}

