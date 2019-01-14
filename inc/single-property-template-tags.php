<?php
/**
 * Custom template tags for single property pages
 *
 * @package Quantum_Property_Management
 */

/**
 * Single Property Main Content Additions
 */
if ( ! function_exists( 'quantum_property_main_content_additions' ) ) :

	function quantum_property_main_content_additions() {
		if( have_rows('property_content_images') ):

		?>

		<div class="property-content-images">

			<?php
			while( have_rows('property_content_images') ): the_row();
				$prop_img = get_sub_field('property_image');

				if ( $prop_img ) :
				?>
				<div class='property-image'>
					<img src="<?php echo esc_url( $prop_img['sizes']['property-content-img'] ); ?>" alt="<?php echo esc_attr( $prop_img['alt'] ); ?>" description="<?php echo esc_attr( $prop_img['description'] ); ?>">
				</div>
				<?php
				endif;

			endwhile;
			?>
		</div>

		<?php
		endif;

		if( function_exists('get_field') ) :
			$add_contact_button = get_field('add_a_contact_form');

			if( $add_contact_button ) :
				$contact_button = get_field( 'contact_form_section' )
				?>
				<div class='main-content-button'>
					<a rel="noopener noreferrer" href="#"><?php echo esc_html( $contact_button['property_content_button_text'] ) ?></a>

				</div>
				<?php
			endif;
		endif;
	}
endif;

/**
 * Single Property Amenities Section
 */
if ( ! function_exists( 'quantum_property_amenities_section' ) ) :

	function quantum_property_amenities_section() {
		if( function_exists('get_field') ) :
			$add_prop_amenities_section = get_field('add_property_amenities_section');
			$add_community_amenities_section = get_field('add_community_amenities_section');

			if ( $add_prop_amenities_section || $add_community_amenities_section ) :
				?>

				<section class='amenities'>
					<?php
					if ( $add_prop_amenities_section ) :
						$prop_amenities = get_field( 'property_amenities_section' );

						?>
						<div class='apartment-amenities'>
							<h2><?php echo esc_html( $prop_amenities['property_amenities_section_title'] ); ?></h2>
							<div class='amenities-content'>
								<?php echo $prop_amenities['property_amenities']; ?>
							</div>
						</div>
						<?php

					endif;
					?>

					<?php
					if ( $add_community_amenities_section ) :
						$community_amenities = get_field( 'community_amenities_section' );

						?>
						<div class='community-amenities'>
							<h2><?php echo esc_html( $community_amenities['community_amenities_section_title'] ); ?></h2>
							<div class='amenities-content'>
								<?php echo $community_amenities['community_amenities']; ?>
							</div>
						</div>
						<?php

					endif;
					?>

				</section>
				<?php
			endif;

		endif;
	}
endif;

/**
 * Single Property Floor Plans Section
 */
if ( ! function_exists( 'quantum_property_floorplans_section' ) ) :

	function quantum_property_floorplans_section() {
		if( function_exists('get_field') ) :
			$add_floor_plans_section = get_field('add_floor_plans_section');

			if ( $add_floor_plans_section ) :
				$floor_plans_section = get_field( 'floor_plans_section' );

				if( $floor_plans_section ) {
					$floorplans_section_title = $floor_plans_section['floor_plans_title'];
					$floorplans               = $floor_plans_section['floor_plans_gallery'];
					$floorplans_disclaimer    = $floor_plans_section['floor_plan_disclaimer'];
					?>

					<section class="floor-plans">
						<h2><?php echo esc_html( $floorplans_section_title ); ?></h2>

						<?php
						if($floorplans) { ?>
							<div class="floorplans-gallery">
								<?php foreach ($floorplans as $floorplan) { ?>
									<div class="cell">
										<a data-imagelightbox="a" data-ilb2-caption="<?php echo esc_attr( $floorplan['caption'] ); ?>" href="<?php echo esc_attr( $floorplan['sizes']['property-floorplan-img'] ); ?>"><img src="<?php echo esc_attr( $floorplan['sizes']['property-floorplan-img'] ); ?>" alt="<?php echo esc_attr( $floorplan['alt'] ); ?>"></a>
									</div>
								<?php } ?>
							</div>
						<?php

						wp_enqueue_script( 'imagelightbox-library', get_template_directory_uri() . '/js/min/imagelightbox.min.js', array(), NULL, true );
						wp_enqueue_script( 'flickity-library', get_template_directory_uri() . '/js/vendor/flickity.pkgd.min.js', array( 'imagelightbox-library' ), NULL, true );
						wp_enqueue_script( 'property-carousel', get_template_directory_uri() . '/js/min/property-carousel.min.js', array( 'imagelightbox-library' , 'flickity-library' ), NULL, true );
						} ?>
					</section>
				<?php }
				?>

				<?php
			endif;

		endif;
	}
endif;

/**
 * Single Property Location Section
 */
if ( ! function_exists( 'quantum_property_location_section' ) ) :

	function quantum_property_location_section() {
		if( function_exists('get_field') ) :
			$add_floor_plans_section = get_field('add_floor_plans_section');

			if ( $add_floor_plans_section ) :
				$floor_plans_section = get_field( 'floor_plans_section' );

				if( $floor_plans_section ) {
					$floorplans_section_title = $floor_plans_section['floor_plans_title'];
					$floorplans               = $floor_plans_section['floor_plans_gallery'];
					$floorplans_disclaimer    = $floor_plans_section['floor_plan_disclaimer'];
					?>

					<section class="floor-plans">
						<h2><?php echo esc_html( $floorplans_section_title ); ?></h2>

						<?php
						if($floorplans) { ?>
							<div class="floorplans-gallery">
								<?php foreach ($floorplans as $floorplan) { ?>
									<div class="cell">
										<a data-imagelightbox="a" data-ilb2-caption="<?php echo esc_attr( $floorplan['caption'] ); ?>" href="<?php echo esc_attr( $floorplan['sizes']['property-floorplan-img'] ); ?>"><img src="<?php echo esc_attr( $floorplan['sizes']['property-floorplan-img'] ); ?>" alt="<?php echo esc_attr( $floorplan['alt'] ); ?>"></a>
									</div>
								<?php } ?>
							</div>
						<?php

						wp_enqueue_script( 'imagelightbox-library', get_template_directory_uri() . '/js/min/imagelightbox.min.js', array(), NULL, true );
						wp_enqueue_script( 'flickity-library', get_template_directory_uri() . '/js/vendor/flickity.pkgd.min.js', array( 'imagelightbox-library' ), NULL, true );
						wp_enqueue_script( 'property-carousel', get_template_directory_uri() . '/js/min/property-carousel.min.js', array( 'imagelightbox-library' , 'flickity-library' ), NULL, true );
						} ?>
					</section>
				<?php }
				?>

				<?php
			endif;

		endif;
	}
endif;