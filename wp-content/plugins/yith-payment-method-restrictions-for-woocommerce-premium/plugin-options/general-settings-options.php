<?php
return array(

    'general-settings' => apply_filters( 'yith_wcpmr_settings_options', array(

            //////////////////////////////////////////////////////

            'settings_tab_payment_restriction_options_start'    => array(
                'type' => 'sectionstart',
                'id'   => 'yith_wcpmr_settings_tab_payment_restriction_start'
            ),

            'settings_tab_payment_restriction_options_title'    => array(
                'title' => esc_html_x( 'General settings', 'Panel: page title', 'yith-payment-method-restrictions-for-woocommerce' ),
                'type'  => 'title',
                'desc'  => '',
                'id'    => 'yith_wcpmr_settings_tab_payment_restriction_title'
            ),
            'settings_tab_payment_restriction_show_name' => array(
                'title'   => esc_html_x( 'Show Payment Restriction option for shop manager', 'Admin option: Show Payment Restriction option for shop managers', 'yith-payment-method-restrictions-for-woocommerce' ),
                'type'    => 'checkbox',
                'desc'    => esc_html_x( 'Check this option to manage payment restriction option for shop manager role', 'Admin option description: Check this option to manage payment restriction option for shop manager role', 'yith-payment-method-restrictions-for-woocommerce' ),
                'id'      => 'yith_wcpmr_settings_tab_payment_restriction_allow_shop_manager',
                'default' => 'no'
            ),

            'settings_tab_payment_restriction_geolocalization_how_work' => array(
                'name' => esc_html__('How does geolocation work?', 'yith-payment-method-restrictions-for-woocommerce'),
                'type'    => 'yith-field',
                'yith-type' => 'radio',
                'id' => 'yith_wcpmr_get_geolocalization_how_work',
                'options' => array(
                    'ip' => esc_html__('Using IP Geolocalization', 'yith-payment-method-restrictions-for-woocommerce'),
                    'billing_country' => esc_html__('Using Billing Country', 'yith-payment-method-restrictions-for-woocommerce'),
                ),
                'default' => 'ip',
            ),

            'settings_tab_payment_restriction_options_end'      => array(
                'type' => 'sectionend',
                'id'   => 'yyith_wcpmr_settings_tab_payment_restriction_end'
            ),

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        )
    )
);
