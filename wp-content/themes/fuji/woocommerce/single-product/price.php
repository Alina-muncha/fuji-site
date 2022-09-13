<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
$tax_rates = WC_Tax::get_rates( $product->get_tax_class() );

$price_incl = $product->get_price_including_tax();  // price included VAT


?>
<div class="my-3">
	<h3 class="me-2 mb-0">
	<p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php echo $product->get_price_html(); ?></p>
	
	<span class="text-success h6"></span>
    <?php 
    $discount = (string) YITH_WC_Dynamic_Pricing()->get_discount_price( $product->get_price(), $product );
    foreach($tax_rates as $tax_rate){
        $tax_percentage = $tax_rate["rate"];
    } ?>
	<span class="text-success h6">
  <?php if(get_locale() == 'ja') { 
                                    echo "税 ";
                                  }
                                    else{
                                      echo "Tax ";
                                      }
                                ?> 
    <?php echo $tax_percentage . "%"; ?>. (
      <?php if(get_locale() == 'ja') { 
                                    echo "税引き後 ";
                                  }
                                    else{
                                      echo "After tax ";
                                      }
                                ?> 
      <?php $price_inc = (($tax_percentage/100) * $discount) + $discount;
	      echo woocommerce_price( $price_inc ); ?>)</span>
	</h3>
    </div>
                <div class="mb-3">
                <?php if(get_field('bulk_note')){?>
                  <span class="text-muted">(<?php the_field('bulk_note');?>)</span>
                  <?php } ?>
                  </div>
                    <div class="mb-3">
                    <span class="text-dark fw-bold">
                    <?php if(get_locale() == 'ja') { 
                                    echo "富士コード: ";
                                  }
                                    else{
                                      echo "Fuji Code: ";
                                      }
                                ?>    
                     </span>
                    <span class="text-muted">
                   <?php echo get_post_meta(get_the_ID(),'_sku',true);?>
                    </span>
                </div>
               
                <div class="mb-3">
                    <span class="text-dark fw-bold">
                    <?php if(get_locale() == 'ja') { 
                                    echo "メーカー: ";
                                  }
                                    else{
                                      echo "Manufacturer: ";
                                      }
                                ?>       
                    </span>
                    <span class="text-muted"><?php the_field('manufacturer');?></span>
                </div>
                <!-- <div class="mb-3">
                    <span class="text-dark fw-bold">
                    <?php if(get_locale() == 'ja') { 
                                    echo "重さ: ";
                                  }
                                    else{
                                      echo "Weight: ";
                                      }
                                ?>       
                    </span>
                    <span class="text-muted">
                        <?php echo get_post_meta(get_the_ID(), '_weight', true) . ' ' . get_option('woocommerce_weight_unit');?> </span>
                </div> -->
                <div class="mb-3">
                    <span class="text-dark fw-bold">
                    <?php if(get_locale() == 'ja') { 
                                    echo "タグ: ";
                                  }
                                    else{
                                      echo "Tags: ";
                                      }
                                ?>       
                    </span>
                        <span class="text-muted"> 
                          <?php 
                          global $product;
                          $tags = $product->tag_ids;
                          $tagArray = [];
                          foreach($tags as $tag) {
                          $tagArray[] = get_term($tag )->name;
                          };
                          echo implode(", ",$tagArray);
                          ?> 
                        </span>
                </div>

                <div class="mb-3">
                    <span class="text-dark fw-bold">
                    <?php if(get_locale() == 'ja') { 
                                    echo "JANコード: ";
                                  }
                                    else{
                                      echo "JAN Code: ";
                                      }
                                ?>   
                                </span>
                    <span class="text-muted"><?php $key_1_value = get_post_meta( get_the_ID(), 'ywbc_barcode_display_value_custom_field');
                        echo $key_1_value[0];?>
                        </span>
                </div>
                <div class="mb-3">
                <?php if ( is_user_logged_in() ) { ?>
                 <?php echo do_shortcode("[yith_wcwl_add_to_wishlist]    "); ?>
                 <?php } ?>
                </div>
               
                <!-- <div class="row">
                    <div class="col-4 col-sm-3">
                        <label for="quantity" class="form-label fw-bold">
                        <?php if(get_locale() == 'ja') { 
                                    echo "量: ";
                                  }
                                    else{
                                      echo "Quantity";
                                      }
                                ?>       
                        </label>
                    </div>
                </div> -->
</div>