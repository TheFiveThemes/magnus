<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Magnus
 */

if ( has_nav_menu( 'primary' ) || has_nav_menu( 'social' ) || is_active_sidebar( 'sidebar-1' )  ) : ?>
    <div id="sidebar" class="sidebar">
        <div id="sidebar-inner" class="sidebar-inner">

        <?php if ( has_nav_menu( 'primary' ) ) : ?>
            <nav class="main-navigation widget" role="navigation">
                <h2 class="menu-heading widget-title"><?php _e( 'Navigation', 'magnus' ); ?></h2>
                <?php
                    // Primary navigation menu.
                    wp_nav_menu( array(
                        'menu_class'     => 'nav-menu',
                        'theme_location' => 'primary',
                    ) );
                ?>
            </nav><!-- .main-navigation -->
        <?php endif; ?>

        <?php if ( has_nav_menu( 'social' ) ) : ?>
            <nav id="social-navigation widget" class="social-navigation" role="navigation">
                <?php
                    // Social links navigation menu.
                    wp_nav_menu( array(
                        'theme_location' => 'social',
                        'depth'          => 1,
                        'link_before'    => '<span class="screen-reader-text">',
                        'link_after'     => '</span>',
                    ) );
                ?>
            </nav><!-- .social-navigation -->
        <?php endif; ?>

        <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
            <div id="secondary" class="widget-area" role="complementary">
                <?php dynamic_sidebar( 'sidebar-1' ); ?>
            </div><!-- .widget-area -->
        <?php endif; ?>

        </div>
    </div><!-- .sidebar -->
<?php endif; ?>