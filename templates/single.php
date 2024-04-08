<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Event_Calendar_Plugin
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
					<?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
							<?php the_post_thumbnail(); ?>
                        </div>
					<?php endif; ?>

					<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                </header>

                <div class="entry-content">
					<?php
					while (have_posts()) :
						the_post();

						// Display the post content
						the_content();

						// Output custom meta-box fields
						?>
                        <div class="event-meta">
                            <p><strong>Start Date:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'event_start_date', true)); ?></p>
                            <p><strong>Start Time:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'event_start_time', true)); ?></p>
                            <p><strong>End Date:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'event_end_date', true)); ?></p>
                            <p><strong>End Time:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'event_end_time', true)); ?></p>
                            <p><strong>Location:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'event_location', true)); ?></p>
                            <?php
                            // Get the event categories (keywords)
                            $event_categories = get_the_terms(get_the_ID(), 'event_keyword');

                            // Check if event categories exist
                            if (!empty($event_categories)) :
                            ?>
                            <div class="event-meta">
                                <p><strong>Keywords:</strong>
			                        <?php
			                        // Loop through each term and display its name
			                        $category_names = array();
			                        foreach ($event_categories as $category) {
				                        $category_names[] = $category->name;
			                        }
			                        echo esc_html(implode(', ', $category_names));
			                        ?>
                                </p>
                            </div>
                            <?php endif; ?>
                        </div>
					<?php endwhile;
					?>
                </div>

            </article><?php the_ID(); ?>
        </main>
    </div>
<?php
get_sidebar();
get_footer();
