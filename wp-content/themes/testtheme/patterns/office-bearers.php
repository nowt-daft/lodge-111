<?php
/**
 * Title: Office Bearers
 * Slug: testtheme/office-bearers
 * Categories: content
 * Description: Render Office Positions
*/

$posts = get_posts([
	"post_type" => "office_bearers",
	"order" => 'ASC',
	"posts_per_page" => -1
]);

if (empty($posts))
	return;
?>

<article class="office">
	<h1>Office Bearers</h1>
	<ul>
		<?php foreach ($posts as $post) : ?>
		<li>
			<article class="bearer">
				<header>
					<h1><?php echo $post->post_title ?></h1>
					<h2><?php
						echo get_post_meta(
							$post->ID,
							'office_bearers_name',
							true
						)
					?></h2>
				</header>
				<section class="photo">
					<img src="<?php
						$file = get_post_meta(
							$post->ID,
							'office_bearers_image',
							true
						);
						echo empty($file) ?
							'/wp-content/themes/testtheme/assets/img/placeholder.jpg' :
							$file['url']
					?>" />
				</section>
			</article>
		</li>
		<?php endforeach ?>
	</ul>
</article>
