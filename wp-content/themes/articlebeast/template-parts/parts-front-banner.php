<?php

echo '<section class="banner-section position-relative" style="background-image: url('. wp_get_attachment_url( get_post_thumbnail_id( $post->ID )) .');">'.
    '<div class="banner-content d-flex justify-content-end align-items-center">'.
        '<div class="banner-image d-flex align-items-center text-center bg-black cell-6 position-absolute pin-t pin-l d-992-none">'.
            (
                get_field('banner_left_image')
                ? wp_get_attachment_image(get_field('banner_left_image'), 'large')
                : ''
            ).
        '</div>'.
        '<div class="form-content cell-6 cell-992-12 pt-20 pt-640-0 position-relative">'; 

        if(isset($_REQUEST['user_verify']) && $_REQUEST['user_verify'] == 0) {
            echo '<h6>Error! check your email and verify user for activate account!</h6>';
        }elseif(isset($_REQUEST['user_verify']) && $_REQUEST['user_verify'] == 1){
            echo '<h6>Success! User verify Sucessfully!</h6>';
        }
		
		if (!is_user_logged_in() ) {
        ?>

			<h2 class="pippin_header font-normal text-center text-uppercase text-white"><?php _e('Sign In'); ?></h2>

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
						<input id="pippin_login_submit" type="submit" value="Sign In" title="Sign In" class="text-uppercase"/>
					</p>

					<p class="m-0 text-20"><span class="frm-btn">
						<a class="register-btn read-more primary hover-secondary" href="<?php echo home_url( '/register/' ); ?>" title="Sign Up" rel="home">Or Sign Up</a>
					</span></p>
				</fieldset>
			</form>
		
		<?php } else { ?>
		
			<h2 class="pippin_header font-normal text-center text-uppercase text-white"><?php _e('User already login'); ?></h2>
			
		<?php } ?>
        
    <?php echo '</div>'.
    '</div>'.
'</section>';
?>