<?php
/**
 * ArcticRestoDRY ICE — Technical SEO, Meta Tags, OpenGraph & Truthful JSON-LD Schema.
 *
 * Emits clean Organization, WebSite, WebPage, BreadcrumbList, Article, and
 * truthful Product / FAQPage schema. Never outputs fabricated AggregateRating,
 * Review, price, or stock availability data.
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Per-page curated meta descriptions for core ArcticRestoDRY ICE pages
 * (overridable via post excerpt or custom field `_ar_meta_description`).
 */
function ar_get_meta_description(): string {
	if ( is_singular() ) {
		$post_id = get_the_ID();
		$custom  = trim( (string) get_post_meta( $post_id, '_ar_meta_description', true ) );
		if ( $custom !== '' ) {
			return $custom;
		}
		if ( has_excerpt( $post_id ) ) {
			return wp_strip_all_tags( get_the_excerpt( $post_id ) );
		}
		$slug = get_post_field( 'post_name', $post_id );
		$map  = [
			'home'                   => 'ArcticRestoDRY ICE manufactures and supplies dry ice pellets, blocks, and nuggets for commercial, industrial, food processing, pharmaceutical, and cold-chain applications.',
			'about-us'               => 'Learn about ArcticRestoDRY ICE — our focus on dependable dry ice manufacturing, consistent pellet and block quality, disciplined handling, and customer-first supply coordination.',
			'dry-ice-manufacturing'  => 'Explore how ArcticRestoDRY ICE produces solid CO₂ pellets, blocks, and nuggets through controlled liquid CO₂ expansion, compression, sizing, and insulated packaging.',
			'dry-ice-products'       => 'Compare dry ice pellets, solid dry ice blocks, high-density nuggets, and custom format options supplied in vented insulated containers.',
			'dry-ice-pellets'        => 'High-density extruded dry ice pellets for food processing, pharmaceutical cold-chain shipping, research laboratories, and industrial blast/cooling applications.',
			'dry-ice-blocks-nuggets' => 'Solid dry ice blocks and dense nuggets engineered for extended cooling duration, cold-chain transport, airline catering, and industrial process cooling.',
			'bulk-orders'            => 'Request bulk dry ice supply, standing recurring deliveries, commercial tote rotation programs, and multi-pallet orders from ArcticRestoDRY ICE.',
			'industries'             => 'Dry ice supply solutions for food processing, pharmaceuticals, healthcare, laboratories, manufacturing, automotive engineering, and cold-chain logistics.',
			'dry-ice-applications'   => 'Technical guide to dry ice applications: cold-chain shipping, food temperature control, biological sample transport, shrink-fitting, and industrial cooling.',
			'delivery-areas'         => 'Check dry ice delivery coverage, local collection options, recurring commercial route availability, and order minimum guidelines.',
			'dry-ice-safety'         => 'Essential dry ice safety, handling, PPE, ventilation, and storage guide. Learn why solid CO₂ (-78.5°C / -109.3°F) requires vented insulated containers.',
			'quality'                => 'Dry ice product specifications, density, sublimation management, packaging integrity, and technical documentation request center.',
			'faq'                    => 'Frequently asked questions about dry ice pellets vs. blocks, sublimation rates, safe handling, storage containers, minimum orders, and bulk supply.',
			'contact'                => 'Request a dry ice quote, schedule recurring bulk supply, verify delivery coverage, or contact the ArcticRestoDRY ICE coordination team.',
			'blog'                   => 'Technical articles and buyer guides on dry ice manufacturing, sublimation management, cold-chain packaging, and safe handling practices.',
			'privacy-policy'         => 'Privacy policy for ArcticRestoDRY ICE explaining how quote, bulk order, and contact inquiry data is collected, used, and protected.',
		];
		if ( isset( $map[ $slug ] ) ) {
			return $map[ $slug ];
		}
		$content = wp_strip_all_tags( get_post_field( 'post_content', $post_id ) );
		if ( $content !== '' ) {
			return wp_trim_words( $content, 26, '…' );
		}
	}
	return (string) ar_opt( 'brand_tagline', 'Quality Dry Ice. Reliable Supply. Flexible Solutions.' );
}

