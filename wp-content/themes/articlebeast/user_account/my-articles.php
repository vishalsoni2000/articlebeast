<?php
$current_user = wp_get_current_user();

global $post;

$pagenum = isset( $_GET['pagenum'] ) ? intval( wp_unslash( $_GET['pagenum'] ) ) : 1;
$action = isset( $_REQUEST['action'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) : '';
// delete post
if ( $action == 'del' ) {

    $nonce = isset( $_REQUEST['_wpnonce'] ) ? sanitize_key( wp_unslash( $_REQUEST['_wpnonce'] ) ) : '';

    if ( isset( $nonce ) && !wp_verify_nonce( $nonce, 'post_del' ) ) {
        wp_delete_post( $pid );        
        $redirect = home_url().'/account/?section=my-articles&msg=error';
        wp_safe_redirect( $redirect );
        exit;
    }

    //check, if the requested user is the post author
    $pid = isset( $_REQUEST['id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['id'] ) ) : '';


    $maybe_delete = get_post( $pid );

    if ( $maybe_delete->post_author == $current_user->ID  ) {
        wp_delete_post( $pid );        
        $redirect = home_url().'/account/?section=my-articles&msg=deleted';
        wp_safe_redirect( $redirect );
        exit;
    } 
}

// show delete success message
$msg = isset( $_GET['msg'] ) ? sanitize_text_field( wp_unslash( $_GET['msg'] ) ) : '';
if ( $msg == 'deleted' ) {
    echo wp_kses_post( '<div class="success">' . __( 'Post Deleted Successfully' ) . '</div>' );
}

if ( $msg == 'error' ) {
    echo wp_kses_post( '<div class="success">' . __( 'Something went wrong!' ) . '</div>' );
}

$post_type = 'post';

$args = [
	'author'         => $current_user->ID,
	'post_status'    => ['draft', 'future', 'pending', 'publish', 'private'],
	'post_type'      => 'post',
	'posts_per_page' => get_option('posts_per_page'),
	'paged'          => $pagenum,
];

$original_post   = $post;
$dashboard_query = new WP_Query( $args );
$post_type_obj   = get_post_type_object( $post_type );

?>
<?php if ( $dashboard_query->have_posts() ) { ?>

<div class="post_count">
	<?php printf( wp_kses_post( __( '<b class="pb-20 d-block">You have created <span>%d</span> %s</b>', 'wp-user-frontend'  ) ), esc_attr( $dashboard_query->found_posts ), esc_attr( $post_type_obj->label ) ); ?>

	<table class="items-table <?php echo esc_attr( $post_type ); ?>" cellpadding="0" cellspacing="0">
		<thead>
			<tr class="items-list-header">
				
				<th><?php esc_html_e( 'Title', 'wp-user-frontend' ); ?></th>
				<th><?php esc_html_e( 'Status', 'wp-user-frontend' ); ?></th>
				<th><?php esc_html_e( 'Options', 'wp-user-frontend' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			global $post;

			while ( $dashboard_query->have_posts() ) {
				$dashboard_query->the_post();
				$show_link  = !in_array( $post->post_status, ['draft', 'future', 'pending'] ); ?>
				<tr>					
					<td>
						<?php if ( !$show_link ) { ?>

							<?php the_title(); ?>

						<?php } else { ?>

							<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wp-user-frontend' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>

						<?php } ?>
					</td>
					
					<td><?php echo ucfirst( $post->post_status ); ?></td>

					<td>
						<?php                            
                            $url  = add_query_arg( ['pid' => $post->ID], get_permalink( $post->ID ) );
                            $show_edit = true;
                            if ( $post->post_status == 'pending') {
                                $show_edit  = false;
                            }

                            if ( $show_edit ) {
                                ?>
                                <a class="posts-edit mr-5" href="<?php echo home_url().'/account/?section=edit-article&id='. $post->ID?>"><?php esc_html_e( 'Edit' ); ?></a>
                                 <a class="posts-prview mr-5" href="<?php echo esc_url( wp_nonce_url( $url ) ); ?>"><?php esc_html_e( 'Preview'); ?></a>
                                <?php
                            }
                        ?>

						<?php
							
							$del_url = add_query_arg( ['action' => 'del', 'id' => $post->ID] );
							$message = __( 'Are you sure to delete?' ); ?>
							<a class="posts-delete" style="color: red;" href="<?php echo esc_url_raw( wp_nonce_url( $del_url, 'post_del' ) ); ?>" onclick="return confirm('<?php echo esc_attr( $message ); ?>');"><?php esc_html_e( 'Delete'); ?></a>
							<?php
						 ?>
					</td>
				</tr>
				<?php
			}

			wp_reset_postdata();
			?>

		</tbody>
	</table>

	<div class="wpuf-pagination">
        <?php
        $pagination = paginate_links( [
            'base'      => add_query_arg( 'pagenum', '%#%' ),
            'format'    => '',
            'prev_text' => __( '&laquo;', 'wp-user-frontend' ),
            'next_text' => __( '&raquo;', 'wp-user-frontend' ),
            'total'     => $dashboard_query->max_num_pages,
            'current'   => $pagenum,
            'add_args'  => false,
        ] );

        if ( $pagination ) {
            echo wp_kses( $pagination, [
                'span' => [
                    'aria-current' => [],
                    'class' => [],
                ],
                'a' => [
                    'href' => [],
                    'class' => [],
                ]
            ] );
        }
        ?>
    </div>

</div>

<?php } else {
    printf( '<div class="wpuf-message">' . esc_attr( __( 'No %s found', 'wp-user-frontend' ) ) . '</div>', esc_html( $post_type_obj->label ) );    
}
wp_reset_postdata();

?>