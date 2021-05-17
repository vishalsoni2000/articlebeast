<?php
/**
* @package WordPress
* @subpackage Default_Theme
template name: Sitemap Page
*/
get_header(); 

echo '<div class="content">' .
        '<div class="wrapper">' .
            '<div class="mid">' .
                '<div class="post entry" id="' . get_the_ID() .'"> ' .
                    '<h1>' . get_the_title() . '</h1>' ;
                    wp_list_pages();
                echo '</div>';   
                edit_post_link('Edit this entry.', '<p>', '</p>');
            echo '</div>';
        echo '</div>' ;
echo '</div>' ;
get_footer(); 
?>