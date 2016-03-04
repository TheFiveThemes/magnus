<?php
/**
 * Magnus functions and definitions
 *
 * @package Magnus
 */

if ( ! function_exists( 'magnus_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function magnus_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Magnus, use a find and replace
	 * to change 'magnus' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'magnus', get_template_directory() . '/languages' );

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
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 256, 256, true );
	add_image_size( 'magnus-large', 2000, 1500, true  );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
        'primary' => __( 'Primary Sidebar Navigation', 'magnus' ),
				// 'social'  => __( 'Social Links', 'magnus' ),
        'secondary' => __( 'Header Quick Navigation', 'magnus' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );
}
endif; // magnus_setup
add_action( 'after_setup_theme', 'magnus_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * Priority 0 to make it available to lower priority callbacks.
 * @global int $content_width
 */
function magnus_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'magnus_content_width', 1088 );
}
add_action( 'after_setup_theme', 'magnus_content_width', 0 );

/**
 * Register widget area.
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function magnus_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'magnus' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'magnus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'magnus_widgets_init' );


/**
 * JavaScript Detection.
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 * @since Magnus 2.0
 */
function magnus_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'magnus_javascript_detection', 0 );


/**
 * Google Fonts
 * Gives translators ability to deactivate fonts that don't include their language's characters.
 * @since Magnus 2.0
 */
function magnus_fonts_url() {
    $fonts_url = '';

    /* Translators: If there are characters in your language that are not
    * supported by Montserrat, translate this to 'off'. Do not translate
    * into your own language.
    */
    $montserrat = _x( 'on', 'Montserrat font: on or off', 'magnus' );

    /* Translators: If there are characters in your language that are not
    * supported by Roboto Slab, translate this to 'off'. Do not translate
    * into your own language.
    */
    $karla = _x( 'on', 'Karla font: on or off', 'magnus' );

    if ( 'off' !== $montserrat || 'off' !== $karla ) {
        $font_families = array();

        if ( 'off' !== $montserrat ) {
            $font_families[] = 'Montserrat:400,700';
        }

        if ( 'off' !== $karla ) {
            $font_families[] = 'Karla:400,700,400italic,700italic';
        }

        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );

        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }

    return $fonts_url;
}


/**
 * Enqueue scripts and styles.
 */
function magnus_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'magnus-fonts', magnus_fonts_url(), array(), null );

	// Load our main stylesheet.
	wp_enqueue_style( 'magnus-style', get_stylesheet_uri() );

    // Load scripts
	wp_enqueue_script( 'magnus-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), '20120206', true );

	wp_enqueue_script( 'magnus-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'magnus-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20150302' );
	}

	// Javacript functions in Magnus.
	wp_enqueue_script( 'magnus-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150302', true );

}
add_action( 'wp_enqueue_scripts', 'magnus_scripts' );


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
