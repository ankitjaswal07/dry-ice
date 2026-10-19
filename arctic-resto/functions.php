<?php
/**
 * ArcticRestoDRY ICE — Theme bootstrap.
 *
 * Industrial dry ice manufacturing, product supply, bulk distribution,
 * and Elementor page builder platform.
 *
 * @package ArcticResto
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AR_VERSION', '2.0.0' );
define( 'AR_DIR', get_template_directory() );
define( 'AR_URI', get_template_directory_uri() );

if ( ! function_exists( 'is_plugin_active' ) && file_exists( ABSPATH . 'wp-admin/includes/plugin.php' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

$ar_includes = [
	'inc/helpers.php',
	'inc/setup.php',
	'inc/optimize.php',
	'inc/post-types.php',
	'inc/customizer.php',
	'inc/portal.php',
	'inc/territory.php',
	'inc/seo.php',
	'inc/ai.php',
	'inc/forms.php',
	'inc/elementor.php',
	'inc/demo-importer.php',
];

foreach ( $ar_includes as $ar_file ) {
	$ar_path = AR_DIR . '/' . $ar_file;
	if ( file_exists( $ar_path ) ) {
		require_once $ar_path;
	}
}
