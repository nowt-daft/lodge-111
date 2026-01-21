<?php
/**
 * Title: Office Bearer
 * Slug: testtheme/bearer
 * Categories: content
 * Description: Render Office Position
*/

$ID = get_the_ID();

?>
<article class="bearer">
	<header>
		<h1><?php the_title() ?></h1>
		<h2><?php
			echo get_post_meta(
				$ID,
				'office_bearers_name',
				true
			)
		?></h2>
	</header>
	<section class="photo">
		<img src="<?php
			$file = get_post_meta(
				$ID,
				'office_bearers_image',
				true
			);
			echo empty($file) ?
				'/wp-content/themes/testtheme/assets/img/placeholder.jpg' :
				$file['url']
		?>" />
	</section>
</article>
