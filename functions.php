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

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'quantum' ),
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
		wp_enqueue_script( 'flickity', get_template_directory_uri() . '/js/min/flickity.min.js', array(), '20151215', true );
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

$labels = array(
	"name" => __( 'Testimonials', 'themeSlug' ),
	"singular_name" => __( 'Testimonial', 'themeSlug' ),
	"menu_name" => __( 'Testimonials', 'themeSlug' ),
	"all_items" => __( 'All Testimonials', 'themeSlug' ),
	"add_new" => __( 'Add New', 'themeSlug' ),
	"add_new_item" => __( 'Add New Testimonial', 'themeSlug' ),
	"edit_item" => __( 'Edit Testimonial', 'themeSlug' ),
	"new_item" => __( 'New Item', 'themeSlug' ),
	"view_item" => __( 'View Testimonial', 'themeSlug' ),
	"search_items" => __( 'Search Testimonials', 'themeSlug' ),
	"not_found" => __( 'No Testimonials Found', 'themeSlug' ),
	"not_found_in_trash" => __( 'No Testimonials in trash', 'themeSlug' ),
	"parent_item_colon" => __( 'Parent Testimonial', 'themeSlug' ),
	"archives" => __( 'Testimonial Archives', 'themeSlug' ),
	"insert_into_item" => __( 'Insert into Testimonial', 'themeSlug' ),
	"uploaded_to_this_item" => __( 'Uploaded to this Testimonial', 'themeSlug' ),
	"filter_items_list" => __( 'Filter Testimonial List', 'themeSlug' ),
	"items_list_navigation" => __( 'Testimonial list navigation', 'themeSlug' ),
	"items_list" => __( 'Testimonials List', 'themeSlug' ),
	"parent_item_colon" => __( 'Parent Testimonial', 'themeSlug' )
);
$args = array(
	"label" =>'Testimonials',
	"labels" => $labels,
	"description" => "",
	"public" => true,
	"publicly_queryable" => true,
	"show_ui" => true,
	"show_in_rest" => false,
	"rest_base" => "",
	"has_archive" => true,
	"show_in_menu" => true,
	"exclude_from_search" => false,
	"capability_type" => "post",
	"map_meta_cap" => true,
	"hierarchical" => false,
	"rewrite" => array( "slug" => "testimonials", "with_front" => true ),
	"query_var" => true,
	"supports" => array( "title","editor" ),
	"menu_icon" => "dashicons-format-status",
);
register_post_type( "testimonials", $args );

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
 * Testimonial Slider.
 */
require get_template_directory() . '/inc/testimonial.php';
