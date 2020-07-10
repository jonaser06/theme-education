<?php if (themerex_get_theme_option('use_ajax_views_counter')=='yes') {
	$THEMEREX_GLOBALS['js_vars']['post_id'] =  (int) $post_data['post_id'];
	if ( function_exists( 'trx_addons_plugin_post_data_atts' ) ) {
		$THEMEREX_GLOBALS['js_vars']['post_views'] =  (int) $post_data['post_views'];
	}
}