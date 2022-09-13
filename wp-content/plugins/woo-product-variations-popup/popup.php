
<div class="wpvp-popup" id="wpvp-popup-<?php echo $product_id; ?>">

    <div class="popup-inner">
        <a href="javascript:void(0)" class="wpvp-popup-close">x</a>
        <div class="popup-content">
            <div class="product-title-price">
                <?php
                $WPVP_product_title = get_option('WPVP_product_title', true);
                if ($WPVP_product_title == 'true') {
                    echo '<div class = "product-title">' . $product->get_title() . '</div>';
                }
                $WPVP_product_price = get_option('WPVP_product_price', true);
                if ($WPVP_product_price == 'true') {
                    woocommerce_template_single_price();
                }
                ?>
            </div>
            <?php woocommerce_variable_add_to_cart(); ?>
        </div>


    </div>
</div>