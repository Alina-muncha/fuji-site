<?php

include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader-skin.php' );

class Rws_Demo_Setup_Before_Import{

	public function __construct() {
		add_filter( 'before_theme_setup', array( $this, 'predefined_demo_options'), 5);
	}

	function predefined_demo_options(){
		$demo_options = array(
	        array(
	            'import_file'                => 'No File',
	            'categories'                 => 'category-1',
	            'import_file_url'            => '',
	            'import_customizer_file_url' =>	'',
	            'import_widget_file_url' 	 => '',
	            'import_preview_image_url'   => RWS_DEMO_IMPORT_URL.'/inc/assets/demo-files/demo-1/image.jpg',
	        ),

		);

		return($demo_options);
	}


	/**
      * Reset existing active widgets.
      */
    function reset_widgets() {
        $sidebars_widgets = wp_get_sidebars_widgets();

        // Reset active widgets.
        foreach ( $sidebars_widgets as $key => $widgets ) {
                $sidebars_widgets[ $key ] = array();
        }

        wp_set_sidebars_widgets( $sidebars_widgets );
    }

    /**
       * Delete existing navigation menus.
       */
    function delete_nav_menus() {
        $nav_menus = wp_get_nav_menus();

        // Delete navigation menus.
        if ( ! empty( $nav_menus ) ) {
            foreach ( $nav_menus as $nav_menu ) {
                wp_delete_nav_menu( $nav_menu->slug );
            }
        }
    }

    function before_demo_import() {
        $this->reset_widgets();
        $this->delete_nav_menus();

        //Deleting default post and pages before importing start
        wp_delete_post(1);

		wp_delete_post(2);
		
		wp_delete_post(3);
		
        /**
          * Remove theme modifications option.
          */
        //remove_theme_mods();
    }

}

class Quiet_Skin extends WP_Upgrader_Skin {
    public function feedback($string)
    {
        // just keep it quiet
    }
}



function rws_get_plugins($plugin)
{
    
            rws_plugin_download( $plugin['name'] );
            rws_plugin_activate($plugin['install']);
}
function rws_plugin_download($pluguin_name){
    include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' ); //for plugins_api..

    $plugin = $pluguin_name;

    $api = plugins_api( 'plugin_information', array(
        'slug' => $plugin,
        'fields' => array(
            'short_description' => false,
            'sections' => false,
            'requires' => false,
            'rating' => false,
            'ratings' => false,
            'downloaded' => false,
            'last_updated' => false,
            'added' => false,
            'tags' => false,
            'compatibility' => false,
            'homepage' => false,
            'donate_link' => false,
        ),
    ));

    //includes necessary for Plugin_Upgrader and Plugin_Installer_Skin
    include_once( ABSPATH . 'wp-admin/includes/file.php' );
    include_once( ABSPATH . 'wp-admin/includes/misc.php' );
    include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
    
    $upgrader = new Plugin_Upgrader( new Quiet_Skin() );

    $upgrader->install($api->download_link);

}

function rws_plugin_activate($installer)
{
    $current = get_option('active_plugins');
    $plugin = plugin_basename(trim($installer));

    if(!in_array($plugin, $current))
    {
            $current[] = $plugin;
            sort($current);
            do_action('activate_plugin', trim($plugin));
            update_option('active_plugins', $current);
            do_action('activate_'.trim($plugin));
            do_action('activated_plugin', trim($plugin));
            return true;
    }
    else
            return false;
}



