<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              
 * @since             1.0.0
 * @package           wpfit
 *
 * @wordpress-plugin
 * Plugin Name:       wpfit
 * Plugin URI:        http://example.com/wpfit-uri/
 * Description:       Get fit with wordpress
 * Version:           1.0.0
 * Author:            NK
 * Author URI:        
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpfit
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpfit-activator.php
 */
function activate_wpfit() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpfit-activator.php';
	wpfit_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpfit-deactivator.php
 */
function deactivate_wpfit() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpfit-deactivator.php';
	wpfit_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpfit' );
register_deactivation_hook( __FILE__, 'deactivate_wpfit' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpfit.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpfit() {

	$plugin = new wpfit();
	$plugin->run();

}
run_wpfit();
