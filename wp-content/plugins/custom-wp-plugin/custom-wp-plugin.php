<?php
/**
 * Plugin Name:	  Hawick Lodge Website Plugin
 * Author:		  Graham Robertson
 */

require_once __DIR__ . "/includes.php";

require_once __DIR__ . "/types/hero.php";
require_once __DIR__ . "/types/announcement.php";
require_once __DIR__ . "/types/news.php";
require_once __DIR__ . "/types/event.php";
require_once __DIR__ . "/types/function.php";
require_once __DIR__ . "/types/history.php";
require_once __DIR__ . "/types/office_bearer.php";
require_once __DIR__ . "/types/master.php";

/**
 * ALLOW IMAGE UPLOADS
 */
add_action(
	'post_edit_form_tag',
	function() {
		echo ' enctype="multipart/form-data"';
	}
);

