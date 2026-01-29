<?php
/**
 * Title: History List
 * Slug: testtheme/history-list
 * Categories: content
 * Description: Render History
*/

$posts = get_posts([
	"post_type" => "history",
	"meta_key" => 'history_chapter_order',
	"orderby" => 'meta_value_num',
	"order" => 'ASC',
	"posts_per_page" => -1
]);

if (empty($posts))
	return;
?>

<article class="history">
	<h1>Table of Contents</h1>
	<ul>
		<?php foreach ($posts as $post) : ?>
		<li class="chapter">
			<h2>
				<a
					href="/history/<?php echo $post->post_name ?>"
				>
					<?php echo $post->post_title ?>
				</a>
			</h2>
		</li>
		<?php endforeach ?>
	</ul>
</article>
