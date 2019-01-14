<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Quantum_Property_Management
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">

		<?php
		if( function_exists('get_field') ) :
			$logo = get_field('logo');
			$prop_info = get_field('property_contact_information');

			?>

			<div class='property-header'>

				<?php
				if( function_exists('get_field') ) :
					$logo = get_field('logo');
					$orientation = get_field('logo_orientation');

					if( $logo ) :
						?>
						<div class='logo'>
							<img class="property-logo <?php echo $orientation; ?>" src="<?php echo esc_url( $logo['sizes']['property-logo-img'] ); ?>" alt="<?php echo esc_attr( $logo['alt'] ); ?>" description="<?php echo esc_attr( $logo['description'] ); ?>">
						</div>
						<?php
					endif;
				endif;
				?>

				<?php
				if ( function_exists( 'get_field' ) ):
					$prop_info = get_field('property_contact_information');

					if( $prop_info ):
						?>
						<div id="contact-information">
							<span class="ftr-city"><?php echo esc_html( $prop_info['prop_address_1'] ); ?></span>
							<span class="ftr-city"><?php echo esc_html( $prop_info['prop_address_2'] ); ?></span>
							<span class="ftr-city"><?php echo esc_html( $prop_info['prop_city'] ); ?></span>
							<span class="ftr-city"><?php echo esc_html( $prop_info['prop_state'] ); ?></span>
							<span class="ftr-city"><?php echo esc_html( $prop_info['prop_zip'] ); ?></span>
							<span class="ftr-city"><?php echo esc_html( $prop_info['prop_phone'] ); ?></span>
							<span class="ftr-city"><?php echo esc_html( $prop_info['prop_fax'] ); ?></span>
							<span class="ftr-city"><?php echo esc_html( $prop_info['prop_email'] ); ?></span>
						</div>
						<?php
					endif;
				endif;
				?>

				<?php
				if ( function_exists( 'get_field' ) ):
					$add_application_file = get_field('add_application_download');

					if( $add_application_file ):
						$application_download_section = get_field('application_download_section');
						$file                         = $application_download_section['prop_application'];
						$download_url_text            = $application_download_section['download_url_text'];

						if ( $application_download_section ) :

							?>
							<a rel="noopener noreferrer" target="_blank" href="<?php echo esc_url( $file['url'] ); ?>"><?php echo esc_html( $download_url_text ); ?></a>
							<?php

						endif;
					endif;
				endif;
				?>

			</div>

			<?php

		endif;
		?>
		<div class='entry-content-inner-wrapper'>

			<?php
			the_content();
			?>

			<?php quantum_property_main_content_additions(); ?>

		</div> <!-- .entry-content-inner-wrapper -->

		<?php quantum_property_amenities_section(); ?>
		<?php quantum_property_floorplans_section(); ?>
		<?php quantum_property_location_section(); ?>
		<?php quantum_property_contact_form_section(); ?>

	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'quantum' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
