<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.19h47.fr/
 * @since      1.0.0
 *
 * @package    WPF
 * @subpackage wpf/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @package    WPF
 * @subpackage wpf/includes
 * @author     Jérémy Levron levronjeremy@19h47.fr
 */
 class WPF {

 	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		Now_Hiring_Loader 		$loader 		Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		string 			$plugin_name 		The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'wpf';
		$this->version = '1.0.0';
        $this->post_type_name = 'gallery';

		$this->load_dependencies();
        $this->define_admin_hooks();

        $this->define_widgets_hooks();
        $this->define_meta_boxes_hooks();
        $this->define_shortcode_hooks();

        $this->define_custom_post_type_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WP_Flickr_Loader. Orchestrates the hooks of the plugin.
	 * - WP_Flickr_Admin. Defines all hooks for the dashboard.
	 * - WP_Flickr_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpf-loader.php';

		/**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpf-admin.php';

        /**
         * The class responsible for defining all actions relating to metaboxes.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpf-admin-metabox.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpf-widget.php';

        /**
         * The class responsible for defining all shortcodes of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wpf-public-shortcode.php';

        /**
         * The class responsible for defining all custom post type.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpf-admin-custom-post-type.php';

		$this->loader = new WPF_Loader();
	}

	/**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {
    	$plugin_admin = new WPF_Admin( 
            $this->get_plugin_name(), 
            $this->get_version()
        );
    }

    /**
     * 
     */
    private function define_custom_post_type_hooks() {
    	$plugin_custom_post_type = new WPF_Admin_Custom_Post_Type(
    		$this->get_plugin_name(), 
            $this->get_version(),
            $this->get_post_type_name()
    	);

    	$this->loader->add_action( 'init', $plugin_custom_post_type, 'register_post_type' );
    	// $this->loader->add_action( 'manage_edit-gallery', $plugin_custom_post_type, 'manage_edit-gallery' );

    	$this->loader->add_filter( 'manage_gallery_posts_columns', $plugin_custom_post_type, 'gallery_columns' );
        $this->loader->add_action( 'manage_gallery_posts_custom_column', $plugin_custom_post_type, 'gallery_manage_columns', 10, 2);
        $this->loader->add_filter( 'post_updated_messages', $plugin_custom_post_type, 'custom_post_type_messages' );
    }

    /**
     * Register all of the hooks related to the metaboxes functionalities
     */
    private function define_meta_boxes_hooks() {

        $plugin_metaboxes = new WPF_Admin_Metabox(
            $this->get_plugin_name(), 
            $this->get_version(),
            $this->get_post_type_name()
        );

        $this->loader->add_action( 'add_meta_boxes', $plugin_metaboxes, 'add_meta_boxes' );
        $this->loader->add_action( 'admin_init', $plugin_metaboxes, 'add_meta_boxes' );
        $this->loader->add_action( 'save_post', $plugin_metaboxes, 'save_post' );
    }

    /**
     * Register all of the hooks related to widgets functionality
     *
     * @since       1.0.0
     * @access      private
     */
    private function define_widgets_hooks() {

        $this->loader->add_action( 'widgets_init', $this, 'widgets_init' );
        $this->loader->add_action( 'save_post_job', $this, 'flush_widget_cache' );
        $this->loader->add_action( 'deleted_post', $this, 'flush_widget_cache' );
        $this->loader->add_action( 'switch_theme', $this, 'flush_widget_cache' );
    }

    /**
     * Register all of the hooks related to shortcodes functionality
     *
     * @since       1.0.0
     * @access      private
     */
    private function define_shortcode_hooks() {

        $plugin_shortcodes = new WPF_Shortcode(
            $this->get_plugin_name(), 
            $this->get_version(),
            $this->get_post_type_name()
        );

        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_shortcodes, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_shortcodes, 'enqueue_scripts' );

        /**
         * Add hook for shortcode tag.
         * 
         * @param  string   $tag    Shortcode tag to be searched in post content.
         * @param  callable $func   Hook to run when shortcode is found.
         */
        $this->loader->add_shortcode( 'WPF', $plugin_shortcodes, 'add_shortCode' );
    }

    /**
     * Registers widgets with WordPress
     *
     * @since       1.0.0
     * @access      public
     */
    public function widgets_init() {

        register_widget( 'wpf_widget' );
    } 

    /**
     * Flushes widget cache
     *
     * @since       1.0.0
     * @access      public
     * @param       int         $post_id        The post ID
     * @return      void
     */
    public function flush_widget_cache( $post_id ) {

        if ( wp_is_post_revision( $post_id ) ) { 
            return; 
        }
        $post = get_post( $post_id );
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {

        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {

        return $this->plugin_name;
    }

    /**
     * Retrieve the default post types
     */
    public function get_default_post_types() {

        return $this->default_post_types;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin
     */
    public function get_loader() {

        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {

        return $this->version;
    }

    /**
     * Retrieve the post name
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_post_type_name() {

        return $this->post_type_name;
    }
}