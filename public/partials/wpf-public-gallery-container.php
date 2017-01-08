<?php 
/**
 * Provides the markup for the container gallery
 *
 * @link       http://www.19h47.fr
 * @since      1.0.0
 *
 * @package    WPF
 * @subpackage wpf/includes
 */
?>

<div class="gallery<?php echo $current_ID ?>">

	<!-- Gallery Thumbnails -->
	<?php if( $WPF_Show_Title == "yes" ) : ?>

		<h3 style="border-bottom: 1px solid;">
			<?php echo ucwords( get_the_title( $current_ID ) ); ?>		
		</h3>

	<?php endif ?>

	<div class="row">
		<div class="col-xs-12 spinner-wrapper">

			<div class="LoadingImg">
				<?php echo '<img src="' . plugins_url( '../css/img/loading.gif', __FILE__ ) ?>" />		
			</div>

		</div>
		<div align="center" class="gallery-container"></div>
	</div>
</div>