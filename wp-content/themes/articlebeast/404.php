<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();

$page_404_image = get_field( '404_page_image', 'options' );
$page_404_title = get_field( '404_page_title', 'options' );
$page_404_content = get_field( '404_page_content', 'options' );
$page_404_note = get_field( '404_page_note', 'options' );
?>

<div class="content">
	<div class="wrapper">
        <div class="entry content-404">
            <?php if( $page_404_image ) { echo wp_get_attachment_image( $page_404_image, 'medium', false, array() ); } ?>
            
            <?php if( $page_404_title ) { echo '<h2>'. $page_404_title .'</h2>'; } ?>
            
            <?php if( $page_404_content ) { echo '<p>'. $page_404_content .'</p>'; } ?>
            
            <?php if( have_rows( '404_page_links', 'options' ) ) : ?>
                <ul>
                <?php while( have_rows( '404_page_links', 'options' ) ) : the_row();
                $page_name = get_sub_field( 'page_name' );
                $page_link = get_sub_field( 'page_link' );
                if( $page_link ) : ?>
                    <li><a href="<?php echo $page_link; ?>"><?php echo $page_name; ?></a></li>
                <?php endif;
                endwhile; ?>
                </ul>
            <?php endif; ?>
            
            <?php if( $page_404_note ) { echo '<div class="note-404"><span>'. $page_404_note .'</span></div>'; } ?>
        </div>
	</div>
</div>

<?php get_footer(); ?>
