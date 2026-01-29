<?php
/**
 * TYPE: news
 * PLURAL: news
 * SLUG: /news
 */

// DEFINITION:
add_action(
	'init',
	function() {
		register_post_type(
			'news',
			[
				'labels'        => generate_post_labels(
					'News Item',
					'News Items',
				),
				'public'        => true,
				'supports'      => ['title'],
				'menu_icon'     => 'dashicons-welcome-widgets-menus',
				'menu_position' => 1,
				'has_archive'   => true,
				'rewrite'       => ['slug' => 'news'],
			]
		);
	}
);

// ADMIN BOXES:
add_action(
	'add_meta_boxes',
	function() {
		add_meta_box(
			'news_box',
			"News Item Image",
			function($post) {
				render_image_upload(
					$post->ID,
					'news_image'
				);
			},
			'news',
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
			$type != 'news'
		) return;

		upload_image(
			$id,
			$type . '_image'
		);
	}
);

