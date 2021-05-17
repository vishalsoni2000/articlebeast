<?php
/**
 * Template part for displaying post archives and search results
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

?>

<?php

// get the current taxonomy term
//$term = get_queried_object();

// vars
//$category_image = get_field('category_image', $term);

echo  '<div class="categories-section">'.
        '<div class="wrapper">'.
            '<div class="categories-content text-center">'.
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

//                $types = get_terms( array(
//                    'taxonomy' => 'category',
//                    'hide_empty' => true,
//                ) );
//
//                foreach($types as $type) {   setup_postdata($type);
//                    $image = get_field('category_image', 'category_' . $type->term_id . '' );
//
//                    if( !has_term('term', 'taxonomy', $post->ID )) {
//                    echo '<li class="cell-4 cell-992-6 cell-640-12 list-none pt-0">'.
//                        '<div class="category-content m-10 position-relative">'.
//                            '<div class="image-src innbaner">'.
//                                (
//                                    $image
//                                    ? '<img src="' . $image['url'] . '" /> '
//                                    : ''
//                                ).
//                            '</div>'.
//                            '<div class="category-title position-absolute">'.
//                                '<h4 class="font-normal text-white mb-0 "><a href=" ' . get_category_link( $type->term_id ) . ' " rel="bookmark" title="Permanent Link to '. $type->name .'">' . $type->name . '</a></h4>' .
//                            '</div>'.
//                        '</div>';
//
//                    }
//
//                }
//            wp_reset_query();
//            wp_reset_postdata();
//
//            global $post;
//            $category = get_the_category($post->ID);
//            $category = $category[0]->cat_ID;
//$myposts = get_posts(array('numberposts' => 5, 'offset' => 0, 'category__in' => array($category), 'post_status'=>'publish', 'order'=>'ASC' ));

$args = array(
'cat' => get_query_var('cat'),
  'orderby' => 'title',
  'order' => 'DESC',
  'posts_per_page'=>-1,
);
$my_query = new WP_Query($args);

if( $my_query->have_posts() ) {
    while($my_query->have_posts()) : $my_query->the_post();

    //echo '<a href="'. get_the_permalink() . '">'. get_the_title() .'</a>';
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
}


//            foreach($query as $post) :
//                setup_postdata($post);
//                    
//                    echo '<div id=" post-' . get_the_ID() . ' " class="cell-4 cell-992-6 cell-640-12 '. 
//                        join( ' listing-single-post ', get_post_class($id) ) .'">' .
//                        '<div class="post-content m-10 position-relative">'.
//                            '<div class="article-image position-relative image-src inbanner">' .
//                            (
//                                has_post_thumbnail($id)
//                                ? wp_get_attachment_image( get_post_thumbnail_id(), 'large' )                                
//                                : '<img src="'.get_template_directory_uri().'/images/placeholder-image.jpg">'
//                            ) .
//                            '</div>'.
//                        '<div class="post-title position-absolute">'.
//                            '<h4 class="font-normal text-white mb-0 "><a href=" ' . get_the_permalink($id) . ' " rel="bookmark" title="Permanent Link to '. get_the_title($id) .'">' . get_the_title($id) . '</a></h4>' .
//                        '</div>'.
//                        '</div>'.
//                    '</div>';
//            
//        
//                endforeach;
//                wp_reset_query();
//                wp_reset_postdata();

        echo '</div>'.
    '</div>'.
'</div>';


?>
