<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>

<?php $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy')); ?>

    <section class="my-4 container-xl px-4 px-lg-3 px-xxl-5">
      <div class="row">
        <div class="col-lg-3">
          <div class="filters">
            <h5 class="mb-3"><?php  echo $term->name; ?></h5>
<form method="post" id="product_search" style="display:none">
	
                        <input type="hidden" name="keyword" id="sidebar_keyword" value=""/>
                        <input type="hidden" name="pageno" id="pageno" value="1"/>
                        <input type="hidden" name="sortBy" value="nameAsc" id="sortBy">
                        <input type="hidden" name="searchBy" value="product_title" id="searchBy">
	<input type="checkbox" id="<?php echo $term->slug ?>"
                                       name="product_cat[]" value="<?php echo $term->slug ?>"
                                       class="manufacturer" checked/>
			  </form>
            <div class="accordion accordion-flush" id="accordionFlushExample">
            <?php
              $term_id = $term->term_id;
              $taxonomy_name = 'product_cat';
              $termchildren = get_term_children( $term_id, $taxonomy_name );
              
              echo '<ul class="firstChild" >';
              foreach ( $termchildren as $child ) {
                  $child_term = get_term_by( 'id', $child, $taxonomy_name );
                  $parent = $child_term->parent;
                  if($parent == $term_id){
                  echo '<li><a class="mb-3" style="font-size: 1.1rem; color: black; padding-top: 5px;" href="' . get_term_link( $child, $taxonomy_name ) . '">' . $child_term->name . '</a></li>';
                  $child_id = $child_term->term_id;
                  ?>
                  <hr>
                  <?php
                  $termSecondChildren = get_term_children( $child_id, $taxonomy_name );
                  echo '<ul class="secondChild">';
                  foreach ( $termSecondChildren as $secondChild ) {
                    $secondChild_term = get_term_by( 'id', $secondChild, $taxonomy_name );
                    echo '<li><a class="mb-3" style="font-size: 1.1rem; color: black;" href="' . get_term_link( $secondChild, $taxonomy_name ) . '">' . $secondChild_term->name . '</a></li>';
                  }
                  echo '</ul>';
                }
              }
              echo '</ul>';
              ?>
            </div>
           <hr>
            
          </div>
        </div>
        <div class="col-lg-9">
          
          <div
            class="
              d-flex
              mt-2
              mb-lg-3
              gap-2
              justify-content-between
              filter-options
            "
          >
            <div class="d-flex">
                        <select
                                class="form-select rounded-0 p-1 sortBySelect"
                                aria-label="Default select example"
                        >
                            <option selected>
								<?php if(get_locale() == 'ja') { 
                        echo "並び替え：";
                      }
                        else{
                          echo "Sort By:";
                          }
                    ?></option>
                            <option value="nameAsc">
								<?php if(get_locale() == 'ja') { 
                        echo "名前：A-Z";
                      }
                        else{
                          echo "Name: A - Z";
                          }
                    ?></option>
                            <option value="nameDesc">
								<?php if(get_locale() == 'ja') { 
                        echo "名前：Z-A";
                      }
                        else{
                          echo "Name: Z - A";
                          }
                    ?></option>
                            <option value="priceDesc">
								<?php if(get_locale() == 'ja') { 
                        echo "価格：高から低";
                      }
                        else{
                          echo "Price: High to Low";
                          }
                    ?></option>
                            <option value="priceAsc">
								<?php if(get_locale() == 'ja') { 
                        echo "価格：低から高";
                      }
                        else{
                          echo "Price: Low to High";
                          }
                    ?></option>
                        </select>
            </div>

            <div class="product-view-options">
              <button class="btn list-btn active">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="22"
                  height="22"
                  fill="currentColor"
                  class="bi bi-list-ul"
                  viewBox="0 0 16 16"
                >
                  <path
                    fill-rule="evenodd"
                    d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"
                  />
                </svg>
              </button>
              <button class="btn grid-btn">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="18"
                  height="18"
                  fill="currentColor"
                  class="bi bi-grid-3x3-gap-fill"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M1 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2zM1 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V7zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V7zM1 12a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2z"
                  />
                </svg>
              </button>
            </div>
          </div>
          <div class="row g-3 mb-5" id="filter_product_result">
            <!-- loop starts -->
            <?php
              $counter = 1;
              ?>
              <?php if (have_posts()) :
                while (have_posts()) : the_post();
                $_product = wc_get_product(get_the_ID());
                ?>
                    <div class="col-12 search-item">
                            <div class="card rounded-0 border-0">
                                <div class="position-relative overflow-hidden">
                                    <a class="text-dark" href="<?php the_permalink(); ?>">
                                        <figure class="border border-secondary mb-0 p-1 d-none">
                                        <?php $product_image = get_the_post_thumbnail_url();
                        if($product_image){ ?>    
                          <img class="search-item-img w-100 img-fluid obj-fit-cover" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" />                 
                        <?php  }
                        else{ ?>
                        <img class="search-item-img w-100 img-fluid obj-fit-cover" src="<?php echo DEFAULT_IMAGE;?>" alt="<?php the_title(); ?>" />
                       
                      <?php }?>
                                        </figure>
                                        <div class="list_type_btn_wrapper">
                                        <?php if($_product->is_type( 'simple' )){ ?>
                                          <form action="<?php echo get_site_url(); ?>/cart/" method="post" enctype="multipart/form-data">
                                            <?php $title = $_product->get_meta( 'product_code' ); ?>
                                            <input type="text" id="cfwc-product-code" name="cfwc-product-code" value="<?php echo $title; ?>" style="display: none;">
                                            <button class="btn btn-success rounded-0 p-1 px-2 btn-add-to-cart" style="float: right;" type="submit" name="add-to-cart" value="<?php the_ID(); ?>">
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
                                                
                                            <a class="btn btn-success rounded-0 p-1 px-2 btn-add-to-cart" style="float: right;" href="<?php the_permalink(); ?>">
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


                                        <div class="px-0 px-lg-2 border-bottom">
                                            <h5 class="title">
                                                <?php the_title(); ?>
                                            </h5>
                                            <h5>
                                                <?php  //echo get_post_meta(get_the_ID(), '_regular_price', true);
                                               
                                                echo $_product->get_price_html();
                                                ?>
                                            </h5>
                                        </div>
                                        <div class="product-overlay-items cart-button-group d-none">
                                             <?php if($_product->is_type( 'simple' )){ ?>
                <form action="<?php echo get_site_url(); ?>/cart/" method="post" enctype="multipart/form-data">
                  <?php $title = $_product->get_meta( 'product_code' ); ?>
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
											
                                             <a class="btn bg-warning text-white rounded-0 d-block btn-add-to-cart" href="<?php the_permalink(); ?>">
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
                                    </a>
                                </div>
                            </div>
                        </div>
            <?php $counter++;
            endwhile;
			  ?>
			  <div class="row my-4 container-xl px-4 px-lg-3 px-xxl-5">
                    <div class="col-lg-5">
                    </div>
                    <div class="pagination col-7 col-sm-3 mb-3">
                        <?php
						$total_news = $GLOBALS['wp_query']->found_posts;
                        $total_pages = ceil($total_news / 12);
                        $upperLimit = $total_pages - 2;
						$currentPage = 1;
                        ?>

                        <?php if ($total_pages > 1) {
                            if($total_pages > 7){
                            if ($currentPage > 1) {
                                $previousPage = $currentPage - 1;
                        ?>
                        <a href="#" class="changePage" data-pageno="<?php echo $previousPage; ?>">&laquo;</a> <?php } ?>
                        <a <?php
                                if ($currentPage == 1) {
                                    echo 'class="active"';
                                } else {
                                    echo 'class="changePage"';
                                } ?> data-pageno="1" href="#">
                            1</a>
                        <a <?php
                                if ($currentPage == 2) {
                                    echo 'class="active"';
                                } else {
                                    echo 'class="changePage"';
                                } ?> data-pageno="2" href="#">
                            2</a>

                        <span class="paginateDots" >...</span>
                        <?php $count = 3;
                            while ($count < $upperLimit) { ?>
                        <?php
                                if ($currentPage == $count) {
                                ?>
                        <a class="changePage active" data-pageno="<?php echo $count; ?>" href="#">
                            <?php echo $count; ?>
                        </a>
                        <?php
                                } ?>

                        <?php $count++;
                            } ?>
                        <span class="paginateDots" >...</span>
                        <a <?php
                                if ($currentPage == ($total_pages - 1)) {
                                    echo 'class="active"';
                                } else {
                                    echo 'class="changePage"';
                                } ?> data-pageno="<?php echo ($total_pages - 1); ?>" href="#">
                            <?php echo ($total_pages - 1); ?></a>
                        <a <?php
                                if ($currentPage == $total_pages) {
                                    echo 'class="active"';
                                } else {
                                    echo 'class="changePage"';
                                } ?> data-pageno="<?php echo $total_pages; ?>" href="#">
                            <?php echo $total_pages; ?></a>
                        <?php if ($currentPage < $total_pages) { ?>
                        <a href="#" class="changePage" data-pageno="<?php echo ($currentPage + 1); ?>">&raquo;</a>
                        <?php }
                        } else{
                            if ($currentPage > 1) {
                            $previousPage = $currentPage - 1; ?>
                        <a href="#" class="changePage" data-pageno="<?php echo $previousPage; ?>">&laquo;</a> <?php } ?>
                        <?php $count = 1;
                        while ($count <= $total_pages) { ?>
                        <a <?php
                                if ($currentPage == $count) {
                                    echo 'class="active"';
                                } else {
                                    echo 'class="changePage"';
                                } ?> data-pageno="<?php echo $count; ?>" href="#">
                            <?php echo $count; ?></a>
                        <?php $count++;
                        } ?>
                        <?php if ($currentPage < $total_pages) {
                        ?>
                        <a href="#" class="changePage" data-pageno="<?php echo ($currentPage + 1); ?>">&raquo;</a>
                        <?php }
                    } } ?>
                    </div>
                </div>
			  <?php
            endif; ?>
          </div>
			
		</div>  
      </div>
    </section>
<script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('#filter_search').on('submit', this, function (e) {
                e.preventDefault();
                let search = $('#search').val();
                $('#sidebar_keyword').val(search);
                $('#product_search').trigger('submit');
                let searchTerm = 'Search: "' + search + '"';
                $('.search_term').html(searchTerm);
            });

            $('#product_search').on('submit', this, function (e) {
                e.preventDefault();
                let search = $('#search').val();

                $('#sidebar_keyword').val(search);
                let searchTerm = 'Search: "' + search + '"';
                $('.search_term').html(searchTerm);
				
                var upload_url = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
				
                
                var btn = $(this).find('#filter-btn');
                $.ajax({
                    url: upload_url + '?action=filter_product', // replace with your own server URL
                    xhrFields: {
                        withCredentials: true
                    },
                    data: new FormData(this),
                    type: 'POST',
                    datatype: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('#pleaseWaitDialog').show();
                    },
                    success: function (data) {
                        var html = $.parseHTML(data);
                        $('#filter_product_result').html(html);
                        $('#pleaseWaitDialog').hide();
                    }
                });
            });

            $('.manufacturer').change(function () {
                $('#product_search').trigger('submit');
            });

            $('.sortBySelect').change(function () {
                let sortBy = $('.sortBySelect').val();
                $('#sortBy').val(sortBy);
				$('#pageno').val(1);
                $('#product_search').trigger('submit');
            });
			$('.sortByManufacture').change(function () {
                $('#product_search').trigger('submit');
            });
			
            $('#SearchByFilter').change(function () {
                let sortBy = $('#SearchByFilter').val();
                $('#searchBy').val(sortBy);
            });
			$(document).on('click', '.changePage', function() {
				let pageNo = $(this).data('pageno');
				$('#pageno').val(pageNo);
				$('#product_search').trigger('submit');
			});

        })
    </script>
    <div id="pleaseWaitDialog" class="byc-please-wait" style="display: none;">
        <div>

            <div class="lds-ring">
                <div class="loader"></div>
            </div>
            Please wait
        </div>
</div>
<?php

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
//do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
// do_action( 'woocommerce_sidebar' );

get_footer( );