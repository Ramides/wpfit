<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    wpfit
 * @subpackage wpfit/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    wpfit
 * @subpackage wpfit/admin
 * @author     Your Name <email@example.com>
 */
class wpfit_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wpfit    The ID of this plugin.
	 */
	private $wpfit;

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
	 * @param      string    $wpfit       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $wpfit, $version ) {

		$this->wpfit = $wpfit;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in wpfit_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The wpfit_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->wpfit, plugin_dir_url( __FILE__ ) . 'css/wpfit-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in wpfit_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The wpfit_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->wpfit, plugin_dir_url( __FILE__ ) . 'js/wpfit-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the custom post type recipe
	 *
	 * @since 	1.0.0
	 */
	public function setup_post_type() {
		$labels = array(
			'name'               => _x( 'Recipes', 'post type general name', 'wpfit' ),
			'singular_name'      => _x( 'Recipe', 'post type singular name', 'wpfit' ),
			'menu_name'          => _x( 'Recipes', 'admin menu', 'wpfit' ),
			'name_admin_bar'     => _x( 'Recipe', 'add new on admin bar', 'wpfit' ),
			'add_new'            => _x( 'Add New', 'recipe', 'wpfit' ),
			'add_new_item'       => __( 'Add New Recipe', 'wpfit' ),
			'new_item'           => __( 'New Recipe', 'wpfit' ),
			'edit_item'          => __( 'Edit Recipe', 'wpfit' ),
			'view_item'          => __( 'View Recipe', 'wpfit' ),
			'all_items'          => __( 'All Recipe', 'wpfit' ),
			'search_items'       => __( 'Search Recipes', 'wpfit' ),
			'parent_item_colon'  => __( 'Parent Recipes:', 'wpfit' ),
			'not_found'          => __( 'No recipes found.', 'wpfit' ),
			'not_found_in_trash' => __( 'No recipes found in Trash.', 'wpfit' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Get fit with wordpress.', 'wpfit' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'wpfit' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);

		register_post_type( 'recipe', $args );

	}

}
