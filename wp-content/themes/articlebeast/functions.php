<?php
/**
 * Twenty Nineteen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

/**
 * Twenty Nineteen only works in WordPress 4.7 or later.
 */

include ('svg-icons.php');

error_reporting(0);

if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}


/**
 * Fire on the initialization of WordPress.
 */
function the_dramatist_fire_on_wp_initialization() {
    /** to detect mobile  */
    function my_wp_is_mobile() {

        static $is_mobile;

        if ( isset($is_mobile) )
            return $is_mobile;

        if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
            $is_mobile = false;
        } elseif (
            strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false ) {
                $is_mobile = true;
        } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false && strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') == false) {
                $is_mobile = true;
        } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false) {
            $is_mobile = false;
        } else {
            if (preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false)) {
              $is_mobile = 'ie11';
          } else {
              $is_mobile = false;
          }
        }
        return $is_mobile;
    }
}
add_action( 'init', 'the_dramatist_fire_on_wp_initialization' );


/** stop autoupdate wp-scss plugin  */
function my_filter_plugin_updates( $value ) {
   if( isset( $value->response['WP-SCSS-1.2.4/wp-scss.php'] ) ) {
      unset( $value->response['WP-SCSS-1.2.4/wp-scss.php'] );
    }
    return $value;
 }
 add_filter( 'site_transient_update_plugins', 'my_filter_plugin_updates' );


/** Admin Logo */
function my_login_logo() { ?>
<style type="text/css">
    #login h1 a, .login h1 a {
        background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/admin-logo.png);
        height:100px;
        width:100%;
        background-size: contain;
        background-repeat: no-repeat;
    }
</style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );



/* ACF Options page Multiple choices */
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title' 	=> 'Theme General Options',
        'menu_title'	=> 'Theme options',
        'menu_slug' 	=> 'theme-general-options',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Header Options',
        'menu_title'	=> 'Header',
        'parent_slug'	=> 'theme-general-options',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Footer Options',
        'menu_title'	=> 'Footer',
        'parent_slug'	=> 'theme-general-options',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Social Options',
        'menu_title'	=> 'Social',
        'parent_slug'	=> 'theme-general-options',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme 404 Options',
        'menu_title'	=> '404',
        'parent_slug'	=> 'theme-general-options',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme General Options',
        'menu_title'	=> 'General',
        'parent_slug'	=> 'theme-general-options',
    ));
}


/** svg file upload permission */
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


if ( ! function_exists( 'twentynineteen_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function twentynineteen_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Twenty Nineteen, use a find and replace
		 * to change 'twentynineteen' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'twentynineteen', get_template_directory() . '/languages' );

    
         /* Footer logo*/
        function footer_logo($wp_customize) {
            // add a setting
            $wp_customize->add_setting('footer_logo');
            // Add a control to upload the hover logo
            $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'footer_logo', array(
                'label' => 'Footer Logo',
                'section' => 'title_tagline', //this is the section where the custom-logo from WordPress is
                'settings' => 'footer_logo',
                'priority' => 9 // show it just below the custom-logo
            )));
        }
        add_action('customize_register', 'footer_logo');
        
        
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1568, 9999 );

        
		// This theme uses wp_nav_menu() in two locations.
        register_nav_menus(
            array(
                'main-navigation' => __( 'Primary', 'twentynineteen' ),
            )
        );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

        /* footer logo*/
        function site_logo($wp_customize) {
            // add a setting
            $wp_customize->add_setting('site_logo');
            // Add a control to upload the hover logo
            $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'site_logo', array(
                'label' => 'Site Logo',
                'section' => 'title_tagline', //this is the section where the custom-logo from WordPress is
                'settings' => 'site_logo',
                'priority' => 9 // show it just below the custom-logo
            )));
        }
        add_action('customize_register', 'site_logo');
        
		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 190,
				'width'       => 190,
				'flex-width'  => false,
				'flex-height' => false,
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Add custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => __( 'Small', 'twentynineteen' ),
					'shortName' => __( 'S', 'twentynineteen' ),
					'size'      => 19.5,
					'slug'      => 'small',
				),
				array(
					'name'      => __( 'Normal', 'twentynineteen' ),
					'shortName' => __( 'M', 'twentynineteen' ),
					'size'      => 22,
					'slug'      => 'normal',
				),
				array(
					'name'      => __( 'Large', 'twentynineteen' ),
					'shortName' => __( 'L', 'twentynineteen' ),
					'size'      => 36.5,
					'slug'      => 'large',
				),
				array(
					'name'      => __( 'Huge', 'twentynineteen' ),
					'shortName' => __( 'XL', 'twentynineteen' ),
					'size'      => 49.5,
					'slug'      => 'huge',
				),
			)
		);

		// Editor color palette.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Primary', 'twentynineteen' ),
					'slug'  => 'primary',
					'color' => twentynineteen_hsl_hex( 'default' === get_theme_mod( 'primary_color' ) ? 199 : get_theme_mod( 'primary_color_hue', 199 ), 100, 33 ),
				),
				array(
					'name'  => __( 'Secondary', 'twentynineteen' ),
					'slug'  => 'secondary',
					'color' => twentynineteen_hsl_hex( 'default' === get_theme_mod( 'primary_color' ) ? 199 : get_theme_mod( 'primary_color_hue', 199 ), 100, 23 ),
				),
				array(
					'name'  => __( 'Dark Gray', 'twentynineteen' ),
					'slug'  => 'dark-gray',
					'color' => '#111',
				),
				array(
					'name'  => __( 'Light Gray', 'twentynineteen' ),
					'slug'  => 'light-gray',
					'color' => '#767676',
				),
				array(
					'name'  => __( 'White', 'twentynineteen' ),
					'slug'  => 'white',
					'color' => '#FFF',
				),
			)
		);

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );
	}
