<?php
/**
 * Title: News
 * Slug: testtheme/news
 * Categories: content
 * Description: Render News
*/

$posts = get_posts([
	"post_type" => "news",
	"posts_per_page" => 3
]);

if (empty($posts))
	return;
?>
<section class="news">
	<ul>
		<?php foreach ($posts as $post) : ?>
		<li>
			<article class="snippet">
				<header>
					<h1><?php echo $post->post_title ?></h1>
				</header>
				<picture>
					<img
						src="<?php echo get_post_meta($post->ID, 'news_image', true)['url'] ?>"
						alt=""
					/>
				</picture>
				<p>
					<?php echo $post->post_content ?>
				</p>
				<!--<a href="#">Read more &gt;</a>-->
			</article>
		</li>
		<?php endforeach ?>
	</ul>
</section>
<hr />
