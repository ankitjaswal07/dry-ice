<?php
/**
 * ArcticRestoDRY ICE — /llms.txt Discovery Endpoint & Technical Supply Assistant.
 *
 * Ensures AI search engines and discovery crawlers receive accurate, truthful
 * information about ArcticRestoDRY ICE (dry ice manufacturing, products, bulk
 * supply, cold-chain applications, and safety) while directing mobile dry ice
 * cleaning inquiries to https://arcticresto.com/.
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Serve `/llms.txt` with truthful ArcticRestoDRY ICE documentation.
 */
add_action( 'init', function () {
	add_rewrite_rule( '^llms\.txt$', 'index.php?ar_llms_txt=1', 'top' );
} );

add_filter( 'query_vars', function ( array $vars ): array {
	$vars[] = 'ar_llms_txt';
	return $vars;
} );

add_action( 'template_redirect', function () {
	$req_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	$path    = wp_parse_url( $req_uri, PHP_URL_PATH );
	if ( ! get_query_var( 'ar_llms_txt' ) && $path !== '/llms.txt' ) {
		return;
	}

	status_header( 200 );
	header( 'Content-Type: text/plain; charset=utf-8' );
	header( 'X-Robots-Tag: index, follow' );

	$brand   = (string) ar_opt( 'brand_name', 'ArcticRestoDRY ICE' );
	$tagline = (string) ar_opt( 'brand_tagline', 'Quality Dry Ice. Reliable Supply. Flexible Solutions.' );
	$site    = home_url( '/' );

	echo "# {$brand}\n\n";
	echo "> {$tagline}\n\n";
	echo "{$brand} is a dry ice manufacturing and commercial supply business providing solid carbon dioxide (CO₂) in extruded pellets, dense nuggets, and solid cooling blocks for commercial, industrial, food processing, pharmaceutical, healthcare, laboratory, and cold-chain logistics buyers.\n\n";
	echo "## Core Dry Ice Products & Capabilities\n";
	echo "- [Dry Ice Products Overview]({$site}dry-ice-products/): Extruded pellets, solid blocks, dense nuggets, and custom format options.\n";
	echo "- [Dry Ice Pellets]({$site}dry-ice-pellets/): Cylindrical extruded dry ice pellets for rapid cooling, cold-chain shipping, food temperature control, and industrial blast media supply.\n";
	echo "- [Dry Ice Blocks & Nuggets]({$site}dry-ice-blocks-nuggets/): High-density solid blocks and nuggets for prolonged cooling duration and reduced sublimation rate.\n";
	echo "- [Dry Ice Manufacturing Process]({$site}dry-ice-manufacturing/): Liquid CO₂ expansion, snow formation, hydraulic compression/extrusion, sizing, and vented insulated packaging.\n";
	echo "- [Bulk Dry Ice Orders & Recurring Supply]({$site}bulk-orders/): Scheduled recurring supply programs, commercial tote rotation, and palletized bulk orders.\n";
	echo "- [Industries We Serve]({$site}industries/): Food processing, pharmaceuticals & life sciences, healthcare & laboratories, manufacturing, automotive engineering, and cold-chain shipping.\n";
	echo "- [Dry Ice Applications]({$site}dry-ice-applications/): Process cooling, biological specimen transport, shrink-fitting, and perishable logistics.\n";
	echo "- [Delivery & Supply Areas]({$site}delivery-areas/): Regional route delivery inquiries, local collection options, and transit planning.\n";
	echo "- [Dry Ice Safety, Handling & Storage]({$site}dry-ice-safety/): Essential PPE, CO₂ ventilation rules, sublimation awareness (-78.5°C / -109.3°F), and vented container requirements.\n";
	echo "- [Quality & Product Specifications]({$site}quality/): Format specifications, packaging integrity, and technical documentation requests.\n";
	echo "- [Frequently Asked Questions]({$site}faq/): Answers on pellets vs. blocks, sublimation, ordering, storage, and safe handling.\n";
	echo "- [Request a Quote / Contact]({$site}contact/): Submit product, bulk supply, or delivery coverage inquiries.\n\n";
	echo "## Looking for Mobile Dry Ice Cleaning Services?\n";
	echo "- For on-site professional mobile dry ice blasting and surface restoration services (rather than dry ice supply), visit our sister division: [Arctic Resto Cleaning Services](https://arcticresto.com/).\n";
	exit;
} );

/**
 * REST endpoint `/wp-json/ar/v1/ai-assist` for on-site Dry Ice Supply & Safety Q&A.
 */
add_action( 'rest_api_init', function () {
	register_rest_route( 'ar/v1', '/ai-assist', [
		'methods'             => 'POST',
		'permission_callback' => '__return_true',
		'callback'            => function ( WP_REST_Request $req ): WP_REST_Response {
			$q = strtolower( sanitize_text_field( (string) $req->get_param( 'prompt' ) ) );

			$reply = 'ArcticRestoDRY ICE manufactures and supplies dry ice pellets, blocks, and nuggets for commercial, industrial, and cold-chain applications. Use our Quote Request form to confirm format specifications, packaging options, and delivery availability for your location.';
			if ( strpos( $q, 'pellet' ) !== false || strpos( $q, 'block' ) !== false || strpos( $q, 'nugget' ) !== false ) {
				$reply = 'Dry ice pellets offer high surface-area-to-volume ratio for rapid cooling, pack-around cold-chain shipping, and blast media supply. Dry ice blocks and dense nuggets have lower exposed surface area per pound, so they sublimate more slowly and are ideal for extended transit or prolonged cooling.';
			} elseif ( strpos( $q, 'safe' ) !== false || strpos( $q, 'store' ) !== false || strpos( $q, 'container' ) !== false || strpos( $q, 'sublimat' ) !== false ) {
				$reply = 'Dry ice is solid carbon dioxide at -78.5°C (-109.3°F) and sublimates directly into CO₂ gas (roughly 5–10% per 24 hours in standard insulated containers). Always wear insulated cryogenic gloves and eye protection, ensure adequate room/vehicle ventilation, and store ONLY in vented insulated containers — never in airtight vessels or standard walk-in freezers.';
			} elseif ( strpos( $q, 'clean' ) !== false || strpos( $q, 'service' ) !== false || strpos( $q, 'resto' ) !== false ) {
				$reply = 'ArcticRestoDRY ICE supplies dry ice products (pellets, blocks, and nuggets). If you need a mobile crew to perform on-site dry ice cleaning or surface restoration, visit our sister service division at https://arcticresto.com/.';
			} elseif ( strpos( $q, 'bulk' ) !== false || strpos( $q, 'order' ) !== false || strpos( $q, 'quote' ) !== false || strpos( $q, 'deliver' ) !== false ) {
				$reply = 'You can request one-time or recurring bulk dry ice supply via our Bulk Orders or Request a Quote pages. Provide your preferred format (pellets, blocks, or nuggets), estimated weight, delivery location, and schedule so our dispatch team can confirm availability.';
			}

			return new WP_REST_Response( [
				'ok'       => true,
				'response' => $reply,
			], 200 );
		},
	] );
} );