endif;
add_action( 'after_setup_theme', 'twentynineteen_setup' );


// Google font
function google_font_load_function() { ?>
    <script>
        WebFontConfig = {
            google: { families: [ 'Roboto+Condensed:300,300i,400,400i,700,700i','Raleway:wght@300;400;500;600;700;800;900' ] }
        };

        (function() {
            var wf = document.createElement('script');
            wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>
<?php
}
add_action('wp_footer','google_font_load_function');


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentynineteen_widgets_init() {

    register_sidebar( array(
        'name' => __( 'Footer Quick Links Navigation', 'twentynineteen' ),
        'id' => 'footer-quick-nav',
        'description' => __('Appears in the footer of the site.', ' '),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h4 class="widgettitle mb-0 text-uppercase text-white pb-20">',
        'after_title' => '</h4>',
    ) );
    register_sidebar( array(
        'name' => __( 'Footer Articles Navigation', 'twentynineteen' ),
        'id' => 'footer-articles-nav',
        'description' => __('Appears in the footer of the site.', ' '),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h4 class="widgettitle mb-0 text-uppercase text-white pb-20">',
        'after_title' => '</h4>',
    ) );
    register_sidebar( array(
        'name' => __( 'Footer Help Navigation', 'twentynineteen' ),
        'id' => 'footer-help-nav',
        'description' => __('Appears in the footer of the site.', ' '),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h4 class="widgettitle mb-0 text-uppercase text-white pb-20">',
        'after_title' => '</h4>',
    ) );

}
add_action( 'widgets_init', 'twentynineteen_widgets_init' );


function site_style() {
    if( is_front_page() ){
        wp_enqueue_style( 'herostencil-style', get_template_directory_uri() . '/assets/css/style.css' , array(), wp_get_theme()->get( 'Version' ) );
    } else {
        wp_enqueue_style( 'herostencil-style', get_template_directory_uri() . '/assets/css/inner-styles.css' , array(), wp_get_theme()->get( 'Version' ) );
    }
	wp_enqueue_style( 'general-style', get_template_directory_uri() . '/assets/css/general.css' , array(), wp_get_theme()->get( 'Version' ) );
    wp_style_add_data( 'twentynineteen-style', 'rtl', 'replace' );

    if ( has_nav_menu( 'menu-1' ) ) {
        wp_enqueue_script( 'twentynineteen-priority-menu', get_theme_file_uri( '/js/priority-menu.js' ), array(), '1.0', true );
        wp_enqueue_script( 'twentynineteen-touch-navigation', get_theme_file_uri( '/js/touch-keyboard-navigation.js' ), array(), '1.0', true );
    }

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    // human body css
    wp_register_style( 'bodyparts', get_theme_file_uri() . '/assets/css/bodyparts.css' );
	wp_register_style( 'tax-bodyparts', get_theme_file_uri() . '/assets/css/taxonomy-body_parts.css' );
	wp_register_style( 'faq-page', get_theme_file_uri() . '/assets/css/content-accordion-block.css' );
	wp_register_style( 'content-patientinfo', get_theme_file_uri() . '/assets/css/content-patientinfo.css' );
	wp_register_style( 'content-servicessources', get_theme_file_uri() . '/assets/css/content-servicessources.css' );
	wp_register_style( 'pr-wired-app', get_theme_file_uri() . '/assets/css/page-pt-wired-app.css' );
    
}
add_action( 'wp_enqueue_scripts', 'site_style' );

function site_script() {
    wp_enqueue_script('jquery');
    wp_script_add_data('jquery', 'rtl', 'replace');
    wp_enqueue_script('slick-script', get_theme_file_uri(). '/js/slick.min.js', array(), wp_get_theme()->get('version'), true);
    wp_enqueue_script('matchheight-script', get_theme_file_uri(). '/js/jquery.matchheight.min.js', array(), wp_get_theme()->get('version'), true);
    wp_enqueue_script( 'general-script', get_theme_file_uri() . '/js/general.js', array(), wp_get_theme()->get( 'Version' ) , true );
    wp_enqueue_script( 'parallex-script', get_theme_file_uri() . '/js/parallax.min.js', array(), wp_get_theme()->get( 'Version' ) , true );
    wp_enqueue_script( 'input-counter-script', get_theme_file_uri() . '/js/jsapi.js', array(), wp_get_theme()->get( 'Version' ) , true );
    
}
add_action( 'wp_enqueue_scripts', 'site_script' );


 /** Location Custom Title */
function locationCustomTitle(){
    ob_start();
        $customTitle = get_field('location_name');
        if( $customTitle ){
            echo '<h4 data-match-height="location-custom-title" >' . $customTitle . '</h4>';
        }
    return ob_get_clean();
}
add_shortcode('location-custom-title', 'locationCustomTitle');


/** Location address */
function locationAddress(){
    ob_start();
        $locationAddress = get_field('location_address');
        $locationMapLink = get_field('location_map_link');
        if( $locationAddress ){
            global $locationIcon;
            echo '<p data-match-height="loc-address" >'. $locationIcon .'<a href="'. $locationMapLink .'" target="_blank">' . $locationAddress . '</a></p>';
        }
    return ob_get_clean();
}
add_shortcode('location-address', 'locationAddress');

/** Location Phone Number */
function locationPhoneNumber(){
    ob_start();
        global $callIcon;
        $locationPhoneNumber = get_field('phone_number');
        if( $locationPhoneNumber ){
            echo '<p>'. $callIcon .'<a href="tel:' . preg_replace('/[^0-9]/', '', $locationPhoneNumber ) . '">' . $locationPhoneNumber . '</a></p>';
        }
    return ob_get_clean();
}
add_shortcode('location-phone', 'locationPhoneNumber');


/** Location Email Address */
function locationEmailAddress(){
    ob_start();
    $locationEmailAddress = get_field('email');
    if( $locationEmailAddress ){
        global $messageIcon;
        echo '<p class="mb-0">'. $messageIcon .'<a href="mailto:' . $locationEmailAddress . '">' . $locationEmailAddress . '</a></p>';
    }
    return ob_get_clean();
}
add_shortcode('location-email', 'locationEmailAddress');


//location map
 function locationMap(){
     ob_start();
   
     if( get_field( 'location_map_iframe' ) ){
         echo '<div class="location-map cell-12">' .
             get_field( 'location_map_iframe' ) .
         '</div>' ;
     }
     
     return ob_get_clean();
 }
 add_shortcode('location-map', 'locationMap');



/** footer navigation */
function footer_navigation() {
    ob_start();

    if ( is_active_sidebar( 'footer-quick-nav' ) ) {
        echo '<div class="single-menu cell-3 cell-992-4 cell-767-6 cell-350-12 pr-10 p-992-0">';
            dynamic_sidebar( 'footer-quick-nav' );
        echo '</div>';
    }
    if ( is_active_sidebar( 'footer-articles-nav' ) ) {
        echo '<div class="single-menu cell-3 cell-992-4 cell-767-6 cell-350-12 pr-10 p-992-0">';
            dynamic_sidebar( 'footer-articles-nav' );
        echo '</div>';
    }
     if ( is_active_sidebar( 'footer-help-nav' ) ) {
        echo '<div class="single-menu cell-3 cell-992-4 cell-767-6  cell-350-12 pr-10 p-992-0">';
            dynamic_sidebar( 'footer-help-nav' );
        echo '</div>';
    }

    return ob_get_clean();
}
add_shortcode('footer-navigation', 'footer_navigation');


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width Content width.
 */
function twentynineteen_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'twentynineteen_content_width', 640 );
}
add_action( 'after_setup_theme', 'twentynineteen_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function twentynineteen_scripts() {
	wp_enqueue_style( 'twentynineteen-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

	wp_style_add_data( 'twentynineteen-style', 'rtl', 'replace' );

	if ( has_nav_menu( 'menu-1' ) ) {
		wp_enqueue_script( 'twentynineteen-priority-menu', get_theme_file_uri( '/js/priority-menu.js' ), array(), '1.1', true );
		wp_enqueue_script( 'twentynineteen-touch-navigation', get_theme_file_uri( '/js/touch-keyboard-navigation.js' ), array(), '1.1', true );
	}

	wp_enqueue_style( 'twentynineteen-print-style', get_template_directory_uri() . '/print.css', array(), wp_get_theme()->get( 'Version' ), 'print' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'twentynineteen_scripts' );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function twentynineteen_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'twentynineteen_skip_link_focus_fix' );

/**
 * Enqueue supplemental block editor styles.
 */
function twentynineteen_editor_customizer_styles() {

	wp_enqueue_style( 'twentynineteen-editor-customizer-styles', get_theme_file_uri( '/style-editor-customizer.css' ), false, '1.1', 'all' );

	if ( 'custom' === get_theme_mod( 'primary_color' ) ) {
		// Include color patterns.
		require_once get_parent_theme_file_path( '/inc/color-patterns.php' );
		wp_add_inline_style( 'twentynineteen-editor-customizer-styles', twentynineteen_custom_colors_css() );
	}
}
add_action( 'enqueue_block_editor_assets', 'twentynineteen_editor_customizer_styles' );

/**
 * Display custom color CSS in customizer and on frontend.
 */
function twentynineteen_colors_css_wrap() {

	// Only include custom colors in customizer or frontend.
	if ( ( ! is_customize_preview() && 'default' === get_theme_mod( 'primary_color', 'default' ) ) || is_admin() ) {
		return;
	}

	require_once get_parent_theme_file_path( '/inc/color-patterns.php' );

	$primary_color = 199;
	if ( 'default' !== get_theme_mod( 'primary_color', 'default' ) ) {
		$primary_color = get_theme_mod( 'primary_color_hue', 199 );
	}
	?>

	<style type="text/css" id="custom-theme-colors" <?php echo is_customize_preview() ? 'data-hue="' . absint( $primary_color ) . '"' : ''; ?>>
		<?php echo twentynineteen_custom_colors_css(); ?>
	</style>
	<?php
}
add_action( 'wp_head', 'twentynineteen_colors_css_wrap' );

/**
 * SVG Icons class.
 */
require get_template_directory() . '/classes/class-twentynineteen-svg-icons.php';

/**
 * Custom Comment Walker template.
 */
require get_template_directory() . '/classes/class-twentynineteen-walker-comment.php';

/**
 * Enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * SVG Icons related functions.
 */
require get_template_directory() . '/inc/icon-functions.php';

/**
 * Custom template tags for the theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


/** main navigation */
function main_navigation(){
    ob_start();
    wp_nav_menu(
        array(
            'theme_location' => 'main-navigation',
            'menu_class' => 'nav_menu'
        )
    );
    return ob_get_clean();
}


/** Social Media Function Start */
function social_media_options(){
    ob_start();
    global $facebook;
    global $insta;
    global $twitter;
    global $youtube;
    global $linkedin;
    global $yelp;
    if( have_rows('social_media', 'options') ){
        echo '<div class="socialmedialinks pl-20 pl-640-0"><span class="follow mb-10 d-block">Follow Us</span><ul class="justify-content-start">';
            while ( have_rows('social_media', 'options')) : the_row();
            $icon = get_sub_field('social_media_name', 'options');
            echo '<li class="p-0">' .
                    '<a href="' . get_sub_field('social_media_link', 'options') . '" target="_blank" class="' . get_sub_field('social_media_name', 'options') . '">';
                        if($icon == "facebook"){
                            echo $facebook;
                        } else if($icon == "insta") {
                            echo $insta;
                        } else if($icon == "twitter") {
                            echo $twitter;
                        } else if($icon == "youtube") {
                            echo $youtube;
                        } else if($icon == "linkedin") {
                            echo $linkedin;
                        } else if($icon == "yelp") {
                            echo $yelp;
                        }
                    echo '</a>' .
                '</li>';
            endwhile;
        echo '</ul></div>';
    }
    return ob_get_clean();
}
/** Social Media Function End */



/** Site Logo Function Start */
function site_main_logo(){
    ob_start();
        if( has_custom_logo() ){
            $siteLogoID = attachment_url_to_postid( get_theme_mod( 'site_logo' ) ) ; // Footer Logo ID
            $siteLogoImage = wp_get_attachment_image( $siteLogoID ,'large', '', ["class" => "site-main-logo transition"] ); //Footer Logo Image

            echo '<div class="site-main-logo position-relative transition pr-20 pr-640-10">' .
                '<a href="' . get_option('home') . '" class="transition d-block position-relative">' .
                    ( $siteLogoID ? $siteLogoImage : '' ) .
                '</a>' .
            '</div>';
        }
    return ob_get_clean();
}



// For revomoe prefix from category title
function prefix_category_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    }
    return $title;
}
add_filter( 'get_the_archive_title', 'prefix_category_title' );



