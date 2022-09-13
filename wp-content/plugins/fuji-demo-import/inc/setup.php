<?php

/**
 * rws demo setup
 */

class RwsDemoSetup
{

	function __construct()
	{
		add_action('admin_menu', array($this, 'menu'));
		add_action('admin_enqueue_scripts', array($this, 'style_scripts'));
		add_action('wp_ajax_rws_demo_install_plugin', array($this, 'rws_install_plugin'));
		ini_set('max_execution_time', 1200);
	}

	function menu()
	{

		global $page_hook_suffix;

		$page_hook_suffix = add_theme_page(__('Fuji Discount Import', 'rws-demo-import'), __('Fuji Discount Import', 'rws-demo-import'), 'upload_files', 'fuji-demo-import', array($this, 'screen'));
	}

	function style_scripts($hook)
	{

		global $page_hook_suffix;


		$data = array(
			'ajaxurl' => admin_url('admin-ajax.php'),
		);


		//return if not option page
		if ($hook == $page_hook_suffix) :

			//enqueue bootstrap to option page
			wp_register_style('view_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css');
			wp_enqueue_style('view_bootstrap');
			wp_enqueue_style('rws-demo-style', RWS_DEMO_IMPORT_URL . '/inc/assets/css/style.css');
			wp_enqueue_script('rws-demo-bsjs', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', array('jquery'), '', true);
			wp_enqueue_style('bootstrap-datatable-style', 'https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css', array(), '', false);
			wp_enqueue_style('bootstrap-datatable-select', 'https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css', array(), '', false);
			wp_enqueue_script('datatable-script', 'https://cdn.datatables.net/v/dt/dt-1.10.22/fc-3.3.1/fh-3.1.7/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/datatables.min.js', array(), '', true);
			wp_enqueue_script('bootstrap-datatable-script', 'https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js', array(), '', true);
			wp_enqueue_script('rws-demo-import', RWS_DEMO_IMPORT_URL . '/inc/assets/js/rws-demo-import.js', array('jquery'), '1.0', true);
			wp_localize_script('rws-demo-import', 'rws_demo_import_object', $data);
		endif;
	}


	function rws_install_plugin()
	{
		$csvFile = $_FILES['discountCSV'];
		$attach_id = $this->uploadFile($_FILES['discountCSV']);
		$fullsize_path = get_attached_file($attach_id);
		$file = fopen($fullsize_path, "r");
		$count = 1;
		while (!feof($file)) {
			$csvDatas = fgetcsv($file);
			if ($count > 1 && !empty($csvDatas)) {
				echo '<tr>';
				foreach ($csvDatas as $csvData) {
					echo '<td>';
					print_r($csvData);
					echo  '</td>';
				}
				echo '</tr>';
			}
			$count++;
		}

		fclose($file);
		die();
	}

	function uploadFile($file)
	{
		if (!function_exists('wp_handle_upload')) {
			require_once(ABSPATH . 'wp-admin/includes/file.php');
		}
		$movefile = wp_handle_upload($file, array('test_form' => false));

		if ($movefile && !isset($movefile['error'])) {

			$wp_upload_dir = wp_upload_dir();
			$attachment    = array(
				'guid' => $wp_upload_dir['url'] . '/' . basename($movefile['file']),
				'post_mime_type' => $movefile['type'],
				'post_title' => preg_replace('/\.[^.]+$/', '', basename($movefile['file'])),
				'post_content' => '',
				'post_status' => 'inherit'
			);
			$attach_id     = wp_insert_attachment($attachment, $movefile['file']);

			return $attach_id;
		}
	}


	function screen()
	{

		include RWS_DEMO_IMPORT_PATH . '/admin/view.php';

?>
<div class="ajax-loader">

    <div class="loader"></div>

</div>

<div id="div1" class="container result">

</div>


<?php
	}
}

$rws_demo_setup = new RwsDemoSetup();