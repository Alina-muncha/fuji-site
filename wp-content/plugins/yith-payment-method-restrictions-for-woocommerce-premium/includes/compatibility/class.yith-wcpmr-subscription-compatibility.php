<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
if ( ! defined( 'YITH_WCPMR_VERSION' ) ) {
    exit( 'Direct access forbidden.' );
}

/**
 *
 *
 * @class      YITH_WCPMR_Subscription_Compatibility
 * @package    Yithemes
 * @since      Version 1.0.0
 * @author     Your Inspiration Themes
 *
 */
if ( ! class_exists( 'YITH_WCPMR_Subscription_Compatibility' ) ) {

    class YITH_WCPMR_Subscription_Compatibility
    {

        public function __construct()
        {
            add_filter('yith_wcmr_type_of_restrictions',array($this,'add_subscription_restriction'));
            add_action('yith_wcpmr_conditions_row',array($this,'add_subscription_conditions_row'),10,2);
            add_filter('yith_wcpmr_save_metabox',array($this,'save_subscription_options'),10,4);
            add_filter('yith_wcpmr_is_payment_method_disabled',array($this,'is_payment_method_disabled_for_subscription_rule'),10,5);
        }

        /**
         * add_subscription_restriction
         *
         * Add membership on restriction type
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.1.7
         * @return array
         */

        public function add_subscription_restriction($restrictions) {

            $restrictions['subscription'] = 'Subscription';

            return $restrictions;

        }
        /**
         * add_subscription_conditions_row
         *
         * Add membership conditions on restriction type
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.1.7
         * @return array
         */
        public function add_subscription_conditions_row($args,$i) {

            ?>

            <div data-type="yith-products" class="yith-wcpmr-select2 yith-wcpmr-select2-subscription yith-wcpmr-row">
                <?php
                $data_selected = array();

                if (!empty($args['subscription'])) {
                    $products = is_array($args['subscription']) ? $args['subscription'] : explode(',', $args['subscription']);
                    if ($products) {
                        foreach ($products as $product_id) {
                            $product = wc_get_product($product_id);
                            $data_selected[$product_id] = $product->get_formatted_name();
                        }
                    }
                }
                $class = 'wc-product-search yith-wcpmr-information yith-wcpmr-subscription-search yith-wcpmr-select yith-wcpmr yith-wcpmr-li';
                $class = isset($args['subscription']) ? $class.' yith-wcpmr-rule-set yith-wcpmr-selector2' : $class.' yith-wcpmr-hide-rule-set';
                $search_products_array = array(
                    'type' => '',
                    'class' => $class,
                    'id' => 'yith_wcpmr_product_selector',
                    'name' => 'yith-wcpmr-rule[conditions][' . $i . '][subscription]',
                    'data-placeholder' => esc_attr__('Search for a product&hellip;', 'yith-google-product-feed-for-woocommerce'),
                    'data-allow_clear' => false,
                    'data-selected' => $data_selected,
                    'data-multiple' => true,
                    'data-action' => 'woocommerce_json_search_products_and_variations',
                    'value' => empty($args['subscription']) ? '' : $args['subscription'],
                    'style' => 'display:none;',
                    'custom-attributes' => array(
                        'data-type' => 'subscription'
                    ),
                );
                yit_add_select2_fields($search_products_array,$i);


                ?>
            </div>

            <?php
        }

        public function save_subscription_options($list_condition,$i,$type_restriction,$conditions) {
            if( 'subscription' == $type_restriction ) {

                $list_condition[$i]['restriction_by'] = $conditions[$i]['restriction_by'];
                $list_condition[$i]['subscription'] = (isset($conditions[$i]['subscription'])) ? $conditions[$i]['subscription'] : '';
            }

            return $list_condition;

        }

        public function is_payment_method_disabled_for_subscription_rule($status,$type_restriction,$condition,$gateway,$order_cart) {

            if( 'subscription' == $type_restriction ) {


                if ( ( is_checkout() && !is_wc_endpoint_url( 'order-pay' ) ) || apply_filters('yith_wcpmr_restriction_by',false) ) {

                    $item_cart = ( isset( $order_cart['items'] ) ) ? $order_cart['items']  : ( isset( WC()->cart ) ?  WC()->cart->get_cart() : '' ) ;

                }else {

                    global $wp;
                    $order_id = $wp->query_vars['order-pay'];
                    $order = wc_get_order( $order_id );

                    if( $order ) {

                        $item_cart = $order->get_items();

                    } else {
                        $item_cart ='';
                    }

                }

                if(!$item_cart) {
                    return true;
                }

                $products_in_cart = array();
                foreach ( $item_cart as $cart_item_key => $cart_item ) {

                    $product_id = isset($cart_item['variation_id']) ? $cart_item['variation_id'] :  $cart_item['product_id'];
                    $products_in_cart[] = $product_id;
                }

                $selected_products = $condition['subscription'];


                switch( $condition['restriction_by'] ){
                    case 'include_or':

                        if( ! empty( $selected_products ) && ! empty( $products_in_cart ) ){
                            $found = false;
                            foreach( (array) $selected_products as $product ){
                                if( in_array( $product, $products_in_cart ) ){
                                    $found = true;
                                    break;
                                }
                            }

                            if( ! $found ){
                                return false;
                            }
                        }
                        elseif( ! empty( $selected_products ) ){
                            return false;
                        }

                        break;
                    case 'include_and':

                        if( ! empty( $selected_products ) && ! empty( $products_in_cart ) ){
                            foreach( (array) $selected_products as $product ){
                                if( ! in_array( $product, $products_in_cart ) ){
                                    return false;
                                    break;
                                }
                            }
                        }
                        elseif( ! empty( $selected_products ) ){
                            return false;
                        }

                        break;
                    case 'exclude_or':

                        if( ! empty( $selected_products ) && ! empty( $products_in_cart ) ){
                            foreach( (array) $selected_products as $product ){
                                if( in_array( $product, $products_in_cart ) ){
                                    return false;
                                    break;
                                }
                            }
                        }
                        elseif( ! empty( $selected_products ) ){
                            return false;
                        }

                        break;
                }
                
            }

            return true;

        }

    }
}

return new YITH_WCPMR_Subscription_Compatibility();