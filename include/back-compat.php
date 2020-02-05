<?php
/**
 * web log back compat functionality
 *
 * Prevents web log from running on WordPress versions prior to 4.7,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.7.
 *
 * @package web-log
 */

/**
 * Prevent switching to web-log on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 */
function web_log_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'web_log_upgrade_notice' );
}
add_action( 'after_switch_theme', 'web_log_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * web-log on WordPress versions prior to 4.7.
 * @global string $wp_version WordPress version.
 */
function web_log_upgrade_notice() {
	$message = sprintf( __( 'web log requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'web-log' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 * @global string $wp_version WordPress version.
 */
function web_log_customize() {
	wp_die( sprintf( __( 'web log requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'web-log' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'web_log_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 * @global string $wp_version WordPress version.
 */
function web_log_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'web-log requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'web-log' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'web_log_preview' );