/********************************************** User Post Relared function *********************************/
// Add New custome field in admin
add_action( 'show_user_profile', 'crf_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'crf_show_extra_profile_fields' );

//Showing the user field
function crf_show_extra_profile_fields( $user ) {
    $user_location = get_the_author_meta( 'user_location', $user->ID );
    ?>
    <h3><?php esc_html_e( 'User Information', '' ); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="user_location"><?php esc_html_e( 'User Location', '' ); ?></label></th>
            <td>
                <input type="text"                  
                   id="user_location"
                   name="user_location"
                   value="<?php echo esc_attr( $user_location ); ?>"
                   class="regular-text"
                />
            </td>
        </tr>
    </table>
    <?php
}

//Saving the field
add_action( 'personal_options_update', 'crf_update_profile_fields' );
add_action( 'edit_user_profile_update', 'crf_update_profile_fields' );

function crf_update_profile_fields( $user_id ) {
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }

    if ( ! empty( $_POST['user_location'] ) ) {
        update_user_meta( $user_id, 'user_location', $_POST['user_location'] );
    }

}

// logs a member in after submitting a form
function wp__login_member() {

    if(isset($_POST['pippin_user_login']) && !isset($_POST['pippin_register_nonce'])) {

        if(wp_verify_nonce($_POST['pippin_login_nonce'], 'pippin-login-nonce')){
            

            // this returns the user ID and other info from the user name
            $user = get_user_by('login', $_POST['pippin_user_login']);
     
            if(!$user) {
                // if the user name doesn't exist
                pippin_errors()->add('empty_username', __('Invalid username'));
            }
     
            if(!isset($_POST['pippin_user_pass']) || $_POST['pippin_user_pass'] == '') {
                // if no password was entered
                pippin_errors()->add('empty_password', __('Please enter a password'));
            }
     
            // check the user's login with their password
            if(!empty($_REQUEST['pippin_user_login']) && !empty($_REQUEST['pippin_user_pass']) && $user){
                if(!wp_check_password($_POST['pippin_user_pass'], $user->user_pass, $user->ID)) {
                    // if the password is incorrect for the specified user
                    pippin_errors()->add('empty_password', __('Incorrect password'));
                }
            }
     
            // retrieve all error messages
            $errors = pippin_errors()->get_error_messages();
     
            // only log the user in if there are no errors
            if(empty($errors)) {

                $user_role = $user->roles[0];

                $permission = get_user_meta( $user->ID, 'account_activated' , true );
                if(!empty($permission) && $user_role != 'administrator'){
                    wp_clear_auth_cookie();
                    wp_set_current_user ( $user->ID );
                    wp_set_auth_cookie  ( $user->ID );
                    $redirect_to = home_url().'/account/';
                }else if($user_role == 'administrator'){    
                    wp_clear_auth_cookie();
                    wp_set_current_user ( $user->ID );
                    wp_set_auth_cookie  ( $user->ID );
                    $redirect_to = home_url().'/account/';
                }else{
                    $redirect_to = home_url().'/login/?user_verify=0';                    
                }
            
                wp_safe_redirect( $redirect_to );
                exit();
                
            }
        }
    }
}
add_action('init', 'wp__login_member');


