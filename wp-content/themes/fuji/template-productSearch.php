<?php
/*
    Template Name: ProductSearch page
    */
get_header();
$arg                   = [
    'post_type' => array('product'),

    'count_total' => true,
    'meta_query'  => array(
        'relation' => 'AND',
    )
];
$currentPage           = 1;
$postPerPage           = 32;
$arg['posts_per_page'] = $postPerPage;
$arg['paged']          = $currentPage;
$searchTerm            = 0;
if (!empty($_GET['manufacturer'])) {
    $arg["meta_query"][] = [
        'key'     => 'manufacturer',
        'value'   => $_GET['manufacturer'],
        'compare' => 'IN'
    ];
}
if (!empty($_POST['headerSearchBy'])) {
    $headerSearchBy = $_POST['headerSearchBy'];

    if ($headerSearchBy == 'fuji_code') {

        $arg["meta_query"][] = [
            'key'     => '_sku',
            'value'   => $_POST['headerSearch'],
            'compare' => '='
        ];
        $searchTerm          = 'Fuji Code : ' . $_POST['headerSearch'];
    } elseif ($headerSearchBy == 'jan_code') {

        $arg["meta_query"][] = [
            'key'     => '_ywbc_barcode_display_value',
            'value'   => $_POST['headerSearch'],
            'compare' => 'IN'
        ];
        $searchTerm          = 'JAN Code : ' . $_POST['headerSearch'];
    } else {
        $arg['s']   = $_POST['headerSearch'];
        $searchTerm = $_POST['headerSearch'];
    }
} else {
    if (!empty($_POST['headerSearch'])) {
        $arg['s']   = $_POST['headerSearch'];
        $searchTerm = $_POST['headerSearch'];
    }
}
?>

<section class="my-4 container-xl px-4 px-lg-3 px-xxl-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a class="text-dark" href="<?php echo get_site_url(); ?>">
                    <?php if (get_locale() == 'ja') {
                        echo "ホーム";
                    } else {
                        echo Home;
                    }
                    ?></a>
            </li>
            <li class="breadcrumb-item active">
                <a class="text-dark" href="#">
                    <?php if (get_locale() == 'ja') {
                        echo "検索";
                    } else {
                        echo Search;
                    }
                    ?></a>
            </li>
        </ol>
    </nav>
