<?php

if( isset( $_GET['ghwebhook'] ) ) {
	require( '/home/dh_yt768n/jtpk.tools/wp-content/themes/jetstats/scripts/process-incoming-gh-webhook.php' );
	exit;
}

if( isset( $_GET['gh_dump'] ) ) {
	require( '/home/dh_yt768n/jtpk.tools/wp-content/themes/jetstats/scripts/process-gh-log.php' );
	exit;
}

if( isset( $_GET['gh_nightly_stats'] ) ) {
	require( '/home/dh_yt768n/jtpk.tools/wp-content/themes/jetstats/scripts/nightly-gh-stats.php' );
	exit;
}


if( isset( $_GET['graph_total_issues'] ) ) {
	require( '/home/dh_yt768n/jtpk.tools/wp-content/themes/jetstats/graphs/total-issues.php' );
	exit;
}

if( isset( $_GET['graph_prs'] ) ) {
	require( '/home/dh_yt768n/jtpk.tools/wp-content/themes/jetstats/graphs/pr-info.php' );
	exit;
}


if( isset( $_GET['graph_time'] ) ) {
	require( '/home/dh_yt768n/jtpk.tools/wp-content/themes/jetstats/graphs/time-info.php' );
	exit;
}

if( isset( $_GET['graph_average_age_review'] ) ) {
	require( '/home/dh_yt768n/jtpk.tools/wp-content/themes/jetstats/graphs/prs-average-age-review.php' );
	exit;
}

if( isset( $_GET['wpcom_commit_log'] ) ) {
	require( '/home/dh_yt768n/jtpk.tools/wp-content/themes/jetstats/scripts/wpcom-commit-log.php' );
	exit;
}

function get_old_pr_link()
{
	return 'https://github.com/Automattic/jetpack/pulls?utf8=%E2%9C%93&q=is%3Aissue%20is%3Aopen%20updated%3A%3C%3D' . date( 'Y-m-d', strtotime( '30 days ago' ) ) . '%20';
}

add_shortcode( 'old_pr_link', 'get_old_pr_link' );

function jpdebug_search_form()
{
	return '<form action="https://jetpack.com/support/debug/" method="get" target="_blank">
		<input type="text" name="url" value="" placeholder="URL">
		<input type="submit" value="Go">
	</form>';

}
add_shortcode( 'jpdebug_search_form', 'jpdebug_search_form' );


function gh_request( $route, $options = array() ) {

	$key = '6830f0b79e15f5972a3d59cdfb9db4aae176acbf';

	if( substr( $route, 0, 4 ) != 'http' ) {
		$route = 'https://api.github.com/repos/Automattic/jetpack/' . $route;
	}

	$curl = curl_init();

	curl_setopt_array(
		$curl, array(
		CURLOPT_URL            =>  $route . '?' . http_build_query( $options ),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING       => "",
		CURLOPT_MAXREDIRS      => 10,
		CURLOPT_TIMEOUT        => 30,
		CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST  => "GET",
		// CURLOPT_POSTFIELDS     => "[\"Touches WP.com Files\"]",
		CURLOPT_HTTPHEADER     => array(
			'Authorization: token ' . $key,
			"cache-control: no-cache",
			"User-Agent: AUTOMATTIC"
		),
	)
	);

	$response = curl_exec( $curl );
	$err      = curl_error( $curl );

	curl_close( $curl );

	if ( $err ) {
		return false;
	}

	return json_decode( $response );
}


/**
 * Jetstats functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Jetstats
 */

if ( ! function_exists( 'jetstats_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function jetstats_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Jetstats, use a find and replace
	 * to change 'jetstats' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'jetstats', get_template_directory() . '/languages' );

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
		'primary' => esc_html__( 'Primary', 'jetstats' ),
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
	add_theme_support( 'custom-background', apply_filters( 'jetstats_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'jetstats_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function jetstats_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'jetstats_content_width', 640 );
}
add_action( 'after_setup_theme', 'jetstats_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function jetstats_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'jetstats' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'jetstats' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'jetstats_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function jetstats_scripts() {
	wp_enqueue_style( 'jetstats-style', get_stylesheet_uri() );

	wp_enqueue_script( 'jetstats-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'jetstats-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'jetstats_scripts' );

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
