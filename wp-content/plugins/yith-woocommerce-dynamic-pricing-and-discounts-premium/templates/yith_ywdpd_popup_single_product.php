<?php

/**
 * Popup gift single product.
 *
 * @package YITH WooCommerce Dynamic Pricing and Discounts Premium
 * @since   1.0.0
 * @version 1.6.0
 * @author  YITH
 *
 * @var integer $rule_id
 * @var integer $product_id
 */

if ( ! defined( 'ABSPATH' ) && ! isset( $product_id ) ) {
	exit;
}

$single_product = wc_get_product( $product_id );

?>
<div class="single-product">
	<div class="ywdpd_step2_header">
		<span class="ywdpd_back"></span>
		<h4 class="ywdpd_rule_title"><?php esc_html_e( 'Select a variation', 'ywdpd' ); ?></h4>
	</div>
	<div id="product-<?php echo esc_attr( $product_id ); ?>" class="ywdpdp_single_product product">
		<div class="ywdpd_single_product_left">
			<?php
			echo $single_product->get_image(  ); //phpcs:ignore
			echo "<h5>".$single_product->get_name()."</h5>"; //phpcs:ignore
			?>
			<span class="price" style="display: none;">
			</span>
		</div>
		<div class="ywdpd_single_product_right">
			<?php
			if ( 'variable' === $single_product->get_type() ) {

				global $product;

				$product = $single_product;
				woocommerce_variable_add_to_cart();
				?>
				<div class="ywdpd_button_add_to_gift">
					<?php
						$add_to_cart_button = __( 'Save options', 'ywdpd' ) ;
					?>
					<button
						class="ywdpd_add_to_gift button single_add_to_cart_button disabled"><?php echo esc_html( $add_to_cart_button ); ?></button>
					<input type="hidden" class="ywdpd_rule_id" value="<?php echo esc_attr( $rule_id ); ?>">
					<input type="hidden" class="ywdpd_rule_type" value="<?php echo esc_attr( $rule_type ); ?>">
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