// register a new user
function wp__add_new_member() {
    if (isset( $_POST["pippin_user_login"] ) && !isset($_POST['pippin_login_nonce']) ) {

        if( wp_verify_nonce($_POST['pippin_register_nonce'], 'pippin-register-nonce') ) {

            $user_login     = $_POST["pippin_user_login"];  
            $user_email     = $_POST["pippin_user_email"];
            $user_first     = $_POST["pippin_user_first"];
            $user_last      = $_POST["pippin_user_last"];
            $user_pass      = $_POST["password"];
            $pass_confirm   = $_POST["password_again"];
            $user_location  = $_POST["pippin_user_location"];
     
            if(username_exists($user_login)) {
                // Username already registered
                pippin_errors()->add('username_unavailable', __('Username already taken'));
            }
            if(!validate_username($user_login)) {
                // invalid username
                pippin_errors()->add('username_invalid', __('Invalid username'));
            }
            if($user_login == '') {
                // empty username
                pippin_errors()->add('username_empty', __('Please enter a username'));
            }
            if(!is_email($user_email)) {
                //invalid email
                pippin_errors()->add('email_invalid', __('Invalid email'));
            }
            if(email_exists($user_email)) {
                //Email address already registered
                pippin_errors()->add('email_used', __('Email already registered'));
            }
            if($user_pass == '') {
                // passwords do not match
                pippin_errors()->add('password_empty', __('Please enter a password'));
            }
            if($user_pass != $pass_confirm) {
                // passwords do not match
                pippin_errors()->add('password_mismatch', __('Passwords do not match'));
            }
            if(empty($user_location)) {
                pippin_errors()->add('location_empty', __('Please enter a location'));
            }           
     
            $errors = pippin_errors()->get_error_messages();
     
            // only create the user in if there are no errors
            if(empty($errors)) {
     
                $user_id = wp_insert_user(array(
                        'user_login'        => $user_login,
                        'user_pass'         => $user_pass,
                        'user_email'        => $user_email,
                        'first_name'        => $user_first,
                        'last_name'         => $user_last,
                        'user_registered'   => date('Y-m-d H:i:s'),
                        'role'              => 'contributor',
                    )
                );
                if($user_id) {

                    update_user_meta($user_id, 'user_location', $user_location);

                    // send an email to the admin alerting them of the registration
                    wp_new_user_notification($user_id);

                    /************** Conformation Email **************/
                    $code = md5(time());
                    // make it into a code to send it to user via email
                    $string = array('id'=>$user_id, 'code'=>$code);
                    // create the activation code and activation status
                    update_user_meta($user_id, 'account_activated', 0);
                    update_user_meta($user_id, 'activation_code', $code);
                    // create the url
                    $url = home_url(). '/login/?act=' .base64_encode( serialize($string));
                    // basically we will edit here to make this nicer
                    $html = 'Please click the following links '.$url;
                    // send an email out to user
                    wp_mail( $user_email, __('User Activation Link','wordpress') , $html);
                    /************** Conformation Email End **************/
                    
                    wp_clear_auth_cookie();
                    //wp_set_current_user ( $user_id );
                    //wp_set_auth_cookie  ( $user_id );
					$redirect = home_url().'/login/?user_verify=2'; 
                    wp_safe_redirect( $redirect );
                    exit();
                }    
            }
        }    
    }
}
add_action('init', 'wp__add_new_member');

