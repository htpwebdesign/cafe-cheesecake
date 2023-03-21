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
		)
	);

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
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function cafe_cheesecake_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'cafe-cheesecake' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'cafe-cheesecake' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'cafe_cheesecake_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function cafe_cheesecake_scripts() {
	wp_enqueue_style( 'cafe-cheesecake-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'cafe-cheesecake-style', 'rtl', 'replace' );

	wp_enqueue_script( 'cafe-cheesecake-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

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
	// Register Menu CPT
	$labels = array(
	   'name'                  => _x( 'Menu', 'post type general name' ),
	   'singular_name'         => _x( 'Menu', 'post type singular name'),
	   'menu_name'             => _x( 'Menu', 'admin menu' ),
	   'name_admin_bar'        => _x( 'Menu', 'add new on admin bar' ),
	   'add_new'               => _x( 'Add New', 'menu' ),
	   'add_new_item'          => __( 'Add New Menu' ),
	   'new_item'              => __( 'New Menu' ),
	   'edit_item'             => __( 'Edit Menu' ),
	   'view_item'             => __( 'View Menu' ),
	   'all_items'             => __( 'All Menus' ),
	   'search_items'          => __( 'Search Menus' ),
	   'parent_item_colon'     => __( 'Parent Menus:' ),
	   'not_found'             => __( 'No menus found.' ),
	   'not_found_in_trash'    => __( 'No menus found in Trash.' ),
	   'archives'              => __( 'Menu Archives'),
	   'insert_into_item'      => __( 'Insert into menu'),
	   'uploaded_to_this_item' => __( 'Uploaded to this menu'),
	   'filter_item_list'      => __( 'Filter menus list'),
	   'items_list_navigation' => __( 'Menus list navigation'),
	   'items_list'            => __( 'Menus list'),
	   'featured_image'        => __( 'Menu featured image'),
	   'set_featured_image'    => __( 'Set menu featured image'),
	   'remove_featured_image' => __( 'Remove menu featured image'),
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
	   'rewrite'            => array( 'slug' => 'menu' ),
	   'capability_type'    => 'post',
	   'has_archive'        => true,
	   'hierarchical'       => false,
	   'menu_position'      => 5,
	   'menu_icon'          => 'dashicons-archive',
	   'supports'           => array( 'title', 'thumbnail' ),
   );

   register_post_type( 'cafe-menu', $args );

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
		'has_archive'        => true,
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
    // Add Menu Type taxonomy
    $labels = array(
        'name'              => _x( 'Menu Type', 'taxonomy general name' ),
        'singular_name'     => _x( 'Menu Type', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Menu Types' ),
        'all_items'         => __( 'All Menu Type' ),
        'parent_item'       => __( 'Parent Menu Type' ),
        'parent_item_colon' => __( 'Parent Menu Type:' ),
        'edit_item'         => __( 'Edit Menu Type' ),
        'view_item'         => __( 'View Menu Type' ),
        'update_item'       => __( 'Update Menu Type' ),
        'add_new_item'      => __( 'Add New Menu Type' ),
        'new_item_name'     => __( 'New Menu Type Name' ),
        'menu_name'         => __( 'Menu Type' ),
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
        'rewrite'           => array( 'slug' => 'menu-type' ),
    );
    register_taxonomy( 'cafe-menu-type', array( 'cafe-menu', 'product' ), $args );

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
		register_taxonomy( 'cafe-product-type', array( 'cafe-menu', 'product' ), $args );


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