</section>
<section class="my-4 container-xl px-4 px-lg-3 px-xxl-5">
    <div class="row">
        <h5 class="text-center search_term"><?php if ($searchTerm) {
                                                echo 'Search " ' . $searchTerm . '"';
                                            } ?></h5>
        <div class="col-lg-3">
            <form method="post" id="product_search">
                <div class="filters">
                    <h5>
                        <?php if (get_locale() == 'ja') {
                            echo "カテゴリー";
                        } else {
                            echo Categories;
                        }
                        ?></h5>
                    <input type="hidden" name="keyword" id="sidebar_keyword" value="" />
                    <input type="hidden" name="pageno" id="pageno" value="1" />
                    <input type="hidden" name="sortBy" value="nameAsc" id="sortBy">
                    <input type="hidden" name="searchBy" value="product_title" id="searchBy">

                    <?php

                    $myterms = get_terms(array('taxonomy' => 'product_cat', 'parent' => 0));

                    foreach ($myterms as $myterm) {
                        if ($myterm->name != 'On sale') {
                    ?>
                    <div class="d-flex align-items-center mb-1">
                        <input type="checkbox" id="<?php echo $myterm->slug ?>" name="product_cat[]"
                            value="<?php echo $myterm->slug ?>" class="manufacturer" />
                        <label for="<?php echo $myterm->slug ?>" class="mb-0 ms-2"><?php echo $myterm->name; ?></label>
                    </div>
                    <?php }
                    } ?>

                    <hr />
                    <h5>
                        <?php if (get_locale() == 'ja') {
                            echo "メーカー";
                        } else {
                            echo Manufacturers;
                        }
                        ?></h5>
                    <select class="form-select rounded-0 p-1 sortByManufacture" aria-label="Default select example"
                        name="manufacturer">
                        <option value="" <?php if (empty($_GET['manufacturer'])) { ?>selected<?php } ?>>
                            <?php if (get_locale() == 'ja') {
                                echo "選択する";
                            } else {
                                echo "Select";
                            }
                            ?></option>

                        <?php 
                             $loop = new WP_Query(array(
                                'posts_per_page' => -1,
                                'post_type'  => 'manufacturer',
                                ));
                                
                                if ($loop->have_posts()) :
                                    while ($loop->have_posts()) : $loop->the_post();
                                    $count = 0;
                         ?>

                        <option value="<?php the_title(); ?>" <?php if ($_GET['manufacturers'] == get_title()) {
                                                                                    echo 'selected';
                                                                                } ?>><?php the_title(); ?>
                        </option>
                        <?php endwhile;
                        endif; 
                        wp_reset_postdata(); ?>
                    </select>
                    <hr />
                    <h5>
                        <?php if (get_locale() == 'ja') {
                            echo "価格";
                        } else {
                            echo "Price";
                        }
                        ?></h5>
                    <div class="d-flex align-items-center gap-2">
                        <?php if (get_locale() == 'ja') { ?>
							<input type="number" class="form-control" id="minPrice" placeholder="最低価格" name="min_price" />
						<?php }
						else{ ?>
							<input type="number" class="form-control" id="minPrice" placeholder="Min" name="min_price" />
						<?php } ?>
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-dash" viewBox="0 0 16 16">
                                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z" />
                            </svg>
                        </span>
						 <?php if (get_locale() == 'ja') { ?>
							<input type="number" class="form-control" id="maxPrice" placeholder="最高価格" name="max_price" />
						<?php }
						else{ ?>
                        <input type="number" class="form-control" id="maxPrice" placeholder="Max" name="max_price" />
						<?php }?>
                        <button class="btn btn-success p-1" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                                <path
                                    d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-9">
            <form id="filter_search">
                <div class="form-group row">
                    <div class="col-4 col-sm-3 mb-3">
                        <select class="form-select btn btn-dark text-white rounded-0 myselect"
                            aria-label="Default select example" name="headerSearchBy" id="SearchByFilter">
                            <option>
                                <?php if (get_locale() == 'ja') {
                                    echo "で検索";
                                } else {
                                    echo "Search By";
                                }
                                ?></option>
							<option value="product_title" <?php if ($headerSearchBy == 'product_title') { echo 'selected'; } ?>>
                                <?php if (get_locale() == 'ja') {
                                    echo "商品名
								";
                                } else {
                                    echo "Product Title";
                                }
                                ?></option>
                            <option value="jan_code" <?php if ($headerSearchBy == 'jan_code') { echo 'selected'; } ?>>
                                <?php if (get_locale() == 'ja') {
                                    echo "JANコード";
                                } else {
                                    echo "JAN Code";
                                }
                                ?></option>
                            <option value="fuji_code" <?php if ($headerSearchBy == 'fuji_code') { echo 'selected'; } ?>>
                                <?php if (get_locale() == 'ja') {
                                    echo "フジコード";
                                } else {
                                    echo "Fuji Code";
                                }
                                ?></option>
                            
                        </select>
                    </div>
                    <div class="col-6 col-sm-6 mb-3">
					 <?php if (get_locale() == 'ja') { ?>
                                   <input type="text" class="form-control rounded-0 mb-3" id="search" placeholder="検索.."
                            name="search"
                            value="<?php if ($searchTerm != null) {																							echo $_POST['headerSearch'];
																																						} ?>" />
                               <?php  } else { ?>
                                <input type="text" class="form-control rounded-0 mb-3" id="search" placeholder="Search.."
                            name="search"
                            value="<?php if ($searchTerm != null) {
                                                                                                                                            echo $_POST['headerSearch'];
                                                                                                                                        } ?>" />
						<?php } ?>
                    </div>
                    <div class="col-2 col-sm-3 mb-3">
                        <button type="submit" class="btn btn-success rounded-0 p-1 px-2">
                            <?php if (get_locale() == 'ja') {
                                echo "検索";
                            } else {
                                echo "Search";
                            }
                            ?></button>
                    </div>
                </div>
            </form>
            <div class="
              d-flex
              mt-2
              mb-lg-3
              gap-2
              justify-content-between
              filter-options
            ">
                <div class="d-flex">
                    <select class="form-select rounded-0 p-1 sortBySelect" aria-label="Default select example">
                        <option selected>
                            <?php if (get_locale() == 'ja') {
                                echo "並び替え";
                            } else {
                                echo "Sort By:";
                            }
                            ?></option>
                        <option value="nameAsc">
                            <?php if (get_locale() == 'ja') {
                                echo "名前：昇順（A-Z）";
                            } else {
                                echo "Name: Ascending order (A-Z)";
                            }
                            ?></option>
                        <option value="nameDesc">
                            <?php if (get_locale() == 'ja') {
                                echo "名前：降順（Z-A）";
                            } else {
                                echo "Name: Descending (Z-A)";
                            }
                            ?></option>
