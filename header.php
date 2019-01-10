<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Quantum_Property_Management
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'quantum' ); ?></a>

	<header id="masthead" class="site-header">
		<div>

			<div class="site-branding">
				<?php
					the_custom_logo();
				?>
			</div><!-- .site-branding -->

			<?php if ( has_nav_menu( 'main' ) ) : ?>
				<button class="mobile-menu-toggle" aria-controls="main-navigation" aria-expanded="false" aria-label="Menu"><span class="inner"><?php esc_html_e( '', 'quantum' ); ?></span></button>
				<!-- <button class="menu-toggle" aria-controls="main-menu" aria-expanded="false"><span class="screen-reader-text">Menu</span></button> -->
			<?php endif; ?>

		</div>

		<?php if ( has_nav_menu( 'main' ) ) : ?>
			<nav id="main-navigation" class="main-navigation">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'main',
						'container'      => '',
						'menu_id'        => 'main-menu',
					)
				);
				?>
			</nav><!-- #site-navigation -->
		<?php endif; ?>

	</header><!-- #masthead -->

	<?php
	if ( is_front_page() ) :
		quantum_front_page_carousel();
	elseif ( is_page() || is_single() ) :
		quantum_page_feature();
	endif;
	?>

	<div id="content" class="site-content">
		<div class="content-wrapper">
