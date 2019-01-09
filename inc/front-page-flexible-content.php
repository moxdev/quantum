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
					if ( get_row_layout() === 'statistics_section' ) :
						quantum_flexible_statistics_content();
					elseif ( get_row_layout() === 'highlights_section' ) :
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
 * Frontpage Statistics Section
 *
 * @return void
 */

function quantum_flexible_statistics_content() {
	if ( have_rows( 'statistics_content' ) ) : ?>

		<section class="statistics">
			<div class="statistics-container">
				<?php
				while ( have_rows( 'statistics_content' ) ) :
					the_row();
					$statistic_icon        = get_sub_field( 'statistic_icon' );
					$statistic_number      = get_sub_field( 'statistic_number' );
					$statistic_description = get_sub_field( 'statistic_description' );
					?>

					<div class='icon-wrapper'>
						<img src="<?php echo esc_url( $statistic_icon['sizes']['statistics-icon'] ); ?>" alt="<?php echo esc_attr( $statistic_icon['alt'] ); ?>" description="<?php echo esc_attr( $statistic_icon['description'] ); ?>">
					</div>
					<div class='description-wrapper'>
						<span class='number'><?php echo esc_html( $statistic_number ) ?></span>
						<span class='description'><?php echo esc_html( $statistic_description ) ?></span>
					</div>

				<?php endwhile; ?>
			</section>
		</div>
		<?php
	endif;
}

/**
 * Frontpage Highlight Content
 *
 * @return void
 */

function quantum_flexible_highlight_content() {
	$count = count( get_sub_field( 'highlight_content_areas' ) );
	$highlight_bk_img = get_sub_field( 'highlight_content_area_background_image' );
	if ( have_rows( 'highlight_content_areas' ) ) : ?>

		<div class="flex-highlight-outer">
			<img src="<?php echo esc_url( $highlight_bk_img['sizes']['highlight-bk-img'] ); ?>" alt="<?php echo esc_attr( $highlight_bk_img['alt'] ); ?>" description="<?php echo esc_attr( $highlight_bk_img['description'] ); ?>">
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
						<div>
							<?php
							if ( $icon ) :
								?>
								<img src="<?php echo esc_url( $icon['sizes']['highlight-icon'] ); ?>" alt="<?php echo esc_attr( $icon['alt'] ); ?>" description="<?php echo esc_attr( $icon['description'] ); ?>">
								<?php
							endif;
							if ( $title ) :
								?>
								<h2 class="highlight-title"><?php echo esc_html( $title ); ?></h2>
								<?php
							endif;

							if ( $btn_txt ) :
								?>
								<span class="btn highlight-btn"><?php echo esc_html( $btn_txt ); ?></span><?php endif; ?>
						</div>
					</a>
				<?php endwhile; ?>
			</div>
		</div>
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
				<div class='content-wrapper'>
					<?php echo $callout_content; ?>
				</div>

				<?php if ( $callout_button_label ) : ?>

					<a rel="noopener noreferrer" href="<?php echo esc_url($callout_button_url); ?>"><?php echo esc_html($callout_button_label); ?></a>

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
											<div class="cell-wrapper">
												<div class="excerpt-wrapper">

													<span class="name"><?php the_title(); ?></span>
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

							<a rel="noopener noreferrer" href="<?php echo esc_url($testimonial_btn_url); ?>"><?php echo esc_html($testimonial_btn_text); ?></a>

						</section>

					<?php
					}
					// Restore original Post Data
					wp_reset_postdata();
			}

		endif;
	}
}