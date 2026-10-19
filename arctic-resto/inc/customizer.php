<?php
/**
 * ArcticRestoDRY ICE — WordPress Customizer panels, sections & controls.
 *
 * Allows non-technical admins to manage brand settings, contact placeholders,
 * header/footer CTAs, the Arctic Resto cleaning cross-promotion banner,
 * color tokens, and quote notification email.
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'customize_register', function ( WP_Customize_Manager $wp_customize ) {
	$defaults = ar_defaults();

	$wp_customize->add_panel( 'ar_panel', [
		'title'       => __( 'ArcticRestoDRY ICE Settings', 'arctic-resto' ),
		'description' => __( 'Configure brand details, contact & dispatch info, cross-promotion for Arctic Resto cleaning services, and global design tokens.', 'arctic-resto' ),
		'priority'    => 25,
	] );

	// 1. Brand & Header Settings
	$wp_customize->add_section( 'ar_sec_brand', [
		'title' => __( 'Brand & Header Navigation', 'arctic-resto' ),
		'panel' => 'ar_panel',
	] );

	$brand_fields = [
		'brand_name'        => [ 'Brand Name', 'text' ],
		'brand_tagline'     => [ 'Primary Brand Tagline', 'text' ],
		'topbar_enable'     => [ 'Show Top Information Bar', 'checkbox' ],
		'topbar_badge'      => [ 'Top Bar Badge Text', 'text' ],
		'topbar_text'       => [ 'Top Bar Summary Text', 'text' ],
		'header_cta_label'  => [ 'Primary Header Button Label', 'text' ],
		'header_cta_url'    => [ 'Primary Header Button URL', 'text' ],
		'header_sec_label'  => [ 'Secondary Header Link Label', 'text' ],
		'header_sec_url'    => [ 'Secondary Header Link URL', 'text' ],
		'enable_sticky_cta' => [ 'Enable Floating Quote CTA', 'checkbox' ],
		'sticky_cta_label'  => [ 'Floating Quote CTA Label', 'text' ],
	];

	foreach ( $brand_fields as $key => $cfg ) {
		$wp_customize->add_setting( 'ar_' . $key, [
			'default'           => $defaults[ $key ] ?? '',
			'sanitize_callback' => $cfg[1] === 'checkbox' ? 'rest_sanitize_boolean' : 'sanitize_text_field',
		] );
		$wp_customize->add_control( 'ar_' . $key, [
			'label'   => $cfg[0],
			'section' => 'ar_sec_brand',
			'type'    => $cfg[1],
		] );
	}

	// 2. Contact, Dispatch & Quote Notifications
	$wp_customize->add_section( 'ar_sec_contact', [
		'title'       => __( 'Contact, Dispatch & Quote Routing', 'arctic-resto' ),
		'description' => __( 'Leave fields blank until verified business contact details are ready; the theme automatically displays clear admin-configurable placeholders rather than fictional contact info.', 'arctic-resto' ),
		'panel'       => 'ar_panel',
	] );

	$contact_fields = [
		'phone'               => [ 'Verified Business Phone (leave blank for placeholder)', 'text' ],
		'phone_placeholder'   => [ 'Phone Placeholder Label (when phone is blank)', 'text' ],
		'email'               => [ 'Verified Public Sales/Quote Email (leave blank for placeholder)', 'text' ],
		'email_placeholder'   => [ 'Email Placeholder Label (when email is blank)', 'text' ],
		'address'             => [ 'Verified Facility / Dispatch Address (leave blank for placeholder)', 'textarea' ],
		'address_placeholder' => [ 'Address Placeholder Label (when address is blank)', 'text' ],
		'hours'               => [ 'Verified Operating & Dispatch Hours (leave blank for placeholder)', 'text' ],
		'hours_placeholder'   => [ 'Hours Placeholder Label (when hours are blank)', 'text' ],
		'urgent_supply_note'  => [ 'Urgent / Scheduled Supply Instructions', 'textarea' ],
		'notify_email'        => [ 'Quote Notification Recipient Email (defaults to WP Admin Email)', 'email' ],
	];

	foreach ( $contact_fields as $key => $cfg ) {
		$sanitize = 'sanitize_text_field';
		if ( $cfg[1] === 'textarea' ) {
			$sanitize = 'sanitize_textarea_field';
		} elseif ( $cfg[1] === 'email' ) {
			$sanitize = 'sanitize_email';
		}
		$wp_customize->add_setting( 'ar_' . $key, [
			'default'           => $defaults[ $key ] ?? '',
			'sanitize_callback' => $sanitize,
		] );
		$wp_customize->add_control( 'ar_' . $key, [
			'label'   => $cfg[0],
			'section' => 'ar_sec_contact',
			'type'    => $cfg[1],
		] );
	}

	// 3. Secondary Cross-Promotion (Arctic Resto Cleaning Services)
	$wp_customize->add_section( 'ar_sec_cross_promo', [
		'title'       => __( 'Cross-Promotion: Arctic Resto Cleaning', 'arctic-resto' ),
		'description' => __( 'Configure the secondary promotional callout directing visitors who need mobile dry ice cleaning/blasting services to https://arcticresto.com/.', 'arctic-resto' ),
		'panel'       => 'ar_panel',
	] );

	$promo_fields = [
		'cross_promo_enable'    => [ 'Enable Secondary Cleaning Cross-Promo in Footer & Widget Default', 'checkbox' ],
		'cross_promo_badge'     => [ 'Cross-Promo Badge Text', 'text' ],
		'cross_promo_heading'   => [ 'Cross-Promo Heading', 'text' ],
		'cross_promo_body'      => [ 'Cross-Promo Description', 'textarea' ],
		'cross_promo_btn_label' => [ 'Cross-Promo Button Label', 'text' ],
		'cross_promo_url'       => [ 'Cross-Promo Destination URL', 'url' ],
		'cross_promo_new_tab'   => [ 'Open Link in New Tab', 'checkbox' ],
	];

	foreach ( $promo_fields as $key => $cfg ) {
		$sanitize = 'sanitize_text_field';
		if ( $cfg[1] === 'checkbox' ) {
			$sanitize = 'rest_sanitize_boolean';
		} elseif ( $cfg[1] === 'textarea' ) {
			$sanitize = 'sanitize_textarea_field';
		} elseif ( $cfg[1] === 'url' ) {
			$sanitize = 'esc_url_raw';
		}
		$wp_customize->add_setting( 'ar_' . $key, [
			'default'           => $defaults[ $key ] ?? '',
			'sanitize_callback' => $sanitize,
		] );
		$wp_customize->add_control( 'ar_' . $key, [
			'label'   => $cfg[0],
			'section' => 'ar_sec_cross_promo',
			'type'    => $cfg[1],
		] );
	}

	// 4. Colors & Layout Tokens
	$wp_customize->add_section( 'ar_sec_design', [
		'title' => __( 'Colors & Layout Tokens', 'arctic-resto' ),
		'panel' => 'ar_panel',
	] );

	$colors = [
		'color_bg'      => 'Background Deep Slate',
		'color_surface' => 'Card Surface Slate',
		'color_primary' => 'Primary Cryo Ice Cyan',
		'color_accent'  => 'Secondary Sky Accent',
		'color_amber'   => 'Safety / Warning Amber',
		'color_text'    => 'Primary Text Color',
		'color_muted'   => 'Muted Text Color',
	];

	foreach ( $colors as $key => $label ) {
		$wp_customize->add_setting( 'ar_' . $key, [
			'default'           => $defaults[ $key ],
			'sanitize_callback' => 'sanitize_hex_color',
		] );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ar_' . $key, [
			'label'   => $label,
			'section' => 'ar_sec_design',
		] ) );
	}

	$wp_customize->add_setting( 'ar_container_width', [
		'default'           => $defaults['container_width'],
		'sanitize_callback' => 'absint',
	] );
	$wp_customize->add_control( 'ar_container_width', [
		'label'   => __( 'Max Container Width (px)', 'arctic-resto' ),
		'section' => 'ar_sec_design',
		'type'    => 'number',
	] );

	// 5. Footer & Safety Copy
	$wp_customize->add_section( 'ar_sec_footer', [
		'title' => __( 'Footer & Safety Disclaimers', 'arctic-resto' ),
		'panel' => 'ar_panel',
	] );

	foreach ( [
		'footer_summary'     => [ 'Footer Brand Summary', 'textarea' ],
		'footer_safety_note' => [ 'Footer Dry Ice Safety Reminder', 'textarea' ],
		'footer_copyright'   => [ 'Copyright Notice ({year} auto-replaced)', 'text' ],
		'social_linkedin'    => [ 'LinkedIn URL (optional)', 'url' ],
		'social_youtube'     => [ 'YouTube URL (optional)', 'url' ],
	] as $key => $cfg ) {
		$wp_customize->add_setting( 'ar_' . $key, [
			'default'           => $defaults[ $key ] ?? '',
			'sanitize_callback' => $cfg[1] === 'textarea' ? 'sanitize_textarea_field' : ( $cfg[1] === 'url' ? 'esc_url_raw' : 'sanitize_text_field' ),
		] );
		$wp_customize->add_control( 'ar_' . $key, [
			'label'   => $cfg[0],
			'section' => 'ar_sec_footer',
			'type'    => $cfg[1],
		] );
	}
} );
