<?php
/**
 * TYPE: hero
 * PLURAL: heros
 * SLUG: /heros
 */

// TYPE DEFINITION:
add_action(
	'init',
	function() {
		register_post_type(
			'heros',
			[
				'labels'        => generate_post_labels(
					'Hero Post',
					'Hero Posts',
				),
				'public'        => true,
				'supports'      => ['editor'],
				'menu_icon'     => 'dashicons-admin-post',
				'menu_position' => 1,
				'has_archive'   => true,
				'rewrite'       => ['slug' => 'hero']
			]
		);
	}
);
