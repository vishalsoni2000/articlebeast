<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();
    
$bg_image_url = wp_get_attachment_url( get_post_thumbnail_id());

echo '<section class="banner-top position-relative" style="background-image: 
url('. ( $bg_image_url ? $bg_image_url : get_template_directory_uri(). '/images/default-banner.png') .');">'.
    '<div class="wrapper d-flex justify-content-end align-items-center position-relative">';
        echo '<div class="banner-content cell-6">'.
            '<h1 class="text-white text-uppercase text-center">' . get_the_title(). '</h1>'.
        '</div>'.
    '</div>'.
'</section>';

$postID = get_option('page_for_posts', true);

echo '<section class="content-area">'.
    '<div class="article-details">';
    
    if (have_posts()) {
		
        
    while (have_posts()) : the_post();
            $my_post = get_post( get_the_post_id() );
			
			$current_post_pennname = get_post_meta( get_the_post_id(), 'article_penname', true );
			$post_penname = $wpdb->get_row("SELECT * FROM wp_penname WHERE id = ".$current_post_pennname."");		

           echo '<div class="article-social-part">'.
                '<div class="wrapper d-flex justify-content-between">'.
                    '<div class="left-part d-flex align-items-center cell-480-12 pb-480-5">';
						if(empty($current_post_pennname)) {
							echo '<p>Description | <a href="'. esc_url( get_author_posts_url( $my_post->post_author ) ) .'">Author</a></p>';
						}else{
							echo '<p>Description | <a href="'. esc_url( get_author_posts_url( $my_post->post_author ) ) .'">'.$post_penname->penname.'</a></p>';
						}
                    echo '</div>'.
                    '<div class="right-part d-flex align-items-center position-relative  cell-480-12">'.
                        '<span class="pr-15 pr-767-10">Share</span> '. 
                        sharethis_inline_buttons().
                    '</div>'.
                '</div>'.
            '</div>';


        echo '<div class="article-content">'.
                '<div class="wrapper">';
                
                $attachment_id = get_field('article_image', get_the_post_id());
                        
                    if( $attachment_id ) {
                    echo '<div class="article-image section-padding">'.
                        '<div class="image-src inbanner">'.
                            wp_get_attachment_image( $attachment_id , 'full', false, array( 'class' => 'transition' ) ).
                        '</div>'.
                    '</div>';
                    }
        
                    echo '<div class="article-form d-flex pt-15">'.
                        '<div class="left-part '. (get_field('article_form', get_the_post_id()) ? 'cell-6 cell-992-12' : 'cell-12') .'">'.
                            '<div class="description pr-15 pr-992-0 pb-992-20">'.
                                (
                                    get_post_field('post_content', get_the_post_id())
                                    ? apply_filters('the_content', get_post_field('post_content', get_the_post_id()))
                                    : ''
                                );
                            echo '</div>'.
                        '</div>'.
                        '<div class="right-part contact-form cell-6 cell-992-12">'.
                            (
                                get_field('article_form', get_the_post_id())
                                ? do_shortcode(get_field('article_form', get_the_post_id()))
                                : ''
                            ) .
                        '</div>'.
                    '</div>'.
                '</div>'.    
            '</div>';
    endwhile;
    wp_reset_query();
    wp_reset_postdata(); 
    }
    echo '</div>';
 

echo '</section>';
    


function get_the_post_id() {
    global $wp_query;
    $post_id = $wp_query->get_queried_object_id();
  return $post_id;
}


?>

<?php
get_footer();
?>