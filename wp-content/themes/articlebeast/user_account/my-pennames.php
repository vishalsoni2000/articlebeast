<?php
global $wpdb;
$current_user = wp_get_current_user();

pippin_show_error_messages();


$action = isset( $_REQUEST['action'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) : '';
// delete post
if ( $action == 'del' ) {

    $nonce = isset( $_REQUEST['_wpnonce'] ) ? sanitize_key( wp_unslash( $_REQUEST['_wpnonce'] ) ) : '';

    if ( isset( $nonce ) && !wp_verify_nonce( $nonce, 'penname_del' ) ) {
        return ;
    }

    //check, if the requested user is the post author
    $id = isset( $_REQUEST['id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['id'] ) ) : '';

    $remove_penname=  $wpdb->query( 'DELETE  FROM wp_penname WHERE id = "'.$id.'"' );    
	if($remove_penname){
	    $redirect = home_url().'/account/?section=my-pennames&msg=deleted';
	    wp_safe_redirect( $redirect );
	    exit;
	}else{
		 $redirect = home_url().'/account/?section=my-pennames&msg=deleted';
	    wp_safe_redirect( $redirect );
	    exit;
	}     
}

$msg = isset( $_GET['msg'] ) ? sanitize_text_field( wp_unslash( $_GET['msg'] ) ) : '';
if ( $msg == 'deleted' ) {
   esc_html_e( 'Penname Remove successfully!' );
}

if ( $msg == 'error' ) {
   esc_html_e( 'Something went wrong!' );
}

$penname_data = $wpdb->get_results("SELECT * FROM wp_penname WHERE user_id = $current_user->ID");

?>

<a href="<?php echo $redirect = home_url().'/account/?section=add-pennames'?>" class="mb-20 d-inline-block">Add Pennames</a>

<table class="items-table" cellpadding="0" cellspacing="0">
	<thead>
		<tr class="items-list-header">
			
			<th><?php esc_html_e( 'Picture' ); ?></th>
			<th><?php esc_html_e( 'Name' ); ?></th>
			<th><?php esc_html_e( 'Actions' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			if(!empty($penname_data)){				
				foreach ($penname_data as $value) { ?>
				<tr>
					<td>
						<?php 
							$image = wp_get_attachment_image_src($value->image, 'thumbnail' );	
							if(!empty($image)){					 	
						 		echo '<img src="'.$image[0].'" alt="penname" />';
						 	}else{
						 		echo 'no image';
						 	}
						?>						
					</td>				
					<td><?php echo $value->penname; ?></td>
					<td>
						<?php
							
							$del_url = add_query_arg( ['action' => 'del', 'id' => $value->id] );
							$message = __( 'Are you sure to delete?' ); ?>
							<a class="penname-delete" style="color: red;" href="<?php echo esc_url_raw( wp_nonce_url( $del_url, 'penname_del' ) ); ?>" onclick="return confirm('<?php echo esc_attr( $message ); ?>');"><?php esc_html_e( 'Delete'); ?></a>
							<?php
						 ?>
					</td>
				</tr>
				<?php }

			}else{ ?>
				<tr>
					<td colspan="3">No result found</td>
				</tr>
			<?php } ?>		
	</tbody>
</table>
