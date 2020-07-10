<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'themerex_template_date_theme_setup' ) ) {
	add_action( 'themerex_action_before_init_theme', 'themerex_template_date_theme_setup', 1 );
	function themerex_template_date_theme_setup() {
		themerex_add_template(array(
			'layout' => 'date',
			'mode'   => 'blogger',
			'title'  => esc_html__('Blogger layout: Timeline', 'education')
			));
	}
}

// Template output
if ( !function_exists( 'themerex_template_date_output' ) ) {
	function themerex_template_date_output($post_options, $post_data) {
		if (themerex_sc_param_is_on($post_options['scroll'])) themerex_enqueue_slider();
		require(themerex_get_file_dir('templates/parts/reviews-summary.php'));
		?>
		
		<div class="post_item sc_blogger_item
			<?php if ($post_options['number'] == $post_options['posts_on_page'] && !themerex_sc_param_is_on($post_options['loadmore'])) { echo esc_attr(' sc_blogger_item_last'); }
				?>"
			<?php if ($post_options['dir'] == 'horizontal') { echo ' style="width:'.(100/$post_options['posts_on_page']).'%"'; } ?>>
			<div class="sc_blogger_date">
				<span class="day_month"><?php themerex_show_layout($post_data['post_date_part1']); ?></span>
				<span class="year"><?php themerex_show_layout($post_data['post_date_part2']); ?></span>
			</div>

			<div class="post_content">
				<h6 class="post_title sc_title sc_blogger_title">
					<?php echo (!isset($post_options['links']) || $post_options['links'] ? '<a href="' . esc_url($post_data['post_link']) . '">' : ''); ?>
					<?php themerex_show_layout($post_data['post_title']); ?>
					<?php echo (!isset($post_options['links']) || $post_options['links'] ? '</a>' : ''); ?>
				</h6>
				
				<?php if (!empty($reviews_summary)) {
					themerex_show_layout($reviews_summary);
				} ?>
	
				<?php if (themerex_sc_param_is_on($post_options['info'])) { ?>
				<div class="post_info">
					<span class="post_info_item post_info_posted_by"><?php esc_html_e('by', 'education'); ?> <a href="<?php echo esc_url($post_data['post_author_url']); ?>" class="post_info_author"><?php echo esc_html($post_data['post_author']); ?></a></span>
					<span class="post_info_item post_info_counters">
						<?php if ($post_options['orderby']=='comments' || $post_options['counters']=='comments') { esc_html_e('Comments', 'education'); } else { esc_html_e('Views', 'education'); } ?>
						<span class="post_info_counters_number"><?php if ($post_options['orderby']=='comments' || $post_options['counters']=='comments') { themerex_show_layout($post_data['post_comments']); } else { themerex_show_layout($post_data['post_views']); } ?></span>
					</span>
				</div>
				<?php } ?>

			</div>	<!-- /.post_content -->
		
		</div>		<!-- /.post_item -->

		<?php
		if ($post_options['number'] == $post_options['posts_on_page'] && themerex_sc_param_is_on($post_options['loadmore'])) {
		?>
			<div class="load_more"<?php if ($post_options['dir'] == 'horizontal') { echo ' style="width:'.(100/$post_options['posts_on_page']).'%"'; } ?>></div>
		<?php
		}
	}
}
?>