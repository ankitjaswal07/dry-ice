<?php
/**
 * Performance & hardening.
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Strip needless head output */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'the_generator', '__return_empty_string' );

/* Drop jQuery Migrate on the front end */
add_action(
	'wp_default_scripts',
	function ( $scripts ) {
		if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
			$scripts->registered['jquery']->deps = array_diff( $scripts->registered['jquery']->deps, array( 'jquery-migrate' ) );
		}
	}
);

/* Skip Gutenberg CSS on pages that are built with Elementor */
add_action(
	'wp_enqueue_scripts',
	function () {
		if ( is_singular() && ar_is_elementor( get_queried_object_id() ) ) {
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'wp-block-library-theme' );
			wp_dequeue_style( 'global-styles' );
			wp_dequeue_style( 'classic-theme-styles' );
		}
	},
	100
);

/* The theme loads its own fonts; stop Elementor loading a second copy */
add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );

/* Image loading hints */
add_filter(
	'wp_get_attachment_image_attributes',
	function ( $attr ) {
		if ( empty( $attr['decoding'] ) ) {
			$attr['decoding'] = 'async';
		}
		return $attr;
	}
);

/* Security headers */
add_action(
	'send_headers',
	function () {
		if ( is_admin() ) {
			return;
		}
		header( 'X-Content-Type-Options: nosniff' );
		header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	}
);

/* Tidy the author enumeration vector */
add_action(
	'template_redirect',
	function () {
		if ( is_author() && ! is_user_logged_in() ) {
			wp_safe_redirect( home_url( '/' ), 301 );
			exit;
		}
	}
);
