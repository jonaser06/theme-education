<?php
/**
 * ThemeREX Framework: Lesson post type settings
 *
 * @package	themerex
 * @since	themerex 1.0
 */

// Theme init
if (!function_exists('themerex_lesson_theme_setup')) {
	add_action( 'themerex_action_before_init_theme', 'themerex_lesson_theme_setup' );
	function themerex_lesson_theme_setup() {

		// Add post specific actions and filters
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['post_override_options']) && $THEMEREX_GLOBALS['post_override_options']['page']=='lesson') {
			add_filter('themerex_filter_post_save_custom_options',		'themerex_lesson_save_custom_options', 10, 3);
		}

		// Add categories (taxonomies) filter for custom posts types
		add_action( 'restrict_manage_posts','themerex_lesson_show_courses_combo' );
		add_filter( 'pre_get_posts', 		'themerex_lesson_add_parent_course_in_query' );

		// Extra column for lessons lists with overriden Theme Options
		if (themerex_get_theme_option('show_overriden_posts')=='yes') {
			add_filter('manage_edit-lesson_columns',		'themerex_post_add_options_column', 9);
			add_filter('manage_lesson_posts_custom_column',	'themerex_post_fill_options_column', 9, 2);
		}
		// Extra column for lessons lists with parent course name
		add_filter('manage_edit-lesson_columns',		'themerex_lesson_add_options_column', 9);
		add_filter('manage_lesson_posts_custom_column',	'themerex_lesson_fill_options_column', 9, 2);

		// Add shortcode [trx_lessons]
		add_action( 'themerex_action_shortcodes_list',		'themerex_lesson_require_shortcodes' );
		add_action( 'themerex_action_shortcodes_list_vc',	'themerex_lesson_require_shortcodes_vc' );
	}
}


/* Extra column for lessons list
-------------------------------------------------------------------------------------------- */

// Create additional column
if (!function_exists('themerex_lesson_add_options_column')) {
	function themerex_lesson_add_options_column( $columns ) {
		themerex_array_insert_after( $columns, 'title', array('course_title' => esc_html__('Course', 'education')) );
		return $columns;
	}
}

// Fill column with data
if (!function_exists('themerex_lesson_fill_options_column')) {
	function themerex_lesson_fill_options_column($column_name='', $post_id=0) {
		if ($column_name != 'course_title') return;
		if ($parent_id = get_post_meta($post_id, 'parent_course', true)) {
			if ($parent_id > 0) {
				$parent_title = get_the_title($parent_id);
				echo '<a href="#" onclick="jQuery(\'select#parent_course\').val('.intval($parent_id).').siblings(\'input[type=\\\'submit\\\']\').trigger(\'click\'); return false;" title="'.esc_attr(__('Leave only lessons of this course', 'education')).'">' . strip_tags($parent_title) . '</a>';
			}
		}
	}
}


/* Display filter for lessons by courses
-------------------------------------------------------------------------------------------- */

// Display filter combobox
if (!function_exists('themerex_lesson_show_courses_combo')) {
	function themerex_lesson_show_courses_combo() {
		$page = get_query_var('post_type');
		if ($page != 'lesson') return;
		$courses = themerex_get_list_posts(false, array(
					'post_type' => 'courses',
					'orderby' => 'title',
					'order' => 'asc'
					)
		);
		$list = '';
		if (count($courses) > 0) {
			$slug = 'parent_course';
			$list .= '<label class="screen-reader-text filter_label" for="'.esc_attr($slug).'">' . esc_html__('Parent Course:', 'education') . "</label> <select name='".esc_attr($slug)."' id='".esc_attr($slug)."' class='postform'>";
			foreach ($courses as $id=>$name) {
				$list .= '<option value='. esc_attr($id) . (isset($_GET[$slug]) && $_GET[$slug] == $id ? ' selected="selected"' : '') . '>' . esc_html($name) . '</option>';
			}
			$list .=  "</select>";
		}
		themerex_show_layout($list);
	}
}

