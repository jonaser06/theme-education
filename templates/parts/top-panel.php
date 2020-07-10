			<?php 
				// WP custom header
				$header_image = $header_image2 = $header_color = '';
				if ($top_panel_style=='dark') {
					if (($header_image = get_header_image()) == '') {
						$header_image = themerex_get_custom_option('top_panel_bg_image');
					}
					if (file_exists(themerex_get_file_dir('skins/'.($theme_skin).'/images/bg_over.png'))) {
						$header_image2 = themerex_get_file_url('skins/'.($theme_skin).'/images/bg_over.png');
					}
					$header_color = apply_filters('themerex_filter_get_link_color', themerex_get_custom_option('top_panel_bg_color'));
				}

				$header_style = $top_panel_opacity!='transparent' && ($header_image!='' || $header_image2!='' || $header_color!='') 
					? ' style="background: ' 
						. ($header_image2!='' ? 'url('.esc_url($header_image2).') repeat-x center bottom' : '')
						. ($header_image!=''  ? ($header_image2!='' ? ',' : '') . 'url('.esc_url($header_image).') repeat center top' : '') 
						. ($header_color!=''  ? ' '.esc_attr($header_color).';' : '')
						.'"' 
					: '';
			?>

			<div class="top_panel_fixed_wrap"></div>

			<header class="top_panel_wrap bg_tint_<?php echo esc_attr($top_panel_style); ?>" <?php themerex_show_layout($header_style); ?>>
				
				<?php if (themerex_get_custom_option('show_menu_user')=='yes') { ?>
					<div class="menu_user_wrap">
						<div class="content_wrap clearfix">
							<div class="menu_user_area menu_user_right menu_user_nav_area">
								<?php require_once( themerex_get_file_dir('templates/parts/user-panel.php') ); ?>
							</div>
							<?php if (themerex_get_custom_option('show_contact_info')=='yes') { ?>
							<div class="menu_user_area menu_user_left menu_user_contact_area"><?php echo wp_kses_post(themerex_get_custom_option('contact_info')); ?></div>
							<?php } ?>
						</div>
					</div>
				<?php } ?>

				<div class="menu_main_wrap logo_<?php echo esc_attr(themerex_get_custom_option('logo_align')); ?><?php if ($THEMEREX_GLOBALS['logo_text']) { echo ' with_text'; } ?>">
					<div class="content_wrap clearfix">
						<div class="logo">
							<a href="<?php echo esc_url(home_url('/')); ?>"><?php echo !empty($THEMEREX_GLOBALS['logo_'.($logo_style)]) ? '<img src="'.esc_url($THEMEREX_GLOBALS['logo_'.($logo_style)]).'" class="logo_main" alt="'.esc_attr__('img', 'education').'"><img src="'.esc_url($THEMEREX_GLOBALS['logo_fixed']).'" class="logo_fixed" alt="'.esc_attr__('img', 'education').'">' : ''; ?><?php if ($THEMEREX_GLOBALS['logo_text']) { echo '<span class="logo_text">'.($THEMEREX_GLOBALS['logo_text']).'</span>'; } ?><?php if ($THEMEREX_GLOBALS['logo_slogan']) { echo '<span class="logo_slogan">' . esc_html($THEMEREX_GLOBALS['logo_slogan']) . '</span>'; } ?></a>
						</div>
						
						<?php if (themerex_get_custom_option('show_search')=='yes' && function_exists('themerex_sc_search')) echo themerex_sc_search(array( 'open'=>"no", 'title'=>"")); ?>
		
						<a href="#" class="menu_main_responsive_button icon-menu-1"></a>
	
						<nav role="navigation" class="menu_main_nav_area">
							<?php
							if (empty($THEMEREX_GLOBALS['menu_main'])) $THEMEREX_GLOBALS['menu_main'] = themerex_get_nav_menu('menu_main');
							if (empty($THEMEREX_GLOBALS['menu_main'])) $THEMEREX_GLOBALS['menu_main'] = themerex_get_nav_menu();
							themerex_show_layout($THEMEREX_GLOBALS['menu_main']);
							?>
						</nav>
					</div>
				</div>

			</header>
