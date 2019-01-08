<?php

if ( ! function_exists( 'quantum_frontpage_flexible_content' ) ) :
	/**
	 * Quantum Frontpage Flexible Content Areas
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
						quantum_add_testimonial_section();
					endif;
				endwhile;
			endif;
		}
	}
endif;