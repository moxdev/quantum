<?php
/**
 * Frontpage Callout Section
 *
 * @package Quantum_Property_Management
 */

function quantum_flexible_callout_content() {
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
}