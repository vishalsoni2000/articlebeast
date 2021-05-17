<?php
/*
Template Name: Front Page
*/
/** header */
get_header();

/** banner */
get_template_part( 'template-parts/parts-front', 'banner' );

/** banner */
get_template_part( 'template-parts/parts-front', 'categories' );

/** banner */
get_template_part( 'template-parts/parts-front', 'associated' );

/** banner */
get_template_part( 'template-parts/parts-front', 'article' );

/** footer */
get_footer();

?>
