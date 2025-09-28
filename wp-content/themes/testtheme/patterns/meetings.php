<?php
/**
 * Title: Meetings
 * Slug: testtheme/meetings
 * Categories: content
 * Description: Render Meetings
*/

$latest_post = get_posts([
	"post_type" => "events",
	"posts_per_page" => 1
]);

if (empty($latest_post))
	return;

$latest_post = $latest_post[0];
$date = get_post_meta($latest_post->ID, 'event_date', true);
$time = get_post_meta($latest_post->ID, 'event_time', true);

$date_parts = explode('-', $date);

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

?>
<section class="meetings">
	<header>
		<h2><?php echo $latest_post->post_title ?></h2>
	</header>
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
		<p>
			<?php echo $latest_post->post_content ?>
		</p>
	</div>
</section>
<hr />
