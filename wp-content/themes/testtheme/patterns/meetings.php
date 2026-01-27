<?php
/**
 * Title: Meetings
 * Slug: testtheme/meetings
 * Categories: content
 * Description: Render Meetings
*/

$months = [
	"___",
	"JAN",
	"FEB",
	"MAR",
	"APR",
	"MAY",
	"JUN",
	"JUL",
	"AUG",
	"SEP",
	"OCT",
	"NOV",
	"DEC"
];

$posts = get_posts([
	"post_type" => "events",
	"posts_per_page" => 3
]);

if (empty($posts))
	return;

?>
<section class="meetings">
	<ul>
		<?php foreach ($posts as $post) : ?>
		<li>
			<article>

				<?php
					$ID = $post->ID;

					$date = get_post_meta($ID, 'event_date', true);
					$time = get_post_meta($ID, 'event_time', true);

					$date_parts = explode('-', $date);
				?>

				<div class="content">	
					<time
						datetime="<?php echo $date ?>T<?php $time ?>"
					>
						<span class="month">
							<?php echo $months[(int)$date_parts[1]] ?>
						</span>
						<span class="day">
							<?php echo $date_parts[2] ?>
						</span>
					</time>
					<header>
						<h2><?php echo $post->post_title ?></h2>
						<p>
							<?php echo $post->post_content ?>
						</p>
					</header>
				</div>

			</article>
		</li>
		<?php endforeach ?>
	</ul>
</section>
<hr />
