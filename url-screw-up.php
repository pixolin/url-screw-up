<?php
/**
 * Plugin Name:     URL Screw-Up
 * Plugin URI:      https://github.com/pixolin/url-screw-up
 * Description:     Anonymize an URL
 * Author:          Bego Mario Garde <pixolin@pixolin.de>
 * Author URI:      https://pixolin.de
 * Text Domain:     url-screw-up
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Url_Screw_Up
 */

namespace Pixolin;

defined( 'WPINC' ) || exit;

load_plugin_textdomain( 'url-screw-up', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

add_shortcode( 'urlscrewup', 'Pixolin\shortcode' );
/**
 * Renders form for URL input
 *
 * @return string $out
 */
function shortcode() {
	$out =
	'   <form id="anonymizer">
		<label for="urlanon">' . __( 'Enter URL:', 'url-screw-up' ) . '</label><br />
		<input
			id="urlanon"
			type="url"
			name="urlanon"
			placeholder="https://example.com/path/index.html?message=hello&who=world"
			aria-placeholder="https://example.com"
		/><br />
		<input type="submit" value="' . __( 'Screw up URL', 'url-screw-up' ) . '" class="button"/>
	</form>
	<div id="anonurl"></div>';
	return $out;
}

add_action( 'wp_enqueue_scripts', 'Pixolin\script' );
/**
 * Enqueue JavaScript
 *
 * @return void
 */
function script() {

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_register_style( 'url-screw-up', plugins_url( 'css/url-screw-up' . $suffix . '.css', __FILE__ ), false, '0.1.0' );
	wp_enqueue_style( 'url-screw-up' );
	// Use minified libraries if SCRIPT_DEBUG is turned off.
	wp_register_script(
		'url-screw-up',
		plugins_url( 'js/app' . $suffix . '.js', __FILE__ ),
		array( 'wp-i18n' ),
		'0.1',
		false
	);
	wp_enqueue_script( 'url-screw-up' );

	wp_set_script_translations( 'url-screw-up', 'url-screw-up', plugin_dir_path( __FILE__ ) . '/languages/js' );
}
