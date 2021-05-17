<?php
/**
* @package WordPress
* @subpackage Default_Theme
template name: Contact Us
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

echo '<section class="contact-form-section section-padding bg-light-gray">'.
        '<div class="wrapper d-flex justify-content-end align-items-center">'.
            '<div class="location-details cell-6 cell-992-12 position-relative d-flex pb-992-20">'.
                '<div class="left-part cell-12 cell-992-6 cell-767-4 cell-640-12">'.
                    (
                        get_field('location_heading')
                        ? '<h3 class="mb-640-10">'. get_field('location_heading') .'</h3>'
                        : ''
                    ).
                    do_shortcode('[location-custom-title]') .

                    '<div class="location-contact">'.                    
                        do_shortcode('[location-address]') .
                        do_shortcode('[location-phone]') .
                        do_shortcode('[location-email]') .
                    '</div>'.
                '</div>'.
                
                '<div class="right-part cell-12 cell-992-6 cell-767-8 cell-640-12">'.
                    '<div class="logo-part d-flex align-items-center text-center">'.
                        site_main_logo().
                        social_media_options().
                    '</div>'.
                '</div>'.
            '</div>'.
            '<div class="contact-form cell-6 cell-992-12 pl-20 pl-992-0">'.
                (
                    get_field('contact_form_heading')
                    ? '<h4>'. get_field('contact_form_heading') .'</h4>'
                    : ''
                ).
                do_shortcode(get_field('contact_form')) .
            '</div>'.
        '</div>'.
'</section>';

echo '<section class="map-section">'.
    do_shortcode('[location-map]') .
'</section>';

get_footer(); 
?>

