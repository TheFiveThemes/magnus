<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Magnus
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function magnus_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'magnus_jetpack_setup' );

/**
 * Add support for the Site Logo
 *
 * @since Magnus 1.0
 */
function magnus_site_logo_init() {
    add_image_size( 'magnus-logo', 192, 192 );
    add_theme_support( 'site-logo', array( 'size' => 'magnus-logo' ) );
}
add_action( 'after_setup_theme', 'magnus_site_logo_init' );

/**
 * Return early if Site Logo is not available.
 *
 * @since Magnus 2.0
 */
function magnus_the_site_logo() {
    if ( ! function_exists( 'jetpack_the_site_logo' ) ) {
        return;
    } else {
        jetpack_the_site_logo();
    }
}
