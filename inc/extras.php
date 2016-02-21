<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Magnus
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function magnus_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( is_singular() ) {
		$classes[] = 'single';
	}

	if ( has_nav_menu( 'primary' ) ) {
		$classes[] = 'custom-menu';
	}

	if ( is_singular() && has_post_thumbnail() ) {
        $classes[] = 'featured-image';
    }

    if (get_header_image() != '') {
    	$classes[] = 'header-image';
    }

    if (is_home()) {
    	$classes[] = 'fullpage-panels';
    }

	return $classes;
}
add_filter( 'body_class', 'magnus_body_classes' );



if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function magnus_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'magnus' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'magnus_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function magnus_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'magnus_render_title' );
endif;



/**
 * Limit number of nav menu items on primary menu
 */
function magnus_nav_menu_objects( $sorted_menu_items, $args ) {
    if ( $args->theme_location != 'secondary' )
        return $sorted_menu_items;
    $unset_top_level_menu_item_ids = array();
    $array_unset_value = 1;
    $count = 1;

    foreach ( $sorted_menu_items as $sorted_menu_item ) {

        // unset top level menu items if over count 3
        if ( 0 == $sorted_menu_item->menu_item_parent ) {
            if ( $count > 3 ) {
                unset( $sorted_menu_items[$array_unset_value] );
                $unset_top_level_menu_item_ids[] = $sorted_menu_item->ID;
            }
            $count++;
        }

        // unset child menu items of unset top level menu items
        if ( in_array( $sorted_menu_item->menu_item_parent, $unset_top_level_menu_item_ids ) )
            unset( $sorted_menu_items[$array_unset_value] );

        $array_unset_value++;
    }

    return $sorted_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'magnus_nav_menu_objects', 10, 2 );

?>
