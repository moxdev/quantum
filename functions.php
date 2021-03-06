<?php
/**
 * Quantum Property Management functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Quantum_Property_Management
 */

if ( ! function_exists( 'quantum_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function quantum_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Quantum Property Management, use a find and replace
		 * to change 'quantum' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'quantum', get_template_directory() . '/languages' );

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
		add_image_size( 'home-carousel-sm', 750, 340, true );
		add_image_size( 'home-carousel-md', 1000, 455, true );
		add_image_size( 'home-carousel-lg', 1500, 680, true );
		add_image_size( 'home-carousel-xl', 2200, 1000, true );

		add_image_size( 'highlight-bk-img-sm', 750, 340, true );
		add_image_size( 'highlight-bk-img-md', 1000, 455, true );
		add_image_size( 'highlight-bk-img-lg', 1500, 680, true );
		add_image_size( 'highlight-bk-img-xl', 2200, 1000, true );

		add_image_size( 'highlight-icon', 70, 70, true );
		add_image_size( 'highlight-bk-img', 2200, 1000, true );

		add_image_size( 'statistics-icon', 200, 9999, false );
		add_image_size( 'about-icon', 200, 9999, false );

		add_image_size( 'property-logo-img', 300, 9999, false );
		add_image_size( 'property-content-img', 230, 140, true );
		add_image_size( 'property-floorplan-img', 400, 9999, false );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'main' => esc_html__( 'Main Menu', 'quantum' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'quantum_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'quantum_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function quantum_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'quantum_content_width', 640 );
}
add_action( 'after_setup_theme', 'quantum_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function quantum_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'quantum' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'quantum' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'quantum_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function quantum_scripts() {
	wp_enqueue_style( 'quantum-style', get_stylesheet_uri() );

	wp_enqueue_script( 'quantum-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'quantum-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_front_page() ) {
		wp_enqueue_script( 'flickity', get_template_directory_uri() . '/js/vendor/flickity.pkgd.min.js', array(), '20151215', true );
		wp_enqueue_script( 'quantum-flickity', get_template_directory_uri() . '/js/min/testimonial-carousel.min.js', array( 'flickity' ), '20151215', true );
	}
}
add_action( 'wp_enqueue_scripts', 'quantum_scripts' );

/**
 * Global Site Information
 */
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		array(
			'page_title' => 'Global Website Information',
			'menu_title' => 'Site Global Info',
			'menu_slug'  => 'global-information',
			'post_id'    => 'global-information',
			'capability' => 'edit_posts',
		)
	);
	acf_add_options_sub_page(
		array(
			'page_title'  => 'Contact Information',
			'menu_title'  => 'Contact Info',
			'menu_slug'   => 'contact-information',
			'post_id'     => 'contact-information',
			'parent_slug' => 'global-information',
		)
	);
	acf_add_options_sub_page(
		array(
			'page_title'  => 'Social Media Channels',
			'menu_title'  => 'Social Media',
			'menu_slug'   => 'social-media-channels',
			'post_id'     => 'social-media-channels',
			'parent_slug' => 'global-information',
		)
	);
}

// Register Custom Post Type for Testimonial
function quantum_create_testimonial_custom_post_type() {

  $labels = array(
    'name'                  => 'Testimonials',
    'singular_name'         => 'Testimonial',
    'menu_name'             => 'Testimonials',
    'name_admin_bar'        => 'Testimonials',
    'archives'              => 'Testimonials Archives',
    'attributes'            => 'Testimonials Attributes',
    'parent_item_colon'     => 'Parent Item: Testimonials',
    'all_items'             => 'All Testimonials',
    'add_new_item'          => 'Add New Testimonial',
    'add_new'               => 'Add New Testimonial',
    'new_item'              => 'New Testimonial',
    'edit_item'             => 'Edit Testimonial',
    'update_item'           => 'Update Testimonial',
    'view_item'             => 'View Testimonial',
    'view_items'            => 'View Testimonials',
    'search_items'          => 'Search Testimonials',
    'not_found'             => 'Not found',
    'not_found_in_trash'    => 'Not found in Trash',
    'featured_image'        => 'Featured Image',
    'set_featured_image'    => 'Set featured image',
    'remove_featured_image' => 'Remove featured image',
    'use_featured_image'    => 'Use as featured image',
    'insert_into_item'      => 'Insert into item',
    'uploaded_to_this_item' => 'Uploaded to this item',
    'items_list'            => 'Items list',
    'items_list_navigation' => 'Items list navigation',
    'filter_items_list'     => 'Filter items list',
  );
  $rewrite = array(
    'slug'                  => 'testimonial',
    'with_front'            => true,
    'pages'                 => true,
    'feeds'                 => true,
  );
  $args = array(
    'label'                 => 'Testimonial',
    'description'           => 'Testimonial Section',
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'revisions' ),
    'taxonomies'            => array( 'testimonial' ),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'menu_icon'             => 'dashicons-testimonial',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => false,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'query_var'             => 'testimonial',
    'rewrite'               => $rewrite,
    'capability_type'       => 'page',
    'show_in_rest'          => true,
  );
  register_post_type( 'testimonials', $args );

}
add_action( 'init', 'quantum_create_testimonial_custom_post_type', 0 );

