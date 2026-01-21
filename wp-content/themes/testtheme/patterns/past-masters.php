<?php
/**
 * Title: Past Masters
 * Slug: testtheme/past-masters
 * Categories: content
 * Description: Render Past Masters
*/

$posts = get_posts([
	"post_type" => "masters",
	"order" => 'ASC',
	"posts_per_page" => -1
]);

if (empty($posts))
	return;
?>

<article class="office">
	<h1>Past Masters</h1>
	<ul>
		<?php foreach ($posts as $post) : ?>
		<li>
			<article class="bearer">
				<header>
					<h1><?php echo $post->post_title ?></h1>
					<p><?php echo $post->post_content ?></p>
				</header>
				<section class="photo">
					<img src="<?php
						$file = get_post_meta(
							$post->ID,
							'masters_image',
							true
						);
						echo empty($file) ?
							'/wp-content/themes/testtheme/assets/img/placeholder.jpg' :
							$file['url']
					?>" />
				</section>
			</article>
			<hr />
		</li>
		<?php endforeach ?>
	</ul>
</article>
