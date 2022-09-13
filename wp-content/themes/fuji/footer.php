<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package fuji
 */

?>

<footer class="container-xl px-4 mb-4">
      <div class="row pt-5">
        <div class="col-12 col-md-4">

          <button
          type="button"
          class="btn btn-primary"
          id="addToCartSuccessToast"
          onclick="invokeToast()"
        >
          Show live toast
        </button>

          <h5><?php the_field('first_column_heading', 'options'); ?></h5>
          <ul class="list-group">
          <?php if( have_rows('first_column_subfields', 'options')):
              while(have_rows('first_column_subfields', 'options')): the_row();?>
            <li class="list-group-item border-0 p-1 hoverable-item">
              <a class="text-muted" href="<?php the_sub_field('subfield_link'); ?>"><?php the_sub_field('subfield_name'); ?></a>
            </li>
            <?php endwhile; endif; ?>
          </ul>
        </div>
        <div class="col-12 col-md-4">
          <h5><?php the_field('second_column_heading','options');?></h5>
          <ul class="list-group">
          <?php if( have_rows('second_column_subfields', 'options')):
              while(have_rows('second_column_subfields', 'options')): the_row();?>
            <li class="list-group-item border-0 p-1 hoverable-item">
              <span class="text-muted"><?php the_sub_field('subfield_name');?></span>
            </li>
            <?php endwhile; endif; ?>
          </ul>
        </div>
        
        <div class="col-12 col-md-4">
          <h5><?php the_field('third_column_heading', 'options'); ?></h5>
          <ul class="list-group">
          <?php if( have_rows('third_column_subfields', 'options')):
              while(have_rows('third_column_subfields', 'options')): the_row();?>
            <li class="list-group-item border-0 p-1 hoverable-item">
              <a class="text-muted" href="<?php the_sub_field('subfield_link'); ?>"><?php the_sub_field('subfield_name');?></a>
            </li>
            <?php endwhile; endif; ?>
          </ul>
        </div>
      </div>
    </footer>
    <section class="bg-dark">
    <div class="container-xl text-white py-2">
      <div class="row">
        <div class="col-sm-8">
          <p class="mb-0 text-md-end">
            © <span class="year"></span>. <?php the_field('copyright_text','options');?></p>
        </div>
        <div class="col-sm-4">
          <p class="mb-0 text-sm-end">
            <a class="text-white" href="<?php the_field('link_for_powered_by'); ?>"
              ><?php the_field('powered_by', 'options');?></a
            >
          </p>
        </div>
      </div>
    </div>
  </section>
   
  <div
        class="modal fade"
        id="exampleModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
>
    <div class="modal-dialog mt-0 mw-100 m-0" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-body">
                <div class="col-11 col-sm-8 col-md-8 col-lg-5 mx-auto">
                    <form class="row g-3 align-items-end" method="post"
                          action="<?php echo get_site_url(); ?>/product-search/">
                        <div class="col-4 col-sm-3 mb-3">
                            <select
                                    class="form-select btn btn-dark text-white rounded-0 myselect"
                                    aria-label="Default select example"
                                    name="headerSearchBy"
                            >
                                <option selected>Search By</option>
                                <option value="jan_code">JAN Code</option>
                                <option value="fuji_code">Fuji Code</option>
                                <option value="product_title">Product Title</option>
                            </select>
                        </div>
                        <div class="col-8 col-sm-9 mb-3">
                            <label for="exampleFormControlInput1" class="form-label"
                            >Looking For Something ?</label
                            >
                            <div class="position-relative">
                                <input
                                        type="text"
                                        class="form-control rounded-0 search-box"
                                        id="exampleFormControlInput1"
                                        placeholder="Search"
                                        name="headerSearch"
                                />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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
                  <h6>Options:</h6>
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
                  <h6>Color:</h6>

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
                                <h6>Quantity:</h6>
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
                        <span class="ms-2 fw-bold"> Add to Cart </span>
                      </button>
                                    </div>
                                    <a class="text-dark" href="#">View Full Info</a>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="fixed-bottom right-0 text-end m-4">
        <a href="#top" class="btn btn-dark opacity-50">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
          <path
            fill-rule="evenodd"
            d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"
          />
        </svg>
        </a>
    </div>
   

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999999">
  <div
    id="successToast"
    class="toast"
    role="alert"
    aria-live="assertive"
    aria-atomic="true"
  >
    <div class="toast-header">
      <strong class="me-auto">Add To Cart</strong>
      <button
        type="button"
        class="btn-close"
        data-bs-dismiss="toast"
        aria-label="Close"
      ></button>
    </div>
    <div class="toast-body">Product has been added to cart.</div>
  </div>
</div>

    <script>

function invokeToast() {
  var toastLiveExample = document.getElementById("successToast");
  var toast = new bootstrap.Toast(toastLiveExample);
  toast.show();
}
      </script>



<!-- <script>
    (function(w, d, u) {
        var s = d.createElement('script');
        s.async = true;
        s.src = u + '?' + (Date.now() / 60000 | 0);
        var h = d.getElementsByTagName('script')[0];
        h.parentNode.insertBefore(s, h);
    })(window, document, 'https://cdn.bitrix24.com/b18251299/crm/site_button/loader_1_d9wabw.js');
</script> -->

<?php wp_footer(); ?>

</body>
</html>
