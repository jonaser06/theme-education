<?php
/**
 * ThemeREX Framework: Testimonial post type settings
 *
 * @package	themerex
 * @since	themerex 1.0
 */

// Theme init
if (!function_exists('themerex_testimonial_theme_setup')) {
	add_action( 'themerex_action_before_init_theme', 'themerex_testimonial_theme_setup' );
	function themerex_testimonial_theme_setup() {
	
		// Add item in the admin menu
        add_filter('trx_addons_filter_override_options', 			'themerex_testimonial_add_override_options');

		// Save data from override options
		add_action('save_post',				'themerex_testimonial_save_data');

		// Override Options fields
		global $THEMEREX_GLOBALS;
		$THEMEREX_GLOBALS['testimonial_override_options'] = array(
			'id' => 'testimonial-override-options',
			'title' => esc_html__('Testimonial Details', 'education'),
			'page' => 'testimonial',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				"testimonial_author" => array(
					"title" => esc_html__('Testimonial author',  'education'),
					"desc" => esc_html__("Name of the testimonial's author", 'education'),
					"class" => "testimonial_author",
					"std" => "",
					"type" => "text"),
				"testimonial_email" => array(
					"title" => esc_html__("Author's e-mail",  'education'),
					"desc" => esc_html__("E-mail of the testimonial's author - need to take Gravatar (if registered)", 'education'),
					"class" => "testimonial_email",
					"std" => "",
					"type" => "text"),
				"testimonial_link" => array(
					"title" => esc_html__('Testimonial link',  'education'),
					"desc" => esc_html__("URL of the testimonial source or author profile page", 'education'),
					"class" => "testimonial_link",
					"std" => "",
					"type" => "text")
			)
		);

	}
}


// Add override options
if (!function_exists('themerex_testimonial_add_override_options')) {
	//Handler of add_action('admin_menu', 'themerex_testimonial_add_override_options');
	function themerex_testimonial_add_override_options($boxes=array()) {
        $boxes[] = array_merge(themerex_get_global('testimonial_override_options'), array('callback' => 'themerex_testimonial_show_override_options'));
        return $boxes;
	}
}

// Callback function to show fields in override options
if (!function_exists('themerex_testimonial_show_override_options')) {
	function themerex_testimonial_show_override_options() {
		global $post, $THEMEREX_GLOBALS;

		// Use nonce for verification
		echo '<input type="hidden" name="override_options_testimonial_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
		
		$data = get_post_meta($post->ID, 'testimonial_data', true);
	
		$fields = $THEMEREX_GLOBALS['testimonial_override_options']['fields'];
		?>
		<table class="testimonial_area">
		<?php
		foreach ($fields as $id=>$field) { 
			$meta = isset($data[$id]) ? $data[$id] : '';
			?>
			<tr class="testimonial_field <?php echo esc_attr($field['class']); ?>" valign="top">
				<td><label for="<?php echo esc_attr($id); ?>"><?php echo esc_attr($field['title']); ?></label></td>
				<td><input type="text" name="<?php echo esc_attr($id); ?>" id="<?php echo esc_attr($id); ?>" value="<?php echo esc_attr($meta); ?>" size="30" />
					<br><small><?php echo esc_attr($field['desc']); ?></small></td>
			</tr>
			<?php
		}
		?>
		</table>
		<?php
	}
}


// Save data from override options
if (!function_exists('themerex_testimonial_save_data')) {
	function themerex_testimonial_save_data($post_id) {
		// verify nonce
		if (!isset($_POST['override_options_testimonial_nonce']) || !wp_verify_nonce($_POST['override_options_testimonial_nonce'], basename(__FILE__))) {
			return $post_id;
		}

		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		// check permissions
		if ($_POST['post_type']!='testimonial' || !current_user_can('edit_post', $post_id)) {
			return $post_id;
		}

		global $THEMEREX_GLOBALS;

		$data = array();

		$fields = $THEMEREX_GLOBALS['testimonial_override_options']['fields'];

		// Post type specific data handling
		foreach ($fields as $id=>$field) { 
			if (isset($_POST[$id])) 
				$data[$id] = stripslashes($_POST[$id]);
		}

		update_post_meta($post_id, 'testimonial_data', $data);
	}
}
?>