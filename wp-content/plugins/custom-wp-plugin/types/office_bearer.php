<?php
/**
 * TYPE: office_bearer
 * PLURAL: office_bearers
 * SLUG: /office-bearers
 */
 
require_once __DIR__ . '/../includes.php';

// DEFINITION:
add_action(
	'init',
	function() {
		register_post_type(
			'office_bearers',
			[
				'labels'        => generate_post_labels(
					'Office Bearer',
					'Office Bearers',
				),
				'public'        => true,
				'supports'      => ['title'],
				'menu_icon'     => 'dashicons-id',
				'menu_position' => 1,
				'has_archive'   => true,
				'rewrite'       => ['slug' => 'office-bearers'],
			]
		);
	}
);

// ADMIN BOXES:
add_action(
	'add_meta_boxes',
	function() {
		add_meta_box(
			'office_bearers_name',
			'Full Name',
			function($post) {
				render_input_field(
					$post->ID,
					'office_bearers_name',
					'text',
					'John Doe'
				);
			},
			'office_bearers',
			'normal', // side, etc.
			'high', // <- priority
		);
		add_meta_box(
			'office_bearers_image',
			'Office Bearer Image',
			function($post) {
				render_image_upload(
					$post->ID,
					'office_bearers_image'
				);
			},
			'office_bearers',
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
			$type != 'office_bearers'
		) return;

		upload_image($id, $type . "_image");
		save_meta_value($id, $type . "_name");
	}
);

