<?php
/**
 * ArcticRestoDRY ICE — Core helper functions, SVG icon library & theme option getters.
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default theme mod values.
 * Note: Contact details use explicit admin-configurable placeholders rather than
 * fabricated real-looking phone numbers, street addresses, or emails.
 */
function ar_defaults(): array {
	return [
		// Brand & Identity
		'brand_name'            => 'ArcticRestoDRY ICE',
		'brand_tagline'         => 'Quality Dry Ice. Reliable Supply. Flexible Solutions.',
		'Cleaning_division_url' => 'https://arcticresto.com/',

		// Contact & Dispatch (Admin-configurable placeholders by default)
		'phone'                 => '',
		'phone_raw'             => '',
		'phone_placeholder'     => 'Phone Number — Configure in Customizer → Contact & Dispatch',
		'email'                 => '',
		'email_placeholder'     => 'Sales & Quote Email — Configure in Customizer → Contact & Dispatch',
		'address'               => '',
		'address_placeholder'   => 'Manufacturing & Dispatch Facility Address — Configure in Customizer',
		'hours'                 => '',
		'hours_placeholder'     => 'Operating & Dispatch Hours — Configure in Customizer',
		'urgent_supply_note'    => 'For scheduled recurring deliveries, urgent cold-chain replenishment, or bulk dispatch coordination, submit an inquiry below or configure direct dispatch contact details in Appearance → Customize.',
		'notify_email'          => '',

		// Header & Topbar
		'topbar_enable'         => true,
		'topbar_badge'          => 'DRY ICE MANUFACTURING & SUPPLY',
		'topbar_text'           => 'Pellets, Nuggets & Blocks · Commercial & Bulk Supply · Vented Insulated Packaging',
		'header_cta_label'      => 'Request a Quote',
		'header_cta_url'        => '/contact/#quote',
		'header_sec_label'      => 'Bulk Orders',
		'header_sec_url'        => '/bulk-orders/',

		// Secondary Cross-Promotion (Arctic Resto Mobile Cleaning Division)
		'cross_promo_enable'    => true,
		'cross_promo_badge'     => 'Sister Division · Mobile Dry Ice Blasting Services',
		'cross_promo_heading'   => 'Looking for Professional Dry Ice Cleaning Services Instead of Dry Ice Supply?',
		'cross_promo_body'      => 'ArcticRestoDRY ICE focuses on manufacturing and supplying dry ice pellets, blocks, and nuggets. If your facility needs on-site mobile dry ice blasting, equipment decontamination, or surface restoration, visit Arctic Resto.',
		'cross_promo_btn_label' => 'Visit ArcticResto.com (Dry Ice Cleaning)',
		'cross_promo_url'       => 'https://arcticresto.com/',
		'cross_promo_new_tab'   => true,

		// Design Tokens
		'color_bg'              => '#030A14',
		'color_surface'         => '#08182C',
		'color_primary'         => '#38BDF8',
		'color_accent'          => '#0EA5E9',
		'color_amber'           => '#F59E0B',
		'color_text'            => '#F8FAFC',
		'color_muted'           => '#94A3B8',
		'font_heading'          => 'Space Grotesk',
		'font_body'             => 'Plus Jakarta Sans',
		'font_mono'             => 'JetBrains Mono',
		'container_width'       => 1320,

		// Sticky CTA & Footer
		'enable_sticky_cta'     => true,
		'sticky_cta_label'      => 'Request a Dry Ice Quote',
		'footer_summary'        => 'Dedicated to dependable dry ice manufacturing and commercial supply. We produce dry ice pellets, blocks, and nuggets with disciplined handling, vented insulated packaging, and responsive order coordination.',
		'footer_safety_note'    => 'Safety Reminder: Dry ice is solid carbon dioxide (-78.5°C / -109.3°F). Always handle with insulated cryogenic gloves, use in well-ventilated areas, and never store in airtight containers.',
		'footer_copyright'      => '© {year} ArcticRestoDRY ICE. All rights reserved. Quality Dry Ice. Reliable Supply. Flexible Solutions.',

		// Socials & AI
		'social_linkedin'       => '',
		'social_youtube'        => '',
		'social_facebook'       => '',
		'social_instagram'      => '',
		'ai_endpoint'           => '',
		'ai_api_key'            => '',
		'ai_model'              => 'gpt-4o-mini',
		'ga4_id'                => '',
		'gtm_id'                => '',
	];
}

/**
 * Retrieve theme option with default fallback.
 *
 * @param string $key     Option key.
 * @param mixed  $default Optional override default.
 * @return mixed
 */
