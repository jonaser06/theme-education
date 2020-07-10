<?php
/**
 * ThemeREX Framework: Customize css
 *
 * @package	themerex
 * @since	themerex 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


// Theme init
if (!function_exists('themerex_core_customizer_theme_setup')) {
	add_action( 'themerex_action_before_init_theme', 'themerex_core_customizer_theme_setup' );
	function themerex_core_customizer_theme_setup() {

		// Add core customization in the custom css
		add_filter( 'themerex_filter_add_styles_inline', 'themerex_core_customizer_add_custom_styles' );

	}
}


// Prepare core custom styles
if (!function_exists('themerex_core_customizer_add_custom_styles')) {
	function themerex_core_customizer_add_custom_styles($custom_style) {
		// Custom fonts
		if (themerex_get_custom_option('typography_custom')=='yes') {
			$fonts = themerex_get_list_fonts(false);
			$fname = themerex_get_custom_option('typography_p_font');
			if (isset($fonts[$fname])) {
				$fstyle = explode(',', themerex_get_custom_option('typography_p_style'));
				$fname2 = ($pos=themerex_strpos($fname,' ('))!==false ? themerex_substr($fname, 0, $pos) : $fname;
				$i = in_array('i', $fstyle);
				$u = in_array('u', $fstyle);
				$c = themerex_get_custom_option('typography_p_color');
				$custom_style .= "
					body, button, input, select, textarea {
						font-family: '" . esc_attr($fname2) . "'" . (isset($fonts[$fname]['family']) ? ", " . esc_attr($fonts[$fname]['family']) : '').";
					}
					body {
						font-size: " . esc_attr(themerex_get_custom_option('typography_p_size')) . "px;
						font-weight: " . esc_attr(themerex_get_custom_option('typography_p_weight')) . ";
						line-height: " . esc_attr(themerex_get_custom_option('typography_p_lineheight')) . "px;
						".($c ? "color: ".esc_attr($c).";" : '')."
						".($i ? "font-style: italic;" : '')."
						".($u ? "text-decoration: underline;" : '')."
					}
				";
			}
			for ($h=1; $h<=6; $h++) {
				$fname = themerex_get_custom_option('typography_h'.($h).'_font');
				if (isset($fonts[$fname])) {
					$fstyle = explode(',', themerex_get_custom_option('typography_h'.($h).'_style'));
					$fname2 = ($pos=themerex_strpos($fname,' ('))!==false ? themerex_substr($fname, 0, $pos) : $fname;
					$i = in_array('i', $fstyle);
					$u = in_array('u', $fstyle);
					$c = themerex_get_custom_option('typography_h'.($h).'_color');
					$custom_style .= "
						h".intval($h).", .h".intval($h)." {
							font-family: '" . esc_attr($fname2) . "'" . (isset($fonts[$fname]['family']) ? ", " . esc_attr($fonts[$fname]['family']) : '').";
							font-size: ".esc_attr(themerex_get_custom_option('typography_h'.intval($h).'_size'))."px;
							font-weight: ".esc_attr(themerex_get_custom_option('typography_h'.intval($h).'_weight')).";
							line-height: ".esc_attr(themerex_get_custom_option('typography_h'.intval($h).'_lineheight'))."px;
							".($c ? "color: ".esc_attr($c).";" : '')."
							".($i ? "font-style: italic;" : '')."
							".($u ? "text-decoration: underline;" : '')."
						}
						h".($h)." a, .h".($h)." a {
							".($c ? "color: ".esc_attr($c).";" : '')."
						}
					";
				}
			}
		}

		// Submenu width
		$menu_width = themerex_get_theme_option('menu_width');
		if (!empty($menu_width)) {
			$custom_style .= "
				/* Submenu width */
				.menu_main_wrap .menu_main_nav > li ul {
					width: ".intval($menu_width)."px;
				}
				.menu_main_wrap .menu_main_nav > li > ul ul {
					left:".intval($menu_width+4)."px;
				}
				.menu_main_wrap .menu_main_nav > li > ul ul.submenu_left {
					left:-".intval($menu_width+1)."px;
				}
			";
		}
	
		// Logo height
		$logo_height = themerex_get_custom_option('logo_height');
		if (!empty($logo_height)) {
			$custom_style .= "
				/* Logo header height */
				.menu_main_wrap .logo_main {
					height:".intval($logo_height)."px;
				}
			";
		}
	
		// Logo top offset
		$logo_offset = themerex_get_custom_option('logo_offset');
		if (!empty($logo_offset)) {
			$custom_style .= "
				/* Logo header top offset */
				.menu_main_wrap .logo {
					margin-top:".intval($logo_offset)."px;
				}
			";
		}

		// Logo footer height
		$logo_height = themerex_get_theme_option('logo_footer_height');
		if (!empty($logo_height)) {
			$custom_style .= "
				/* Logo footer height */
				.contacts_wrap .logo img {
					height:".intval($logo_height)."px;
				}
			";
		}

		// Custom css from theme options
		$custom_style .= themerex_get_custom_option('custom_css');

		return $custom_style;
	}
}
?>