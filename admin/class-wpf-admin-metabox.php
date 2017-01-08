<?php

/**
 * The metaxbox functionality of the plugin.
 *
 * @link       http://www.19h47.fr/
 * @since      1.0.0
 *
 * @package    WPF
 * @subpackage wpf/includes
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    WPF
 * @subpackage wpf/includes
 * @author     Jérémy Levron levronjeremy@19h47.fr
 */
class WPF_Admin_Metabox {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;


	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $post_type_name ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->post_type_name = $post_type_name;
	}

	public function add_meta_boxes() {

		add_meta_box( 
			__( 'Ajouter des images',  $this->plugin_name ), 
			__( 'Ajouter des images', $this->plugin_name ), 
			array( $this, 'meta_box_form_function' ), 
			$this->post_type_name,
			'normal', 
			'low' 
		);

		add_meta_box ( 
			__( 'Shortcode de la galerie', $this->plugin_name ), 
			__( 'Shortcode de la galerie', $this->plugin_name ), 
			array( $this, 'meta_box_form_function_shortcode' ), 
			$this->post_type_name,
			'side', 
			'low');
    }
	
	/**
	 * meta_box_form_function description
	 * 
	 * @param $post
	 */
	public function meta_box_form_function( $post ) {
		
		$WPF_Settings = unserialize( get_post_meta( $post->ID, '_wpf_settings', true ) );

		if( count( $WPF_Settings[0] ) ) {

			$WPF_API_KEY = $WPF_Settings[0]['wpf_api_key'];
			$WPF_Album_ID = $WPF_Settings[0]['wpf_album_id'];
			$WPF_Show_Title = $WPF_Settings[0]['wpf_show_title'];
			$WPF_Custom_CSS = $WPF_Settings[0]['wpf_custom_css'];
		}

		 if( ! isset( $WPF_API_KEY ) ) {

		 	// Default API KEY
			$WPF_API_KEY = 'e54499be5aedef32dccbf89df9eaf921';
		 }
		 
		 if( ! isset( $WPF_Album_ID ) ) {

		 	// Default Flickr Album ID
			$WPF_Album_ID = '72157645975425037';
		 }
		 
		 if( ! isset( $WPF_Show_Title ) ) {

		 	// By default the title is displayed
			$WPF_Show_Title = "yes";
		 }
		
		// Check if WPF_Custom_CSS exist
		if( ! isset( $WPF_Custom_CSS ) ) $WPF_Custom_CSS = '';

		// Include template
		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-meta-box-normal.php' );
	}
	
	/**
	 * Save data from meta box
	 * @param int $post_id Post ID
	 */
	public function save_post( $post_id ) {

		// Return if API KEY AND Album ID are not set
		if( ! isset( $_POST['flickr-api-key'] ) && ! isset( $_POST['flickr-album-id'] ) ) {
 			return;
		}

		// return if autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
			return;
		}

      	// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ){
			return;
		}

		$WPF_API_KEY = $_POST['flickr-api-key'];
		$WPF_Album_ID = $_POST['flickr-album-id'];
		$WPF_Show_Title = $_POST['wpf-show-title'];
		$WPF_Custom_CSS = $_POST['wpf-custom-css'];

		$wpf_array[] = array(
			'wpf_api_key' => $WPF_API_KEY,
			'wpf_album_id' => $WPF_Album_ID,
			'wpf_show_title' => $WPF_Show_Title,
			'wpf_custom_css' => $WPF_Custom_CSS
		);
		update_post_meta( $post_id, '_wpf_settings', serialize( $wpf_array ) );	
	}

	/**
	 * Shortcode Meta Box
	 *
	 * @param $post
	 */
	public function meta_box_form_function_shortcode( $post ) { 
		// Include template
		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-meta-box-side.php' );
	}
}