<?php
/**
 * ArcticRestoDRY ICE — Elementor Integration & Custom Widget Registry.
 *
 * Registers the `arctic-resto` widget category and 34 custom Elementor widgets
 * built for Dry Ice Manufacturing, Products, Bulk Supply, Cold-Chain Industries,
 * Safety Guidance, and Quote Conversion — 100% compatible with Free Elementor.
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'elementor/elements/categories_registered', function ( $elements_manager ) {
	$elements_manager->add_category( 'arctic-resto', [
		'title' => __( 'ArcticRestoDRY ICE Supply Widgets', 'arctic-resto' ),
		'icon'  => 'eicon-snowflake',
	] );
} );

add_action( 'elementor/widgets/register', function ( $widgets_manager ) {
	$dir   = AR_DIR . '/inc/elementor/';
	$files = [
		'class-base.php',
		'widgets-hero.php',
		'widgets-blocks.php',
		'widgets-dynamic.php',
		'widgets-interactive.php',
		'widgets-forms.php',
		'widgets-seo.php',
		'widgets-territory.php',
		'widgets-extra.php',
		'widgets-dryice.php',
	];

	foreach ( $files as $file ) {
		if ( file_exists( $dir . $file ) ) {
			require_once $dir . $file;
		}
	}

	$classes = [
		// Hero, Stats, Process, CTA
		'\ArcticResto\Elementor\W_Hero',
		'\ArcticResto\Elementor\W_Stats',
		'\ArcticResto\Elementor\W_Process',
		'\ArcticResto\Elementor\W_Cta',
		// Content Blocks
		'\ArcticResto\Elementor\W_Bento',
		'\ArcticResto\Elementor\W_Comparison',
		'\ArcticResto\Elementor\W_Faq',
		'\ArcticResto\Elementor\W_Pricing',
		'\ArcticResto\Elementor\W_Logos',
		// Dynamic CPT Grids
		'\ArcticResto\Elementor\W_Services',
		'\ArcticResto\Elementor\W_Cases',
		'\ArcticResto\Elementor\W_Testimonials',
		'\ArcticResto\Elementor\W_Posts',
		// Interactive Calculators & Visuals
		'\ArcticResto\Elementor\W_BeforeAfter',
		'\ArcticResto\Elementor\W_Roi',
		'\ArcticResto\Elementor\W_FranchiseCalc',
		'\ArcticResto\Elementor\W_AiAssist',
		// Forms
		'\ArcticResto\Elementor\W_LeadForm',
		// SEO & Navigation Helpers
		'\ArcticResto\Elementor\W_Breadcrumbs',
		'\ArcticResto\Elementor\W_AuthorBox',
		'\ArcticResto\Elementor\W_SpecSheet',
		'\ArcticResto\Elementor\W_StickyCta',
		// Delivery & Supply Area Coverage
		'\ArcticResto\Elementor\W_TerritoryChecker',
		'\ArcticResto\Elementor\W_TerritoryGrid',
		'\ArcticResto\Elementor\W_TerritoryHero',
		// Extra Structural Widgets
		'\ArcticResto\Elementor\W_Timeline',
		'\ArcticResto\Elementor\W_CertStrip',
		'\ArcticResto\Elementor\W_VideoModal',
		'\ArcticResto\Elementor\W_Hotspots',
		// Dedicated Dry Ice Manufacturing & Supply Widgets
		'\ArcticResto\Elementor\W_Products',
		'\ArcticResto\Elementor\W_SpecTable',
		'\ArcticResto\Elementor\W_Industries',
		'\ArcticResto\Elementor\W_SafetyNotice',
		'\ArcticResto\Elementor\W_CrossPromo',
	];

	foreach ( $classes as $cls ) {
		if ( class_exists( $cls ) ) {
			$widgets_manager->register( new $cls() );
		}
	}
} );
