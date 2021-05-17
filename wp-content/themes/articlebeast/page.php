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


$bg_image_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ));

echo '<section class="banner-top position-relative" style="background-image: 
url('. ( $bg_image_url ? $bg_image_url : get_template_directory_uri(). '/images/default-banner.png') .');">'.
    '<div class="wrapper d-flex justify-content-end align-items-center position-relative">';
        echo '<div class="banner-content cell-6">'.
            '<h1 class="text-white text-uppercase text-center">' . get_the_title(). '</h1>'.
        '</div>'.
    '</div>'.
'</section>';

echo '<section id="primary" class="content-area">'.
        '<div class="wrapper">'.
            '<div class="innerpage-content">'.
                '<p>'. get_the_content() .'</p>'.
            '</div>'.
        '</div>'.
	'</section>';


get_footer();


?>