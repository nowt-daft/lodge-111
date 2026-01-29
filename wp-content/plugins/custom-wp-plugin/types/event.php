<?php
/**
 * TYPE: event
 * PLURAL: events
 * SLUG: /events
 */

// DEFINITION:
add_action(
	'init',
	function() {
		register_post_type(
			'events',
			[
				'labels'        => generate_post_labels(
					'Event',
					'Events',
				),
				'public'        => true,
				'supports'      => ['title', 'editor'],
				'menu_icon'     => 'dashicons-calendar-alt',
				'menu_position' => 1,
				/* 'has_archive'   => true, */
				'rewrite'       => ['slug' => 'events'],
			]
		);
	}
);

// ADMIN BOXES:
add_action(
	'add_meta_boxes',
	function() {
		add_meta_box(
			'events_box',
			"Event Date",
			function ($post) {
				render_date_field(
					$post->ID,
					'event_date'
				);
				render_time_field(
					$post->ID,
					'event_time'
				);
			},
			'events',
			'side',
			'high'
		);
	}
);

// SAVE:
add_action(
	'save_post',
	function($id) {
		$type = get_post_type();

		if (
			$type != 'events'
		) return;

		save_meta(
			$id,
			[
				'event_date',
				'event_time'
			]
		);
	}
);

