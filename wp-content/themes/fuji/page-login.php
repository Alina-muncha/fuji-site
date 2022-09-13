<?php 
/*
    Template Name: Login page
    */
get_header(); ?>


<section>
      <div class="entry-header text-center">
            <h1>
            <?php if(get_locale() == 'ja') { 
                            echo "ログイン";
                        }
                            else{
                            echo "Login";
                            }
                        ?>        
            </h1>
      </div>
      <div id="main-banner" class="col-md-6 col-xxl-5 mx-auto my-5" >
            <?php the_content(); ?>
      </div>
</section>

<?php get_footer(); ?>