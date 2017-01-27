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

	/**
	 * Register the custom meta box
	 * 
	 * @since 	1.0.0
	 */
	public function setup_meta_box() {
		add_meta_box('book_meta_box', __('Zusätzliche Angaben', 'wpfit'), array($this, 'metabox_markup_book'), 'book', 'normal', 'high', null);
		add_meta_box('ingredient_meta_box', __('Zusätzliche Angaben', 'wpfit'), array($this, 'meta_box_markup_ingredient'), 'ingredient', 'normal', 'high', null);
	}

	private function meta_box_markup($name, $labeltext) {
		?>
		<label for="<?= $name ?>"><?= __($labeltext) ?></label>
		<input name="<?= $name ?>" type="text" value="<?php echo get_post_meta(get_the_ID(), $name, true); ?>">
		<?php
	}

	public function metabox_markup_book() {
		wp_nonce_field(basename(__FILE__), "meta-box-nonce");
    	?>
		<div class="wpfit-meta-box-100">
			<?php $this->meta_box_markup('amazon',		'Amazon'); ?><br>
			<?php $this->meta_box_markup('buecherei',	'Bücherei'); ?><br>
			<?php $this->meta_box_markup('seitenanzahl','Seitenanzahl'); ?><br>
			<?php $this->meta_box_markup('auflage',		'Auflage'); ?><br>
			<?php $this->meta_box_markup('isbn',		'ISBN'); ?>
        </div>
    	<?php
	}

	public function meta_box_markup_ingredient() {
		wp_nonce_field(basename(__FILE__), "meta-box-nonce");
    	?>
		<div class="wpfit-meta-box-100">
			<?php $this->meta_box_markup('kalorien',	'Kalorien'); ?><br>
			<?php $this->meta_box_markup('protein',		'Protein'); ?><br>
			<?php $this->meta_box_markup('kohlenhydrate','Kohlenhydrate'); ?><br>
			<?php $this->meta_box_markup('zucker',		'davon Zucker'); ?><br>
			<?php $this->meta_box_markup('fett',		'Fett'); ?>
        </div>
    	<?php
	}

	function save_custom_meta_box($post_id, $post, $update) {
		if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
			return $post_id;

		if(!current_user_can("edit_post", $post_id))
			return $post_id;

		if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
			return $post_id;

		switch($post->post_type) {
			case "book":
				$this->update_post_meta($post_id, "amazon");
				$this->update_post_meta($post_id, "buecherei");
				$this->update_post_meta($post_id, "seitenanzahl");
				$this->update_post_meta($post_id, "auflage");
				$this->update_post_meta($post_id, "isbn");
				break;

			case "ingredient":
				$this->update_post_meta($post_id, "kalorien");
				$this->update_post_meta($post_id, "protein");
				$this->update_post_meta($post_id, "kohlenhydrate");
				$this->update_post_meta($post_id, "zucker");
				$this->update_post_meta($post_id, "fett");
				break;

			default:
				return $post_id;
		}
	}

	private function update_post_meta($post_id, $name) {
		$value = "";
		if(isset($_POST[$name])) {
			$value = $_POST[$name];
		}   
		update_post_meta($post_id, $name, $value);
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

			'public'			=> true,
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

			'supports'			=> array('title','editor','revisions','thumbnail'),
			// Core feature(s) the post type supports. Serves as an alias for calling add_post_type_support() directly. Core features include 'title', 'editor', 'comments', 'revisions', 'trackbacks',
			// 'author','excerpt', 'page-attributes', 'thumbnail', 'custom-fields', and 'post-formats'. Additionally, the 'revisions' feature dictates whether the post type will store revisions, and
			// the 'comments' feature dictates whether the comments count will show on the edit screen. Defaults is an array containing 'title' and 'editor'.

			'taxonomies'		=> array('Kochbuch'),
			// An array of taxonomy identifiers that will be registered for the post type. Taxonomies can be registered later with register_taxonomy() or register_taxonomy_for_object_type().

			'has_archive'		=> true,
			// Enables post type archives. Will use $post_type as archive slug by default. Default: false
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
			'public'			=> true,
			'show_ui'			=> true,
			'menu_icon'			=> 'dashicons-carrot',
			'supports'			=> array('title','revisions','thumbnail'),
			'has_archive'		=> true,
		);

		register_post_type( 'ingredient', $args );
	}

	private function setup_post_type_book() {
		$args = array(
			'label'				=> __('Bücher', 'wpfit'),
			'public'			=> true,
			'show_ui'			=> true,
			'menu_icon'			=> 'dashicons-book',
			'supports'			=> array('title','revisions','thumbnail'),
			'has_archive'		=> true,
		);

		register_post_type( 'book', $args );

		register_taxonomy(
			'publisher',
			'book',
        	array(
				'label' => __('Verlag')
			)
		);

		register_taxonomy(
			'language',
			'book',
        	array(
				'label' => __('Sprache')
			)
		);
	}

}
