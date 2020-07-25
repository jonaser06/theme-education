<?php 
global $THEMEREX_GLOBALS;
if (empty($THEMEREX_GLOBALS['menu_user'])) 
	$THEMEREX_GLOBALS['menu_user'] = themerex_get_nav_menu('menu_user');
if (empty($THEMEREX_GLOBALS['menu_user'])) {
	?>
	<ul id="menu_user" class="menu_user_nav">
    <?php
} else {
	$menu = themerex_substr($THEMEREX_GLOBALS['menu_user'], 0, themerex_strlen($THEMEREX_GLOBALS['menu_user'])-5);
	$pos = themerex_strpos($menu, '<ul');
	if ($pos!==false) $menu = themerex_substr($menu, 0, $pos+3) . ' class="menu_user_nav"' . themerex_substr($menu, $pos+3);
	echo str_replace('class=""', '', $menu);
}
?>

<?php if (themerex_is_woocommerce_page() && themerex_get_custom_option('show_currency')=='yes') { ?>
	<li class="menu_user_currency">
		<a href="#">$</a>
		<ul>
			<li><a href="#"><b>&#36;</b> <?php esc_html_e('Dollar', 'education'); ?></a></li>
			<li><a href="#"><b>&euro;</b> <?php esc_html_e('Euro', 'education'); ?></a></li>
			<li><a href="#"><b>&pound;</b> <?php esc_html_e('Pounds', 'education'); ?></a></li>
		</ul>
	</li>
<?php } ?>

<?php if (themerex_exists_woocommerce() && (themerex_is_woocommerce_page() && themerex_get_custom_option('show_cart')=='shop' || themerex_get_custom_option('show_cart')=='always') && !(is_checkout() || is_cart() || defined('WOOCOMMERCE_CHECKOUT') || defined('WOOCOMMERCE_CART'))) { ?>
	<li class="menu_user_cart">
		<a href="#" class="cart_button"><span><?php esc_html_e('Cart', 'education'); ?></span> <b class="cart_total"><?php echo WC()->cart->get_cart_subtotal(); ?></b></a>
			<ul class="widget_area sidebar_cart sidebar"><li>
				<?php
				do_action( 'before_sidebar' );
				$THEMEREX_GLOBALS['current_sidebar'] = 'cart';
				if ( ! dynamic_sidebar( 'sidebar-cart' ) ) { 
					the_widget( 'WC_Widget_Cart', 'title=&hide_if_empty=1' );
				}
				?>
			</li></ul>
	</li>
<?php } ?>

<?php if (themerex_get_custom_option('show_languages')=='yes' && function_exists('icl_get_languages')) {
	$languages = icl_get_languages('skip_missing=1');
	if (!empty($languages)) {
		$lang_list = '';
		$lang_active = '';
		foreach ($languages as $lang) {
			$lang_title = esc_attr($lang['translated_name']);	//esc_attr($lang['native_name']);
			if ($lang['active']) {
				$lang_active = $lang_title;
			}
			$lang_list .= "\n".'<li><a rel="alternate" hreflang="' . esc_attr($lang['language_code']) . '" href="' . esc_url(apply_filters('WPML_filter_link', $lang['url'], $lang)) . '">'
				.'<img src="' . esc_url($lang['country_flag_url']) . '" alt="' . esc_attr($lang_title) . '" title="' . esc_attr($lang_title) . '" />'
				. ($lang_title)
				.'</a></li>';
		}
		?>
		<li class="menu_user_language">
			<a href="#"><span><?php themerex_show_layout($lang_active); ?></span></a>
			<ul><?php themerex_show_layout($lang_list); ?></ul>
		</li>
<?php
	}
}



if (themerex_get_custom_option('show_bookmarks')=='yes') {
	// Load core messages
	themerex_enqueue_messages();
	?>
	<li class="menu_user_bookmarks"><a href="#" class="bookmarks_show icon-star-1" title="<?php esc_html_e('Show bookmarks', 'education'); ?>"></a>
	<?php 
		$list = themerex_get_value_gpc('themerex_bookmarks', '');
		if (!empty($list)) $list = json_decode($list, true);
		?>
		<ul class="bookmarks_list">
			<li><a href="#" class="bookmarks_add icon-star-empty" title="<?php esc_html_e('Add the current page into bookmarks', 'education'); ?>"><?php esc_html_e('Add bookmark', 'education'); ?></a></li>
			<?php 
			if (!empty($list)) {
				foreach ($list as $bm) {
					echo '<li><a href="'.esc_url($bm['url']).'" class="bookmarks_item">'.($bm['title']).'<span class="bookmarks_delete icon-cancel-1" title="'.esc_html__('Delete this bookmark', 'education').'"></span></a></li>';
				}
			}
			?>
		</ul>
	</li>
	<?php 
}


if (themerex_get_custom_option('show_login')=='yes') {

	if ( !is_user_logged_in() ) {
	
		// Load core messages
		themerex_enqueue_messages();

		// Anyone can register ?
		// do_action( 'trx_addons_action_login_code');

		// custom by jonaser
		echo '<li class="menu_user_register">
				<a href="'.esc_url(home_url('/')).'wp-login.php?action=register" class="popup_link popup_register_link inited">Registrar</a>
			</li>';
		echo '<li class="menu_user_login">
				<a href="'.esc_url(home_url('/')).'wp-login.php" class="popup_link popup_login_link inited">Iniciar Sesion</a>
			</li>';

	} else {
	
		$current_user = wp_get_current_user();
		?>
		<li class="menu_user_controls">
			<a href="#"><?php
				$user_avatar = '';
				if ($current_user->user_email) $user_avatar = get_avatar($current_user->user_email, 16*min(2, max(1, themerex_get_theme_option("retina_ready"))));
				if ($user_avatar) {
					?><span class="user_avatar"><?php themerex_show_layout($user_avatar); ?></span><?php
				}?><span class="user_name"><?php themerex_show_layout($current_user->display_name); ?></span></a>
			<ul>
				<?php if (current_user_can('publish_posts')) { ?>
				<li><a href="<?php echo esc_url(home_url('/')); ?>/wp-admin/post-new.php?post_type=post" class="icon icon-doc-inv"><?php esc_html_e('New post', 'education'); ?></a></li>
				<?php } ?>
				<li><a href="<?php echo esc_url(home_url('/'));//echo esc_url(get_edit_user_link()); ?>my-account/" class="icon icon-cog-1">Mi Cuenta<?php //esc_html_e('Settings', 'education'); ?></a></li>
			</ul>
		</li>
		<li class="menu_user_logout"><a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>" class="icon icon-logout"><?php esc_html_e('Logout', 'education'); ?></a></li>
		<?php 
	}
}
?>

</ul>
