<?php
/**
 * Lost password confirmation text.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/lost-password-confirmation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.9.0
 */

defined( 'ABSPATH' ) || exit;
echo '<section class="my-4 container-xl px-4 px-lg-3 px-xxl-5 pb-5">';
if(get_locale() == 'ja') { 
    wc_print_notice( esc_html__( 'パスワードのリセットメールが送信されました.', 'woocommerce' ) );

  }
    else{
        wc_print_notice( esc_html__( 'Password reset email has been sent.', 'woocommerce' ) );
    }
?>

<?php do_action( 'woocommerce_before_lost_password_confirmation_message' ); ?>

<p><?php echo esc_html( apply_filters( 'woocommerce_lost_password_confirmation_message', esc_html__( 'A password reset email has been sent to the email address on file for your account, but may take several minutes to show up in your inbox. Please wait at least 10 minutes before attempting another reset.', 'woocommerce' ) ) ); ?></p>

<?php do_action( 'woocommerce_after_lost_password_confirmation_message' );
echo '</section>'; ?>
