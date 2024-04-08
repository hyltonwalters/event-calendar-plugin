<?php
/**
 * Template Name: Event List
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event List</title>
    <style>
        /* CSS styles for event list */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 0 20px;
        }
        .event-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .event-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
            cursor: pointer;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .event-item:last-child {
            border-bottom: none;
        }
        .event-item:hover {
            background-color: #f9f9f9;
        }
        .event-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .event-info {
            font-size: 0.9rem;
            color: #666;
            margin-left: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <ul class="event-list">
		<?php
		// Retrieve and display the list of upcoming events
		$args = array(
			'post_type'      => 'event',
			'posts_per_page' => -1, // Retrieve all events
			'post_status'    => 'publish',
		);
		$events = get_posts($args);
		foreach ($events as $event) {
			$event_start_date = get_post_meta($event->ID, 'event_start_date', true);
			$event_start_time = get_post_meta($event->ID, 'event_start_time', true);
			$event_end_date = get_post_meta($event->ID, 'event_end_date', true);
			$event_end_time = get_post_meta($event->ID, 'event_end_time', true);
			?>
            <li class="event-item" onclick="window.location.href='<?php echo esc_url(get_permalink($event->ID)); ?>'">
                <div class="event-title"><?php echo esc_html($event->post_title); ?></div>
                <div class="event-info">
                    <span><strong>Date:</strong> <?php echo esc_html($event_start_date); ?></span>
                    <span><strong>Time:</strong> <?php echo esc_html($event_start_time); ?> - <?php echo esc_html($event_end_time); ?></span>
                </div>
            </li>
			<?php
		}
		?>
    </ul>
</div>
</body>
</html>
