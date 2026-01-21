<?php

/**
 * Plugin Name:	  Hawick Lodge Website Plugin
 * Author:		  Graham Robertson
 */
/**
 * HELPER FUNCTIONS:
 */
function generate_post_labels(
	$singular,
	$plural
) {
	return array(
		'name'          => __( $plural, 'textdomain' ),
		'singular_name' => __( $singular, 'textdomain' ),
		'add_new'       => 'Add ' . $singular,
		'add_new_item'  => 'Add ' . $singular,
		'edit_item'     => 'Edit ' . $singular,
		'new_item'      => 'New ' . $singular,
		'view_item'     => 'View ' . $singular,
		'view_items'    => 'View ' . $plural,
		'all_items'     => 'All ' . $plural
	);
}
function get_data($post) {
	$data = [];

	foreach (get_post_meta($post->ID) as $field => $value) {
		if (isset($value))
			$data[$field] = $value[0] ?? '';
		else
			$data[$field] = '';
	}

	return $data;
}
function upload_image($id, $name) {
	if (empty(
		$_FILES[$name]['name']
	)) {
		return;
	}

	$supported_types = array(
		'image/jpeg',
		'image/png',
		'image/webp',
	);

	$uploaded_type = wp_check_filetype(
		basename($_FILES[$name]['name'])
	)['type'];

	if (
		!in_array($uploaded_type, $supported_types)
	) {
		wp_die("The file uploaded is not a supported image format.");
	}

	$upload = wp_upload_bits(
		$_FILES[$name]['name'],
		null,
		file_get_contents(
			$_FILES[$name]['tmp_name']
		)
	);

	if (
		isset($upload['error']) && $upload['error'] != 0
	) {
		wp_die('Error with image upload: ' . $upload['error']);
	}
	
	add_post_meta($id, $name, $upload);
	update_post_meta($id, $name, $upload);
}

/**
 * THE MOST IMPORTANT THING
 */
add_action(
	'post_edit_form_tag',
	function() {
		echo ' enctype="multipart/form-data"';
	}
);

/**
 * POST REGISTRATION
 */
add_action(
	'init',
	function() {
		register_post_type(
			'heros',
			array(
				'labels'        => generate_post_labels(
					'Hero Post',
					'Hero Posts'
				),
				'public'        => true,
				'supports'      => array('editor'),
				'menu_icon'     => 'dashicons-admin-post',
				'menu_position' => 0,
				'rewrite'       => array('slug' => 'hero')
			)
		);
		register_post_type(
			'announcements',
			array(
				'labels'        => generate_post_labels(
					'Announcement',
					'Announcements'
				),
				'public'        => true,
				'supports'      => array('title', 'editor'),
				'menu_icon'     => 'dashicons-megaphone',
				'menu_position' => 0,
				'rewrite'       => array('slug' => 'announcements')
			)
		);
		register_post_type(
			'news',
			array(
				'labels'        => generate_post_labels(
					'News Item',
					'News Items'
				),
				'public'        => true,
				'supports'      => array('title', 'editor'),
				'menu_icon'     => 'dashicons-welcome-widgets-menus',
				'menu_position' => 0,
				'rewrite'       => array('slug' => 'news')
			)
		);
		register_post_type(
			'events',
			array(
				'labels'        => generate_post_labels(
					'Event',
					'Events'
				),
				'public'        => true,
				'supports'      => array('title', 'editor'),
				'menu_icon'     => 'dashicons-calendar-alt',
				'menu_position' => 0,
				'rewrite'       => array('slug' => 'events')
			)
		);
		register_post_type(
			'functions',
			array(
				'labels'        => generate_post_labels(
					'Function',
					'Functions'
				),
				'public'        => true,
				'supports'      => array('title', 'editor'),
				'menu_icon'     => 'dashicons-groups',
				'menu_position' => 0,
				'rewrite'       => array('slug' => 'functions')
			)
		);
		register_post_type(
			'history',
			array(
				'labels'        => generate_post_labels(
					'History',
					'History'
				),
				'public'        => true,
				'supports'      => array('title', 'editor'),
				'menu_icon'     => 'dashicons-book',
				'menu_position' => 0,
				'rewrite'       => array('slug' => 'history'),
				'has_archive'   => true
			)
		);
		register_post_type(
			'office_bearers',
			array(
				'labels'        => generate_post_labels(
					'Office Bearer',
					'Office Bearers'
				),
				'public'        => true,
				'supports'      => array('title'),
				'menu_icon'     => 'dashicons-id',
				'menu_position' => 0,
				'rewrite'       => array('slug' => 'office-bearers'),
				'has_archive'   => true
			)
		);
		register_post_type(
			'masters',
			array(
				'labels'        => generate_post_labels(
					'Past Master',
					'Past Masters'
				),
				'public'        => true,
				'supports'      => array('title', 'editor'),
				'menu_icon'     => 'dashicons-businessman',
				'menu_position' => 0,
				'rewrite'       => array('slug' => 'past-masters'),
				'has_archive'   => true
			)
		);
	},
	10
);

