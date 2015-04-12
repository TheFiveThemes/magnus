<?php
/**
 * Magnus functions and definitions
 *
 * @package Magnus
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1088; /* pixels */
}

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
		'primary' => __( 'Primary Menu', 'magnus' ),
		'social'  => __( 'Social Links Menu', 'magnus' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'magnus_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'editor-style.css' ) );
}
endif; // magnus_setup
add_action( 'after_setup_theme', 'magnus_setup' );

/**
 * Register widget area.
 *
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
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Magnus 2.0
 */
function magnus_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'magnus_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 */
function magnus_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Montserrat:700|Roboto+Slab:300,700,400)');
    wp_enqueue_style( 'googleFonts');

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.3' );

	// Load our main stylesheet.
	wp_enqueue_style( 'magnus-style', get_stylesheet_uri() );

	wp_enqueue_script( 'magnus-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

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
 * Enqueue Google fonts style to admin screen for custom header display.
 *
 * @since Magnus 2.0
 */
function magnus_admin_fonts() {
	wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Montserrat:700|Roboto+Slab:300,700,400)');
    wp_enqueue_style( 'googleFonts');
}
add_action( 'admin_print_scripts-appearance_page_custom-header', 'magnus_admin_fonts' );

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
