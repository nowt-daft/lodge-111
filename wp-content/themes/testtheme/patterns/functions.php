<?php
/**
 * Title: Function Hall
 * Slug: testtheme/functions
 * Categories: content
 * Description: Render Function Content
*/

$latest_post = get_posts([
	"post_type" => "functions",
	"posts_per_page" => 1
]);

if (empty($latest_post))
	return;

$latest_post = $latest_post[0];

?>
<section class="function-hall">
	<header>
		<h2><?php echo $latest_post->post_title ?></h2>
	</header>

	<div class="content">
		<picture>
			<img
				src="<?php
					echo get_post_meta($latest_post->ID, 'functions_image', true)['url']
				?>"
				alt="NO DESCRIPTION"
			>
		</picture>
		<div class="description">
			<p>
				<?php echo $latest_post->post_content ?>
			</p>
			<a
				href="mailto:<?php
					echo get_post_meta($latest_post->ID, 'function_email', true) ?? ''
				?>"
				class="btn"
			>
				Book Now
			</a>
		</div>
	</div>
</section>
<hr />
