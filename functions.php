<?php
/**
 * Cafe Cheesecake functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Cafe_Cheesecake
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function cafe_cheesecake_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Cafe Cheesecake, use a find and replace
		* to change 'cafe-cheesecake' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'cafe-cheesecake', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'cafe-cheesecake' ),
			'menu-2' => esc_html__( 'Footer', 'cafe-cheesecake'),
			'menu-3' => esc_html__( 'Social', 'cafe-cheesecake')
		)
	);

	// Carousel 
	function enqueue_my_scripts() {
		wp_enqueue_script('owl-carousel', get_stylesheet_directory_uri() . '/js/owl-carousel.js', array('jquery'), '1.0', true);
	}
	add_action('wp_enqueue_scripts', 'enqueue_my_scripts');
	
	// Add Crop Size for the Carousel

	add_image_size( 'banner-crop', 1920, 1080, true );

	
	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'cafe_cheesecake_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Remove sidebar from shop page

	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

}
add_action( 'after_setup_theme', 'cafe_cheesecake_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function cafe_cheesecake_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'cafe_cheesecake_content_width', 640 );
}
add_action( 'after_setup_theme', 'cafe_cheesecake_content_width', 0 );



/**
 * Enqueue scripts and styles.
 */
function cafe_cheesecake_scripts() {
	wp_enqueue_style( 'cafe-cheesecake-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'cafe-cheesecake-style', 'rtl', 'replace' );

	wp_enqueue_script( 'cafe-cheesecake-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	wp_enqueue_script( 'cafe-cheesecake-script', get_template_directory_uri() . '/js/script.js', array(), _S_VERSION, true );

	// if(is_post_type_archive('location')){
		wp_enqueue_script('google_map', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDCtkSmxg7p70EAdYwXMlLHDbnK4ZLuskI');
		wp_enqueue_script('cafe-cheesecake-google_map', get_template_directory_uri() . '/js/google_map.js', array(), _S_VERSION, true );
	// }
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cafe_cheesecake_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


require get_template_directory() . '/inc/class-fwd-add-sub-menu-button-walker.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
* Custom Post Types & Taxonomies
*/


function cafe_cheesecake_register_custom_post_types() {
	// Register Jobs CPT
	$labels = array(
		'name'                  => _x( 'Jobs', 'post type general name' ),
		'singular_name'         => _x( 'Job', 'post type singular name'),
		'menu_name'             => _x( 'Jobs', 'admin menu' ),
		'name_admin_bar'        => _x( 'Job', 'add new on admin bar' ),
		'add_new'               => _x( 'Add New', 'job' ),
		'add_new_item'          => __( 'Add New Job' ),
		'new_item'              => __( 'New Job' ),
		'edit_item'             => __( 'Edit Job' ),
		'view_item'             => __( 'View Job' ),
		'all_items'             => __( 'All Jobs' ),
		'search_items'          => __( 'Search Jobs' ),
		'parent_item_colon'     => __( 'Parent Jobs:' ),
		'not_found'             => __( 'No jobs found.' ),
		'not_found_in_trash'    => __( 'No jobs found in Trash.' ),
		'archives'              => __( 'Job Archives'),
		'insert_into_item'      => __( 'Insert into job'),
		'uploaded_to_this_item' => __( 'Uploaded to this job'),
		'filter_item_list'      => __( 'Filter jobs list'),
		'items_list_navigation' => __( 'Jobs list navigation'),
		'items_list'            => __( 'Jobs list'),
		'featured_image'        => __( 'Job featured image'),
		'set_featured_image'    => __( 'Set job featured image'),
		'remove_featured_image' => __( 'Remove job featured image'),
		'use_featured_image'    => __( 'Use as featured image'),
	);
 
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_in_admin_bar'  => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'jobs' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-archive',
		'supports'           => array( 'title', 'editor' ),
	);
 
	register_post_type( 'cafe-jobs', $args );
 

	// Register Catering CPT
	$labels = array(
		'name'                  => _x( 'Catering', 'post type general name' ),
		'singular_name'         => _x( 'Catering', 'post type singular name'),
		'menu_name'             => _x( 'Catering', 'admin menu' ),
		'name_admin_bar'        => _x( 'Catering', 'add new on admin bar' ),
		'add_new'               => _x( 'Add New', 'catering' ),
		'add_new_item'          => __( 'Add New Catering' ),
		'new_item'              => __( 'New Catering' ),
		'edit_item'             => __( 'Edit Catering' ),
		'view_item'             => __( 'View Catering' ),
		'all_items'             => __( 'All Catering' ),
		'search_items'          => __( 'Search Catering' ),
		'parent_item_colon'     => __( 'Parent Catering:' ),
		'not_found'             => __( 'No catering found.' ),
		'not_found_in_trash'    => __( 'No catering found in Trash.' ),
		'archives'              => __( 'Catering Archives'),
		'insert_into_item'      => __( 'Insert into catering'),
		'uploaded_to_this_item' => __( 'Uploaded to this catering'),
		'filter_item_list'      => __( 'Filter catering list'),
		'items_list_navigation' => __( 'Catering list navigation'),
		'items_list'            => __( 'Catering list'),
		'featured_image'        => __( 'Catering featured image'),
		'set_featured_image'    => __( 'Set catering featured image'),
		'remove_featured_image' => __( 'Remove catering featured image'),
		'use_featured_image'    => __( 'Use as featured image'),
	);
 
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_in_admin_bar'  => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'catering' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-archive',
		'supports'           => array( 'title', 'editor' ),
	);
 
	register_post_type( 'cafe-catering', $args );

	// Register Location CPT
	$labels = array(
		'name'                  => _x( 'Location', 'post type general name' ),
		'singular_name'         => _x( 'Location', 'post type singular name'),
		'menu_name'             => _x( 'Location', 'admin menu' ),
		'name_admin_bar'        => _x( 'Location', 'add new on admin bar' ),
		'add_new'               => _x( 'Add New', 'location' ),
		'add_new_item'          => __( 'Add New Location' ),
		'new_item'              => __( 'New Location' ),
		'edit_item'             => __( 'Edit Location' ),
		'view_item'             => __( 'View Location' ),
		'all_items'             => __( 'All Locations' ),
		'search_items'          => __( 'Search Location' ),
		'parent_item_colon'     => __( 'Parent Location:' ),
		'not_found'             => __( 'No location found.' ),
		'not_found_in_trash'    => __( 'No locations found in Trash.' ),
		'archives'              => __( 'Location Archives'),
		'insert_into_item'      => __( 'Insert into location'),
		'uploaded_to_this_item' => __( 'Uploaded to this location'),
		'filter_item_list'      => __( 'Filter location list'),
		'items_list_navigation' => __( 'Location list navigation'),
		'items_list'            => __( 'Location list'),
		'featured_image'        => __( 'Location featured image'),
		'set_featured_image'    => __( 'Set location featured image'),
		'remove_featured_image' => __( 'Remove location featured image'),
		'use_featured_image'    => __( 'Use as featured image'),
	);
 
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_in_admin_bar'  => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'location' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-archive',
		'supports'           => array( 'title', 'editor' ),
	);
 
	register_post_type( 'cafe-location', $args );

};

add_action( 'init', 'cafe_cheesecake_register_custom_post_types' );


function cafe_cheesecake_register_taxonomies() {
	// Add product-type taxonomy
	$labels = array(
		'name'              => _x( 'Product Type', 'taxonomy general name' ),
		'singular_name'     => _x( 'Product Type', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Product Types' ),
		'all_items'         => __( 'All Product Type' ),
		'parent_item'       => __( 'Parent Product Type' ),
		'parent_item_colon' => __( 'Parent Product Type:' ),
		'edit_item'         => __( 'Edit Product Type' ),
		'view_item'         => __( 'View Product Type' ),
		'update_item'       => __( 'Update Product Type' ),
		'add_new_item'      => __( 'Add New Product Type' ),
		'new_item_name'     => __( 'New Product Type Name' ),
		'menu_name'         => __( 'Product Type' ),
	);
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_in_menu'      => true,
		'show_in_nav_menu'  => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'product-type' ),
	);
	register_taxonomy( 'cafe-product-type', array(  'product' ), $args );		


    // Add Location Type taxonomy
    $labels = array(
        'name'                       => _x( 'Location Type', 'taxonomy general name' ),
        'singular_name'              => _x( 'Location Type', 'taxonomy singular name' ),
        'search_items'               => __( 'Location Type' ),
        'all_items'                  => __( 'All Location Type' ),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __( 'Edit Location Type' ),
        'update_item'                => __( 'Update Location Type' ),
        'add_new_item'               => __( 'Add New Location Type' ),
        'new_item_name'              => __( 'New Location Type Name' ),
        'separate_items_with_commas' => __( 'Separate student type with commas' ),
        'add_or_remove_items'        => __( 'Add or remove Location Types' ),
        'choose_from_most_used'      => __( 'Choose from the most used student types' ),
        'not_found'                  => __( 'No student types found.' ),
        'menu_name'                  => __( 'Location Type' ),
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_nav_menu'      => true,
        'show_in_rest'          => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'location-type' ),
    );

    register_taxonomy( 'cafe-location-type', array( 'cafe-jobs', 'cafe-location' ), $args );
}
add_action( 'init', 'cafe_cheesecake_register_taxonomies');


