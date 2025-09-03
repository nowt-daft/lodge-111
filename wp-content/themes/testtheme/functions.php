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
		wp_enqueue_style(
			'map-style',
			'https://unpkg.com/maplibre-gl@^5.6.1/dist/maplibre-gl.css'
		);
		wp_enqueue_script(
			'map-script',
			'https://unpkg.com/maplibre-gl@^5.6.1/dist/maplibre-gl.js'
		);
	}
);