function wp__update_member() {

    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user'  ) {

        if( wp_verify_nonce($_POST['_wpnonce'], 'update-user') ) {

            $user_email     = $_POST["email"];
            $user_first     = $_POST["first_name"];
            $user_last      = $_POST["last_name"];
            $user_location  = $_POST["location"];
            $user_id        = $_POST["user_id"];
			$about_author   = $_POST["about_author"];
			$profile_attachment_id = $_POST["profile_attachment_id"];

            if ( !empty( $user_email ) ){
                if (!is_email(esc_attr( $user_email )))
                    pippin_errors()->add('Email Validate', __('The Email you entered is not valid.  please try again.'));
                elseif(email_exists(esc_attr( $user_email )) != $user_id )
                    pippin_errors()->add('Email', __('This email is already used by another user.  try a different one.'));
                else{
                    wp_update_user( array ('ID' => $user_id, 'user_email' => esc_attr( $user_email )));
                }
            }

            if(empty($user_id )) {
                //Email address already registered
                pippin_errors()->add('User', __('User Is not verified please try again'));
            }            

            $errors = pippin_errors()->get_error_messages();

            if(empty($errors)) {
				
				
				if ($_FILES) {
					
                    array_reverse($_FILES);
                    $i = 0;
                    foreach ($_FILES as $file => $array) {
                        if( $array['name'] != '' ){                            
                            $set_feature = 0;                            						
                            $profile_attachment_id = wp__user_insert_attachment($file, $user_id, $set_feature);
                        }else{
                            update_user_meta( $user_id, 'wp_custom_user_profile_avatar', $profile_attachment_id );
                        }                  
                    }
                }
				
                update_user_meta( $user_id, 'first_name', esc_attr( $user_first  ) );
                update_user_meta( $user_id, 'last_name', esc_attr( $user_last ) );
                update_user_meta( $user_id, 'user_location', esc_attr( $user_location ) );
				update_user_meta( $user_id, 'description', esc_attr( $about_author ) );
            }

            if(empty($errors)) {
                $redirect = home_url().'/account/?section=edit-profile&msg=success';
                wp_safe_redirect( $redirect );
                exit();
            }else{
                $redirect = home_url().'/account/?section=edit-profile&msg=error';
                wp_safe_redirect( $redirect );
                exit(); 
            }
        }
    }
}

add_action('init', 'wp__update_member');


add_filter( 'get_avatar', 'wp__get_avatar', 10, 5 );
function wp__get_avatar( $avatar = '', $id_or_email, $size = 96, $default = '', $alt = '' ) {

    // Replace $avatar with your own image element, for example
     $attach_id = get_user_meta( $id_or_email, 'wp_custom_user_profile_avatar', true );
	 $profile_avatar = wp_get_attachment_url( $attach_id );
     $avatar = "<img alt='$alt' src='".$profile_avatar."' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";

    return $avatar;

}



function wp__insert_attachment($file_handler,$post_id,$setthumb='false') {
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK){ return __return_false(); 
    } 
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');

    $attach_id = media_handle_upload( $file_handler, $post_id );
    //set post thumbnail if setthumb is 1
    if ($setthumb == 1) update_post_meta($post_id,'_thumbnail_id',$attach_id);
    return $attach_id;
}

function wp__user_insert_attachment($file_handler,$post_id,$setthumb='false') {
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK){ return __return_false(); 
    } 
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');

    $attach_id = media_handle_upload( $file_handler, $post_id );

    //set post thumbnail if setthumb is 1
    update_user_meta( $post_id, 'wp_custom_user_profile_avatar', $attach_id ); 
    return $attach_id;
}



