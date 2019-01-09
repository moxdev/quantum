<?php
/**
 * About page content links
 *
 * @package Quantum_Property_Management
 *
 * @return void
 */

function quantum_about_page_content_links() {
	if ( have_rows( 'content_links' ) ) : ?>

		<div class="content-links">
			<div class="content-links-container">
				<?php
				while ( have_rows( 'content_links' ) ) :
					the_row();
					$icon    = get_sub_field( 'icon' );
					$title   = get_sub_field( 'title' );
					$btn_txt = get_sub_field( 'button_text' );
					$btn_url = get_sub_field( 'button_url' );
					?>

					<div class='icon-wrapper'>
						<img src="<?php echo esc_url( $icon['sizes']['about-icon'] ); ?>" alt="<?php echo esc_attr( $icon['alt'] ); ?>" description="<?php echo esc_attr( $icon['description'] ); ?>">
					</div>
					<div class='link-wrapper'>
						<span class='title'><?php echo esc_html( $title ) ?></span>
						<a rel="noopener noreferrer" href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( $btn_txt ); ?></a>
					</div>

				<?php endwhile; ?>
			</div>
		</div>
		<?php
	endif;
}