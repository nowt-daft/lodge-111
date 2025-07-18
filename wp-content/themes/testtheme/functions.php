<?php

add_filter(
	'show_admin_bar',
	'__return_false'
);

add_action(
	'wp_enqueue_scripts',
	function() {
		wp_enqueue_style(
			'theme-slug-style', 
			get_stylesheet_uri()
		);
	}
);

