<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://themehigh.com
 * @since      1.0.0
 *
 * @package    themehigh-multiple-addresses
 * @subpackage themehigh-multiple-addresses/admin
 */
if(!defined('WPINC')) { 
    die; 
}

if(!class_exists('THMAF_Admin')):
 
    /**
     * Admin class.
    */
    class THMAF_Admin {
        private $plugin_name;
        private $version;

        /**
         * Initialize the class and set its properties.
         *
         * @param      string    $plugin_name       The name of this plugin.
         * @param      string    $version    The version of this plugin.
         */
        public function __construct($plugin_name, $version) {
            $this->plugin_name = $plugin_name;
            $this->version = $version;
            $this->plugin_pages = array(
                'woocommerce_page_th_multiple_addresses_free', 'user-edit.php', 'profile.php'
            );
        }
        
        /**
         * Enqueue style and script.
         *
         * @param string $hook The screen id
         *
         * @return void
         */
        public function enqueue_styles_and_scripts($hook) {
            if(!in_array($hook, $this->plugin_pages)) {
                return;
            }

            $screen = get_current_screen();
            $debug_mode = apply_filters('thmaf_debug_mode', false);
            $suffix = $debug_mode ? '' : '.min';        
            $this->enqueue_styles($suffix);
            $this->enqueue_scripts($suffix);
        }
        
        /**
         * Enqueue style.
         *
         * @param string $suffix The suffix of style sheets
         *
         * @return void
         */
        public function enqueue_styles($suffix) {
            wp_enqueue_style('woocommerce_admin_styles', THMAF_WOO_ASSETS_URL.'css/admin.css');
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_style('thmaf-admin-style', THMAF_ASSETS_URL_ADMIN . 'css/thmaf-admin'. $suffix .'.css', $this->version);
        }

        /**
         * Enqueue script.
         *
         * @param string $suffix The suffix of js file
         *
         * @return void
         */
        public function enqueue_scripts($suffix) {
            $deps = array('jquery', 'jquery-ui-dialog', 'jquery-ui-sortable', 'jquery-tiptip', 'wc-enhanced-select', 'select2', 'wp-color-picker');
            
            wp_enqueue_script('thmaf-admin-script', THMAF_ASSETS_URL_ADMIN . 'js/thmaf-admin'. $suffix .'.js', $deps, $this->version, false);
            
            $script_var = array(
                'admin_url' => admin_url(),
                'ajaxurl'   => admin_url('admin-ajax.php'),
            );
            wp_localize_script('thmaf-admin-script', 'thmaf_var', $script_var);
        }

        /**
         * Function for set capability.
         *
         *
         * @return string
         */
        public function thmaf_capability() {
            $allowed = array('manage_woocommerce', 'manage_options');
            $capability = apply_filters('thmaf_required_capability', 'manage_options');

            if(!in_array($capability, $allowed)) {
                $capability = 'manage_woocommerce';
            }
            return $capability;
        }
        
        /**
         * Function for set admin menu.
         *
         *
         * @return void
         */
        public function admin_menu() {
            $capability = $this->thmaf_capability();
            $this->screen_id = add_submenu_page('woocommerce', esc_html__('WooCommerce Multiple Addresses', 'themehigh-multiple-addresses'), esc_html__('Manage Address', 'themehigh-multiple-addresses'), $capability, 'th_multiple_addresses_free', array($this, 'output_settings'));
        }
        
        /**
         * Function for setting screen id.
         *
         * @param string $ids The unique screen id
         *
         * @return string
         */
        public function add_screen_id($ids) {
            $ids[] = 'woocommerce_page_th_multiple_addresses_free';
            $ids[] = strtolower(THMAF_i18n::__t('WooCommerce')) .'_page_th_multiple_addresses_free';

            return $ids;
        }

        /**
         * function for setting link.
         *
         * @param string $links The plugin action link
         *
         * @return void
         */
        public function plugin_action_links($links) {
            $settings_link = '<a href="'.admin_url('admin.php?&page=th_multiple_addresses_free').'">'. esc_html__('Settings', 'woocommerce-multiple-addresses-pro') .'</a>';
            array_unshift($links, $settings_link);
            return $links;
        }
        
        /**
         * Function for premium version notice.
         *
         *
         * @return void
         */
        private function _output_premium_version_notice() { ?>
            <div id="message" class="wc-connect updated thpladmin-notice thmaf-admin-notice">
                <div class="squeezer">
                    <table>
                        <tr>
                            <td width="70%">
                                <!-- <p><strong><i>WooCommerce Multiple addresses Pro</i></strong> premium version provides more features to setup your checkout page and cart page.</p> -->
                                <p>
                                    <strong><i><a href="https://www.themehigh.com/product/woocommerce-multiple-addresses-pro/">
                                        <?php echo esc_html__('WooCommerce Multiple addresses', 'themehigh-multiple-addresses');?>

                                    </a></i></strong><?php echo esc_html__('premium version provides more features to manage the users addresses.', 'themehigh-multiple-addresses'); ?>
                                    <ul>
                                    <li>
                                    <?php echo esc_html__('Let Your Shoppers Choose from a List of Saved Addresses', 'themehigh-multiple-addresses'); ?>
                                    </li>
                                    <li>
                                    <?php echo esc_html__('Manage All Addresses from My Account Page', 'themehigh-multiple-addresses'); ?>
                                        
                                    </li>
                                    <li>
                                        <?php echo esc_html__('Save Time with Google Autocomplete Feature', 'themehigh-multiple-addresses'); ?>
                                    </li>
                                    <li>
                                        <?php echo esc_html__('Custom Address Formats through Overriding', 'themehigh-multiple-addresses'); ?>
                                    </li>
                                    <li>
                                        <?php echo esc_html__('Display Your Multiple Address Layouts in Style', 'themehigh-multiple-addresses'); ?> 
                                    </li>
                                    <li>
                                        <?php echo esc_html__('Highly Compatible with', 'themehigh-multiple-addresses'); ?> 
                                            <strong><i><a href="https://www.themehigh.com/product/woocommerce-checkout-field-editor-pro/">
                                                <?php echo esc_html__('WooCommerce Checkout Field Editor', 'themehigh-multiple-addresses'); ?>
                                            </a></i></li>
                                    </ul>
                            </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        <?php }

        /**
         * function for output settings.
         *
         * @return void
         */
        public function output_settings() {
            $this->_output_premium_version_notice();
            $tab  = isset($_GET['tab']) ? sanitize_key($_GET['tab']) : 'general_settings';
            if($tab ==='general_settings') {
                $general_settings = THMAF_Admin_Settings_General::instance();   
                $general_settings->render_page();
            }
        }
    }
endif;