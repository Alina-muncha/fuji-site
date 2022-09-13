<?php

/**
 * fuji functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package fuji
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

if (!function_exists('fuji_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function fuji_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on fuji, use a find and replace
		 * to change 'fuji' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('fuji', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__('Primary', 'fuji'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'fuji_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action('after_setup_theme', 'fuji_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fuji_content_width()
{
	$GLOBALS['content_width'] = apply_filters('fuji_content_width', 640);
}

add_action('after_setup_theme', 'fuji_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fuji_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'fuji'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'fuji'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}

add_action('widgets_init', 'fuji_widgets_init');

class macho_bootstrap_walker extends Walker_Nav_Menu
{

	/**
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 *
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 */
	public function start_lvl(&$output, $depth = 0, $args = array())
	{
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul role=\"menu\" class=\"dropdown\">\n";
	}

	/**
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::start_el()
	 */
	public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
	{
		$indent = ($depth) ? str_repeat("\t", $depth) : '';

		/**
		 * Dividers, Headers or Disabled
		 * =============================
		 * Determine whether the item is a Divider, Header, Disabled or regular
		 * menu item. To prevent errors we use the strcasecmp() function to so a
		 * comparison that is not case sensitive. The strcasecmp() function returns
		 * a 0 if the strings are equal.
		 */
		if (strcasecmp($item->attr_title, 'divider') == 0 && $depth === 1) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if (strcasecmp($item->title, 'divider') == 0 && $depth === 1) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if (strcasecmp($item->attr_title, 'dropdown-header') == 0 && $depth === 1) {
			$output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr($item->title);
		} else if (strcasecmp($item->attr_title, 'disabled') == 0) {
			$output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr($item->title) . '</a>';
		} else {

			$class_names = $value = '';

			$classes   = empty($item->classes) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));

			if ($args->has_children) {
				$class_names .= ' submenu dropdown';
			}

			if (in_array('current-menu-item', $classes)) {
				$class_names .= '';
			}

			$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

			$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
			$id = $id ? ' id="' . esc_attr($id) . '"' : '';

			$output .= $indent . '<li' . $id . $value . $class_names . '>';

			$atts           = array();
			$atts['title']  = !empty($item->title) ? $item->title : '';
			$atts['target'] = !empty($item->target) ? $item->target : '';
			$atts['rel']    = !empty($item->xfn) ? $item->xfn : '';


			$atts['custom'] = !empty($item->custom) ? $item->custom : '';

			// If item has_children add atts to a.
			if ($args->has_children && $depth === 0) {
				$atts['href']          = $item->title;
				$atts['data-toggle']   = 'dropdown';
				$atts['class']         = 'dropdown-toggle';
				$atts['aria-haspopup'] = 'true';
			} else {
				$atts['href'] = !empty($item->url) ? $item->url : '';
			}

			$atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);


			$attributes = '';
			foreach ($atts as $attr => $value) {


				if (!empty($value)) {
					$value      = ('href' === $attr) ? esc_url($value) : esc_attr($value);
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$item_output = $args->before;

			/*
			 * Glyphicons
			 * ===========
			 * Since the the menu item is NOT a Divider or Header we check the see
			 * if there is a value in the attr_title property. If the attr_title
			 * property is NOT null we apply it as the class name for the glyphicon.
			 */
			if (!empty($item->attr_title)) {
				$item_output .= '<a' . $attributes . '><span class="glyphicon ' . esc_attr($item->attr_title) . '"></span>&nbsp;';
			} else {
				$item_output .= '<a' . $attributes . '>';
			}


			$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
			$item_output .= ($args->has_children && 0 === $depth) ? ' </a>' : '</a>';
			$item_output .= $args->after;

			$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
		}
	}

	/**
	 * Traverse elements to create list from elements.
	 *
	 * Display one element if the element doesn't have any children otherwise,
	 * display the element and its children. Will only traverse up to the max
	 * depth and no ignore elements under that depth.
	 *
	 * This method shouldn't be called directly, use the walk() method instead.
	 *
	 * @param object $element Data object
	 * @param array $children_elements List of elements to continue traversing.
	 * @param int $max_depth Max depth to traverse.
	 * @param int $depth Depth of current element.
	 * @param array $args
	 * @param string $output Passed by reference. Used to append additional content.
	 *
	 * @return null Null on failure with no changes to parameters.
	 * @since 2.5.0
	 *
	 * @see Walker::start_el()
	 */
	public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
	{
		if (!$element) {
			return;
		}

		$id_field = $this->db_fields['id'];

		// Display this element.
		if (is_object($args[0])) {
			$args[0]->has_children = !empty($children_elements[$element->$id_field]);
		}

		parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}

	/**
	 * Menu Fallback
	 * =============
	 * If this function is assigned to the wp_nav_menu's fallback_cb variable
	 * and a manu has not been assigned to the theme location in the WordPress
	 * menu manager the function with display nothing to a non-logged in user,
	 * and will add a link to the WordPress menu manager if logged in as an admin.
	 *
	 * @param array $args passed from the wp_nav_menu function.
	 *
	 */
	public static function fallback($args)
	{
		if (current_user_can('manage_options')) {

			extract($args);

			$fb_output = null;

			if ($container) {
				$fb_output = '<' . $container;

				if ($container_id) {
					$fb_output .= ' id="' . $container_id . '"';
				}

				if ($container_class) {
					$fb_output .= ' class="' . $container_class . '"';
				}

				$fb_output .= '>';
			}

			$fb_output .= '<ul';

			if ($menu_id) {
				$fb_output .= ' id="' . $menu_id . '"';
			}

			if ($menu_class) {
				$fb_output .= ' class="' . $menu_class . '"';
			}

			$fb_output .= '>';
			$fb_output .= '<li><a href="' . admin_url('nav-menus.php') . '">Add a menu</a></li>';
			$fb_output .= '</ul>';

			if ($container) {
				$fb_output .= '</' . $container . '>';
			}

			echo $fb_output;
		}
	}
}

if (function_exists('acf_add_options_page')) {

	acf_add_options_page(array(
		'page_title' => 'Fuji General Settings',
		'menu_title' => 'Fuji Settings',
		'menu_slug'  => 'fuji-general-settings',
		'capability' => 'edit_posts',
		'redirect'   => false
	));

	acf_add_options_sub_page(array(
		'page_title'  => 'Fuji Header Settings',
		'menu_title'  => 'Header',
		'parent_slug' => 'fuji-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title'  => 'Fuji Footer Settings',
		'menu_title'  => 'Footer',
		'parent_slug' => 'fuji-general-settings',
	));
}


/**
 * Enqueue scripts and styles.
 */
