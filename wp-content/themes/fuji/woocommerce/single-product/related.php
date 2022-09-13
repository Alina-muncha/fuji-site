<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<section class="related products text-center">

		<?php
		$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Similar products', 'woocommerce' ) );

		if ( $heading ) :
			?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		<span class="seperator"></span>
		
		<div class="row g-3">

			<?php foreach ( $related_products as $related_product ) : ?>
									
					<?php
					$related_productid = $related_product->get_id();
					
					?>
					 <div class="col-6 col-sm-6 col-md-3 mb-3 mb-lg-0">
                <div class="card rounded-0 border-0">
                    <div class="position-relative overflow-hidden">
                        <a href="<?php echo  get_the_permalink($related_productid);?>">
                            <figure class="
                    h-20
                    border border-secondary
                    mb-0
                    d-flex
                    align-items-center
                    p-1
                  ">
                                <img class="w-100 obj-fit-cover" src="<?php echo get_the_post_thumbnail_url($related_productid); ?>" alt="Card image cap" />
                            </figure>
                        </a>
                        <div class="position-absolute top-0 p-3"></div>
                        <div class="product-overlay-items opacity-100">
                            <button class="btn bg-warning text-white rounded-0 d-block d-lg-none" onclick='alert("I am an alert box!")'>
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="currentColor"
                                class="bi bi-bag"
                                viewBox="0 0 16 16"
                              >
                                <path
                                  d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"
                                />
                              </svg>
                            </button>
                        </div>
                        <div class="product-overlay-items">
                          <?php
                          $_product = wc_get_product( $related_productid );
                          if($_product->is_type( 'simple' )){ ?>
                          <form action="<?php echo get_site_url(); ?>/cart/" method="post" enctype="multipart/form-data">
                            <?php $title = $_product->get_meta( 'product_code' ); ?>
                            <input type="text" id="cfwc-product-code" name="cfwc-product-code" value="<?php echo $title; ?>" style="display: none;">
                            <button class="btn bg-warning text-white rounded-0 d-block btn-add-to-cart" type="submit" name="add-to-cart" value="<?php echo $related_productid; ?>">
                            <?php if(get_locale() == 'ja') { 
                                              echo "カートに追加";
                                            }
                                              else{
                                                echo "Add to cart";
                                                }
                                          ?>  
                          </button>
                          </form>
                          <?php }
                          else { ?>
                          <a href="<?php the_permalink(); ?>" class="btn bg-primary text-white rounded-0 btn-variant">
                          <?php if(get_locale() == 'ja') { 
                              echo "バリアントを選択";
                            }
                              else{
                                echo "Choose Variant";
                                }
                          ?>
                        </a>
                          <?php } ?>
                    </div>
                    </div>
                    <div class="">
                        <a href="<?php echo  get_the_permalink($related_productid);?>">
                            <p class="mb-1 text-muted elipsis-2">
                            <?php echo get_the_title($related_productid); ?>
                            </p>
                        </a>
                        <div>
                            <span class="fw-bold"> 
                            <?php  //echo get_post_meta(get_the_ID(), '_regular_price', true);

                        echo $_product->get_price_html();
                         ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

			<?php endforeach; ?>

			
			</div>
	</section>
	<?php
endif;

wp_reset_postdata();
