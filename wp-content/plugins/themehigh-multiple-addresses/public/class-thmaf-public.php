<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://themehigh.com
 * @since      1.0.0
 *
 * @package    themehigh-multiple-addresses
 * @subpackage themehigh-multiple-addresses/public
 */

if(!defined('WPINC')) { 
    die; 
}

if(!class_exists('THMAF_Public')) :

    /**
     * Public class.
    */
    class THMAF_Public {
        private $plugin_name;
        private $version;

        /**
         * function for define public hook.
         *
         * @param string $plugin_name The name of the plugin
         * @param string $version The version of the plugin
         *
         * @return void
         */
        public function __construct($plugin_name, $version) {
            $this->plugin_name = $plugin_name;
            $this->version = $version;
            add_action('after_setup_theme', array($this, 'define_public_hooks'));
        
        }

        /**
         * Function for enqueue style and script.
         *
         * @return void
         */
        public function enqueue_styles_and_scripts() {
            global $wp_scripts;
            if(is_wc_endpoint_url('edit-address')|| (is_checkout())) {
                $debug_mode = apply_filters('thmaf_debug_mode', false);
                $suffix = $debug_mode ? '' : '.min';
                $jquery_version = isset($wp_scripts->registered['jquery-ui-core']->ver) ? $wp_scripts->registered['jquery-ui-core']->ver : '1.9.2';
                
                $this->enqueue_styles($suffix, $jquery_version);
                $this->enqueue_scripts($suffix, $jquery_version);
            }
        }
        
        /**
         * function for enqueue style.
         *
         * @param string $suffix The suffix name of the stylesheet file
         * @param string $jquery_version The version of the jquery file
         *
         * @return void
         */
        private function enqueue_styles($suffix, $jquery_version) {
            wp_register_style('select2', THMAF_WOO_ASSETS_URL.'/css/select2.css');
            wp_enqueue_style('woocommerce_frontend_styles');
            wp_enqueue_style('select2');
            wp_enqueue_style('dashicons');
            wp_enqueue_style('thmaf-public-style', THMAF_ASSETS_URL_PUBLIC . 'css/thmaf-public'. $suffix .'.css', $this->version);
        }

        /**
         * function for enqueue script.
         *
         * @param string $suffix The suffix name of the js file
         * @param string $jquery_version The version of the jquery file
         *
         * @return void
         */
        private function enqueue_scripts($suffix, $jquery_version) {
            wp_register_script('thmaf-public-script', THMAF_ASSETS_URL_PUBLIC . 'js/thmaf-public'. $suffix .'.js', array('jquery', 'jquery-ui-dialog', 'jquery-ui-accordion', 'select2',), $this->version, true);       
            wp_enqueue_script('thmaf-public-script','dashicons');
            $address_fields_billing = '';
            $address_fields_billing = $this->get_address_fields_by_address_key('billing_');
            $address_fields_shipping = '';
            $address_fields_shipping = $this->get_address_fields_by_address_key('shipping_');

            $store_country = array();
            $store_country = WC()->countries->get_base_country(); 
            $sell_countries = array();  
            $sell_countries =  WC()->countries->get_allowed_countries();
            $specific_coutries =  array();

            $script_var = array(
                'ajax_url'                  => admin_url('admin-ajax.php'),
                'ajax_nonce'                => wp_create_nonce('populate_address_nonce'),
                'address_fields_billing'    => $address_fields_billing,
                'address_fields_shipping'   => $address_fields_shipping,
                'store_country'             => $store_country,
                'sell_countries'            => $sell_countries,     
                'billing_address'           => esc_html__('Billing Addresses', 'themehigh-multiple-addresses'),
                'shipping_address'          => esc_html__('Shipping Addresses', 'themehigh-multiple-addresses'),
                'addresses'                 => esc_html__('Addresses', 'themehigh-multiple-addresses'),
            );
            wp_localize_script('thmaf-public-script', 'thmaf_public_var', $script_var);
        }
        
        /**
         * Function for define public hooks.
         *
         * @return void
         */
        public function define_public_hooks() {
            add_action('woocommerce_after_save_address_validation', array($this, 'save_address'), 10, 3);

            // My-account.
            add_action('thmaf_after_address_display', array($this, 'display_custom_addresses'));
            add_action('woocommerce_before_edit_account_address_form', array($this, 'delete_address'));
            add_action('woocommerce_before_edit_account_address_form', array($this, 'set_default_billing_address'));
            add_action('woocommerce_before_edit_account_address_form', array($this, 'set_default_shipping_address'));
            // Checkout.
            add_action('woocommerce_before_checkout_billing_form', array($this, 'session_update_billing'));
            add_action('woocommerce_before_checkout_shipping_form', array($this, 'session_update_shipping'));

            // Position to display multiple Billing address. 
            add_action('woocommerce_before_checkout_billing_form', array($this, 'address_above_billing_form'));
            if(!is_admin()){
                add_filter('woocommerce_checkout_fields', array($this, 'add_hidden_field_to_checkout_fields'));
            }
            add_filter('woocommerce_form_field_hidden', array($this, 'add_hidden_field'), 5, 4);
            add_action('woocommerce_checkout_order_processed', array($this, 'update_custom_billing_address_from_checkout'), 10, 3);

            // Position to display multiple Shipping address. 
            add_action('woocommerce_before_checkout_shipping_form', array($this, 'address_above_shipping_form'));
            add_action('woocommerce_checkout_order_processed', array($this, 'update_custom_shipping_address_from_checkout'), 10, 3);

            add_action('wp_ajax_get_address_with_id', array($this, 'get_addresses_by_id'));
            add_action('wp_ajax_nopriv_get_address_with_id', array($this, 'get_addresses_by_id'));

            add_action('woocommerce_after_checkout_validation', array($this, 'add_address_from_checkout'), 30, 2);
            add_filter('woocommerce_billing_fields', array($this, 'prepare_address_fields_before_billing'), 1500, 2);
            add_filter('woocommerce_shipping_fields', array($this, 'prepare_address_fields_before_shipping'), 1500, 2);         
        }

        /**
         * Function for get address key by using address key.
         *
         * @param string $type The address type
         *
         * @return array
         */
        public function get_address_fields_by_address_key($type) {
            $fields = WC()->countries->get_address_fields(WC()->countries->get_base_country(), $type);
            $fields_keys = array();
            if(!empty($fields) && is_array($fields)) {
                foreach($fields as $key => $value) {
                    if(isset($value['custom']) && $value['custom']) {
                        if(isset($value['user_meta'])) {
                            if($value['user_meta'] === 'yes') {
                                if(isset($value['type'])){
                                    if($value['type'] == 'checkboxgroup' || $value['type'] == 'radio') {            
                                        $options = array();
                                        $options['type'] = $value['type'];
                                        if(isset($value['options'])) {
                                            if(!empty($value['options']) && is_array($value['options'])) {
                                                foreach($value['options'] as $check_key => $check_value) {
                                                    if($value['type'] == 'checkboxgroup') {
                                                        $options[$key.'_'.$check_key] = 'checkbox';
                                                    }elseif($value['type'] == 'radio') {
                                                        $options[$key.'_'.$check_key] = 'radio';
                                                    }       
                                                }
                                            }
                                        }
                                        $fields_keys[$key] = $options;
                                    }else {
                                        $fields_keys[$key] = $value['type'];
                                    } 
                                }                       
                            }   
                        }
                    }else {
                        if(isset($value['type'])) {
                            $fields_keys[$key] = $value['type'];
                        }else {
                            $fields_keys[$key] = 'text';
                        }
                    }   
                }
            }
            return $fields_keys;
        }

        /**
         * Function for get address fields(static function).
         *
         * @param string $type The address type
         *
         * @return array
         */
        public static function get_address_fields($type) {
            $fields = WC()->countries->get_address_fields(WC()->countries->get_base_country(), $type.'_');
            $fields_keys = array_keys($fields);
            return $fields_keys;
        }

        /**
         * Function for set address template (Change address template).
         *
         * @param string $template The template name
         * @param string $template_name The template url
         * @param string $template_path The template path
         *
         * @return string
         */
        public function address_template($template, $template_name, $template_path) {           
            if('myaccount/my-address.php' == $template_name) {              
                $template = THMAF_TEMPLATE_URL_PUBLIC.'myaccount/my-address.php';   
            }
            return $template;
        }

        /**
         * Function for display custom addresses(My Account).
         *
         * @param integer $customer_id The user id
         *
         * @return void
         */
        public function display_custom_addresses($customer_id) {
            $enable_billing = THMAF_Utils::get_setting_value('settings_billing', 'enable_billing');
            $enable_shipping = THMAF_Utils::get_setting_value('settings_shipping', 'enable_shipping');

            $custom_addresses_billing = THMAF_Utils::get_addresses($customer_id, 'billing');        
            if(is_array($custom_addresses_billing)) {
                $billing_addresses = $this->get_account_addresses($customer_id, 'billing', $custom_addresses_billing);
            }
            $custom_addresses_shipping = THMAF_Utils::get_addresses($customer_id, 'shipping');
            if(is_array($custom_addresses_shipping)) {
                $shipping_addresses = $this->get_account_addresses($customer_id, 'shipping', $custom_addresses_shipping);
            }

            $theme_class_name = $this->check_current_theme();
            $theme_class =  $theme_class_name.'-acnt'; ?> 
            <div class= 'th-custom thmaf-my-acnt <?php echo esc_attr($theme_class); ?>'><?php 
                if($enable_billing == 'yes') {
                    if(empty($custom_addresses_billing)) {
                        $div_hide = 'thmaf_hide_div';
                    } else {
                        $div_hide = '';
                    } ?>                
                    <div class='thmaf-acnt-cus-addr th-custom-address <?php echo esc_attr($div_hide); ?>' >
                        <div class = 'th-head'><h3><?php esc_html_e('Additional billing addresses', 'themehigh-multiple-addresses'); ?> </h3></div>
                        <?php if($custom_addresses_billing) {
                            echo $billing_addresses; 
                        }else { ?>
                                <p><?php esc_html_e("There are no saved addresses yet ", 'themehigh-multiple-addresses'); ?> </p>
                        <?php } ?>
                    </div>
                <?php }
                if (! wc_ship_to_billing_address_only() && wc_shipping_enabled()) {
                    if($enable_shipping == 'yes') {
                        if(empty($custom_addresses_shipping)) {
                            $div_hide = 'thmaf_hide_div';
                        } else {
                            $div_hide = '';
                        } ?>                
                        <div class='thmaf-acnt-cus-addr th-custom-address <?php echo esc_attr($div_hide); ?> '>
                            <div class = 'th-head'><h3><?php esc_html_e("Additional shipping addresses", 'themehigh-multiple-addresses'); ?> </h3></div>
                            <?php if($custom_addresses_shipping) {
                                    echo $shipping_addresses;  
                            }else { ?>
                                <p><?php esc_html_e("There are no saved addresses yet ", 'themehigh-multiple-addresses'); ?> </p>
                            <?php } ?>
                        </div>
                    <?php }
                } ?>
            </div>      
        <?php }

        /**
         * Function for get addresses on my-account page.
         *
         * @param integer $customer_id The user id info
         * @param string $type The address type info
         * @param array $custom_addresses The custom addresses
         *
         * @return string
         */
        public function get_account_addresses($customer_id, $type, $custom_addresses) {     
            $return_html = '';
            $add_class='';
            $address_type = "'$type'";
            $address_limit = '2';

            if(!empty($custom_addresses)) {
                if(is_array($custom_addresses)) {
                    $add_list_class  = ($type == 'billing') ? " thmaf-thslider-list bill " : " thmaf-thslider-list ship";  
                    $return_html .= '<div class="thmaf-thslider">';
                    $return_html .= '<div class="thmaf-thslider-box">';
                    $return_html .= '<div class="thmaf-thslider-viewport '.esc_attr($type).'">';
                    $return_html .= '<ul id="thmaf-th-list" class="'.esc_attr($add_list_class).'">';
                    $i = 0;
                    if(is_array($custom_addresses)) {
                        foreach($custom_addresses as $name => $title) {
                            $default_heading = apply_filters('thmaf_default_heading', false);
                            
                            $address = THMAF_Utils::get_all_addresses($customer_id, $name);
                            $address_key = substr($name, strpos($name, "=") + 1);
                            $action_row_html = '';
                            $action_def_html = '';
                            $delete_msg = esc_html__('Are you sure you want to delete this address?', 'themehigh-multiple-addresses');
                            //$confirm = "return confirm(". $delete_msg .");";
                            $str_arr = preg_split ("/\?/", $name);
                            $str_arr1 = $str_arr[0];
                            $str_arr2 = $str_arr[1];
                            $str_arr_sec = preg_split ("/\=/", $str_arr2);
                            $str_arr_sec1 = $str_arr_sec[0];
                            $str_arr_sec2 = $str_arr_sec[1];
                            $query_arg = add_query_arg($str_arr_sec1, $str_arr_sec2, wc_get_endpoint_url('edit-address', $str_arr1));

                            $action_row_html .= '<div class="thmaf-acnt-adr-footer acnt-address-footer">';
                                $action_row_html .= '<form action="" method="post" name="thmaf_account_adr_delete_action">';                        
                                    $action_row_html.=  '<input type="hidden" name="account_adr_delete_action" value="'.wp_create_nonce('thmaf_account_adr_delete_action').'"> ';
                                    $action_row_html .=' <button type="submit" name="thmaf_del_addr"  class="thmaf-del-acnt th-del-acnt " title="Delete"  onclick="return confirm(\''. $delete_msg .'\');">'.esc_html__('Delete', 'themehigh-multiple-addresses').'</button>';
                                    $action_row_html .= '<input type="hidden" name="thmaf_deleteby" value="'.esc_attr($type.'_'. $address_key).'"/>';

                                $action_row_html .= '</form>';
                            $action_row_html .= '</div>';                

                            if($type == "billing") {
                                $action_def_html.=  ' <form action="" method="post" name="thmaf_billing_adr_default_action">';
                                $action_def_html.=  '<button type="submit" name="thmaf_default_bil_addr" id="submit-billing" class="primary button account-default thmaf-acnt-dflt"  >'.esc_html__('Set as default', 'themehigh-multiple-addresses').' </button> 
                                <input type="hidden" name="thmaf_bil_defaultby" value="'.esc_attr($type.'_'. $address_key).'"/>';

                                $action_def_html.=  '<input type="hidden" name="billing_adr_default_action" value="'.wp_create_nonce('thmaf_billing_adr_default_action').'"> ';
                                $action_def_html.=  '</form>';
                            }else { 
                                $action_def_html.= '<form action="" method="post" name="thmaf_shipping_adr_default_action">'; 
                                $action_def_html.=  '<input type="hidden" name="shipping_adr_default_action" value="'.wp_create_nonce('thmaf_shipping_adr_default_action').'"> ';
                                $action_def_html.=  '<button type="submit" name="thmaf_default_ship_addr" id="submit-shipping" class="primary button account-default thmaf-acnt-dflt" >'.esc_html__('Set as default', 'themehigh-multiple-addresses').'</button>';
                                $action_def_html.=  '<input type="hidden" name="thmaf_ship_defaultby" value="'.esc_attr($type.'_'. $address_key).'"/> </form>';
                            
                            }

                            $add_class = 'thmaf-thslider-item '.esc_attr($type);
                            $add_class .= $i == 0 ? ' first' : '';
                            $show_heading = '<div class="acnt-adrr-text thmaf-adr-text address-text address-wrapper wrapper-only">'.wp_kses_post($address).'</div>';
                            $return_html .= '<li class="'.esc_attr($add_class).'" value="'. esc_attr($address_key).'" >
                                <div class="thmaf-adr-box address-box" data-index="'.esc_attr($i).'" data-address-id=""> 
                                    <div class="thmaf-main-content"> 
                                        <div class="complete-aaddress">  
                                            '.$show_heading.'                                   
                                        </div>                          
                                        <div class="btn-continue address-wrapper">                              
                                            '.$action_def_html.'                                    
                                        </div> 
                                    </div>
                                        '.$action_row_html.'
                                </div>
                            </li>';
                            if($i >= $address_limit-1) {
                                break;
                            }
                            $i++;
                        }
                    }
                    $return_html .= '</ul>';
                    $return_html .= '</div>';
                    $return_html .= '</div>';
                    $return_html .= '<div class="control-buttons control-buttons-'.esc_attr($type).'">';
                    $return_html .= '</div>';
                    $return_html .= '</div>';
                }
            }
            return $return_html;
        }

        /**
         * Function for check the current activated theme.
         *
         * @return string
         */
        public function check_current_theme() {
            $current_theme = wp_get_theme();
            $current_theme_name = isset($current_theme['Template']) ? $current_theme['Template'] : '';
            $wrapper_class = '';
            $theme_class_name = '';
            if($current_theme_name) {
                $wrapper_class = str_replace(' ', '-', strtolower($current_theme_name));
                $theme_class_name = 'thmaf-'.esc_attr($wrapper_class);
            }
            return $theme_class_name;
        }

        /**
         * Function for save Address from my-account.
         *
         * @param integer $user_id The user id info
         * @param array $load_address The address is loaded
         * @param array $address The custom addresses
         *
         * @return void
         */
        public function save_address($user_id, $load_address, $address) {
            if($load_address!='') {
                if(isset($_GET['atype'])) {
                    $url = isset($_GET['atype']) ? sanitize_key($_GET['atype']) : '';
                    $type = str_replace('/', '', $url); 
                    if (0 === wc_notice_count('error')) {
                        if($type == 'add-address') {
                            if($load_address == 'billing') {
                                $new_address = $this->prepare_posted_address($user_id, $address, 'billing');
                                $this->save_address_to_user($new_address, 'billing');   
                            }elseif($load_address == 'shipping') {
                                $custom_address = $this->prepare_posted_address($user_id, $address, 'shipping');
                                $this->save_address_to_user($custom_address, 'shipping');
                            }
                        }else {
                            $this->update_address($user_id, $load_address, $address, $type);
                        }

                        if($type == 'add-address') {
                            wc_add_notice(esc_html__('Address Added successfully.', 'woocommerce'));
                        }else {
                            wc_add_notice(esc_html__('Address Changed successfully.', 'woocommerce'));
                        }
                        wp_safe_redirect(wc_get_endpoint_url('edit-address', '', wc_get_page_permalink('myaccount')));
                        exit;
                    }       
                }else {
                    $exist_address = get_user_meta($user_id, THMAF_Utils::ADDRESS_KEY,true);
                    if($exist_address) {
                        $default_key = THMAF_Utils::get_custom_addresses($user_id, 'default_'.$load_address);
                        $address_key = ($default_key) ? $default_key : 'address_0';
                        $this->update_address($user_id, $load_address, $address, $address_key); 
                    }
                }
            }
        }

        /**
         * Function for prepared posted address.
         *
         * @param integer $user_id The user id info
         * @param array $address The posted address
         * @param string $type The address type
         *
         * @return array
         */
        private function prepare_posted_address($user_id, $address, $type) {
            $address_new = array();
            if($type == 'billing') {
                if(!isset($address['billing_heading'])) {
                    $address_new['billing_heading'] = esc_html__('Address');
                }
            }else {
                if(!isset($address['shipping_heading'])) {
                    $address_new['shipping_heading'] = esc_html__('Address');
                }
            }
            $address_value = '';
            if(!empty($address) && is_array($address)) {
                foreach ($address as $key => $value) {
                    if(isset($_POST[ $key ])) {
                        $posted_key = isset($_POST[$key]) ? THMAF_Utils::sanitize_post_fields($_POST[$key]) : '';
                        $address_value = is_array($posted_key) ? implode(',', wc_clean($posted_key)) : wc_clean($posted_key);

                        if(!empty($address_value)) {
                            $address_new[$key] = $address_value;
                        }
                    }
                }   
            }
            return $address_new;
        }

        /**
         * Function for save address to user.
         *
         * @param array $address The posted address
         * @param string $type The address type
         *
         * @return void
         */
        private function save_address_to_user($address, $type) {
            $user_id = get_current_user_id();
            $custom_addresses = get_user_meta($user_id, THMAF_Utils::ADDRESS_KEY, true);
            $saved_address = THMAF_Utils::get_custom_addresses($user_id, $type);
            if(!is_array($saved_address)) {
                if(!is_array($custom_addresses)) {
                    $custom_addresses = array();
                }
                $custom_address = array();
                $default_address = THMAF_Utils::get_default_address($user_id, $type);
                $custom_address['address_0'] = $default_address;
                $custom_address['address_1'] = $address;
                $custom_addresses[$type] = $custom_address;         
            }else {
                if(is_array($saved_address)) {
                    if(isset($custom_addresses[$type])) {
                        $exist_custom = $custom_addresses[$type];
                        $new_key_id = $this->get_new_custom_id($user_id, $type);
                        $new_key = 'address_'.esc_attr($new_key_id);
                        $custom_address[$new_key] = $address;
                        $custom_addresses[$type] = array_merge($exist_custom, $custom_address);     
                    }
                }       
            }
            $custom_adr_count = count($custom_addresses[$type]);
            if($custom_adr_count <= '2') {  
                update_user_meta($user_id, THMAF_Utils::ADDRESS_KEY, $custom_addresses);
            }
        }

        /**
         * Function for get default address.
         *
         * @param integer $user_id The user id
         * @param string $type The address type
         *
         * @return array
         */
        /*public function get_default_address($user_id, $type) {
            $fields = self::get_address_fields($type);
            $default_address = array();
            if(!empty($fields) && is_array($fields)) {
                foreach ($fields as $key) {
                    $default_address[$key] = get_user_meta($user_id, $key, true);
                }
            }
            $default_address[$type.'_heading'] = esc_html__('Address');
            return $default_address;
        }*/

        /**
         * Function for create to address name or address key.
         *
         * @param integer $user_id The user id
         * @param string $type The address type
         *
         * @return string
         */
        public function get_new_custom_id($user_id, $type) {
            $custom_address = THMAF_Utils::get_custom_addresses($user_id, $type);
            if($custom_address) {
                $all_keys = array_keys($custom_address);
                $key_ids = array();
                if(!empty($all_keys) && is_array($all_keys)) {
                    foreach($all_keys as $key) {
                        $key_ids[] = str_replace('address_','', $key);
                    }
                }
                $new_id = max($key_ids)+1;
                return $new_id;
            }       
        } 

        /**
         * Function for update address.
         *
         * @param integer $user_id The user id
         * @param string $address_type The address type
         * @param array $address The address type
         * @param string $type The address type(shipping/billing)
         *
         * @return void
         */
        public function update_address($user_id, $address_type, $address, $type) {      
            $edited_address=$this->prepare_posted_address($user_id, $address, $address_type);
            $this->update_address_to_user($user_id, $edited_address, $address_type, $type); 
        }

        /**
         * Function for update address to user.
         *
         * @param integer $user_id The user id
         * @param array $address The address type
         * @param string $type The address type(shipping/billing)
         * @param string $address_key The address name or address key
         *
         * @return void
         */
        private function update_address_to_user($user_id, $address, $type, $address_key) {
            $custom_addresses = get_user_meta($user_id, THMAF_Utils::ADDRESS_KEY, true);
            $exist_custom = $custom_addresses[$type];
            $custom_address[$address_key] = $address;
            $custom_addresses[$type] = array_merge($exist_custom, $custom_address);     
            update_user_meta($user_id, THMAF_Utils::ADDRESS_KEY, $custom_addresses);
        }
        
        /**
         * Function for delete Address.
         *
         * @return void
         */
        public function delete_address() {      
            if(isset($_POST['thmaf_del_addr'])) {
                if (! isset($_POST['account_adr_delete_action']) || ! wp_verify_nonce($_POST['account_adr_delete_action'], 'thmaf_account_adr_delete_action')) {
                   echo $responce = '<div class="error"><p>'.esc_html__('Sorry, your nonce did not verify.').'</p></div>';
                   exit;
                }else {
                    $buton_id = isset($_POST['thmaf_deleteby']) ? THMAF_Utils::sanitize_post_fields($_POST['thmaf_deleteby']) : '';
                    $type = substr($buton_id.'_', 0, strpos($buton_id, '_'));
                    $address_key = substr($buton_id, strpos($buton_id, "_") + 1);
                    $this->delete($type, $address_key);
                }
            }
            
        }

        /**
         * Function for delete.
         *
         * @param string $type The address type(shipping/billing)
         * @param string $custom The custom string of the address 
         *
         * @return void
         */
        public function delete($type, $custom) {
            $user_id = get_current_user_id();
            $custom_addresses = get_user_meta($user_id, THMAF_Utils::ADDRESS_KEY, true);    
            unset($custom_addresses[$type][$custom]);
            update_user_meta($user_id, THMAF_Utils::ADDRESS_KEY, $custom_addresses);
        }

        /**
         * Function for set as default billing address.
         *
         * @return void
         */ 
        public function set_default_billing_address() {
            $customer_id = get_current_user_id();
            if(isset($_POST['thmaf_default_bil_addr'])) {
                if (! isset($_POST['billing_adr_default_action']) || ! wp_verify_nonce($_POST['billing_adr_default_action'], 'thmaf_billing_adr_default_action')) {
                   echo $responce = '<div class="error"><p>'.esc_html__('Sorry, your nonce did not verify.').'</p></div>';
                   exit;
                }else {
                    $address_key = isset($_POST['thmaf_bil_defaultby']) ? THMAF_Utils::sanitize_post_fields($_POST['thmaf_bil_defaultby']) : '';
                    $type = substr($address_key.'_', 0, strpos($address_key, '_'));
                    $custom_key = substr($address_key, strpos($address_key, "_") + 1);
                    $this->change_default_address($customer_id, $type, $custom_key);
                }
            }
        }

        /**
         * Function for set as default shipping address.
         *
         * @return void
         */ 
        public function set_default_shipping_address() {
            $customer_id = get_current_user_id();
            if(isset($_POST['thmaf_default_ship_addr'])) {
                if (! isset($_POST['shipping_adr_default_action']) || ! wp_verify_nonce($_POST['shipping_adr_default_action'], 'thmaf_shipping_adr_default_action')) {
                   echo $responce = '<div class="error"><p>'.esc_html__('Sorry, your nonce did not verify.').'</p></div>';
                   exit;
                }else {
                    $address_key = isset($_POST['thmaf_ship_defaultby']) ? THMAF_Utils::sanitize_post_fields($_POST['thmaf_ship_defaultby']) : '';
                    $type = substr($address_key.'_', 0, strpos($address_key, '_'));
                    $custom_key = substr($address_key, strpos($address_key, "_") + 1);
                    $this->change_default_address($customer_id, $type, $custom_key);
                }
            }
        }

        /**
         * Core function for set default address
         *
         * @param integer $customer_id The user id
         * @param string $type The address type(billing/shipping) 
         * @param string $custom_key The custom key of the address
         *
         * @return void
         */
        public function change_default_address($customer_id, $type, $custom_key) {
            $default_address = THMAF_Utils::get_custom_addresses($customer_id, $type, $custom_key);
            $current_address = THMAF_Utils::get_default_address($customer_id, $type);
            if(!empty($current_address) && is_array($current_address)) {
                foreach ($current_address as $key => $value) {
                    if(isset($default_address[$key])) {
                        update_user_meta($customer_id, $key, $default_address[$key], $current_address[$key]);
                    }else {
                        update_user_meta($customer_id, $key, '', $current_address[$key]);
                    }
                }
            }
            $custom_addresses = get_user_meta($customer_id, THMAF_Utils::ADDRESS_KEY,true);
            $custom_addresses['default_'.$type] = $custom_key;
            update_user_meta($customer_id, THMAF_Utils::ADDRESS_KEY, $custom_addresses);
            $current_address = THMAF_Utils::get_default_address($customer_id, $type);
        }

        /**
         * Function for add hidden field to the checkout form fields(Checkout page)
         *
         * @param array $fields The checkout form fields
         *
         * @return array
         */
        public function add_hidden_field_to_checkout_fields($fields) {
            $user_id = get_current_user_id();
            $default_bil_key = THMAF_Utils::get_custom_addresses($user_id, 'default_billing');
            $same_bil_key = THMAF_Utils::is_same_address_exists($user_id, 'billing'); 
            $default_value = $default_bil_key ? $default_bil_key : $same_bil_key;
            $fields['billing']['thmaf_hidden_field_billing'] = array(
                'label'    => esc_html__('hidden value',''),
                'required' => false,
                'class'    => array('form-row'),
                'clear'    => true,
                'default'  => $default_value,
                'type'     => 'hidden' 
            );

            $default_ship_key = THMAF_Utils::get_custom_addresses($user_id, 'default_shipping');
            $same_ship_key = THMAF_Utils::is_same_address_exists($user_id, 'shipping'); 
            $default_value_ship = $default_ship_key ? $default_ship_key : $same_ship_key;
            $fields['billing']['thmaf_checkbox_shipping'] = array(
                'label'    => esc_html__('hidden value',''),
                'required' => false,
                'class'    => array('form-row'),
                'clear'    => true,
                'default'   => $default_value_ship,
                'type'     => 'hidden' 
            );

            $fields['shipping']['thmaf_hidden_field_shipping'] = array(
                'label'    => esc_html__('hidden value',''),
                'required' => false,
                'class'    => array('form-row'),
                'clear'    => true,
                'default'  => $default_value_ship,
                'type'     => 'hidden' 
            );
            return $fields;
        }

        /**
         * Function for add hidden field to the checkout form fields(Checkout page)
         *
         * @param array $fields The checkout form fields
         * @param string $key The checkout form fields key
         * @param array $args The arguments on checkout form fields
         * @param string $value The checkout form values
         *
         * @return void
         */
        public function add_hidden_field($field, $key, $args, $value) {
             return '<input type="hidden" name="'.esc_attr($key).'" id="'.esc_attr($args['id']).'" value="'.esc_attr($args['default']).'" />';
        }

        /**
         * Function for update checkout billing form(Checkout page)
         *
         * @param array $checkout The checkout form fields
         *
         * @return void
         */
        public function session_update_billing($checkout) {
            // $customer_id = get_current_user_id();
            // $default_address = THMAF_Utils::get_default_address($customer_id, 'billing');
            //     $addresfields = array('first_name', 'last_name', 'company', 'address_1', 'address_2', 'city', 'state', 'postcode', 'country', 'phone', 'email');
            // if(!empty($addresfields) && is_array($addresfields)) {
            //     foreach ($addresfields as $key) {
            //         $temp_value = isset($default_address['billing_'.$key]) ? $default_address['billing_'.$key] : '';
            //         WC()->customer->{"set_billing_"."{$key}"}($temp_value);
            //         WC()->customer->save();
            //     }
            // }

            $customer_id = get_current_user_id();           
            if(is_user_logged_in()) {   
                $default_address = THMAF_Utils::get_default_address($customer_id, 'billing');
                $addresfields = array('first_name', 'last_name', 'company','address_1', 'address_2', 'city', 'state', 'postcode', 'country', 'phone', 'email');
                if($default_address && array_filter($default_address) && (count(array_filter($default_address)) > 2)) {
                    if(!empty($addresfields) && is_array($addresfields)){
                        foreach ($addresfields as $key) {
                            if(isset($default_address['billing_'.$key])) {
                                $temp_value = isset($default_address['billing_'.$key]) ? $default_address['billing_'.$key] : '';
                                WC()->customer->{"set_billing_"."{$key}"}($temp_value);
                                WC()->customer->save();
                            }
                        }
                    }
                }               

                // Fix for deactivate & activate.
                $default_set_address = THMAF_Utils::get_custom_addresses($customer_id, 'default_billing');
                if($default_set_address) {
                    $address_key = THMAF_Utils::is_same_address_exists($customer_id, 'billing');
                    if(!$address_key) {                     
                        THMAF_Utils::update_address_to_user($customer_id, $default_address, 'billing', $default_set_address);
                    }
                }
            }
        }

        /**
         * Function for update checkout shipping form(Checkout page)
         *
         * @param array $checkout The checkout form fields
         *
         * @return void
         */
        public function session_update_shipping($checkout) {
            // $customer_id = get_current_user_id();
            // $default_address = THMAF_Utils::get_default_address($customer_id, 'shipping');
            // $addresfields = array('first_name', 'last_name', 'company', 'address_1', 'address_2', 'city', 'state', 'postcode', 'country');
            // if(!empty($addresfields) && is_array($addresfields)) {
            //     foreach($addresfields as $key) {
            //         $temp_value = isset($default_address['shipping_'.$key]) ? $default_address['shipping_'.$key] : '';
            //         WC()->customer->{"set_shipping_"."{$key}"}($temp_value);
            //         WC()->customer->save();
            //     }
            // }

            $customer_id = get_current_user_id();
            if (is_user_logged_in()) {              
                $default_address = THMAF_Utils::get_default_address($customer_id, 'shipping');
                $addresfields = array('first_name', 'last_name', 'company', 'address_1', 'address_2', 'city', 'state', 'postcode', 'country');
                if($default_address && array_filter($default_address) && (count(array_filter($default_address)) > 2)) {
                    if(!empty($addresfields) && is_array($addresfields)) {
                        foreach ($addresfields as $key) {
                            if(isset($default_address['shipping_'.$key])) {
                                $temp_value = isset($default_address['shipping_'.$key]) ? $default_address['shipping_'.$key] : '';
                                WC()->customer->{"set_shipping_"."{$key}"}($temp_value);
                                WC()->customer->save();
                            }
                        }
                    }
                }
                // Fix for deactivate & activate.
                $default_set_address = THMAF_Utils::get_custom_addresses($customer_id, 'default_shipping');
                if($default_set_address) {
                    $address_key = THMAF_Utils::is_same_address_exists($customer_id, 'shipping');
                    if(!$address_key) {                     
                        THMAF_Utils::update_address_to_user($customer_id, $default_address, 'shipping', $default_set_address);
                    }
                }
            }
        }

        /**
         * Function for billing address select option display - above the billing form (Checkout page)
         *
         * @return void
         */
        public function address_above_billing_form() {
            $settings = THMAF_Utils::get_setting_value('settings_billing');
            if($settings && !empty($settings)) {
                if (is_user_logged_in()) {
                    if($settings['enable_billing']=='yes') {
                        $this->add_dd_to_checkout_billing();
                    }
                }
            }
        }

        /**
         * Function for shipping address select option display - above the shipping form (Checkout page)
         *
         * @return void
         */
        public function address_above_shipping_form() {
            $settings=THMAF_Utils::get_setting_value('settings_shipping');
            if($settings && !empty($settings)) {
                if (is_user_logged_in()) {
                    if($settings['enable_shipping']=='yes') {
                        $this->add_dd_to_checkout_shipping();
                    }
                }
            }
        }

        /**
         * Function for address drop down field display(Checkout page)
         *
         * @return void
         */
        public function add_dd_to_checkout_billing() {
            $customer_id = get_current_user_id();
            $custom_addresses = THMAF_Utils::get_custom_addresses($customer_id, 'billing');
            $default_bil_address = THMAF_Utils::get_custom_addresses($customer_id, 'default_billing');
            $same_address = THMAF_Utils::is_same_address_exists($customer_id, 'billing');
            $default_address = $default_bil_address ? $default_bil_address : $same_address ;
            $address_limit = '2';
            $options = array();

            if(is_array($custom_addresses)) {
                $custom_address = $custom_addresses;
            }else {
                $custom_address = array();
                $def_address = THMAF_Utils::get_default_address($customer_id, 'billing');           
                if(array_filter($def_address) && (count(array_filter($def_address)) > 2)) {
                    $custom_address ['selected_address'] = $def_address;
                }
            }
            if($custom_address) {
                if($default_address) {
                    //$options[$default_address] = $custom_address[$default_address]['billing_address_1'];
                    $new_address = $custom_address[$default_address];
                    $new_address_format = THMAF_Utils::get_formated_address('billing', $new_address);
                    $options_arr = WC()->countries->get_formatted_address($new_address_format);
                    $adrsvalues_to_dd = explode('<br/>', $options_arr);
                    $adrs_string = implode(', ', $adrsvalues_to_dd);

                    $options[$default_address] = $adrs_string;
                }else {
                    $default_address = 'selected_address';
                    $options[$default_address]  = esc_html__('Billing Address', 'themehigh-multiple-addresses');
                }                   
            
                $i = 0;
                if(is_array($custom_address)) {
                    foreach ($custom_address as $key => $address_values) {
                        $adrsvalues_to_dd = array();
                        if(apply_filters('thmaf_remove_dropdown_address_format', true)) {
                            if(!empty($address_values) && is_array($address_values)) {
                                foreach ($address_values as $adrs_key => $adrs_value) {
                                    if($adrs_key == 'billing_address_1' || $adrs_key =='billing_address_2' || $adrs_key =='billing_city' || $adrs_key =='billing_state' || $adrs_key =='billing_postcode') {
                                        if($adrs_value) {
                                            $adrsvalues_to_dd[] = $adrs_value;
                                        }
                                    }
                                }
                            }
                        } else {
                            $type = 'billing';
                            $separator = '</br>';
                            $new_address = $custom_address[$key];
                            $new_address_format = THMAF_Utils::get_formated_address($type,$new_address);
                            $options_arr = WC()->countries->get_formatted_address($new_address_format);
                            $adrsvalues_to_dd = explode('<br/>', $options_arr);
                        }
                        $adrs_string = implode(', ', $adrsvalues_to_dd);
                        $options[$key] = esc_html($adrs_string);
                        if($i >= $address_limit) {
                            break;
                        }
                        $i++;               
                    }
                }
                $address_count = count($custom_address);
                if(((int)($address_limit)) >= $address_count) {
                    $options['add_address'] = esc_html__('Add New Address', 'themehigh-multiple-addresses');
                }
            }else {
                $default_address = 'selected_address';
                $options[$default_address] = esc_html__('Billing Address', 'themehigh-multiple-addresses');
                //$options['add_address'] = esc_html__('Add New Address', 'themehigh-multiple-addresses');
            }
                    
            $alt_field = array(
                'label'         => '',
                'required'      => false,
                'class'         => array('form-row form-row-wide enhanced_select', 'select2-selection'),
                'clear'         => true,
                'type'          => 'select',
                'placeholder'   =>esc_html__('Choose an Address..',''),
                'options'       => $options
            );
            woocommerce_form_field(THMAF_Utils::DEFAULT_BILLING_ADDRESS_KEY, $alt_field, $options[$default_address]);   
        }

        /**
         * Function for create address drop down list(Checkout page)
         *
         * @return void
         */
        public function add_dd_to_checkout_shipping() {
            $customer_id = get_current_user_id();
            $custom_addresses = THMAF_Utils::get_custom_addresses($customer_id, 'shipping');
            $default_ship_address = THMAF_Utils::get_custom_addresses($customer_id, 'default_shipping');
            $same_address = THMAF_Utils::is_same_address_exists($customer_id, 'shipping');
            $default_address = $default_ship_address ? $default_ship_address : $same_address;
            $address_limit = '2';
            $options = array();
            if(is_array($custom_addresses) && !empty($custom_addresses)) {
                $custom_address = $custom_addresses;
            }else {
                $custom_address = array();
                $def_address = THMAF_Utils::get_default_address($customer_id, 'shipping');          
                if(array_filter($def_address) && (count(array_filter($def_address)) > 2)) {
                    $custom_address ['selected_address'] = $def_address;
                }           
            }
                
            if($custom_address) {
                if($default_address) {
                    $new_address = $custom_address[$default_address];
                    $new_address_format = THMAF_Utils::get_formated_address('shipping', $new_address);
                    $options_arr = WC()->countries->get_formatted_address($new_address_format);
                    $adrsvalues_to_dd = explode('<br/>', $options_arr);
                    $adrs_string = implode(', ', $adrsvalues_to_dd);

                    //$options[$default_address] = $custom_address[$default_address];
                    $options[$default_address] = $adrs_string;
                }else {
                    $default_address = 'selected_address';
                    $options[$default_address] = esc_html__('Shipping Address', 'themehigh-multiple-addresses');
                }

                $i = 0;
                if(is_array($custom_address)) {
                    foreach ($custom_address as $key => $address_values) {
                        $adrsvalues_to_dd = array();
                        if(apply_filters('thmaf_remove_dropdown_address_format', true)) {
                            if(!empty($address_values) && is_array($address_values)) {
                                foreach ($address_values as $adrs_key => $adrs_value) {
                                    if($adrs_key == 'shipping_address_1' || $adrs_key =='shipping_address_2' || $adrs_key =='shipping_city' || $adrs_key =='shipping_state' || $adrs_key =='shipping_postcode') {
                                        if($adrs_value) {
                                            $adrsvalues_to_dd[] = $adrs_value;
                                        }
                                    }
                                }
                            }
                        } else {
                            $type = 'shipping';
                            $separator = '</br>';
                            $new_address = $custom_address[$key];
                            $new_address_format = THMAF_Utils::get_formated_address($type, $new_address);
                            $options_arr = WC()->countries->get_formatted_address($new_address_format);
                            $adrsvalues_to_dd = explode('<br/>', $options_arr);
                        }
                        $adrs_string = implode(', ', $adrsvalues_to_dd);
                        $options[$key] = esc_html($adrs_string);
                        if($i >= $address_limit) {
                            break;
                        }
                        $i++;
                    }
                }
                $address_count = count($custom_address);
                if(((int)($address_limit)) >= $address_count) {
                    $options['add_address'] = esc_html__('Add New Address', 'themehigh-multiple-addresses');
                }
            }else {
                $default_address = 'selected_address';
                $options[$default_address] = esc_html__('Shipping Address', 'themehigh-multiple-addresses');
            }

            $alt_field = array(
                'label'         => '',
                'required'      => false,
                'class'         => array('form-row form-row-wide enhanced_select', 'select2-selection'),
                'clear'         => true,
                'type'          => 'select',
                'placeholder'   =>esc_html__('Choose an Address..',''),
                'options'       => $options
            );

            woocommerce_form_field(THMAF_Utils::DEFAULT_SHIPPING_ADDRESS_KEY, $alt_field, $options[$default_address]);  
        }

        /**
         * Function for get address by id(Checkout page-ajax response)
         *
         * @return void
         */
        public function get_addresses_by_id() {
            if(check_ajax_referer('populate_address_nonce', 'security')) {

                $address_key = isset($_POST['selected_address_id']) ? THMAF_Utils::sanitize_post_fields($_POST['selected_address_id']) : '';
                $type = isset($_POST['selected_type']) ? THMAF_Utils::sanitize_post_fields($_POST['selected_type']) : '';
                $section_name = isset($_POST['section_name']) ? THMAF_Utils::sanitize_post_fields($_POST['section_name']) : '';
                $customer_id = get_current_user_id();
                if(!empty($section_name) && $address_key == 'section_address') {
                    $custom_address = $this->get_default_section_address($customer_id, $section_name);
                }else {
                    if($address_key == 'selected_address') {
                        $custom_address = THMAF_Utils::get_default_address($customer_id, $type);
                    }else {
                        $custom_address = THMAF_Utils::get_custom_addresses($customer_id, $type, $address_key);
                    }           
                }
                wp_send_json($custom_address);
            die;
            }       
        }

        /**
         * Function for update custom blling address on checkout page(checkout page)
         *
         * @param integer $order_id The order id
         * @param array $posted_data The posted address data
         * @param array $order The order info
         *
         * @return void
         */
        public function update_custom_billing_address_from_checkout($order_id, $posted_data, $order) {
            if (is_user_logged_in()) {
                $address_key = isset($posted_data['thmaf_hidden_field_billing']) ? THMAF_Utils::sanitize_post_fields($posted_data['thmaf_hidden_field_billing']) : '';
                $user_id = get_current_user_id();
                $custom_key = THMAF_Utils::get_custom_addresses($user_id, 'default_billing');
                $same_address_key = THMAF_Utils::is_same_address_exists($user_id, 'billing');
                $default_key = ($custom_key) ? $custom_key : $same_address_key ;

                $this->update_address_from_checkout('billing', $address_key, $posted_data, $default_key);
                
                if($custom_key) {
                    $modify = apply_filters('thmaf_modify_billing_update_address', true);
                    if($modify) {

                        $this->change_default_address($user_id, 'billing', $default_key);

                    }else {
                        if ($address_key == 'add_address') {
                            $new_key_id = (THMAF_Utils::get_new_custom_id($user_id, 'billing')) - 1;
                            $new_key = 'address_'.$new_key_id;
                            $this->change_default_address($user_id, 'billing', $new_key);
                        }elseif(!empty($address_key)) {
                            $this->change_default_address($user_id, 'billing', $address_key);
                        }           
                    }
                }       
            }
        }

        /**
         * Function for update custom shipping address on checkout page(checkout page)
         *
         * @param integer $order_id The order id
         * @param array $posted_data The posted address data
         * @param array $order The order info
         *
         * @return void
         */
        public function update_custom_shipping_address_from_checkout($order_id, $posted_data, $order) {
            if (is_user_logged_in()) {
                $user_id = get_current_user_id();
                $custom_key = THMAF_Utils::get_custom_addresses($user_id, 'default_shipping');
                $same_address_key = THMAF_Utils::is_same_address_exists($user_id, 'shipping');
                $default_key = ($custom_key) ? $custom_key : $same_address_key ;
                
                if (! wc_ship_to_billing_address_only() && wc_shipping_enabled()) {
                    $address_key = isset($posted_data['thmaf_hidden_field_shipping']) ? THMAF_Utils::sanitize_post_fields($posted_data['thmaf_hidden_field_shipping']) : '';
                    $ship_select = isset($posted_data['thmaf_checkbox_shipping']) ? THMAF_Utils::sanitize_post_fields($posted_data['thmaf_checkbox_shipping']) : ''; 
                    if($ship_select == 'ship_select') {

                        $this->update_address_from_checkout('shipping', $address_key, $posted_data, $default_key);
                    }else {
                        if(!$custom_key) {
                            $this->update_address_from_checkout('shipping', $ship_select, $posted_data, $default_key);
                            //$custom_address = self::get_custom_addresses($user_id, 'shipping', $ship_select);
                            //$this->update_address_to_user($user_id, $custom_address, 'shipping', $ship_select);
                        }
                    }
                }
                if($custom_key) {
                    $modify = apply_filters('thmaf_modify_shipping_update_address', true);
                    if($modify) {
                        $this->change_default_address($user_id, 'shipping', $default_key);
                    }else {
                        if ($address_key == 'add_address') {
                            $new_key_id = (THMAF_Utils::get_new_custom_id($user_id, 'shipping')) - 1;
                            $new_key = 'address_'.$new_key_id;
                            $this->change_default_address($user_id, 'shipping', $new_key);
                        }elseif(!empty($address_key)) {
                            $this->change_default_address($user_id, 'shipping', $address_key);
                        }
                    }
                }   
            }
        }

        /**
         * Function for update address from checkout page(checkout page)
         *
         * @param string $type The address type
         * @param string $address_key The address key
         * @param array $posted_data The posted address data
         * @param string $default_key The default key
         *
         * @return void
         */
        public function update_address_from_checkout($type, $address_key, $posted_data, $default_key) {
            $user_id = get_current_user_id();       
            $added_address = array();
            $added_address = $this->prepare_order_placed_address($user_id, $posted_data, $type);
            if($address_key == 'add_address') {         
                self::save_address_to_user_from_checkout($added_address, $type);
            }
            elseif(($default_key) && (empty($address_key)|| ($address_key == $default_key))) {          
                THMAF_Utils::update_address_to_user($user_id, $added_address, $type, $default_key);
            }elseif($address_key && ($address_key != 'selected_address')) {
                $this->update_address_to_user_from_checkout($user_id, $added_address, $type, $address_key);
            }
        }

        /**
         * Function for update address to user from checkout page(checkout page)
         *
         * @param integer $user_id The user id
         * @param array $address The given address
         * @param string $type The posted address type
         * @param string $address_key The address key
         *
         * @return void
         */
        private function update_address_to_user_from_checkout($user_id, $address, $type, $address_key) {
            $custom_addresses = get_user_meta($user_id,THMAF_Utils::ADDRESS_KEY, true);
            $exist_custom = $custom_addresses[$type];
            $custom_address[$address_key] = $address;
            $custom_key = THMAF_Utils::get_custom_addresses($user_id, 'default_'.$type);
            if(!$custom_key) {
                $custom_addresses['default_'.$type] = $address_key;
            }

            $custom_addresses[$type] = array_merge($exist_custom, $custom_address);
            
            update_user_meta($user_id, THMAF_Utils::ADDRESS_KEY, $custom_addresses);
        }

        /**
         * Function for save address to user from checkout page(checkout page)
         *
         * @param array $address The given address
         * @param string $type The posted address type
         *
         * @return void
         */
        private function save_address_to_user_from_checkout($address, $type) {
            $user_id = get_current_user_id();
            $custom_addresses = get_user_meta($user_id, THMAF_Utils::ADDRESS_KEY, true);
            $custom_addresses = is_array($custom_addresses) ? $custom_addresses : array();
            $saved_address = THMAF_Utils::get_custom_addresses($user_id, $type);

            if(!is_array($saved_address)) {
                $custom_address = array();
                $default_address = THMAF_Utils::get_default_address($user_id, $type);
                $custom_address['address_0'] = $default_address;
                $custom_key = THMAF_Utils::get_custom_addresses($user_id, 'default_'.$type);
                $custom_addresses[$type] = $custom_address;         
            }else {
                if(is_array($saved_address)) {
                    if(isset($custom_addresses[$type])) {
                        $exist_custom = $custom_addresses[$type];
                        $new_key_id = THMAF_Utils::get_new_custom_id($user_id, $type);
                        $new_key = 'address_'.$new_key_id;
                        $custom_address[$new_key] = $address; 
                        $custom_key = THMAF_Utils::get_custom_addresses($user_id, 'default_'.$type);
                        if(!$custom_key) {
                            $custom_addresses['default_'.$type] = $new_key;
                        }
                        $custom_addresses[$type] = array_merge($exist_custom, $custom_address);     
                    }
                }       
            }   
            update_user_meta($user_id,THMAF_Utils::ADDRESS_KEY, $custom_addresses);
        }

        /**
         * Function for add address from checkout page(checkout page)
         *
         * @param array $data The given address datas
         * @param string $errors The existing errors
         *
         * @return void
         */
        public function add_address_from_checkout($data, $errors) {
            $user_id = get_current_user_id();   
            if(empty($errors->get_error_messages())) {
                if(isset($_POST['thmaf_hidden_field_billing'])) {
                    $checkout_bil_key = isset($_POST['thmaf_hidden_field_billing']) ? THMAF_Utils::sanitize_post_fields($_POST['thmaf_hidden_field_billing']) : '';            
                    if($checkout_bil_key == 'add_address') {
                        $this->set_first_address_from_checkout($user_id, 'billing');
                    }
                }
                if (! wc_ship_to_billing_address_only() && wc_shipping_enabled()) {
                    if(isset($_POST['thmaf_hidden_field_shipping'])) {
                        $checkout_ship_key = isset($_POST['thmaf_hidden_field_shipping']) ? THMAF_Utils::sanitize_post_fields($_POST['thmaf_hidden_field_shipping']) : '';
                        if($checkout_ship_key == 'add_address') {
                            $this->set_first_address_from_checkout($user_id, 'shipping');
                        }
                    }
                }
            }
        }

        /**
         * Function for set first address from checkout page - new user(checkout page)
         *
         * @param array $user_id The user id
         * @param string $type The address type
         *
         * @return void
         */
        public function set_first_address_from_checkout($user_id, $type) {
            $custom_addresses = get_user_meta($user_id,THMAF_Utils::ADDRESS_KEY, true); 
            $custom_address = THMAF_Utils::get_custom_addresses($user_id, $type);       
            $checkout_address_key = isset($_POST['thmaf_hidden_field_'.$type]) ? THMAF_Utils::sanitize_post_fields($_POST['thmaf_hidden_field_'.$type]) : '';

            if(!$custom_address && $checkout_address_key == 'add_address') {    
                $custom_address = array();
                $custom_addresses = is_array($custom_addresses) ? $custom_addresses : array();
                $default_address = THMAF_Utils::get_default_address($user_id, $type);

                if(array_filter($default_address) && (count(array_filter($default_address)) > 2)) { 
                    $custom_address['address_0'] = $default_address;
                    $custom_addresses[$type] = $custom_address;
                    update_user_meta($user_id,THMAF_Utils::ADDRESS_KEY, $custom_addresses);
                }
            }
        }

        /**
         * Function for prepare order placed address(checkout page)
         *
         * @param array $user_id The user id
         * @param array $posted_data The posted data
         * @param string $type The address type(billing/shipping)
         *
         * @return array
         */
        private function prepare_order_placed_address($user_id, $posted_data, $type) {
            $fields = THMAF_Utils::get_address_fields($type);
            $new_address = array();
            if(!empty($fields) && is_array($fields)) {
                foreach ($fields as $key) {
                    if(isset($posted_data[$key])) {
                        $new_address[$key] = is_array($posted_data[$key]) ? implode(',', $posted_data[$key]) : $posted_data[$key];
                    }
                }
            }
            return $new_address;
        }

        /**
         * Function for prepare address fields before billing section(checkout page)
         *
         * @param array $fields The checkout field info
         * @param string $country The country info
         *
         * @return array
         */
        public function prepare_address_fields_before_billing($fields, $country) {
            if(!empty($fields) && is_array($fields)) {
                foreach ($fields as $key => $value) {
                    if ('billing_state' === $key) {
                        if(!isset($fields[$key]['country_field'])) {
                            $fields[$key]['country_field'] = 'billing_country';
                        }
                    }
                
                }
            }
            return $fields;
        }

        /**
         * Function for prepare address fields before shipping section(checkout page)
         *
         * @param array $fields The checkout field info
         * @param string $country The country info
         *
         * @return array
         */
        public function prepare_address_fields_before_shipping($fields, $country) {
            if(!empty($fields) && is_array($fields)) {
                foreach ($fields as $key => $value) {
                    if ('shipping_state' === $key) {
                        if(!isset($fields[$key]['country_field'])) {
                            $fields[$key]['country_field'] = 'shipping_country';
                        }
                    }       
                }
            }
            return $fields;
        }       
    }
endif;