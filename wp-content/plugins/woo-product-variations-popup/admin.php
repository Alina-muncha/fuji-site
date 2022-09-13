<?php
/**
 *  Adding action for admin menu. 
 */
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_action('admin_menu', 'WPVP_register_menu', 99);
}

/**
 *  Registring admin menu. 
 */
function WPVP_register_menu() {
    add_submenu_page('woocommerce', 'Variations Popup', 'Variations Popup Settings', 'manage_options', 'wpvp_settings', 'WPVP_settings_callback');
}

/**
 *  Admin setting page callback. 
 */
function WPVP_settings_callback() {

    if (isset($_POST['submit'])) {
        $WPVP_popup = (isset($_POST['WPVP_popup'])) ? 'true' : 'false';
        $WPVP_button_text = (isset($_POST['WPVP_button_text'])) ? sanitize_text_field($_POST['WPVP_button_text']) : 'Select Options';
        $WPVP_product_title = (isset($_POST['WPVP_product_title'])) ? 'true' : 'false';
        $WPVP_product_price = (isset($_POST['WPVP_product_price'])) ? 'true' : 'false';

        update_option('WPVP_popup', $WPVP_popup);
        update_option('WPVP_button_text', $WPVP_button_text);
        update_option('WPVP_product_title', $WPVP_product_title);
        update_option('WPVP_product_price', $WPVP_product_price);
    }


    $WPVP_popup = get_option('WPVP_popup', true);
    $WPVP_button_text = get_option('WPVP_button_text', 'Select Options');
    $WPVP_product_title = get_option('WPVP_product_title', true);
    $WPVP_product_price = get_option('WPVP_product_price', true);
    ?>

    <div class="wrap">
        <h1>Product Variations Settings</h1>
        <form method="post">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label>Popup Status</label></th>
                        <td>
                            <label for="WPVP_popup">
                                <input name="WPVP_popup" type="checkbox" value="true" <?php echo ($WPVP_popup == 'true') ? 'checked="checked"' : '' ?>>
                                Enable
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label>Popup Button Text</label></th>
                        <td>
                            <input name="WPVP_button_text" type="text" class="regular-text" value="<?php echo esc_html($WPVP_button_text); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label>Popup Settings</label></th>
                        <td>
                            <label for="WPVP_product_title"><input name="WPVP_product_title" type="checkbox" id="WPVP_title" value="true" <?php echo ($WPVP_product_title == 'true') ? 'checked="checked"' : '' ?>> Include product title in popup</label>
                            <br />
                            <label for="WPVP_product_price"><input name="WPVP_product_price" type="checkbox" id="WPVP_title" value="true" <?php echo ($WPVP_product_price == 'true') ? 'checked="checked"' : '' ?>> Include product price in popup</label>

                        </td>
                    </tr>

                </tbody>
            </table>


            <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
        </form>

    </div>

    <?php
}
