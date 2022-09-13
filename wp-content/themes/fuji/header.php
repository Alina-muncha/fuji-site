<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package fuji
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'fuji'); ?></a>

    <header class="bg-dark d-flex flex-row-reverse flex-direction-row">
      <!-- <div class="dropdown rounded-0">
        <button
          class="btn btn-dark btn-sm dropdown-toggle rounded-0"
          type="button"
          id="dropdownMenuButton1"
          data-bs-toggle="dropdown"
          aria-expanded="false"
        >
          <img class="img-flag" src="../assets/img/japan.png" />
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <li>
            <a class="dropdown-item d-flex justify-content-between" href="#"
              >Japan<img class="img-flag" src="../assets/img/japan.png"
            /></a>
          </li>
          <li>
            <a
              class="dropdown-item d-flex justify-content-between"
              href="./product.html"
              >English <img class="img-flag" src="../assets//img/uk.png"
            /></a>
          </li>
        </ul>
      </div> -->

      <?php echo do_shortcode('[language-switcher]'); ?>

      <div class="text-white me-4 text-small">
        <?php if (is_user_logged_in()) : ?>
          <p class="mb-0">
            <?php if (get_locale() == 'ja') {
              echo "いらっしゃいませ、";
            } else {
              echo "Welcome,";
            }
            ?>
          </p>
          <?php
          $current_user = wp_get_current_user();
          $user_last = get_user_meta( get_current_user_id(), 'billing_last_name', 'true' ); 
          $user_first = get_user_meta( get_current_user_id(), 'billing_first_name', 'true' ); 
          ?>
          <p class="mb-0"><?php printf(__('%s', 'textdomain'), esc_html(
                            $user_last
                          )) . ' ' . printf(__(' %s', 'textdomain'), esc_html(
                            $user_first
                          )); ?></p>
        <?php else : ?>
        <?php endif; ?>
      </div>
    </header>

    <!-- Navbar -->
    <nav class="bg-primary position-sticky top-0 z-index-2 py-0 py-md-1">
      <div class="container-xl px-0 px-md-3 px-xxl-5 d-flex justify-content-between align-items-center">

        <div class="d-none d-md-flex flex-direction-column align-items-center">
          <a class="navbar-brand" href="<?php echo get_site_url(); ?>">
            <div class="">
              <h5 style="color: white; width: 100px;">MAATO </h5>
              <!-- <img class="img-fluid logo" src="<?php the_field('logo', 'options') ?>" /> -->
              <h6 class="mb-0 text-white">
                <?php if (get_locale() == 'ja') {
                  echo "富士、企業間ストア";
                } else {
                  echo  "FUJI B2B STORE";
                }
                ?>
              </h6>
            </div>
          </a>
        </div>

        <?php wp_nav_menu(array('theme_location' => 'menu-1', 'menu_id' => 'primary-menu', 'container' => 'ul', 'menu_class' => 'nav-link nav-item navbar-nav mb-2 mb-lg-0', 'walker' => new macho_bootstrap_walker)); ?>

        <div class="
              flex
              mb-2 mb-lg-0
              d-none d-md-flex
              flex-row
              align-items-center
            ">
          <div class="nav-item">
            <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#exampleModal">
              <span class="me-2">
                <?php if (get_locale() == 'ja') {
                  echo "検索";
                } else {
                  echo "Search Here";
                }
                ?>
              </span>
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
              </svg>
            </button>
          </div>
          <div class="nav-item">
            <?php if (is_user_logged_in()) { ?>
              <a href="<?php echo get_site_url(); ?>/my-account/"><button class="btn text-white" title="My-account">
                <?php } else { ?>
                  <a href="<?php echo get_site_url(); ?>/my-account/"><button class="btn text-white" title="Login">
                    <?php } ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                      <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                    </svg>
                    </button>
                  </a>
          </div>
          <div class="nav-item">
            <div class="dropdown hoverable-dropdown">
              <div class="position-relative">
                <a class="nav-link text-white" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                  </svg>
                </a>
                <span class="
                      badge
                      bg-dark
                      position-absolute
                      top-0
                      start-100
                      translate-middle
                    "><?php echo sprintf(_n('%d ', '%d', WC()->cart->get_cart_contents_count()), WC()->cart->get_cart_contents_count()); ?></span>
              </div>

              <!-- <a class="nav-link dropdown active" aria-current="page" href="#">HOME</a> -->
              <div class="
                    dropdown-menu
                    cart-dropdown-menu
                    rounded-0
                    py-3
                    px-4
                    border-0
                    elevate-1
                  " aria-labelledby="dropdownMenuLink">
                <div class="row">
                  <?php
                  //-----Cart product
                  global $woocommerce;
                  $items = $woocommerce->cart->get_cart();

                  foreach ($items as $item => $values) :
                    $_product =  wc_get_product($values['data']->get_id());

                    $price = get_post_meta($values['product_id'], '_price', true);


                    //------return remove item url for cart------ anchor tag is down below  
                    $string = wc_get_cart_remove_url($item);
                    $src = wp_get_attachment_image_src(get_post_thumbnail_id($values['product_id']), 'thumbnail_size');
                  ?><?php

                    ?>
                  <div class="row border-bottom">
                    <div class="col-6">
                      <img class="img-fluid text-center" src="<?php echo $src[0]; ?>" />
                    </div>
                    <div class="col-6">
                      <a class="text-dark" href="#">
                        <div class="text-truncate">
                          <?php echo $_product->get_title(); ?>
                        </div>
                      </a>
                      <p class="fw-bold mb-1"><?php echo $_product->get_price_html(); ?></p>
                      <p class="text-muted mb-1">Quantity: <?php echo $values['quantity']; ?></p>
                      <h6 class="text-end">
                        <a class="btn hoverable-btn cancel" href="<?php echo $string; ?>">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                          </svg>
                        </a>
                      </h6>
                    </div>
                  </div>
                <?php endforeach; ?>

                <div class="d-flex my-2">
                  <div class="d-flex align-items-end">
                    <a href="<?php echo esc_url(add_query_arg('empty_cart', 'yes')) ?>" class="text-muted"><span class="me-5">Clear Cart</span></a>
                  </div>
                  <div class="mx-auto">
                    <span>
                      <?php if (get_locale() == 'ja') {
                        echo "合計金額：";
                      } else {
                        echo "Total Price: ";
                      }
                      ?>
                    </span>
                    <span class="h3"> <?php echo WC()->cart->get_cart_total(); ?></span>
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-6 text-center">
                    <a href="<?php echo get_site_url(); ?>/checkout/" class="btn btn-outline-warning rounded-0 px-5">
                      <?php if (get_locale() == 'ja') {
                        echo "チェックアウト";
                      } else {
                        echo "Checkout";
                      }
                      ?>
                    </a>
                  </div>
                  <div class="col-6">
                    <a href="<?php echo get_site_url(); ?>/cart/" class="btn btn-warning text-white rounded-0 px-5">

                      <?php if (get_locale() == 'ja') {
                        echo "カートに移動";
                      } else {
                        echo "Go to cart";
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
    </nav>