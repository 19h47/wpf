<?php 
/**
 * Provides the markup for metabox normal
 *
 * @link       http://www.19h47.fr
 * @since      1.0.0
 *
 * @package    WPF
 * @subpackage wpf/includes
 */
?>

<p>
    <strong>
        <?php _e( 'Saisisser la clé API Flickr', $this->plugin_name ) ?>
    </strong>
</p>

<input type="text" name="flickr-api-key" id="flickr-api-key" value="<?php echo $WPF_API_KEY ?>" class="regular-text" > 

<p>
    <a title="<?php _e( 'Obtener la clé API de votre compte Flickr', $this->plugin_name ) ?>" href="" target="_blank">
        <?php _e( 'Obtener la clé API', $this->plugin_name ) ?>      
    </a>
</p>
<br>

<p>
    <strong>
        <?php _e( 'Entrer l\'ID de l\'album Flickr', $this->plugin_name ) ?>     
    </strong>
</p>

<input type="text" name="flickr-album-id" id="flickr-album-id" value="<?php echo $WPF_Album_ID ?>" class="regular-text" /><br>

<p>
    <a title="<?php _e( 'Obtenir l\'ID de votre album Flickr', $this->plugin_name ) ?>" href="" target="_blank">
        
        <?php _e( 'Obtenir l\'ID de votre album', $this->plugin_name ) ?>
            
    </a>
</p>
<br>



<p>
    <strong>
        <?php _e( 'Afficher le titre de la galerie', $this->plugin_name ) ?>
    </strong>
</p>
<fieldset>
    <legend class="screen-reader-text">
        <span>input type="radio"</span>
    </legend>
    <label title='g:i a'>

        <input type="radio" name="wpf-show-title" id="wpf-show-title" value="yes" <?php if( $WPF_Show_Title == 'yes' ) echo 'checked' ?>/>
        
        <span>
            <?php esc_attr_e( 'Oui', $this->plugin_name ) ?>        
        </span>

    </label><br>
    <label title='g:i a'>

        <input  type="radio" name="wpf-show-title" id="wpf-show-title" value="no" <?php if( $WPF_Show_Title == 'no' ) echo 'checked' ?>/>
        
        <span>
            <?php esc_attr_e( 'Non', $this->plugin_name ) ?>        
        </span>

    </label>
</fieldset>
<br>

<p>
    <strong>
        <?php _e( 'CSS personnalisées', $this->plugin_name ) ?>
    </strong>
</p>

<?php

    $textarea  = '<textarea name="wpf-custom-css" class="large-text" id="wpf-custom-css" rows="10" cols="80">';
    $textarea .= $WPF_Custom_CSS;
    $textarea .= '</textarea>';
    
    echo $textarea;

?>

<p>
    <?php _e( 'Entrez les CSS personnalisées que vous souhaitez appliquer.', $this->plugin_name); ?><br>
    <?php _e( 'Note', $this->plugin_name); ?>&nbsp;:
    <?php _e( 'Veuillez ne pas utiliser le tag' , $this->plugin_name); ?>&nbsp;<strong>&lt;style&gt;...&lt;/style&gt;</strong> 
    <?php _e( 'dans ce champ' , $this->plugin_name); ?>.
</p>