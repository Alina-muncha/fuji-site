<?php

/*
  Plugin Name: WooCommerce Product Variations Popup
  Plugin URI:  https://developer.wordpress.org/plugins/woocommerce-product-variations-popup/
  Description: This plugin provides the functionality to select product options on the product listing page in a popup.
  Version:     1.0
  Author:      CodiMinds
  Author URI:  https://profiles.wordpress.org/codiminds
  License:     GPL2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Getting the value set by user for the popup.
 * 
 * By default set to true.
 */
$WPVP_popup = get_option('WPVP_popup', true);

/**
 * Loading admin functions file.
 */
include( plugin_dir_path(__FILE__) . 'admin.php');

/**
 *  Registering script and style for the front end. 
 */
function WPVP_register_assets() {
    wp_register_script('WPVP_script', plugins_url('/js/wpvp.js', __FILE__), array ('jquery'));
    wp_register_style('WPVP_style', plugins_url('/css/wpvp.css', __FILE__));
}

/**
 *  Utilize the registered scripts and styles.
 */
function WPVP_enqueue_assets() {
    wp_enqueue_script('WPVP_script');
    wp_enqueue_style('WPVP_style');
}

/**
 *  Initializing popups container.
 */
function WPVP_initiate_popup_container() {
    echo '<div class="wpvp-popups-container"></div>';
}

/**
 *  Alter select options button and add popup for each product.
 */
function WPVP_alter_options_button($quantity, $product) {
//    global $product_id, $product;
    if ($product->is_type('variable')) {
        $product_id = $product->get_id();
        $product_url = get_permalink($product_id);
        $WPVP_button_text = get_option('WPVP_button_text', 'Select Options');
        $new_button = '<a href="' . $product_url . '" data-product_id="' . $product_id . '" class="wpvp-options button product_type_variable add_to_cart_button">' . esc_html($WPVP_button_text) . '</a>';
        include( plugin_dir_path(__FILE__) . 'popup.php');
        return $new_button;
    }
    return $quantity;
}

if ($WPVP_popup == 'true' && in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_filter('woocommerce_loop_add_to_cart_link', 'WPVP_alter_options_button', 10, 2);
    add_action('init', 'WPVP_register_assets');
    add_action('wp_enqueue_scripts', 'WPVP_enqueue_assets');
    add_action('wp_footer', 'WPVP_initiate_popup_container');
}