function wp__add_article() {

    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'add-article'  ) {

        if( wp_verify_nonce($_POST['_wpnonce'], 'add-article') ) {

            //echo "<pre>";print_r($_POST);exit;

            $post_title = $_POST['post_title'];
            $post_content = $_POST['post_content'];
            $category = $_POST['category'];
            $create_new_cat = $_POST['create_new_cat'];
            $post_status = $_POST['post_status'];
            $article_penname = $_POST['article_penname'];
            $user_id = $_POST['user_id'];
            //$tags_input = $_POST['post_tags_input'];           

            if(empty($post_title)) {
                pippin_errors()->add('Post Title', __('Please enter post title'));
            }   

            if(empty($post_content)) {
                pippin_errors()->add('Post Content', __('Please enter post Content'));
            } 

            if( empty($category) && empty($create_new_cat)) {                
                pippin_errors()->add('Post Category', __('Please select post category'));
            }            

            if( empty($article_penname) ) {                
                pippin_errors()->add('Penname', __('Please select Pennmae'));
            }  

            if( empty($user_id) ) {                
                pippin_errors()->add('User', __('Please not authorize to submit post'));
            }  
            

            $errors = pippin_errors()->get_error_messages();

            if(empty($errors)) {

                /*require_once( ABSPATH . '/wp-admin/includes/taxonomy.php');
                
                //Checking if category already there
                $cat_ID = get_cat_ID( $create_new_cat );

                //If not create new category
                if($cat_ID == 0) {
                    $cat_name = array('cat_name' => $create_new_cat);
                    wp_insert_category($cat_name);
                }

                //Get ID of newly created category
                $category[] = get_cat_ID($create_new_cat);
				*/
				
                $new_post = array(
                    'post_title' => $post_title,
                    'post_content' => $post_content,
                    'post_status' => $post_status,
                    'post_type' => 'post',
                    'post_author' => $user_id,
                    'post_category' => $category,
                    //'tags_input' => $tags_input,  
                );

                $pid = wp_insert_post($new_post);

                if ($_FILES) {
                    array_reverse($_FILES);
                    $i = 0;
                    foreach ($_FILES as $file => $array) {
                        if( $array['name'] != '' ){
                            if ($i == 0){ 
                                $set_feature = 1; 
                            } else {
                                $set_feature = 0;
                            } 
                            $newupload = wp__insert_attachment($file, $pid, $set_feature);  
                        }else{
                            update_post_meta($pid,'_thumbnail_id','');
                        }                  
                    }
                }

                if(!empty($pid)){

                    $user_obj = get_user_by('id', $user_id);

                    //do_action('user_apply_post_approval',$user_obj->user_email);
                    add_post_meta( $pid, 'article_penname', $article_penname, true );

                    $redirect = home_url().'/account/?section=submit-article&msg=success';
                    wp_safe_redirect( $redirect );
                    exit();
                }else{
                    $redirect = home_url().'/account/?section=submit-article&msg=error';
                    wp_safe_redirect( $redirect );
                    exit();
                }
            }
        }
    }
}

add_action('init', 'wp__add_article');


function wp__edit_article() {

    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'edit-article'  ) {

        if( wp_verify_nonce($_POST['_wpnonce'], 'edit-article') ) {

            $post_id = $_POST['post_id'];
            $post_title = $_POST['post_title'];
            $post_content = $_POST['post_content'];
            $category = $_POST['category'];
            $post_status = $_POST['post_status'];
            $article_penname = $_POST['article_penname'];
            //$tags_input = $_POST['post_tags_input'];
			$post_image_attachment_id = $_POST['post_image_attachment_id'];

            if(empty($post_title)) {
                pippin_errors()->add('Post Title', __('Please enter post title'));
            }   

            if(empty($post_content)) {
                pippin_errors()->add('Post Content', __('Please enter post Content'));
            } 

            if( empty($category)) {                
                pippin_errors()->add('Post Category', __('Please select post category'));
            }

            if( empty($post_status) ) {                
                pippin_errors()->add('Post Submit', __('Please select article submit post type'));
            }  

            if( empty($article_penname) ) {                
                pippin_errors()->add('Penname', __('Please select Pennmae'));
            }              

            $errors = pippin_errors()->get_error_messages();

            if(empty($errors)) {


                $new_post = array(
                    'ID' => $post_id,
                    'post_title' => $post_title,
                    'post_content' => $post_content,
                    'post_status' => $post_status,
                    'post_type' => 'post',
                    'post_category' =>  $category,
                    //'tags_input' => $tags_input,
                );

                $pid = wp_update_post($new_post);
				
                if ($_FILES) {
                    array_reverse($_FILES);
                    $i = 0;
                    foreach ($_FILES as $file => $array) {
                        if( $array['name'] != '' ){
                            if ($i == 0){ 
                                $set_feature = 1; 
                            } else {
                                $set_feature = 0;
                            } 
                            $newupload = wp__insert_attachment($file,$pid, $set_feature);  
                        }else{
                            update_post_meta($pid,'_thumbnail_id',$post_image_attachment_id);
                        }                  
                    }
                }

                if(!empty($pid)){

                    update_post_meta( $post_id, 'article_penname', $article_penname, true );

                    $redirect = home_url().'/account/?section=edit-article&id='.$post_id.'&msg=success';
                    wp_safe_redirect( $redirect );
                    exit();
                }else{
                    $redirect = home_url().'/account/?section=edit-article&id='.$post_id.'&msg=error';
                    wp_safe_redirect( $redirect );
                    exit();
                }
            }
        }
    }
}

add_action('init', 'wp__edit_article');