/**
 * Add meta box for custom SEO title & meta description on pages/posts/CPTs.
 */
add_action( 'add_meta_boxes', function () {
	foreach ( [ 'page', 'post', 'ar_product', 'ar_industry' ] as $screen ) {
		add_meta_box(
			'ar_seo_meta',
			__( 'SEO Title & Meta Description (ArcticRestoDRY ICE)', 'arctic-resto' ),
			function ( WP_Post $post ) {
				wp_nonce_field( 'ar_save_seo_meta', 'ar_seo_nonce' );
				$title = get_post_meta( $post->ID, '_ar_meta_title', true );
				$desc  = get_post_meta( $post->ID, '_ar_meta_description', true );
				?>
				<p>
					<label style="display:block;font-weight:600;margin-bottom:4px;"><?php esc_html_e( 'Custom Document Title (optional)', 'arctic-resto' ); ?></label>
					<input type="text" name="_ar_meta_title" value="<?php echo esc_attr( (string) $title ); ?>" class="large-text" placeholder="<?php echo esc_attr( get_the_title( $post ) . ' | ArcticRestoDRY ICE' ); ?>" />
				</p>
				<p>
					<label style="display:block;font-weight:600;margin-bottom:4px;"><?php esc_html_e( 'Custom Meta Description (optional)', 'arctic-resto' ); ?></label>
					<textarea name="_ar_meta_description" rows="2" class="large-text"><?php echo esc_textarea( (string) $desc ); ?></textarea>
				</p>
				<?php
			},
			$screen,
			'normal',
			'default'
		);
	}
} );

add_action( 'save_post', function ( int $post_id ) {
	if ( ! isset( $_POST['ar_seo_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ar_seo_nonce'] ) ), 'ar_save_seo_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( isset( $_POST['_ar_meta_title'] ) ) {
		update_post_meta( $post_id, '_ar_meta_title', sanitize_text_field( wp_unslash( $_POST['_ar_meta_title'] ) ) );
	}
	if ( isset( $_POST['_ar_meta_description'] ) ) {
		update_post_meta( $post_id, '_ar_meta_description', sanitize_textarea_field( wp_unslash( $_POST['_ar_meta_description'] ) ) );
	}
} );

add_filter( 'pre_get_document_title', function ( string $title ): string {
	if ( is_singular() ) {
		$custom = trim( (string) get_post_meta( get_the_ID(), '_ar_meta_title', true ) );
		if ( $custom !== '' ) {
			return $custom;
		}
	}
	if ( is_front_page() ) {
		return ar_opt( 'brand_name', 'ArcticRestoDRY ICE' ) . ' | ' . ar_opt( 'brand_tagline', 'Quality Dry Ice. Reliable Supply. Flexible Solutions.' );
	}
	return $title;
} );

/**
 * Output meta description, canonical, OpenGraph, and truthful JSON-LD schema.
 */
