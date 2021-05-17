<?php


if( have_rows( 'front_article' ) ) :
    while( have_rows( 'front_article' ) ) : the_row();

echo '<section class="article-categories text-center">'.
    '<div class="wrapper">'.
        (
            get_field('article_heading', 'options')
            ? '<h1 class="text-brand-secondary mb-0">'. get_field('article_heading', 'options') .'</h1>'
            : ''
        ).
        (
            get_field('article_subheading', 'options')
            ? '<h4>'. get_field('article_subheading', 'options') .'</h4>'
            : ''
        );
    
        $terms = get_sub_field('front_article_categories');
    
        if( $terms ) {
        echo '<ul class="categories-list d-flex justify-content-center py-20 pl-0 p-767-0">';
            
              foreach( $terms as $term ) {
            $cat = get_category($term);
              echo '<li class="cell-2 cell-992-3 cell-640-6 cell-480-8 m-10 px-10 py-20 list-none bg-brand-secondary border-radius hover-bg-brand-primary transition">'.
                  '<a href="'. esc_url( get_term_link( $term ) ) .'" class="d-block">'.
                      '<div class="categories-icon pb-10">'.  
                        wp_get_attachment_image( get_sub_field('front_article_icon') , 'full', false, array( 'class' => 'transition' ) );
                      echo '</div>'.
                      '<h5 class="text-white mb-0">'. $cat->name . '</h5>'.
                '</a>'.
              '</li>';
            }
            wp_reset_query();
            wp_reset_postdata();
        echo '</ul>';
        }

        $article_button = get_sub_field('front_article_button');

        if( $article_button ) {
            $article_btn_url = $article_button['url'];
            $article_btn_title = $article_button['title'];
            $article_btn_target = $article_button['target'];
            
            echo '<a href="'. $article_btn_url .'" target="'. $article_btn_target .'" class="read-more"><span>'. $article_btn_title .'</span></a>';
        }
        
    echo '</div>'.
'</section>';

endwhile;
endif;
?>