<?php
$current_user = wp_get_current_user();

ob_start(); 
pippin_show_error_messages(); 

?>
<form class="update-profile-form" id="update-profile-form" action="" method="post" enctype="multipart/form-data">

	<?php
	$msg = isset( $_GET['msg'] ) ? sanitize_text_field( wp_unslash( $_GET['msg'] ) ) : '';
	if ( $msg == 'success' ) {
	   esc_html_e( 'Profile updated successfully!' );
	}

	if ( $msg == 'error' ) {
	   esc_html_e( 'Something went wrong!' );
	}

	?>  

    <ul class="wpuf-form form-label-above list-none">
        <li class="wpuf-el form-row form-row">
            <div class="wpuf-label" >
                <label for="first_name"><?php esc_html_e( 'First Name ' ); ?><span class="required">*</span></label>
            </div>
            <div class="wpuf-fields pb-15" >
                <input type="text" class="input-text" name="first_name" id="first_name" value="<?php echo esc_attr( $current_user->first_name ); ?>" required>
            </div>
        </li>
        <li class="wpuf-el form-row">
            <div class="wpuf-label" >
                <label for="last_name"><?php esc_html_e( 'Last Name ' ); ?><span class="required">*</span></label>
            </div>
            <div class="wpuf-fields pb-15" >
                <input type="text" class="input-text" name="last_name" id="last_name" value="<?php echo esc_attr( $current_user->last_name ); ?>" required>
            </div>
        </li>

        <li class="wpuf-el form-row">
            <div class="wpuf-label" >
                <label for="location"><?php esc_html_e( 'Location ' ); ?><span class="required">*</span></label>
            </div>
            <div class="wpuf-fields pb-15" >
                <input type="text" class="input-text" name="location" id="location" value="<?php echo get_user_meta($current_user->ID, 'user_location',true ); ?>" required>
            </div>
        </li>

        <li class="wpuf-el form-row">
            <div class="wpuf-label" >
                <label for="email"><?php esc_html_e( 'Email Address ' ); ?><span class="required">*</span></label>
            </div>
            <div class="wpuf-fields pb-15" >
                <input type="email" class="input-text" name="email" id="email" value="<?php echo esc_attr( $current_user->user_email ); ?>" required>
            </div>
        </li>
		
		<li>
			<div class="wpuf-el form-row">
				<div class="post_image_preview" id="post_image_preview">
					<?php 
					$user_profile =  get_user_meta($current_user->ID, 'wp_custom_user_profile_avatar',true );
					if (!empty( $user_profile ) ) { 
						$img_atts = wp_get_attachment_image_src($user_profile, 'thumbnail');?>
						<img src="<?php echo $img_atts[0]; ?>" />
						<span class='remove-img'></span>
					<?php } ?>
				</div>
				<label class="control-label">Upload Post Image</label> 
				<input type="file" name="wp_custom_user_profile_avatar" id="wp_custom_user_profile_avatar" class="form-control" />
				<input type="hidden" name="profile_attachment_id" id="profile_attachment_id" value='<?php echo $user_profile; ?>' />
				<span id="file_error"></span>
			</div>
		</li>
		
		<li></li>


        <!-- <li class="wpuf-el">
            <div class="wpuf-label" >
                <label for="current_password"><?php esc_html_e( 'Current Password' ); ?></label>
            </div>
            <div class="wpuf-fields" >
                <input type="password" class="input-text" name="current_password" id="current_password" size="16" value="" autocomplete="off" />
            </div>
            <span class="wpuf-help"><?php esc_html_e( 'Leave this field empty to keep your password unchanged.', 'wp-user-frontend' ); ?></span>
        </li>
        <div class="clear"></div>

        <li class="wpuf-el">
            <div class="wpuf-label" >
                <label for="pass1"><?php esc_html_e( 'New Password' ); ?></label>
            </div>
            <div class="wpuf-fields" >
                <input type="password" class="input-text" name="pass1" id="pass1" size="16" value="" autocomplete="off" />
            </div>
        </li>
        <div class="clear"></div>

        <li class="wpuf-el">
            <div class="wpuf-label" >
                <label for="pass2"><?php esc_html_e( 'Confirm New Password' ); ?></label>
            </div>
            <div class="wpuf-fields" >
                <input type="password" class="input-text" name="pass2" id="pass2" size="16" value="" autocomplete="off" />
            </div>            
        </li>update_profile
        <div class="clear"></div>
 -->
		<li class="wpuf-el form-row">
			<div class="wpuf-label" >
				<label for="about_author"><?php esc_html_e( 'About Author' ); ?></label>
			</div>
			<?php 
			$content = get_user_meta($current_user->ID, 'description',true );
			$editor_id = 'about_author';
			$settings =   array(
				'wpautop' => true, // use wpautop?
				'media_buttons' => false,
				'textarea_name' => $editor_id, // set the textarea name to something different, square brackets [] can be used here
				'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
				'tabindex' => '',
				'editor_css' => '', //  extra styles for both visual and HTML editors buttons, 
				'editor_class' => 'required', // add extra class(es) to the editor textarea
				'teeny' => false, // output the minimal editor config used in Press This
				'dfw' => false, // replace the default fullscreen with DFW (supported on the front-end in WordPress 3.4)
				'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
				'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
			);

			wp_editor( $content, $editor_id, $settings = array() ); 

			?>
		</li>
        <li class="wpuf-submit">
        	<?php wp_nonce_field( 'update-user' ) ?>
            <input name="action" type="hidden" id="action" value="update-user" />
            <input name="user_id" type="hidden" value="<?php echo $current_user->ID; ?>" />
            <button class="dashboard-submit" type="submit" id="update-profile" ><?php esc_html_e( 'Update Profile' ); ?></button>
        </li>
    </ul>

</form>