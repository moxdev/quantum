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
		<div class="ftr-logo-contact">
			<?php
			$custom_icon = get_theme_mod( 'logo_icon' );
			if ( $custom_icon ) :
				$icon_id = attachment_url_to_postid( $custom_icon );
				$logo    = wp_get_attachment_image( $icon_id, 'thumbnail' );
				echo $logo;
			endif;

			quantum_contact_info();
			?>
		</div><!-- .ftr-logo -->

		<div class="ftr-social">
			<?php quantum_social_media_menu(); ?>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
