<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Magnus
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'magnus' ); ?></a>

	<header id="masthead" class="site-header" role="banner">

		<div class="site-branding">

			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="header-navigation" role="navigation">
			<div class="menu-header-container">
			<?php wp_nav_menu(
			array(
				'theme_location' => 'secondary',
				'container' => 'false',
				'menu_id' => 'header-menu',
				'fallback_cb' => 'false',
				'depth' => '1'
			) ); ?>
			</div>
			<button class="sidebar-toggle" aria-controls="sidebar" aria-expanded="false">
				<span class="sidebar-toggle-icon"><?php _e( 'Sidebar', 'magnus' ); ?></span>
			</button>
		</nav><!-- #site-navigation -->

	</header><!-- #masthead -->


	<?php if (is_home()) : ?>

	<section id="content" class="blog-home-content">

	<?php else : ?>
	<section class="site-header-image">
		<?php // Check if this is a post or page, if it has a thumbnail, and if it's a big one
		if ( is_singular() && has_post_thumbnail(  get_the_ID() ) ) :
			// Houston, we have a new header image!
			//echo get_the_post_thumbnail( $post->ID, 'magnus-large' );

			$image_id = get_post_thumbnail_id();
			$url = wp_get_attachment_image_src( $image_id, 'magnus-large' ); ?>

			<div class="section-image" style="background-image: url(<?php echo esc_attr( $url[0] ); ?>);">
			</div><!-- .section-image -->

		<?php elseif ( get_header_image() ) : ?>
			<img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" />
		<?php endif; // end check for featured image or standard header ?>
	</section><!-- .site-header-image -->

	<section id="content" class="site-content">
	<?php endif; // end check for blog homepage ?>
