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
		$this->setup_post_type_receipe();
		$this->setup_post_type_ingredient();
		$this->setup_post_type_book();
	}

	private function setup_post_type_receipe() {
		$args = array(
			'label'				=> __('Rezepte', 'wpfit'),
			// Name of the post type shown in the menu. Usually plural. Default is value of $labels['name'].

			// 'labels'			=> $labels,
			// An array of labels for this post type. If not set, post labels are inherited for non-hierarchical types and page labels for hierarchical ones. See
			// get_post_type_labels() for a full list of supported labels.

			'description'		=> __('Kochrezepte', 'wpfit'),
			// A short descriptive summary of what the post type is.

			'public'			=> false,
			// Whether a post type is intended for use publicly either via the admin interface or by front-end
			// users. While the default settings of $exclude_from_search, $publicly_queryable, $show_ui, and
			// $show_in_nav_menus are inherited from public, each does not rely on this relationship and controls
			// a very specific intention. Default false.

			'show_ui'			=> true,
			// Whether to generate and allow a UI for managing this post type in the admin. Default is value of $public.

			// 'show_in_rest'		=> true,
			// Whether to add the post type route in the REST API 'wp/v2' namespace.

			'menu_icon'			=> 'dashicons-carrot',
			// (string) The url to the icon to be used for this menu. Pass a base64-encoded SVG using a data URI, which will be colored to match the color scheme --
			// this should begin with 'data:image/svg+xml;base64,'. Pass the name of a Dashicons helper class to use a font icon, e.g. 'dashicons-chart-pie'. Pass 'none'
			// to leave div.wp-menu-image empty so an icon can be added via CSS. Defaults to use the posts icon.

			'supports'			=> array('title','editor','revisions','thumbnail','custom-fields'),
			// Core feature(s) the post type supports. Serves as an alias for calling add_post_type_support() directly. Core features include 'title', 'editor', 'comments', 'revisions', 'trackbacks',
			// 'author','excerpt', 'page-attributes', 'thumbnail', 'custom-fields', and 'post-formats'. Additionally, the 'revisions' feature dictates whether the post type will store revisions, and
			// the 'comments' feature dictates whether the comments count will show on the edit screen. Defaults is an array containing 'title' and 'editor'.

			'taxonomies'		=> array('Kochbuch'),
			// An array of taxonomy identifiers that will be registered for the post type. Taxonomies can be registered later with register_taxonomy() or register_taxonomy_for_object_type().
		);

		register_post_type( 'recipe', $args );

		register_taxonomy(
			'source',
			'recipe',
        	array(
				'label' => __('Quelle'),
				'hierarchical'	=> true
			)
		);

		register_taxonomy(
			'categories',
			'recipe',
        	array(
				'label' => __('Kategorien'),
				'hierarchical'	=> true
			)
		);


	}

	private function setup_post_type_ingredient() {
		$args = array(
			'label'				=> __('Zutaten', 'wpfit'),
			'public'			=> false,
			'show_ui'			=> true,
			'menu_icon'			=> 'dashicons-carrot',
			'supports'			=> array('title','editor','revisions','thumbnail','custom-fields'),
		);

		register_post_type( 'ingredient', $args );
	}

	private function setup_post_type_book() {
		$args = array(
			'label'				=> __('Bücher', 'wpfit'),
			'public'			=> false,
			'show_ui'			=> true,
			'menu_icon'			=> 'dashicons-book',
			'supports'			=> array('title','editor','revisions','thumbnail','custom-fields'),
		);

		register_post_type( 'book', $args );
	}

}
