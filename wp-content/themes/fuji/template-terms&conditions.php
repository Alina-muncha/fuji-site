<?php 
/*
    Template Name: Terms and condition page
    */
get_header(); ?>

<section class="my-5">
    <div class="entry-header text-center">
            <h1>
            <?php if(get_locale() == 'ja') { 
                    echo "規約と条件";
                  }
                    else{
                      echo "Terms and Condition";
                      }
                ?></h1>
      </div>
    <div class="container-xl px-4 px-lg-3 px-xxl-5" style="box-shadow: 0 7px 25px 0; padding: 1.5rem!important;">
      <div class="row">
        <?php the_content(); ?>
      </div>
    </div>
</section>

<?php get_footer(); ?>