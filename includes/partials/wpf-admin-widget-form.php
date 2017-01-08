<?php 
/**
 * Provides the markup for admin widget form
 *
 * @link       http://www.19h47.fr
 * @since      1.0.0
 *
 * @package    WPF
 * @subpackage wpf/includes
 */
?>

<p>
	<label for="<?php echo $this->get_field_id( 'shortcode' ) ?>">
			<?php _e( 'Sélectionner', $this->plugin_name ) ?>&nbsp;Obligatoire
		</label>

	<select id="<?php echo $this->get_field_id( 'shortcode' ) ?>" name="<?php echo $this->get_field_name( 'shortcode' ) ?>" style="width: 100%;">

		<option value="<?php _e( 'Sélectionner une galerie', $this->plugin_name ) ?>" <?php echo ( $wpf_shortcode == __( 'Sélectionner une galerie', $this->plugin_name ) ) ? 'selected="selected"' : '' ?>>
			<?php _e( 'Sélectionner une galerie', $this->plugin_name ) ?>
		</option>

		<?php

		while ( $wpf_posts->have_posts() ) : $wpf_posts->the_post();
			
			$wpf_post_ID = get_the_ID();
			$wpf_post_title = get_the_title( $wpf_post_ID );
		?>

			<option value="<?php echo $wpf_post_ID ?>" <?php echo ( $wpf_shortcode == $wpf_post_ID ) ? 'selected="selected"' : '' ?>>
				<?php echo $wpf_post_title ? $wpf_post_title : __( 'Galerie sans titre', $this->plugin_name ) ?>
			</option>

		<?php endwhile; ?>

	</select>
</p>