// This flushes the permalinks if the theme is changed
function cafe_cheesecake_rewrite_flush() {
    cafe_cheesecake_register_custom_post_types();
	cafe_cheesecake_register_taxonomies();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'cafe_cheesecake_rewrite_flush' );


function cafeMapKey($api) {
	$api['key'] = 'AIzaSyDCtkSmxg7p70EAdYwXMlLHDbnK4ZLuskI';
	return $api;
}

add_filter( 'acf/fields/google_map/api', 'cafeMapKey');

// Adds taxonomy terms when user adds new location 

function cafe_send_new_post($new_status, $old_status, $post) {
	if('publish' === $new_status && 'publish' !== $old_status && $post->post_type === 'cafe-location') {
		$term = term_exists( $post->post_title, 'cafe-location-type' ); // Checks if the term is already in the taxonomy
		if ( $term == 0 || $term == null ){ // If the term isnt in the taxonomy 
			wp_insert_term(
					$post->post_title,   // the term 
					'cafe-location-type' // the taxonomy
				);
		}
	}
  }

add_action('transition_post_status', 'cafe_send_new_post', 10, 3);

// Create custom dashboard widget for Client Tutorial 
add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
function my_custom_dashboard_widgets() {
	global $wp_meta_boxes;
	// wp_add_dashboard_widget($widget_id, $widget_anme, $callback, $control_callbacks, $callback_args);
	wp_add_dashboard_widget('custom_links_widget', 'Tutorial', 'custom_dashboard_links');
}
function custom_dashboard_links() {
	echo '<a href="https://cafecheesecake.bcitwebdeveloper.ca/wp-content/uploads/2023/04/BAM-CAFE.pdf">Link to Client Tutorial</a>';
}

