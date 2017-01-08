<?php
/**
 * The widget functionality of the plugin.
 *
 * @link 		http://www.19h47.fr
 * @since 		1.0.0
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

class WPF_Widget extends WP_Widget {
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
	function __construct() {
		
		$this->plugin_name = 'wpf';
		$this->version = '1.0.0';
        $this->post_type_name = 'gallery';

		$name = esc_html__( 'Galerie', $this->plugin_name );
		$opts['classname'] = '';
		$opts['description'] = esc_html__( 'Afficher une galerie', $this->plugin_name );
		$control = array( 
			'width' 	=> '', 
			'height' 	=> '' 
		);
		parent::__construct( false, $name, $opts, $control );
	}

	/**
	 * Back-end widget form.
	 *
	 * @see		WP_Widget::form()
	 *
	 * @uses	wp_parse_args
	 * @uses	esc_attr
	 * @uses	get_field_id
	 * @uses	get_field_name
	 * @uses	checked
	 *
	 * @param	array	$instance	Previously saved values from database.
	 */
	function form( $instance ) {

	 	$wpf_title = __( 'Galerie', $this->plugin_name );
	 	$wpf_shortcode = __( 'Sélectionner une galerie', $this->plugin_name );

	 	if ( isset( $instance['title'] ) ) {
	 		
	 		$wpf_title = $instance['title'];
	 	} 

	 	if ( isset( $instance['shortcode'] ) ) {
	 		
	 		$wpf_shortcode = $instance['shortcode'];
	 	} 

	 	// Include title partial
	 	include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-widget-title.php' );

		global $wpf_posts;

		$args = array(
			'post_type' 		=> $this->post_type_name, 
			'orderby' 			=> 'ASC', 
			'posts_per_page' 	=> -1,
			'post_status' 		=> 'publish'
		);

		$wpf_posts = new WP_Query( $args );

		// If $wpf_posts have no post
		if( ! $wpf_posts->have_posts() ) {
			
			$html  = '<p>';
			$html .= esc_html__( 'Désolé ! Aucune galerie n\'a été trouvée.', $this->plugin_name );
			$html .= '</p>';
			
			echo $html;

			// And return
			return;
		} 
		
		// Include form partial
		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-widget-form.php' );
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see		WP_Widget::widget()
	 *
	 * @uses	apply_filters
	 * @uses	get_widget_layout
	 *
	 * @param	array	$args		Widget arguments.
	 * @param 	array	$instance	Saved values from database.
	 */
	function widget( $args, $instance ) {
	  	
	  	$title = apply_filters( 'wpf_widget_title', $instance['title'] );
	  	$wpf_shortcode = apply_filters( 'wpf_widget_shortcode', $instance['shortcode'] );
	  	echo $args['before_widget'];

	  	// Title
  		if ( ! empty( $instance['title'] ) ) {

  			$html  = $args['before_title'];
  			$html .= apply_filters( 'widget_title', $instance['title'] );
  			$html .= $args['after_title'];

  			echo $html;
  		}

  		// If no gallery is select
	  	if( ! is_numeric( $wpf_shortcode ) ) {

	  		$html  = '<p>';
	  		$html .= __( 'Désolé ! Aucune galerie n\'a été trouvée.', $this->plugin_name );
	  		$html .= '</p>';

	  		echo $html;

	  		return;
	  	}

  		echo do_shortcode( '[WPF id=' . $wpf_shortcode . ']' );
	  	
	  	echo $args['after_widget'];

	  	wp_reset_query();
  	}

  	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see		WP_Widget::update()
	 *
	 * @param	array	$new_instance	Values just sent to be saved.
	 * @param	array	$old_instance	Previously saved values from database.
	 *
	 * @return 	array	$instance		Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['shortcode'] = sanitize_text_field( $new_instance['shortcode'] );
		return $instance;
	}
} 