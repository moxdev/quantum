<?php
/**
 * Frontpage Flexible Content
 *
 * @package Quantum_Property_Management
 *
 * @return void
 */

if ( ! function_exists( 'quantum_frontpage_flexible_content' ) ) :
	/**
	 * Frontpage Flexible Content Areas
	 *
	 * @return void
	 */
	function quantum_frontpage_flexible_content() {
		if ( function_exists( 'get_field' ) ) {
			if ( have_rows( 'home_page_sections' ) ) :
				while ( have_rows( 'home_page_sections' ) ) :
					the_row();
					if ( get_row_layout() === 'highlights_section' ) :
						quantum_flexible_highlight_content();
					elseif ( get_row_layout() === 'callout_section' ) :
						quantum_flexible_callout_content();
					elseif ( get_row_layout() === 'testimonial_section' ) :
						quantum_testimonial_carousel();
					endif;
				endwhile;
			endif;
		}
	}
endif;

/**
 * Frontpage Highlight Content
 *
 * @return void
 */

function quantum_flexible_highlight_content() {
	$count = count( get_sub_field( 'highlight_content_areas' ) );
	$highlight_bk_img = get_sub_field( 'highlight_content_area_background_image' );
	if ( have_rows( 'highlight_content_areas' ) ) : ?>

		<section class="flex-highlight">
			<img class="background-img" src="<?php echo esc_url( $highlight_bk_img['sizes']['highlight-bk-img-sm'] ); ?>" srcset="<?php echo esc_url( $highlight_bk_img['sizes']['highlight-bk-img-sm'] ); ?> 750w, <?php echo esc_url( $highlight_bk_img['sizes']['highlight-bk-img-md'] ); ?> 1000w, <?php echo esc_url( $highlight_bk_img['sizes']['highlight-bk-img-lg'] ); ?> 1500w, <?php echo esc_url( $highlight_bk_img['sizes']['highlight-bk-img-xl'] ); ?> 2200w" sizes="100vw" alt="<?php echo esc_attr( $highlight_bk_img['alt'] ); ?>">

			<div class="flexible-highlight-inner wrapper col-<?php echo esc_attr( $count ); ?>">
				<?php
				while ( have_rows( 'highlight_content_areas' ) ) :
					the_row();
					$icon      = get_sub_field( 'highlight_icon' );
					$title     = get_sub_field( 'highlight_title' );
					$btn_txt   = get_sub_field( 'highlight_button_text' );
					$btn_url   = get_sub_field( 'highlight_button_url' );
					?>
					<a class="highlight-item"
					<?php if ( $btn_url ) : ?>
						href="
						<?php
						echo esc_url( $btn_url );
						?>
						">
					<?php endif; ?>

						<div class="inner-wrapper">

							<?php
							if ( $icon ) :
								?>
								<div class='icon-wrapper'>
									<img class='icon-img' src="<?php echo esc_url( $icon['sizes']['highlight-icon'] ); ?>" alt="<?php echo esc_attr( $icon['alt'] ); ?>" description="<?php echo esc_attr( $icon['description'] ); ?>">
								</div>
								<?php
							endif;
							if ( $title ) :
								?>

								<div class='highlight-title-wrapper'>
									<span class="highlight-title"><?php echo esc_html( $title ); ?></span>

								<?php

								if ( $btn_txt ) :
									?>
									<span class="highlight-btn"><?php echo esc_html( $btn_txt ); ?></span>
									<?php
								endif;
								?>

								</div>

								<?php
							endif;

							?>

						</div>
					</a>
				<?php endwhile; ?>
			</div>
		</section>
		<?php
	endif;
}

/**
 * Frontpage Callout Section
 *
 * @return void
 */

function quantum_flexible_callout_content() {
	if ( function_exists( 'get_field' ) ) :
		$callout_content      = get_sub_field( 'callout_content' );
		$callout_button_label = get_sub_field( 'callout_button_label' );
		$callout_button_url   = get_sub_field( 'callout_button_url' );

		if ( $callout_content ) : ?>

			<section class='callout'>
				<div class='callout-content-wrapper'>
					<?php echo $callout_content; ?>
				</div>

				<?php if ( $callout_button_label ) : ?>

					<a class='btn' rel='noopener noreferrer' href='<?php echo esc_url($callout_button_url); ?>'><?php echo esc_html($callout_button_label); ?></a>

				<?php endif; ?>

			</section>

		<?php
		endif;

	endif;
}

/**
 * Frontpage Testimonial Slider
 *
 * @return void
 */

function quantum_testimonial_carousel() {
	if ( function_exists( 'get_field' ) ) {
		$add_testimonial = get_sub_field('add_testimonial_section');

		if ( $add_testimonial ) :

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
					if ( $testimonials->have_posts() ) {
						$testimonial_header   = get_sub_field('testimonial_header');
						$testimonial_btn_text = get_sub_field('testimonial_button_text');
						$testimonial_btn_url  = get_sub_field('testimonial_button_url'); ?>

					<!-- CLEANUP MARKUP -->

						<section class="home-testimonial">
							<h2><?php echo esc_html( $testimonial_header ); ?></h2>

							<div class="home-testimonial-wrapper">
								<div class="testimonial-carousel">

								<?php while ( $testimonials->have_posts() ) {
										$testimonials->the_post();
										$testimonial_company = get_field( 'testimonial_company', $post->ID );

										?>

										<div class="cell">
											<div class="name-wrapper">
												<span class="name"><?php the_title(); ?></span>
												<span class="company"><?php echo esc_html( $testimonial_company ); ?></span>
											</div>

											<div class="testimonial-content-wrapper">
												<?php the_content(); ?>
											</div>
										</div><!-- cell -->

									<?php

								} ?>

								</div><!-- testimonial-carousel -->
							</div><!-- home-testimonial-wrapper -->

							<a class='btn-alt' rel="noopener noreferrer" href="<?php echo esc_url($testimonial_btn_url); ?>"><?php echo esc_html($testimonial_btn_text); ?></a>

						</section>

					<?php
					}
					// Restore original Post Data
					wp_reset_postdata();
			}

		endif;
	}
}