<!--                         <option value="priceDesc">
                            <?php if (get_locale() == 'ja') {
                                echo "価格：高から低";
                            } else {
                                echo "Price: High to Low";
                            }
                            ?></option>
                        <option value="priceAsc">
                            <?php if (get_locale() == 'ja') {
                                echo "価格：低から高";
                            } else {
                                echo "Price: Low to High";
                            }
                            ?>Price: Low to High</option> -->
                    </select>
                </div>
                <button class="btn btn-light d-block d-lg-none filter-btn">
                    Filters
                </button>

                <div class="product-view-options">
                    <button class="btn list-btn active">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                            class="bi bi-list-ul" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                        </svg>
                    </button>
                    <button class="btn grid-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                            class="bi bi-grid-3x3-gap-fill" viewBox="0 0 16 16">
                            <path
                                d="M1 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2zM1 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V7zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V7zM1 12a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="row g-3 mb-5" id="filter_product_result" style="padding-top: 10px; padding-left: 5px;">
                <?php $the_query = new WP_Query($arg);
                $total_news      = $the_query->found_posts;

                if ($the_query->have_posts()) : ?>
                <?php while ($the_query->have_posts()) : $the_query->the_post(); 
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
                                    <?php if ($_product->is_type('simple')) { ?>
                                    <form action="<?php echo get_site_url(); ?>/cart/" method="post"
                                        enctype="multipart/form-data">
                                        <?php $title = $_product->get_meta('product_code'); ?>
                                        <input type="text" id="cfwc-product-code" name="cfwc-product-code"
                                            value="<?php echo $title; ?>" style="display: none;">
                                        <button class="btn btn-success rounded-0 p-1 px-2 btn-add-to-cart"
                                            type="submit" name="add-to-cart" value="<?php the_ID(); ?>">
                                            <?php if (get_locale() == 'ja') {
                                                            echo "カートに追加";
                                                        } else {
                                                            echo "Add to cart";
                                                        }
                                                        ?>
                                        </button>
                                    </form>
                                    <?php } else { ?>

                                    <a class="btn btn-success rounded-0 p-1 px-2 btn-add-to-cart"
                                        href="<?php the_permalink(); ?>">
                                        <?php if (get_locale() == 'ja') {
                                                        echo "バリアントを選択";
                                                    } else {
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

                <?php endwhile; ?>

                <?php else : ?>

                <?php endif;
                wp_reset_postdata(); ?>
                <div class="row my-4 container-xl px-4 px-lg-3 px-xxl-5">
                    <div class="col-lg-4">
                    </div>
                    <div class="pagination col-8 col-sm-3 mb-3">
                        <?php
                        $total_pages = ceil($total_news / $postPerPage);
                        $upperLimit = $total_pages - 2;

                        ?>

                        <?php if ($total_pages > 1) {
                            if ($total_pages > 7) {
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
                                while ($count <= $upperLimit) { ?>
                        <?php
                                    if ($currentPage == $count) {
                                    ?>
                        <a class="changePage" data-pageno="<?php echo $count; ?>" href="#">
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
                            } else {
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
                            }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




<script type="text/javascript">
jQuery(document).ready(function($) {
    $('#filter_search').on('submit', this, function(e) {
        e.preventDefault();
        let search = $('#search').val();
        $('#sidebar_keyword').val(search);
        $('#product_search').trigger('submit');
        let searchTerm = 'Search: "' + search + '"';
        $('.search_term').html(searchTerm);
    });

    $('#product_search').on('submit', this, function(e) {
        e.preventDefault();
        let search = $('#search').val();

        $('#sidebar_keyword').val(search);
        let searchTerm = 'Search: "' + search + '"';
        $('.search_term').html(searchTerm);

        var upload_url = "<?php echo admin_url('admin-ajax.php'); ?>";

        // $('#pageno').val(1);
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
            beforeSend: function() {
                $('#pleaseWaitDialog').show();
            },
            success: function(data) {
                var html = $.parseHTML(data);
                $('#filter_product_result').html(html);
                $('#pleaseWaitDialog').hide();
            }
        });
    });

    $('.manufacturer').change(function() {
        $('#pageno').val(1);
        $('#product_search').trigger('submit');

    });

    $('.sortBySelect').change(function() {
        let sortBy = $('.sortBySelect').val();
        $('#sortBy').val(sortBy);
        $('#pageno').val(1);
        $('#product_search').trigger('submit');
    });
    $(document).on('click', '.changePage', function() {
        let pageNo = $(this).data('pageno');
        $('#pageno').val(pageNo);
        $('#product_search').trigger('submit');
    });
    $('.sortByManufacture').change(function() {
        $('#pageno').val(1);
        $('#product_search').trigger('submit');
    });

    $('#SearchByFilter').change(function() {
        $('#pageno').val(1);
        let sortBy = $('#SearchByFilter').val();
        $('#searchBy').val(sortBy);
    });

})
</script>
<div id="pleaseWaitDialog" class="byc-please-wait" style="display: none;">
    <div>

        <div class="lds-ring">
            <div class="loader"></div>
        </div>
        <?php if (get_locale() == 'ja') {
            echo "お待ちください";
        } else {
            echo "Please wait";
        }
        ?>
    </div>
</div>
<?php get_footer(); ?>