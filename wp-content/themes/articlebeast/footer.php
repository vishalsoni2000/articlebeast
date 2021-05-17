<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

?>

	</div><!-- #content -->
<?php

$footer_bg_image = get_field('footer_background_image','options');

	echo '<footer id="colophon" class="site-footer">'.
        '<div class="footer-top section-padding bg-brand-secondary text-center">'.
            '<div class="wrapper">'.
                (
                    get_field('footer_heading','options')
                    ? '<h2 class="text-white text-uppercase">'. get_field('footer_heading','options') .'</h2>'
                    : ''
                );
                
                $footer_button = get_field('footer_button','options');

                if($footer_button) {
                    $footer_btn_url = $footer_button['url'];
                    $footer_btn_title = $footer_button['title'];
                    $footer_btn_target = $footer_button['target'];
                    
                    echo '<a href="'. $footer_btn_url .'" target="'. $footer_btn_target .'" class="read-more white hover-primary">'. $footer_btn_title .'</a>';
                }
        
            echo '</div>'.
        '</div>'.
        '<div class="footer-bottom position-relative text-992-center" style="background-image: url('. ($footer_bg_image ? $footer_bg_image : '') .');">'.
            '<div class="footer-menu position-relative">'.
                '<div class="wrapper d-flex justify-content-center">'.
                    do_shortcode('[footer-navigation]').
                    '<div class="site-links cell-3 cell-992-4 cell-767-6 cell-350-12">'.
                        '<h4 class="site-name d-block text-white text-uppercase font-bold">'. get_bloginfo() .'</h4>'. 
                        footer_main_logo() . '</div>'.
                '</div>'.
            '</div>'.
            '<div class="copyright-block position-relative text-center">'.
                '<div class="wrapper">'.
                    '<p class="text-white">'. get_field('copyright', 'options'). '</p>'.
                '</div>'.
            '</div>'.
        '</div>';
	echo '</footer>';
// colophon 
?>

</div><!-- #page -->

<?php wp_footer(); ?>

<script type="text/javascript">
    $(document).ready(function(){
        $('.input-with-counter input[type="text"]').text(
        function () {
            var limit = $(this).attr("maxlength");
            var remainingChars = limit - $(this).val().length;
            $('#remainingCharacters').html(remainingChars); 
        });
    });
    
    var characterLimit = 100; 
    $('#remainingCharacters').html(characterLimit); 
    $('#myInputarea').bind('keyup', 
   function(){
        var charactersUsed = $(this).val().length; 
        if(charactersUsed > characterLimit){ 
            charactersUsed = characterLimit; 
            $(this).val($(this).val().substr(0, characterLimit)); $(this).scrollTop($(this)[0].scrollHeight); 
        } 
        var charactersRemaining = characterLimit - charactersUsed; $('#remainingCharacters').html(charactersRemaining); 
    }); 
</script>


</body>
</html>
