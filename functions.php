<?php
/**
 * WP Devangelist functions and definitions
 *
 * @package wp-devangelist
 */


/**
 * Tell WordPress which customizations this theme offers.
 */
function wp_devangelist_customize_register( $wp_customize ) {
	
	$choices = array();
	
	$users = get_users( array( 'fields' => array(
		'display_name',
		'ID'
	)));

	foreach( $users as $user ) {
		$choices[$user->ID] = $user->display_name;
	}
	
	$wp_customize->add_section( "wp_devangelist_settings", array(
		'title' => __("Settings", "wp-devangelist")
	));

	$wp_customize->add_setting( "wp_devangelist_showcased_user", array(
		'default' => 1, # defaults to user ID 1
		'type' => 'theme_mod'
	));

	$wp_customize->add_control( "wp_devangelist_showcased_user", array(
		'choices' => $choices,
		'label' => __("WordPress User", "wp-devangelist"),
		'section' => 'wp_devangelist_settings',
		'settings' => 'wp_devangelist_showcased_user',
		'type' => 'select'
	));
}
 add_action("customize_register", "wp_devangelist_customize_register");

/**
 * Adds additional contact fields in the user profile.
 * 
 * This adds additional profile fields for:
 *	- Twitter
 *	- GitHub
 *	- Google+
 * 	- LinkedIn
 * 	- Facebook
 */
function wp_devangelist_modify_contact_methods($profile_fields) {
	
	$profile_fields['twitter'] = "Twitter Username";
	$profile_fields['github'] = "GitHub Username";
	$profile_fields['gplus'] = "Google+ URL";
	$profile_fields['linkedin'] = "LinkedIn URL";
	$profile_fields['facebook'] = "Facebook URL";

	return $profile_fields;
}
add_filter('user_contactmethods', 'wp_devangelist_modify_contact_methods');

if( !function_exists( 'wp_devangelist_setup' )):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wp_devangelist_setup() {
	
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( "wp_devangelist", get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( "automatic-feed-links" );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( "title-tag" );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( "post-thumbnails" );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( "Primary Menu", "wp_devangelist" ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( "html5", array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( "post-formats", array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( "custom-background", apply_filters(
	"dev_devangelist_custom_background_args", array(
		'default-color' => 'FFFFFF',
		'default-image' => ''
	)));

	add_theme_support( "infinite-scroll", array(
		'container' => 'main',
		'footer' => 'site-footer',
	));
}
endif; // wp_devangelist_setup
add_action( "after_setup_theme", "wp_devangelist_setup" );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wp_devangelist_content_width() {
	
	$GLOBALS['content_width'] = apply_filters( "dev_evangelist_content_width", 640 );
}
add_action( "after_setup_theme", "wp_devangelist_content_width", 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function wp_devangelist_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( "Sidebar", "wp_devangelist" ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( "widgets_init", "wp_devangelist_widgets_init" );

/**
 * Enqueue scripts and styles.
 */
function wp_devangelist_enqueue_scripts(){
	
	// register any stylesheets
	wp_register_style( "mobile-stylesheet",
	get_template_directory_uri()."/styles/mobile.css", "main-stylesheet",
	false, "(max-width:1000px)");

	wp_enqueue_style( "main-stylesheet", get_stylesheet_uri());
	wp_enqueue_style( "mobile-stylesheet" );

	wp_enqueue_script( "wp_devangelist-navigation",
	get_template_directory_uri()."/js/navigation.js", array(), "20120206", true );

	wp_enqueue_script( "wp_devangelist-skip-link-focus-fix",
	get_template_directory_uri()."/js/skip-link-focus-fix.js", array(),
	"20130115", true );

	if( is_singular() && comments_open() && get_option( "thread_comments" )) {
		wp_enqueue_script( "comment-reply" );
	}
}
add_action( "wp_enqueue_scripts", "wp_devangelist_enqueue_scripts" );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
