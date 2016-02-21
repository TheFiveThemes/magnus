( function( $ ) {

	// Remove widdows and orphans from post titles
	$("h1.entry-title a, .single h1.entry-title").each(function() {
	  var wordArray = $(this).text().split(" ");
	  if (wordArray.length > 1) {
	    wordArray[wordArray.length-2] += "&nbsp;" + wordArray[wordArray.length-1];
	    wordArray.pop();
	    $(this).html(wordArray.join(" "));
	  }
	});

// Add a class to big image and caption >= 1088px.
// For some reason it's not working... HELP!

	// function bigImageClass() {
	// 	$( '.entry-content img.size-full' ).each( function() {
	// 		var img = $( this ),
	// 		    caption = $( this ).closest( 'figure' ),
	// 		    newImg = new Image();

	// 		newImg.src = img.attr( 'src' );

	// 		$( newImg ).load( function() {
	// 			var imgWidth = newImg.width;

	// 			if ( imgWidth >= 1088 ) {
	// 				$( img ).addClass( 'size-big' );
	// 			}

	// 			if ( caption.hasClass( 'wp-caption' ) && imgWidth >= 1088 ) {
	// 				caption.addClass( 'caption-big' );
	// 				caption.removeAttr( 'style' );
	// 			}
	// 		} );
	// 	} );
	// }

} )( jQuery );
