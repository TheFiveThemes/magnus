<?php
/**
 * Magnus Theme Customizer
 *
 * @package Magnus
 */

/**
 * Add settings and controls to customizer
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function magnus_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	// Remove default header text color control
	$wp_customize->remove_control( 'header_textcolor' );

	// Accent Color
	$wp_customize->add_setting( 'accent_color' , array(
		'default'     => '#50e3c2',
		'transport'   => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color' , array(
		'label'        => __( 'Accent Color', 'magnus' ),
		'section'    => 'colors',
	) ) );


}
add_action( 'customize_register', 'magnus_customize_register' );


/**
 * Render custom CSS
 */
function magnus_customize_css() {

	$accent_color = get_theme_mod( 'accent_color', '#50e3c2' );

	if( '#50e3c2' === $accent_color ) {
		return;
	}

	?>
	<style type="text/css">
		a {
			color: <?php echo $accent_color; ?>;
		}
	</style>
	<?php
}

add_action( 'wp_head', 'magnus_customize_css', 90 );



/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function magnus_customize_preview_js() {
	wp_enqueue_script( 'magnus_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'magnus_customize_preview_js' );