// Register Custom Post Type
function quantum_create_property_custom_post_types() {

	$labels = array(
		'name'                  => _x( 'Properties', 'Post Type General Name', 'quantum' ),
		'singular_name'         => _x( 'Property', 'Post Type Singular Name', 'quantum' ),
		'menu_name'             => __( 'Properties', 'quantum' ),
		'name_admin_bar'        => __( 'Property', 'quantum' ),
		'archives'              => __( 'Property Archives', 'quantum' ),
		'attributes'            => __( 'Property Attributes', 'quantum' ),
		'parent_item_colon'     => __( 'Parent Item:', 'quantum' ),
		'all_items'             => __( 'All Properties', 'quantum' ),
		'add_new_item'          => __( 'Add New Property', 'quantum' ),
		'add_new'               => __( 'Add New Property', 'quantum' ),
		'new_item'              => __( 'New Property', 'quantum' ),
		'edit_item'             => __( 'Edit Property', 'quantum' ),
		'update_item'           => __( 'Update Property', 'quantum' ),
		'view_item'             => __( 'View Property', 'quantum' ),
		'view_items'            => __( 'View Property', 'quantum' ),
		'search_items'          => __( 'Search Property', 'quantum' ),
		'not_found'             => __( 'Not found', 'quantum' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'quantum' ),
		'featured_image'        => __( 'Featured Image', 'quantum' ),
		'set_featured_image'    => __( 'Set featured image', 'quantum' ),
		'remove_featured_image' => __( 'Remove featured image', 'quantum' ),
		'use_featured_image'    => __( 'Use as featured image', 'quantum' ),
		'insert_into_item'      => __( 'Insert into item', 'quantum' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'quantum' ),
		'items_list'            => __( 'Items list', 'quantum' ),
		'items_list_navigation' => __( 'Items list navigation', 'quantum' ),
		'filter_items_list'     => __( 'Filter items list', 'quantum' ),
	);
	$args = array(
		'label'                 => __( 'Property', 'quantum' ),
		'description'           => __( 'Custom post type for all Quantum properties.', 'quantum' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
		'taxonomies'            => array( 'property_locations' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-building',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'properties',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'properties', $args );

}
add_action( 'init', 'quantum_create_property_custom_post_types', 0 );

// Register Custom Taxonomy
function quantum_property_custom_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Property Locations', 'Taxonomy General Name', 'quantum' ),
		'singular_name'              => _x( 'Property Location', 'Taxonomy Singular Name', 'quantum' ),
		'menu_name'                  => __( 'Property Locations', 'quantum' ),
		'all_items'                  => __( 'All Properties', 'quantum' ),
		'parent_item'                => __( 'Parent Item', 'quantum' ),
		'parent_item_colon'          => __( 'Parent Item:', 'quantum' ),
		'new_item_name'              => __( 'New Property Location', 'quantum' ),
		'add_new_item'               => __( 'Add New Property Location', 'quantum' ),
		'edit_item'                  => __( 'Edit Property Location', 'quantum' ),
		'update_item'                => __( 'Update Property Location', 'quantum' ),
		'view_item'                  => __( 'View Property Location', 'quantum' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'quantum' ),
		'add_or_remove_items'        => __( 'Add or remove property locations', 'quantum' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'quantum' ),
		'popular_items'              => __( 'Popular Property Locations', 'quantum' ),
		'search_items'               => __( 'Search Property Locations', 'quantum' ),
		'not_found'                  => __( 'Not Found', 'quantum' ),
		'no_terms'                   => __( 'No items', 'quantum' ),
		'items_list'                 => __( 'Items list', 'quantum' ),
		'items_list_navigation'      => __( 'Items list navigation', 'quantum' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'property_locations', array( 'properties' ), $args );

}
add_action( 'init', 'quantum_property_custom_taxonomy', 0 );

// For Properties Page custom post type
// https://wpsites.net/web-design/customize-archive-pages-conditionally-using-pre-get-posts/

add_action( 'pre_get_posts', 'custom_post_type_archive' );

function custom_post_type_archive( $query ) {

if( $query->is_main_query() && !is_admin() && is_post_type_archive( 'properties' ) ) {

		$query->set( 'posts_per_page', '6' );
		$query->set( 'orderby', 'title' );
    $query->set( 'order', 'DESC' );
	}

}


// Main nav submenu toggling.
add_filter( 'walker_nav_menu_start_el', 'quantum_add_arrow', 10, 4 );
/**
 * Add arrow icons into registered menu "main"
 *
 * @param string $item_output String to be output after menu items.
 * @param object $item Menu item.
 * @param int    $depth Depth of each menu item.
 * @param object $args Menu.
 */
function quantum_add_arrow( $item_output, $item, $depth, $args ) {
	if ( 'main' === $args->theme_location && in_array( 'menu-item-has-children', $item->classes, true ) ) {
		$item_output .= '<button class="arrow"><span class="screen-reader-text">Toggle Item</span></button>';
	}
	return $item_output;
}

/**
 * Object Fit
 */
function quantum_object_fit_js() { ?>
	<script>objectFitImages();</script>
	<?php
}

add_filter( 'wpseo_metabox_prio', 'yoast_to_bottom' );
/**
 * Move Yoast to bottom
 */
function yoast_to_bottom() {
	return 'low';
}


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
 * Frontpage Carousel.
 */
require get_template_directory() . '/inc/front-page-carousel.php';

/**
 * Frontpage Statistics Section.
 */
require get_template_directory() . '/inc/front-page-statistics.php';

/**
 * Frontpage Flexible Content.
 */
require get_template_directory() . '/inc/front-page-flexible-content.php';

/**
 * About Page Content Links.
 */
require get_template_directory() . '/inc/about-page-content-links.php';

/**
 * Single Property Page Template Tags.
 */
require get_template_directory() . '/inc/single-property-template-tags.php';

/**
 * Footer Contact Info/Social Content.
 */
require get_template_directory() . '/inc/footer-contact-social.php';
