<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Jetstats
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'jetstats' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 321 55" xml:space="preserve">
					<path d="M27.1 0C12.1 0 0 12.1 0 27.1c0 15 12.1 27.1 27.1 27.1s27.1-12.1 27.1-27.1C54.3 12.1 42.1 0 27.1 0zM26.1 33.5l-8.5-2.2c-2.2-0.6-3.2-3-2.1-4.9L26.1 8V33.5zM39.2 27.9L28.6 46.3V20.8l8.5 2.2C39.3 23.5 40.3 26 39.2 27.9z"></path>
					<path d="M93.8 18.3c0-3.8-3.1-6.9-6.9-6.9H76.5l9.7 8.6v10.7c0 1.9-0.3 3.3-1 4.2 -0.8 1-2 1.5-3.6 1.5 -1.9 0-3.4-0.6-5.1-2 0 0 0 0 0 0 -0.4-0.3-0.8-0.6-1.1-1l-3.6 6.1c0.2 0.2 0.4 0.3 0.6 0.5 0 0 0.6 0.5 0.6 0.5 2.7 1.9 5.8 2.8 8.8 2.8 3.8 0 7.1-1 9.3-3.4 1.9-2 2.8-4.8 2.8-8.7v-4.5l0 0V18.3z"></path>
						<polygon points="142.6 11.4 142.6 18.3 152.4 18.3 152.4 42.9 160.1 42.9 160.1 18.3 169.8 18.3 169.8 11.4 "></polygon>
					<path d="M203.1 14.6c-2.1-2.1-5-3.2-9-3.2h-13.7v31.5h7.6v-9.1h5.6c3.8 0 6.8-0.9 9-2.8 2.1-1.9 3.4-4.8 3.4-8.4C206 19.3 205 16.6 203.1 14.6zM196.5 26.3c-1 0.6-2.3 0.9-3.4 0.9h-5V18h5.1c1.2 0 2.7 0.2 3.7 1.1 0.8 0.8 1.3 1.9 1.3 3.4C198.2 24.4 197.6 25.6 196.5 26.3zM239.7 14.7c-2.2-2.2-5.4-3.8-9.9-3.8 -4.3 0-7.6 1.6-9.8 3.8 -2.5 2.5-3.7 6.1-3.7 9.4v18.7h7.6v-9.3h11.8v9.3h7.6V24.2C243.4 20.9 242.2 17.2 239.7 14.7zM235.8 27H224v-2.5c0-2 0.6-3.5 1.5-4.6 1.1-1.2 2.7-1.8 4.3-1.8 1.7 0 3.3 0.5 4.5 1.8 0.9 1.1 1.5 2.6 1.5 4.6V27z"></path>
						<polygon points="132 18.2 132 11.4 107.6 11.4 107.6 42.9 132 42.9 132 36.1 115.3 36.1 115.3 30.4 129.6 30.4 129.6 23.7 115.3 23.7 115.3 18.2 "></polygon>
						<polygon points="308 25.2 321.1 11.4 311 11.4 300.8 22.6 300.8 11.4 293.2 11.4 293.2 42.9 300.8 42.9 300.8 32.8 302.8 30.7 309.5 39.5 312 42.9 321.5 42.9 "></polygon>
						<polygon points="281.5 38.5 281.5 38.5 281.7 38.9 "></polygon>
					<path d="M281.2 41.1C281.2 41.1 281.2 41.1 281.2 41.1c0.4-0.2 0.9-0.5 1.2-0.7l-3.1-6.4c-0.3 0.2-0.6 0.4-0.9 0.5 -0.2 0.1-0.3 0.2-0.5 0.2 0 0-0.1 0-0.1 0 -1.8 0.8-3.7 1.5-5.9 1.5 -2.7 0-5-0.9-6.6-2.5 -1.7-1.6-2.7-3.9-2.7-6.7 0-2.3 0.8-4.3 2.1-6 1.6-2 4.1-3.2 7.2-3.2 1.8 0 3.2 0.3 4.7 0.9 0.1 0 0.2 0.1 0.3 0.1 0.2 0.1 0.3 0.1 0.5 0.2 0.1 0 0.1 0.1 0.2 0.1 0.1 0 0.2 0.1 0.3 0.2 0.4 0.2 0.7 0.4 1.1 0.6l3-6.3c-0.6-0.4-1.3-0.8-2-1.1 -2.2-1-4.8-1.7-8.5-1.7 -5 0-9.6 2.1-12.7 5.5 -2.7 2.8-4.3 6.5-4.3 10.7 0 5 1.9 9.1 4.9 11.9 3 2.8 7.2 4.3 12 4.3 4 0 7-0.9 9.5-2.2C281.1 41.1 281.1 41.1 281.2 41.1z"></path>
				</svg>
				<span id="the-word-tools">Tools</span>

		</div><!-- .site-branding -->

	</header><!-- #masthead -->

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<?php
				// Primary navigation menu.
				wp_nav_menu( array(
					'menu_class'     => 'nav-menu',
					'theme_location' => 'primary',
				) );
			?>
		</nav><!-- .main-navigation -->

	<div id="content" class="site-content">
