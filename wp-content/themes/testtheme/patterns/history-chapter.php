<?php
/**
 * Title: History Chapter
 * Slug: testtheme/history-chapter
 * Categories: content
 * Description: Render History Chapter
*/

$prev_name = "";
$next_name = "";

$chapter_number = (int)get_post_meta(
	get_the_ID(),
	'history_chapter_order',
	true
);

if ($chapter_number > 0)
	$prev_name = get_posts([
		"post_type" => "history",
		"meta_query" => [
			[
				'key' => 'history_chapter_order',
				'value' => (string)($chapter_number - 1),
				'compare' => '='
			],
		]
	])[0]->post_name;

$next_chapter = get_posts([
	"post_type" => "history",
	"meta_query" => [
		[
			'key' => 'history_chapter_order',
			'value' => (string)($chapter_number + 1),
			'compare' => '='
		],
	]
])[0];

if (!is_null($next_chapter))
	$next_name = $next_chapter->post_name;

?>

<article class="history-chapter">
	<nav>
		<?php if (!empty($prev_name)) : ?>
		<a
			class="prev"
			href="/history/<?php echo $prev_name ?>"
		>
			&lt; Previous
		</a>
		<?php endif ?>
		<a href="/history">
			Top &uarr;
		</a>
		<?php if (!empty($next_name)) : ?>
		<a
			class="next"
			href="/history/<?php echo $next_name ?>"
		>
			Next &gt;
		</a>
		<?php endif ?>
	</nav>
	<hr />

	<h1><?php the_title() ?></h1>
	<?php the_content() ?>

	<hr />
	<nav>
		<?php if (!empty($prev_name)) : ?>
		<a
			class="prev"
			href="/history/<?php echo $prev_name ?>"
		>
			&lt; Previous
		</a>
		<?php endif ?>
		<?php if (!empty($next_name)) : ?>
		<a
			class="next"
			href="/history/<?php echo $next_name ?>"
		>
			Next &gt;
		</a>
		<?php endif ?>
	</nav>
</article>
