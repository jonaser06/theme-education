<?php
/**
 * ThemeREX Framework: return lists
 *
 * @package themerex
 * @since themerex 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


// Return list of the animations
if ( !function_exists( 'themerex_get_list_animations' ) ) {
	function themerex_get_list_animations($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_animations']))
			$list = $THEMEREX_GLOBALS['list_animations'];
		else {
			$list = array();
			$list['none']			= esc_html__('- None -',	'education');
			$list['bounced']		= esc_html__('Bounced',		'education');
			$list['flash']			= esc_html__('Flash',		'education');
			$list['flip']			= esc_html__('Flip',		'education');
			$list['pulse']			= esc_html__('Pulse',		'education');
			$list['rubberBand']		= esc_html__('Rubber Band',	'education');
			$list['shake']			= esc_html__('Shake',		'education');
			$list['swing']			= esc_html__('Swing',		'education');
			$list['tada']			= esc_html__('Tada',		'education');
			$list['wobble']			= esc_html__('Wobble',		'education');
			$THEMEREX_GLOBALS['list_animations'] = $list = apply_filters('themerex_filter_list_animations', $list);
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}


// Return list of the enter animations
if ( !function_exists( 'themerex_get_list_animations_in' ) ) {
	function themerex_get_list_animations_in($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_animations_in']))
			$list = $THEMEREX_GLOBALS['list_animations_in'];
		else {
			$list = array();
			$list['none']			= esc_html__('- None -',	'education');
			$list['bounceIn']		= esc_html__('Bounce In',			'education');
			$list['bounceInUp']		= esc_html__('Bounce In Up',		'education');
			$list['bounceInDown']	= esc_html__('Bounce In Down',		'education');
			$list['bounceInLeft']	= esc_html__('Bounce In Left',		'education');
			$list['bounceInRight']	= esc_html__('Bounce In Right',		'education');
			$list['fadeIn']			= esc_html__('Fade In',				'education');
			$list['fadeInUp']		= esc_html__('Fade In Up',			'education');
			$list['fadeInDown']		= esc_html__('Fade In Down',		'education');
			$list['fadeInLeft']		= esc_html__('Fade In Left',		'education');
			$list['fadeInRight']	= esc_html__('Fade In Right',		'education');
			$list['fadeInUpBig']	= esc_html__('Fade In Up Big',		'education');
			$list['fadeInDownBig']	= esc_html__('Fade In Down Big',	'education');
			$list['fadeInLeftBig']	= esc_html__('Fade In Left Big',	'education');
			$list['fadeInRightBig']	= esc_html__('Fade In Right Big',	'education');
			$list['flipInX']		= esc_html__('Flip In X',			'education');
			$list['flipInY']		= esc_html__('Flip In Y',			'education');
			$list['lightSpeedIn']	= esc_html__('Light Speed In',		'education');
			$list['rotateIn']		= esc_html__('Rotate In',			'education');
			$list['rotateInUpLeft']		= esc_html__('Rotate In Down Left',	'education');
			$list['rotateInUpRight']	= esc_html__('Rotate In Up Right',	'education');
			$list['rotateInDownLeft']	= esc_html__('Rotate In Up Left',	'education');
			$list['rotateInDownRight']	= esc_html__('Rotate In Down Right','education');
			$list['rollIn']				= esc_html__('Roll In',			'education');
			$list['slideInUp']			= esc_html__('Slide In Up',		'education');
			$list['slideInDown']		= esc_html__('Slide In Down',	'education');
			$list['slideInLeft']		= esc_html__('Slide In Left',	'education');
			$list['slideInRight']		= esc_html__('Slide In Right',	'education');
			$list['zoomIn']				= esc_html__('Zoom In',			'education');
			$list['zoomInUp']			= esc_html__('Zoom In Up',		'education');
			$list['zoomInDown']			= esc_html__('Zoom In Down',	'education');
			$list['zoomInLeft']			= esc_html__('Zoom In Left',	'education');
			$list['zoomInRight']		= esc_html__('Zoom In Right',	'education');
			$THEMEREX_GLOBALS['list_animations_in'] = $list = apply_filters('themerex_filter_list_animations_in', $list);
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}


// Return list of the out animations
if ( !function_exists( 'themerex_get_list_animations_out' ) ) {
	function themerex_get_list_animations_out($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_animations_out']))
			$list = $THEMEREX_GLOBALS['list_animations_out'];
		else {
			$list = array();
			$list['none']			= esc_html__('- None -',	'education');
			$list['bounceOut']		= esc_html__('Bounce Out',			'education');
			$list['bounceOutUp']	= esc_html__('Bounce Out Up',		'education');
			$list['bounceOutDown']	= esc_html__('Bounce Out Down',		'education');
			$list['bounceOutLeft']	= esc_html__('Bounce Out Left',		'education');
			$list['bounceOutRight']	= esc_html__('Bounce Out Right',	'education');
			$list['fadeOut']		= esc_html__('Fade Out',			'education');
			$list['fadeOutUp']		= esc_html__('Fade Out Up',			'education');
			$list['fadeOutDown']	= esc_html__('Fade Out Down',		'education');
			$list['fadeOutLeft']	= esc_html__('Fade Out Left',		'education');
			$list['fadeOutRight']	= esc_html__('Fade Out Right',		'education');
			$list['fadeOutUpBig']	= esc_html__('Fade Out Up Big',		'education');
			$list['fadeOutDownBig']	= esc_html__('Fade Out Down Big',	'education');
			$list['fadeOutLeftBig']	= esc_html__('Fade Out Left Big',	'education');
			$list['fadeOutRightBig']= esc_html__('Fade Out Right Big',	'education');
			$list['flipOutX']		= esc_html__('Flip Out X',			'education');
			$list['flipOutY']		= esc_html__('Flip Out Y',			'education');
			$list['hinge']			= esc_html__('Hinge Out',			'education');
			$list['lightSpeedOut']	= esc_html__('Light Speed Out',		'education');
			$list['rotateOut']		= esc_html__('Rotate Out',			'education');
			$list['rotateOutUpLeft']	= esc_html__('Rotate Out Down Left',	'education');
			$list['rotateOutUpRight']	= esc_html__('Rotate Out Up Right',		'education');
			$list['rotateOutDownLeft']	= esc_html__('Rotate Out Up Left',		'education');
			$list['rotateOutDownRight']	= esc_html__('Rotate Out Down Right',	'education');
			$list['rollOut']			= esc_html__('Roll Out',		'education');
			$list['slideOutUp']			= esc_html__('Slide Out Up',		'education');
			$list['slideOutDown']		= esc_html__('Slide Out Down',	'education');
			$list['slideOutLeft']		= esc_html__('Slide Out Left',	'education');
			$list['slideOutRight']		= esc_html__('Slide Out Right',	'education');
			$list['zoomOut']			= esc_html__('Zoom Out',			'education');
			$list['zoomOutUp']			= esc_html__('Zoom Out Up',		'education');
			$list['zoomOutDown']		= esc_html__('Zoom Out Down',	'education');
			$list['zoomOutLeft']		= esc_html__('Zoom Out Left',	'education');
			$list['zoomOutRight']		= esc_html__('Zoom Out Right',	'education');
			$THEMEREX_GLOBALS['list_animations_out'] = $list = apply_filters('themerex_filter_list_animations_out', $list);
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}


// Return list of categories
if ( !function_exists( 'themerex_get_list_categories' ) ) {
	function themerex_get_list_categories($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_categories']))
			$list = $THEMEREX_GLOBALS['list_categories'];
		else {
			$list = array();
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'category',
				'pad_counts'               => false );
			$taxonomies = get_categories( $args );
			foreach ($taxonomies as $cat) {
				$list[$cat->term_id] = $cat->name;
			}
			$THEMEREX_GLOBALS['list_categories'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}


// Return list of taxonomies
if ( !function_exists( 'themerex_get_list_terms' ) ) {
	function themerex_get_list_terms($prepend_inherit=false, $taxonomy='category') {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_taxonomies_'.($taxonomy)]))
			$list = $THEMEREX_GLOBALS['list_taxonomies_'.($taxonomy)];
		else {
			$list = array();
			$args = array(
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => $taxonomy,
				'pad_counts'               => false );
			$taxonomies = get_terms( $taxonomy, $args );
			foreach ($taxonomies as $cat) {
				$list[$cat->term_id] = $cat->name;	// . ($taxonomy!='category' ? ' /'.($cat->taxonomy).'/' : '');
			}
			$THEMEREX_GLOBALS['list_taxonomies_'.($taxonomy)] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return list of post's types
if ( !function_exists( 'themerex_get_list_posts_types' ) ) {
	function themerex_get_list_posts_types($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_posts_types']))
			$list = $THEMEREX_GLOBALS['list_posts_types'];
		else {
			$list = array();

			// Return only theme inheritance supported post types
			$THEMEREX_GLOBALS['list_posts_types'] = $list = apply_filters('themerex_filter_list_post_types', $list);
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}


// Return list post items from any post type and taxonomy
if ( !function_exists( 'themerex_get_list_posts' ) ) {
	function themerex_get_list_posts($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'taxonomy'			=> 'category',
			'taxonomy_value'	=> '',
			'posts_per_page'	=> -1,
			'orderby'			=> 'post_date',
			'order'				=> 'desc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));

		global $THEMEREX_GLOBALS;
		$hash = 'list_posts_'.($opt['post_type']).'_'.($opt['taxonomy']).'_'.($opt['taxonomy_value']).'_'.($opt['orderby']).'_'.($opt['order']).'_'.($opt['return']).'_'.($opt['posts_per_page']);
		if (isset($THEMEREX_GLOBALS[$hash]))
			$list = $THEMEREX_GLOBALS[$hash];
		else {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'education');
			$args = array(
				'post_type' => $opt['post_type'],
				'post_status' => $opt['post_status'],
				'posts_per_page' => $opt['posts_per_page'],
				'ignore_sticky_posts' => true,
				'orderby'	=> $opt['orderby'],
				'order'		=> $opt['order']
			);
			if (!empty($opt['taxonomy_value'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $opt['taxonomy'],
						'field' => (int) $opt['taxonomy_value'] > 0 ? 'id' : 'slug',
						'terms' => $opt['taxonomy_value']
					)
				);
			}
			$posts = get_posts( $args );
			foreach ($posts as $post) {
				$list[$opt['return']=='id' ? $post->ID : $post->post_title] = $post->post_title;
			}
			$THEMEREX_GLOBALS[$hash] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}


// Return list of registered users
if ( !function_exists( 'themerex_get_list_users' ) ) {
	function themerex_get_list_users($prepend_inherit=false, $roles=array('administrator', 'editor', 'author', 'contributor', 'shop_manager')) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_users']))
			$list = $THEMEREX_GLOBALS['list_users'];
		else {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'education');
			$args = array(
				'orderby'	=> 'display_name',
				'order'		=> 'ASC' );
			$users = get_users( $args );
			foreach ($users as $user) {
				$accept = true;
				if (is_array($user->roles)) {
					if (count($user->roles) > 0) {
						$accept = false;
						foreach ($user->roles as $role) {
							if (in_array($role, $roles)) {
								$accept = true;
								break;
							}
						}
					}
				}
				if ($accept) $list[$user->user_login] = $user->display_name;
			}
			$THEMEREX_GLOBALS['list_users'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}


// Return sliders list, prepended inherit and main sidebars item (if need)
if ( !function_exists( 'themerex_get_list_sliders' ) ) {
	function themerex_get_list_sliders($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_sliders']))
			$list = $THEMEREX_GLOBALS['list_sliders'];
		else {
			$list = array();
			$list["swiper"] = esc_html__("Posts slider (Swiper)", 'education');
			if (themerex_exists_revslider())
				$list["revo"] = esc_html__("Layer slider (Revolution)", 'education');
			if (themerex_exists_royalslider())
				$list["royal"] = esc_html__("Layer slider (Royal)", 'education');
			$THEMEREX_GLOBALS['list_sliders'] = $list = apply_filters('themerex_filter_list_sliders', $list);
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return list with popup engines
if ( !function_exists( 'themerex_get_list_popup_engines' ) ) {
	function themerex_get_list_popup_engines($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_popup_engines']))
			$list = $THEMEREX_GLOBALS['list_popup_engines'];
		else {
			$list = array();
			$list["pretty"] = esc_html__("Pretty photo", 'education');
			$list["magnific"] = esc_html__("Magnific popup", 'education');
			$THEMEREX_GLOBALS['list_popup_engines'] = $list = apply_filters('themerex_filter_list_popup_engines', $list);
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return menus list, prepended inherit
if ( !function_exists( 'themerex_get_list_menus' ) ) {
	function themerex_get_list_menus($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_menus']))
			$list = $THEMEREX_GLOBALS['list_menus'];
		else {
			$list = array();
			$list['default'] = esc_html__("Default", 'education');
			$menus = wp_get_nav_menus();
			if ($menus) {
				foreach ($menus as $menu) {
					$list[$menu->slug] = $menu->name;
				}
			}
			$THEMEREX_GLOBALS['list_menus'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return custom sidebars list, prepended inherit and main sidebars item (if need)
if ( !function_exists( 'themerex_get_list_sidebars' ) ) {
	function themerex_get_list_sidebars($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_sidebars'])) {
			$list = $THEMEREX_GLOBALS['list_sidebars'];
		} else {
			$list = isset($THEMEREX_GLOBALS['registered_sidebars']) ? $THEMEREX_GLOBALS['registered_sidebars'] : array();
			$THEMEREX_GLOBALS['list_sidebars'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return sidebars positions
if ( !function_exists( 'themerex_get_list_sidebars_positions' ) ) {
	function themerex_get_list_sidebars_positions($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_sidebars_positions']))
			$list = $THEMEREX_GLOBALS['list_sidebars_positions'];
		else {
			$list = array();
			$list['left']  = esc_html__('Left',  'education');
			$list['right'] = esc_html__('Right', 'education');
			$THEMEREX_GLOBALS['list_sidebars_positions'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return sidebars class
if ( !function_exists( 'themerex_get_sidebar_class' ) ) {
	function themerex_get_sidebar_class($style, $pos) {
		return themerex_sc_param_is_off($style) ? 'sidebar_hide' : 'sidebar_show sidebar_'.($pos);
	}
}

// Return body styles list, prepended inherit
if ( !function_exists( 'themerex_get_list_body_styles' ) ) {
	function themerex_get_list_body_styles($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_body_styles']))
			$list = $THEMEREX_GLOBALS['list_body_styles'];
		else {
			$list = array();
			$list['boxed']		= esc_html__('Boxed',		'education');
			$list['wide']		= esc_html__('Wide',		'education');
			$list['fullwide']	= esc_html__('Fullwide',	'education');
			$list['fullscreen']	= esc_html__('Fullscreen',	'education');
			$THEMEREX_GLOBALS['list_body_styles'] = $list = apply_filters('themerex_filter_list_body_styles', $list);
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return skins list, prepended inherit
if ( !function_exists( 'themerex_get_list_skins' ) ) {
	function themerex_get_list_skins($prepend_inherit=false) {
		$list = array(
			'education' => esc_html__('Education', 'education')
		);
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return templates list, prepended inherit
if ( !function_exists( 'themerex_get_list_templates' ) ) {
	function themerex_get_list_templates($mode='') {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_templates_'.($mode)]))
			$list = $THEMEREX_GLOBALS['list_templates_'.($mode)];
		else {
			$list = array();
			foreach ($THEMEREX_GLOBALS['registered_templates'] as $k=>$v) {
				if ($mode=='' || themerex_strpos($v['mode'], $mode)!==false)
					$list[$k] = !empty($v['title']) ? $v['title'] : themerex_strtoproper($v['layout']);
			}
			$THEMEREX_GLOBALS['list_templates_'.($mode)] = $list;
		}
		return $list;
	}
}

// Return blog styles list, prepended inherit
if ( !function_exists( 'themerex_get_list_templates_blog' ) ) {
	function themerex_get_list_templates_blog($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_templates_blog']))
			$list = $THEMEREX_GLOBALS['list_templates_blog'];
		else {
			$list = themerex_get_list_templates('blog');
			$THEMEREX_GLOBALS['list_templates_blog'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return blogger styles list, prepended inherit
if ( !function_exists( 'themerex_get_list_templates_blogger' ) ) {
	function themerex_get_list_templates_blogger($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_templates_blogger']))
			$list = $THEMEREX_GLOBALS['list_templates_blogger'];
		else {
			$list = themerex_array_merge(themerex_get_list_templates('blogger'), themerex_get_list_templates('blog'));
			$THEMEREX_GLOBALS['list_templates_blogger'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return single page styles list, prepended inherit
if ( !function_exists( 'themerex_get_list_templates_single' ) ) {
	function themerex_get_list_templates_single($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_templates_single']))
			$list = $THEMEREX_GLOBALS['list_templates_single'];
		else {
			$list = themerex_get_list_templates('single');
			$THEMEREX_GLOBALS['list_templates_single'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return article styles list, prepended inherit
if ( !function_exists( 'themerex_get_list_article_styles' ) ) {
	function themerex_get_list_article_styles($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_article_styles']))
			$list = $THEMEREX_GLOBALS['list_article_styles'];
		else {
			$list = array();
			$list["boxed"]   = esc_html__('Boxed', 'education');
			$list["stretch"] = esc_html__('Stretch', 'education');
			$THEMEREX_GLOBALS['list_article_styles'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return color schemes list, prepended inherit
if ( !function_exists( 'themerex_get_list_color_schemes' ) ) {
	function themerex_get_list_color_schemes($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_color_schemes']))
			$list = $THEMEREX_GLOBALS['list_color_schemes'];
		else {
			$list = array();
			if (!empty($THEMEREX_GLOBALS['color_schemes'])) {
				foreach ($THEMEREX_GLOBALS['color_schemes'] as $k=>$v) {
					$list[$k] = $v['title'];
				}
			}
			$THEMEREX_GLOBALS['list_color_schemes'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return button styles list, prepended inherit
if ( !function_exists( 'themerex_get_list_button_styles' ) ) {
	function themerex_get_list_button_styles($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_button_styles']))
			$list = $THEMEREX_GLOBALS['list_button_styles'];
		else {
			$list = array();
			$list["custom"]	= esc_html__('Custom', 'education');
			$list["link"] 	= esc_html__('As links', 'education');
			$list["menu"] 	= esc_html__('As main menu', 'education');
			$list["user"] 	= esc_html__('As user menu', 'education');
			$THEMEREX_GLOBALS['list_button_styles'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return post-formats filters list, prepended inherit
if ( !function_exists( 'themerex_get_list_post_formats_filters' ) ) {
	function themerex_get_list_post_formats_filters($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_post_formats_filters']))
			$list = $THEMEREX_GLOBALS['list_post_formats_filters'];
		else {
			$list = array();
			$list["no"]      = esc_html__('All posts', 'education');
			$list["thumbs"]  = esc_html__('With thumbs', 'education');
			$list["reviews"] = esc_html__('With reviews', 'education');
			$list["video"]   = esc_html__('With videos', 'education');
			$list["audio"]   = esc_html__('With audios', 'education');
			$list["gallery"] = esc_html__('With galleries', 'education');
			$THEMEREX_GLOBALS['list_post_formats_filters'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return scheme color
if (!function_exists('themerex_get_scheme_color')) {
	function themerex_get_scheme_color($clr) {
		global $THEMEREX_GLOBALS;
		$scheme = themerex_get_custom_option('color_scheme');
		if (empty($scheme) || empty($THEMEREX_GLOBALS['color_schemes'][$scheme])) $scheme = 'original';
		return isset($THEMEREX_GLOBALS['color_schemes'][$scheme][$clr]) ? $THEMEREX_GLOBALS['color_schemes'][$scheme][$clr] : '';
	}
}

// Return portfolio filters list, prepended inherit
if ( !function_exists( 'themerex_get_list_portfolio_filters' ) ) {
	function themerex_get_list_portfolio_filters($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_portfolio_filters']))
			$list = $THEMEREX_GLOBALS['list_portfolio_filters'];
		else {
			$list = array();
			$list["hide"] = esc_html__('Hide', 'education');
			$list["tags"] = esc_html__('Tags', 'education');
			$list["categories"] = esc_html__('Categories', 'education');
			$THEMEREX_GLOBALS['list_portfolio_filters'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return hover styles list, prepended inherit
if ( !function_exists( 'themerex_get_list_hovers' ) ) {
	function themerex_get_list_hovers($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_hovers']))
			$list = $THEMEREX_GLOBALS['list_hovers'];
		else {
			$list = array();
			$list['circle effect1']  = esc_html__('Circle Effect 1',  'education');
			$list['circle effect2']  = esc_html__('Circle Effect 2',  'education');
			$list['circle effect3']  = esc_html__('Circle Effect 3',  'education');
			$list['circle effect4']  = esc_html__('Circle Effect 4',  'education');
			$list['circle effect5']  = esc_html__('Circle Effect 5',  'education');
			$list['circle effect6']  = esc_html__('Circle Effect 6',  'education');
			$list['circle effect7']  = esc_html__('Circle Effect 7',  'education');
			$list['circle effect8']  = esc_html__('Circle Effect 8',  'education');
			$list['circle effect9']  = esc_html__('Circle Effect 9',  'education');
			$list['circle effect10'] = esc_html__('Circle Effect 10',  'education');
			$list['circle effect11'] = esc_html__('Circle Effect 11',  'education');
			$list['circle effect12'] = esc_html__('Circle Effect 12',  'education');
			$list['circle effect13'] = esc_html__('Circle Effect 13',  'education');
			$list['circle effect14'] = esc_html__('Circle Effect 14',  'education');
			$list['circle effect15'] = esc_html__('Circle Effect 15',  'education');
			$list['circle effect16'] = esc_html__('Circle Effect 16',  'education');
			$list['circle effect17'] = esc_html__('Circle Effect 17',  'education');
			$list['circle effect18'] = esc_html__('Circle Effect 18',  'education');
			$list['circle effect19'] = esc_html__('Circle Effect 19',  'education');
			$list['circle effect20'] = esc_html__('Circle Effect 20',  'education');
			$list['square effect1']  = esc_html__('Square Effect 1',  'education');
			$list['square effect2']  = esc_html__('Square Effect 2',  'education');
			$list['square effect3']  = esc_html__('Square Effect 3',  'education');
			$list['square effect5']  = esc_html__('Square Effect 5',  'education');
			$list['square effect6']  = esc_html__('Square Effect 6',  'education');
			$list['square effect7']  = esc_html__('Square Effect 7',  'education');
			$list['square effect8']  = esc_html__('Square Effect 8',  'education');
			$list['square effect9']  = esc_html__('Square Effect 9',  'education');
			$list['square effect10'] = esc_html__('Square Effect 10',  'education');
			$list['square effect11'] = esc_html__('Square Effect 11',  'education');
			$list['square effect12'] = esc_html__('Square Effect 12',  'education');
			$list['square effect13'] = esc_html__('Square Effect 13',  'education');
			$list['square effect14'] = esc_html__('Square Effect 14',  'education');
			$list['square effect15'] = esc_html__('Square Effect 15',  'education');
			$list['square effect_dir']   = esc_html__('Square Effect Dir',   'education');
			$list['square effect_shift'] = esc_html__('Square Effect Shift', 'education');
			$list['square effect_book']  = esc_html__('Square Effect Book',  'education');
			$THEMEREX_GLOBALS['list_hovers'] = $list = apply_filters('themerex_filter_portfolio_hovers', $list);
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return extended hover directions list, prepended inherit
if ( !function_exists( 'themerex_get_list_hovers_directions' ) ) {
	function themerex_get_list_hovers_directions($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_hovers_directions']))
			$list = $THEMEREX_GLOBALS['list_hovers_directions'];
		else {
			$list = array();
			$list['left_to_right'] = esc_html__('Left to Right',  'education');
			$list['right_to_left'] = esc_html__('Right to Left',  'education');
			$list['top_to_bottom'] = esc_html__('Top to Bottom',  'education');
			$list['bottom_to_top'] = esc_html__('Bottom to Top',  'education');
			$list['scale_up']      = esc_html__('Scale Up',  'education');
			$list['scale_down']    = esc_html__('Scale Down',  'education');
			$list['scale_down_up'] = esc_html__('Scale Down-Up',  'education');
			$list['from_left_and_right'] = esc_html__('From Left and Right',  'education');
			$list['from_top_and_bottom'] = esc_html__('From Top and Bottom',  'education');
			$THEMEREX_GLOBALS['list_hovers_directions'] = $list = apply_filters('themerex_filter_portfolio_hovers_directions', $list);
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}


// Return list of the label positions in the custom forms
if ( !function_exists( 'themerex_get_list_label_positions' ) ) {
	function themerex_get_list_label_positions($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_label_positions']))
			$list = $THEMEREX_GLOBALS['list_label_positions'];
		else {
			$list = array();
			$list['top']	= esc_html__('Top',		'education');
			$list['bottom']	= esc_html__('Bottom',		'education');
			$list['left']	= esc_html__('Left',		'education');
			$list['over']	= esc_html__('Over',		'education');
			$THEMEREX_GLOBALS['list_label_positions'] = $list = apply_filters('themerex_filter_label_positions', $list);
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return background tints list, prepended inherit
if ( !function_exists( 'themerex_get_list_bg_tints' ) ) {
	function themerex_get_list_bg_tints($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_bg_tints']))
			$list = $THEMEREX_GLOBALS['list_bg_tints'];
		else {
			$list = array();
			$list['none']  = esc_html__('None',  'education');
			$list['light'] = esc_html__('Light','education');
			$list['dark']  = esc_html__('Dark',  'education');
			$THEMEREX_GLOBALS['list_bg_tints'] = $list = apply_filters('themerex_filter_bg_tints', $list);
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return background tints list for sidebars, prepended inherit
if ( !function_exists( 'themerex_get_list_sidebar_styles' ) ) {
	function themerex_get_list_sidebar_styles($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_sidebar_styles']))
			$list = $THEMEREX_GLOBALS['list_sidebar_styles'];
		else {
			$list = array();
			$list['none']  = esc_html__('None',  'education');
			$list['light white'] = esc_html__('White','education');
			$list['light'] = esc_html__('Light','education');
			$list['dark']  = esc_html__('Dark',  'education');
			$THEMEREX_GLOBALS['list_sidebar_styles'] = $list = apply_filters('themerex_filter_sidebar_styles', $list);
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return custom fields types list, prepended inherit
if ( !function_exists( 'themerex_get_list_field_types' ) ) {
	function themerex_get_list_field_types($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_field_types']))
			$list = $THEMEREX_GLOBALS['list_field_types'];
		else {
			$list = array();
			$list['text']     = esc_html__('Text',  'education');
			$list['textarea'] = esc_html__('Text Area','education');
			$list['password'] = esc_html__('Password',  'education');
			$list['radio']    = esc_html__('Radio',  'education');
			$list['checkbox'] = esc_html__('Checkbox',  'education');
			$list['button']   = esc_html__('Button','education');
			$THEMEREX_GLOBALS['list_field_types'] = $list = apply_filters('themerex_filter_field_types', $list);
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return Google map styles
if ( !function_exists( 'themerex_get_list_googlemap_styles' ) ) {
	function themerex_get_list_googlemap_styles($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_googlemap_styles']))
			$list = $THEMEREX_GLOBALS['list_googlemap_styles'];
		else {
			$list = array();
			$list['default'] = esc_html__('Default', 'education');
			$list['simple'] = esc_html__('Simple', 'education');
			$list['greyscale'] = esc_html__('Greyscale', 'education');
			$list['greyscale2'] = esc_html__('Greyscale 2', 'education');
			$list['invert'] = esc_html__('Invert', 'education');
			$list['dark'] = esc_html__('Dark', 'education');
			$list['style1'] = esc_html__('Custom style 1', 'education');
			$list['style2'] = esc_html__('Custom style 2', 'education');
			$list['style3'] = esc_html__('Custom style 3', 'education');
			$THEMEREX_GLOBALS['list_googlemap_styles'] = $list = apply_filters('themerex_filter_googlemap_styles', $list);
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return iconed classes list
if ( !function_exists( 'themerex_get_list_icons' ) ) {
	function themerex_get_list_icons($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_icons']))
			$list = $THEMEREX_GLOBALS['list_icons'];
		else
			$THEMEREX_GLOBALS['list_icons'] = $list = themerex_parse_icons_classes(themerex_get_file_dir("css/fontello/css/fontello-codes.css"));
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return socials list
if ( !function_exists( 'themerex_get_list_socials' ) ) {
	function themerex_get_list_socials($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_socials']))
			$list = $THEMEREX_GLOBALS['list_socials'];
		else
			$THEMEREX_GLOBALS['list_socials'] = $list = themerex_get_list_files("images/socials", "png");
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return flags list
if ( !function_exists( 'themerex_get_list_flags' ) ) {
	function themerex_get_list_flags($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_flags']))
			$list = $THEMEREX_GLOBALS['list_flags'];
		else
			$THEMEREX_GLOBALS['list_flags'] = $list = themerex_get_list_files("images/flags", "png");
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return list with 'Yes' and 'No' items
if ( !function_exists( 'themerex_get_list_yesno' ) ) {
	function themerex_get_list_yesno($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_yesno']))
			$list = $THEMEREX_GLOBALS['list_yesno'];
		else {
			$list = array();
			$list["yes"] = esc_html__("Yes", 'education');
			$list["no"]  = esc_html__("No", 'education');
			$THEMEREX_GLOBALS['list_yesno'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return list with 'On' and 'Of' items
if ( !function_exists( 'themerex_get_list_onoff' ) ) {
	function themerex_get_list_onoff($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_onoff']))
			$list = $THEMEREX_GLOBALS['list_onoff'];
		else {
			$list = array();
			$list["on"] = esc_html__("On", 'education');
			$list["off"] = esc_html__("Off", 'education');
			$THEMEREX_GLOBALS['list_onoff'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return list with 'Show' and 'Hide' items
if ( !function_exists( 'themerex_get_list_showhide' ) ) {
	function themerex_get_list_showhide($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_showhide']))
			$list = $THEMEREX_GLOBALS['list_showhide'];
		else {
			$list = array();
			$list["show"] = esc_html__("Show", 'education');
			$list["hide"] = esc_html__("Hide", 'education');
			$THEMEREX_GLOBALS['list_showhide'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return list with 'Ascending' and 'Descending' items
if ( !function_exists( 'themerex_get_list_orderings' ) ) {
	function themerex_get_list_orderings($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_orderings']))
			$list = $THEMEREX_GLOBALS['list_orderings'];
		else {
			$list = array();
			$list["asc"] = esc_html__("Ascending", 'education');
			$list["desc"] = esc_html__("Descending", 'education');
			$THEMEREX_GLOBALS['list_orderings'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return list with 'Horizontal' and 'Vertical' items
if ( !function_exists( 'themerex_get_list_directions' ) ) {
	function themerex_get_list_directions($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_directions']))
			$list = $THEMEREX_GLOBALS['list_directions'];
		else {
			$list = array();
			$list["horizontal"] = esc_html__("Horizontal", 'education');
			$list["vertical"] = esc_html__("Vertical", 'education');
			$THEMEREX_GLOBALS['list_directions'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return list with float items
if ( !function_exists( 'themerex_get_list_floats' ) ) {
	function themerex_get_list_floats($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_floats']))
			$list = $THEMEREX_GLOBALS['list_floats'];
		else {
			$list = array();
			$list["none"] = esc_html__("None", 'education');
			$list["left"] = esc_html__("Float Left", 'education');
			$list["right"] = esc_html__("Float Right", 'education');
			$THEMEREX_GLOBALS['list_floats'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return list with alignment items
if ( !function_exists( 'themerex_get_list_alignments' ) ) {
	function themerex_get_list_alignments($justify=false, $prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_alignments']))
			$list = $THEMEREX_GLOBALS['list_alignments'];
		else {
			$list = array();
			$list["none"] = esc_html__("None", 'education');
			$list["left"] = esc_html__("Left", 'education');
			$list["center"] = esc_html__("Center", 'education');
			$list["right"] = esc_html__("Right", 'education');
			if ($justify) $list["justify"] = esc_html__("Justify", 'education');
			$THEMEREX_GLOBALS['list_alignments'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return sorting list items
if ( !function_exists( 'themerex_get_list_sortings' ) ) {
	function themerex_get_list_sortings($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_sortings']))
			$list = $THEMEREX_GLOBALS['list_sortings'];
		else {
			$list = array();
			$list["date"] = esc_html__("Date", 'education');
			$list["title"] = esc_html__("Alphabetically", 'education');
			$list["views"] = esc_html__("Popular (views count)", 'education');
			$list["comments"] = esc_html__("Most commented (comments count)", 'education');
			$list["author_rating"] = esc_html__("Author rating", 'education');
			$list["users_rating"] = esc_html__("Visitors (users) rating", 'education');
			$list["random"] = esc_html__("Random", 'education');
			$THEMEREX_GLOBALS['list_sortings'] = $list = apply_filters('themerex_filter_list_sortings', $list);
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return list with columns widths
if ( !function_exists( 'themerex_get_list_columns' ) ) {
	function themerex_get_list_columns($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_columns']))
			$list = $THEMEREX_GLOBALS['list_columns'];
		else {
			$list = array();
			$list["none"] = esc_html__("None", 'education');
			$list["1_1"] = esc_html__("100%", 'education');
			$list["1_2"] = esc_html__("1/2", 'education');
			$list["1_3"] = esc_html__("1/3", 'education');
			$list["2_3"] = esc_html__("2/3", 'education');
			$list["1_4"] = esc_html__("1/4", 'education');
			$list["3_4"] = esc_html__("3/4", 'education');
			$list["1_5"] = esc_html__("1/5", 'education');
			$list["2_5"] = esc_html__("2/5", 'education');
			$list["3_5"] = esc_html__("3/5", 'education');
			$list["4_5"] = esc_html__("4/5", 'education');
			$list["1_6"] = esc_html__("1/6", 'education');
			$list["5_6"] = esc_html__("5/6", 'education');
			$list["1_7"] = esc_html__("1/7", 'education');
			$list["2_7"] = esc_html__("2/7", 'education');
			$list["3_7"] = esc_html__("3/7", 'education');
			$list["4_7"] = esc_html__("4/7", 'education');
			$list["5_7"] = esc_html__("5/7", 'education');
			$list["6_7"] = esc_html__("6/7", 'education');
			$list["1_8"] = esc_html__("1/8", 'education');
			$list["3_8"] = esc_html__("3/8", 'education');
			$list["5_8"] = esc_html__("5/8", 'education');
			$list["7_8"] = esc_html__("7/8", 'education');
			$list["1_9"] = esc_html__("1/9", 'education');
			$list["2_9"] = esc_html__("2/9", 'education');
			$list["4_9"] = esc_html__("4/9", 'education');
			$list["5_9"] = esc_html__("5/9", 'education');
			$list["7_9"] = esc_html__("7/9", 'education');
			$list["8_9"] = esc_html__("8/9", 'education');
			$list["1_10"]= esc_html__("1/10", 'education');
			$list["3_10"]= esc_html__("3/10", 'education');
			$list["7_10"]= esc_html__("7/10", 'education');
			$list["9_10"]= esc_html__("9/10", 'education');
			$list["1_11"]= esc_html__("1/11", 'education');
			$list["2_11"]= esc_html__("2/11", 'education');
			$list["3_11"]= esc_html__("3/11", 'education');
			$list["4_11"]= esc_html__("4/11", 'education');
			$list["5_11"]= esc_html__("5/11", 'education');
			$list["6_11"]= esc_html__("6/11", 'education');
			$list["7_11"]= esc_html__("7/11", 'education');
			$list["8_11"]= esc_html__("8/11", 'education');
			$list["9_11"]= esc_html__("9/11", 'education');
			$list["10_11"]= esc_html__("10/11", 'education');
			$list["1_12"]= esc_html__("1/12", 'education');
			$list["5_12"]= esc_html__("5/12", 'education');
			$list["7_12"]= esc_html__("7/12", 'education');
			$list["10_12"]= esc_html__("10/12", 'education');
			$list["11_12"]= esc_html__("11/12", 'education');
			$THEMEREX_GLOBALS['list_columns'] = $list = apply_filters('themerex_filter_list_columns', $list);
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return list of locations for the dedicated content
if ( !function_exists( 'themerex_get_list_dedicated_locations' ) ) {
	function themerex_get_list_dedicated_locations($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_dedicated_locations']))
			$list = $THEMEREX_GLOBALS['list_dedicated_locations'];
		else {
			$list = array();
			$list["default"] = esc_html__('As in the post defined', 'education');
			$list["center"]  = esc_html__('Above the text of the post', 'education');
			$list["left"]    = esc_html__('To the left the text of the post', 'education');
			$list["right"]   = esc_html__('To the right the text of the post', 'education');
			$list["alter"]   = esc_html__('Alternates for each post', 'education');
			$THEMEREX_GLOBALS['list_dedicated_locations'] = $list = apply_filters('themerex_filter_list_dedicated_locations', $list);
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return post-format name
if ( !function_exists( 'themerex_get_post_format_name' ) ) {
	function themerex_get_post_format_name($format, $single=true) {
		$name = '';
		if ($format=='gallery')		$name = $single ? esc_html__('gallery', 'education') : esc_html__('galleries', 'education');
		else if ($format=='video')	$name = $single ? esc_html__('video', 'education') : esc_html__('videos', 'education');
		else if ($format=='audio')	$name = $single ? esc_html__('audio', 'education') : esc_html__('audios', 'education');
		else if ($format=='image')	$name = $single ? esc_html__('image', 'education') : esc_html__('images', 'education');
		else if ($format=='quote')	$name = $single ? esc_html__('quote', 'education') : esc_html__('quotes', 'education');
		else if ($format=='link')	$name = $single ? esc_html__('link', 'education') : esc_html__('links', 'education');
		else if ($format=='status')	$name = $single ? esc_html__('status', 'education') : esc_html__('statuses', 'education');
		else if ($format=='aside')	$name = $single ? esc_html__('aside', 'education') : esc_html__('asides', 'education');
		else if ($format=='chat')	$name = $single ? esc_html__('chat', 'education') : esc_html__('chats', 'education');
		else						$name = $single ? esc_html__('standard', 'education') : esc_html__('standards', 'education');
		return apply_filters('themerex_filter_list_post_format_name', $name, $format);
	}
}

// Return post-format icon name (from Fontello library)
if ( !function_exists( 'themerex_get_post_format_icon' ) ) {
	function themerex_get_post_format_icon($format) {
		$icon = 'icon-';
		if ($format=='gallery')		$icon .= 'picture-2';
		else if ($format=='video')	$icon .= 'video-2';
		else if ($format=='audio')	$icon .= 'musical-2';
		else if ($format=='image')	$icon .= 'picture-boxed-2';
		else if ($format=='quote')	$icon .= 'quote-2';
		else if ($format=='link')	$icon .= 'link-2';
		else if ($format=='status')	$icon .= 'agenda-2';
		else if ($format=='aside')	$icon .= 'chat-2';
		else if ($format=='chat')	$icon .= 'chat-all-2';
		else						$icon .= 'book-2';
		return apply_filters('themerex_filter_list_post_format_icon', $icon, $format);
	}
}

// Return fonts styles list, prepended inherit
if ( !function_exists( 'themerex_get_list_fonts_styles' ) ) {
	function themerex_get_list_fonts_styles($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_fonts_styles']))
			$list = $THEMEREX_GLOBALS['list_fonts_styles'];
		else {
			$list = array();
			$list['i'] = esc_html__('I','education');
			$list['u'] = esc_html__('U', 'education');
			$THEMEREX_GLOBALS['list_fonts_styles'] = $list;
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return Google fonts list
if ( !function_exists( 'themerex_get_list_fonts' ) ) {
	function themerex_get_list_fonts($prepend_inherit=false) {
		global $THEMEREX_GLOBALS;
		if (isset($THEMEREX_GLOBALS['list_fonts']))
			$list = $THEMEREX_GLOBALS['list_fonts'];
		else {
			$list = array();
			$list = themerex_array_merge($list, themerex_get_list_fonts_custom());
			$list['Advent Pro'] = array('family'=>'sans-serif');
			$list['Alegreya Sans'] = array('family'=>'sans-serif');
			$list['Arimo'] = array('family'=>'sans-serif');
			$list['Asap'] = array('family'=>'sans-serif');
			$list['Averia Sans Libre'] = array('family'=>'cursive');
			$list['Averia Serif Libre'] = array('family'=>'cursive');
			$list['Bree Serif'] = array('family'=>'serif',);
			$list['Cabin'] = array('family'=>'sans-serif');
			$list['Cabin Condensed'] = array('family'=>'sans-serif');
			$list['Caudex'] = array('family'=>'serif');
			$list['Comfortaa'] = array('family'=>'cursive');
			$list['Cousine'] = array('family'=>'sans-serif');
			$list['Crimson Text'] = array('family'=>'serif');
			$list['Cuprum'] = array('family'=>'sans-serif');
			$list['Dosis'] = array('family'=>'sans-serif');
			$list['Economica'] = array('family'=>'sans-serif');
			$list['Exo'] = array('family'=>'sans-serif');
			$list['Expletus Sans'] = array('family'=>'cursive');
			$list['Karla'] = array('family'=>'sans-serif');
			$list['Lato'] = array('family'=>'sans-serif');
			$list['Lekton'] = array('family'=>'sans-serif');
			$list['Lobster Two'] = array('family'=>'cursive');
			$list['Maven Pro'] = array('family'=>'sans-serif');
			$list['Merriweather'] = array('family'=>'serif');
			$list['Montserrat'] = array('family'=>'sans-serif');
			$list['Neuton'] = array('family'=>'serif');
			$list['Noticia Text'] = array('family'=>'serif');
			$list['Old Standard TT'] = array('family'=>'serif');
			$list['Open Sans'] = array('family'=>'sans-serif');
			$list['Orbitron'] = array('family'=>'sans-serif');
			$list['Oswald'] = array('family'=>'sans-serif');
			$list['Overlock'] = array('family'=>'cursive');
			$list['Oxygen'] = array('family'=>'sans-serif');
			$list['PT Serif'] = array('family'=>'serif');
			$list['Puritan'] = array('family'=>'sans-serif');
			$list['Raleway'] = array('family'=>'sans-serif');
			$list['Roboto'] = array('family'=>'sans-serif');
			$list['Roboto Slab'] = array('family'=>'sans-serif');
			$list['Roboto Condensed'] = array('family'=>'sans-serif');
			$list['Rosario'] = array('family'=>'sans-serif');
			$list['Share'] = array('family'=>'cursive');
			$list['Signika'] = array('family'=>'sans-serif');
			$list['Signika Negative'] = array('family'=>'sans-serif');
			$list['Source Sans Pro'] = array('family'=>'sans-serif');
			$list['Tinos'] = array('family'=>'serif');
			$list['Ubuntu'] = array('family'=>'sans-serif');
			$list['Vollkorn'] = array('family'=>'serif');
			$THEMEREX_GLOBALS['list_fonts'] = $list = apply_filters('themerex_filter_list_fonts', $list);
		}
		return $prepend_inherit ? themerex_array_merge(array('inherit' => esc_html__("Inherit", 'education')), $list) : $list;
	}
}

// Return Custom font-face list
if ( !function_exists( 'themerex_get_list_fonts_custom' ) ) {
	function themerex_get_list_fonts_custom($prepend_inherit=false) {
		static $list = false;
		if (is_array($list)) return $list;
		$fonts = themerex_get_global('required_custom_fonts');
		$list = array();
		if (is_array($fonts)) {
			foreach ($fonts as $font) {
				if (($url = themerex_get_file_url('css/font-face/'.trim($font).'/stylesheet.css'))!='') {
					$list[sprintf(esc_html__('%s (uploaded font)', 'education'), $font)] = array('css' => $url);
				}
			}
		}
		return $list;
	}
}
?>