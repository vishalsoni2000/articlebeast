<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();

$page_for_posts = get_option( 'page_for_posts', true );

echo '<section class="banner-top position-relative" style="background-image: url('. get_the_post_thumbnail_url($page_for_posts) .');">'.
    '<div class="wrapper d-flex justify-content-end align-items-center position-relative">';
    if (have_posts()) {
        echo '<div class="banner-content cell-6">'.
            '<h1 class="text-white text-uppercase text-center">' . get_the_title($page_for_posts). '</h1>'.
        '</div>';
    }
  echo '</div>'.
'</section>';


echo '<section class="content-area">'.
    '<div class="wrapper">'.
        '<div class="article-content text-center">'.
            (
                get_field('article_heading', 'options')
                ? '<h1 class="text-brand-secondary mb-0">'. get_field('article_heading', 'options') .'</h1>'
                : ''
            ).
            (
                get_field('article_subheading', 'options')
                ? '<h4>'. get_field('article_subheading', 'options') .'</h4>'
                : ''
            ).
        '</div>'.
        '<div class="article-lising d-flex">';

            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
            $args = array(
                 'posts_per_page'   => get_option('posts_per_page'),
                 'orderby'          => 'date',
                 'order'            => 'DESC',
                 'paged'            => $paged
            );
            $custom_query = new WP_Query( $args );

            if ($custom_query->have_posts()) {
                while ($custom_query->have_posts()) : $custom_query->the_post();

                   echo '<div id=" post-' . get_the_ID() . ' " class="cell-4 cell-992-6 cell-640-12 '. 
                       join( ' listing-single-post ', get_post_class() ) .'">' .
                       '<div class="post-content m-10 position-relative">'.
                           '<div class="article-image position-relative image-src inbanner">' .
                           (
                               has_post_thumbnail()
                               ? wp_get_attachment_image( get_post_thumbnail_id(), 'large' )                                
                               : '<img src="'.get_template_directory_uri().'/images/placeholder-image.jpg">'
                           ) .
                           '</div>'.
                       '<div class="post-title position-absolute">'.
                           '<h4 class="font-normal text-white mb-0 "><a href=" ' . get_the_permalink() . ' " rel="bookmark" title="Permanent Link to '. get_the_title() .'">' . get_the_title() . '</a></h4>' .
                       '</div>'.
                       '</div>'.
                   '</div>';        
                endwhile; 
                wp_reset_query();
                wp_reset_postdata();
                twentynineteen_the_posts_navigation();
            }else{
                echo '<div class="post-error">'.
                    '<h2 class="d-block">Not Found</h2>'.
                    '<p class="d-block">Sorry, but you are looking for something that isnt here.</p>';
                get_search_form();
                echo '</div>';
            }

    
       echo '</div>'.
    '</div>'.
'</section>';


?>

<?php
get_footer();
