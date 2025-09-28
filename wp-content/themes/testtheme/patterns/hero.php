<?php
/**
 * Title: Hero
 * Slug: testtheme/hero
 * Categories: content
 * Description: Render Hero
*/

$latest_post = get_posts([
	"post_type" => "heros",
	"posts_per_page" => 1
]);

if (empty($latest_post))
	return;

$latest_post = $latest_post[0];

?>
<section class="mission">
	<blockquote cite="">
		<?php echo $latest_post->post_content ?>
	</blockquote>
</section>
<hr />
