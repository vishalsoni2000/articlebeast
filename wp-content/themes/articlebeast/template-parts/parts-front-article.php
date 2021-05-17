<?php

$BlogGroup = get_field('recent_article');
$BlogSecHeading = $BlogGroup['recent_article_heading'];
$BlogSecSubHeading = $BlogGroup['recent_article_subheading'];

if(have_rows('recent_article')){
    while( have_rows('recent_article') ) :
    the_row();
    
    $args = array('post_type' => 'post','posts_per_page' => 10, 'orderby' => 'date', 'order' => 'DESC', 'post_status' => array('publish'), );
    $posts = new WP_Query( $args ); 
    
    if ( $posts->have_posts() ){
    echo '<section class="article-section">' .
        '<div class="wrapper">' .
                (
                    $BlogSecHeading
                    ? '<h2 class="text-center text-brand-secondary mb-10">' . $BlogSecHeading . '</h2>'
                    : ''
                ).
                (
                    $BlogSecSubHeading
                    ? '<h4 class="text-center">' . $BlogSecSubHeading . '</h4>'
                    : ''
                );


                echo '<ul class="article-list py-40">';
                while ( $posts->have_posts() ) : $posts->the_post();
                
                $BlogTitle = get_the_title();
                $BlogLink = get_the_permalink();
                $BlogContent =  apply_filters( 'the_content', wp_trim_words( get_the_content(), 30 ));
                $BlogContent =  str_replace('<p', '<p data-match-height="2" class="text-14"', $BlogContent);
                $BlogExcerpt =  apply_filters( 'the_content', wp_trim_words( get_the_excerpt(), 18 ));
                $BlogExcerpt =  str_replace('<p', '<p class="text-white text-14"', $BlogExcerpt);
                $BlogImage =  wp_get_attachment_image( get_post_thumbnail_id(), 'large', '', array( 'class' => 'transition' ) );

            echo'<li class="single-blog cell-4 cell-640-12 cell-992-6 pt-0 list-none">'.
                    '<div data-match-height class="blog-inner">'.
                                '<div class="blog-upper position-relative">' .
                                    '<div class="image-src innbaner">'.
                                        (
                                            $BlogImage
                                            ?  $BlogImage
                                            : '<img src="'. get_template_directory_uri() .'/images/placeholder-image.jpg" alt="'. get_the_title() .'">'
                                        ).
                                    '</div>'.                                        
                                '</div>'.
                                    '<div class="blog-content"  data-match-height="1">'.
                                        (
                                            $BlogTitle
                                            ? '<a href="' . $BlogLink . '">'.
                                                '<h3 class="text-14 text-brand-secondary hover-text-brand-primary font-bold transition mb-767-10">'.
                                                    $BlogTitle .
                                                '</h3>'.
                                                '</a>'
                                            : ''
                                        ).
                                       (
                                            $BlogContent
                                            ? $BlogContent
                                            : $BlogExcerpt
                                       ).
                                       (
                                            $BlogLink
                                            ? '<a class="blog-link text-brand-secondary hover-text-brand-primary font-bold" href="' . $BlogLink . '"><span>Read More &#x2192;</span></a>'
                                            : ''
                                       ).
                                    '</div>'.
                    '</div>'.
                '</li>';
                endwhile; 
                wp_reset_query();
                wp_reset_postdata(); 
                echo '</ul>'.                    
		'</div>' .
        '</section>';
          }
    endwhile;
}
?>
