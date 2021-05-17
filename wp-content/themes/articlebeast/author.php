<?php

/**
 * The template for displaying Author Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */
     
get_header();

global $current_user; 
$page_for_posts = get_option( 'page_for_posts', true );
$bg_image_url = get_the_post_thumbnail_url($page_for_posts);
$content = get_user_meta($current_user->ID, 'description',true ); // Biographical Info

$author_id = $post->post_author;
$post_penname = $wpdb->get_row("SELECT * FROM wp_penname WHERE user_id = ". $author_id ."");

echo '<section class="banner-top position-relative" style="background-image: 
url('. ( $bg_image_url ? $bg_image_url : get_template_directory_uri(). '/images/default-banner.png') .');">'.
    '<div class="wrapper d-flex justify-content-end align-items-center position-relative">';
    if (have_posts()) {
        echo '<div class="banner-content cell-6">'.
            '<h1 class="text-white text-uppercase text-center">' . $post_penname->penname . '</h1>'.
        '</div>';
    }
  echo '</div>'.
'</section>';

echo '<section class="content-area">'.
    '<div class="wrapper">'.
        (
            $content
            ? '<div class="author-description text-center"><p class="font-bold">'. $content .'</p></div>'
            : ''
        ).        
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
        '</div>';

        $author_id = $post->post_author;

        echo '<div class="article-lising d-flex">';

            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
               $args = array(
                  'posts_per_page'   => get_option('posts_per_page'),
                  'author'           => $author_id,
                  'orderby'          => 'date',
                  'order'            => 'DESC',
                  'post_type'        => 'post',
                  'paged' => $paged
                );
                $myposts = get_posts( $args );
                
                if($myposts) :
                foreach ( $myposts as $post ) : setup_postdata( $post );
                    
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
            
        
                endforeach; 
                wp_reset_query();
                wp_reset_postdata();
                twentynineteen_the_posts_navigation();
                else :
                    echo '<h2 class="center">Not Found</h2>';
                    echo '<p class="center">Sorry, but you are looking for something that isnt here.</p>';
                    get_search_form();
                endif;

    
       echo '</div>'.
    '</div>'.
'</section>';


?>

<?php
get_footer();
