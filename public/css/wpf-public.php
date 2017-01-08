<?php 

/**
 * All of the CSS for your public-facing functionality should be
 * included in this file.
 */

?>

<style>
	<?php echo $WPF_Custom_CSS; ?>

	.flickr-img-responsive {
		width:100% !important;
		height:auto !important;
		display:block !important;
	}
	.LoadingImg img {
		max-width: 45px;
		max-height: 45px;
		box-shadow:  none;
	}
	@media ( max-width: 786px ) {
		.col-md-3 {
			width:49.9%;
			float:left;
		}
	}
	.play-pause {
		display: none !important;
	}
	.gallery<?php echo $ID; ?> {
		overflow:hidden;
	}
</style>