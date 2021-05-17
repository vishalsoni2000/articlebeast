<?php

$current_user = wp_get_current_user();

// show any error messages after form submission
pippin_show_error_messages();
 ?>


<?php
$msg = isset( $_GET['msg'] ) ? sanitize_text_field( wp_unslash( $_GET['msg'] ) ) : '';
if ( $msg == 'success' ) {
   esc_html_e( 'Pennname Submitted successfully!' );
}

if ( $msg == 'error' ) {
   esc_html_e( 'Something went wrong!' );
}

?> 

<div class="col-sm-12">
	<h3>Add New Pennname</h3>
	<form class="form-horizontal" id="submit-post" name="form" method="post" enctype="multipart/form-data">		
		<div class="col-md-12 pb-15">
			<label class="control-label">Name</label>
			<input type="text" class="form-control required" name="penname" />
		</div>

		<div class="col-md-12 pb-15">
			<div class="post_image_preview" id="post_image_preview"></div>
			<label class="control-label">Upload Post Image</label>
			<input type="file" name="penn_image" id="penn_image" class="form-control" />
			<span id="file_error"></span>
		</div>

		<div class="col-md-12">
			<?php wp_nonce_field( 'add-penname' ) ?>
			<input name="action" type="hidden" id="action" value="add-penname" />
            <input name="user_id" type="hidden" value="<?php echo $current_user->ID; ?>" />
			<input type="submit" class="dashboard-submit btn btn-primary" name="submit-penname" />
		</div>
	</form>
	<div class="clearfix"></div>
</div>