function wp__add_penname() {

    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'add-penname'  ) {

        if( wp_verify_nonce($_POST['_wpnonce'], 'add-penname') ) {

            $penname = $_POST['penname'];
            $user_id = $_POST['user_id'];

            if(empty($penname)) {
                pippin_errors()->add('Penname', __('Please enter penname'));
            } 

            if(empty($user_id)) {
                pippin_errors()->add('User', __('Someting gone wrong please try again'));
            } 

            $errors = pippin_errors()->get_error_messages();

            if(empty($errors)) {

                $previous_data = get_user_meta($user_id, 'pennames_'.$user_id, true);

                if ($_FILES) {
                    array_reverse($_FILES);                   
                    foreach ($_FILES as $file => $array) {
                        $set_feature = 0;                        
                        $newupload = wp__insert_attachment($file,$user_id, $set_feature);                    
                    }
                } 

                $image_attchment_id = $newupload;

                global $wpdb;
                $table = 'wp_penname';
                $data = array('user_id' => $user_id, 'image' => $image_attchment_id , 'penname' =>$penname);
                $format = array('%d','%s','%s');
                $wpdb->insert($table,$data,$format);
                $pen_id = $wpdb->insert_id;

                if($pen_id){
                    wp_update_user( array(
                        'ID'            => $user_id,
                        'user_nicename' => $penname
                    ) );
                    $redirect = home_url().'/account/?section=add-pennames&msg=success';
                    wp_safe_redirect( $redirect );
                    exit();     
                }else{
                    $redirect = home_url().'/account/?section=add-pennames&msg=error';
                    wp_safe_redirect( $redirect );
                    exit();    
                }          
            }
        }
    }
}
add_action('init', 'wp__add_penname');


// Verify user & conformation link
function wp__verify_user_code(){
    //http://localhost/wordpress-zealapp/login/?act=YToyOntzOjI6ImlkIjtpOjEzO3M6NDoiY29kZSI7czozMjoiZGQ1Y2M2ZWFlYTAyZjQzNDYwMGM2MDkzMWJlYTdhYTAiO30=
    if(isset($_REQUEST['act']) && !empty($_REQUEST['act'])){
        
        $data = base64_decode($_REQUEST['act']);
        $data = unserialize($data);

        $code = get_user_meta($data['id'], 'activation_code', true);
        $account_activated = get_user_meta($data['id'], 'account_activated', true);
        // verify whether the code given is the same as ours
        if($code == $data['code']){
            // update the user meta
            if( $account_activated == 0){
                update_user_meta($data['id'], 'account_activated', 1);
                $redirect = home_url().'/login/?user_verify=1'; 
                wp_safe_redirect( $redirect );
                exit();
            }else{
                $redirect = home_url().'/login/'; 
                wp_safe_redirect( $redirect );
                exit();
            }            
        }else{
            $redirect = home_url().'/login/?user_verify=0'; 
            wp_safe_redirect( $redirect );
            exit();
        }
    }
}
add_action( 'init', 'wp__verify_user_code' );

// used for tracking error messages
function pippin_errors(){
    static $wp_error; // Will hold global variable safely
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

// displays error messages from form submissions
function pippin_show_error_messages() {
    if($codes = pippin_errors()->get_error_codes()) {
        echo '<div class="pippin_errors">';
            // Loop error codes and display errors
           foreach($codes as $code){
                $message = pippin_errors()->get_error_message($code);
                echo '<span class="error"><strong>' . __('Error') . '</strong>: ' . $message . '</span><br/>';
            }
        echo '</div>';
    }   
}


/**
 * Hide admin bar for non-admins
 */
function wp__js_hide_admin_bar( $show ) {
    if ( ! current_user_can( 'administrator' ) ) {
        return false;
    }
    return $show;
}
add_filter( 'show_admin_bar', 'wp__js_hide_admin_bar' );


/**
 * Block wp-admin access for non-admins
 */
function wp__block_wp_admin() {
    if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        $redirect_to = home_url().'/account/';
        wp_safe_redirect( $redirect_to );
        exit;
    }
}
add_action( 'admin_init', 'wp__block_wp_admin' );


