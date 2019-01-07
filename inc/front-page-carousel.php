
<?php
/**
 * Static front page carousel
 *
 * @package Quantum_Property_Management
 */

function quantum_front_page_carousel() {
	if ( function_exists( 'get_field' ) ) :
		$add_carousel = get_field( 'add_home_page_carousel' );

		if ( 'yes' === $add_carousel ) {
			$imgs = get_field( 'carousel_images' );
			if ( $imgs ) :
				wp_enqueue_script( 'flickity', get_template_directory_uri() . '/js/vendor/flickity.pkgd.min.js', null, '20190107', true );

				wp_enqueue_script( 'quantum-object-fit-library', get_template_directory_uri() . '/js/vendor/ofi.min.js', array(), '20190107', true );
				add_action( 'wp_footer', 'quantum_object_fit_js', 100 );

				add_action( 'wp_footer', 'flickity_trigger', 100 );
				/**
				 * Output to footer ro run carousel
				 *
				 * @return void
				 */
				function flickity_trigger() { ?>
					<script>
						var elem = document.querySelector('.home-carousel');
						var flkty = new Flickity( elem, {
							prevNextButtons: false,
							wrapAround: true,
							autoPlay: 4000,
							pauseAutoPlayOnHover: false
						});
					</script>
				<?php } ?>

				<div class="carousel-wrapper">
					<div class="home-carousel">
						<?php foreach ( $imgs as $img ) { ?>
							<img src="<?php echo esc_url( $img['sizes']['home-carousel-sm'] ); ?>" srcset="<?php echo esc_url( $img['sizes']['home-carousel-sm'] ); ?> 750w, <?php echo esc_url( $img['sizes']['home-carousel-md'] ); ?> 1000w, <?php echo esc_url( $img['sizes']['home-carousel-lg'] ); ?> 1500w, <?php echo esc_url( $img['sizes']['home-carousel-xl'] ); ?> 2200w" sizes="100vw" alt="<?php echo esc_attr( $img['alt'] ); ?>">
						<?php } ?>
					</div>
					<?php
					$carousel_txt = get_field( 'carousel_text' );
					if ( $carousel_txt ) :
						?>
						<div class="carousel-text"><?php echo wp_kses_post( wpautop( $carousel_txt ) ); ?></div><?php endif; ?>
				</div>
				<?php
			endif;
		} else {
			quantum_page_feature();
		}
	endif;
}