<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();

//$bg_image_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ));

$term = get_queried_object();
$bg_image_url = get_field('category_image', $term);
$bg_image_url = $bg_image_url['url'];

echo '<section class="banner-top position-relative" style="background-image: 
url('. ( $bg_image_url ? $bg_image_url : get_template_directory_uri(). '/images/category-image.jpg') .');">'.
    '<div class="wrapper d-flex justify-content-end align-items-center position-relative">';
        echo '<div class="banner-content cell-6">'.
            '<h1 class="text-white text-uppercase text-center">' . get_the_archive_title(). '</h1>'.
        '</div>'.
    '</div>'.
'</section>';


echo '<section id="primary" class="content-area">'.
    '<div class="wrapper">';
        
        get_template_part( 'template-parts/content/content', 'excerpt' );

    echo '</div>'.
'</section>';
?>


<?php
get_footer();