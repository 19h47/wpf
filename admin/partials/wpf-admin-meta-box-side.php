<?php 
/**
 * Provides the markup for metabox side
 *
 * @link       http://www.19h47.fr
 * @since      1.0.0
 *
 * @package    WPF
 * @subpackage wpf/includes
 */
?>

<p>
	<?php _e( 'Utilisez le Shortcode ci-dessous dans n\'importe quelle page/poste pour publier votre galerie.', $this->plugin_name ) ?>		
</p>
<input readonly="readonly" type="text" value="<?php echo '[WPF id=' .  $post->ID . ']' ?>">