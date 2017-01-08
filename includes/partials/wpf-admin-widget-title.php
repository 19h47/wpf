<?php 
/**
 * Provides the markup for admin widget title
 *
 * @link       http://www.19h47.fr
 * @since      1.0.0
 *
 * @package    WPF
 * @subpackage wpf/includes
 */
?>

<p>	
	<label for="<?php echo $this->get_field_id( 'title' ) ?>">
		<?php _e( 'Titre du widget', $this->plugin_name ) ?>		
	</label>

	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" type="text" value="<?php echo esc_attr( $wpf_title ) ?>">
</p>