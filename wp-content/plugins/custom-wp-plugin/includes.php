<?php

/**
 * HELPER FUNCTIONS FOR CUSTOM POST TYPES:
 * Author: Graham Robertson
 */
function do_nothing($x) {
	return $x;
}

function generate_post_labels(
	$singular,
	$plural
) {
	return [
		'name'          => __( $plural, 'textdomain' ),
		'singular_name' => __( $singular, 'textdomain' ),
		'add_new'       => 'Add ' . $singular,
		'add_new_item'  => 'Add ' . $singular,
		'edit_item'     => 'Edit ' . $singular,
		'new_item'      => 'New ' . $singular,
		'view_item'     => 'View ' . $singular,
		'view_items'    => 'View ' . $plural,
		'all_items'     => 'All ' . $plural
	];
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

function save_meta_value(
	$post_id,
	$post_meta_key,
	$callback = null
) {
	$post_meta_value = $_POST[$post_meta_key] ?? '';
	
	if (
		empty($post_meta_value)
	) return;

	if (
		is_callable($callback)
	)
		$post_meta_value = $callback($post_meta_value);

	update_post_meta(
		$post_id,
		$post_meta_key,
		$post_meta_value
	);
}

function save_meta(
	$post_id,
	$post_keys
) {
	foreach ($post_keys as $post_meta_key) {
		save_meta_value(
			$post_id,
			$post_meta_key
		);
	}
}

function upload_image(
	$id,
	$name
) {
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
		!in_array(
			$uploaded_type,
			$supported_types
		)
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
		isset($upload['error']) &&
		$upload['error'] != 0
	) {
		wp_die('Error with image upload: ' . $upload['error']);
	}
	
	add_post_meta($id, $name, $upload);
	update_post_meta($id, $name, $upload);
}

function render_image_upload(
	$post_id,
	$post_meta_key
) {
	$file = get_post_meta($post_id, $post_meta_key, true);

	if (!empty($file)) : ?>
	<img src="<?php echo $file['url'] ?>" />
	<?php endif ?>
	<input
		type="file"
		name="<?php echo $post_meta_key ?>"
	/>
	<?php
}

function render_input_field(
	$post_id,
	$post_meta_key,
	$input_type = 'text',
	$input_placeholder = ''
) {
	$post_meta_value = get_post_meta(
		$post_id,
		$post_meta_key,
		true
	) ?? '';
	?>
	<input
		type="<?php echo $input_type ?>"
		placeholder="<?php echo $input_placeholder ?>"
		name="<?php echo $post_meta_key ?>"
		value="<?php echo $post_meta_value ?>"
	/>
	<?php
}

function render_email_field(
	$post_id,
	$post_meta_key
) {
	render_input_field(
		$post_id,
		$post_meta_key,
		"email",
		"user@example.com"
	);
}

function render_date_field(
	$post_id,
	$post_meta_key
) {
	render_input_field(
		$post_id,
		$post_meta_key,
		"date"
	);
}

function render_time_field(
	$post_id,
	$post_meta_key
) {
	render_input_field(
		$post_id,
		$post_meta_key,
		'text',
		'HH:MM (24-hour time)'
	);
}
