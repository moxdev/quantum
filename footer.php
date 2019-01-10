<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Quantum_Property_Management
 */

?>

		</div><!-- .content-wrapper -->
	</div><!-- #content -->

	<?php if ( is_front_page() && function_exists( 'quantum_frontpage_flexible_content' ) ) {
		quantum_frontpage_flexible_content();
	} ?>

	<footer id="colophon" class="site-footer wrapper">
		<div class='flex-left-side'>
			<div class="ftr-logo">
				<?php
				$custom_icon = get_theme_mod( 'logo_icon' );
				if ( $custom_icon ) :
					$icon_id = attachment_url_to_postid( $custom_icon );
					$logo    = wp_get_attachment_image( $icon_id, 'full' );
					echo $logo;
				endif;
				?>
			</div><!-- .ftr-logo -->

			<?php quantum_contact_info(); ?>

		</div> <!-- .flex-contact-wrapper -->

		<div class='flex-right-side'>
			<div class="ftr-social">
				<?php quantum_social_media_menu(); ?>
			</div>

			<div class='equal-housing'>
				<svg id="ab177fb8-9053-44fc-b84d-c9660e9e8ff2" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="60" height="58" viewBox="0 0 60 58"><title>equal_housing_logo</title><image width="60" height="58" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA6CAYAAADspTpvAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyhpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQ1IDc5LjE2MzQ5OSwgMjAxOC8wOC8xMy0xNjo0MDoyMiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NjVCOUQxNjQwQzdDMTFFOTkzNUFEM0M5RkI3M0FDMjAiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NjVCOUQxNjUwQzdDMTFFOTkzNUFEM0M5RkI3M0FDMjAiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDowMjMyODlGRjBDNTkxMUU5OTM1QUQzQzlGQjczQUMyMCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDowMjMyOEEwMDBDNTkxMUU5OTM1QUQzQzlGQjczQUMyMCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PlNKLRoAAAHUSURBVHja7JtNsoMgDIDFwbu50MuqC+/mgjcu6FBf+AshWA0bHaxJPiABJFXLsnRvKn0LpfM8m1bAuhWovV/XVT0OONSj3OD6LkOXC1zfzUdrg5MCT9NklFKkjUYNru8GWhu8LwU9DcqFxRh/6qGYzhRm4YHt0eM4un3fFYW/Y3s8CxgLaozptm3zvjiOoxmGoeMATwLGGhQDbQEeBOYC5dQLArcC5XChL2BOX2oF/gHmjpac4K6N6IUH9y7nLLa3SuZj/QugPhsw4JoalnJzH9N3Ps/V13cvKwL89KIhf2n5ka22/2suRTKkBViA6wYtqsK58JAeFmABlqAlCw8Z0gL8YB9+wi5KhrQAC7AA/36UvvtqSXpYgCPANmHkmhoIpQpC975nscVLiT5bd73Gfu/9Lu0eWNX26VR9MVuuz6Hf9yXLRisw91ALm4Jk9fje9dnhvtOHInNK72KMt42E3W+HGhiSCx6IuxlvVqB7dZW4AqCz2tzsOUg2VOfqSJENNYySjPi3AEO+CE1XoXoKOaX3PnlfQSsUbXPqc+W4/krxASJFnk5VchWSG5go0oAxOR1u4E0C9hmYazjVQgYD/a+HfVNOiTEl82zNvwG8blr6E2AARVgDmmmXLnYAAAAASUVORK5CYII="/></svg>
			</div>
		</div>
	</footer><!-- #colophon -->

	<div id="mobile-navigation">
			<nav>
				<?php
					wp_nav_menu( array(
						'theme_location' => 'main',
						'menu_id' => 'mobile-main',
						'container' => '',
						'menu_class' => 'main-menu'
					) );
				?>
			</nav>
	</div><!-- #mobile-navigation -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
