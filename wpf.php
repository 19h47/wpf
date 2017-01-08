<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.19h47.fr
 * @since             1.0.0
 * @package           Wpf
 *
 * @wordpress-plugin
 * Plugin Name:       WPF
 * Plugin URI:        http://www.19h47.fr/
 * Description:       Display your Flickr photo albums on WordPress.
 * Version:           1.0.0
 * Author:            Jérémy Levron
 * Author URI:        http://www.19h47.fr/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpf
 * Domain Path:       /languages
 */


// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;
 

// check if class already exists
if( ! class_exists( 'WPF' ) ) :


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpf.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 		1.0.0
 */
function run_WPF() {
	$plugin = new WPF();
	$plugin->run();
}
run_WPF();

// class_exists check
endif;

?>