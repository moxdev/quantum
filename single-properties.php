<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Quantum_Property_Management
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php quantum_page_titles(); ?>

			<div class='logo-container'>
				<?php if( function_exists('get_field') ) {
					$logo = get_field('logo');
					$orientation = get_field('logo_orientation');

					if( $logo ) { ?>
						<img class="property-logo <?php echo $orientation; ?>" src="<?php echo esc_url( $logo['sizes']['property-logo-img'] ); ?>" alt="<?php echo esc_attr( $logo['alt'] ); ?>" description="<?php echo esc_attr( $logo['description'] ); ?>">
					<?php }
				} ?>
			</div>

			<?php

			// vars
			$prop_info = get_field('property_contact_information');

			if( $prop_info ): ?>
				<div id="contact-info">
					<div class="contact-info-container">

					<div class='ftr-company-name'>
						<span class="ftr-city"><?php echo esc_html( $prop_info['prop_address_1'] ); ?></span>
						<span class="ftr-city"><?php echo esc_html( $prop_info['prop_address_2'] ); ?></span>
						<span class="ftr-city"><?php echo esc_html( $prop_info['prop_city'] ); ?></span>
						<span class="ftr-city"><?php echo esc_html( $prop_info['prop_state'] ); ?></span>
						<span class="ftr-city"><?php echo esc_html( $prop_info['prop_zip'] ); ?></span>
						<span class="ftr-city"><?php echo esc_html( $prop_info['prop_phone'] ); ?></span>
						<span class="ftr-city"><?php echo esc_html( $prop_info['prop_fax'] ); ?></span>
						<span class="ftr-city"><?php echo esc_html( $prop_info['prop_email'] ); ?></span>
					</div>

					</div>

				</div>
			<?php endif; ?>

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'properties' );

			the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();
