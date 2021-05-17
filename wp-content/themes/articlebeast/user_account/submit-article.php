<?php
global $wpdb;

$current_user = wp_get_current_user();

// show any error messages after form submission
pippin_show_error_messages();

$post_tags = get_terms( 'post_tag', array(
    'hide_empty' => false,
) );

?>

<?php
$msg = isset( $_GET['msg'] ) ? sanitize_text_field( wp_unslash( $_GET['msg'] ) ) : '';
if ( $msg == 'success' ) {
   esc_html_e( 'Post Submitted successfully!' );
}

if ( $msg == 'error' ) {
   esc_html_e( 'Something went wrong!' );
}

$penname_data = $wpdb->get_results("SELECT * FROM wp_penname WHERE user_id = $current_user->ID");

?>  

<div class="col-sm-12">
	<h3 class="pt-767-10">Add New Post</h3>
	<form class="form-horizontal" id="submit-post" name="form" method="post" enctype="multipart/form-data">		

		<div class="col-md-12 pb-15">
			<label class="control-label">Add Penname</label>
			<select name="article_penname">
				<?php if(!empty($penname_data)){ 
					foreach ($penname_data as $value) {  ?> 						
						<option value="<?php echo $value->id; ?>"><?php echo $value->penname; ?></option>
				<?php } }else{ ?> 
						<option value="">Please Add Penname</option>
				<?php } ?>
			</select>
		</div>

		<div class="col-md-12 pb-15">
			<label class="control-label">Title</label>
            <div class="input-with-counter d-flex justify-content-center">
                <input type="text" id="myInputarea" class="form-control required" name="post_title" maxlength="100" />
                <div class="input-count d-flex justify-content-center align-items-center ml-5 mt-0 px-10"><span id="remainingCharacters"></span></div>
            </div>
		</div>

		<?php 
		$content = '';
		$editor_id = 'post_content';
		$settings =   array(
		    'wpautop' => true, // use wpautop?
		    'media_buttons' => true, // show insert/upload button(s)
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

		wp_editor( $content, $editor_id, $settings ); 

		?>

		<div class="col-md-12 py-15">
			<label class="control-label">Choose Category</label>

			<?php 
				$catList = get_categories(array(
					    'orderby' => 'name',
					    'order'   => 'ASC',
					    'hide_empty'  => false,
					));
			?>
			<select name="category[]" id="category" class="form-control category" data-placeholder="Select post category">
				<?php
					if(!empty($catList)){
						foreach($catList as $listval)
						{
							echo '<option value="'.$listval->term_id.'">'.$listval->name.'</option>';
						}
					}
				?>
			</select>
		</div>


		<!--<div class="col-md-12 pb-15">
			<label class="control-label">Add New Category</label>
			<input type="text" class="form-control create_new_cat" id="create_new_cat" name="create_new_cat" />
		</div>-->

		<!--<div class="col-md-12 pb-15">
			<label class="control-label">Add Post Tags</label>
		 
 			<select class="form-control post_tags_input" name="post_tags_input[]" id="post_tags_input" multiple="multiple" data-placeholder="Select a tag or add">
				<?php foreach ($post_tags as $tag) { ?>
					<option value="<?php echo $tag->slug; ?>"><?php echo $tag->name; ?></option>
				<?php } ?>
			</select>
		</div>-->

		<div class="col-md-12 pb-15">
			<div class="post_image_preview" id="post_image_preview"></div>
			<label class="control-label">Upload Post Image</label>
			<p>For better result please upload minimum 1200*600 size image </p>
			<input type="file" name="post_image" id="post_image" class="form-control" />
			<span id="file_error"></span>
		</div>

		<div class="col-md-12 pb-15">			
			<input type="radio" id="draft" name="post_status" value="draft" checked>
			<label for="draft" class="d-inline-block pl-5">Draft</label><br>
			<input type="radio" id="pending" name="post_status" value="pending">
			<label for="pending" class="d-inline-block pl-5">Ready for approval</label><br>
		</div>

		<div class="col-md-12 pb-15">
			<?php wp_nonce_field( 'add-article' ) ?>
			<input name="action" type="hidden" id="action" value="add-article" />
            <input name="user_id" type="hidden" value="<?php echo $current_user->ID; ?>" />
			<input type="submit" class="dashboard-submit btn btn-primary" value="save" name="submitpost" />
		</div>
	</form>
	<div class="clearfix"></div>
</div>

