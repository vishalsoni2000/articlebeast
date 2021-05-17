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
$current_user = wp_get_current_user();
?>

<p>Hello <strong><?php echo esc_html( $current_user->user_login ); ?></strong>, <a href="<?php echo wp_logout_url(); ?>">Sign out</a></p>
<p>From your account dashboard, you can <a href="<?php echo home_url().'/account/?section=submit-article' ?>">submit new articles</a>, <a href="<?php echo home_url().'/account/?section=my-articles' ?>">edit your existing articles</a>, <a href="<?php echo home_url().'/account/?section=my-pennames' ?>">manage your pennames</a> and <a href="<?php echo home_url().'/account/?section=edit-profile' ?>">edit your profile </a> information.</p>  
 
 
 
 
 
 
