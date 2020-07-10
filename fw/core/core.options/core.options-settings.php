<?php

/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'themerex_options_settings_theme_setup2' ) ) {
	add_action( 'themerex_action_after_init_theme', 'themerex_options_settings_theme_setup2', 1 );
	function themerex_options_settings_theme_setup2() {
		if (themerex_options_is_used()) {
			global $THEMEREX_GLOBALS;
			// Replace arrays with actual parameters
			$lists = array();
			foreach ($THEMEREX_GLOBALS['options'] as $k=>$v) {
				if (isset($v['options']) && is_array($v['options'])) {
					foreach ($v['options'] as $k1=>$v1) {
						if (themerex_substr($k1, 0, 10) == '$themerex_' || themerex_substr($v1, 0, 10) == '$themerex_') {
							$list_func = themerex_substr(themerex_substr($k1, 0, 10) == '$themerex_' ? $k1 : $v1, 1);
							unset($THEMEREX_GLOBALS['options'][$k]['options'][$k1]);
							if (isset($lists[$list_func]))
								$THEMEREX_GLOBALS['options'][$k]['options'] = themerex_array_merge($THEMEREX_GLOBALS['options'][$k]['options'], $lists[$list_func]);
							else {
								if (function_exists($list_func)) {
									$THEMEREX_GLOBALS['options'][$k]['options'] = $lists[$list_func] = themerex_array_merge($THEMEREX_GLOBALS['options'][$k]['options'], $list_func == 'themerex_get_list_menus' ? $list_func(true) : $list_func());
							   	} else
							   		echo sprintf(__('Wrong function name %s in the theme options array', 'education'), $list_func);
							}
						}
					}
				}
			}
		}
	}
}

// Reset old Theme Options on theme first run
if ( !function_exists( 'themerex_options_reset' ) ) {
	function themerex_options_reset($clear=true) {
		$theme_data = wp_get_theme();
		$slug = str_replace(' ', '_', trim(themerex_strtolower((string) $theme_data->get('Name'))));
		$option_name = 'themerex_'.strip_tags($slug).'_options_reset';
		if ( get_option($option_name, false) === false ) {
			if ($clear) {
				global $wpdb;
				$wpdb->query('delete from '.esc_sql($wpdb->options).' where option_name like "themerex_options%"');
			}
			add_option($option_name, 1, '', 'yes');
		}
	}
}

