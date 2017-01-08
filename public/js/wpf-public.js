(function( $ ) {
	'use strict';
	// Engage gallery.
	$('.gallery' + wpf_gallery.id).flickr({
		apiKey: wpf_gallery.key,
		photosetId: wpf_gallery.album_id
	});

})( jQuery );