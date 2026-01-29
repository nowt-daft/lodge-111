<?php
/**
 * TYPE: history
 * PLURAL: history
 * SLUG: /history
 */

// DEFINITION:
add_action(
	'init',
	function() {
		register_post_type(
			'history',
			[
				'labels'        => generate_post_labels(
					'History Chapter',
					'History',
				),
				'public'        => true,
				'supports'      => ['title', 'editor'],
				'menu_icon'     => 'dashicons-book',
				'menu_position' => 1,
				'has_archive'   => true,
				'rewrite'       => ['slug' => 'history'],
			]
		);
		register_meta(
			'history',
			'history_chapter_order',
			[
				'type' => 'integer',
				// Should I do this with other meta values?
				'single' => true,
				'sanitize_callback' => 'absint',
				// Is the lower part necessary
				/* 'auth_callback' => function() { */
				/* 	return current_user_can('edit_posts'); */
				/* } */
			]
		);
	}
);

// ADMIN BOXES:
add_action(
	'add_meta_boxes',
	function() {
		add_meta_box(
			'history_chapter_order',
			'Chapter Order/Index',
			function($post) {
				$meta_key = 'history_chapter_order';
				$meta_value = get_post_meta(
					$post->ID,
					$meta_key,
					true
				) ?? '0';
				?>
					<input
						type="number"
						min="0"
						step="1"

						name="<?php echo $meta_key ?>"
						value="<?php echo $meta_value ?>"
					/>
				<?php
			},
			'history',
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
			$type != 'history'
		) return;

		save_meta_value(
			$id,
			"history_chapter_order",
			function($value) {
				return absint($value);
			}
		);
	}
);