// Add filter in main query
if (!function_exists('themerex_lesson_add_parent_course_in_query')) {
	function themerex_lesson_add_parent_course_in_query($query) {
		if ( is_admin() && themerex_strpos(add_query_arg(array()), 'edit.php')!==false && $query->is_main_query() && $query->get( 'post_type' )=='lesson' ) {
			$parent_course = isset( $_GET['parent_course'] ) ? intval($_GET['parent_course']) : 0;
			if ($parent_course > 0 ) {
				$meta_query = $query->get( 'meta_query' );
				if (!is_array($meta_query)) $meta_query = array();
				$meta_query['relation'] = 'AND';
				$meta_query[] = array(
					'meta_filter' => 'lesson',
					'key' => 'parent_course',
					'value' => $parent_course,
					'compare' => '=',
					'type' => 'NUMERIC'
				);
				$query->set( 'meta_query', $meta_query );
			}
		}
		return $query;
	}
}


/* Display metabox for lessons
-------------------------------------------------------------------------------------------- */

if (!function_exists('themerex_lesson_after_theme_setup')) {
	add_action( 'themerex_action_after_init_theme', 'themerex_lesson_after_theme_setup' );
	function themerex_lesson_after_theme_setup() {
		// Update fields in the override options
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['post_override_options']) && $THEMEREX_GLOBALS['post_override_options']['page']=='lesson') {
			// Override Options fields
			$THEMEREX_GLOBALS['post_override_options']['title'] = esc_html__('Lesson Options', 'education');
			$THEMEREX_GLOBALS['post_override_options']['fields'] = array(
				"mb_partition_lessons" => array(
					"title" => esc_html__('Lesson', 'education'),
					"override" => "page,post",
					"divider" => false,
					"icon" => "iconadmin-users-1",
					"type" => "partition"),
				"mb_info_lessons_1" => array(
					"title" => esc_html__('Lesson details', 'education'),
					"override" => "page,post",
					"divider" => false,
					"desc" => esc_html__('In this section you can put details for this lesson', 'education'),
					"class" => "course_meta",
					"type" => "info"),
				"parent_course" => array(
					"title" => esc_html__('Parent Course',  'education'),
					"desc" => esc_html__("Select parent course for this lesson", 'education'),
					"override" => "page,post",
					"class" => "lesson_parent_course",
					"std" => '',
					"options" => themerex_get_list_posts(false, array(
						'post_type' => 'courses',
						'orderby' => 'title',
						'order' => 'asc'
						)
					),
					"type" => "select"),
				"teacher" => array(
					"title" => esc_html__('Teacher',  'education'),
					"desc" => esc_html__("Main Teacher for this lesson", 'education'),
					"override" => "page,post",
					"class" => "lesson_teacher",
					"std" => '',
					"options" => themerex_get_list_posts(false, array(
						'post_type' => 'team',
						'orderby' => 'title',
						'order' => 'asc')
					),
					"type" => "select"),
				"date_start" => array(
					"title" => esc_html__('Start date',  'education'),
					"desc" => esc_html__("Lesson start date", 'education'),
					"override" => "page,post",
					"class" => "lesson_date",
					"std" => date('Y-m-d'),
					"format" => 'yy-mm-dd',
					"type" => "date"),
				"date_end" => array(
					"title" => esc_html__('End date',  'education'),
					"desc" => esc_html__("Lesson finish date", 'education'),
					"override" => "page,post",
					"class" => "lesson_date",
					"std" => date('Y-m-d'),
					"format" => 'yy-mm-dd',
					"type" => "date"),
				"shedule" => array(
					"title" => esc_html__('Schedule time',  'education'),
					"desc" => esc_html__("Lesson start days and time. For example: Mon, Wed, Fri 19:00-21:00", 'education'),
					"override" => "page,post",
					"class" => "lesson_time",
					"std" => '',
					"divider" => false,
					"type" => "text")
			);
		}
	}
}

// Before save custom options - calc and save average rating
if (!function_exists('themerex_lesson_save_custom_options')) {
	function themerex_lesson_save_custom_options($custom_options, $post_type, $post_id) {
		if (isset($custom_options['parent_course'])) {
			update_post_meta($post_id, 'parent_course', $custom_options['parent_course']);
		}
		if (isset($custom_options['date_start'])) {
			update_post_meta($post_id, 'date_start', $custom_options['date_start']);
		}
		return $custom_options;
	}
}


