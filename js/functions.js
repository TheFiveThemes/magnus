/* global screenReaderText */
/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */

( function( $ ) {
	var $body         = $( document.body ),
	    $window       = $( window ),
	    sidebar       = $( '#sidebar' ),
	    sidebarToggle = $( '#masthead' ).find( '#sidebar-toggle' ),
	    resizeTimer,
	    toolbarHeight,
	    mastheadHeight,
	    headerImageHeight;

	// Add dropdown toggle that display child menu items.
	$( '#sidebar .main-navigation .menu-item-has-children > a' ).after( '<button class="dropdown-toggle" aria-expanded="false">' + screenReaderText.expand + '</button>' );

	// Toggle buttons and submenu items with active children menu items.
	$( '#sidebar .main-navigation .current-menu-ancestor > button' ).addClass( 'toggle-on' );
	$( '#sidebar .main-navigation .current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );

	$( '.dropdown-toggle' ).click( function( e ) {
		var _this = $( this );
		e.preventDefault();
		_this.toggleClass( 'toggle-on' );
		_this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );
		_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
		_this.html( _this.html() === screenReaderText.expand ? screenReaderText.collapse : screenReaderText.expand );
	} );

	// Move the Page Links before Sharedaddy.
	$( '.single .hentry' ).each( function() {
		$( this ).find( '.page-links' ).insertBefore( $( this ).find( '.sharedaddy' ).first() );
	} );

	// Enable sidebar toggle.
	( function() {
		var sidebarMenu, widgets, social;
		if ( ! sidebar || ! sidebarToggle ) {
			return;
		}

		// Hide button if there are no widgets and the menus are missing or empty.
		sidebarMenu  = sidebar.find( '.main-navigation' );
		widgets      = sidebar.find( '#secondary' );
		social       = sidebar.find( '#social-navigation' );
		if ( ! widgets.length && ! social.length && ( ! sidebarMenu || ! sidebarMenu.children().length ) ) {
			sidebarToggle.hide();
			return;
		}

		sidebarToggle.on( 'click.magnus', function() {
			$body.toggleClass( 'sidebar-open' ).trigger( 'resize.magnus' );
			$( this ).toggleClass( 'toggled-on' );
			$( this ).attr( 'aria-expanded', sidebar.attr( 'aria-expanded' ) === 'true' ? 'false' : 'true');
			sidebar.attr( 'aria-hidden', sidebar.attr( 'aria-hidden' ) === 'false' ? 'true' : 'false');
		} );
	} )();

	// Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
	( function() {
		var menu = $( '#masthead' ).find( '.nav-menu' );
		if ( ! menu || ! menu.children().length ) {
			return;
		}

		if ( 'ontouchstart' in window ) {
			menu.find( '.menu-item-has-children > a' ).on( 'touchstart.magnus', function( e ) {
				var el = $( this ).parent( 'li' );

				if ( ! el.hasClass( 'focus' ) ) {
					e.preventDefault();
					el.toggleClass( 'focus' );
					el.siblings( '.focus' ).removeClass( 'focus' );
				}
			} );
		}

		menu.find( 'a' ).on( 'focus.magnus blur.magnus', function() {
			$( this ).parents( '.menu-item' ).toggleClass( 'focus' );
		} );
	} )();

	// Make Featured image full-screen.
	function fullscreenFeaturedImage() {
		var entryHeaderBackground, entryHeaderHeight, entryHeaderOffset = 0, windowWidth;
		entryHeaderBackground = $( '.entry-header-background' );

		if ( ! entryHeaderBackground ) {
			return;
		}

		toolbarHeight     = $body.is( '.admin-bar' ) ? $( '#wpadminbar' ).height() : 0;
		mastheadHeight    = $( '#masthead' ).outerHeight();
		headerImageHeight = $( '.header-image' ).height();
		entryHeaderHeight = $window.height() - ( toolbarHeight + mastheadHeight + headerImageHeight );
		windowWidth       = $window.width();

		// 1088 is site-main width.
		if ( 1088 < windowWidth ) {
			entryHeaderOffset = ( windowWidth - 1088 ) / 2;
		}

		entryHeaderBackground.css( {
			'height': entryHeaderHeight + 'px',
			'margin-left':  '-' + entryHeaderOffset + 'px',
			'margin-right':  '-' + entryHeaderOffset + 'px'
		} );
	}

	// Minimum height for sidebar.
	function sidebarSize() {
		var sidebarMinHeight;

		if ( ! sidebar ) {
			return;
		}

		toolbarHeight     = $body.is( '.admin-bar' ) ? $( '#wpadminbar' ).height() : 0;
		mastheadHeight    = $( '#masthead' ).outerHeight();
		headerImageHeight = $( '.header-image' ).height();
		sidebarMinHeight  = $window.height() - ( toolbarHeight + mastheadHeight + headerImageHeight );

		sidebar.css( {
			'min-height': sidebarMinHeight + 'px'
		} );
	}

	// Scroll up when the arrow is clicked.
	function scroll() {
		if ( ! $( '#scroll-indicator' ) ) {
			return;
		}

		$( '#scroll-indicator' ).on( 'click.magnus', function() {
			$( 'html, body' ).animate( {
				scrollTop: $( '#entry-header' ).offset().top + 24
			}, 300  );
			return false;
		} );
	}

	// Add a class to change opacity of the arrow and to move the entry header.
	$( function() {
		if ( ! $( '#scroll-indicator' ) ) {
			return;
		}

		$window.on( 'scroll.magnus', function() {
			if ( 0 < $window.scrollTop() ) {
				$( '#scroll-indicator, #entry-header' ).addClass ( 'scrolled' );
			} else {
				$( '#scroll-indicator, #entry-header' ).removeClass ( 'scrolled' );
			}
		} );
	} );

	// Add body classes to modify layout.
	function bodyClasses() {
		if ( $window.width() > 924 ) {
			var widgets             = sidebar.find( '#secondary' ),
			    social              = sidebar.find( '#social-navigation' ),
			    masthead            = $( '#masthead' ),
			    siteBrandingWidth   = masthead.find( '.site-branding' ).width() + 32,
		        mainNavigationWidth = masthead.find( '.main-navigation' ).width() - 16,
		        mastheadWidth       = masthead.width();

			if ( ! widgets.length && ! social.length ) {
				$body.addClass( 'no-sidebar' );
			} else {
				$body.removeClass( 'no-sidebar' );
			}

			if ( mastheadWidth < ( siteBrandingWidth + mainNavigationWidth + sidebarToggle.width() ) ) {
				$body.addClass( 'menu-left' );
			} else {
				$body.removeClass( 'menu-left' );
			}
		} else {
			$body.removeClass( 'no-sidebar, menu-left' );
		}
	}

	// Add a class to big image and caption >= 1088px.
	function bigImageClass() {
		$( '.entry-content img.size-full' ).each( function() {
			var img = $( this ),
			    caption = $( this ).closest( 'figure' ),
			    newImg = new Image();

			newImg.src = img.attr( 'src' );

			$( newImg ).load( function() {
				var imgWidth = newImg.width;

				if ( imgWidth >= 1088 ) {
					$( img ).addClass( 'size-big' );
				}

				if ( caption.hasClass( 'wp-caption' ) && imgWidth >= 1088 ) {
					caption.addClass( 'caption-big' );
					caption.removeAttr( 'style' );
				}
			} );
		} );
	}

	// Close Sidebar with an escape key.
	$( document ).keyup( function( e ) {
		if ( e.keyCode === 27 && sidebarToggle.hasClass( 'toggled-on' ) ) {
			$body.removeClass( 'sidebar-open' );
			sidebarToggle.removeClass( 'toggled-on' ).attr( 'aria-expanded', 'false' );
			sidebar.attr( 'aria-hidden', 'true' );
		}
	} );

	$( document ).ready( function() {
		$window.on( 'resize.magnus', function() {
			clearTimeout( resizeTimer );
			resizeTimer = setTimeout( function() {
				sidebarSize();
				fullscreenFeaturedImage();
				bodyClasses();
			}, 300 );
		} );

		sidebarSize();
		fullscreenFeaturedImage();
		bodyClasses();
		bigImageClass();
		scroll();

		for ( var i = 1; i < 4; i++ ) {
			setTimeout( sidebarSize, 100 * i );
			setTimeout( fullscreenFeaturedImage, 100 * i );
			setTimeout( bodyClasses, 100 * i );
		}
	} );
} )( jQuery );
