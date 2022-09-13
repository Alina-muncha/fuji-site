<?php
/**
 * The admin general settings page functionality of the plugin.
 *
 * @link  https://themehigh.com
 * @since 1.0.0
 *
 * @package    themehigh-multiple-addresses
 * @subpackage themehigh-multiple-addresses/admin
 */
if(!defined('WPINC')) { 
    die; 
}

if(!class_exists('THMAF_Admin_Settings_General')) :

    /**
     * Genereal setting class.
    */
    class THMAF_Admin_Settings_General extends THMAF_Admin_Settings {

        protected static $_instance = null; 
        private $settings_props = array();
        
        /**
         * Constructor.
         */
        public function __construct() {
            parent::__construct('general_settings', '');
            $this->init_constants();
        }
        
        /**
         * Instance.
         *
         * @return $_instance
         */
        public static function instance() {
            if(is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }
        
        /**
         * Initialize the consatants.
         *
         * @return void
         */
        public function init_constants() {  
            $this->settings_props = $this->get_field_form_props();
        } 
        
        /**
         * Get form field propd.
         *
         * @return void
         */ 
        public function get_field_form_props() {        
            $settings_props_billing = array(
                'enable_billing' => array('name'=>'enable_billing', 'label' =>esc_html__('Enable multiple address for billing', 'themehigh-multiple-addresses'), 'type'=>'checkbox', 'value'=>'yes', 'checked'=>1), 
            );
            $settings_props_shipping = array(
                'enable_shipping'=> array('type'=>'checkbox', 'name'=>'enable_shipping', 'label' => esc_html__('Enable multiple address for shipping', 'themehigh-multiple-addresses'), 'checked'=>1,'value'=>'yes'),
            );
            return array(
                'section_address_fields' => array('title'=>esc_html__('Address Properties','themehigh-multiple-addresses'), 'type'=>'separator', 'colspan'=>'3'),
                'settings_props_billing' => $settings_props_billing,
                'settings_props_shipping' => $settings_props_shipping,      
            );
        }
        
        /**
         * Render calls.
         *
         * @return void
         */ 
        public function render_page() {
            $this->render_tabs();
            $this->render_sections();
            $this->render_content();
        }

        /**
         * Save settings.
         *
         * @return void
         */
        public function save_settings() {
            if( check_admin_referer( 'settings_fields_form', 'thmaf_settings_fields_form')) {
                $settings = array();
                $settings['settings_billing'] = $this->_populate_posted_address_settings('billing');
                $settings['settings_shipping'] = $this->_populate_posted_address_settings('shipping');
                $result = update_option(THMAF_Utils::OPTION_KEY_THMAF_SETTINGS,$settings);

                if ($result == true) {
                    echo '<div class="updated"><p>'. esc_html__('Your changes were saved.', 'themehigh-multiple-addresses') .'</p></div>';
                } else {
                    echo '<div class="error"><p>'. esc_html__('Your changes were not saved due to an error (or you made none!).', 'themehigh-multiple-addresses') .'</p></div>';
                }
            }
        }

        /**
         * Populate posted addresses setings.
         *
         * @param string $type
         *
         * @return void
         */
        private function _populate_posted_address_settings($type) {
            $posted = array();
            $prefix='i_';
            $SETTINGS_PROPS = $this->settings_props['settings_props_'.$type];
            if(!empty($SETTINGS_PROPS)) {
                foreach($SETTINGS_PROPS as $props) {
                    $name  = $props['name'];
                    if($props['type'] == 'checkbox') {
                        $value = isset($_POST[$prefix.$name]) ? 'yes' : 'no';
                    }else {
                        $prefix_name = isset($_POST[$prefix.$name]) ? $_POST[$prefix.$name] : '';
                        $props_value  = array_key_exists('value', $props) ? $props['value'] : '';
                        $sanitiz_props_value = $this->thmaf_sanitize_post_fields($props['type'], $props_value);
                        $sanitiz_value = $this->thmaf_sanitize_post_fields($props['type'], $prefix_name);
                        $value = isset($sanitiz_value) ? $sanitiz_value : $sanitiz_props_value; 
                    }
                    $posted[$name] = $value;
                }
            }
            return $posted;
        }
        
        /**
         * Reset to default function.
         *
         * @return void
         */
        public function reset_to_default() {
            if( check_admin_referer( 'settings_fields_form', 'thmaf_settings_fields_form')) {
                delete_option(THMAF_Utils::OPTION_KEY_THMAF_SETTINGS);  
                return '<div class="updated"><p>'. esc_html__('Settings successfully reset', 'themehigh-multiple-addresses') .'</p></div>';
            }
        }
        
        /**
         * Render content function.
         *
         * @return void
         */
        public function render_content() {
            // register_block_type(
            //     'tb-blocks/tb-latest-posts-block',
            //     array(
            //         'attributes'                => array(
            //             'displayTabCategories'  => array(
            //                 'type'              => 'array',
            //                 'default'           => '[]',
            //                 'items'             => array('type' => 'integer')
            //             ),
            //         )
            //     )
            // );
            $prefix='i_';       
            if(isset($_POST['save_settings']))      
                echo $this->save_settings();        
            if(isset($_POST['reset_settings']))
                echo $this->reset_to_default();

            $settings_fields = $this->get_field_form_props();

            $settings_props_billing = $settings_fields['settings_props_billing'];
            $settings_props_shipping = $settings_fields['settings_props_shipping'];

            $settings_props_billing = $this->set_values_props($settings_props_billing,'billing');
            $settings_props_shipping = $this->set_values_props($settings_props_shipping,'shipping'); ?>            
            <div style="padding-left: 30px;">               
                <form id="thmaf_settings_fields_form" name="thmaf_settings_fields_form" method="post" action="">
                    <?php if (function_exists('wp_nonce_field')) {
                        wp_nonce_field('settings_fields_form', 'thmaf_settings_fields_form'); 
                    } ?>
                    <table class="form-table thpladmin-form-table">
                        <tbody>
                            <tr>
                                <?php $this->render_form_section_separator($settings_fields['section_address_fields']); ?>
                            </tr>
                            <tr>
                                <?php if($settings_props_billing['enable_billing']['value']=='no')
                                {
                                    $settings_props_billing['enable_billing']['checked']=0;
                                }
                                $this->render_form_field_element($settings_props_billing['enable_billing']); ?>
                            </tr>
                            <tr>
                                <?php if($settings_props_shipping['enable_shipping']['value']=='no')
                                {
                                    $settings_props_shipping['enable_shipping']['checked']=0;
                                }
                                $this->render_form_field_element($settings_props_shipping['enable_shipping']); ?>
                            </tr>
                        </tbody>
                    </table> 
                    <p class="submit">
                        <input type="submit" name="save_settings" class="button-primary" value="<?php echo esc_html__('Save changes', 'themehigh-multiple-addresses'); ?>" id="thmaf_save_settings">
                        <input type="submit" name="reset_settings" class="button" value="<?php echo esc_html__('Reset to default', 'themehigh-multiple-addresses'); ?>" 
                        onclick="return confirm('Are you sure you want to reset to default settings? all your changes will be deleted.');">
                    </p>
                </form>
            </div>      
        <?php }
        
        /**
         * Set values props.
         *
         * @param array $settings_props
         * @param string $type
         *
         * @return array
         */
        public function set_values_props($settings_props, $type) {
            if(!empty($settings_props) && is_array($settings_props)) {
                foreach ($settings_props as $name => $props) {
                    $settings_props[$name]['value']=THMAF_Utils::get_setting_value('settings_'.$type,$name);
                }
            }
            return $settings_props;
        }

        /**
         * Sanitization of post fields.
         *
         * @param string $type
         * @param array $value
         *
         * @return array
         */
        public function thmaf_sanitize_post_fields($type, $value) {
            $cleaned = '';
            $value = stripslashes($value);
            if($type) {
                switch ($type) {
                    case 'text':
                    case 'select':
                        $cleaned = sanitize_text_field($value); 
                        break;
                    case 'colorpicker':
                        $cleaned = sanitize_hex_color($value);
                        break;
                    case 'number':
                        $cleaned = is_numeric(trim($value));
                        $cleaned = $cleaned ? absint(trim($value)) : "";
                        break;
                    case 'switch':
                    case 'checkbox':
                        $cleaned = filter_var( $value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE );
                        break;
                    case 'button':
                        $cleaned = esc_url($value);
                        break;
                    case 'email':
                        $cleaned = is_email($value) ? $value : '';
                        break;
                    default:
                        $cleaned = sanitize_text_field($value); 
                        break;
                }
            }
            return $cleaned;
        }       
    }
endif;