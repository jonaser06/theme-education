<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'themerex_template_related_theme_setup' ) ) {
	add_action( 'themerex_action_before_init_theme', 'themerex_template_related_theme_setup', 1 );
	function themerex_template_related_theme_setup() {
		themerex_add_template(array(
			'layout' => 'related',
			'mode'   => 'blog',
			'need_columns' => true,
			'title'  => esc_html__('Related posts /no columns/', 'education'),
			'thumb_title'  => esc_html__('Medium image (crop)', 'education'),
			'w'		 => 400,
			'h'		 => 225
		));
		themerex_add_template(array(
			'layout' => 'related_2',
			'template' => 'related',
			'mode'   => 'blog',
			'need_columns' => true,
			'title'  => esc_html__('Related posts /2 columns/', 'education'),
			'thumb_title'  => esc_html__('Large image (crop)', 'education'),
			'w'		 => 750,
			'h'		 => 422
		));
		themerex_add_template(array(
			'layout' => 'related_3',
			'template' => 'related',
			'mode'   => 'blog',
			'need_columns' => true,
			'title'  => esc_html__('Related posts /3 columns/', 'education'),
			'thumb_title'  => esc_html__('Medium image (crop)', 'education'),
			'w'		 => 400,
			'h'		 => 225
		));
		themerex_add_template(array(
			'layout' => 'related_4',
			'template' => 'related',
			'mode'   => 'blog',
			'need_columns' => true,
			'title'  => esc_html__('Related posts /4 columns/', 'education'),
			'thumb_title'  => esc_html__('Small image (crop)', 'education'),
			'w'		 => 250,
			'h'		 => 141
		));
	}
}

// Template output
if ( !function_exists( 'themerex_template_related_output' ) ) {
	function themerex_template_related_output($post_options, $post_data) {
		$show_title = true;
		$parts = explode('_', $post_options['layout']);
		$style = $parts[0];
		$columns = max(1, min(4, empty($parts[1]) ? $post_options['columns_count'] : (int) $parts[1]));
        if(function_exists('themerex_sc_in_shortcode_blogger') && themerex_sc_in_shortcode_blogger(true)){
            $tag = 'div';
        } else {
            $tag = 'article';
        }
		$post_color = themerex_get_custom_option('post_color', '', $post_data['post_id'], $post_data['post_type']);
		if ($columns > 1) {
			?><div class="<?php echo 'column-1_'.esc_attr($columns); ?> column_padding_bottom"><?php
		}
		?>
		<<?php themerex_show_layout($tag); ?> class="post_item post_item_<?php echo esc_attr($style); ?> post_item_<?php echo esc_attr($post_options['number']); ?>">

			<div class="post_content">
				<?php if ($post_data['post_video'] || $post_data['post_thumb'] || $post_data['post_gallery']) { ?>
				<div class="post_featured">
					<?php require(themerex_get_file_dir('templates/parts/post-featured.php')); ?>
				</div>
				<?php } ?>

				<?php if ($show_title) { ?>
					<div class="post_content_wrap"<?php if (!empty($post_color)) { echo ' style="border-color:'.esc_attr($post_color).'"'; } ?>>
					<?php if (!isset($post_options['links']) || $post_options['links']) { ?>
						<h4 class="post_title"><a href="<?php echo esc_url($post_data['post_link']); ?>"<?php if (!empty($post_color)) { echo ' style="color:'.esc_attr($post_color).'"'; } ?>><?php themerex_show_layout($post_data['post_title']); ?></a></h4>
					<?php } else { ?>
						<h4 class="post_title"<?php if (!empty($post_color)) { echo ' style="color:'.esc_attr($post_color).'"'; } ?>><?php themerex_show_layout($post_data['post_title']); ?></h4>
					<?php }
					?>
					</div>
				<?php } ?>
			</div>	<!-- /.post_content -->
		</<?php themerex_show_layout($tag); ?>>	<!-- /.post_item -->
		<?php
		if ($columns > 1) {
			?></div><?php
		}
	}
}
?>