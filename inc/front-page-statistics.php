<?php
/**
 * Frontpage Statistics Section
 *
 * @package Quantum_Property_Management
 *
 * @return void
 */

function quantum_flexible_statistics_content() {
	if ( have_rows( 'statistics_section' ) ) : ?>

		<div class="statistics-content">

				<?php
				while ( have_rows( 'statistics_section' ) ) :
					the_row();
					$statistic_icon        = get_sub_field( 'statistic_icon' );
					$statistic_number      = get_sub_field( 'statistic_number' );
					$statistic_description = get_sub_field( 'statistic_description' );
					?>

					<div class="statistics-container">
						<div class='icon-wrapper'>
							<img src="<?php echo esc_url( $statistic_icon['sizes']['statistics-icon'] ); ?>" alt="<?php echo esc_attr( $statistic_icon['alt'] ); ?>" description="<?php echo esc_attr( $statistic_icon['description'] ); ?>">
						</div>
						<div class='description-wrapper'>
							<span class='number'><?php echo esc_html( $statistic_number ) ?></span>
							<span class='description'><?php echo esc_html( $statistic_description ) ?></span>
						</div>
					</div>

				<?php endwhile; ?>
		</div>
		<?php
	endif;
}