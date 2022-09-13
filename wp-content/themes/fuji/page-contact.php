<?php 
/*
    Template Name: Contact page
    */
get_header(); ?>


<section>
      <div class="entry-header text-center">
            <h1>
            <?php if(get_locale() == 'ja') { 
                    echo "問い合わせ";
                  }
                    else{
                      echo "Inquiry";
                      }
                ?></h1>
      </div>
      <div id="main-banner" class="col-md-6 col-xxl-5 mx-auto my-5" style="box-shadow: 0 7px 25px 0; padding: 1.5rem!important;">
                  <label class= "text-center" style="vertical-align: inherit;" >
                  <?php if(get_locale() == 'ja') { 
                    echo "プログラムに関するご質問や参加に関するご質問には、スタッフが迅速に回答いたします。";
                  }
                    else{
                      echo "Our staff will promptly answer any questions you may have about the program or any questions you may have regarding your participation.";
                      }
                  ?>

                <h5 class="text-center w-100 font-weight-bold p-5">
                <?php if(get_locale() == 'ja') { 
                    echo "お問い合わせフォーム";
                  }
                    else{
                      echo "Inquiry form";
                      }
                  ?>
                  </h5>
                  
         </label>
      
      <?php the_content(); ?>
      </div>
</section>

<?php get_footer(); ?>