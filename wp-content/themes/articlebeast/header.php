<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
    <meta name="author" content="" />
  <meta name="description" content="">
  <meta name="keywords" content="">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
    
	<?php wp_head(); ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-170593156-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    
    gtag('config', 'UA-170593156-1');
    </script>
</head>

<body <?php body_class(); ?>>
    
     <?php
       /** mobile navigation */
       if( my_wp_is_mobile() == 1 ) {
           echo '<div class="mobile_menu d-none">' .
                '<a class="close-btn" href="#"></a>' .
                '<div class="inner">' .
                    main_navigation() .
                '</div>' .
           '</div>';
       }
       ?>
    
<?php

$stickyHeader = get_field('transparent_home_page_header','options');
$posts = get_field('select_pages_for_transparent_header','options');
    
//echo console.log(get_the_ID ());
    
echo '<div id="wrapper" class="';
    if( 'yes' == $stickyHeader ){ 
        if( $posts ):         
            foreach( $posts as $p ):  
                setup_postdata($p);
        
                if(get_the_ID () == $p->ID){
                    echo ' sticky-header';
                }
            endforeach;
        
            wp_reset_query();
            wp_reset_postdata();
        endif;
        }    
    echo '">';
    
     /** Brand Logo Function Start */
    function brand_logo(){
        ob_start();
        if( has_custom_logo() ){
            $desktopBrandLogoID = get_theme_mod( 'custom_logo' ); //Desktop Main brand Logo ID
            $desktopBrandLogoImage = wp_get_attachment_image( $desktopBrandLogoID , 'large', '', ["class" => "large-logo transition"] ); //Desktop Main brand Logo Image

            echo '<div class="header-logo position-relative height-auto transition twidth' .'">' .
                '<a href="' . get_option('home') . '" class="cell-12 transition position-relative">' .
                    ( $desktopBrandLogoID ? $desktopBrandLogoImage : '' ) .           
                '</a>' .
            '</div>';
        }
        return ob_get_clean();
    }
    /** Brand Logo Function End */
    

     echo '<header id="myHeader" class="d-block position-fixed cell-12 transition">'.
        '<div class="wrapper d-flex align-items-center justify-content-between justify-767-content-end">' .
           brand_logo() .
            '<div class="quick-links d-flex justify-content-end cell-12 height-auto">'.
               '<a class="navbar-toggle" href="javascript:void(0)"><span class="navbar-toggle__icon-bar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </span> </a>'.
            '</div>' .
            (
                my_wp_is_mobile() == 1
                ? ''
                : '<div class="main-navigation cell-12 height-auto d-block position-relative pt-30 transition">' .
                    (
                        has_nav_menu( 'main-navigation' )
                        ? '<nav id="site-navigation" class="" aria-label="' . esc_attr( 'Top Menu', 'twentynineteen' ) . '">' .
                          main_navigation() .
                       '</nav>'
                        : ''
                    ) .
                '</div>'
            ) .
        '</div>' .
    '</header>' .

	'<div id="content-area" class="site-content">';