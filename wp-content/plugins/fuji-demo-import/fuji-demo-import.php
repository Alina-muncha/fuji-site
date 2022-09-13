<?php

/**
 * Plugin Name: Fuji Discount Import
 * Plugin URI:  
 * Description: Fuji plugin for importing user based discount.
 * Version: 1.0.0
 * Author: Alwin Kansakar
 * Author URI: 
 * Text Domain: fuji-discount-import
 */

/**
 * @package RWS Demo Import
 */

if (!defined('ABSPATH')) {
	exit();
}

class RwsDemoImport
{

	public function includes()
	{

		if (!defined('RWS_DEMO_IMPORT_PATH')) {
			define('RWS_DEMO_IMPORT_PATH', plugin_dir_path(__FILE__));
		}
		if (!defined('RWS_DEMO_IMPORT_URL')) {
			define('RWS_DEMO_IMPORT_URL', plugins_url('', __FILE__));
		}
		if (!defined('RWS_DEMO_IMPORT_FILE_PATH')) :
			define('RWS_DEMO_IMPORT_FILE_PATH', RWS_DEMO_IMPORT_PATH . 'inc/assets/demo-files/');
		endif;
		if (!defined('RWS_DEMO_CONTENT_PATH')) :
			define('RWS_DEMO_CONTENT_PATH', get_template_directory() . '/demo-content/');
		endif;
	}

	public function import_start()
	{

		include RWS_DEMO_IMPORT_PATH . 'inc/setup.php';
	}
}

if (class_exists('RwsDemoImport')) {

	$rws_demo_import = new RwsDemoImport();
	$rws_demo_import->includes();
	$rws_demo_import->import_start();
}