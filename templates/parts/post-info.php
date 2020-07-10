			<div class="post_info">
				<?php
				$info_parts = array_merge(array(
					'snippets' => false,	// For singular post/page/course/team etc.
					'date' => true,
					'author' => true,
					'terms' => true,
					'counters' => true,
					'shedule' => false,		// For single course
					'length' => false		// For single course
					), isset($info_parts) && is_array($info_parts) ? $info_parts : array());
									
				if (in_array($post_data['post_type'], array('courses', 'lesson'))) {
					$course_start = is_single() ? themerex_get_custom_option('date_start') : themerex_get_custom_option('date_start', '', $post_data['post_id'], $post_data['post_type']);	//!!!!!
					if (empty($course_start) || themerex_is_inherit_option($course_start)) $course_start = '';
					$course_end  = is_single() ? themerex_get_custom_option('date_end') : themerex_get_custom_option('date_end', '', $post_data['post_id'], $post_data['post_type']);	//!!!!!
					if (empty($course_end) || themerex_is_inherit_option($course_end)) $course_end = '';
					$course_shed = is_single() ? themerex_get_custom_option('shedule') : themerex_get_custom_option('shedule', '', $post_data['post_id'], $post_data['post_type']);	//!!!!!
					$showed_time = false;
					if ($info_parts['date'] && !empty($course_start)) {
						?>
						<span class="post_info_item post_info_posted"><?php
							echo ( empty($course_end) || $course_end >= date('Y-m-d') 
								? ( $course_start >= date('Y-m-d') 
									? esc_html__('Starts on', 'education')
									: esc_html__('Started on', 'education'))
								: esc_html__('Finished on', 'education')); ?> <a href="<?php echo esc_url($post_data['post_link']); ?>" class="post_info_date<?php echo esc_attr($info_parts['snippets'] ? ' date updated' : ''); ?>"<?php if ($info_parts['snippets']) { echo ' itemprop="datePublished" content="'.esc_attr($course_start).'"'; } ?>><?php themerex_show_layout(themerex_get_date_translations(date_i18n(get_option('date_format'), strtotime(empty($course_end) || themerex_is_inherit_option($course_end) || $course_end >= date('Y-m-d') ? $course_start : $course_end)))); ?></a></span>
						<?php
						$showed_time = true;
					}
					if ($info_parts['shedule'] && !empty($course_shed)) {
						?>
						<span class="post_info_item post_info_time<?php echo (!$showed_time ? ' post_info_posted' : ''); ?>"><?php themerex_show_layout($course_shed); ?></span>
						<?php
						$showed_time = true;
					}
					if ($info_parts['length'] && !empty($course_start) && !empty($course_end)) {
						?>
						<span class="post_info_item post_info_length<?php echo (!$showed_time ? ' post_info_posted' : ''); ?>"><?php esc_html_e('Length', 'education'); ?> <span class="post_info_months"><?php themerex_show_layout(themerex_get_date_difference($course_start, $course_end, 2)); ?></span></span>
						<?php
					}
					if ($info_parts['terms'] && !empty($post_data['post_terms'][$post_data['post_taxonomy']]->terms_links)) {
						?>
						<span class="post_info_item post_info_tags"><?php esc_html_e('Category', 'education'); ?> <?php echo join(', ', $post_data['post_terms'][$post_data['post_taxonomy']]->terms_links); ?></span>
						<?php
					}
					if ($info_parts['author'] && $post_data['post_type']=='lesson') {
						$teacher_id = is_single() ? themerex_get_custom_option('teacher') : themerex_get_custom_option('teacher', '', $post_data['post_id'], $post_data['post_type']);	//!!!!!
						$teacher_post = get_post($teacher_id);
						$teacher_link = get_permalink($teacher_id);
						?>
						<span class="post_info_item post_info_posted_by<?php if ($info_parts['snippets']) { echo ' vcard'; } ?>"<?php if ($info_parts['snippets']) {echo ' itemprop="author"'; } ?>><?php esc_html_e('Teacher', 'education'); ?> <a href="<?php echo esc_url($teacher_link); ?>" class="post_info_author"><?php echo esc_html($teacher_post->post_title); ?></a></span>
					<?php 
					}
				} else {
					if ($info_parts['date']) {
						$post_date = apply_filters('themerex_filter_post_date', $post_data['post_date_sql'], $post_data['post_id'], $post_data['post_type']);
						$post_date_diff = themerex_get_date_or_difference($post_date);
						?>
						<span class="post_info_item post_info_posted"><?php echo (in_array($post_data['post_type'], array('post', 'page', 'product')) ? esc_html__('Posted', 'education') : ($post_date <= date('Y-m-d') ? esc_html__('Started', 'education') : esc_html__('Will start', 'education'))); ?> <a href="<?php echo esc_url($post_data['post_link']); ?>" class="post_info_date<?php echo esc_attr($info_parts['snippets'] ? ' date updated' : ''); ?>"<?php if ($info_parts['snippets']) { echo ' itemprop="datePublished" content="'.esc_attr($post_date).'"'; } ?>><?php echo esc_html($post_date_diff); ?></a></span>
						<?php
					}
					if ($info_parts['author'] && $post_data['post_type']=='post') {
						?>
						<span class="post_info_item post_info_posted_by<?php if ($info_parts['snippets']) { echo ' vcard'; } ?>"<?php if ($info_parts['snippets']) { echo ' itemprop="author"'; } ?>><?php esc_html_e('by', 'education'); ?> <a href="<?php echo esc_url($post_data['post_author_url']); ?>" class="post_info_author"><?php themerex_show_layout($post_data['post_author']); ?></a></span>
					<?php 
					}
					if ($info_parts['terms'] && !empty($post_data['post_terms'][$post_data['post_taxonomy']]->terms_links)) {
						?>
						<span class="post_info_item post_info_tags"><?php esc_html_e('in', 'education'); ?> <?php echo join(', ', $post_data['post_terms'][$post_data['post_taxonomy']]->terms_links); ?></span>
						<?php
					}
				}
				if ($info_parts['counters']) {
					?>
					<span class="post_info_item post_info_counters"><?php require(themerex_get_file_dir('templates/parts/counters.php')); ?></span>
					<?php
				}
				?>
			</div>
