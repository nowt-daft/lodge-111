<?php
/**
 * TYPE: announcement
 * PLURAL: announcements
 * SLUG: /announcements
 */

// DEFINITION:
add_action(
	'init',
	function() {
		register_post_type(
			'announcements',
			[
				'labels'        => generate_post_labels(
					'Announcement',
					'Announcements',
				),
				'public'        => true,
				'supports'      => ['title', 'editor'],
				'menu_icon'     => 'dashicons-megaphone',
				'menu_position' => 1,
				/* 'has_archive'   => true, */
				'rewrite'       => ['slug' => 'announcements'],
			]
		);
	}
);

// ADMIN BOXES:
add_action(
	'add_meta_boxes',
	function() {
		add_meta_box(
			'announcements_box',
			'Announcement Image (optional)',
			function($post) {
				render_image_upload(
					$post->ID,
					'announcements_image'
				);
			},
			'announcements',
			'side',
			'high', // <- priority
		);
	}
);

// SAVE:
add_action(
	'save_post',
	function($id) {
		$type = get_post_type();

		if (
			$type != 'announcements'
		) return;

		upload_image(
			$id,
			$type . '_image'
		);
	}
);