// Prepare default Theme Options
if ( !function_exists( 'themerex_options_settings_theme_setup' ) ) {
	add_action( 'themerex_action_before_init_theme', 'themerex_options_settings_theme_setup', 2 );	// Priority 1 for add themerex_filter handlers
	function themerex_options_settings_theme_setup() {
		global $THEMEREX_GLOBALS;
		
		// Remove 'false' to clear all saved Theme Options on next run.
		// Attention! Use this way only on new theme installation, not in updates!
		themerex_options_reset(false);
		
		// Prepare arrays 
		$THEMEREX_GLOBALS['options_params'] = array(
			'list_fonts'		=> array('$themerex_get_list_fonts' => ''),
			'list_fonts_styles'	=> array('$themerex_get_list_fonts_styles' => ''),
			'list_socials' 		=> array('$themerex_get_list_socials' => ''),
			'list_icons' 		=> array('$themerex_get_list_icons' => ''),
			'list_posts_types' 	=> array('$themerex_get_list_posts_types' => ''),
			'list_categories' 	=> array('$themerex_get_list_categories' => ''),
			'list_menus'		=> array('$themerex_get_list_menus' => ''),
			'list_sidebars'		=> array('$themerex_get_list_sidebars' => ''),
			'list_positions' 	=> array('$themerex_get_list_sidebars_positions' => ''),
			'list_tints'	 	=> array('$themerex_get_list_bg_tints' => ''),
			'list_sidebar_styles' => array('$themerex_get_list_sidebar_styles' => ''),
			'list_skins'		=> array('$themerex_get_list_skins' => ''),
			'list_color_schemes'=> array('$themerex_get_list_color_schemes' => ''),
			'list_body_styles'	=> array('$themerex_get_list_body_styles' => ''),
			'list_blog_styles'	=> array('$themerex_get_list_templates_blog' => ''),
			'list_single_styles'=> array('$themerex_get_list_templates_single' => ''),
			'list_article_styles'=> array('$themerex_get_list_article_styles' => ''),
			'list_animations_in' => array('$themerex_get_list_animations_in' => ''),
			'list_animations_out'=> array('$themerex_get_list_animations_out' => ''),
			'list_filters'		=> array('$themerex_get_list_portfolio_filters' => ''),
			'list_hovers'		=> array('$themerex_get_list_hovers' => ''),
			'list_hovers_dir'	=> array('$themerex_get_list_hovers_directions' => ''),
			'list_sliders' 		=> array('$themerex_get_list_sliders' => ''),
			'list_popups' 		=> array('$themerex_get_list_popup_engines' => ''),
			'list_gmap_styles' 	=> array('$themerex_get_list_googlemap_styles' => ''),
			'list_yes_no' 		=> array('$themerex_get_list_yesno' => ''),
			'list_on_off' 		=> array('$themerex_get_list_onoff' => ''),
			'list_show_hide' 	=> array('$themerex_get_list_showhide' => ''),
			'list_sorting' 		=> array('$themerex_get_list_sortings' => ''),
			'list_ordering' 	=> array('$themerex_get_list_orderings' => ''),
			'list_locations' 	=> array('$themerex_get_list_dedicated_locations' => '')
			);


		// Theme options array
		$THEMEREX_GLOBALS['options'] = array(

		
		//###############################
		//#### Customization         #### 
		//###############################
		'partition_customization' => array(
					"title" => esc_html__('Customization', 'education'),
					"start" => "partitions",
					"override" => "category,courses_group,page,post",
					"icon" => "iconadmin-cog-alt",
					"type" => "partition"
					),
		
		
		// Customization -> General
		//-------------------------------------------------
		
		'customization_general' => array(
					"title" => esc_html__('General', 'education'),
					"override" => "category,courses_group,page,post",
					"icon" => 'iconadmin-cog',
					"start" => "customization_tabs",
					"type" => "tab"
					),
		
		'info_custom_1' => array(
					"title" => esc_html__('Theme customization general parameters', 'education'),
					"desc" => esc_html__('Select main theme skin, customize colors and enable responsive layouts for the small screens', 'education'),
					"override" => "category,courses_group,page,post",
					"type" => "info"
					),
		
		'theme_skin' => array(
					"title" => esc_html__('Select theme skin', 'education'),
					"desc" => esc_html__('Select skin for the theme decoration', 'education'),
					"divider" => false,
					"override" => "category,courses_group,post,page",
					"std" => "education",
					"options" => $THEMEREX_GLOBALS['options_params']['list_skins'],
					"type" => "select"
					),
		
		"icon" => array(
					"title" => esc_html__('Select icon', 'education'),
					"desc" => esc_html__('Select icon for output before post/category name in some layouts', 'education'),
					"override" => "category,courses_group,post",
					"std" => "",
					"options" => $THEMEREX_GLOBALS['options_params']['list_icons'],
					"style" => "select",
					"type" => "icons"
					),

		"post_color" => array(
					"title" => esc_html__('Posts color', 'education'),
					"desc" => esc_html__('Posts color - used as accent color to display posts in some layouts. If empty - used link, menu and usermenu colors - see below', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"),

		"color_scheme" => array(
					"title" => esc_html__('Color scheme', 'education'),
					"desc" => esc_html__('Select predefined color scheme. Or set separate colors in fields below', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "original",
					"dir" => "horizontal",
					"options" => $THEMEREX_GLOBALS['options_params']['list_color_schemes'],
					"type" => "checklist"),

		"link_color" => array(
					"title" => esc_html__('Links color', 'education'),
					"desc" => esc_html__('Links color. Also used as background color for the page header area and some other elements', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"),

		"link_dark" => array(
					"title" => esc_html__('Links dark color', 'education'),
					"desc" => esc_html__('Used as background color for the buttons, hover states and some other elements', 'education'),
					"divider" => false,
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"),

		"menu_color" => array(
					"title" => esc_html__('Main menu color', 'education'),
					"desc" => esc_html__('Used as background color for the active menu item, calendar item, tabs and some other elements', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"),

		"menu_dark" => array(
					"title" => esc_html__('Main menu dark color', 'education'),
					"desc" => esc_html__('Used as text color for the menu items (in the Light style), as background color for the selected menu item, etc.', 'education'),
					"divider" => false,
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"),

		"menu_hover" => array(
					"title" => esc_html__('Sub menu hover', 'education'),
					"desc" => esc_html__('Sub Main menu hover background color.', 'education'),
					"divider" => false,
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"),

		"user_color" => array(
					"title" => esc_html__('User menu color', 'education'),
					"desc" => esc_html__('Used as background color for the user menu items and some other elements', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"),

		"user_dark" => array(
					"title" => esc_html__('User menu dark color', 'education'),
					"desc" => esc_html__('Used as background color for the selected user menu item, etc.', 'education'),
					"divider" => false,
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"),


		'show_theme_customizer' => array(
					"title" => esc_html__('Show Theme customizer', 'education'),
					"desc" => esc_html__('Do you want to show theme customizer in the right panel? Your website visitors will be able to customise it yourself.', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),

		"customizer_demo" => array(
					"title" => esc_html__('Theme customizer panel demo time', 'education'),
					"desc" => esc_html__('Timer for demo mode for the customizer panel (in milliseconds: 1000ms = 1s). If 0 - no demo.', 'education'),
					"divider" => false,
					"std" => "0",
					"min" => 0,
					"max" => 10000,
					"step" => 500,
					"type" => "spinner"),
		
		'css_animation' => array(
					"title" => esc_html__('Extended CSS animations', 'education'),
					"desc" => esc_html__('Do you want use extended animations effects on your site?', 'education'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),

		'remember_visitors_settings' => array(
					"title" => esc_html__('Remember visitor\'s settings', 'education'),
					"desc" => esc_html__('To remember the settings that were made by the visitor, when navigating to other pages or to limit their effect only within the current page', 'education'),
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),
					
		'responsive_layouts' => array(
					"title" => esc_html__('Responsive Layouts', 'education'),
					"desc" => esc_html__('Do you want use responsive layouts on small screen or still use main layout?', 'education'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),

            'privacy_text' => array(
                "title" => esc_html__("Text with Privacy Policy link", 'education'),
                "desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'education') ),
                "std"   => wp_kses_post( __( 'I agree that my submitted data is being collected and stored.', 'education') ),
                "type"  => "text"
            ),
		
		'info_custom_2' => array(
					"title" => esc_html__('Additional CSS and HTML/JS code', 'education'),
					"desc" => esc_html__('Put here your custom CSS and JS code', 'education'),
					"override" => "category,courses_group,page,post",
					"type" => "info"
					),
		
		'custom_css' => array(
					"title" => esc_html__('Your CSS code',  'education'),
					"desc" => esc_html__('Put here your css code to correct main theme styles',  'education'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"type" => "textarea"
					),
		
		'custom_code' => array(
					"title" => esc_html__('Your HTML/JS code',  'education'),
					"desc" => esc_html__('Put here your invisible html/js code: Google analitics, counters, etc',  'education'),
					"override" => "category,courses_group,post,page",
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"type" => "textarea"
					),
		
		
		// Customization -> Body Style
		//-------------------------------------------------
		
		'customization_body' => array(
					"title" => esc_html__('Body style', 'education'),
					"override" => "category,courses_group,post,page",
					"icon" => 'iconadmin-picture-1',
					"type" => "tab"
					),
		
		'info_custom_3' => array(
					"title" => esc_html__('Body parameters', 'education'),
					"desc" => esc_html__('Background color, pattern and image used only for fixed body style.', 'education'),
					"override" => "category,courses_group,post,page",
					"type" => "info"
					),
					
		'body_style' => array(
					"title" => esc_html__('Body style', 'education'),
					"desc" => wp_kses_data( __('Select body style:<br><b>boxed</b> - if you want use background color and/or image,<br><b>wide</b> - page fill whole window with centered content,<br><b>fullwide</b> - page content stretched on the full width of the window (with few left and right paddings),<br><b>fullscreen</b> - page content fill whole window without any paddings', 'education')),
					"divider" => false,
					"override" => "category,courses_group,post,page",
					"std" => "wide",
					"options" => $THEMEREX_GLOBALS['options_params']['list_body_styles'],
					"dir" => "horizontal",
					"type" => "radio"
					),
		
		'body_filled' => array(
					"title" => esc_html__('Fill body', 'education'),
					"desc" => esc_html__('Fill the body background with the solid color (white or grey) or leave it transparend to show background image (or video)', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),
		
		'load_bg_image' => array(
					"title" => esc_html__('Load background image', 'education'),
					"desc" => esc_html__('Always load background images or only for boxed body style', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "boxed",
					"size" => "medium",
					"options" => array(
						'boxed' => esc_html__('Boxed', 'education'),
						'always' => esc_html__('Always', 'education')
					),
					"type" => "switch"
					),
		
		'bg_color' => array(
					"title" => esc_html__('Background color',  'education'),
					"desc" => esc_html__('Body background color',  'education'),
					"override" => "category,courses_group,post,page",
					"std" => "#bfbfbf",
					"type" => "color"
					),
		
		'bg_pattern' => array(
					"title" => esc_html__('Background predefined pattern',  'education'),
					"desc" => esc_html__('Select theme background pattern (first case - without pattern)',  'education'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"options" => array(
						0 => themerex_get_file_url('/images/spacer.png'),
						1 => themerex_get_file_url('/images/bg/pattern_1.png'),
						2 => themerex_get_file_url('/images/bg/pattern_2.png'),
						3 => themerex_get_file_url('/images/bg/pattern_3.png'),
						4 => themerex_get_file_url('/images/bg/pattern_4.png'),
						5 => themerex_get_file_url('/images/bg/pattern_5.png'),
						6 => themerex_get_file_url('/images/bg/pattern_6.png'),
						7 => themerex_get_file_url('/images/bg/pattern_7.png'),
						8 => themerex_get_file_url('/images/bg/pattern_8.png'),
						9 => themerex_get_file_url('/images/bg/pattern_9.png')
					),
					"style" => "list",
					"type" => "images"
					),
		
		'bg_custom_pattern' => array(
					"title" => esc_html__('Background custom pattern',  'education'),
					"desc" => esc_html__('Select or upload background custom pattern. If selected - use it instead the theme predefined pattern (selected in the field above)',  'education'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "media"
					),
		
		'bg_image' => array(
					"title" => esc_html__('Background predefined image',  'education'),
					"desc" => esc_html__('Select theme background image (first case - without image)',  'education'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"options" => array(
						0 => themerex_get_file_url('/images/spacer.png'),
						1 => themerex_get_file_url('/images/bg/image_1_thumb.jpg'),
						2 => themerex_get_file_url('/images/bg/image_2_thumb.jpg'),
						3 => themerex_get_file_url('/images/bg/image_3_thumb.jpg'),
						4 => themerex_get_file_url('/images/bg/image_4_thumb.jpg'),
						5 => themerex_get_file_url('/images/bg/image_5_thumb.jpg'),
						6 => themerex_get_file_url('/images/bg/image_6_thumb.jpg')
					),
					"style" => "list",
					"type" => "images"
					),
		
		'bg_custom_image' => array(
					"title" => esc_html__('Background custom image',  'education'),
					"desc" => esc_html__('Select or upload background custom image. If selected - use it instead the theme predefined image (selected in the field above)',  'education'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "media"
					),
		
		'bg_custom_image_position' => array( 
					"title" => esc_html__('Background custom image position',  'education'),
					"desc" => esc_html__('Select custom image position',  'education'),
					"override" => "category,courses_group,post,page",
					"std" => "left_top",
					"options" => array(
						'left_top' => "Left Top",
						'center_top' => "Center Top",
						'right_top' => "Right Top",
						'left_center' => "Left Center",
						'center_center' => "Center Center",
						'right_center' => "Right Center",
						'left_bottom' => "Left Bottom",
						'center_bottom' => "Center Bottom",
						'right_bottom' => "Right Bottom",
					),
					"type" => "select"
					),
		
		'show_video_bg' => array(
					"title" => esc_html__('Show video background',  'education'),
					"desc" => esc_html__("Show video on the site background (only for Fullscreen body style)", 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),
		
		'video_bg_youtube_code' => array(
					"title" => esc_html__('Youtube code for video bg',  'education'),
					"desc" => esc_html__("Youtube code of video", 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "text"
					),
		
		'video_bg_url' => array(
					"title" => esc_html__('Local video for video bg',  'education'),
					"desc" => esc_html__("URL to video-file (uploaded on your site)", 'education'),
					"readonly" =>false,
					"override" => "category,courses_group,post,page",
					"before" => array(	'title' => esc_html__('Choose video', 'education'),
										'action' => 'media_upload',
										'multiple' => false,
										'linked_field' => '',
										'type' => 'video',
										'captions' => array('choose' => esc_html__( 'Choose Video', 'education'),
															'update' => esc_html__( 'Select Video', 'education')
														)
								),
					"std" => "",
					"type" => "media"
					),
		
		'video_bg_overlay' => array(
					"title" => esc_html__('Use overlay for video bg', 'education'),
					"desc" => esc_html__('Use overlay texture for the video background', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),
		
		
		
		// Customization -> Logo
		//-------------------------------------------------
		
		'customization_logo' => array(
					"title" => esc_html__('Logo', 'education'),
					"override" => "category,courses_group,post,page",
					"icon" => 'iconadmin-heart-1',
					"type" => "tab"
					),
		
		'info_custom_4' => array(
					"title" => esc_html__('Main logo', 'education'),
					"desc" => esc_html__("Select or upload logos for the site's header and select it position", 'education'),
					"override" => "category,courses_group,post,page",
					"type" => "info"
					),

		'logo_dark' => array(
					"title" => esc_html__('Logo image (dark header)', 'education'),
					"desc" => esc_html__('Main logo image for the dark header', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "media"
					),

		'logo_light' => array(
					"title" => esc_html__('Logo image (light header)', 'education'),
					"desc" => esc_html__('Main logo image for the light header', 'education'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => "",
					"type" => "media"
					),

		'logo_fixed' => array(
					"title" => esc_html__('Logo image (fixed header)', 'education'),
					"desc" => esc_html__('Logo image for the header (if menu is fixed after the page is scrolled)', 'education'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => "",
					"type" => "media"
					),
		
		'logo_from_skin' => array(
					"title" => esc_html__('Logo from skin',  'education'),
					"desc" => esc_html__("Use logo images from current skin folder if not filled out fields above", 'education'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),

		'logo_text' => array(
					"title" => esc_html__('Logo text', 'education'),
					"desc" => esc_html__('Logo text - display it after logo image', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => '',
					"type" => "text"
					),

		'logo_slogan' => array(
					"title" => esc_html__('Logo slogan', 'education'),
					"desc" => esc_html__('Logo slogan - display it under logo image (instead the site slogan)', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => '',
					"type" => "text"
					),

		'logo_height' => array(
					"title" => esc_html__('Logo height', 'education'),
					"desc" => esc_html__('Height for the logo in the header area', 'education'),
					"override" => "category,courses_group,post,page",
					"step" => 1,
					"std" => '',
					"min" => 10,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"
					),

		'logo_offset' => array(
					"title" => esc_html__('Logo top offset', 'education'),
					"desc" => esc_html__('Top offset for the logo in the header area', 'education'),
					"override" => "category,courses_group,post,page",
					"step" => 1,
					"std" => '',
					"min" => 0,
					"max" => 99,
					"mask" => "?99",
					"type" => "spinner"
					),

		'logo_align' => array(
					"title" => esc_html__('Logo alignment', 'education'),
					"desc" => esc_html__('Logo alignment (only if logo above menu)', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "left",
					"options" =>  array("left"=>__("Left", 'education'), "center"=>__("Center", 'education'), "right"=>__("Right", 'education')),
					"dir" => "horizontal",
					"type" => "checklist"
					),

		'iinfo_custom_5' => array(
					"title" => esc_html__('Logo for footer', 'education'),
					"desc" => esc_html__('Select or upload logos for the site\'s footer and set it height', 'education'),
					"override" => "category,courses_group,post,page",
					"type" => "info"
					),

		'logo_footer' => array(
					"title" => esc_html__('Logo image for footer', 'education'),
					"desc" => esc_html__('Logo image for the footer', 'education'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => "",
					"type" => "media"
					),
		
		'logo_footer_height' => array(
					"title" => esc_html__('Logo height', 'education'),
					"desc" => esc_html__('Height for the logo in the footer area (in contacts)', 'education'),
					"override" => "category,courses_group,post,page",
					"step" => 1,
					"std" => 30,
					"min" => 10,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"
					),
		
		
		
		// Customization -> Menus
		//-------------------------------------------------
		
		"customization_menus" => array(
					"title" => esc_html__('Menus', 'education'),
					"override" => "category,courses_group,post,page",
					"icon" => 'iconadmin-menu',
					"type" => "tab"),
		
		"info_custom_6" => array(
					"title" => esc_html__('Top panel', 'education'),
					"desc" => esc_html__('Top panel settings. It include user menu area (with contact info, cart button, language selector, login/logout menu and user menu) and main menu area (with logo and main menu).', 'education'),
					"override" => "category,courses_group,post,page",
					"type" => "info"),
		
		"top_panel_position" => array( 
					"title" => esc_html__('Top panel position', 'education'),
					"desc" => esc_html__('Select position for the top panel with logo and main menu', 'education'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => "above",
					"options" => array(
						'hide'  => esc_html__('Hide', 'education'),
						'above' => esc_html__('Above slider', 'education'),
						'below' => esc_html__('Below slider', 'education'),
						'over'  => esc_html__('Over slider', 'education')
					),
					"type" => "checklist"),
		
		"top_panel_style" => array( 
					"title" => esc_html__('Top panel style', 'education'),
					"desc" => esc_html__('Select background style for the top panel with logo and main menu', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "dark",
					"options" => array(
						'dark' => esc_html__('Dark', 'education'),
						'light' => esc_html__('Light', 'education')
					),
					"type" => "checklist"),
		
		"top_panel_opacity" => array( 
					"title" => esc_html__('Top panel opacity', 'education'),
					"desc" => esc_html__('Select background opacity for the top panel with logo and main menu', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "solid",
					"options" => array(
						'solid' => esc_html__('Solid', 'education'),
						'transparent' => esc_html__('Transparent', 'education')
					),
					"type" => "checklist"),
		
		'top_panel_bg_color' => array(
					"title" => esc_html__('Top panel bg color',  'education'),
					"desc" => esc_html__('Background color for the top panel',  'education'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"
					),
		
		"top_panel_bg_image" => array( 
					"title" => esc_html__('Top panel bg image', 'education'),
					"desc" => esc_html__('Upload top panel background image', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "media"),
		
		
		"info_custom_7" => array( 
					"title" => esc_html__('Main menu style and position', 'education'),
					"desc" => esc_html__('Select the Main menu style and position', 'education'),
					"override" => "category,courses_group,post,page",
					"type" => "info"),
		
		"menu_main" => array( 
					"title" => esc_html__('Select main menu',  'education'),
					"desc" => esc_html__('Select main menu for the current page',  'education'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => "default",
					"options" => $THEMEREX_GLOBALS['options_params']['list_menus'],
					"type" => "select"),
		
		"menu_position" => array( 
					"title" => esc_html__('Main menu position', 'education'),
					"desc" => esc_html__('Attach main menu to top of window then page scroll down', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "fixed",
					"options" => array("fixed"=>__("Fix menu position", 'education'), "none"=>__("Don't fix menu position", 'education')),
					"dir" => "vertical",
					"type" => "radio"),
		
		"menu_align" => array( 
					"title" => esc_html__('Main menu alignment', 'education'),
					"desc" => esc_html__('Main menu alignment', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "right",
					"options" => array(
						"left"   => esc_html__("Left (under logo)", 'education'),
						"center" => esc_html__("Center (under logo)", 'education'),
						"right"	 => esc_html__("Right (at same line with logo)", 'education')
					),
					"dir" => "vertical",
					"type" => "radio"),

		"menu_slider" => array( 
					"title" => esc_html__('Main menu slider', 'education'),
					"desc" => esc_html__('Use slider background for main menu items', 'education'),
					"std" => "yes",
					"type" => "switch",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no']),

		"menu_animation_in" => array( 
					"title" => esc_html__('Submenu show animation', 'education'),
					"desc" => esc_html__('Select animation to show submenu ', 'education'),
					"std" => "bounceIn",
					"type" => "select",
					"options" => $THEMEREX_GLOBALS['options_params']['list_animations_in']),

		"menu_animation_out" => array( 
					"title" => esc_html__('Submenu hide animation', 'education'),
					"desc" => esc_html__('Select animation to hide submenu ', 'education'),
					"std" => "fadeOutDown",
					"type" => "select",
					"options" => $THEMEREX_GLOBALS['options_params']['list_animations_out']),
		
		"menu_relayout" => array( 
					"title" => esc_html__('Main menu relayout', 'education'),
					"desc" => esc_html__('Allow relayout main menu if window width less then this value', 'education'),
					"std" => 960,
					"min" => 320,
					"max" => 1024,
					"type" => "spinner"),
		
		"menu_responsive" => array( 
					"title" => esc_html__('Main menu responsive', 'education'),
					"desc" => esc_html__('Allow responsive version for the main menu if window width less then this value', 'education'),
					"std" => 640,
					"min" => 320,
					"max" => 1024,
					"type" => "spinner"),
		
		"menu_width" => array( 
					"title" => esc_html__('Submenu width', 'education'),
					"desc" => esc_html__('Width for dropdown menus in main menu', 'education'),
					"override" => "category,courses_group,post,page",
					"step" => 5,
					"std" => "",
					"min" => 180,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"),
		
		
		
		"info_custom_8" => array(
					"title" => esc_html__("User's menu area components", 'education'),
					"desc" => esc_html__("Select parts for the user's menu area", 'education'),
					"override" => "category,courses_group,page,post",
					"type" => "info"),
		
		"show_menu_user" => array(
					"title" => esc_html__('Show user menu area', 'education'),
					"desc" => esc_html__('Show user menu area on top of page', 'education'),
					"divider" => false,
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"menu_user" => array(
					"title" => esc_html__('Select user menu',  'education'),
					"desc" => esc_html__('Select user menu for the current page',  'education'),
					"override" => "category,courses_group,post,page",
					"std" => "default",
					"options" => $THEMEREX_GLOBALS['options_params']['list_menus'],
					"type" => "select"),
		
		"show_contact_info" => array(
					"title" => esc_html__('Show contact info', 'education'),
					"desc" => esc_html__("Show the contact details for the owner of the site at the top left corner of the page", 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_currency" => array(
					"title" => esc_html__('Show currency selector', 'education'),
					"desc" => esc_html__('Show currency selector in the user menu', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_cart" => array(
					"title" => esc_html__('Show cart button', 'education'),
					"desc" => esc_html__('Show cart button in the user menu', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "shop",
					"options" => array(
						'hide'   => esc_html__('Hide', 'education'),
						'always' => esc_html__('Always', 'education'),
						'shop'   => esc_html__('Only on shop pages', 'education')
					),
					"type" => "checklist"),
		
		"show_languages" => array(
					"title" => esc_html__('Show language selector', 'education'),
					"desc" => esc_html__('Show language selector in the user menu (if WPML plugin installed and current page/post has multilanguage version)', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_login" => array( 
					"title" => esc_html__('Show Login/Logout buttons', 'education'),
					"desc" => esc_html__('Show Login and Logout buttons in the user menu area', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_bookmarks" => array(
					"title" => esc_html__('Show bookmarks', 'education'),
					"desc" => esc_html__('Show bookmarks selector in the user menu', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		

		
		"info_custom_9" => array( 
					"title" => esc_html__("Table of Contents (TOC)", 'education'),
					"desc" => esc_html__("Table of Contents for the current page. Automatically created if the page contains objects with id starting with 'toc_'", 'education'),
					"override" => "category,courses_group,page,post",
					"type" => "info"),
		
		"menu_toc" => array( 
					"title" => esc_html__('TOC position', 'education'),
					"desc" => esc_html__('Show TOC for the current page', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "float",
					"options" => array(
						'hide'  => esc_html__('Hide', 'education'),
						'fixed' => esc_html__('Fixed', 'education'),
						'float' => esc_html__('Float', 'education')
					),
					"type" => "checklist"),
		
		"menu_toc_home" => array(
					"title" => esc_html__('Add "Home" into TOC', 'education'),
					"desc" => esc_html__('Automatically add "Home" item into table of contents - return to home page of the site', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"menu_toc_top" => array( 
					"title" => esc_html__('Add "To Top" into TOC', 'education'),
					"desc" => esc_html__('Automatically add "To Top" item into table of contents - scroll to top of the page', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		
		
		
		
		// Customization -> Sidebars
		//-------------------------------------------------
		
		"customization_sidebars" => array( 
					"title" => esc_html__('Sidebars', 'education'),
					"icon" => "iconadmin-indent-right",
					"override" => "category,courses_group,post,page",
					"type" => "tab"),
		
		"info_custom_10" => array( 
					"title" => esc_html__('Custom sidebars', 'education'),
					"desc" => esc_html__('In this section you can create unlimited sidebars. You can fill them with widgets in the menu Appearance - Widgets', 'education'),
					"type" => "info"),
		
		"custom_sidebars" => array(
					"title" => esc_html__('Custom sidebars',  'education'),
					"desc" => esc_html__('Manage custom sidebars. You can use it with each category (page, post) independently',  'education'),
					"divider" => false,
					"std" => "",
					"cloneable" => true,
					"type" => "text"),
		
		"info_custom_11" => array(
					"title" => esc_html__('Sidebars settings', 'education'),
					"desc" => esc_html__('Show / Hide and Select sidebar in each location', 'education'),
					"override" => "category,courses_group,post,page",
					"type" => "info"),
		
		'show_sidebar_main' => array( 
					"title" => esc_html__('Show main sidebar',  'education'),
					"desc" => esc_html__('Select style for the main sidebar or hide it',  'education'),
					"override" => "category,courses_group,post,page",
					"std" => "light",
					"options" => $THEMEREX_GLOBALS['options_params']['list_sidebar_styles'],
					"dir" => "horizontal",
					"type" => "checklist"),
		
		'sidebar_main_position' => array( 
					"title" => esc_html__('Main sidebar position',  'education'),
					"desc" => esc_html__('Select main sidebar position on blog page',  'education'),
					"override" => "category,courses_group,post,page",
					"std" => "right",
					"options" => $THEMEREX_GLOBALS['options_params']['list_positions'],
					"size" => "medium",
					"type" => "switch"),
		
		"sidebar_main" => array( 
					"title" => esc_html__('Select main sidebar',  'education'),
					"desc" => esc_html__('Select main sidebar for the blog page',  'education'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => "sidebar_main",
					"options" => $THEMEREX_GLOBALS['options_params']['list_sidebars'],
					"type" => "select"),
		
		"show_sidebar_footer" => array(
					"title" => esc_html__('Show footer sidebar', 'education'),
					"desc" => esc_html__('Select style for the footer sidebar or hide it', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "light",
					"options" => $THEMEREX_GLOBALS['options_params']['list_sidebar_styles'],
					"dir" => "horizontal",
					"type" => "checklist"),
		
		"sidebar_footer" => array( 
					"title" => esc_html__('Select footer sidebar',  'education'),
					"desc" => esc_html__('Select footer sidebar for the blog page',  'education'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => "sidebar_footer",
					"options" => $THEMEREX_GLOBALS['options_params']['list_sidebars'],
					"type" => "select"),
		
		"sidebar_footer_columns" => array( 
					"title" => esc_html__('Footer sidebar columns',  'education'),
					"desc" => esc_html__('Select columns number for the footer sidebar',  'education'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => 3,
					"min" => 1,
					"max" => 6,
					"type" => "spinner"),







		// Customization -> Slider
		//-------------------------------------------------

		"customization_slider" => array(
					"title" => esc_html__('Slider', 'education'),
					"icon" => "iconadmin-picture",
					"override" => "category,courses_group,page",
					"type" => "tab"),

		"info_custom_13" => array(
					"title" => esc_html__('Main slider parameters', 'education'),
					"desc" => esc_html__('Select parameters for main slider (you can override it in each category and page)', 'education'),
					"override" => "category,courses_group,page",
					"type" => "info"),

		"show_slider" => array(
					"title" => esc_html__('Show Slider', 'education'),
					"desc" => esc_html__('Do you want to show slider on each page (post)', 'education'),
					"divider" => false,
					"override" => "category,courses_group,page",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"slider_display" => array(
					"title" => esc_html__('Slider display', 'education'),
					"desc" => esc_html__('How display slider: boxed (fixed width and height), fullwide (fixed height) or fullscreen', 'education'),
					"override" => "category,courses_group,page",
					"std" => "none",
					"options" => array(
						"boxed"=>__("Boxed", 'education'),
						"fullwide"=>__("Fullwide", 'education'),
						"fullscreen"=>__("Fullscreen", 'education')
					),
					"type" => "checklist"),

		"slider_height" => array(
					"title" => esc_html__("Height (in pixels)", 'education'),
					"desc" => esc_html__("Slider height (in pixels) - only if slider display with fixed height.", 'education'),
					"override" => "category,courses_group,page",
					"std" => '',
					"min" => 100,
					"step" => 10,
					"type" => "spinner"),

		"slider_engine" => array(
					"title" => esc_html__('Slider engine', 'education'),
					"desc" => esc_html__('What engine use to show slider?', 'education'),
					"override" => "category,courses_group,page",
					"std" => "flex",
					"options" => $THEMEREX_GLOBALS['options_params']['list_sliders'],
					"type" => "radio"),

		"slider_alias" => array(
					"title" => esc_html__('Layer Slider: Alias (for Revolution) or ID (for Royal)',  'education'),
					"desc" => esc_html__("Revolution Slider alias or Royal Slider ID (see in slider settings on plugin page)", 'education'),
					"override" => "category,courses_group,page",
					"std" => "",
					"type" => "text"),

		"slider_category" => array(
					"title" => esc_html__('Posts Slider: Category to show', 'education'),
					"desc" => esc_html__('Select category to show in Flexslider (ignored for Revolution and Royal sliders)', 'education'),
					"override" => "category,courses_group,page",
					"std" => "",
					"options" => themerex_array_merge(array(0 => esc_html__('- Select category -', 'education')), $THEMEREX_GLOBALS['options_params']['list_categories']),
					"type" => "select",
					"multiple" => true,
					"style" => "list"),

		"slider_posts" => array(
					"title" => esc_html__('Posts Slider: Number posts or comma separated posts list',  'education'),
					"desc" => esc_html__("How many recent posts display in slider or comma separated list of posts ID (in this case selected category ignored)", 'education'),
					"override" => "category,courses_group,page",
					"std" => "5",
					"type" => "text"),

		"slider_orderby" => array(
					"title" => esc_html__("Posts Slider: Posts order by",  'education'),
					"desc" => esc_html__("Posts in slider ordered by date (default), comments, views, author rating, users rating, random or alphabetically", 'education'),
					"override" => "category,courses_group,page",
					"std" => "date",
					"options" => $THEMEREX_GLOBALS['options_params']['list_sorting'],
					"type" => "select"),

		"slider_order" => array(
					"title" => esc_html__("Posts Slider: Posts order", 'education'),
					"desc" => esc_html__('Select the desired ordering method for posts', 'education'),
					"override" => "category,courses_group,page",
					"std" => "desc",
					"options" => $THEMEREX_GLOBALS['options_params']['list_ordering'],
					"size" => "big",
					"type" => "switch"),

		"slider_interval" => array(
					"title" => esc_html__("Posts Slider: Slide change interval", 'education'),
					"desc" => esc_html__("Interval (in ms) for slides change in slider", 'education'),
					"override" => "category,courses_group,page",
					"std" => 7000,
					"min" => 100,
					"step" => 100,
					"type" => "spinner"),

		"slider_pagination" => array(
					"title" => esc_html__("Posts Slider: Pagination", 'education'),
					"desc" => esc_html__("Choose pagination style for the slider", 'education'),
					"override" => "category,courses_group,page",
					"std" => "no",
					"options" => array(
						'no'   => esc_html__('None', 'education'),
						'yes'  => esc_html__('Dots', 'education'),
						'over' => esc_html__('Titles', 'education')
					),
					"type" => "checklist"),

		"slider_infobox" => array(
					"title" => esc_html__("Posts Slider: Show infobox", 'education'),
					"desc" => esc_html__("Do you want to show post's title, reviews rating and description on slides in slider", 'education'),
					"override" => "category,courses_group,page",
					"std" => "slide",
					"options" => array(
						'no'    => esc_html__('None',  'education'),
						'slide' => esc_html__('Slide', 'education'),
						'fixed' => esc_html__('Fixed', 'education')
					),
					"type" => "checklist"),

		"slider_info_category" => array(
					"title" => esc_html__("Posts Slider: Show post's category", 'education'),
					"desc" => esc_html__("Do you want to show post's category on slides in slider", 'education'),
					"override" => "category,courses_group,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"slider_info_reviews" => array(
					"title" => esc_html__("Posts Slider: Show post's reviews rating", 'education'),
					"desc" => esc_html__("Do you want to show post's reviews rating on slides in slider", 'education'),
					"override" => "category,courses_group,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"slider_info_descriptions" => array(
					"title" => esc_html__("Posts Slider: Show post's descriptions", 'education'),
					"desc" => esc_html__("How many characters show in the post's description in slider. 0 - no descriptions", 'education'),
					"override" => "category,courses_group,page",
					"std" => 0,
					"min" => 0,
					"step" => 10,
					"type" => "spinner"),
		
		
		
		
		// Customization -> Header & Footer
		//-------------------------------------------------
		
		'customization_header_footer' => array(
					"title" => esc_html__("Header &amp; Footer", 'education'),
					"override" => "category,courses_group,post,page",
					"icon" => 'iconadmin-window',
					"type" => "tab"),
		
		
		"info_footer_1" => array(
					"title" => esc_html__("Header settings", 'education'),
					"desc" => esc_html__("Select components of the page header, set style and put the content for the user's header area", 'education'),
					"override" => "category,courses_group,page,post",
					"type" => "info"),
		
		"show_user_header" => array(
					"title" => esc_html__("Show user's header", 'education'),
					"desc" => esc_html__("Show custom user's header", 'education'),
					"divider" => false,
					"override" => "category,courses_group,page,post",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"user_header_content" => array(
					"title" => esc_html__("User's header content", 'education'),
					"desc" => esc_html__('Put header html-code and/or shortcodes here. You can use any html-tags and shortcodes', 'education'),
					"override" => "category,courses_group,page,post",
					"std" => "",
					"rows" => "10",
					"type" => "editor"),
		
		"show_page_top" => array(
					"title" => esc_html__('Show Top of page section', 'education'),
					"desc" => esc_html__('Show top section with post/page/category title and breadcrumbs', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_page_title" => array(
					"title" => esc_html__('Show Page title', 'education'),
					"desc" => esc_html__('Show post/page/category title', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_breadcrumbs" => array(
					"title" => esc_html__('Show Breadcrumbs', 'education'),
					"desc" => esc_html__('Show path to current category (post, page)', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"breadcrumbs_max_level" => array(
					"title" => esc_html__('Breadcrumbs max nesting', 'education'),
					"desc" => esc_html__("Max number of the nested categories in the breadcrumbs (0 - unlimited)", 'education'),
					"std" => "0",
					"min" => 0,
					"max" => 100,
					"step" => 1,
					"type" => "spinner"),
		
		
		
		
		"info_footer_2" => array(
					"title" => esc_html__("Footer settings", 'education'),
					"desc" => esc_html__("Select components of the footer, set style and put the content for the user's footer area", 'education'),
					"override" => "category,courses_group,page,post",
					"type" => "info"),
		
		"show_user_footer" => array(
					"title" => esc_html__("Show user's footer", 'education'),
					"desc" => esc_html__("Show custom user's footer", 'education'),
					"divider" => false,
					"override" => "category,courses_group,page,post",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"user_footer_content" => array(
					"title" => esc_html__("User's footer content", 'education'),
					"desc" => esc_html__('Put footer html-code and/or shortcodes here. You can use any html-tags and shortcodes', 'education'),
					"override" => "category,courses_group,page,post",
					"std" => "",
					"rows" => "10",
					"type" => "editor"),
		
		"show_contacts_in_footer" => array(
					"title" => esc_html__('Show Contacts in footer', 'education'),
					"desc" => esc_html__('Show contact information area in footer: site logo, contact info and large social icons', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "dark",
					"options" => array(
						'hide' 	=> esc_html__('Hide', 'education'),
						'light'	=> esc_html__('Light', 'education'),
						'dark'	=> esc_html__('Dark', 'education')
					),
					"dir" => "horizontal",
					"type" => "checklist"),

		"show_copyright_in_footer" => array(
					"title" => esc_html__('Show Copyright area in footer', 'education'),
					"desc" => esc_html__('Show area with copyright information and small social icons in footer', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"footer_copyright" => array(
					"title" => esc_html__('Footer copyright text',  'education'),
					"desc" => esc_html__("Copyright text to show in footer area (bottom of site)", 'education'),
					"override" => "category,courses_group,page,post",
					"std" => "ThemeREX &copy; {Y} All Rights Reserved ",
					"rows" => "10",
					"type" => "editor"),
		
		
		"info_footer_3" => array(
					"title" => esc_html__('Testimonials in Footer', 'education'),
					"desc" => esc_html__('Select parameters for Testimonials in the Footer (you can override it in each category and page)', 'education'),
					"override" => "category,courses_group,page,post",
					"type" => "info"),

		"show_testimonials_in_footer" => array(
					"title" => esc_html__('Show Testimonials in footer', 'education'),
					"desc" => esc_html__('Show Testimonials slider in footer. For correct operation of the slider (and shortcode testimonials) you must fill out Testimonials posts on the menu "Testimonials"', 'education'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => "none",
					"options" => $THEMEREX_GLOBALS['options_params']['list_tints'],
					"type" => "checklist"),

		"testimonials_count" => array( 
					"title" => esc_html__('Testimonials count', 'education'),
					"desc" => esc_html__('Number testimonials to show', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => 3,
					"step" => 1,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),

		"testimonials_bg_image" => array( 
					"title" => esc_html__('Testimonials bg image', 'education'),
					"desc" => esc_html__('Select image or put image URL from other site to use it as testimonials block background', 'education'),
					"override" => "category,courses_group,post,page",
					"readonly" => false,
					"std" => "",
					"type" => "media"),

		"testimonials_bg_color" => array( 
					"title" => esc_html__('Testimonials bg color', 'education'),
					"desc" => esc_html__('Select color to use it as testimonials block background', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"),

		"testimonials_bg_overlay" => array( 
					"title" => esc_html__('Testimonials bg overlay', 'education'),
					"desc" => esc_html__('Select background color opacity to create overlay effect on background', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => 0,
					"step" => 0.1,
					"min" => 0,
					"max" => 1,
					"type" => "spinner"),
		
		
		"info_footer_4" => array(
					"title" => esc_html__('Twitter in Footer', 'education'),
					"desc" => esc_html__('Select parameters for Twitter stream in the Footer (you can override it in each category and page)', 'education'),
					"override" => "category,courses_group,page,post",
					"type" => "info"),

		"show_twitter_in_footer" => array(
					"title" => esc_html__('Show Twitter in footer', 'education'),
					"desc" => esc_html__('Show Twitter slider in footer. For correct operation of the slider (and shortcode twitter) you must fill out the Twitter API keys on the menu "Appearance - Theme Options - Socials"', 'education'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => "none",
					"options" => $THEMEREX_GLOBALS['options_params']['list_tints'],
					"type" => "checklist"),

		"twitter_count" => array( 
					"title" => esc_html__('Twitter count', 'education'),
					"desc" => esc_html__('Number twitter to show', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => 3,
					"step" => 1,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),

		"twitter_bg_image" => array( 
					"title" => esc_html__('Twitter bg image', 'education'),
					"desc" => esc_html__('Select image or put image URL from other site to use it as Twitter block background', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "media"),

		"twitter_bg_color" => array( 
					"title" => esc_html__('Twitter bg color', 'education'),
					"desc" => esc_html__('Select color to use it as Twitter block background', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"),

		"twitter_bg_overlay" => array( 
					"title" => esc_html__('Twitter bg overlay', 'education'),
					"desc" => esc_html__('Select background color opacity to create overlay effect on background', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => 0,
					"step" => 0.1,
					"min" => 0,
					"max" => 1,
					"type" => "spinner"),


		"info_footer_5" => array(
					"title" => esc_html__('Google map parameters', 'education'),
					"desc" => esc_html__('Select parameters for Google map (you can override it in each category and page)', 'education'),
					"override" => "category,courses_group,page,post",
					"type" => "info"),
					
		"show_googlemap" => array(
					"title" => esc_html__('Show Google Map', 'education'),
					"desc" => esc_html__('Do you want to show Google map on each page (post)', 'education'),
					"divider" => false,
					"override" => "category,courses_group,page,post",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"googlemap_height" => array(
					"title" => esc_html__("Map height", 'education'),
					"desc" => esc_html__("Map height (default - in pixels, allows any CSS units of measure)", 'education'),
					"override" => "category,courses_group,page",
					"std" => 400,
					"min" => 100,
					"step" => 10,
					"type" => "spinner"),
		
		"googlemap_address" => array(
					"title" => esc_html__('Address to show on map',  'education'),
					"desc" => esc_html__("Enter address to show on map center", 'education'),
					"override" => "category,courses_group,page,post",
					"std" => "",
					"type" => "text"),
		
		"googlemap_latlng" => array(
					"title" => esc_html__('Latitude and Longtitude to show on map',  'education'),
					"desc" => esc_html__("Enter coordinates (separated by comma) to show on map center (instead of address)", 'education'),
					"override" => "category,courses_group,page,post",
					"std" => "",
					"type" => "text"),
		
		"googlemap_title" => array(
					"title" => esc_html__("Marker's title",  'education'),
					"desc" => esc_html__("Title to be displayed when hovering on the marker", 'education'),
					"override" => "category,courses_group,page,post",
					"std" => "",
					"type" => "text"),
		
		"googlemap_description" => array(
					"title" => esc_html__("Marker's description",  'education'),
					"desc" => esc_html__("Description to be displayed when clicking on the marker", 'education'),
					"override" => "category,courses_group,page,post",
					"std" => "",
					"type" => "text"),
		
		"googlemap_zoom" => array(
					"title" => esc_html__('Google map initial zoom',  'education'),
					"desc" => esc_html__("Enter desired initial zoom for Google map", 'education'),
					"override" => "category,courses_group,page,post",
					"std" => 16,
					"min" => 1,
					"max" => 20,
					"step" => 1,
					"type" => "spinner"),
		
		"googlemap_style" => array(
					"title" => esc_html__('Google map style',  'education'),
					"desc" => esc_html__("Select style to show Google map", 'education'),
					"override" => "category,courses_group,page,post",
					"std" => 'style1',
					"options" => $THEMEREX_GLOBALS['options_params']['list_gmap_styles'],
					"type" => "select"),
		
		"googlemap_marker" => array(
					"title" => esc_html__('Google map marker',  'education'),
					"desc" => esc_html__("Select or upload png-image with Google map marker", 'education'),
					"std" => '',
					"type" => "media"),
		
		
		
		
		// Customization -> Media
		//-------------------------------------------------
		
		'customization_media' => array(
					"title" => esc_html__('Media', 'education'),
					"override" => "category,courses_group,post,page",
					"icon" => 'iconadmin-picture',
					"type" => "tab"),
		
		"info_media_1" => array(
					"title" => esc_html__('Retina ready', 'education'),
					"desc" => esc_html__("Additional parameters for the Retina displays", 'education'),
					"type" => "info"),
					
		"retina_ready" => array(
					"title" => esc_html__('Image dimensions', 'education'),
					"desc" => esc_html__('What dimensions use for uploaded image: Original or "Retina ready" (twice enlarged)', 'education'),
					"divider" => false,
					"std" => "1",
					"size" => "medium",
					"options" => array("1"=>__("Original", 'education'), "2"=>__("Retina", 'education')),
					"type" => "switch"),
		
		"info_media_2" => array(
					"title" => esc_html__('Media Substitution parameters', 'education'),
					"desc" => esc_html__("Set up the media substitution parameters and slider's options", 'education'),
					"override" => "category,courses_group,page,post",
					"type" => "info"),
		
		"substitute_gallery" => array(
					"title" => esc_html__('Substitute standard Wordpress gallery', 'education'),
					"desc" => esc_html__('Substitute standard Wordpress gallery with our slider on the single pages', 'education'),
					"divider" => false,
					"override" => "category,courses_group,post,page",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
					
		"substitute_slider_engine" => array(
					"title" => esc_html__('Substitution Slider engine', 'education'),
					"desc" => esc_html__('What engine use to show slider instead standard gallery?', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "swiper",
					"options" => array(
						//"chop" => esc_html__("Chop slider", 'education'),
						"swiper" => esc_html__("Swiper slider", 'education')
					),
					"type" => "radio"),
		
		"gallery_instead_image" => array(
					"title" => esc_html__('Show gallery instead featured image', 'education'),
					"desc" => esc_html__('Show slider with gallery instead featured image on blog streampage and in the related posts section for the gallery posts', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"gallery_max_slides" => array(
					"title" => esc_html__('Max images number in the slider', 'education'),
					"desc" => esc_html__('Maximum images number from gallery into slider', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "5",
					"min" => 2,
					"max" => 10,
					"type" => "spinner"),
		
		"popup_engine" => array(
					"title" => esc_html__('Gallery popup engine', 'education'),
					"desc" => esc_html__('Select engine to show popup windows with galleries', 'education'),
					"std" => "magnific",
					"options" => $THEMEREX_GLOBALS['options_params']['list_popups'],
					"type" => "select"),
		
		"popup_gallery" => array(
					"title" => esc_html__('Enable Gallery mode in the popup', 'education'),
					"desc" => esc_html__('Enable Gallery mode in the popup or show only single image', 'education'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		
		"substitute_audio" => array(
					"title" => esc_html__('Substitute audio tags', 'education'),
					"desc" => esc_html__('Substitute audio tag with source from soundcloud to embed player', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"substitute_video" => array(
					"title" => esc_html__('Substitute video tags', 'education'),
					"desc" => esc_html__('Substitute video tags with embed players or leave video tags unchanged (if you use third party plugins for the video tags)', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"use_mediaelement" => array(
					"title" => esc_html__('Use Media Element script for audio and video tags', 'education'),
					"desc" => esc_html__('Do you want use the Media Element script for all audio and video tags on your site or leave standard HTML5 behaviour?', 'education'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		
		
		
		
		// Customization -> Typography
		//-------------------------------------------------
		
		'customization_typography' => array(
					"title" => esc_html__("Typography", 'education'),
					"icon" => 'iconadmin-font',
					"type" => "tab"),
		
		"info_typo_1" => array(
					"title" => esc_html__('Typography settings', 'education'),
					"desc" => wp_kses_data( __('Select fonts, sizes and styles for the headings and paragraphs. You can use Google fonts and custom fonts.<br><br>How to install custom @font-face fonts into the theme?<br>All @font-face fonts are located in "theme_name/css/font-face/" folder in the separate subfolders for the each font. Subfolder name is a font-family name!<br>Place full set of the font files (for each font style and weight) and css-file named stylesheet.css in the each subfolder.<br>Create your @font-face kit by using <a href="http://www.fontsquirrel.com/fontface/generator">Fontsquirrel @font-face Generator</a> and then extract the font kit (with folder in the kit) into the "theme_name/css/font-face" folder to install.', 'education')),
					"type" => "info"),
		
		"typography_custom" => array(
					"title" => esc_html__('Use custom typography', 'education'),
					"desc" => esc_html__('Use custom font settings or leave theme-styled fonts', 'education'),
					"divider" => false,
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"typography_h1_font" => array(
					"title" => esc_html__('Heading 1', 'education'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Signika",
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),
		
		"typography_h1_size" => array(
					"title" => esc_html__('Size', 'education'),
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "48",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),
		
		"typography_h1_lineheight" => array(
					"title" => esc_html__('Line height', 'education'),
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "60",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),
		
		"typography_h1_weight" => array(
					"title" => esc_html__('Weight', 'education'),
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "400",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),
		
		"typography_h1_style" => array(
					"title" => esc_html__('Style', 'education'),
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),
		
		"typography_h1_color" => array(
					"title" => esc_html__('Color', 'education'),
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),
		
		"typography_h2_font" => array(
					"title" => esc_html__('Heading 2', 'education'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Signika",
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),
		
		"typography_h2_size" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "36",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),
		
		"typography_h2_lineheight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "43",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),
		
		"typography_h2_weight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "400",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),
		
		"typography_h2_style" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),
		
		"typography_h2_color" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),
		
		"typography_h3_font" => array(
					"title" => esc_html__('Heading 3', 'education'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Signika",
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),
		
		"typography_h3_size" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "24",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),
		
		"typography_h3_lineheight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "28",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),
		
		"typography_h3_weight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "400",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),
		
		"typography_h3_style" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),
		
		"typography_h3_color" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),
		
		"typography_h4_font" => array(
					"title" => esc_html__('Heading 4', 'education'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Signika",
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),
		
		"typography_h4_size" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "20",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),
		
		"typography_h4_lineheight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "24",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),
		
		"typography_h4_weight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "400",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),
		
		"typography_h4_style" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),
		
		"typography_h4_color" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),
		
		"typography_h5_font" => array(
					"title" => esc_html__('Heading 5', 'education'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Signika",
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),
		
		"typography_h5_size" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "18",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),
		
		"typography_h5_lineheight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "20",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),
		
		"typography_h5_weight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "400",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),
		
		"typography_h5_style" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),
		
		"typography_h5_color" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),
		
		"typography_h6_font" => array(
					"title" => esc_html__('Heading 6', 'education'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Signika",
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),
		
		"typography_h6_size" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "16",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),
		
		"typography_h6_lineheight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "18",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),
		
		"typography_h6_weight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "400",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),
		
		"typography_h6_style" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),
		
		"typography_h6_color" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),
		
		"typography_p_font" => array(
					"title" => esc_html__('Paragraph text', 'education'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Source Sans Pro",
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),
		
		"typography_p_size" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "14",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),
		
		"typography_p_lineheight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "21",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),
		
		"typography_p_weight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "300",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),
		
		"typography_p_style" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $THEMEREX_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),
		
		"typography_p_color" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8 last",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),
		
		
		
		
		
		
		
		
		
		
		
		
		//###############################
		//#### Blog and Single pages #### 
		//###############################
		"partition_blog" => array(
					"title" => esc_html__('Blog &amp; Single', 'education'),
					"icon" => "iconadmin-docs",
					"override" => "category,courses_group,post,page",
					"type" => "partition"),
		
		
		
		// Blog -> Stream page
		//-------------------------------------------------
		
		'blog_tab_stream' => array(
					"title" => esc_html__('Stream page', 'education'),
					"start" => 'blog_tabs',
					"icon" => "iconadmin-docs",
					"override" => "category,courses_group,post,page",
					"type" => "tab"),
		
		"info_blog_1" => array(
					"title" => esc_html__('Blog streampage parameters', 'education'),
					"desc" => esc_html__('Select desired blog streampage parameters (you can override it in each category)', 'education'),
					"override" => "category,courses_group,post,page",
					"type" => "info"),
		
		"blog_style" => array(
					"title" => esc_html__('Blog style', 'education'),
					"desc" => esc_html__('Select desired blog style', 'education'),
					"divider" => false,
					"override" => "category,courses_group,page",
					"std" => "excerpt",
					"options" => $THEMEREX_GLOBALS['options_params']['list_blog_styles'],
					"type" => "select"),
		
		"article_style" => array(
					"title" => esc_html__('Article style', 'education'),
					"desc" => esc_html__('Select article display method: boxed or stretch', 'education'),
					"override" => "category,courses_group,page",
					"std" => "stretch",
					"options" => $THEMEREX_GLOBALS['options_params']['list_article_styles'],
					"size" => "medium",
					"type" => "switch"),
		
		"hover_style" => array(
					"title" => esc_html__('Hover style', 'education'),
					"desc" => esc_html__('Select desired hover style (only for Blog style = Portfolio)', 'education'),
					"override" => "category,courses_group,page",
					"std" => "square effect_shift",
					"options" => $THEMEREX_GLOBALS['options_params']['list_hovers'],
					"type" => "select"),
		
		"hover_dir" => array(
					"title" => esc_html__('Hover dir', 'education'),
					"desc" => esc_html__('Select hover direction (only for Blog style = Portfolio and Hover style = Circle or Square)', 'education'),
					"override" => "category,courses_group,page",
					"std" => "left_to_right",
					"options" => $THEMEREX_GLOBALS['options_params']['list_hovers_dir'],
					"type" => "select"),
		
		"dedicated_location" => array(
					"title" => esc_html__('Dedicated location', 'education'),
					"desc" => esc_html__('Select location for the dedicated content or featured image in the "excerpt" blog style', 'education'),
					"override" => "category,courses_group,page,post",
					"std" => "default",
					"options" => $THEMEREX_GLOBALS['options_params']['list_locations'],
					"type" => "select"),
		
		"show_filters" => array(
					"title" => esc_html__('Show filters', 'education'),
					"desc" => esc_html__('Show filter buttons (only for Blog style = Portfolio, Masonry, Classic)', 'education'),
					"override" => "category,courses_group,page",
					"std" => "hide",
					"options" => $THEMEREX_GLOBALS['options_params']['list_filters'],
					"type" => "checklist"),
		
		"blog_sort" => array(
					"title" => esc_html__('Blog posts sorted by', 'education'),
					"desc" => esc_html__('Select the desired sorting method for posts', 'education'),
					"override" => "category,courses_group,page",
					"std" => "date",
					"options" => $THEMEREX_GLOBALS['options_params']['list_sorting'],
					"dir" => "vertical",
					"type" => "radio"),
		
		"blog_order" => array(
					"title" => esc_html__('Blog posts order', 'education'),
					"desc" => esc_html__('Select the desired ordering method for posts', 'education'),
					"override" => "category,courses_group,page",
					"std" => "desc",
					"options" => $THEMEREX_GLOBALS['options_params']['list_ordering'],
					"size" => "big",
					"type" => "switch"),
		
		"posts_per_page" => array(
					"title" => esc_html__('Blog posts per page',  'education'),
					"desc" => esc_html__('How many posts display on blog pages for selected style. If empty or 0 - inherit system wordpress settings',  'education'),
					"override" => "category,courses_group,page",
					"std" => "12",
					"mask" => "?99",
					"type" => "text"),
		
		"post_excerpt_maxlength" => array(
					"title" => esc_html__('Excerpt maxlength for streampage',  'education'),
					"desc" => esc_html__('How many characters from post excerpt are display in blog streampage (only for Blog style = Excerpt). 0 - do not trim excerpt.',  'education'),
					"override" => "category,courses_group,page",
					"std" => "250",
					"mask" => "?9999",
					"type" => "text"),
		
		"post_excerpt_maxlength_masonry" => array(
					"title" => esc_html__('Excerpt maxlength for classic and masonry',  'education'),
					"desc" => esc_html__('How many characters from post excerpt are display in blog streampage (only for Blog style = Classic or Masonry). 0 - do not trim excerpt.',  'education'),
					"override" => "category,courses_group,page",
					"std" => "150",
					"mask" => "?9999",
					"type" => "text"),
		
		
		
		
		// Blog -> Single page
		//-------------------------------------------------
		
		'blog_tab_single' => array(
					"title" => esc_html__('Single page', 'education'),
					"icon" => "iconadmin-doc",
					"override" => "category,courses_group,post,page",
					"type" => "tab"),
		
		
		"info_blog_2" => array(
					"title" => esc_html__('Single (detail) pages parameters', 'education'),
					"desc" => esc_html__('Select desired parameters for single (detail) pages (you can override it in each category and single post (page))', 'education'),
					"override" => "category,courses_group,post,page",
					"type" => "info"),
		
		"single_style" => array(
					"title" => esc_html__('Single page style', 'education'),
					"desc" => esc_html__('Select desired style for single page', 'education'),
					"divider" => false,
					"override" => "category,courses_group,page,post",
					"std" => "single-standard",
					"options" => $THEMEREX_GLOBALS['options_params']['list_single_styles'],
					"dir" => "horizontal",
					"type" => "radio"),
		
		"allow_editor" => array(
					"title" => esc_html__('Frontend editor',  'education'),
					"desc" => esc_html__("Allow authors to edit their posts in frontend area)", 'education'),
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_featured_image" => array(
					"title" => esc_html__('Show featured image before post',  'education'),
					"desc" => esc_html__("Show featured image (if selected) before post content on single pages", 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_post_title" => array(
					"title" => esc_html__('Show post title', 'education'),
					"desc" => esc_html__('Show area with post title on single pages', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_post_title_on_quotes" => array(
					"title" => esc_html__('Show post title on links, chat, quote, status', 'education'),
					"desc" => esc_html__('Show area with post title on single and blog pages in specific post formats: links, chat, quote, status', 'education'),
					"override" => "category,courses_group,page",
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_post_info" => array(
					"title" => esc_html__('Show post info', 'education'),
					"desc" => esc_html__('Show area with post info on single pages', 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_text_before_readmore" => array(
					"title" => esc_html__('Show text before "Read more" tag', 'education'),
					"desc" => esc_html__('Show text before "Read more" tag on single pages', 'education'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
					
		"show_post_author" => array(
					"title" => esc_html__('Show post author details',  'education'),
					"desc" => esc_html__("Show post author information block on single post page", 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_post_tags" => array(
					"title" => esc_html__('Show post tags',  'education'),
					"desc" => esc_html__("Show tags block on single post page", 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_post_related" => array(
					"title" => esc_html__('Show related posts',  'education'),
					"desc" => esc_html__("Show related posts block on single post page", 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"post_related_count" => array(
					"title" => esc_html__('Related posts number',  'education'),
					"desc" => esc_html__("How many related posts showed on single post page", 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "2",
					"step" => 1,
					"min" => 2,
					"max" => 8,
					"type" => "spinner"),

		"post_related_columns" => array(
					"title" => esc_html__('Related posts columns',  'education'),
					"desc" => esc_html__("How many columns used to show related posts on single post page. 1 - use scrolling to show all related posts", 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "2",
					"step" => 1,
					"min" => 1,
					"max" => 4,
					"type" => "spinner"),
		
		"post_related_sort" => array(
					"title" => esc_html__('Related posts sorted by', 'education'),
					"desc" => esc_html__('Select the desired sorting method for related posts', 'education'),
					"std" => "date",
					"options" => $THEMEREX_GLOBALS['options_params']['list_sorting'],
					"type" => "select"),
		
		"post_related_order" => array(
					"title" => esc_html__('Related posts order', 'education'),
					"desc" => esc_html__('Select the desired ordering method for related posts', 'education'),
					"std" => "desc",
					"options" => $THEMEREX_GLOBALS['options_params']['list_ordering'],
					"size" => "big",
					"type" => "switch"),
		
		"show_post_comments" => array(
					"title" => esc_html__('Show comments',  'education'),
					"desc" => esc_html__("Show comments block on single post page", 'education'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		
		
		// Blog -> Other parameters
		//-------------------------------------------------
		
		'blog_tab_general' => array(
					"title" => esc_html__('Other parameters', 'education'),
					"icon" => "iconadmin-newspaper",
					"override" => "category,courses_group,page",
					"type" => "tab"),
		
		"info_blog_3" => array(
					"title" => esc_html__('Other Blog parameters', 'education'),
					"desc" => esc_html__('Select excluded categories, substitute parameters, etc.', 'education'),
					"type" => "info"),
		
		"exclude_cats" => array(
					"title" => esc_html__('Exclude categories', 'education'),
					"desc" => esc_html__('Select categories, which posts are exclude from blog page', 'education'),
					"divider" => false,
					"std" => "",
					"options" => $THEMEREX_GLOBALS['options_params']['list_categories'],
					"multiple" => true,
					"style" => "list",
					"type" => "select"),
		
		"blog_pagination" => array(
					"title" => esc_html__('Blog pagination', 'education'),
					"desc" => esc_html__('Select type of the pagination on blog streampages', 'education'),
					"std" => "pages",
					"override" => "category,courses_group,page",
					"options" => array(
						'pages'    => esc_html__('Standard page numbers', 'education'),
						'viewmore' => esc_html__('"View more" button', 'education'),
						'infinite' => esc_html__('Infinite scroll', 'education')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"blog_pagination_style" => array(
					"title" => esc_html__('Blog pagination style', 'education'),
					"desc" => esc_html__('Select pagination style for standard page numbers', 'education'),
					"std" => "pages",
					"override" => "category,courses_group,page",
					"options" => array(
						'pages'  => esc_html__('Page numbers list', 'education'),
						'slider' => esc_html__('Slider with page numbers', 'education')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"blog_counters" => array(
					"title" => esc_html__('Blog counters', 'education'),
					"desc" => esc_html__('Select counters, displayed near the post title', 'education'),
					"std" => "views",
					"override" => "category,courses_group,page",
					"options" => array(
						'views' => esc_html__('Views', 'education'),
						'likes' => esc_html__('Likes', 'education'),
						'rating' => esc_html__('Rating', 'education'),
						'comments' => esc_html__('Comments', 'education')
					),
					"dir" => "vertical",
					"multiple" => true,
					"type" => "checklist"),
		
		"close_category" => array(
					"title" => esc_html__("Post's category announce", 'education'),
					"desc" => esc_html__('What category display in announce block (over posts thumb) - original or nearest parental', 'education'),
					"std" => "parental",
					"override" => "category,courses_group,page",
					"options" => array(
						'parental' => esc_html__('Nearest parental category', 'education'),
						'original' => esc_html__("Original post's category", 'education')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"show_date_after" => array(
					"title" => esc_html__('Show post date after', 'education'),
					"desc" => esc_html__('Show post date after N days (before - show post age)', 'education'),
					"override" => "category,courses_group,page",
					"std" => "30",
					"mask" => "?99",
					"type" => "text"),
		
		
		
		
		
		//###############################
		//#### Reviews               #### 
		//###############################
		"partition_reviews" => array(
					"title" => esc_html__('Reviews', 'education'),
					"icon" => "iconadmin-newspaper",
					"override" => "category,courses_group",
					"type" => "partition"),
		
		"info_reviews_1" => array(
					"title" => esc_html__('Reviews criterias', 'education'),
					"desc" => esc_html__('Set up list of reviews criterias. You can override it in any category.', 'education'),
					"override" => "category,courses_group",
					"type" => "info"),
		
		"show_reviews" => array(
					"title" => esc_html__('Show reviews block',  'education'),
					"desc" => esc_html__("Show reviews block on single post page and average reviews rating after post's title in stream pages", 'education'),
					"divider" => false,
					"override" => "category,courses_group",
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"reviews_max_level" => array(
					"title" => esc_html__('Max reviews level',  'education'),
					"desc" => esc_html__("Maximum level for reviews marks", 'education'),
					"std" => "5",
					"options" => array(
						'5'=>__('5 stars', 'education'), 
						'10'=>__('10 stars', 'education'), 
						'100'=>__('100%', 'education')
					),
					"type" => "radio",
					),
		
		"reviews_style" => array(
					"title" => esc_html__('Show rating as',  'education'),
					"desc" => esc_html__("Show rating marks as text or as stars/progress bars.", 'education'),
					"std" => "stars",
					"options" => array(
						'text' => esc_html__('As text (for example: 7.5 / 10)', 'education'),
						'stars' => esc_html__('As stars or bars', 'education')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"reviews_criterias_levels" => array(
					"title" => esc_html__('Reviews Criterias Levels', 'education'),
					"desc" => esc_html__('Words to mark criterials levels. Just write the word and press "Enter". Also you can arrange words.', 'education'),
					"std" => esc_html__("bad,poor,normal,good,great", 'education'),
					"type" => "tags"),
		
		"reviews_first" => array(
					"title" => esc_html__('Show first reviews',  'education'),
					"desc" => esc_html__("What reviews will be displayed first: by author or by visitors. Also this type of reviews will display under post's title.", 'education'),
					"std" => "author",
					"options" => array(
						'author' => esc_html__('By author', 'education'),
						'users' => esc_html__('By visitors', 'education')
						),
					"dir" => "horizontal",
					"type" => "radio"),
		
		"reviews_second" => array(
					"title" => esc_html__('Hide second reviews',  'education'),
					"desc" => esc_html__("Do you want hide second reviews tab in widgets and single posts?", 'education'),
					"std" => "show",
					"options" => $THEMEREX_GLOBALS['options_params']['list_show_hide'],
					"size" => "medium",
					"type" => "switch"),
		
		"reviews_can_vote" => array(
					"title" => esc_html__('What visitors can vote',  'education'),
					"desc" => esc_html__("What visitors can vote: all or only registered", 'education'),
					"std" => "all",
					"options" => array(
						'all'=>__('All visitors', 'education'), 
						'registered'=>__('Only registered', 'education')
					),
					"dir" => "horizontal",
					"type" => "radio"),
		
		"reviews_criterias" => array(
					"title" => esc_html__('Reviews criterias',  'education'),
					"desc" => esc_html__('Add default reviews criterias.',  'education'),
					"override" => "category,courses_group",
					"std" => "",
					"cloneable" => true,
					"type" => "text"),

		"reviews_marks" => array(
					"std" => "",
					"type" => "hidden"),
		
		
		
		
		
		//###############################
		//#### Contact info          #### 
		//###############################
		"partition_contacts" => array(
					"title" => esc_html__('Contact info', 'education'),
					"icon" => "iconadmin-mail-1",
					"type" => "partition"),
		
		"info_contact_1" => array(
					"title" => esc_html__('Contact information', 'education'),
					"desc" => esc_html__('Company address, phones and e-mail', 'education'),
					"type" => "info"),
		
		"contact_email" => array(
					"title" => esc_html__('Contact form email', 'education'),
					"desc" => esc_html__('E-mail for send contact form and user registration data', 'education'),
					"divider" => false,
					"std" => "",
					"before" => array('icon'=>'iconadmin-mail-1'),
					"type" => "text"),
		
		"contact_address_1" => array(
					"title" => esc_html__('Company address (part 1)', 'education'),
					"desc" => esc_html__('Company country, post code and city', 'education'),
					"std" => "",
					"before" => array('icon'=>'iconadmin-home'),
					"type" => "text"),
		
		"contact_address_2" => array(
					"title" => esc_html__('Company address (part 2)', 'education'),
					"desc" => esc_html__('Street and house number', 'education'),
					"std" => "",
					"before" => array('icon'=>'iconadmin-home'),
					"type" => "text"),
		
		"contact_phone" => array(
					"title" => esc_html__('Phone', 'education'),
					"desc" => esc_html__('Phone number', 'education'),
					"std" => "",
					"before" => array('icon'=>'iconadmin-phone'),
					"type" => "text"),
		
		"contact_fax" => array(
					"title" => esc_html__('Fax', 'education'),
					"desc" => esc_html__('Fax number', 'education'),
					"std" => "",
					"before" => array('icon'=>'iconadmin-phone'),
					"type" => "text"),
		
		"contact_info" => array(
					"title" => esc_html__('Contacts in header', 'education'),
					"desc" => esc_html__('String with contact info in the site header', 'education'),
					"std" => "",
					"before" => array('icon'=>'iconadmin-home'),
					"type" => "text"),
		
		"info_contact_2" => array(
					"title" => esc_html__('Contact and Comments form', 'education'),
					"desc" => esc_html__('Maximum length of the messages in the contact form shortcode and in the comments form', 'education'),
					"type" => "info"),
		
		"message_maxlength_contacts" => array(
					"title" => esc_html__('Contact form message', 'education'),
					"desc" => esc_html__("Message's maxlength in the contact form shortcode", 'education'),
					"std" => "1000",
					"min" => 0,
					"max" => 10000,
					"step" => 100,
					"type" => "spinner"),
		
		"message_maxlength_comments" => array(
					"title" => esc_html__('Comments form message', 'education'),
					"desc" => esc_html__("Message's maxlength in the comments form", 'education'),
					"std" => "1000",
					"min" => 0,
					"max" => 10000,
					"step" => 100,
					"type" => "spinner"),
		
		"info_contact_3" => array(
					"title" => esc_html__('Default mail function', 'education'),
					"desc" => esc_html__('What function you want to use for sending mail: the built-in Wordpress or standard PHP function? Attention! Some plugins may not work with one of them and you always have the ability to switch to alternative.', 'education'),
					"type" => "info"),
		
		"mail_function" => array(
					"title" => esc_html__("Mail function", 'education'),
					"desc" => esc_html__("What function you want to use for sending mail?", 'education'),
					"std" => "wp_mail",
					"size" => "medium",
					"options" => array(
						'wp_mail' => esc_html__('WP mail', 'education'),
						'mail' => esc_html__('PHP mail', 'education')
					),
					"type" => "switch"),
		
		
		
		
		//###############################
		//#### Socials               #### 
		//###############################
		"partition_socials" => array(
					"title" => esc_html__('Socials', 'education'),
					"icon" => "iconadmin-users-1",
					"override" => "category,courses_group,page",
					"type" => "partition"),
		
		"info_socials_1" => array(
					"title" => esc_html__('Social networks', 'education'),
					"desc" => esc_html__("Social networks list for site footer and Social widget", 'education'),
					"type" => "info"),
		
		"social_icons" => array(
					"title" => esc_html__('Social networks',  'education'),
					"desc" => esc_html__('Select icon and write URL to your profile in desired social networks.',  'education'),
					"divider" => false,
					"std" => array(array('url'=>'', 'icon'=>'')),
					"options" => $THEMEREX_GLOBALS['options_params']['list_socials'],
					"cloneable" => true,
					"size" => "small",
					"style" => 'images',
					"type" => "socials"),
		
		"info_socials_2" => array(
					"title" => esc_html__('Share buttons', 'education'),
					"override" => "category,courses_group,page",
					"desc" =>wp_kses_data(__("Add button's code for each social share network.<br>
					In share url you can use next macro:<br>
					<b>{url}</b> - share post (page) URL,<br>
					<b>{title}</b> - post title,<br>
					<b>{image}</b> - post image,<br>
					<b>{descr}</b> - post description (if supported)<br>
					For example:<br>
					<b>Facebook</b> share string: <em>http://www.facebook.com/sharer.php?u={link}&amp;t={title}</em><br>
					<b>Delicious</b> share string: <em>http://delicious.com/save?url={link}&amp;title={title}&amp;note={descr}</em>", 'education')),
					"type" => "info"),
		
		"show_share" => array(
					"title" => esc_html__('Show social share buttons',  'education'),
					"override" => "category,courses_group,page",
					"desc" => esc_html__("Show social share buttons block", 'education'),
					"std" => "horizontal",
					"options" => array(
						'hide'		=> esc_html__('Hide', 'education'),
						'vertical'	=> esc_html__('Vertical', 'education'),
						'horizontal'=> esc_html__('Horizontal', 'education')
					),
					"type" => "checklist"),

		"show_share_counters" => array(
					"title" => esc_html__('Show share counters',  'education'),
					"override" => "category,courses_group,page",
					"desc" => esc_html__("Show share counters after social buttons", 'education'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"share_caption" => array(
					"title" => esc_html__('Share block caption',  'education'),
					"override" => "category,courses_group,page",
					"desc" => esc_html__('Caption for the block with social share buttons',  'education'),
					"std" => esc_html__('Share:', 'education'),
					"type" => "text"),
		
		"share_buttons" => array(
					"title" => esc_html__('Share buttons',  'education'),
					"desc" => wp_kses_data( __('Select icon and write share URL for desired social networks.<br><b>Important!</b> If you leave text field empty - internal theme link will be used (if present).',  'education')),
					"std" => array(array('url'=>'', 'icon'=>'')),
					"options" => $THEMEREX_GLOBALS['options_params']['list_socials'],
					"cloneable" => true,
					"size" => "small",
					"style" => 'images',
					"type" => "socials"),
		
		
		"info_socials_3" => array(
					"title" => esc_html__('Twitter API keys', 'education'),
					"desc" => wp_kses_data(__("Put to this section Twitter API 1.1 keys.<br>
					You can take them after registration your application in <strong>https://apps.twitter.com/</strong>", 'education')),
					"type" => "info"),
		
		"twitter_username" => array(
					"title" => esc_html__('Twitter username',  'education'),
					"desc" => esc_html__('Your login (username) in Twitter',  'education'),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_consumer_key" => array(
					"title" => esc_html__('Consumer Key',  'education'),
					"desc" => esc_html__('Twitter API Consumer key',  'education'),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_consumer_secret" => array(
					"title" => esc_html__('Consumer Secret',  'education'),
					"desc" => esc_html__('Twitter API Consumer secret',  'education'),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_token_key" => array(
					"title" => esc_html__('Token Key',  'education'),
					"desc" => esc_html__('Twitter API Token key',  'education'),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_token_secret" => array(
					"title" => esc_html__('Token Secret',  'education'),
					"desc" => esc_html__('Twitter API Token secret',  'education'),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		
		
		
		
		
		
		//###############################
		//#### Search parameters     #### 
		//###############################
		"partition_search" => array(
					"title" => esc_html__('Search', 'education'),
					"icon" => "iconadmin-search-1",
					"type" => "partition"),
		
		"info_search_1" => array(
					"title" => esc_html__('Search parameters', 'education'),
					"desc" => esc_html__('Enable/disable AJAX search and output settings for it', 'education'),
					"type" => "info"),
		
		"show_search" => array(
					"title" => esc_html__('Show search field', 'education'),
					"desc" => esc_html__('Show search field in the top area and side menus', 'education'),
					"divider" => false,
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"use_ajax_search" => array(
					"title" => esc_html__('Enable AJAX search', 'education'),
					"desc" => esc_html__('Use incremental AJAX search for the search field in top of page', 'education'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"ajax_search_min_length" => array(
					"title" => esc_html__('Min search string length',  'education'),
					"desc" => esc_html__('The minimum length of the search string',  'education'),
					"std" => 4,
					"min" => 3,
					"type" => "spinner"),
		
		"ajax_search_delay" => array(
					"title" => esc_html__('Delay before search (in ms)',  'education'),
					"desc" => esc_html__('How much time (in milliseconds, 1000 ms = 1 second) must pass after the last character before the start search',  'education'),
					"std" => 500,
					"min" => 300,
					"max" => 1000,
					"step" => 100,
					"type" => "spinner"),
		
		"ajax_search_types" => array(
					"title" => esc_html__('Search area', 'education'),
					"desc" => esc_html__('Select post types, what will be include in search results. If not selected - use all types.', 'education'),
					"std" => "",
					"options" => $THEMEREX_GLOBALS['options_params']['list_posts_types'],
					"multiple" => true,
					"style" => "list",
					"type" => "select"),
		
		"ajax_search_posts_count" => array(
					"title" => esc_html__('Posts number in output',  'education'),
					"desc" => esc_html__('Number of the posts to show in search results',  'education'),
					"std" => 5,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),
		
		"ajax_search_posts_image" => array(
					"title" => esc_html__("Show post's image", 'education'),
					"desc" => esc_html__("Show post's thumbnail in the search results", 'education'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"ajax_search_posts_date" => array(
					"title" => esc_html__("Show post's date", 'education'),
					"desc" => esc_html__("Show post's publish date in the search results", 'education'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"ajax_search_posts_author" => array(
					"title" => esc_html__("Show post's author", 'education'),
					"desc" => esc_html__("Show post's author in the search results", 'education'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"ajax_search_posts_counters" => array(
					"title" => esc_html__("Show post's counters", 'education'),
					"desc" => esc_html__("Show post's counters (views, comments, likes) in the search results", 'education'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		
		
		
		
		//###############################
		//#### Service               #### 
		//###############################
		
		"partition_service" => array(
					"title" => esc_html__('Service', 'education'),
					"icon" => "iconadmin-wrench",
					"type" => "partition"),
		
		"info_service_1" => array(
					"title" => esc_html__('Theme functionality', 'education'),
					"desc" => esc_html__('Basic theme functionality settings', 'education'),
					"type" => "info"),
		
		"use_ajax_views_counter" => array(
					"title" => esc_html__('Use AJAX post views counter', 'education'),
					"desc" => esc_html__('Use javascript for post views count (if site work under the caching plugin) or increment views count in single page template', 'education'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"admin_add_filters" => array(
					"title" => esc_html__('Additional filters in the admin panel', 'education'),
					"desc" => wp_kses_data(__('Show additional filters (on post formats, tags and categories) in admin panel page "Posts". <br>Attention! If you have more than 2.000-3.000 posts, enabling this option may cause slow load of the "Posts" page! If you encounter such slow down, simply open Appearance - Theme Options - Service and set "No" for this option.', 'education')),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_overriden_taxonomies" => array(
					"title" => esc_html__('Show overriden options for taxonomies', 'education'),
					"desc" => esc_html__('Show extra column in categories list, where changed (overriden) theme options are displayed.', 'education'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_overriden_posts" => array(
					"title" => esc_html__('Show overriden options for posts and pages', 'education'),
					"desc" => esc_html__('Show extra column in posts and pages list, where changed (overriden) theme options are displayed.', 'education'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"admin_dummy_timeout" => array(
					"title" => esc_html__('Dummy Data Installer Timeout',  'education'),
					"desc" => esc_html__('Web-servers set the time limit for the execution of php-scripts. By default, this is 30 sec. Therefore, the import process will be split into parts. Upon completion of each part - the import will resume automatically! The import process will try to increase this limit to the time, specified in this field.',  'education'),
					"std" => 1200,
					"min" => 30,
					"max" => 1800,
					"type" => "spinner"),
		
		"admin_update_notifier" => array(
					"title" => esc_html__('Enable Update Notifier', 'education'),
					"desc" => wp_kses_data(__('Show update notifier in admin panel. <b>Attention!</b> When this option is enabled, the theme periodically (every few hours) will communicate with our server, to check the current version. When the connection is slow, it may slow down Dashboard.', 'education')),
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"admin_emailer" => array(
					"title" => esc_html__('Enable Emailer in the admin panel', 'education'),
					"desc" => esc_html__('Allow to use ThemeREX Emailer for mass-volume e-mail distribution and management of mailing lists in "Tools - Emailer"', 'education'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"clear_shortcodes" => array(
					"title" => esc_html__('Remove line breaks around shortcodes', 'education'),
					"desc" => wp_kses_data( __('Do you want remove spaces and line breaks around shortcodes? <b>Be attentive!</b> This option thoroughly tested on our theme, but may affect third party plugins.', 'education')),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"debug_mode" => array(
					"title" => esc_html__('Debug mode', 'education'),
					"desc" => wp_kses_data( __('In debug mode we are using unpacked scripts and styles, else - using minified scripts and styles (if present). <b>Attention!</b> If you have modified the source code in the js or css files, regardless of this option will be used latest (modified) version stylesheets and scripts. You can re-create minified versions of files using on-line services (for example <a href="http://yui.2clics.net/" target="_blank">http://yui.2clics.net/</a>) or utility <b>yuicompressor-x.y.z.jar</b>', 'education')),
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"packed_scripts" => array(
					"title" => esc_html__('Use packed css and js files', 'education'),
					"desc" => esc_html__('Do you want to use one packed css and one js file with most theme scripts and styles instead many separate files (for speed up page loading). This reduces the number of HTTP requests when loading pages.', 'education'),
					"std" => "no",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"gtm_code" => array(
					"title" => esc_html__('Google tags manager or Google analitics code',  'education'),
					"desc" => esc_html__('Put here Google Tags Manager (GTM) code from your account: Google analitics, remarketing, etc. This code will be placed after open body tag.',  'education'),
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"type" => "textarea"),
		
		"gtm_code2" => array(
					"title" => esc_html__('Google remarketing code',  'education'),
					"desc" => esc_html__('Put here Google Remarketing code from your account. This code will be placed before close body tag.',  'education'),
					"divider" => false,
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"type" => "textarea"),
		
		"info_service_2" => array(
					"title" => esc_html__('API Keys', 'education'),
					"desc" => wp_kses_data( __('API Keys for some Web services', 'education') ),
					"type" => "info"),
		'api_google_load' => array(
			"title" => esc_html__('Load Google API script', 'education'),
			"desc" => wp_kses_data( __("Uncheck this field to disable loading Google API script if it loaded by another plugin", 'education') ),
			"std" => "yes",
			"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
			"type" => "switch"),
		'api_google' => array(
					"title" => esc_html__('Google API Key', 'education'),
					"desc" => wp_kses_data( __("Insert Google API Key for browsers into the field above to generate Google Maps", 'education') ),
					"std" => "",
					"type" => "text"),
		'api_google_marker' => array(
			"title" => esc_html__('Marker icon', 'education'),
			"desc" => wp_kses_data( __('Default icon to show markers on the Google maps ', 'education') ),
			"std" => '',
			"type" => "media"
		),
		'api_google_cluster' => array(
			"title" => esc_html__('Cluster icon', 'education'),
			"desc" => wp_kses_data( __('Icon to join markers to the cluster on the Google maps ', 'education') ),
			"std" => '',
			"type" => "media"
		),
		
		"info_service_3" => array(
					"title" => esc_html__('Login and Register', 'education'),
					"desc" => wp_kses_data( __('Settings for the users login and registration', 'education') ),
					"type" => "info"),
		
		"ajax_login" => array(
					"title" => esc_html__('Allow AJAX login', 'education'),
					"desc" => esc_html__('Allow AJAX login or redirect visitors on the WP Login screen', 'education'),
					"std" => "yes",
					"options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"social_login" => array(
					"title" => esc_html__('Social Login code',  'education'),
					"desc" => wp_kses_data( __('Specify shortcode from your Social Login Plugin or any HTML/JS code to make Social Login section',  'education') ),
					"std" => "",
					"type" => "textarea"),
		);

	}
}
?>