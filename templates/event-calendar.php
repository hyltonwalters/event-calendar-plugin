<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Calendar</title>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <style>
        /* CSS styles for filter button */
        #calendar-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        #event-type-filter, #event-list-button {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
<div id='calendar-container'>
    <!-- Filter Button -->
    <select id="event-type-filter">
        <option value="">Filter by Type</option>
		<?php
		// Retrieve event types from the WordPress database
		$event_types = get_terms(array(
			'taxonomy' => 'event_keyword', // Replace with your custom taxonomy slug
			'hide_empty' => false,
		));

		// Display event types as options in the filter dropdown
		foreach ($event_types as $event_type) {
			echo '<option value="' . esc_attr($event_type->slug) . '">' . esc_html($event_type->name) . '</option>';
		}
		?>
    </select>

    <!-- Event List Button -->
    <button id="event-list-button">Event List</button>
</div>
<div id='calendar'></div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            buttonText: {
                listWeek: 'List'
            },
            views: {
                listWeek: {
                    type: 'listWeek',
                    buttonText: 'List'
                }
            },
            events: function(fetchInfo, successCallback, failureCallback) {
                get_event_calendar_data(successCallback);
            }
        });

        calendar.render();

        // Handle click event of the Event List button
        document.getElementById('event-list-button').addEventListener('click', function() {
            window.location.href = '<?php echo site_url('/event-list/'); ?>';
        });

        // Function to fetch event data from WordPress
        function get_event_calendar_data(successCallback) {
            var selectedCategory = $('#event-type-filter').val();
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'event_calendar_data',
                    category_id: selectedCategory
                },
                success: function(response) {
                    if (response) {
                        var events = JSON.parse(response);
                        successCallback(events);
                    } else {
                        console.error("No response received.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error occurred while fetching data:", error);
                }
            });
        }

        // Attach event listener to filter dropdown
        $('#event-type-filter').on('change', function() {
            calendar.refetchEvents();
        });
    });
</script>
</body>
</html>
