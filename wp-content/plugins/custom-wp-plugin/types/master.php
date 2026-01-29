<?php
/**
 * TYPE: master
 * PLURAL: masters
 * SLUG: /masters
 */

// DEFINITION:
add_action(
	'init',
	function() {
		register_post_type(
			'masters',
			[
				'labels'        => generate_post_labels(
					'Past Master',
					'Past Masters',
				),
				'public'        => true,
				'supports'      => ['title'],
				'menu_icon'     => 'dashicons-businessman',
				'menu_position' => 1,
				'has_archive'   => true,
				'rewrite'       => ['slug' => 'past-masters'],
			]
		);
	}
);

// ADMIN BOXES:
add_action(
	'add_meta_boxes',
	function() {
		add_meta_box(
			'masters_start_date',
			'Start Date',
			function($post) {
				render_date_field(
					$post->ID,
					'masters_start_date'
				);
			},
			'masters',
			'normal',
			'high'
		);
		add_meta_box(
			'masters_end_date',
			'End Date',
			function($post) {
				render_date_field(
					$post->ID,
					'masters_end_date'
				);
			},
			'masters',
			'normal',
			'high'
		);
		add_meta_box(
			'masters_image',
			'Master Image',
			function($post) {
				render_image_upload(
					$post->ID,
					'masters_image'
				);
			},
			'masters',
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
			$type != 'masters'
		) return;

		upload_image(
			$id,
			$type . "_image"
		);
		save_meta(
			$id,
			[
				$type . '_start_date',
				$type . '_end_date'
			]
		);
	}
);

