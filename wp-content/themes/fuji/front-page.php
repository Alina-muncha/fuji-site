<?php get_header(); ?>

    <div class="bg-dark d-flex flex-row-reverse flex-direction-row">     
      <div class="text-white me-4 text-medium">        
          <p class="mb-6">
           <a style="color: white;" href="<?php echo get_site_url();?>/my-account/">
            <?php if (get_locale() == 'ja') {
              echo "いらっしゃいませ、";
            } else {
              echo "If you are a new here, click here to get registered.";
            }
            ?>
            </a>
          </p>
          </div>          
      </div>
    <!-- Main Banner -->
    <section>
      <div id="main-banner" class="owl-carousel main-banner-carousel">
      <?php if(have_rows('slider')):
        while(have_rows('slider')): the_row();?>
        <div class="item">
          <div class="position-relative main-banner overflow-hidden">
            <img
              class="w-100 h-100 obj-fit-cover"
              src="<?php the_sub_field('image');?>"
            />
            <div class="container-xl px-3 px-xxl-5 caption text-white">
              <p class="mb-0">
              <?php the_sub_field('small_quotes');?>
              </p>
              <p class="display-4 fw-bold text-uppercase mb-1">
              <?php the_sub_field('longer_quotes');?> 
              </p>
              <p class="display-4 fw-bold text-uppercase mb-1">
              <?php the_sub_field('longer_quotes2');?>
              </p>
              <div>
                <a href="<?php the_sub_field('button_link');?>" class="btn btn-success rounded-0 p-2 px-3">
                <?php if(get_locale() == 'ja') { 
                    echo "今すぐ購入";
                  }
                    else{
                      echo "Shop now";
                      }
                ?>
                </a>
              </div>
            </div>
			  </div>
        </div>
            <?php endwhile; endif; ?> 
          
      </div>
    </section>

     <!-- Icons Menu Section -->
     <section class="bg-primary">
        <div class="container-xl text-white py-5 px-3 px-xxl-5">
            <div class="owl-carousel owl-theme icons-menu-carousel px-4 px-lg-0">
            <?php if(have_rows('icon_section')):
              while(have_rows('icon_section')): the_row();?>
            <div class="item text-center">
                      <a href="<?php the_sub_field('icon_link');?>">
                      <?php $icon = get_sub_field('icon');  ?>
                <img width="70" height="70" src="<?php echo $icon['url']; ?>"/>
                  <path
                    d="M4.10156 61.6602H16.4062V37.0508H20.5078V32.9492H12.3047V20.6445H16.9821L13.9059 8.33984H6.60187L3.5257 20.6445H8.20312V32.9492H0V37.0508H4.10156V61.6602ZM9.80437 12.4414H10.7034L11.7288 16.543H8.77898L9.80437 12.4414ZM12.3047 57.5586H8.20312V37.0508H12.3047V57.5586Z"
                  ></path>
                  <path
                    d="M45.2539 20.6445V8.33984H41.1523V12.4414H37.0508V8.33984H30.8984C25.2305 8.33984 20.5078 12.9246 20.5078 18.5938V20.6445H28.8477V24.7461H24.6094V61.6602H37.0508V24.7461H32.9492V20.6445H37.0508V16.543H41.1523V20.6445H45.2539ZM32.9492 57.5586H28.7109V28.8477H32.9492V57.5586ZM32.9492 16.543H24.9833C25.8684 14.1802 28.2201 12.4414 30.8984 12.4414H32.9492V16.543Z"
                  ></path>
                  <path
                    d="M70 18.5938C70 12.9258 65.2786 8.33984 59.6094 8.33984C53.9554 8.33984 49.3555 12.9397 49.3555 18.5938C49.3555 21.8308 50.9011 24.8742 53.457 26.7969V43.2031C50.9011 45.1258 49.3555 48.1693 49.3555 51.4062C49.3555 57.0603 53.9554 61.6602 59.6094 61.6602C65.2773 61.6602 70 57.0753 70 51.4062C70 48.2013 68.4023 45.1529 65.7617 43.1974V26.8026C68.4023 24.8471 70 21.7987 70 18.5938ZM65.8984 51.4062C65.8984 54.7412 63.0185 57.5586 59.6094 57.5586C56.217 57.5586 53.457 54.7987 53.457 51.4062C53.457 47.1513 57.3152 45.7049 57.5586 45.4835V24.5165C57.2988 24.2802 53.457 22.8598 53.457 18.5938C53.457 15.2013 56.217 12.4414 59.6094 12.4414C63.0185 12.4414 65.8984 15.2588 65.8984 18.5938C65.8984 22.7358 61.8987 24.3037 61.6602 24.5165V45.4833C61.9377 45.7311 65.8984 47.2254 65.8984 51.4062Z"
                  ></path>
                  <path
                    d="M61.6602 16.543H57.5586V20.6445H61.6602V16.543Z"
                  ></path>
                  <path
                    d="M61.6602 49.3555H57.5586V53.457H61.6602V49.3555Z"
                  ></path>
               
                          <h5 class="text-white"><?php the_sub_field('icon_name'); ?></h5>
                      </a>
                </div> 
                <?php endwhile; endif; ?>               
            </div>
        </div>
    </section>

    <!-- Grid Box Section -->
    <section class="my-5">
      <div class="container-xl px-4 px-lg-3 px-xxl-5">
        <div class="row g-3 flex-column-reverse flex-md-row grid-container">
          <div class="col-md-7 col-lg-8">
            <div class="flex flex-direction-column gap-0">
              <div class="mb-2 h-20 position-relative overflow-hidden">
                <img
                  class="h-100 w-100 obj-fit-cover"
                  src="<?php the_field('image1'); ?>"
                  />
                <div
                  class="
                    position-absolute
                    bottom-0
                    p-4
                    text-white
                    col-12 col-md-6
                    z-index-1
                  "
                >
                  <p class="mb-1 text-dark"><?php the_field('subtitle1'); ?></p>
                  <h1 class="text-dark"><?php the_field('title1'); ?></h1>
                  <a href="<?php the_field('title1_link'); ?>" class="btn btn-success rounded-0"> 
                  <?php if(get_locale() == 'ja') { 
                        echo "今すぐ購入";
                      }
                        else{
                          echo "Shop now";
                          }
                    ?>
                  </a>
                </div>
              </div>
              <div class="h-20 position-relative overflow-hidden">
                <img
                  class="h-100 w-100 obj-fit-cover"
                  src="<?php the_field('image2'); ?>"
                />
                <div
                  class="
                    position-absolute
                    bottom-0
                    p-4
                    text-white
                    col-12 col-md-6
                    z-index-1
                  "
                >
                  <p class="mb-1 text-dark"><?php the_field('subtitle2'); ?></p>
                  <h1 class="text-dark"><?php the_field('title2'); ?></h1>
                  <a href="<?php the_field('title2_link'); ?>" class="btn btn-success rounded-0"> 
                  <?php if(get_locale() == 'ja') { 
                        echo "今すぐ購入";
                      }
                        else{
                          echo "Shop now";
                          }
                    ?>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-5 col-lg-4 grid-item1-h">
            <div class="position-relative p-0 grid-item1-h">
              <img
                class="h-100 w-100 obj-fit-cover"
                src="<?php the_field('image3'); ?>"
              />
              <div
                class="
                  position-absolute
                  bottom-0
                  p-4
                  text-white
                  col-12 col-md-6
                  z-index-1
                "
              >
                <p class="mb-1"><?php the_field('subtitle3'); ?></p>
                <h1><?php the_field('title3'); ?></h1>
                <a href="<?php the_field('title3_link'); ?>" class="btn btn-success rounded-0"> 
                <?php if(get_locale() == 'ja') { 
                    echo "今すぐ購入";
                  }
                    else{
                      echo "Shop now";
                      }
                ?>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- New Products Section-->
    <section class="my-5 container-xl px-4 px-lg-3 px-xxl-5">
      <div class="my-4">
        <h4 class="text-center">
        <?php if(get_locale() == 'ja') { 
          echo "新商品";
            }
          else{
            echo "New Products";
          }
          ?>
      
        </h4>
        <span class="seperator"></span>
      </div>
      <div class="row g-3">
      <?php
					$latest_product = new WP_Query( array(
					    'posts_per_page' => 4,
						  'post_type'		=> 'product',
						  'order' => 'DESC',
						  'orderby' => 'date',
						 
						 ) ); ?>
						<?php 
						if( $latest_product->have_posts()):
							while( $latest_product->have_posts() ) : $latest_product->the_post(); ?> 
        <!-- Product with Add to Cart Option-->
        <div class="col-6 col-sm-6 col-md-3 mb-3 mb-lg-0">
          <div class="card rounded-0 border-0">
            <div class="position-relative overflow-hidden">
              <a href="<?php the_permalink();?>">
                <figure class="h-20 border border-secondary mb-0 d-flex align-items-center p-1">
                  <?php $product_image = get_the_post_thumbnail_url();
                if($product_image){ ?>  
                <img
                    class="h-100 w-100 obj-fit-cover"
                    src="<?php the_post_thumbnail_url(); ?>"
                    alt="<?php the_title(); ?>"
                  />
                  <?php  }
            else{ ?>
            <img
                    class="h-100 w-100 obj-fit-cover"
                    src="<?php echo DEFAULT_IMAGE;?>"
                    alt="<?php the_title(); ?>"
                  />
                <?php  }?>
                </figure>
              </a>
              <div class="position-absolute top-0 p-3"></div>
              <div class="product-overlay-items opacity-100">
              <div class="product-overlay-items">
                
              </div>

                  <button
                  class="btn bg-warning text-white rounded-0 d-block d-lg-none"
                  onclick='alert("I am an alert box!")'
                >
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
                <?php if($product->is_type( 'simple' )){ ?>
                <form action="<?php echo get_site_url(); ?>/cart/" method="post" enctype="multipart/form-data">
                  <?php $title = $product->get_meta( 'product_code' ); ?>
                  <input type="text" id="cfwc-product-code" name="cfwc-product-code" value="<?php echo $title; ?>" style="display: none;">
                  <button class="btn bg-warning text-white rounded-0 d-block btn-add-to-cart" type="submit" name="add-to-cart" value="<?php the_ID(); ?>">
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
              <a href="<?php the_permalink();?>">
                <p class="mb-1 text-muted">
                <?php the_title();?>
                </p>
              </a>
              <div>
                <span class="fw-bold"> 
                  <?php  //echo get_post_meta(get_the_ID(), '_regular_price', true);
                        $_product = wc_get_product( get_the_ID() );
                        echo $_product->get_price_html();
                        
                         ?>
                </span>
              </div>
            </div>
          </div>
        </div>

        <?php
							endwhile;
							wp_reset_postdata();
						endif; ?>
       
      </div>
    </section>

    <section class="my-5 container-xl px-4 px-lg-3 px-xxl-5">
      <div class="row">
      <?php 
        $terms = get_field('feature_category');
        if( $terms ): ?>

        <?php foreach( $terms as $term ): ?>
        <div class="col-12 col-md-4 mt-3 md-md-0">
          <a href="<?php echo esc_url( get_term_link( $term ) ); ?>">
            <div class="border">
              <h5 class="text-center mt-4 text-dark"><?php echo esc_html( $term->name ); ?></h5>
              <figure class="m-0 overflow-hidden scalable h-22">
              <?php  $thumbnail_id  = (int) get_woocommerce_term_meta( $term->term_id, 'colored_image', true );
                $term_img  = wp_get_attachment_url( $thumbnail_id );
              ?> 
              <img
                  class="h-100 w-100 obj-fit-cover"
                  src="<?php echo $term_img; ?>"
                />
              </figure>
              
            </div>
          </a>
         
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>

    <!-- Featured Products Section -->
    <section class="my-5 container-xl px-4 px-lg-3 px-xxl-5">
    <div class="my-4">
      <h4 class="text-center">

        <?php if(get_locale() == 'ja') { 
      echo "注目商品";
        }
      else{
        echo "Featured Products";
      }
      ?>
      </h4>
      <span class="seperator"></span>
      </div>
      <h5 class="text-center mb-4"></h5>
      <div class="row">
      <?php
            $loop = new WP_Query(array(
            'posts_per_page' => 1,
                'post_type'  => 'product',
                'orderby' => 'date', 
                'order' => 'DESC',
                 'tax_query' => array( array(
                                  'taxonomy' => 'product_visibility',
                                  'field'    => 'name',
                                  'terms'    => 'featured',
                                  'operator' => 'IN', // or 'NOT IN' to exclude feature products
                                      ),
                    ),

                ));
                $counter = 1;
                    if ($loop->have_posts()) :
                        while ($loop->have_posts()) : $loop->the_post();?>
        <div class="col-12 col-md-12 col-lg-4 mb-3 mb-lg-0">
			<?php $product_image = get_the_post_thumbnail_url(); 
          if($product_image){ ?>
          <div class="position-relative h-100 featured-img"
            style="background-image: url(<?php the_post_thumbnail_url(); ?>);">
			  <?php  }
            else{ ?> 
			  <div class="position-relative h-100 featured-img"
            style="background-image: url(<?php echo DEFAULT_IMAGE; ?>);">
				  <?php } ?>
            <div
              class="
                position-absolute
                bottom-0
                mb-5
                p-4
                text-white
                col-12
                z-index-1
              "
            >
              <div class="d-flex">
                <div>
                  <h1 class="mb-1 display-4 fw-bold"><?php the_title();?></h1>
                  <h5 class="text-warning mb-3">
                  <?php if(get_locale() == 'ja') { 
                      echo "から始める";
                        }
                      else{
                        echo "Starting From";
                      }
                      ?>
                  </h5>
                </div>
                <h1 class="text-warning display-4 fw-bold">
                  <?php echo get_woocommerce_currency_symbol(); ?>
                    <?php echo get_post_meta(get_the_ID(), '_regular_price', true); ?>
                  </h1>
              </div>
              <a href="<?php the_permalink(); ?>" class="btn btn-warning text-white rounded-0">
              <?php if(get_locale() == 'ja') { 
                  echo "今すぐ購入";
                }
                  else{
                    echo "Shop now";
                    }
              ?>
              </a>
            </div>
            <div class="overlay position-absolute top-0 bottom-0"></div>
          </div>
        </div>
        <?php $counter++;
                        endwhile;
                    endif;
                    wp_reset_postdata(); 
            ?>
        
        <div class="col-12 col-md-12 col-lg-8 mt-3 mt-md-0">
          <div class="row g-4">

          <?php
					$loop = new WP_Query( array(
					  'posts_per_page' => 9,
						'post_type'		=> 'product',
						'order' => 'DESC',
						'orderby' => 'date',
						'tax_query' => array( array( 	'taxonomy' => 'product_visibility',
											    'field'    => 'name',
											    'terms'    => 'featured',
											    'operator' => 'IN', // or 'NOT IN' to exclude feature products
											), ),
						 ) ); ?>
						<?php 
            $counter = 1;
						if( $loop->have_posts()):
							while( $loop->have_posts() ) : $loop->the_post(); 
              if ($counter>1): ?> 

            <div class="col-6 col-sm-6 col-md-3 mb-3 mb-lg-0">
              <div class="card rounded-0 border-0">
                <div class="position-relative">
                  <a href="<?php the_permalink();?>">
                    <figure
                      class="h-12 border border-secondary mb-0 overflow-hidden position-relative d-flex align-items-center p-2">
						<?php $product_image = get_the_post_thumbnail_url();
                        if($product_image){ ?> 
                      <img
                        class="w-100 obj-fit-cover"
                        src="<?php the_post_thumbnail_url(); ?>"
                        alt="<?php the_title(); ?>"
                      />
						<?php  }
                        else{ ?>
						<img
                        class="w-100 obj-fit-cover"
                        src="<?php echo DEFAULT_IMAGE; ?>"
                        alt="<?php the_title(); ?>"
                      />
                      <?php }?>
                    </figure>
                  </a>

                  <div class="product-overlay-items opacity-100">
                    <button
                      class="
                        btn
                        bg-warning
                        text-white
                        rounded-0
                        d-block d-lg-none
                      "
                      onclick='alert("I am an alert box!")'
                    >
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
                  <div class="product-overlay-items d-none d-lg-block">
                  <?php if($product->is_type( 'simple' )){ ?>
                <form action="<?php echo get_site_url(); ?>/cart/" method="post" enctype="multipart/form-data">
                  <?php $title = $product->get_meta( 'product_code' ); ?>
                  <input type="text" id="cfwc-product-code" name="cfwc-product-code" value="<?php echo $title; ?>" style="display: none;">
                  <button class="btn bg-warning text-white rounded-0 d-block btn-add-to-cart" type="submit" name="add-to-cart" value="<?php the_ID(); ?>">
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
                  <a href="<?php the_permalink();?>">
                    <p class="mb-1 text-muted ">
                    <?php the_title();?>
                    </p>
                  </a>
                  <div>
                    <span class="fw-bold"> 
                    <?php $_product = wc_get_product( get_the_ID() );
                        echo $_product->get_price_html(); ?>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <?php
            endif;
            $counter++;
							endwhile;
							wp_reset_postdata();
						endif; ?>

          </div>
        </div>
      </div>
    </section>

    <!-- Sale Section -->
<!--     <section class="my-5 container-xl px-4 px-lg-3 px-xxl-5">
      <div class="my-4">
        <h4 class="text-center">
        <?php if(get_locale() == 'ja') { 
            echo "セール品";
              }
            else{
              echo "On Sale";
            }
            ?>
        </h4>
        <span class="seperator"></span>
      </div>
      <div class="row g-4">
      <?php
					$latest_product = new WP_Query( array(
					    'posts_per_page' => 4,
						  'post_type'		=> 'product',
						  'order' => 'DESC',
						  'orderby' => 'date',
						  'tax_query' => array( array( 	'taxonomy' => 'product_cat',
							'field'    => 'slug',
							'terms'    => 'on-sale',
											   
											), ),
						 ) ); ?>
						<?php 
						if( $latest_product->have_posts()):
							while( $latest_product->have_posts() ) : $latest_product->the_post(); ?> 
       
        <div class="col-6 col-sm-6 col-md-3 mb-3 mb-lg-0">
                <div class="card rounded-0 border-0">
                    <div class="position-relative overflow-hidden">
                        <a href="<?php the_permalink();?>">
                            <figure class="
                    h-16
                    border border-secondary
                    mb-0
                    d-flex
                    align-items-center
                    p-1 overflow-hidden
                  ">
                                <img class="w-100 obj-fit-cover" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" />
                            </figure>
                        </a>

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
                        <?php if($product->is_type( 'simple' )){ ?>
                        <form action="<?php echo get_site_url(); ?>/cart/" method="post" enctype="multipart/form-data">
                  <?php $title = $product->get_meta( 'product_code' ); ?>
                  <input type="text" id="cfwc-product-code" name="cfwc-product-code" value="<?php echo $title; ?>" style="display: none;">
                  <button class="btn bg-warning text-white rounded-0 d-block btn-add-to-cart" type="submit" name="add-to-cart" value="<?php the_ID(); ?>">
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
                        <a href="<?php the_permalink();?>">
                            <p class="mb-1 text-muted elipsis-2">
                            <?php the_title(); ?>
                           </p>
                        </a>
                        <div>
                            <span class="fw-bold"> 
                               <?php $_product = wc_get_product( get_the_ID() );
                        echo $_product->get_price_html(); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        <?php
							endwhile;
							wp_reset_postdata();
						endif; ?>
      </div>
    </section> -->

    <!-- new manufacturer -->

    <section class="my-5 container-xl px-3 px-xxl-5">
      <h5 class="text-center">
      <?php if(get_locale() == 'ja') { 
          echo "トップメーカー";
        }
          else{
            echo "Top Manufacturers";
            }
      ?>  
      </h5>
      <span class="seperator"></span>
      <div class="row g-2">

          <?php $package_posts = get_field('manufacturer');
            if( $package_posts): ?>
            <?php foreach( $package_posts as $post ): 
                setup_postdata($post);
              ?>

        <div class="col-4 col-sm-2 text-center">
          <a href= "<?php the_permalink(); ?>"><img
            class="img-fluid"
            src="<?php echo get_the_post_thumbnail_url(); ?>"
          /></a>
          <figcaption class="mb-1 text-muted elipsis-2"><?php the_title(); ?></figcaption>
        </div>

        <?php endforeach; 
          // Reset the global post object so that the rest of the page works correctly.
          wp_reset_postdata(); ?>
      <?php endif; ?>
      </div>
    </section>

    <!-- end manufacturer -->

    <!-- <section class="my-5 container-xl px-3 px-xxl-5">
      <h5 class="text-center">
      <?php if(get_locale() == 'ja') { 
          echo "トップメーカー";
        }
          else{
            echo "Top Manufacturers";
            }
      ?>  
      </h5>
      <span class="seperator"></span>
      <div class="row g-2">
      <?php if(have_rows('manufacturers', 'option')):
        while(have_rows('manufacturers', 'option')): the_row();?>
        <div class="col-4 col-sm-2 text-center">
          <a href= "<?php get_site_url(); ?>/product-search/?manufacturer=<?php the_sub_field('name');?>"><img
            class="img-fluid"
            src="<?php the_sub_field('image');?>"
          /></a>
          <figcaption class="mb-1 text-muted elipsis-2"><?php the_sub_field('name');?></figcaption>
        </div>
        <?php endwhile; endif; ?> 
      </div>
    </section> -->

    <!-- Modal For Variant-->

    <div
      class="modal fade"
      id="variantModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-0 position-relative">
          <button
            type="button"
            class="
              btn btn-dark
              position-absolute
              top-0
              start-100
              translate-middle
              z-index-1
              btn-sm
            "
            data-bs-dismiss="modal"
            aria-label="Close"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="16"
              height="16"
              fill="currentColor"
              class="bi bi-x"
              viewBox="0 0 16 16"
            >
              <path
                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
              />
            </svg>
          </button>
          <div class="modal-body p-3">
            <div class="row">
              <div class="col-12 col-lg-6">
                <figure class="h-100 w-100 overflow-hidden mb-0">
                  <img
                    class="h-100 w-100 obj-fit-cover"
                    src="https://cdn.shopify.com/s/files/1/0448/0765/1493/products/dewalt-dw920k-2-1-4-inch-7-2-volt-cordless-two-position-screwdriver-kit_1_377x380.png?v=1595925372"
                  />
                </figure>
              </div>
              <div class="col-12 col-lg-6">
                <a href="#">
                  <p class="text-muted">
                    Makita LCT200W 18-Volt Compact Lithium-Ion Cordless Combo
                    Kit 2-Piece...
                  </p>
                </a>
                <h2>$ 200.00</h2>
                <p>
                  <span class="text-decoration-line-through">$ 135.00</span>
                  Save 11 %
                </p>
                <p>
                  Our goods have a great number of different useful and
                  functional options The products of our store are the perfect
                  combination of a real reliability and durability. We assure
                  yo...
                </p>
                <div class="mb-3">
                  <h6>
                  <?php if(get_locale() == 'ja') { 
                    echo "オプション： ";
                  }
                    else{
                      echo "Option:";
                      }
                ?>
                  </h6>
                  <div class="d-flex gap-2">
                    <select
                      class="form-select"
                      aria-label="Default select example"
                    >
                      <option selected>Options</option>
                      <option value="1">One</option>
                      <option value="2">Two</option>
                      <option value="3">Three</option>
                    </select>
                    <select
                      class="form-select"
                      aria-label="Default select example"
                    >
                      <option selected>Options</option>
                      <option value="1">One</option>
                      <option value="2">Two</option>
                      <option value="3">Three</option>
                    </select>
                  </div>
                </div>
                <div class="input-variation mb-3">
                  <h6>
                  <?php if(get_locale() == 'ja') { 
                    echo "色：";
                  }
                    else{
                      echo "Color:";
                      }
                ?>
                  </h6>

                  <input
                    type="radio"
                    name="color"
                    id="variation11"
                    value="red"
                  />
                  <label for="variation11"
                    ><span
                      class="elevate-1 rounded-2"
                      style="background-color: blue"
                    ></span
                  ></label>
                                <input type="radio" name="color" id="variation12" value="red" />
                                <label for="variation12"><span
                      class="elevate-1 rounded-2"
                      style="background-color: red"
                    ></span
                  ></label>
                            </div>
                            <div>
                                <h6>
                                <?php if(get_locale() == 'ja') { 
                                  echo "量：";
                                }
                                  else{
                                    echo "Quantity:";
                                    }
                              ?>
                                </h6>
                                <div class="row g-2">
                                    <div class="mb-3 col-4">
                                        <input type="number" class="form-control rounded-0" placeholder="1" aria-label="Quantity" aria-describedby="Product Quantity Input" min="0" />
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-outline-success border-1 rounded-0">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="20"
                          height="20"
                          fill="currentColor"
                          class="bi bi-bag"
                          viewBox="0 0 16 16"
                        >
                          <path
                            d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"
                          />
                        </svg>
                        <span class="ms-2 fw-bold"> 
                        <?php if(get_locale() == 'ja') { 
                                    echo "カートに追加";
                                  }
                                    else{
                                      echo "Add to cart";
                                      }
                                ?>
                        </span>
                      </button>
                              </div>
                              <a class="text-dark" href="#">
                              <?php if(get_locale() == 'ja') { 
                                    echo "完全な情報を表示";
                                  }
                                    else{
                                      echo "View Full Info";
                                      }
                                ?>
                              </a>
                          </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php  get_footer(); ?>