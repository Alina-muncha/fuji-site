<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
echo '<div class="container-xl">';
do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

<div class="u-columns col2-set" id="customer_login">

    <div class="u-column1 col-1">

		<?php endif; ?>
        <section class="my-4 container-xl px-4 px-lg-3 px-xxl-5 pb-5">
            <h2 class="text-center"><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>
            <div class="col-md-6 col-xxl-5 mx-auto my-5">

                <form class="" method="post">

					<?php do_action( 'woocommerce_login_form_start' ); ?>

                    <div class="mb-3">
                        <label for="username"
                               class="form-label fw-bold"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>
                            &nbsp;<span class="required">*</span></label>
                        <input type="text" class="form-control rounded-0" name="username"
                               id="username" autocomplete="username"
                               value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                    </div>
                    <div class="mb-3">
                        <label for="password"
                               class="form-label fw-bold"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span
                                    class="required">*</span></label>
                        <input class="form-control rounded-0" type="password"
                               name="password" id="password" autocomplete="current-password"/>
                    </div>

					<?php do_action( 'woocommerce_login_form' ); ?>
                    <div class="mb-3">
                        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                            <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme"
                                   type="checkbox" id="rememberme" value="forever"/>
                            <span class="ml-2"><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
                        </label>

                    </div>
                    <div class="d-flex justify-content-between">
						<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                        <button type="submit"
                                class="woocommerce-form-login__submit btn btn-success rounded-0 px-3"
                                name="login"
                                value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
                        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="text-success"
                           title="Reset your password">
                           <?php if(get_locale() == 'ja') { 
                            echo "パスワードを再設定する";
                        }
                            else{
                            echo "RESET PASSWORD";
                            }
                        ?> 
                           </a>
                    </div>
                    <div>
                        <a class="text-dark" href="<?php echo get_site_url(); ?>/registration/"
                        ><h6 class="my-3">
                        <?php if(get_locale() == 'ja') { 
                            echo "新規ユーザーの場合は、ここをクリックして登録してください";
                        }
                            else{
                            echo "If New User, Click here to register";
                            }
                        ?>     
                        </h6></a>
                    </div>


					<?php do_action( 'woocommerce_login_form_end' ); ?>

                </form>
        </section>


		<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

    </div>

    <div class="u-column2 col-2">

        <h2><?php esc_html_e( 'Register', 'woocommerce' ); ?></h2>

        <form method="post"
              class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span
                                class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username"
                           id="reg_username" autocomplete="username"
                           value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                </p>

			<?php endif; ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span
                            class="required">*</span></label>
                <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email"
                       id="reg_email" autocomplete="email"
                       value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
            </p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span
                                class="required">*</span></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password"
                           id="reg_password" autocomplete="new-password"/>
                </p>

			<?php else : ?>

                <p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>

			<?php endif; ?>

			<?php do_action( 'woocommerce_register_form' ); ?>

            <p class="woocommerce-form-row form-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                <button type="submit"
                        class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit"
                        name="register"
                        value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
            </p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

        </form>

    </div>

</div>
<?php endif; ?>
</div>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