add_action( 'wp_head', function () {
	// Skip if a dedicated SEO plugin is handling meta tags
	if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) ) {
		return;
	}

	$brand = (string) ar_opt( 'brand_name', 'ArcticRestoDRY ICE' );
	$desc  = ar_get_meta_description();
	$url   = is_front_page() ? home_url( '/' ) : get_permalink();
	$title = wp_get_document_title();
	$img   = is_singular() && has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'large' ) : ( AR_URI . '/assets/images/hero-manufacturing.jpg' );

	echo "\n<!-- ArcticRestoDRY ICE SEO & Schema -->\n";
	echo '<meta name="description" content="' . esc_attr( $desc ) . '" />' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( $brand ) . '" />' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '" />' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $desc ) . '" />' . "\n";
	echo '<meta property="og:type" content="' . ( is_singular( 'post' ) ? 'article' : 'website' ) . '" />' . "\n";
	if ( $url ) {
		echo '<meta property="og:url" content="' . esc_url( $url ) . '" />' . "\n";
	}
	if ( $img ) {
		echo '<meta property="og:image" content="' . esc_url( $img ) . '" />' . "\n";
	}
	echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";

	$graph = [];

	// 1. Organization (Truthful — only includes phone/email/address if admin has configured them)
	$org = [
		'@type'       => 'Organization',
		'@id'         => home_url( '/#organization' ),
		'name'        => $brand,
		'url'         => home_url( '/' ),
		'slogan'      => (string) ar_opt( 'brand_tagline', 'Quality Dry Ice. Reliable Supply. Flexible Solutions.' ),
		'description' => 'Dry ice manufacturing and commercial supply business providing dry ice pellets, blocks, nuggets, and bulk cold-chain solutions.',
	];
	if ( ar_has_contact_value( 'phone' ) ) {
		$org['telephone'] = (string) get_theme_mod( 'ar_phone' );
	}
	if ( ar_has_contact_value( 'email' ) ) {
		$org['email'] = (string) get_theme_mod( 'ar_email' );
	}
	$graph[] = $org;

	// 2. WebSite
	$graph[] = [
		'@type'     => 'WebSite',
		'@id'       => home_url( '/#website' ),
		'url'       => home_url( '/' ),
		'name'      => $brand,
		'publisher' => [ '@id' => home_url( '/#organization' ) ],
	];

	// 3. WebPage & BreadcrumbList
	if ( is_singular() || is_front_page() ) {
		$page_id  = get_queried_object_id();
		$page_url = is_front_page() ? home_url( '/' ) : get_permalink( $page_id );
		$graph[]  = [
			'@type'       => 'WebPage',
			'@id'         => $page_url . '#webpage',
			'url'         => $page_url,
			'name'        => $title,
			'description' => $desc,
			'isPartOf'    => [ '@id' => home_url( '/#website' ) ],
			'about'       => [ '@id' => home_url( '/#organization' ) ],
		];

		$crumbs = [
			[
				'@type'    => 'ListItem',
				'position' => 1,
				'name'     => 'Home',
				'item'     => home_url( '/' ),
			],
		];
		if ( ! is_front_page() && $page_id ) {
			$crumbs[] = [
				'@type'    => 'ListItem',
				'position' => 2,
				'name'     => get_the_title( $page_id ),
				'item'     => $page_url,
			];
		}
		$graph[] = [
			'@type'           => 'BreadcrumbList',
			'@id'             => $page_url . '#breadcrumbs',
			'itemListElement' => $crumbs,
		];
	}

	// 4. Article Schema on Single Blog Posts
	if ( is_singular( 'post' ) ) {
		$post_id = get_the_ID();
		$graph[] = [
			'@type'            => 'Article',
			'@id'              => get_permalink( $post_id ) . '#article',
			'headline'         => get_the_title( $post_id ),
			'description'      => $desc,
			'datePublished'    => get_the_date( 'c', $post_id ),
			'dateModified'     => get_the_modified_date( 'c', $post_id ),
			'author'           => [ '@id' => home_url( '/#organization' ) ],
			'publisher'        => [ '@id' => home_url( '/#organization' ) ],
			'mainEntityOfPage' => get_permalink( $post_id ) . '#webpage',
		];
	}

	// 5. Truthful Product Schema (No fabricated price, rating, or stock status)
	if ( is_singular( 'ar_product' ) || is_page( [ 'dry-ice-pellets', 'dry-ice-blocks-nuggets' ] ) ) {
		$post_id = get_the_ID();
		$graph[] = [
			'@type'       => 'Product',
			'@id'         => get_permalink( $post_id ) . '#product',
			'name'        => get_the_title( $post_id ),
			'description' => $desc,
			'brand'       => [
				'@type' => 'Brand',
				'name'  => $brand,
			],
			'manufacturer' => [ '@id' => home_url( '/#organization' ) ],
			'category'     => 'Dry Ice / Solid Carbon Dioxide (CO₂)',
		];
	}

	$schema = [
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	];

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
}, 5 );