function ar_opt( string $key, $default = null ) {
	$defaults = ar_defaults();
	$fallback = $default !== null ? $default : ( $defaults[ $key ] ?? '' );
	$val      = get_theme_mod( 'ar_' . $key, $fallback );
	if ( ( $val === '' || $val === null ) && isset( $defaults[ $key ] ) ) {
		return $defaults[ $key ];
	}
	return $val;
}

/**
 * Check whether a real contact field has been configured in Customizer.
 */
function ar_has_contact_value( string $field ): bool {
	$raw = trim( (string) get_theme_mod( 'ar_' . $field, '' ) );
	return $raw !== '';
}

/**
 * Return either the admin-configured contact value or a clearly marked placeholder.
 */
function ar_contact_display( string $field ): string {
	$raw = trim( (string) get_theme_mod( 'ar_' . $field, '' ) );
	if ( $raw !== '' ) {
		return $raw;
	}
	$defaults = ar_defaults();
	return $defaults[ $field . '_placeholder' ] ?? 'Configure in Appearance → Customize → Contact & Dispatch';
}

/**
 * Resolve internal path or full URL safely.
 */
function ar_url( string $path_or_url ): string {
	$path_or_url = trim( $path_or_url );
	if ( $path_or_url === '' ) {
		return home_url( '/' );
	}
	if ( strpos( $path_or_url, 'http://' ) === 0 || strpos( $path_or_url, 'https://' ) === 0 || strpos( $path_or_url, 'mailto:' ) === 0 || strpos( $path_or_url, 'tel:' ) === 0 || strpos( $path_or_url, '#' ) === 0 ) {
		return $path_or_url;
	}
	return home_url( $path_or_url );
}

/**
 * Sanitize phone for tel: links.
 */
function ar_tel_href( string $phone = '' ): string {
	$raw = $phone ?: (string) get_theme_mod( 'ar_phone', '' );
	$clean = preg_replace( '/[^0-9+]/', '', $raw );
	if ( $clean === '' ) {
		return ar_url( '/contact/#quote' );
	}
	return 'tel:' . $clean;
}

function ar_phone_href( string $phone = '' ): string {
	return ar_tel_href( $phone );
}

/**
 * Inline SVG icon helper (zero external icon font dependency).
 */
function ar_svg( string $name, int $size = 20, string $class = '' ): string {
	$cls   = $class ? ' class="' . esc_attr( $class ) . '"' : '';
	$attrs = sprintf( 'width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"%2$s', $size, $cls );
	$paths = [
		'snowflake'     => '<path d="M12 2v20M17 5l-5 5-5-5M17 19l-5-5-5 5M2 12h20M5 7l5 5-5 5M19 7l-5 5 5 5"/>',
		'shield'        => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>',
		'zap'           => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>',
		'leaf'          => '<path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>',
		'phone'         => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
		'mail'          => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
		'map-pin'       => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
		'clock'         => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
		'arrow-right'   => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
		'external-link' => '<path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/>',
		'check'         => '<polyline points="20 6 9 17 4 12"/>',
		'chevron-down'  => '<path d="m6 9 6 6 6-6"/>',
		'factory'       => '<path d="M2 20a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8l-7 5V8l-7 5V4a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/><path d="M17 18h1"/><path d="M12 18h1"/><path d="M7 18h1"/>',
		'flame'         => '<path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/>',
		'award'         => '<circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>',
		'truck'         => '<path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/>',
		'chart'         => '<line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/>',
		'users'         => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
		'star'          => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" fill="currentColor"/>',
		'sparkles'      => '<path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>',
		'menu'          => '<line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="18" y2="18"/>',
		'close'         => '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
		'compass'       => '<circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>',
		'layers'        => '<polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/>',
		'wrench'        => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>',
		'cube'          => '<path d="m21 16-9 5-9-5V8l9-5 9 5v8z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" x2="12" y1="22.08" y2="12"/>',
		'package'       => '<path d="m16.5 9.4-9-5.19"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/>',
		'thermometer'   => '<path d="M14 4v10.54a4 4 0 1 1-4 0V4a2 2 0 0 1 4 0Z"/>',
		'alert'         => '<path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/>',
		'flask'         => '<path d="M10 2v7.31"/><path d="M14 9.3V1.99"/><path d="M8.5 2h7"/><path d="M14 9.3a6.5 6.5 0 1 1-4 0"/><path d="M5.52 16h12.96"/>',
		'clipboard'     => '<rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/>',
		'wind'          => '<path d="M17.7 7.7a2.5 2.5 0 1 1 1.8 4.3H2"/><path d="M9.6 4.6A2 2 0 1 1 11 8H2"/><path d="M12.6 19.4A2 2 0 1 0 14 16H2"/>',
	];
	$inner = $paths[ $name ] ?? $paths['snowflake'];
	return '<svg ' . $attrs . '>' . $inner . '</svg>';
}

