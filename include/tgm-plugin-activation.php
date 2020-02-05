<?php
/**
 * Recommended plugins
 *
 * @package web-log
 * @version 1.0.0
 */
if ( ! function_exists( 'web_log_recommended_plugins' ) ) :
	/**
	 * Recommend plugins.
	 *
	 * @since 1.0.0
	 */
	function web_log_recommended_plugins() {
		
		$plugins = array(

			array(
				'name'     => esc_html__( 'One Click Demo Import', 'web-log' ),
				'slug'     => 'one-click-demo-import',
				'required' => false,
			),
			
				

			array(
				'name'     => esc_html__( 'Contact Form by WPForms', 'web-log' ),
				'slug'     => 'wpforms-lite',
				'required' => false,
			),
		);
		tgmpa( $plugins );
	}
endif;
add_action( 'tgmpa_register', 'web_log_recommended_plugins' );
