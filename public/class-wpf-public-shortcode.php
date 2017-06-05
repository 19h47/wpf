<?php

/**
 * The widget functionality of the plugin.
 *
 * @link       http://www.19h47.fr
 * @since      1.0.0
 *
 * @package    WPF
 * @subpackage wpf/includes
 */


/**
 * The widget functionality of the plugin.
 *
 * @package    WPF
 * @subpackage wpf/includes
 * @author     Jérémy Levron levronjeremy@19h47.fr
 */
class WPF_Shortcode {
	
	/**
	 * The ID of this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$plugin_name 		The ID of this plugin.
	 */
	private $plugin_name;
	
	
	/**
	 * Register widget with WordPress.
	 */
	function __construct( $plugin_name, $version, $post_type_name ) {
		
		$this->plugin_name = $plugin_name;
		$this->version = $version;
        	$this->post_type_name = $post_type_name;
	}

	
	/**
	 * Register the stylesheets for the shortcode of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		
		/**
		 * Bootstrap
		 * 
		 * @version 3.3.1
		 */
		wp_enqueue_style( 
			'bootstrap', 
			plugin_dir_url( __FILE__ ) . '/css/vendor/bootstrap.css', 
			false
		);

		
		/**
		 * blueimp Gallery
		 * 
		 * @see https://github.com/blueimp/Gallery
		 * @version 2.22.0
		 */
		wp_enqueue_style( 
			'blueimp-gallery', 
			plugin_dir_url( __FILE__ ) . '/css/vendor/blueimp-gallery.min.css',
			false
		);

		
		/**
		 * Site
		 */
		wp_enqueue_style( 
			$this->plugin_name . '-site', 
			plugin_dir_url( __FILE__ ) . '/css/site.css', 
			false,
			null
		);
		
		
		/**
		 * Font Awesome 
		 *
		 * @see https://github.com/FortAwesome/Font-Awesome
		 * @version 4.7.0
		 */
		wp_enqueue_style( 
			'font-awesome', 
			plugin_dir_url( __FILE__ ) . '/css/vendor/font-awesome.min.css',
			false
		);
	}

	/**
	 * Register the JavaScript for the shortocde of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'jquery' );

		/**
		 * Bootstrap
		 *
		 * @version 3.3.7
		 * @see https://github.com/twbs/bootstrap
		 */
		wp_enqueue_script( 
			'bootstrap', 
			plugin_dir_url( __FILE__ ) . '/js/vendor/bootstrap.min.js', 
			'', 
			false
		);
		

		/**
		 * imagesLoaded
		 *
		 * @version 4.1.1
		 * @see https://github.com/desandro/imagesloaded
		 */
		wp_enqueue_script( 
			'imagesLoaded', 
			plugin_dir_url( __FILE__ ) . '/js/vendor/imagesloaded.pkgd.min.js', 
			'',
			false, 
			true 
		);
		

		/**
		 * blueimp Gallery
		 * 
		 * @version 2.22.0
		 * @see https://github.com/blueimp/Gallery
		 */
		wp_enqueue_script( 
			'blueimp-gallery', 
			plugin_dir_url( __FILE__ ) . '/js/vendor/jquery.blueimp-gallery.min.js', 
			array('jquery'), 
			false, 
			true 
		);
		

		/**
		 * jQuery Flickr Photoset
		 * @see https://github.com/hadalin/jquery-flickr-photoset
		 */
		wp_enqueue_script( 
			'flickr-photoset', 
			plugin_dir_url( __FILE__ ) . '/js/vendor/jquery.flickr-photoset.js', 
			array( 
				'jquery', 
				'bootstrap',
				'imagesLoaded', 
				'blueimp-gallery'
			), 
			false, 
			true 
		);
	}
	

	/**
	 * add_shortcode description
	 * 
	 */
	function add_shortcode( $gallery ) {

	    	if( ! isset( $gallery['id'] ) ) {
			echo "<div align='center' class='alert alert-danger'>" . __( 'Sorry! Invalid Flickr Album Shortcode Embedded', $this->plugin_name ) . "</div>";

			return;
		}

	    	ob_start();

		// $args for WP_Query
		$args = array(  
			'p' 		=> $gallery['id'], 
			'post_type' 	=> $this->post_type_name, 
			'orderby' 	=> 'ASC', 
			'post_status' 	=> 'publish'
		);

		$wpf_posts = new WP_Query( $args );
		
		// If the query have post
		while ( $wpf_posts->have_posts() ) : $wpf_posts->the_post();
				
			// Get All Photos from Gallery Details Post Meta
			$current_ID = get_the_ID();

			$WPF_Settings = unserialize( get_post_meta( $current_ID, '_wpf_settings', true ) );
			
			// For each setting find in WPF_settings 
			foreach( $WPF_Settings as $WPF_Setting ) :
						
				$WPF_API_KEY = $WPF_Setting['wpf_api_key'];
				$WPF_Album_ID = $WPF_Setting['wpf_album_id'];
				$WPF_Show_Title = $WPF_Setting['wpf_show_title'];
				$WPF_Custom_CSS = $WPF_Setting['wpf_custom_css'];
	
				// Include CSS with dynamic var
				include( plugin_dir_path( __FILE__ ) . 'css/' . $this->plugin_name . '-public.php' );

				wp_register_script( 
					$this->plugin_name, 
					plugin_dir_url( __FILE__ ) . 'js/' . $this->plugin_name . '-public.js',
					array( 'jquery', 'flickr-photoset' ),
					false
				);

				wp_localize_script( 
					$this->plugin_name,
					'wpf_gallery',
					array(
						'key' 		=> $WPF_API_KEY,
						'album_id' 	=> $WPF_Album_ID,
						'id'		=> $current_ID
					)
				);
				wp_enqueue_script( $this->plugin_name );
			
				include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-public-gallery-container.php' );

			endforeach;
		endwhile;
			
		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-public-gallery.php' );

		wp_reset_query();

		return ob_get_clean();
	}
}