// Return lessons list by parent course post ID
if ( !function_exists( 'themerex_get_lessons_list' ) ) {
	function themerex_get_lessons_list($parent_id, $count=-1) {
		$list = array();
		$args = array(
			'post_type' => 'lesson',
			'post_status' => 'publish',
			'meta_key' => 'date_start',
			'orderby' => 'meta_value',		//'date'
			'order' => 'asc',
			'ignore_sticky_posts' => true,
			'posts_per_page' => $count,
			'meta_query' => array(
				array(
					'key'     => 'parent_course',
					'value'   => $parent_id,
					'compare' => '=',
					'type'    => 'NUMERIC'
				)
			)
		);
		global $post;
		$query = new WP_Query( $args );
		while ( $query->have_posts() ) { $query->the_post();
			$list[] = $post;
		}
		wp_reset_postdata();
		return $list;
	}
}

// Return lessons TOC by parent course post ID
if ( !function_exists( 'themerex_get_lessons_links' ) ) {
	function themerex_get_lessons_links($parent_id, $current_id=0, $opt = array()) {
		$opt = array_merge( array(
			'show_lessons' => true,
			'show_prev_next' => false,
			'header' => '',
			'description' => ''
			), $opt);
		$output = '';
		if ($parent_id > 0) {
			$courses_list = themerex_get_lessons_list($parent_id);
			$courses_toc = '';
			$prev_course = $next_course = null;
			if (count($courses_list) > 1) {
				$step = 0;
				foreach ($courses_list as $course) {
					if ($course->ID == $current_id)
						$step = 1;
					else if ($step==0)
						$prev_course = $course;
					else if ($step==1) {
						$next_course = $course;
						$step = 2;
						if (!$opt['show_lessons']) break;
					}
					if ($opt['show_lessons']) {
						$teacher_id = themerex_get_custom_option('teacher', '', $course->ID, $course->post_type);				//!!!!! Get option from specified post
						$teacher_post = get_post($teacher_id);
						$teacher_link = get_permalink($teacher_id);
						$teacher_position = '';
						$course_start = themerex_get_custom_option('date_start', '', $course->ID, $course->post_type);			//!!!!! Get option from specified post
						$courses_toc .= '<li class="sc_list_item course_lesson_item">'
							. '<span class="sc_list_icon icon-dot"></span>'
							. ($course->ID == $current_id ? '<span class="course_lesson_title">' : '<a href="'.esc_url(get_permalink($course->ID)).'" class="course_lesson_title">') 
								. strip_tags($course->post_title) 
							. ($course->ID == $current_id ? '</span>' : '</a>')
							. ' | <span class="course_lesson_date">' . esc_html(themerex_get_date_or_difference(!empty($course_start) ? $course_start : $course->post_date)) . '</span>'
							. ' <span class="course_lesson_by">' . esc_html(__('by', 'education')) . '</span>'
							. ' <a href="'.esc_url($teacher_link).'" class="course_lesson_teacher">' . trim($teacher_position) . ' ' . trim($teacher_post->post_title) . '</a>'
							. (!empty($course->post_excerpt) ? '<div class="course_lesson_excerpt">' . strip_tags($course->post_excerpt) . '</div>' : '')
							. '</li>';
					}
				}
				$output .= ($opt['show_lessons'] 
								? ('<div class="course_toc' . ($opt['show_prev_next'] ? ' course_toc_with_pagination' : '') . '">'
									. ($opt['header'] ? '<h2 class="course_toc_title">' . trim($opt['header']) . '</h2>' : '')
									. ($opt['description'] ? '<div class="course_toc_description">' . trim($opt['description']) . '</div>' : '')
									. '<ul class="sc_list sc_list_style_iconed">' . trim($courses_toc) . '</ul>'
									. '</div>')
								: '')
					. ($opt['show_prev_next']
								? ('<nav class="pagination_single pagination_lessons" role="navigation">'
									. ($prev_course != null 
										? '<a href="' . esc_url(get_permalink($prev_course->ID)) . '" class="pager_prev"><span class="pager_numbers">&laquo;&nbsp;' . strip_tags($prev_course->post_title) . '</span></a>'
										: '')
									. ($next_course != null
										? '<a href="' . esc_url(get_permalink($next_course->ID)) . '" class="pager_next"><span class="pager_numbers">' . strip_tags($next_course->post_title) . '&nbsp;&raquo;</span></a>'
										: '')
									. '</nav>')
								: '');
			}
		}
		return $output;
	}
}

?>