function fuji_scripts()
{
	wp_enqueue_style('fuji-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
	wp_enqueue_style('fuji-style0', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css');
	wp_enqueue_style('fuji-style1', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css');
	wp_enqueue_style('fuji-style2', get_template_directory_uri() . '/css/main.css');


	wp_deregister_script('jquery');
	wp_register_script('jquery', 'https://code.jquery.com/jquery-3.6.0.min.js');
	wp_enqueue_script('jquery');

	wp_enqueue_script('fuji-navigation1', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', array(), _S_VERSION, true);
	wp_enqueue_script('fuji-navigation2', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array(), _S_VERSION, false);
	wp_enqueue_script('fuji-navigation3', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
	wp_enqueue_script('fuji-navigation4', get_template_directory_uri() . '/js/main.js', array(), _S_VERSION, true);
	// 	wp_enqueue_script( 'fuji-navigation5', get_template_directory_uri() . '/js/customizer.js', array(), _S_VERSION, true );


	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}

add_action('wp_enqueue_scripts', 'fuji_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

add_action('after_setup_theme', 'woocommerce_support');
function woocommerce_support()
{
	add_theme_support('woocommerce');
}

add_filter('woocommerce_checkout_fields', 'addBootstrapToCheckoutFields');
function addBootstrapToCheckoutFields($fields)
{
	foreach ($fields as &$fieldset) {
		foreach ($fieldset as &$field) {
			// if you want to add the form-group class around the label and the input
			$field['class'][] = 'form-group';

			// add form-control to the actual input
			$field['input_class'][] = 'form-control';
		}
	}

	return $fields;
}


// Hook in adding radio button in checkout page

function new_peanut_field($checkout)
{
	if (get_locale() == 'ja') {
		woocommerce_form_field('peanut_allergy', array(
			'type' => 'radio',
			'class' => array('form-row-wide', 'delivery_option'),
			'options' => array('1' => '即発送（在庫のある商品のみ発送いたします。不足品や入荷待ちの商品は入荷次第発送させていただきます。）', '2' => 'ご注文いただいた商品が入荷次第、発送いたします（ご発送までに10日ほどかかる場合がございます）。', '3' => '次回の出張時（次回の営業訪問日時については、各営業担当者にお問い合わせください。)'),
			'label'  => __("配送日"),
			'required' => true,
		), $checkout->get_value('peanut_allergy'));
	} else {
		woocommerce_form_field('peanut_allergy', array(
			'type' => 'radio',
			'class' => array('form-row-wide', 'delivery_option'),
			'options' => array('1' => '1. Desired shipping date selected by the user on the ordering screen (We will only ship in-stock items. Insufficient items and backordered items will be shipped as soon as they arrive.)', '2' => '2. Shipping as soon as the ordered items are available (It may take up to 10 days to order. note that.)', '3' => '3. At the next business visit (Please contact each sales representative for the date and time of your next sales visit.)'),
			'label'  => __("Delivery date"),
			'required' => true,
		), $checkout->get_value('peanut_allergy'));
	}
}
add_action('woocommerce_after_checkout_billing_form', 'new_peanut_field');

function custom_field_validate()
{
	if (!$_POST['peanut_allergy']) {
		if (get_locale() == 'ja') {
			wc_add_notice(__('配送方法をお選びください。'), 'error');
		} else {
			wc_add_notice(__('Please choose one of the delivery methods.'), 'error');
		}
	}
}
add_action('woocommerce_after_checkout_validation', 'custom_field_validate');

function save_peanut($order_id)
{
	if (!empty($_POST['peanut_allergy'])) {
		update_post_meta($order_id, 'Peanut Allergy', $_POST['peanut_allergy']);
	}
}
add_action('woocommerce_checkout_update_order_meta', 'save_peanut');

function display_peanut_allergy($order)
{
	if (get_locale() == 'ja') {
		echo '<p>' . __('配送日') . ': ';
		$allergic = get_post_meta($order->ID, 'Peanut Allergy', true);
		if ($allergic == 1) {
			echo "即発送";
		} elseif ($allergic == 2) {
			echo "ご注文いただいた商品が入荷次第、発送いたします";
		} else {
			echo "次回の出張時";
		}
		echo '</p>';
	} else {

		echo '<p>' . __('Delivery Date') . ': ';
		$allergic = get_post_meta($order->ID, 'Peanut Allergy', true);
		if ($allergic == 1) {
			echo "Immediate shipping";
		} elseif ($allergic == 2) {
			echo "We will ship the ordered items as soon as they arrive.";
		} else {
			echo "On the next business trip";
		}
		echo '</p>';
	}
}
add_action('woocommerce_admin_order_data_after_billing_address', 'display_peanut_allergy', 10, 1);

// End of Hook in adding the radio buttons in checkout page

// add_filter('woocommerce_get_price', 'custom_price_WPA111772', 10, 2);
// add_filter('woocommerce_product_variation_get_price', 'custom_price_WPA111772', 10, 2);
/**
 * custom_price_WPA111772
 *
 * filter the price based on category and user role
 *
 * @param  $price
 * @param  $product
 *
 * @return
 */
function custom_price_WPA111772($price, $product)
{
	if (!is_user_logged_in()) {
		return $price;
	}

	//check if the product is in a category you want, let say shirts
	// if( has_term( 'shirts', 'product_cat' ,$product->ID) ) {
	//check if the user has a role of dealer using a helper function, see bellow
	if (has_role_WPA111772('customer')) {
		//give user 10% of
		$price = $price * 0.9;
	}

	//  }
	return $price;
}

/**
 * has_role_WPA111772
 *
 * function to check if a user has a specific role
 *
 * @param string $role role to check against
 * @param int $user_id user id
 *
 * @return boolean
 */
function has_role_WPA111772($role = '', $user_id = null)
{
	if (is_numeric($user_id)) {
		$user = get_user_by('id', $user_id);
	} else {
		$user = wp_get_current_user();
	}

	if (empty($user)) {
		return false;
	}

	return in_array($role, (array) $user->roles);
}

add_filter('woocommerce_billing_fields', 'custom_woocommerce_billing_fields');

function custom_woocommerce_billing_fields($fields)
{

	if (get_locale() == 'ja') {
		// $fields['companyy_email'] = array(
		// 	'label'       => __('会社の電子メール', 'woocommerce'), // Add custom field label
		// 	'placeholder' => _x('', 'placeholder', 'woocommerce'), // Add custom field placeholder
		// 	'required'    => true, // if field is required or not
		// 	'clear'       => false, // add clear or not
		// 	'type'        => 'email', // add field type
		// 	'class'       => array('form-row-last'),    // add class name
		// 	'priority'    => 5,
		// );
		// $fields['companyy_phone'] = array(
		// 	'label'       => __('会社の電話', 'woocommerce'), // Add custom field label
		// 	'placeholder' => _x('', 'placeholder', 'woocommerce'), // Add custom field placeholder
		// 	'required'    => true, // if field is required or not
		// 	'clear'       => false, // add clear or not
		// 	'type'        => 'text', // add field type
		// 	'class'       => array('form-row-wide'),    // add class name
		// 	'priority'    => 6,
		// );
		$fields['surname_pronounce'] = array(
			'label'       => __('姓', 'woocommerce'), // Add custom field label
			'placeholder' => _x('', 'placeholder', 'woocommerce'), // Add custom field placeholder
			'required'    => false, // if field is required or not
			'clear'       => false, // add clear or not
			'type'        => 'text', // add field type
			'class'       => array('form-row-first'),    // add class name
			'priority'    => 21,
		);

		$fields['name_pronounce'] = array(
			'label'       => __('名前', 'woocommerce'), // Add custom field label
			'placeholder' => _x('', 'placeholder', 'woocommerce'), // Add custom field placeholder
			'required'    => false, // if field is required or not
			'clear'       => false, // add clear or not
			'type'        => 'text', // add field type
			'class'       => array('form-row-last'),    // add class name
			'priority'    => 22,
		);

		$fields['company_position'] = array(
			'label'       => __('役職名', 'woocommerce'), // Add custom field label
			'placeholder' => _x('', 'placeholder', 'woocommerce'), // Add custom field placeholder
			'required'    => false, // if field is required or not
			'clear'       => false, // add clear or not
			'type'        => 'text', // add field type
			'class'       => array('form-row-wide'),    // add class name
			'priority'    => 7,
		);
	} else {
		// $fields['companyy_email'] = array(
		// 	'label'       => __('Company Email', 'woocommerce'), // Add custom field label
		// 	'placeholder' => _x('Company Email', 'placeholder', 'woocommerce'), // Add custom field placeholder
		// 	'required'    => true, // if field is required or not
		// 	'clear'       => false, // add clear or not
		// 	'type'        => 'email', // add field type
		// 	'class'       => array('form-row-last'),    // add class name
		// 	'priority'    => 5,
		// );
		// $fields['companyy_phone'] = array(
		// 	'label'       => __('Company Phone', 'woocommerce'), // Add custom field label
		// 	'placeholder' => _x('Company Phone', 'placeholder', 'woocommerce'), // Add custom field placeholder
		// 	'required'    => true, // if field is required or not
		// 	'clear'       => false, // add clear or not
		// 	'type'        => 'text', // add field type
		// 	'class'       => array('form-row-wide'),    // add class name
		// 	'priority'    => 6,
		// );
		$fields['surname_pronounce'] = array(
			'label'       => __('Surname', 'woocommerce'), // Add custom field label
			'placeholder' => _x('', 'placeholder', 'woocommerce'), // Add custom field placeholder
			'required'    => false, // if field is required or not
			'clear'       => false, // add clear or not
			'type'        => 'text', // add field type
			'class'       => array('form-row-first'),    // add class name
			'priority'    => 21,
		);

		$fields['name_pronounce'] = array(
			'label'       => __('Name', 'woocommerce'), // Add custom field label
			'placeholder' => _x('', 'placeholder', 'woocommerce'), // Add custom field placeholder
			'required'    => false, // if field is required or not
			'clear'       => false, // add clear or not
			'type'        => 'text', // add field type
			'class'       => array('form-row-last'),    // add class name
			'priority'    => 22,
		);

		$fields['company_position'] = array(
			'label'       => __('Company Position', 'woocommerce'), // Add custom field label
			'placeholder' => _x('', 'placeholder', 'woocommerce'), // Add custom field placeholder
			'required'    => false, // if field is required or not
			'clear'       => false, // add clear or not
			'type'        => 'text', // add field type
			'class'       => array('form-row-wide'),    // add class name
			'priority'    => 7,
		);
	}



	return $fields;
}

add_filter('woocommerce_default_address_fields', 'misha_change_fname_field');

function misha_change_fname_field($fields)
{

	if (get_locale() == 'ja') {
		$fields['first_name']['label'] = '名前';
		$fields['last_name']['label']  = '姓';
	} else {
		$fields['first_name']['label'] = 'Name';
		$fields['last_name']['label']  = 'Surname';
	}
	$fields['company']['class']    = array('form-row-first');
	$fields['company']['required']    = true;

	return $fields;
}

add_filter('woocommerce_customer_meta_fields', 'misha_admin_address_field');

function manufacturer() {
 
	register_post_type( 'manufacturer',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'Manufacturer' ),
				'singular_name' => __( 'Manufacturer' )
			),
			'description' => 'Manufacturer',
			'public' => true,
			'menu_position' => 5,
			'has_archive' => true,
			'rewrite' => array('slug' => 'manufacturers'),
			'show_in_rest' => true,
			'supports' => array( 'title', 'editor', 'custom-fields','thumbnail' ),

		)
	);
}
// Hooking up our function to theme setup
add_action( 'init', 'manufacturer' );

function misha_admin_address_field($admin_fields)
{

	// $admin_fields['billing']['fields']['companyy_email']    = array(
	// 	'label' => 'Company Email',
	// );
	// $admin_fields['billing']['fields']['companyy_phone']    = array(
	// 	'label' => 'Company Phone',
	// );
	// $admin_fields['billing']['fields']['surname_pronounce'] = array(
	// 	'label' => 'Surname',
	// );
	// $admin_fields['billing']['fields']['name_pronounce']    = array(
	// 	'label' => 'Name',
	// );
	// $admin_fields['billing']['fields']['company_position']  = array(
	// 	'label' => 'Company Position',
	// );

	// or $admin_fields['shipping']['fields']['shipping_fav_color']
	// or both

	return $admin_fields;
}

add_action('woocommerce_customer_save_address', 'isa_customer_save_address', 10, 1);

function isa_customer_save_address()
{

	global $woocommerce;
	$user_id = get_current_user_id();

	// update_user_meta($user_id, 'first_name', $_POST['billing_first_name']);
	// update_user_meta($user_id, 'last_name', $_POST['billing_last_name']);

	$args = array(
		'ID'         => $user_id,
		'user_email' => esc_attr($_POST['billing_email'])
	);
	wp_update_user($args);
}
add_action('wp_ajax_filter_product', 'filterProduct');
add_action("wp_ajax_nopriv_filter_product", 'filterProduct');
function filterProduct()
{
	if (!empty($_POST['manufacturer'])) {
		echo $_POST['manufacturer'];
	}
	$arg                   = [
		'post_type' => array('product'),

		'count_total' => true,
		'meta_query'  => array(
			'relation' => 'AND',
		)
	];
	$currentPage           = $_POST['pageno'];
	$pageNo                = $_POST['pageno'];
	$postPerPage           = 32;
	$arg['paged'] = $pageNo;
	$arg['posts_per_page'] = $postPerPage;
	$searchBy = $_POST['searchBy'];
	if (!empty($searchBy)) {
		if ($searchBy == 'product_title') {
			if (!empty($_POST['keyword'])) {
				$arg['s'] = $_POST['keyword'];
			}
		} elseif ($searchBy == 'manufacturer') {
			$arg["meta_query"][] = [
				'key'     => 'manufacturer',
				'value'   => $_POST['keyword'],
				'compare' => 'IN'
			];
		} elseif ($searchBy == 'fuji_code') {
			$arg["meta_query"][] = [
				'key'     => '_sku',
				'value'   => $_POST['keyword'],
				'compare' => '='
			];
		} elseif ($searchBy == 'jan_code') {

			$arg["meta_query"][] = [
				'key'     => '_ywbc_barcode_display_value',
				'value'   => $_POST['keyword'],
				'compare' => 'IN'
			];
		}
	} else {

		if (!empty($_POST['keyword'])) {
			$arg['s'] = $_POST['keyword'];
		}
	}
	if (!empty($_POST['sortBy'])) {
		$sortBy = $_POST['sortBy'];
		if ($sortBy == 'nameAsc') {
			$arg['orderby'] = 'title';
			$arg['order']   = 'ASC';
		} elseif ($sortBy == 'nameDesc') {
			$arg['orderby'] = 'title';
			$arg['order']   = 'DESC';
		} elseif ($sortBy == 'priceAsc') {
			$arg['orderby']  = 'meta_value_num';
			$arg['meta_key'] = '_price';
			$arg['order']    = 'ASC';
		} elseif ($sortBy == 'priceDesc') {
			$arg['orderby']  = 'meta_value_num';
			$arg['meta_key'] = '_price';
			$arg['order']    = 'DESC';
		}
	}

	if (!empty($_POST['manufacturer'])) {
		$arg["meta_query"][] = [
			'key'     => 'manufacturer',
			'value'   => $_POST['manufacturer'],
			'compare' => 'IN'
		];
	}

	if (!empty($_POST['min_price'])) {
		$arg["meta_query"][] = [
			'key'     => '_price',
			'value'   => $_POST['min_price'],
			'type'    => 'NUMERIC',
			'compare' => '>='
		];
	}

	if (!empty($_POST['max_price'])) {
		$arg["meta_query"][] = [
			'key'     => '_price',
			'value'   => $_POST['max_price'],
			'type'    => 'NUMERIC',
			'compare' => '<='
		];
	}

	if (!empty($_POST['product_cat'])) {
		$cat_array                  = [];
		$cat_array['relation']      = 'AND';
		$cat_term_array             = [];
		$cat_term_array['taxonomy'] = 'product_cat';
		$cat_term_array['field']    = 'slug';
		$cat_term_array['terms']    = $_POST['product_cat'];
		$cat_array[]                = $cat_term_array;
		$arg['tax_query']           = $cat_array;
	}

	$the_query  = new WP_Query($arg);
	$total_news = $the_query->found_posts;

	if ($the_query->have_posts()) : ?>

<?php while ($the_query->have_posts()) : $the_query->the_post(); 
$_product = wc_get_product(get_the_ID()); ?>

<div class="col-12 search-item">
                    <div class="card rounded-0 border-0">
                        <div class="position-relative overflow-hidden">
                            <a class="text-dark" href="<?php the_permalink(); ?>">
                                <figure class="border border-secondary mb-0 p-1 d-none">
                                    <?php $product_image = get_the_post_thumbnail_url();
										if($product_image){ ?>    
										  <img class="search-item-img w-100 img-fluid obj-fit-cover" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" />                 
										<?php  }
										else{ ?>
										<img class="search-item-img w-100 img-fluid obj-fit-cover" src="<?php echo DEFAULT_IMAGE;?>" alt="<?php the_title(); ?>" />

									  <?php }?>
                                </figure>

                                <div class="list_type_btn_wrapper">
                                        <?php if($_product->is_type( 'simple' )){ ?>
                                          <form action="<?php echo get_site_url(); ?>/cart/" method="post" enctype="multipart/form-data">
                                            <?php $title = $_product->get_meta( 'product_code' ); ?>
                                            <input type="text" id="cfwc-product-code" name="cfwc-product-code" value="<?php echo $title; ?>" style="display: none;">
                                            <button class="btn btn-success rounded-0 p-1 px-2 btn-add-to-cart" data-product="<?php the_ID(); ?>" data-quantity="quantity_<?php the_ID(); ?>" style="float: right;" type="submit" name="add-to-cart" value="<?php the_ID(); ?>">
                                            <?php if(get_locale() == 'ja') { 
                                                              echo "カートに追加";
                                                            }
                                                              else{
                                                                echo "Add to cart";
                                                                }
                                                          ?>  
                                          </button>
                                          </form>
                                          <?php }
                                          else { ?>
                                                
                                            <a class="btn btn-success rounded-0 p-1 px-2 btn-add-to-cart" style="float: right;" href="<?php the_permalink(); ?>">
                                             <?php if(get_locale() == 'ja') { 
                                              echo "バリアントを選択";
                                            }
                                              else{
                                                echo "Choose Variant";
                                                }
                                          ?>
                                                                      </a>
                                           <?php } ?>
                                        </div>
									
                                <div class="px-0 px-lg-2 border-bottom">
                                    <h5 class="title">
                                        <?php the_title(); ?>
                                    </h5>
                                    <h5>
                                        <?php  //echo get_post_meta(get_the_ID(), '_regular_price', true);
                                        echo $_product->get_price_html();
                                                ?>
                                    </h5>
                                </div>
                                <div class="product-overlay-items cart-button-group d-none">
                                    <?php if ($_product->is_type('simple')) { ?>
                                    <form action="<?php echo get_site_url(); ?>/cart/" method="post"
                                        enctype="multipart/form-data">
                                        <?php $title = $_product->get_meta('product_code'); ?>
                                        <input type="text" id="cfwc-product-code" name="cfwc-product-code"
                                            value="<?php echo $title; ?>" style="display: none;">
                                        <button class="btn btn-success rounded-0 p-1 px-2 btn-add-to-cart" data-product="<?php the_ID(); ?>" data-quantity="quantity_<?php the_ID(); ?>" type="submit" name="add-to-cart" value="<?php the_ID(); ?>">
                                            <?php if (get_locale() == 'ja') {
                                                            echo "カートに追加";
                                                        } else {
                                                            echo "Add to cart";
                                                        }
                                                        ?>
                                        </button>
                                    </form>
                                    <?php } else { ?>

                                    <a class="btn btn-success rounded-0 p-1 px-2 btn-add-to-cart"
                                        href="<?php the_permalink(); ?>">
                                        <?php if (get_locale() == 'ja') {
                                                        echo "バリアントを選択";
                                                    } else {
                                                        echo "Choose Variant";
                                                    }
                                                    ?>
                                    </a>
                                    <?php } ?>

                                </div>
                            </a>
                        </div>
                    </div>
                </div>

<?php endwhile; ?>
<div class="row my-4 container-xl px-4 px-lg-3 px-xxl-5">
    <div class="col-lg-5">
    </div>
    <div class="pagination col-7 col-sm-3 mb-3">
        <?php
                        $total_pages = ceil($total_news / $postPerPage);
                        $upperLimit = $total_pages - 2;

                        ?>

                        <?php if ($total_pages > 1) {
                            if ($total_pages > 7) {
                                if ($currentPage > 1) {
                                    $previousPage = $currentPage - 1;
                        ?>
                        <a href="#" class="changePage" data-pageno="<?php echo $previousPage; ?>">&laquo;</a> <?php } ?>
                        <a <?php
                                    if ($currentPage == 1) {
                                        echo 'class="active"';
                                    } else {
                                        echo 'class="changePage"';
                                    } ?> data-pageno="1" href="#">
                            1</a>
                        <a <?php
                                    if ($currentPage == 2) {
                                        echo 'class="active"';
                                    } else {
                                        echo 'class="changePage"';
                                    } ?> data-pageno="2" href="#">
                            2</a>

                        <span class="paginateDots" >...</span>
                        <?php $count = 3;
                                while ($count <= $upperLimit) { ?>
                        <?php
                                    if ($currentPage == $count) {
                                    ?>
                        <a class="changePage active" data-pageno="<?php echo $count; ?>" href="#">
                            <?php echo $count; ?>
                        </a>
                        <?php
                                    } ?>

                        <?php $count++;
                                } ?>
                        <span class="paginateDots" >...</span>
                        <a <?php
                                    if ($currentPage == ($total_pages - 1)) {
                                        echo 'class="active"';
                                    } else {
                                        echo 'class="changePage"';
                                    } ?> data-pageno="<?php echo ($total_pages - 1); ?>" href="#">
                            <?php echo ($total_pages - 1); ?></a>
                        <a <?php
                                    if ($currentPage == $total_pages) {
                                        echo 'class="active"';
                                    } else {
                                        echo 'class="changePage"';
                                    } ?> data-pageno="<?php echo $total_pages; ?>" href="#">
                            <?php echo $total_pages; ?></a>
                        <?php if ($currentPage < $total_pages) { ?>
                        <a href="#" class="changePage" data-pageno="<?php echo ($currentPage + 1); ?>">&raquo;</a>
                        <?php }
                            } else {
                                if ($currentPage > 1) {
                                    $previousPage = $currentPage - 1; ?>
                        <a href="#" class="changePage" data-pageno="<?php echo $previousPage; ?>">&laquo;</a> <?php } ?>
                        <?php $count = 1;
                                while ($count <= $total_pages) { ?>
                        <a <?php
                                        if ($currentPage == $count) {
                                            echo 'class="active"';
                                        } else {
                                            echo 'class="changePage"';
                                        } ?> data-pageno="<?php echo $count; ?>" href="#">
                            <?php echo $count; ?></a>
                        <?php $count++;
                                } ?>
                        <?php if ($currentPage < $total_pages) {
                                ?>
                        <a href="#" class="changePage" data-pageno="<?php echo ($currentPage + 1); ?>">&raquo;</a>
                        <?php }
                            }
                        } ?>
    </div>
</div>
<?php else : ?>

<?php endif;
	die();
}
add_action('init', 'woocommerce_empty_cart_url');
function woocommerce_empty_cart_url()
{
	global $woocommerce;

	if (isset($_GET['empty_cart'])) {
		$woocommerce->cart->empty_cart();
	}
}

add_filter('woocommerce_checkout_fields', 'misha_email_first');

function misha_email_first($checkout_fields)
{
	$checkout_fields['billing']['billing_company']['priority'] = 4;
	$checkout_fields['billing_email']['class'] = array('form-row-last');
	$checkout_fields['billing_email']['priority'] = 5;
	$checkout_fields['billing_phone']['priority'] = 6;
	if (get_locale() == 'ja') {
		$checkout_fields['billing_email']['label'] = '会社の電子メール';
		$checkout_fields['billing_phone']['label'] = '会社の電話';
	} else {
		$checkout_fields['billing_email']['label'] = 'Company Email';
		$checkout_fields['billing_phone']['label'] = 'Company Phone';
	}
	return $checkout_fields;
}

add_filter('woocommerce_billing_fields', function ($billing_fields) {
	// The lower the priority, the higher on the page the field will appear
	// A value of "35" should position the field below the "Company Name"
	$billing_fields['billing_company']['priority'] = 4;
	$billing_fields['billing_email']['priority'] = 5;
	$billing_fields['billing_phone']['priority'] = 6;
	$billing_fields['billing_email']['class'] = array('form-row-last');
	if (get_locale() == 'ja') {
		$billing_fields['billing_email']['label'] = '会社の電子メール';
		$billing_fields['billing_phone']['label'] = '会社の電話';
	} else {
		$billing_fields['billing_email']['label'] = 'Company Email';
		$billing_fields['billing_phone']['label'] = 'Company Phone';
	}

	return $billing_fields;
}, 99);

add_filter('woocommerce_product_get_regular_price', 'custom_dynamic_regular_price', 10, 2);
add_filter('woocommerce_product_variation_get_regular_price', 'custom_dynamic_regular_price', 10, 2);
function custom_dynamic_regular_price($regular_price, $product)
{
	if (empty($regular_price) || $regular_price == 0) {
		return $product->get_price();
	} else {
		return $regular_price;
	}
}


// Generating dynamically the product "sale price"
add_filter('woocommerce_product_get_sale_price', 'custom_dynamic_sale_price', 10, 2);
add_filter('woocommerce_product_variation_get_sale_price', 'custom_dynamic_sale_price', 10, 2);
function custom_dynamic_sale_price($sale_price, $product)
{
	if (is_user_logged_in()) {
		$current_user = wp_get_current_user();
		$currentUserEmail = $current_user->user_email;
		$productSku = $product->get_sku();
		global $wpdb;
		$table = $wpdb->prefix . 'fuji_discount';

		$results = $wpdb->get_results("
                    SELECT * 
                    FROM  $table
					WHERE customer_email = '{$currentUserEmail}'
					AND product_sku = '{$productSku}'
                ");
		if (!empty($results)) {
			foreach ($results as $result) {
				$rateType = $result->discount_type;
				$rate = $result->discount;
				if ($rateType == 'Percentage') {
					$original = $product->get_regular_price();
					$newRate = $original * ($rate / 100);
				} else {
					$newRate = $rate;
				}
				return $product->get_regular_price() - $newRate;
			}
		} else {
			return $sale_price;
		}
	} else {
		return $sale_price;
	}
};

// Displayed formatted regular price + sale price
add_filter('woocommerce_get_price_html', 'custom_dynamic_sale_price_html', 20, 2);
function custom_dynamic_sale_price_html($price_html, $product)
{
	//	if ( $product->is_type( 'variable' ) ) {
	//		return $price_html;
	//	}
	$r = $product->get_regular_price();
	$s = $product->get_sale_price();
	if ($s) {
		$price_html = wc_format_sale_price(wc_get_price_to_display($product, array('price' => $product->get_regular_price())), wc_get_price_to_display($product, array('price' => $product->get_sale_price()))) . $product->get_price_suffix();

		return $price_html;
	} else {

		return $price_html;
	}
}

add_action('woocommerce_before_calculate_totals', 'set_cart_item_sale_price', 20, 1);
function set_cart_item_sale_price($cart)
{
	/*
	if (is_admin() && !defined('DOING_AJAX')) {
		return;
	}

	if (did_action('woocommerce_before_calculate_totals') >= 2) {
		return;
	}
	*/

	// Iterate through each cart item
	foreach ($cart->get_cart() as $cart_item) {
		$price = $cart_item['data']->get_sale_price(); // get sale price
		if ($price) {
			$cart_item['data']->set_price($price); // Set the sale price
		}
	}
}


add_action('admin_init', 'my_remove_menu_pages');
function my_remove_menu_pages()
{

	global $user_ID;

	if (current_user_can('author')) {
		remove_menu_page('edit.php?post_type=thirstylink');
		remove_menu_page('edit.php?post_type=wprss_feed');
		remove_menu_page('authorhreview');
		remove_menu_page('edit.php');                   //Posts
		remove_menu_page('upload.php');
		remove_menu_page('edit-comments.php'); // Comments
		remove_menu_page('tools.php'); // Tools
		remove_menu_page('edit.php?post_type=acf');
		remove_menu_page('wpcf7');
		remove_menu_page('fuji-general-settings');
	}
}
function wps_change_role_name()
{
	global $wp_roles;
	if (!isset($wp_roles))
		$wp_roles = new WP_Roles();
	$wp_roles->roles['subscriber']['name'] = 'New customer';
	$wp_roles->role_names['subscriber'] = 'New customer';
}
add_action('init', 'wps_change_role_name');

add_action('init', 'update_role_name');
function update_role_name()
{
	global $wp_roles;
	$wp_roles->roles['customer']['name'] = 'Old customer';
	$wp_roles->role_names['customer'] = 'Old customer';
}

add_action('init', 'update_role_name1');
function update_role_name1(){
    global $wp_roles;
    $wp_roles->roles['author']['name'] = 'Salesperson'; 
    $wp_roles->role_names['author'] = 'Salesperson'; 
}

add_action('wp_ajax_filter_location', 'filterLocation');
add_action("wp_ajax_nopriv_filter_location", 'filterLocation');
function filterLocation()
{
	$postalCodeT = $_POST['postalcode'];
	$postData = [
		"zipcode" => $postalCodeT,
	];
	$curl = curl_init();

	curl_setopt_array($curl, [
		CURLOPT_URL => "https://geekfeed-search-japanese-postcode-v1.p.rapidapi.com/search-address",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => json_encode($postData),
		CURLOPT_HTTPHEADER => [
			"content-type: application/json",
			"x-rapidapi-host: geekfeed-search-japanese-postcode-v1.p.rapidapi.com",
			"x-rapidapi-key: 357140ea87msh6609b682d8ea3b3p19caadjsn06725f4a869c"
		],
	]);

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		$data = json_decode($response);
	}

	$location = $data->Items[0]->Attributes;

	$return = [];
	$return['city'] = $location[0]->Value;
	$return['postalcode'] = $location[1]->Value;
	$return['town'] = $location[2]->Value;
	$return['pres'] = $location[3]->Value;
	echo json_encode($return);
	die();
}

define('TEMPATH', get_bloginfo('template_directory'));
define('DEFAULT_IMAGE', wc_placeholder_img_src( 'woocommerce_single' ));

add_action('admin_enqueue_scripts', 'admin_style_scripts');
function admin_style_scripts($hook)
{
	if( current_user_can('contributor') ) { 
		wp_enqueue_style('fuji-styl-admin2', get_template_directory_uri() . '/css/extra.css');
	}
}
add_action('woocommerce_checkout_before_customer_details','wc_add_message');
		function wc_add_message(){

			if(get_locale() == 'ja') { 
				echo "[ ＊　必須項目 ]<br><br>";
				  }
				else{
				  echo "[Note: Asterisk (*) indicates 'required' field.]<br><br>";
				}
	
		}
add_action( 'wp_ajax_add_to_cart', 'addToCart' );
add_action( "wp_ajax_nopriv_add_to_cart", 'addToCart' );
function addToCart() {
	$quantity  = $_POST['quantity'];
	$productID = $_POST['product'];
	WC()->cart->add_to_cart( $productID, $quantity );
	echo WC()->cart->cart_contents_count;

	die();
}

add_filter( 'woocommerce_add_to_cart_fragments', 'wc_refresh_mini_cart_count' );
function wc_refresh_mini_cart_count( $fragments ) {
	ob_start();
	$items_count = WC()->cart->get_cart_contents_count();
	?>
    <span class="badge
                      bg-dark
                      position-absolute
                      top-0
                      start-100
                      translate-middle
                    " id="cartCountLG"><?php echo $items_count = WC()->cart->get_cart_contents_count(); ?></span>
	<?php
	$fragments['#cartCountLG'] = ob_get_clean();
	return $fragments;
	

	
}
if( !class_exists( 'MyAPI' ) ) {

	class MyAPI {
	  function __construct() {
		add_action( 'rest_api_init', [$this, 'init'] );
	  }
	
	  function init() {
			
		register_rest_route( 'my/v1', '/get_product_cat', [
			'methods' => 'GET',
			'callback' => [$this, 'get_victim_relation'],
		] );
		  
		  register_rest_route( 'my/v1', '/get_manufacturer', [
					'methods' => 'GET',
					'callback' => [$this, 'get_manufacturer_callback'],
				] );
		  
		  register_rest_route( 'my/v1', '/get_page_info', [
					'methods' => 'GET',
					'callback' => [$this, 'get_page_info_callback'],
				] );
		  
		  register_rest_route( 'my/v1', '/get_discount', [
		  'methods' => 'POST',
		  'callback' => [$this, 'get_discount_callback']
		] );

		register_rest_route( 'my/v1', '/get_product_detail', [
			'methods' => 'GET',
			'callback' => [$this, 'get_product_detail_callback'],
		] );

		register_rest_route( 'my/v1', '/get_allproduct_detail', [
			'methods' => 'GET',
			'callback' => [$this, 'get_allproduct_detail_callback'],
		] );
	  }
	  
	  function get_victim_relation( $params ) {
		$myterms = get_terms(array('taxonomy' => 'product_cat', 'parent' => 0));
		
	
		$return_station = [];
		foreach ($myterms as $myterm) {
                        if ($myterm->name != 'On sale') {
							$thumbnail_id  = (int) get_woocommerce_term_meta( $myterm->term_id, 'colored_image', true );
							$thumbnail_id2  = (int) get_woocommerce_term_meta( $myterm->term_id, 'thumbnail_id', true );
                $term_img  = wp_get_attachment_url( $thumbnail_id );
							if(!$term_img){
								$term_img= "";
							}
							$term_img2  = wp_get_attachment_url( $thumbnail_id2 );
			$return_station[] = ['id' => $myterm->term_id, 'name' => $myterm->name, 'slug' => $myterm->slug, 'coloredImg' => $term_img, 'image' => $term_img2 ];
						}
		}
		
		// $return['police_station'] = $return_station;
		
		$json = json_encode($return_station);
		return $return_station;
	  }
		
			function get_manufacturer_callback( $params ) {
					$mymanfacturer = new WP_Query(array(
						'post_type'		=> 'manufacturer',
						'posts_per_page' => -1 ))	;

					$return_manufacturer = [];
					if( $mymanfacturer->have_posts()):
						while( $mymanfacturer->have_posts() ) : $mymanfacturer->the_post();

						$eng_name= get_field('english_title');
						if($eng_name == null){
							$eng_name= "";
						}
						if($image == false){
							$image= "";
						}
						$return_manufacturer[] = ['id' => get_the_ID(), 'name' => get_the_title(), 'image' => $image, 'eng_name' => $eng_name];
						
					endwhile; endif;
					wp_reset_postdata();
				
					return $return_manufacturer;
			}
		
		function get_page_info_callback( $params){
				$sectionName = $params->get_param('sectionName');

				$return_page_info=[];

				if($sectionName == 'home_banner' ){
					$page_ID = get_option( 'page_on_front' );
					if(have_rows('slider', $page_ID)):
						while(have_rows('slider', $page_ID)): the_row();

						$button_link = get_sub_field('button_link');
						$image= get_sub_field('image');
						if(!$image){
							$image = "";
						}
						if(!$button_link){
							$button_link = "";
						}
							$return_page_info[] = [
								'image' => $image,
								'small_quotes' => get_sub_field('small_quotes'),
								'longer_quotes' => get_sub_field('longer_quotes'),
								'longer_quotes2' => get_sub_field('longer_quotes2'),
								'button_link' => $button_link
							];
					endwhile; endif;
				}
			
			elseif($sectionName == 'home_cat_icons'){
					$page_ID = get_option( 'page_on_front' );
					$cat_terms = get_field('category_icon_section', $page_ID);
              if( $cat_terms ): 

              foreach( $cat_terms as $cat_term ): 
				$thumbnail_id  = (int) get_woocommerce_term_meta( $cat_term->term_id, 'thumbnail_id', true ); 
				$thumbnail_id2  = (int) get_woocommerce_term_meta( $cat_term->term_id, 'colored_image', true ); 
				$cat_image  = wp_get_attachment_url( $thumbnail_id );
				$cat_colored_image = wp_get_attachment_url( $thumbnail_id2 );

				$cat_image = $this->nullValidation($cat_image);
				$cat_colored_image = $this->nullValidation($cat_colored_image);

				$return_page_info[] =[
					'id' => $cat_term->term_id,
					'name' => $cat_term->name,
					'image' => $cat_image,
					'colored_image' => $cat_colored_image
				];

			  endforeach; endif;

				}
			
			elseif($sectionName == 'home_feature_category'){
					$page_ID = get_option( 'page_on_front' );
					

					$terms = get_field('feature_category', $page_ID);

					if( $terms ):
						foreach( $terms as $term ):
							$thumbnail_id  = (int) get_woocommerce_term_meta( $term->term_id, 'colored_image', true );
							$term_img  = wp_get_attachment_url( $thumbnail_id );

							$term_img = $this->nullValidation($term_img);
							$return_page_info[] = [
								'id' => $term->term_id,
								'name' => $term->name,
								'image' => $term_img
							];
						endforeach; endif;


				}
			
			elseif($sectionName == 'home_featured_product'){
					$page_ID = get_option( 'page_on_front' );
					if($params->has_param('userEmail')){
						$userEmail = $params->get_param('userEmail');
					}else{
						$userEmail = null;
					}
					$loop = new WP_Query(array(
						'posts_per_page' => 9,
							'post_type'  => 'product',
							'orderby' => 'date', 
							'order' => 'DESC',
							 'tax_query' => array( array(
											  'taxonomy' => 'product_visibility',
											  'field'    => 'name',
											  'terms'    => 'featured',
											  'operator' => 'IN', // or 'NOT IN' to exclude feature products
												  ),
								),
			
							));
							$counter = 1;
								if ($loop->have_posts()) :
									while ($loop->have_posts()) : $loop->the_post();

									$amount = $originalPrice = get_post_meta(get_the_ID(), '_regular_price', true);
									$product_img = get_the_post_thumbnail_url(); 
									$sku = get_post_meta(get_the_ID(), '_sku', true);

									if($userEmail){
										global $wpdb;
										$table = $wpdb->prefix . 'fuji_discount';

										$results = $wpdb->get_results("
													SELECT * 
													FROM  $table
													WHERE customer_email = '{$userEmail}'
													AND product_sku = '{$sku}'
												");
										if (!empty($results)) {
											foreach ($results as $result) {
												$rateType = $result->discount_type;
												$rate = $result->discount;
												if ($rateType == 'Percentage') {
													$original = $originalPrice;
													$newRate = $original * ($rate / 100);
												} else {
													$newRate = $rate;
												}
												$amount = ($originalPrice - $newRate);
											}
										} else {
											$amount = $originalPrice;
										}

									}

									$amount = $this->nullValidation($amount);

									
									$product_img = $this->nullValidation($product_img);
				
									$janCode = get_post_meta( get_the_ID(), 'ywbc_barcode_display_value_custom_field');
							if(!empty($janCode)){
								$janDisplay = $janCode[0];

							}
							else{
								$janDisplay = "";
							}
							$manufacturer = get_field('manufacturer');
								global $product;
							$tags = $product->tag_ids;
							$tagArray = [];
							foreach($tags as $tag) {
							$tagArray[] = get_term($tag )->name;
							};
							$displayTag = implode(", ",$tagArray);

							$tax_rates = WC_Tax::get_rates( $product->get_tax_class() );
							
							foreach($tax_rates as $tax_rate){
								$tax_percentage = $tax_rate["rate"];
							}

										$return_page_info[] = [
											'id' => get_the_ID(),
											'name' => get_the_title(),
											'image' => $product_img,
											'amount' => $amount,
											'taxPercentage' => $tax_percentage,
											'sku' => $sku,
											'manufacturer' => $manufacturer,
											'tags' => $displayTag,
											'janCode' => $janDisplay
										];
								endwhile; endif;
								wp_reset_postdata(); 

				}
			elseif($sectionName == 'home_top_manufacturer'){
					$page_ID = get_option( 'page_on_front' );

					$package_posts = get_field('manufacturer', $page_ID);
					if( $package_posts): 
					foreach( $package_posts as $package_post ): 

					$image= get_the_post_thumbnail_url($package_post->ID);
					$image = $this->nullValidation($image);

					$english_name= get_field('english_title', $package_post->ID);
					$english_name = $this->nullValidation($english_name);

					$return_page_info[] = [
						'id' => $package_post->ID,
						'name' => get_the_title($package_post->ID),
						'image' => $image,
						'eng_name' => $english_name
					];
					
					endforeach; 
					endif;
				}
			
			elseif($sectionName == 'home_new_products'){
					$page_ID = get_option( 'page_on_front' );
					if($params->has_param('userEmail')){
						$userEmail = $params->get_param('userEmail');
					}else{
						$userEmail = null;
					}

					$latest_product = new WP_Query( array(
					    'posts_per_page' => 4,
						'post_type'	=> 'product',
						'order' => 'DESC',
						'orderby' => 'date',
						 
						 ) ); 

						 if( $latest_product->have_posts()):
							while( $latest_product->have_posts() ) : $latest_product->the_post();

							$image = get_the_post_thumbnail_url();
							$image = $this->nullValidation($image);
							$amount = $originalPrice = get_post_meta(get_the_ID(), '_regular_price', true);
							$sku = get_post_meta(get_the_ID(), '_sku', true);
							if($userEmail){
								global $wpdb;
								$table = $wpdb->prefix . 'fuji_discount';

								$results = $wpdb->get_results("
											SELECT * 
											FROM  $table
											WHERE customer_email = '{$userEmail}'
											AND product_sku = '{$sku}'
										");
								if (!empty($results)) {
									foreach ($results as $result) {
										$rateType = $result->discount_type;
										$rate = $result->discount;
										if ($rateType == 'Percentage') {
											$original = $originalPrice;
											$newRate = $original * ($rate / 100);
										} else {
											$newRate = $rate;
										}
										$amount = ($originalPrice - $newRate);
									}
								} else {
									$amount = $originalPrice;
								}

							}
							$amount = $this->nullValidation($amount);

							$janCode = get_post_meta( get_the_ID(), 'ywbc_barcode_display_value_custom_field');
							if(!empty($janCode)){
								$janDisplay = $janCode[0];

							}
							else{
								$janDisplay = "";
							}
							$manufacturer = get_field('manufacturer');
								global $product;
							$tags = $product->tag_ids;
							$tagArray = [];
							foreach($tags as $tag) {
							$tagArray[] = get_term($tag )->name;
							};
							$displayTag = implode(", ",$tagArray);

							$tax_rates = WC_Tax::get_rates( $product->get_tax_class() );
							
							foreach($tax_rates as $tax_rate){
								$tax_percentage = $tax_rate["rate"];
							}
							

							$return_page_info[] = [
								'id' => get_the_ID(),
								'name' => get_the_title(),
								'image' => $image,
								'amount' => $amount,
								'taxPercentage' => $tax_percentage,
								'sku' => $sku,
								'manufacturer' => $manufacturer,
								'tags' => $displayTag,
								'janCode' => $janDisplay

							];

						endwhile; endif;
						wp_reset_postdata();
				}

				return $return_page_info;

			}
		
		  function get_discount_callback( WP_REST_Request $request ) {
		  		
			$params_array = $request->get_json_params();
			$productSku = $request->get_param('sku');
			$currentUserEmail = $request->get_param('userEmail');
			$originalPrice = $request->get_param('originalPrice');
			  
			 
		
			global $wpdb;
			$table = $wpdb->prefix . 'fuji_discount';

			$results = $wpdb->get_results("
						SELECT * 
						FROM  $table
						WHERE customer_email = '{$currentUserEmail}'
						AND product_sku = '{$productSku}'
					");
			if (!empty($results)) {
				foreach ($results as $result) {
					$rateType = $result->discount_type;
					$rate = $result->discount;
					if ($rateType == 'Percentage') {
						$original = $originalPrice;
						$newRate = $original * ($rate / 100);
					} else {
						$newRate = $rate;
					}
					return ($originalPrice - $newRate);
				}
			} else {
				return $originalPrice;
			}
			  
		  }

		function get_product_detail_callback( $params){
			$productID = $params->get_param('productID');

			if($params->has_param('userEmail')){
				$userEmail = $params->get_param('userEmail');
			}else{
				$userEmail = null;
			}

			$latest_product = new WP_Query( array(
				'posts_per_page' => 1,
				'post_type'	=> 'product',
				'order' => 'DESC',
				'orderby' => 'date',
				'p' => $productID,
				 
				 ) ); 

				 if( $latest_product->have_posts()):
					while( $latest_product->have_posts() ) : $latest_product->the_post();

					$image = get_the_post_thumbnail_url();
					$image = $this->nullValidation($image);
					$amount = $originalPrice = get_post_meta(get_the_ID(), '_regular_price', true);
					$sku = get_post_meta(get_the_ID(), '_sku', true);
					if($userEmail){
						global $wpdb;
						$table = $wpdb->prefix . 'fuji_discount';

						$results = $wpdb->get_results("
									SELECT * 
									FROM  $table
									WHERE customer_email = '{$userEmail}'
									AND product_sku = '{$sku}'
								");
						if (!empty($results)) {
							foreach ($results as $result) {
								$rateType = $result->discount_type;
								$rate = $result->discount;
								if ($rateType == 'Percentage') {
									$original = $originalPrice;
									$newRate = $original * ($rate / 100);
								} else {
									$newRate = $rate;
								}
								$amount = ($originalPrice - $newRate);
							}
						} else {
							$amount = $originalPrice;
						}

					}
					$amount = $this->nullValidation($amount);

					$janCode = get_post_meta( get_the_ID(), 'ywbc_barcode_display_value_custom_field');
					if(!empty($janCode)){
						$janDisplay = $janCode[0];

					}
					else{
						$janDisplay = "";
					}
					$manufacturer = get_field('manufacturer');
						global $product;
					$tags = $product->tag_ids;
					$tagArray = [];
					foreach($tags as $tag) {
					$tagArray[] = get_term($tag )->name;
					};
					$displayTag = implode(", ",$tagArray);

					$tax_rates = WC_Tax::get_rates( $product->get_tax_class() );
					
					foreach($tax_rates as $tax_rate){
						$tax_percentage = $tax_rate["rate"];
					}
					

					$return_page_info[] = [
						'id' => get_the_ID(),
						'name' => get_the_title(),
						'image' => $image,
						'amount' => $amount,
						'taxPercentage' => $tax_percentage,
						'sku' => $sku,
						'manufacturer' => $manufacturer,
						'tags' => $displayTag,
						'janCode' => $janDisplay

					];

				endwhile; endif;
				wp_reset_postdata();

				return $return_page_info;
		}

		function get_allproduct_detail_callback( $params){
			
			if($params->has_param('userEmail')){
				$userEmail = $params->get_param('userEmail');
			}else{
				$userEmail = null;
			}

			$arg = array(
				'posts_per_page' => 1,
				'post_type'	=> 'product',
				'order' => 'DESC',
				'orderby' => 'date'
								 
			);

			if($params->has_param('pageNo')){
				$currentPage = $params->get_param('pageNo');
			}
			else{
				$currentPage = 1;
			}
			$arg['paged']  = $currentPage;
			$latest_product = new WP_Query( $arg); 

				 if( $latest_product->have_posts()):
					while( $latest_product->have_posts() ) : $latest_product->the_post();

					$image = get_the_post_thumbnail_url();
					$image = $this->nullValidation($image);
					$amount = $originalPrice = get_post_meta(get_the_ID(), '_regular_price', true);
					$sku = get_post_meta(get_the_ID(), '_sku', true);
					if($userEmail){
						global $wpdb;
						$table = $wpdb->prefix . 'fuji_discount';

						$results = $wpdb->get_results("
									SELECT * 
									FROM  $table
									WHERE customer_email = '{$userEmail}'
									AND product_sku = '{$sku}'
								");
						if (!empty($results)) {
							foreach ($results as $result) {
								$rateType = $result->discount_type;
								$rate = $result->discount;
								if ($rateType == 'Percentage') {
									$original = $originalPrice;
									$newRate = $original * ($rate / 100);
								} else {
									$newRate = $rate;
								}
								$amount = ($originalPrice - $newRate);
							}
						} else {
							$amount = $originalPrice;
						}

					}
					$amount = $this->nullValidation($amount);

					$janCode = get_post_meta( get_the_ID(), 'ywbc_barcode_display_value_custom_field');
					if(!empty($janCode)){
						$janDisplay = $janCode[0];

					}
					else{
						$janDisplay = "";
					}
					$manufacturer = get_field('manufacturer');
						global $product;
					$tags = $product->tag_ids;
					$tagArray = [];
					foreach($tags as $tag) {
					$tagArray[] = get_term($tag )->name;
					};
					$displayTag = implode(", ",$tagArray);

					$tax_rates = WC_Tax::get_rates( $product->get_tax_class() );
					
					foreach($tax_rates as $tax_rate){
						$tax_percentage = $tax_rate["rate"];
					}
					

					$return_page_info[] = [
						'id' => get_the_ID(),
						'name' => get_the_title(),
						'image' => $image,
						'amount' => $amount,
						'taxPercentage' => $tax_percentage,
						'sku' => $sku,
						'manufacturer' => $manufacturer,
						'tags' => $displayTag,
						'janCode' => $janDisplay

					];

				endwhile; endif;
				wp_reset_postdata();

				return $return_page_info;
		}

		
		
		function nullValidation($nullValue){
				if(!$nullValue){
					$returnValue = "";
				}
				else{
					$returnValue = $nullValue;
				}

				return $returnValue;
			}
		
	}
	
	new MyAPI();
	}
