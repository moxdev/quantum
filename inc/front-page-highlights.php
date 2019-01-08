<?php
/**
 * Frontpage Highlight Content Area
 *
 * @package Quantum_Property_Management
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