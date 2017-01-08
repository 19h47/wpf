<?php

/**
 * The custom post type-specific functionality of the plugin.
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
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WPF
 * @subpackage wvf/includes
 * @author     Jérémy Levron levronjeremy@19h47.fr
 */
class WPF_Admin_Custom_Post_Type {

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

	/**
	 * Creates a new custom post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_post_type()
	 */
	public static function register_post_type() {
		
		$labels = array(
			'name' 					=> _x( 'Galerie', $this->plugin_name ),
			'singular_name' 		=> _x( 'Galerie', $this->plugin_name ),
			'add_new' 				=> __( 'Ajouter', $this->plugin_name ),
			'add_new_item' 			=> __( 'Ajouter une nouvelle galerie', $this->plugin_name ),
			'edit_item' 			=> __( 'Modifier la galerie', $this->plugin_name ),
			'new_item' 				=> __( 'New Album Gallery', $this->plugin_name ),
			'view_item' 			=> __( 'View Album Gallery', $this->plugin_name ),
			'search_items' 			=> __( 'Search Album Galleries', $this->plugin_name ),
			'not_found' 			=> __( 'Aucune galerie trouvée.', $this->plugin_name ),
			'not_found_in_trash' 	=> __( 'Aucune galerie trouvée dans la corbeille.', $this->plugin_name ),
			'parent_item_colon' 	=> __( 'Parent Album Gallery:', $this->plugin_name ),
			'all_items' 			=> __( 'Toutes les galeries', $this->plugin_name ),
			'menu_name' 			=> _x( 'Galeries', $this->plugin_name ),
		);

		$args = array(
			'labels' 				=> $labels,
			'hierarchical' 			=> false,
			'supports' 				=> array( 'title' ),
			'public' 				=> false,
			'show_ui' 				=> true,
			'show_in_menu' 			=> true,
			'menu_position' 		=> 10,
			'menu_icon' 			=> 'dashicons-format-gallery',
			'show_in_nav_menus' 	=> false,
			'publicly_queryable' 	=> false,
			'exclude_from_search' 	=> true,
			'has_archive' 			=> true,
			'query_var' 			=> true,
			'can_export' 			=> true,
			'rewrite' 				=> false,
			'capability_type' 		=> 'post'
		);

        register_post_type( $this->post_type_name, $args );
	}
	/**
	 * gallery_columns
	 * 
	 * @param  string $columns
	 */
	public function gallery_columns( $columns ) {
        $columns = array(
            'cb' 		=> '<input type="checkbox" />',
            'title' 	=> __( 'Galerie', $this->plugin_name ),
            'shortcode' => __( 'Shortcode de la galerie', $this->plugin_name ),
            'date' 		=> __( 'Date', $this->plugin_name )
        );
        return $columns;
    }
	
	/**
	 * gallery_manage_columns
	 * 
	 * @param  string $column
	 * @param  int    $post
	 */
    public function gallery_manage_columns( $column, $post ) {

    	global $post;

        switch( $column ) {
          	case 'shortcode' :
            	echo '<input type="text" value="[WPF id=' . $post->ID . ']" readonly="readonly" />';
            break;
          		default :
            break;
        }
    }

    /**
	 * custom_post_type_messages
	 *
	 * @param array $messages Existing post update messages.
	 * @see https://www.sitepoint.com/wordpress-custom-post-types-notices-taxonomies/
	 * 
	 * @return array Amended book CPT notices
	 */
	function custom_post_type_messages( $messages ) {

	    $post             = get_post();
	    $post_type        = get_post_type( $post );
	    $post_type_object = get_post_type_object( $post_type );

	    $messages[$this->post_type_name] = array(
	        0  => '', // Unused. Messages start at index 1.
	        1  => __( 'Galerie mise à jour.', $this->plugin_name ),
	        2  => __( 'Custom field updated.', $this->plugin_name ),
	        3  => __( 'Custom field deleted.', $this->plugin_name ),
	        4  => __( 'Galerie mise à jour.', 'textdomain' ),
	        5  => isset( $_GET['revision'] ) ? sprintf( __( 'Book restored to revision from %s', $this->plugin_name ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
	        6  => __( 'Galerie publiée.', $this->plugin_name ),
	        7  => __( 'Galerie sauvegardée.', $this->plugin_name ),
	        8  => __( 'Galerie soumise.', $this->plugin_name ),
	        9  => sprintf(
	            __( 'Galerie programmée pour le <strong>%1$s</strong>.', $this->plugin_name ),
	            date_i18n( __( 'j F Y à G\h i\m\i\n', $this->plugin_name ), strtotime( $post->post_date ) )
	        ),
	        10 => __( 'Le brouillon de la galerie a été mis à jour.', $this->plugin_name )
	    );

	    return $messages;
	}
}