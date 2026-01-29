<?php
/**
 * TYPE: function
 * PLURAL: functions
 * SLUG: /functions
 */

// DEFINITION:
add_action(
	'init',
	function() {
		register_post_type(
			'functions',
			[
				'labels'        => generate_post_labels(
					'Function Hall Booking',
					'Function Hall Bookings',
				),
				'public'        => true,
				'supports'      => ['title', 'editor'],
				'menu_icon'     => 'dashicons-groups',
				'menu_position' => 1,
				'has_archive'   => true,
				'rewrite'       => ['slug' => 'functions'],
			]
		);
	}
);

// ADMIN BOXES:
add_action(
	'add_meta_boxes',
	function() {
		add_meta_box(
			'functions_image_box',
			'Function Image',
			function($post) {
				render_image_upload(
					$post->ID,
					'functions_image'
				);
			},
			'functions',
			'side', // side, etc.
			'high', // <- priority
		);
		add_meta_box(
			'functions_contact_box',
			'Booking Email',
			function($post) {
				render_email_field(
					$post->ID,
					'functions_email'
				);
			},
			'functions',
			'side', // side, etc.
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
			$type != 'functions'
		) return;

		save_meta_value(
			$id,
			'functions_email'
		);
		upload_image(
			$id,
			'functions_image'
		);
	}
);

