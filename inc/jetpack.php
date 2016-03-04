<?php
/**
	* Jetpack Compatibility File.
	*
	* @link https://jetpack.me/
	*
	* @package Magnus
	*/

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.me/support/infinite-scroll/
 * See: https://jetpack.me/support/responsive-videos/
 */
function magnus_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'magnus_infinite_scroll_render',
		'footer'    => 'page',
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );
}
// temporarily off till I fix bug
// add_action( 'after_setup_theme', 'magnus_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function magnus_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
		    get_template_part( 'content', 'search' );
		else :
		    get_template_part( 'content', get_post_format() );
		endif;
	}
}
