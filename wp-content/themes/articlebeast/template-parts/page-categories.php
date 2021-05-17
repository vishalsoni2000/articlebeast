<?php
/**
* @package WordPress
* @subpackage Default_Theme
template name: Categories
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

// get the current taxonomy term
$term = get_queried_object();

// vars
$category_image = get_field('category_image', $term);

echo '<section class="content-area">'.  
        '<div class="categories-section">'.
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
    
                '<ul class="categories-list d-flex pl-0">';
                    
                    if ( get_query_var( 'paged' ) )
                    $paged = get_query_var('paged');
                    else if ( get_query_var( 'page' ) )
                    $paged = get_query_var( 'page' );
                    else
                    $paged = 1;

                    $per_page = get_option('posts_per_page');
                    $number_of_series = count( get_terms( 'category', array('hide_empty'=>'0') ) );

                    $offset  = $per_page * $paged;
                    
                $args = array(
                    'offset'       => $offset,
                    'number'       => $per_page,
                    'hide_empty' => '0'
                    );

            $types = get_terms( 'category', $args );


                        foreach($types as $type) {   setup_postdata($type);
                        $image = get_field('category_image', 'category_' . $type->term_id . '' );
                        
                        if( !has_term('term', 'taxonomy', $post->ID )) {
                        echo '<li class="cell-4 cell-992-6 cell-640-12 list-none pt-0">'.
                            '<div class="category-content m-10 position-relative">'.
                                '<div class="image-src innbaner">'.
                                    (
                                        $image
                                        ? '<img src="' . $image['url'] . '" /> '
                                        : '<img src="'.get_template_directory_uri().'/images/category-image.jpg">'
                                    ).
                                '</div>'.
                                '<div class="category-title position-absolute">'.
                                    '<h4 class="font-normal text-white mb-0 "><a href=" ' . get_category_link( $type->term_id ) . ' " rel="bookmark" title="Permanent Link to '. $type->name .'">' . $type->name . '</a></h4>' .
                                '</div>'.
                            '</div>';
                        
                        }

                    }
                wp_reset_query();
                wp_reset_postdata();
    
                echo '</ul>';

                $big = 999999;
                echo '<nav class="navigation pagination"><div class="nav-links">';
                echo paginate_links( array(
                'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format'  => '?paged=%#%',
                'current' => $paged,
                'total'   => ceil( $number_of_series / $per_page ) // 3 items per page
                ) );
                echo '</div></nav>'.
            '</div>'.
        '</div>'.
'</section>';


get_footer(); 
?>
