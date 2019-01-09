<?php
/**
 * Quantum Property Management Theme Customizer
 *
 * @package Quantum_Property_Management
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function quantum_customize_register( $wp_customize ) {
	$wp_customize->add_setting( 'logo_icon' );
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'logo_icon' )->transport        = 'postMessage';

	// add a setting for the site logo
	// Add a control to upload the logo.
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'logo_icon',
			array(
				'label'    => __( 'Icon', 'quantum' ),
				'section'  => 'title_tagline',
				'settings' => 'logo_icon',
				'priority' => 8,
			)
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
			'selector'        => '.site-title a',
			'render_callback' => 'quantum_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
			'selector'        => '.site-description',
			'render_callback' => 'quantum_customize_partial_blogdescription',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'logo_icon',
			array(
				'selector'        => '.ftr-logo',
				'render_callback' => 'quantum_customize_partial_footer_logo',
			)
		);
	}
}
add_action( 'customize_register', 'quantum_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function quantum_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function quantum_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Render the footer logo for the selective refresh partial
 */
function quantum_customize_partial_footer_logo() {
	$custom_icon = get_theme_mod( 'logo_icon' );
	if ( $custom_icon ) :
		$icon_id = attachment_url_to_postid( $custom_icon );
		$logo    = wp_get_attachment_image( $icon_id, 'thumbnail' );
		echo $logo;
	endif;
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function quantum_customize_preview_js() {
	wp_enqueue_script( 'quantum-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'quantum_customize_preview_js' );
