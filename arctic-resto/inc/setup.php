<?php
/**
 * ArcticRestoDRY ICE — Theme setup, asset enqueueing & Elementor Kit sync.
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
	add_theme_support( 'custom-logo', [
		'height'      => 64,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
	] );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );

	// Elementor Free & Pro compatibility
	add_theme_support( 'elementor' );
	add_theme_support( 'header-footer-elementor' );

	register_nav_menus( [
		'primary'          => __( 'Primary Navigation', 'arctic-resto' ),
		'footer'           => __( 'Footer Products & Formats', 'arctic-resto' ),
		'footer_solutions' => __( 'Footer Solutions & Safety', 'arctic-resto' ),
		'footer_company'   => __( 'Footer Company & Inquiries', 'arctic-resto' ),
		'legal'            => __( 'Footer Legal Links', 'arctic-resto' ),
	] );

	add_image_size( 'ar-card', 720, 480, true );
	add_image_size( 'ar-hero', 1600, 960, true );
} );

/**
 * Enqueue front-end styles, fonts & scripts.
 */
add_action( 'wp_enqueue_scripts', function () {
	$fonts_url = 'https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@600;700&display=swap';
	wp_enqueue_style( 'ar-fonts', $fonts_url, [], null );

	wp_enqueue_style(
		'ar-theme',
		AR_URI . '/assets/css/theme.css',
		[],
		AR_VERSION
	);

	// Inline CSS variables synced with Customizer & Elementor Global Kit
	$bg      = sanitize_hex_color( ar_opt( 'color_bg' ) ) ?: '#030A14';
	$surface = sanitize_hex_color( ar_opt( 'color_surface' ) ) ?: '#08182C';
	$primary = sanitize_hex_color( ar_opt( 'color_primary' ) ) ?: '#38BDF8';
	$accent  = sanitize_hex_color( ar_opt( 'color_accent' ) ) ?: '#0EA5E9';
	$amber   = sanitize_hex_color( ar_opt( 'color_amber' ) ) ?: '#F59E0B';
	$text    = sanitize_hex_color( ar_opt( 'color_text' ) ) ?: '#F8FAFC';
	$muted   = sanitize_hex_color( ar_opt( 'color_muted' ) ) ?: '#94A3B8';
	$width   = max( 1040, min( 1600, (int) ar_opt( 'container_width', 1320 ) ) );

	$vars = ":root{--ar-bg:{$bg};--ar-surface:{$surface};--ar-primary:{$primary};--ar-accent:{$accent};--ar-amber:{$amber};--ar-text:{$text};--ar-muted:{$muted};--ar-container:{$width}px;}";
	wp_add_inline_style( 'ar-theme', $vars );

	wp_enqueue_script(
		'ar-theme',
		AR_URI . '/assets/js/theme.js',
		[],
		AR_VERSION,
		true
	);

	wp_localize_script( 'ar-theme', 'ArcticResto', [
		'restUrl'      => esc_url_raw( rest_url( 'ar/v1/' ) ),
		'nonce'        => wp_create_nonce( 'wp_rest' ),
		'formNonce'    => wp_create_nonce( 'ar_form_submit' ),
		'siteUrl'      => esc_url_raw( home_url( '/' ) ),
		'brandName'    => (string) ar_opt( 'brand_name', 'ArcticRestoDRY ICE' ),
		'phone'        => (string) ar_contact_display( 'phone' ),
		'quoteUrl'     => esc_url_raw( ar_url( '/contact/#quote' ) ),
		'bulkQuoteUrl' => esc_url_raw( ar_url( '/bulk-orders/#bulk-quote' ) ),
	] );
} );

/**
 * Register Elementor locations if Elementor Pro Theme Builder is active,
 * while remaining 100% compatible with Free Elementor.
 */
add_action( 'elementor/theme/register_locations', function ( $elementor_theme_manager ) {
	if ( is_object( $elementor_theme_manager ) && method_exists( $elementor_theme_manager, 'register_all_core_location' ) ) {
		$elementor_theme_manager->register_all_core_location();
	}
} );

/**
 * Ensure Elementor supports all custom post types and has Flexbox Container enabled.
 */
add_action( 'init', function () {
	$cpt_support = get_option( 'elementor_cpt_support', [ 'page', 'post' ] );
	if ( ! is_array( $cpt_support ) ) {
		$cpt_support = [ 'page', 'post' ];
	}
	$required = [ 'page', 'post', 'ar_product', 'ar_industry', 'ar_service' ];
	$updated  = false;
	foreach ( $required as $cpt ) {
		if ( ! in_array( $cpt, $cpt_support, true ) ) {
			$cpt_support[] = $cpt;
			$updated       = true;
		}
	}
	if ( $updated ) {
		update_option( 'elementor_cpt_support', $cpt_support );
	}
	if ( get_option( 'elementor_experiment-container' ) !== 'active' ) {
		update_option( 'elementor_experiment-container', 'active' );
	}
}, 20 );

/**
 * Sync Elementor Global Kit colors & typography on activation or customizer save.
 */
function ar_sync_elementor_kit(): void {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}
	$kit_id = get_option( 'elementor_active_kit' );
	if ( ! $kit_id ) {
		return;
	}
	$settings = get_post_meta( $kit_id, '_elementor_page_settings', true );
	if ( ! is_array( $settings ) ) {
		$settings = [];
	}
	$settings['system_colors'] = [
		[ '_id' => 'primary',   'title' => 'Cryogenic Ice Blue', 'color' => ar_opt( 'color_primary' ) ],
		[ '_id' => 'secondary', 'title' => 'Deep Cryo Slate',    'color' => ar_opt( 'color_surface' ) ],
		[ '_id' => 'text',      'title' => 'Frost White',        'color' => ar_opt( 'color_text' ) ],
		[ '_id' => 'accent',    'title' => 'Safety Amber',       'color' => ar_opt( 'color_amber' ) ],
	];
	$settings['system_typography'] = [
		[ '_id' => 'primary',   'title' => 'Display Heading', 'typography_typography' => 'custom', 'typography_font_family' => 'Space Grotesk', 'typography_font_weight' => '700' ],
		[ '_id' => 'secondary', 'title' => 'Section Title',   'typography_typography' => 'custom', 'typography_font_family' => 'Space Grotesk', 'typography_font_weight' => '600' ],
		[ '_id' => 'text',      'title' => 'Body Copy',       'typography_typography' => 'custom', 'typography_font_family' => 'Plus Jakarta Sans', 'typography_font_weight' => '400' ],
		[ '_id' => 'accent',    'title' => 'Technical Mono',  'typography_typography' => 'custom', 'typography_font_family' => 'JetBrains Mono', 'typography_font_weight' => '600' ],
	];
	$settings['container_width'] = [
		'unit'  => 'px',
		'size'  => (int) ar_opt( 'container_width', 1320 ),
		'sizes' => [],
	];
	update_post_meta( $kit_id, '_elementor_page_settings', $settings );
}
add_action( 'customize_save_after', 'ar_sync_elementor_kit' );
add_action( 'after_switch_theme', 'ar_sync_elementor_kit' );
