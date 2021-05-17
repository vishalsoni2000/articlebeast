<?php
/**
* @package WordPress
* @subpackage Default_Theme
template name: Register Page
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

        ?>	

		<h2 class="pippin_header font-normal text-uppercase pt-20 pl-10 mb-0"><?php _e('Register New Account'); ?></h2>
 
		<?php 
		// show any error messages after form submission
		pippin_show_error_messages(); ?>
 
		<form id="registration_form" class="pippin_form inline-frm" action="" method="post">
			<fieldset>
			    <p>
					<input placeholder="First Name" name="pippin_user_first" id="pippin_user_first" class="required" type="text"/>
				</p>
				<p>
					<input placeholder="Last Name" name="pippin_user_last" id="pippin_user_last" class="required" type="text"/>
				</p>
				<p>
					<input placeholder="Username" name="pippin_user_login" id="pippin_user_login" class="required" type="text"/>
				</p>
				<p>
					<input placeholder="Email" name="pippin_user_email" id="pippin_user_email" class="required" type="email"/>
				</p>
				
				<p>
					<input placeholder="Password" name="password" id="password" class="required" type="password"/>
				</p>
				<p>
					<input placeholder="Confirm Password" name="password_again" id="password_again" class="required" type="password"/>
                </p>
                <p>
                    <input placeholder="Location" name="pippin_user_location" id="pippin_user_location" class="required" type="text"/>
                </p>
                <div class="pb-15">                    
                    <input name="pippin_term_condition" class="required" id="pippin_term_condition" type="checkbox" value=""/>
                    <label for="pippin_term_condition" id="term_condition_error_msg" class="d-inline-block"><a target="_blank" href="<?php echo home_url().'/terms-of-use/'; ?>" ><?php _e('Accept Terms & Conditions of Use'); ?></a></label>
                </div>
				<div>
					<input type="hidden" name="pippin_register_nonce" value="<?php echo wp_create_nonce('pippin-register-nonce'); ?>"/>
					<input type="submit" value="<?php _e('Sign Up'); ?>"/>
				</div>
			</fieldset>
		</form>
	<?php
    echo '</div>'.
    '</div>'.
'</section>';

get_footer(); 
?>