add_action(
	'add_meta_boxes',
	function() {
		add_meta_box(
			'announcements_box',
			"Announcement Image (optional)",
			function($post) {
				wp_nonce_field(
					plugin_basename(__FILE__),
					'announcement_image_nonce'
				);
				$file = get_post_meta($post->ID, 'announcements_image', true);
				$file = empty($file) ? '' : $file['url'];
				?>
				<?php if (!empty($file)) : ?>
					<img src="<?php echo $file ?>" />
				<?php endif ?>
				<input
					name="announcements_image"
					type="file"
				/>
				<?php
			},
			'announcements',
			'side',
			'high'
		);
		add_meta_box(
			'functions_box',
			"Function Hall Image",
			function($post) {
				wp_nonce_field(
					plugin_basename(__FILE__),
					'functions_image_nonce'
				);
				$file = get_post_meta($post->ID, 'functions_image', true);
				$file = empty($file) ? '' : $file['url'];
				?>
				<?php if (!empty($file)) : ?>
					<img src="<?php echo $file ?>" />
				<?php endif ?>
				<input
					name="functions_image"
					type="file"
				/>
				<?php
			},
			'functions',
			'side',
			'high'
		);
		add_meta_box(
			'functions_email_box',
			"Booking Email",
			function ($post) {
				$data = get_data($post);
				?>
				<input
					name="function_email"
					type="email"
					placeholder="user@emaildomain.com"
					value="<?php echo $data['function_email'] ?? '' ?>"
				/>
				<?php
			},
			'functions',
			'side',
			'high'
		);
		add_meta_box(
			'news_box',
			"News Item Image",
			function($post) {
				wp_nonce_field(
					plugin_basename(__FILE__),
					'news_image_nonce'
				);
				$file = get_post_meta($post->ID, 'news_image', true);
				$file = empty($file) ? '' : $file['url'];
				?>
				<?php if (!empty($file)) : ?>
					<img src="<?php echo $file ?>" />
				<?php endif ?>
				<input
					name="news_image"
					type="file"
				/>
				<?php
			},
			'news',
			'side',
			'high'
		);

		add_meta_box(
			'events_box',
			"Event Date",
			function ($post) {
				$data = get_data($post);
				?>
				<input
					name="event_date"
					type="date"
					value="<?php echo $data['event_date'] ?? '' ?>"
				/>
				<input
					name="event_time"
					type="text"
					placeholder="HH:MM (24-hour time)"
					value="<?php echo $data['event_time'] ?? '' ?>"
				/>
				<?php
			},
			'events',
			'side',
			'high'
		);
		add_meta_box(
			'chapter_order',
			'Chapter Display Order Number',
			function ($post) {
				$data = get_data($post);
				?>
					<input
						name="history_chapter_order"
						type="number"
						value="<?php
							echo $data['history_chapter_order'] ?? '0'
						?>"
						min="0"
						step="1"
					/>
				<?php
			},
			'history',
			'side',
			'high'
		);
		add_meta_box(
			'office_bearers_name',
			'Office Bearer Full Name',
			function ($post) {
				$data = get_data($post);
				?>
					<input
						name="office_bearers_name"
						type="text"
						value="<?php
							echo $data['office_bearers_name'] ?? 'John Doe'
						?>"
					/>
				<?php
			},
			'office_bearers',
			'normal',
			'high'
		);
		add_meta_box(
			'office_bearers_image',
			'Office Bearer Image',
			function($post) {
				wp_nonce_field(
					plugin_basename(__FILE__),
					'office_bearers_image_nonce'
				);
				$file = get_post_meta(
					$post->ID,
					'office_bearers_image',
					true
				);
				$file = empty($file) ? '' : $file['url'];
				?>
				<?php if (!empty($file)) : ?>
					<img src="<?php echo $file ?>" />
				<?php endif ?>
				<input
					name="office_bearers_image"
					type="file"
				/>
				<?php
			},
			'office_bearers',
			'side',
			'high'
		);
		add_meta_box(
			'masters_image',
			'Master Image',
			function($post) {
				wp_nonce_field(
					plugin_basename(__FILE__),
					'masters_image_nonce'
				);
				$file = get_post_meta(
					$post->ID,
					'masters_image',
					true
				);
				$file = empty($file) ? '' : $file['url'];
				?>
				<?php if (!empty($file)) : ?>
					<img src="<?php echo $file ?>" />
				<?php endif ?>
				<input
					name="masters_image"
					type="file"
				/>
				<?php
			},
			'masters',
			'side',
			'high'
		);
	}
);

add_action(
	'save_post',
	function($id) {
		$type = get_post_type();

		if (
			$type != 'news' &&
			$type != 'announcements' &&
			$type != 'functions' &&
			$type != 'masters'
		) return;

		upload_image($id, $type . '_image');
	}
);
add_action(
	'save_post',
	function($id) {
		$type = get_post_type();
		if (
			$type != 'events'
		) return;

		$event_date = $_POST['event_date'] ?? '';
		$event_time = $_POST['event_time'] ?? '';

		if (!empty($event_date)) {
			update_post_meta(
				$id,
				'event_date',
				$event_date
			);
		}
		if (!empty($event_time)) {
			update_post_meta(
				$id,
				'event_time',
				$event_time
			);
		}
	}
);
add_action(
	'save_post',
	function($id) {
		$type = get_post_type();
		if (
			$type != 'functions'
		) return;

		$content = $_POST['function_email'] ?? '';

		if (!empty($content)) {
			update_post_meta(
				$id,
				'function_email',
				$content
			);
		}
	}
);
add_action(
	'save_post',
	function($id) {
		$type = get_post_type();
		if (
			$type != 'history'
		) return;

		$content = $_POST['history_chapter_order'];

		update_post_meta(
			$id,
			'history_chapter_order',
			$content
		);
	}
);
add_action(
	'save_post',
	function($id) {
		$type = get_post_type();
		if (
			$type != 'office_bearers'
		) return;

		update_post_meta(
			$id,
			$type . "_name",
			$_POST[$type . "_name"]
		);
		upload_image(
			$id,
			$type . '_image'
		);
	}
);
