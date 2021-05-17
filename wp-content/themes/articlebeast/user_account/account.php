<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); 


echo '<div class="content-area">'.
    '<div class="entry wrapper">'.
        '<div class="d-flex justify-content-center pt-20">';
    

if (!is_user_logged_in() ) {
	$redirect = home_url().'/login/'; 
    wp_safe_redirect( $redirect );
    exit();
}

if ( is_user_logged_in() ) { ?>
	<nav class="wpuf-dashboard-navigation cell-3 cell-767-12">
	    <ul>        
	        <li class="wpuf-menu-item" <?php if ( isset($_REQUEST['section'] ) && $_REQUEST['section'] == "dashboard") { echo "active"; } ?> >
	        	<a href="<?php echo home_url().'/account/?section=dashboard'; ?>">Dashboard</a>
	        </li>
	        <li class="wpuf-menu-item" <?php if ( isset($_REQUEST['section']) && $_REQUEST['section'] == "submit-article") {echo "active"; } ?>>
	        	<a href="<?php echo home_url().'/account/?section=submit-article'?>">Submit an article</a>
	        </li>
	        <li class="wpuf-menu-item" <?php if ( isset($_REQUEST['section']) && $_REQUEST['section'] == "my-articles") {echo "active"; } ?>>
	        	<a href="<?php echo home_url().'/account/?section=my-articles'?>">My Articles</a>
	        </li>
	        <li class="wpuf-menu-item" <?php if ( isset($_REQUEST['section']) && $_REQUEST['section'] == "my-pennames") {echo "active"; } ?>>
	        	<a href="<?php echo home_url().'/account/?section=my-pennames'?>">My Pennames</a>
	        </li>
	        <li class="wpuf-menu-item" <?php if ( isset($_REQUEST['section'])  && $_REQUEST['section'] == "edit-profile") {echo "active"; } ?>>
	        	<a href="<?php echo home_url().'/account/?section=edit-profile'?>">Edit Profile</a>
	        </li> 
	        <li class="wpuf-menu-item">
	        	<a href="<?php echo wp_logout_url(); ?>">Logout</a>
	        </li>
	    </ul>
	</nav>


<div class="wpuf-dashboard-content cell-9 cell-767-12 px-15 px-767-0">
    <?php

    	$current_user = wp_get_current_user(); 
		
    	$section = isset( $_REQUEST['section'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['section'] ) ) : '';
        if ( is_user_logged_in() && !empty($section) ) {
            custom_load_template($section.'.php');
        }else{
            custom_load_template('dashboard.php');
        }
    ?>
</div>


<?php }
    echo '</div>'.
    '</div>'.
'</div>';                                                                         
?>


<?php get_footer(); ?>