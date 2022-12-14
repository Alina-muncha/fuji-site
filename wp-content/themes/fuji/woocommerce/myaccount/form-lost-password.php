<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.2
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>
    <section class="my-4 container-xl px-4 px-lg-3 px-xxl-5 pb-5">
        <h2 class="text-center">
        <?php if(get_locale() == 'ja') { 
                            echo "パスワードを紛失した";
                        }
                            else{
                            echo "Lost Password";
                            }
                        ?>  
        </h2>
        <div class="col-md-6 col-xxl-5 mx-auto my-5">
            <form method="post" class="woocommerce-ResetPassword lost_reset_password">

                <p><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

                <div class="mb-3">
                    <label for="user_login"
                           class="form-label fw-bold"><?php esc_html_e( 'Username or email', 'woocommerce' ); ?></label>
                    <input class="woocommerce-Input woocommerce-Input--text input-text form-control rounded-0"
                           type="text" name="user_login"
                           id="user_login" autocomplete="username"/>
                </div>

                <div class="clear"></div>

				<?php do_action( 'woocommerce_lostpassword_form' ); ?>

                <p class="woocommerce-form-row form-row">
                    <input type="hidden" name="wc_reset_password" value="true"/>
                    <button type="submit" class="btn btn-success rounded-0 px-3"
                            value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></button>
                </p>

				<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

            </form>
        </div>
    </section>
<?php
do_action( 'woocommerce_after_lost_password_form' );
