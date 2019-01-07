<?php
/**
 * Custom function for homepage testimonial slider
 *
 * @package Quantum_Property_Management
 */

function quantum_testimonial_carousel() {
	if ( function_exists( 'get_field' ) ) {
		$testimonial = get_posts( array('post_type' => 'testimonials', 'posts_per_page' => -1) );

		if ($testimonial) {
				// WP_Query arguments
				$args = array(
					'post_type'   => array( 'testimonials' ),
					'post_status' => array( 'publish' ),
					'nopaging'    => true,
					'order'       => 'DESC',
					'orderby'     => 'date',
				);
				// The Query
				$testimonials = new WP_Query( $args );
				// The Loop
				if ( $testimonials->have_posts() ) { ?>

					<section class="home-testimonial">
						<div class="home-testimonial-wrapper">
							<div class="testimonial-carousel">

							<?php while ( $testimonials->have_posts() ) {
									$testimonials->the_post();
									$testimonial_company = get_field( 'testimonial_company', $post->ID );

									?>

									<div class="cell">
										<div class="cell-wrapper">
											<div class="excerpt-wrapper">

												<span class="name">&mdash; &nbsp; <?php the_title(); ?></span>
												<span class="company"><?php echo esc_html( $testimonial_company ); ?></span>

											</div>

											<div class="testimonial-content-wrapper">
												<?php the_content(); ?>
											</div>

										</div>
									</div><!-- cell -->

								<?php

							} ?>

							</div><!-- testimonial-carousel -->
						</div><!-- home-testimonial-wrapper -->
					</section>

				<?php
				}
				// Restore original Post Data
				wp_reset_postdata();
		}
	}
}
