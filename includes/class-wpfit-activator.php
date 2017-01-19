<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    wpfit
 * @subpackage wpfit/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    wpfit
 * @subpackage wpfit/includes
 * @author     Your Name <email@example.com>
 */
class wpfit_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// trigger our function that registers the custom post type
    	// pluginprefix_setup_post_types(); // TODO: notwendig? In dieser Struktur sehe ich keine Möglichkeit dafür!

		// clear the permalinks after the post type has been registered
		flush_rewrite_rules();
	}

}
