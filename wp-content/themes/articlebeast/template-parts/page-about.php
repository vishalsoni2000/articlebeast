<?php
/**
* @package WordPress
* @subpackage Default_Theme
template name: About Us
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

echo '<section class="about-content text-767-center">'.   
         '<div class="wrapper">'.
                 '<div class="about-welcome d-flex justify-content-center">'.
                    '<div class="about-welcome-image cell-6 cell-767-8 cell-568-10 cell-480-12 position-relative">'.
                        (
                            get_field('about_welcome_image')                           
                            ? '<div class="about-image image-src innbanner">'. wp_get_attachment_image( get_field('about_welcome_image'), 'full', false, array( 'class' => 'transition' ) ).'</div>'
                            : '<div class="about-image image-src innbanner">
                            <img src="'. get_template_directory_uri().'/images/placeholder-image.jpg'.'"></div>'
                        ). 
                    '</div>'.
                    '<div class="about-welcome-content cell-6 cell-767-12">'.
                        '<div class="about-description">'.
                            get_the_content();
                            $about_button = get_field('about_button');
                            if( $about_button ) {
                                $about_btn_url = $about_button['url'];
                                $about_btn_title = $about_button['title'];
                                $about_btn_target = $about_button['target'];

                                echo '<a href="'. $about_btn_url .'" class="read-more secondary hover-primary" target="'. $about_btn_target .'">'. $about_btn_title . '</a>';
                            }
                     echo '</div>'.
                   '</div>'.
                '</div>';
        
            echo '<div class="about-list">'.
                    '<ul class="d-flex p-0 text-center mb-0">';
                        if( have_rows('about_list') ) {
                            while( have_rows('about_list') ) : the_row();    
                                echo '<li class="cell-3 cell-767-6 cell-480-12 list-none p-10">'.
                                    '<div class="about-icon">'.
                                        (
                                            get_sub_field('about_list_icon')
                                            ? wp_get_attachment_image( get_sub_field('about_list_icon'), 'full', false, array( 'class' => 'transition' ) )
                                            : ''
                                        ). 
                                    '</div>'.
                                    (
                                        get_sub_field('about_list_count')
                                        ? '<h3 class="mb-10">'. get_sub_field('about_list_count') . '</h3>'
                                        : ''
                                    ). 
                                    (
                                        get_sub_field('about_list_title')
                                        ? '<p>'. get_sub_field('about_list_title') . '</p>'
                                        : ''
                                    ). 
                                '</li>';
                            endwhile;
                            wp_reset_query();
                            wp_reset_postdata();
                        }
                   echo '</ul>'.
                '</div>';
        
            echo '<div class="about-vision">'.
                    (
                        get_field('about_vision_heading')
                        ? '<h2 class="pb-20 text-center">'. get_field('about_vision_heading') . '</h2>'
                        : ''
                    ). 
                    '<div class="description d-flex justify-content-center">'.
                        '<div class="about-vision-content cell-6 cell-767-12 pt-767-10">'.
                            '<div class="vision-content">'.
                                (
                                    get_field('about_vision_content')
                                    ? '<p>'. get_field('about_vision_content') . '</p>'
                                    : ''
                                ).
                            '</div>'.
                        '</div>'.
                        '<div class="about-vision-image cell-6 cell-767-12 pb-767-20">'.
                            '<div class="vision-image image-src innbanner">'.
                                (
                                    get_field('about_vision_image')
                                    ? wp_get_attachment_image( get_field('about_vision_image'), 'full', false, array( 'class' => 'transition' ) )
                                    : ''
                                ). 
                            '</div>'.
                        '</div>'.
                    '</div>'.
                '</div>'.
        '</div>'.
'</section>';

get_footer(); 
?>