/**
 * Determine if a post is built with Elementor.
 */
function ar_is_elementor( $post_id = null ): bool {
	$post_id = $post_id ?: get_the_ID();
	if ( ! $post_id ) {
		return false;
	}
	return (bool) get_post_meta( $post_id, '_elementor_edit_mode', true );
}

/**
 * Fallback Primary Navigation when no custom menu is assigned yet.
 */
function ar_fallback_menu(): void {
	$items = [
		'Home'        => home_url( '/' ),
		'About Us'    => home_url( '/about-us/' ),
		'Products'    => [
			'url'      => home_url( '/dry-ice-products/' ),
			'children' => [
				'All Dry Ice Products'      => home_url( '/dry-ice-products/' ),
				'Dry Ice Pellets'           => home_url( '/dry-ice-pellets/' ),
				'Dry Ice Blocks & Nuggets'  => home_url( '/dry-ice-blocks-nuggets/' ),
				'Quality & Specifications'  => home_url( '/quality/' ),
			],
		],
		'Manufacturing' => home_url( '/dry-ice-manufacturing/' ),
		'Bulk Orders'   => home_url( '/bulk-orders/' ),
		'Industries & Uses' => [
			'url'      => home_url( '/industries/' ),
			'children' => [
				'Industries We Serve'       => home_url( '/industries/' ),
				'Dry Ice Applications'      => home_url( '/dry-ice-applications/' ),
				'Delivery & Supply Areas'   => home_url( '/delivery-areas/' ),
			],
		],
		'Safety & FAQ' => [
			'url'      => home_url( '/dry-ice-safety/' ),
			'children' => [
				'Dry Ice Safety & Storage'  => home_url( '/dry-ice-safety/' ),
				'Quality & Specifications'  => home_url( '/quality/' ),
				'Frequently Asked Questions' => home_url( '/faq/' ),
				'Blog & Resources'          => home_url( '/blog/' ),
			],
		],
		'Contact'     => home_url( '/contact/' ),
	];
	echo '<ul class="ar-nav__list">';
	foreach ( $items as $label => $target ) {
		if ( is_array( $target ) ) {
			echo '<li class="menu-item menu-item-has-children"><a href="' . esc_url( $target['url'] ) . '">' . esc_html( $label ) . '</a><ul class="sub-menu">';
			foreach ( $target['children'] as $sub_label => $sub_url ) {
				echo '<li class="menu-item"><a href="' . esc_url( $sub_url ) . '">' . esc_html( $sub_label ) . '</a></li>';
			}
			echo '</ul></li>';
		} else {
			echo '<li class="menu-item"><a href="' . esc_url( $target ) . '">' . esc_html( $label ) . '</a></li>';
		}
	}
	echo '</ul>';
}

/**
 * Fallback Footer Menu helper.
 */
function ar_fallback_footer_menu( string $group = 'products' ): void {
	$groups = [
		'products' => [
			'Dry Ice Products Overview' => home_url( '/dry-ice-products/' ),
			'Dry Ice Pellets'           => home_url( '/dry-ice-pellets/' ),
			'Dry Ice Blocks & Nuggets'  => home_url( '/dry-ice-blocks-nuggets/' ),
			'Bulk Dry Ice Orders'       => home_url( '/bulk-orders/' ),
			'Dry Ice Manufacturing'     => home_url( '/dry-ice-manufacturing/' ),
			'Quality & Specifications'  => home_url( '/quality/' ),
		],
		'solutions' => [
			'Industries We Serve'       => home_url( '/industries/' ),
			'Dry Ice Applications'      => home_url( '/dry-ice-applications/' ),
			'Delivery & Supply Areas'   => home_url( '/delivery-areas/' ),
			'Safety, Handling & Storage' => home_url( '/dry-ice-safety/' ),
			'Frequently Asked Questions' => home_url( '/faq/' ),
			'Blog & Technical Guides'   => home_url( '/blog/' ),
		],
		'company' => [
			'About ArcticRestoDRY ICE'  => home_url( '/about-us/' ),
			'Request a Quote / Contact' => home_url( '/contact/' ),
			'Bulk Supply Inquiries'     => home_url( '/bulk-orders/#bulk-quote' ),
			'Service-Area Inquiry'      => home_url( '/delivery-areas/#area-inquiry' ),
			'Privacy Policy'            => home_url( '/privacy-policy/' ),
		],
	];
	$links = $groups[ $group ] ?? $groups['products'];
	echo '<ul class="ar-footer__links">';
	foreach ( $links as $label => $url ) {
		echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
	}
	echo '</ul>';
}
