<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'themerex_template_single_courses_theme_setup' ) ) {
	add_action( 'themerex_action_before_init_theme', 'themerex_template_single_courses_theme_setup', 1 );
	function themerex_template_single_courses_theme_setup() {
		themerex_add_template(array(
			'layout' => 'single-courses',
			'mode'   => 'single',
			'need_content' => true,
			'need_terms' => true,
			'title'  => esc_html__('Single Course item', 'education'),
			'thumb_title'  => esc_html__('Fullwidth image', 'education'),
			'w'		 => 1150,
			'h'		 => 647
		));
	}
}

// Template output
if ( !function_exists( 'themerex_template_single_courses_output' ) ) {
	function themerex_template_single_courses_output($post_options, $post_data) {
        if ( function_exists( 'trx_addons_plugin_post_data_atts' )){
            $post_data['post_views']++;
        }
		$avg_author = 0;
		$avg_users  = 0;
		if (!$post_data['post_protected'] && $post_options['reviews'] && themerex_get_custom_option('show_reviews')=='yes') {
			$avg_author = $post_data['post_reviews_author'];
			$avg_users  = $post_data['post_reviews_users'];
		}

		$body_style = themerex_get_custom_option('body_style');

		$show_title = themerex_get_custom_option('show_post_title')=='yes' && (themerex_get_custom_option('show_page_top')=='no' || themerex_get_custom_option('show_page_title')=='no');
		$title_over = $body_style=='fullscreen';
		$title_tag  = themerex_get_custom_option('show_page_top')=='yes' && themerex_get_custom_option('show_page_title')=='yes' ? 'h3' : 'h1';
		
		$parent_id = 0;
		$parent_post_title = $parent_post_link = '';
		$course_start = themerex_get_custom_option('date_start');
		$course_icon = $post_data['post_icon'];
		$price = $product = $product_link = '';
		if ($post_data['post_type']=='lesson') {
			$parent_id = themerex_get_custom_option('parent_course');
			if ( empty($parent_id) || themerex_is_inherit_option($parent_id) ) $parent_id = 0;
			if ($parent_id > 0) {
				$parent_post_title = get_the_title($parent_id);
				$parent_post_link = get_permalink($parent_id);
				$parent_post_options = get_post_meta($parent_id, 'post_custom_options', true);

				$course_start = empty($course_start) || themerex_is_inherit_option($course_start) ? $parent_post_options['date_start'] : $course_start;
				$course_icon = empty($course_icon) || themerex_is_inherit_option($course_icon) ? $parent_post_options['icon'] : $course_icon;

				$price = !empty($parent_post_options['price']) && !themerex_is_inherit_option($parent_post_options['price']) ? $parent_post_options['price'] : '';
				if ( empty($price) || themerex_is_inherit_option($price) ) $price = '';
				
				$product = !empty($parent_post_options['product']) && !themerex_is_inherit_option($parent_post_options['product']) ? $parent_post_options['product'] : 0;
				$product_link = $product ? get_permalink($product) : '';
			}
		} else {
			$price = themerex_get_custom_option('price');
			if ( empty($price) || themerex_is_inherit_option($price) ) $price = '';
			
			$product = themerex_get_custom_option('product');
			$product_link = $product ? get_permalink($product) : '';
		}

		if (empty($course_start) || themerex_is_inherit_option($course_start)) $course_start = '';

		$user_can_view_course = current_user_can('edit_posts', $post_data['post_id']) || (empty($price) && $course_start <= date('Y-m-d'));
		$user_bought_course = empty($price);

		if (!$user_can_view_course && $product && is_user_logged_in()) {
			$current_user = wp_get_current_user();
			$user_bought_course = wc_customer_bought_product( $current_user->user_email, $current_user->ID, $product );
			$user_can_view_course = $user_bought_course && $course_start <= date('Y-m-d');
		}

		themerex_open_wrapper('<article class="' 
				. join(' ', get_post_class('itemscope'
					. ' post_item post_item_single_courses'
					. ' post_featured_' . ($title_over ? 'center' : 'default')
					))
				. '"'
				. ' itemscope itemtype="http://schema.org/'.($avg_author > 0 || $avg_users > 0 ? 'Review' : 'Article')
				. '">');

		if ($show_title && $post_options['location'] == 'center' && !$title_over && (themerex_get_custom_option('show_page_top')=='no' || themerex_get_custom_option('show_page_title')=='no')) {
			?>
			<<?php echo esc_html($title_tag); ?> itemprop="<?php echo esc_attr($avg_author > 0 || $avg_users > 0 ? 'itemReviewed' : 'name'); ?>" class="post_title entry-title"><span class="post_icon <?php echo esc_attr($post_data['post_icon']); ?>"></span><?php themerex_show_layout($post_data['post_title']); ?></<?php echo esc_html($title_tag); ?>>
		<?php 
		}

		if (!$post_data['post_protected'] && (
			!empty($post_options['dedicated']) ||
			(themerex_get_custom_option('show_featured_image')=='yes' && $post_data['post_thumb'])
		)) {
			?>
			<section class="post_featured<?php if ($title_over) { echo ' bg_tint_dark'; } ?>">
			<?php
			if (!empty($post_options['dedicated'])) {
				themerex_show_layout($post_options['dedicated']);
			} else {
				if (!$title_over) themerex_enqueue_popup();
				?>
				<div class="post_thumb" data-image="<?php echo esc_url($post_data['post_attachment']); ?>" data-title="<?php echo esc_attr($post_data['post_title']); ?>">
					<?php echo (!$title_over ? '<a class="hover_icon hover_icon_view" href="'.esc_url($post_data['post_attachment']).'" title="'.esc_attr($post_data['post_title']).'">' : '') . ($post_data['post_thumb']) . (!$title_over ? '</a>' : ''); ?>
				</div>
				<?php
				if ($title_over) {
					$header_style = '';
					if (themerex_get_custom_option('top_panel_style') == 'light' && themerex_get_custom_option('show_page_top') == 'no') {
						$header_image2 = '';
						$theme_skin = sanitize_file_name(themerex_get_custom_option('theme_skin'));
						if (file_exists(themerex_get_file_dir('skins/'.($theme_skin).'/images/bg_over.png'))) {
							$header_image2 = themerex_get_file_url('skins/'.($theme_skin).'/images/bg_over.png');
						}
						if ($header_image2!='') { 
							$header_style = ' style="background-image: url('.esc_url($header_image2).'); background-repeat: repeat-x; background-position: center top;"';
						}
					}
					?>
					<div class="post_thumb_hover"<?php echo esc_attr($header_style); ?>>
						<div class="post_icon <?php echo esc_attr($course_icon); ?>"></div>
						<?php
						if (!empty($post_data['post_terms'][$post_data['post_taxonomy']]->terms_links) || !empty($parent_post_title)) {
							?>
							<div class="post_categories"><?php echo !empty($parent_post_title) 
								? esc_html__('Course:', 'education')  . ' '
									. (!empty($parent_post_link)
										? '<a href="'.esc_url($parent_post_link).'">'.esc_html($parent_post_title).'</a>'
										: $parent_post_title
										)
								: join(', ', $post_data['post_terms'][$post_data['post_taxonomy']]->terms_links); ?></div>
							<?php
						}
						?>
						<<?php echo esc_html($title_tag); ?> itemprop="name" class="post_title entry-title"><?php themerex_show_layout($post_data['post_title']); ?></<?php echo esc_html($title_tag); ?>>
						<?php 
						if ($user_can_view_course) {
							if ( $parent_id == 0 ) {
								$courses = themerex_get_lessons_list($post_data['post_id'], 1);
								if (count($courses) > 0) {
									$course_link = get_permalink($courses[0]->ID);
                                    if(function_exists('themerex_sc_button')) echo '<div class="post_button">' . themerex_sc_button(array('size'=>'medium', 'link'=>esc_url($course_link)), esc_html__('View Course', 'education')) . '</div>';
								}
							}
						} else if (!$user_bought_course && $product_link != '') {
                            if(function_exists('themerex_sc_button')) echo '<div class="post_button">'.themerex_sc_button(array('size' => 'medium', 'link'=> esc_url($product_link)),__('Apply to Course Now', 'education')).'</div>';
						}
						?>
					</div>
					<?php
				}
			}
			?>
			</section>
			<?php
			$course_time = themerex_get_custom_option('shedule');
			if (($pos=themerex_strpos($course_time, ':'))!==false)
				$course_time = trim(themerex_substr($course_time, max(0, $pos-2), 5));
			else
				$course_time = '00:00';
			if (($countdown_style = themerex_get_custom_option('show_countdown')) > 0 && $course_start.' '.$course_time > date_i18n('Y-m-d H:i')) {
				?>
				<div class="post_countdown">
					<h4 class="post_countdown_title"><?php if ($parent_id) { esc_html_e('This Lesson Starts In', 'education'); } else { esc_html_e('The Course Starts In', 'education'); } ?></h4>
					<?php
					$args = array(
							'date'=>esc_attr($course_start),
							'style' => max(1, min(2, $countdown_style)));

					if ($course_time != '') {
						$args['time'] = esc_attr($course_time);
					}

					echo themerex_sc_countdown( $args ); ?>
				</div>
				<?php
			}
		}
			
		if ($body_style=='fullscreen') themerex_open_wrapper('<div class="content_wrap">');
		
		if (!$title_over && $show_title && $post_options['location'] != 'center' && (themerex_get_custom_option('show_page_top')=='no' || themerex_get_custom_option('show_page_title')=='no')) {
			?>
			<<?php echo esc_html($title_tag); ?> itemprop="<?php echo esc_attr($avg_author > 0 || $avg_users > 0 ? 'itemReviewed' : 'name'); ?>" class="post_title entry-title"><span class="post_icon <?php echo esc_attr($post_data['post_icon']); ?>"></span><?php themerex_show_layout($post_data['post_title']); ?></<?php echo esc_html($title_tag); ?>>
			<?php 
		}

		if ( ($parent_id == 0 || $user_can_view_course) && !$post_data['post_protected'] && themerex_get_custom_option('show_post_info')=='yes') {
			$info_parts = array('snippets'=>true, 'shedule'=>true, 'length'=>true, 'terms'=>false, 'counters'=>false);
			require(themerex_get_file_dir('templates/parts/post-info.php')); 
		}
		
		if ($parent_id == 0) {
			require(themerex_get_file_dir('templates/parts/reviews-block.php'));
		}
			
		themerex_open_wrapper('<section class="post_content" itemprop="' . ($avg_author > 0 || $avg_users > 0 ? 'reviewBody' : 'articleBody') . '">');
			
		// Post content
		if ($post_data['post_protected']) { 
			themerex_show_layout($post_data['post_excerpt']);
			echo get_the_password_form(); 
		} else {
			if (function_exists('themerex_sc_reviews_placeholder') && $parent_id == 0 && themerex_strpos($post_data['post_content'], themerex_sc_reviews_placeholder())===false)
				$post_data['post_content'] = (shortcode_exists('trx_reviews')? do_shortcode('[trx_reviews]') : '') . ($post_data['post_content']);

			if ($parent_id == 0 || $user_can_view_course) {
                if(function_exists('themerex_sc_gap_wrapper')) themerex_show_layout(themerex_sc_gap_wrapper(themerex_sc_reviews_wrapper($post_data['post_content'])));
			} else {
				?>
				<div class="post_access_denied">
					<?php
					echo '<p>'
						. ($user_bought_course
							? esc_html__('This lesson start after', 'education') . ' ' . date_i18n(get_option('date_format'), strtotime($course_start))
							: esc_html__('Unfortunately, you are not permitted to view this course!', 'education')
							)
						. '</p>';
					if (!$user_bought_course && $product_link != '') {
						echo '<p>'. esc_html__('To purchase it - click the button below:', 'education'). '</p>';
                        if(function_exists('themerex_sc_button')) echo '<div class="post_button">'. themerex_sc_button(array('size'=>'medium', 'link'=>esc_url($product_link)), esc_html__('Apply to Course Now', 'education')) . '</div>';
					}
					?>
				</div>
				<?php
			}

			if ($parent_id == 0 || $user_can_view_course || $user_bought_course) {
				require(themerex_get_file_dir('templates/parts/single-pagination.php'));
			}

			if ($parent_id == 0 && themerex_get_custom_option('show_post_tags') == 'yes' && !empty($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_links)) {
				?>
				<div class="post_info post_info_bottom">
					<span class="post_info_item post_info_tags"><?php esc_html_e('Tags:', 'education'); ?> <?php echo join(', ', $post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_links); ?></span>
				</div>
				<?php 
			}
		} 
			
		themerex_close_wrapper();
			
		if (!$post_data['post_protected']) {
			if ($post_data['post_edit_enable']) {
				require(themerex_get_file_dir('templates/parts/editor-area.php'));
			}
			require(themerex_get_file_dir('templates/parts/author-info.php'));
			require(themerex_get_file_dir('templates/parts/share.php'));
		}

		if ($body_style=='fullscreen') themerex_close_wrapper();

		themerex_close_wrapper();

		if (!$post_data['post_protected']) {

			require(themerex_get_file_dir('templates/parts/related-posts.php'));

			if ($body_style=='fullscreen') themerex_open_wrapper('<div class="content_wrap">');
			require(themerex_get_file_dir('templates/parts/comments.php'));
			if ($body_style=='fullscreen') themerex_close_wrapper();
		}

		require(themerex_get_file_dir('templates/parts/views-counter.php'));
	}
}
?>