function wp__theme_css_scripts() {
    wp_enqueue_script( 'jquery-validate', get_template_directory_uri() . '/assets/js/jquery.validate.min.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'jquery-select2', get_template_directory_uri() . '/assets/js/select2.min.js', array('jquery'), '1.0.0', true );

    wp_enqueue_style( 'css-select2', get_theme_file_uri() . '/assets/css/select2.min.css' );

}
add_action( 'wp_enqueue_scripts', 'wp__theme_css_scripts' );


add_action( 'wp_footer', 'wp__footer_scripts' );
function wp__footer_scripts(){
  ?>
  <script type="text/javascript">
      jQuery(document).ready(function () {
		  
		var get_current_url = window.location.href.replace(window.location.search,'');
		var urlChunks = get_current_url.split('/');
		var check_current_page = urlChunks[urlChunks.length - 2];
		
		if(check_current_page == 'account'){
			jQuery('#menu-main-navigation .menu-item').removeClass('current_page_parent');
		}
		
        jQuery("#registration_form").validate({
            rules: {
                password: {
                    required: true,
                    minlength: 8
                },
                password_again: {
                  equalTo: "#password"
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "pippin_term_condition") {
                    error.insertAfter("#term_condition_error_msg");
                }else{
                    error.insertAfter( element );
                }
            }
        });

        jQuery("#pippin_login_form").validate();

        jQuery("#post_image_preview").on('click','.remove-img',function(e) {
            jQuery('#post_image_preview img').remove(); 
            jQuery('#post_image_preview .remove-img').remove(); 
            jQuery('#post_image,#penn_image').val('');
			jQuery('#post_image_attachment_id').val('');
			jQuery('#profile_attachment_id').val('');			
        });

        jQuery("#post_image,#penn_image,#wp_custom_user_profile_avatar").on('change', function () {
			 jQuery("#file_error").html("");
			 jQuery("#post_image,#penn_image,#wp_custom_user_profile_avatar").css("border-color","#F0F0F0");
			 var file_size = jQuery(this)[0].files[0].size;
			 if(file_size>2097152) {
				jQuery("#file_error").html("File size is greater than 2MB");
				jQuery("#post_image,#penn_image,#wp_custom_user_profile_avatar").css("border-color","#FF0000");
				jQuery(this).val('');
				return false;
			 } 
	
             //Get count of selected files
             var countFiles = jQuery(this)[0].files.length;

             var imgPath = jQuery(this)[0].value;
             var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
             var image_holder = jQuery("#post_image_preview");
             image_holder.empty();

             if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                 if (typeof (FileReader) != "undefined") {

                     //loop for each file selected for uploaded.
                    for (var i = 0; i < countFiles; i++) {

                         var reader = new FileReader();
                         reader.onload = function (e) {
                             jQuery("<img />", {
                                "src": e.target.result,
                                "class": "thumb-image",
                                "width":'200',
                                "height":'200',   
                             }).appendTo(image_holder);

                             jQuery("<span class='remove-img'></span>").appendTo('#post_image_preview');
                        }

                        image_holder.show();
                        reader.readAsDataURL(jQuery(this)[0].files[i]);
                    }

                 } else {
                     alert("This browser does not support FileReader.");
                 }
             } else {
                 alert("Pls select only images");
             }
         });

        jQuery('#category').select2();

        jQuery("#post_tags_input").select2({
            tags: true,
            tokenSeparators: [',', ' ']
        });

    });

  </script>
  <?php
}

add_action( 'wp_loaded', 'wp__internal_rewrites' );
function wp__internal_rewrites(){
     
    add_rewrite_rule( 'account$', 'index.php?account', 'top' );    
    flush_rewrite_rules();
}

add_filter( 'query_vars', 'wp__internal_query_vars' );
function wp__internal_query_vars( $query_vars ){
   
    $query_vars[] = 'account';
    return $query_vars;
}

add_action( 'template_include', 'wp__rewrites_parse_request1' );
function wp__rewrites_parse_request1( $template ){

    global $wp_query;
    
    if (array_key_exists( 'account', $wp_query->query_vars ) ) {
        return dirname( __FILE__ ) . '/user_account/account.php';
    } 

    return $template;
}

function custom_load_template( $file ) {
   
    $parent_theme_dir = get_template_directory() . '/user_account/';

    if ( file_exists( $parent_theme_dir . $file ) ) {
        include $parent_theme_dir . $file;
    }   
}


function wp__app_output_buffer() {
    ob_start();
} // soi_output_buffer
add_action('init', 'wp__app_output_buffer');


// Om logout redirect to home page
add_action('wp_logout','wp__auto_redirect_after_logout');
function wp__auto_redirect_after_logout(){
  wp_safe_redirect( home_url() );
  exit;
}

function add_login_register_nav_menu_items($items) {
	
	$directory = explode('/',ltrim($_SERVER['REQUEST_URI'],'/'));
	// loop through each directory, check against the known directories, and add class   
	$directories = array("account","login","register"); // set home as 'index', but can be changed based of the home uri
	foreach ($directories as $folder){
		$active[$folder] = ($directory[0] == $folder)? "current_page_parent":"";
	}

	if ( is_user_logged_in() ) { 
         $user = '<li id="menu-item-account" class="menu-item-account '.$active['account'].' "><a href="'.home_url('/account/').'" class="account">My Account</a></li>';
	     $user .= '<li id="menu-item-logout" class="menu-item-logout"><a href="'.wp_logout_url().'" class="logout">Logout</a></li>';
	} else { 
		 $user = '<li id="menu-item-register" class="menu-item-register '.$active['login'].' '.$active['register'].'"><a href="'.home_url( '/login/' ).'" title="login-register">Register/Login</a></li>';
	}
    $items = $items . $user;
    return $items;
}
add_filter( 'wp_nav_menu_main-navigation_items', 'add_login_register_nav_menu_items' );

add_filter('use_block_editor_for_post', '__return_false');


/** Footer Logo Function Start */
function footer_main_logo(){
    ob_start();
        if( has_custom_logo() ){
            $footerLogoID = attachment_url_to_postid( get_theme_mod( 'footer_logo' ) ) ; // Footer Logo ID
            $footerLogoImage = wp_get_attachment_image( $footerLogoID ,'large', '', ["class" => "footer-logo transition"] ); //Footer Logo Image

            echo '<div class="footer-logo position-relative transition">' .
                '<a href="' . get_option('home') . '" class="d-inline-block transition position-relative">' .
                    ( $footerLogoID ? $footerLogoImage : '' ) .
                '</a>' .
            '</div>';
        }
    return ob_get_clean();
}

/*Filter to modify the author display name on author page title for co-authors plus guest authors.*/
/*Solution for issue with yoast seo and co-authors plus guest author name reading for title of author page.*/
add_filter( 'wpseo_title', 'filterAndChangeAuthorTitle' );
function filterAndChangeAuthorTitle( $title ) {
	//check if author page, if it's not return as it is
	if ( ! is_author() ) {
		return $title;
	}
	global $wpdb, $post;
	$author_id = $post->post_author;
	$post_penname = $wpdb->get_row("SELECT * FROM wp_penname WHERE user_id = ". $author_id ."");
	$current_display_name = get_the_author_meta( 'display_name', get_query_var( 'author' ) );
	$new_display_name = $post_penname->penname;
	return str_replace( $current_display_name, $new_display_name, $title );
}