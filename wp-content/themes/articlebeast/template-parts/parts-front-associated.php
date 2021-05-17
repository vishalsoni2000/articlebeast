<?php

$associated_bg_image = get_field('associated_background_image');

echo '<section class="parallax associated-section position-relative text-center" data-image-src="'. ($associated_bg_image ? $associated_bg_image : '') .'">'.
    '<div class="wrapper position-relative">'.
        (
            get_field('associated_heading')
            ? '<h2 class="text-white mb-10">'. get_field('associated_heading') .'</h2>'
            : ''
        ).
        (
            get_field('associated_subheading')
            ? '<h4 class="text-white">'. get_field('associated_subheading') .'</h4>'
            : ''
        ).
        '<ul class="associated-list d-flex justify-content-center p-0 mb-0">';
            if(have_rows('associated_list')) {
                $associate_count=1;
                while( have_rows('associated_list') ): the_row();
                    echo '<li class="cell-4 cell-767-6 cell-640-12 list-none p-15 '.($associate_count==2 ? 'centered-logo-icon' : '').'">'.
                        '<div class="associated-details px-15 py-20">'.
                            '<div class="associated-icon pb-10">'.
                                wp_get_attachment_image( get_sub_field('associated_icon') , 'full', false, array( 'class' => 'transition' ) ); 
                            echo '</div>';

                            echo '<div class="associated-content">'.
                                ( get_sub_field('associated_link') ? '<a href="'. get_sub_field('associated_link') .'" class="d-block">' : '' ).
                                    (
                                        get_sub_field('associated_title')
                                        ? '<h4 class="text-white transition mb-10">'. get_sub_field('associated_title') .'</h4>'
                                        : ''
                                    ).
                                ( get_sub_field('associated_link') ? '</a>' : '' ).
                                (
                                    get_sub_field('associated_content')
                                    ? '<p class="text-white">'. get_sub_field('associated_content'). '</p>'
                                    : ''
                                ).
                            '</div>'.    
                        '</div>'.
                    '</li>';
                    $associate_count++;
                endwhile;
                wp_reset_query();
                wp_reset_postdata(); 
            }
        echo '</ul>'.    
    '</div>'.
'</section>';
?>