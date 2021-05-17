<?php
/**
* @package WordPress
* @subpackage Default_Theme
template name: Login Page
*/
get_header();

echo '<section class="form-section pt-20">'.
    '<div class="wrapper">'.
        '<div class="form-content py-20 text-center">'; 

            if(is_user_logged_in()) {
                $redirect = home_url().'/account/';
                wp_safe_redirect( $redirect );
                exit();
            }

            if(isset($_REQUEST['user_verify']) && $_REQUEST['user_verify'] == 0) {
                echo '<h6>Error! Please check your email and click the link to activate your account.</h6>';
            }
			if(isset($_REQUEST['user_verify']) && $_REQUEST['user_verify'] == 1){
                echo '<h6>Success! Your account is now activated.</h6>';
            }
			if(isset($_REQUEST['user_verify']) && $_REQUEST['user_verify'] == 2){
                echo '<h6>Your account has been created. Please check your email account and click the link to activate your account.</h6>';
            }
            ?>

            <h2 class="pippin_header font-normal text-uppercase pt-20 pl-10 mb-0"><?php _e('Sign In'); ?></h2>

            <?php
            // show any error messages after form submission
            pippin_show_error_messages(); ?>

            <form id="pippin_login_form"  class="pippin_form" action="" method="post">
                <fieldset>
                    <p>
                        <input placeholder="Username" name="pippin_user_login" id="pippin_user_login" class="required" type="text"/>
                    </p>
                    <p>
                        <input placeholder="Password" name="pippin_user_pass" id="pippin_user_pass" class="required" type="password"/>
                    </p>
                    <p class="pb-0">
                        <input type="hidden" name="pippin_login_nonce" value="<?php echo wp_create_nonce('pippin-login-nonce'); ?>"/>
                        <input id="pippin_login_submit" type="submit" value="Sign In" class="text-uppercase"/>
                    </p>
    <!--
                    <p><span class="frm-btn">
                        <a href="<?php //echo esc_url( wp_lostpassword_url() ); ?>">Forgot Password</a>
                    </span></p>
    -->
                    <p class="m-0 text-20"><span class="frm-btn">
                        <a class="register-btn read-more primary hover-secondary" href="<?php echo home_url( '/register/' ); ?>" title="Register Form" rel="home">Or Sign Up</a>
                    </span></p>
                </fieldset>
            </form>

        <?php echo '</div>'.
    '</div>'.
'</section>';

get_footer(); 
?>