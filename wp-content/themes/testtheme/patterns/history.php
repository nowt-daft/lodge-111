<?php
/**
 * Title: History
 * Slug: testtheme/history
 * Categories: content
 * Description: Render History
*/

$posts = get_posts([
	"post_type" => "history",
	"posts_per_page" => 1
]);

if (empty($posts))
	return;

?>

<?php foreach ($posts as $post) : ?>
<article class="history">
	<h1>History</h1>
	<?php echo $post->post_content ?>
</article>
<?php endforeach ?>
