<?php get_header(); ?>

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
        <div class="row icons-menu-container">
        <?php if(have_rows('icon_section')):
        while(have_rows('icon_section')): the_row();?>
          <div class="col-12 col-sm-4 col-md-3 text-center">
            <a href="<?php the_sub_field('icon_link');?>">
              <?php $icon = get_sub_field('icon');  ?>
              <img src="<?php echo $icon['url']; ?>" style="max-height: 90px"/>
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
                  <img
                    class="h-100 w-100 obj-fit-cover"
                    src="<?php the_post_thumbnail_url(); ?>"
                    alt="<?php the_title(); ?>"
                  />
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
              <?php  $thumbnail_id  = (int) get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
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
          <div
            class="position-relative h-100 featured-img"
            style="
              background-image: url(<?php the_post_thumbnail_url(); ?>);
            "
          >
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
                      <img
                        class="w-100 obj-fit-cover"
                        src="<?php the_post_thumbnail_url(); ?>"
                        alt=""
                      />
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
    </section>

    
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