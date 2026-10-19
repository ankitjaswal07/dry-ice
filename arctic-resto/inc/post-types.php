<?php
/**
 * ArcticRestoDRY ICE — Custom Post Types & Admin Meta Boxes.
 *
 * Registers Dry Ice Products (`ar_product`), Industries (`ar_industry`),
 * Supply Solutions (`ar_service`), and Quote/Supply Leads (`ar_lead`).
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {
	// 1. Dry Ice Products CPT
	register_post_type( 'ar_product', [
		'labels' => [
			'name'               => __( 'Dry Ice Products', 'arctic-resto' ),
			'singular_name'      => __( 'Dry Ice Product', 'arctic-resto' ),
			'add_new_item'       => __( 'Add New Dry Ice Product', 'arctic-resto' ),
			'edit_item'          => __( 'Edit Dry Ice Product', 'arctic-resto' ),
			'view_item'          => __( 'View Dry Ice Product', 'arctic-resto' ),
			'search_items'       => __( 'Search Dry Ice Products', 'arctic-resto' ),
		],
		'public'       => true,
		'has_archive'  => false,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-products',
		'rewrite'      => [ 'slug' => 'product-format', 'with_front' => false ],
		'supports'     => [ 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'custom-fields' ],
	] );

	// 2. Industries Served CPT
	register_post_type( 'ar_industry', [
		'labels' => [
			'name'               => __( 'Industries Served', 'arctic-resto' ),
			'singular_name'      => __( 'Industry', 'arctic-resto' ),
			'add_new_item'       => __( 'Add New Industry', 'arctic-resto' ),
			'edit_item'          => __( 'Edit Industry', 'arctic-resto' ),
		],
		'public'       => true,
		'has_archive'  => false,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-building',
		'rewrite'      => [ 'slug' => 'industry', 'with_front' => false ],
		'supports'     => [ 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'custom-fields' ],
	] );

	// 3. Supply Solutions CPT (backward-compatible ar_service)
	register_post_type( 'ar_service', [
		'labels' => [
			'name'          => __( 'Supply Programs', 'arctic-resto' ),
			'singular_name' => __( 'Supply Program', 'arctic-resto' ),
			'add_new_item'  => __( 'Add New Supply Program', 'arctic-resto' ),
			'edit_item'     => __( 'Edit Supply Program', 'arctic-resto' ),
		],
		'public'       => true,
		'has_archive'  => false,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-clipboard',
		'rewrite'      => [ 'slug' => 'supply-program', 'with_front' => false ],
		'supports'     => [ 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'custom-fields' ],
	] );

	// 4. Quote & Supply Inquiries (Leads CRM)
	register_post_type( 'ar_lead', [
		'labels' => [
			'name'          => __( 'Quote & Supply Inquiries', 'arctic-resto' ),
			'singular_name' => __( 'Quote Inquiry', 'arctic-resto' ),
		],
		'public'       => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-email-alt',
		'supports'     => [ 'title', 'editor', 'custom-fields' ],
		'capabilities' => [ 'create_posts' => 'do_not_allow' ],
		'map_meta_cap' => true,
	] );
} );

/**
 * Meta Boxes for Dry Ice Products, Industries, and Leads.
 */
add_action( 'add_meta_boxes', function () {
	add_meta_box(
		'ar_product_specs',
		__( 'Dry Ice Product Specifications & Packaging (Editable)', 'arctic-resto' ),
		'ar_render_product_metabox',
		'ar_product',
		'normal',
		'high'
	);

	add_meta_box(
		'ar_industry_specs',
		__( 'Industry Cold-Chain & Dry Ice Parameters', 'arctic-resto' ),
		'ar_render_industry_metabox',
		'ar_industry',
		'normal',
		'high'
	);

	add_meta_box(
		'ar_lead_details',
		__( 'Submitted Quote / Supply Inquiry Details', 'arctic-resto' ),
		'ar_render_lead_metabox',
		'ar_lead',
		'normal',
		'high'
	);
} );

function ar_render_product_metabox( WP_Post $post ): void {
	wp_nonce_field( 'ar_save_product_meta', 'ar_product_meta_nonce' );
	$fields = [
		'_ar_prod_badge'        => [ 'Format Classification Badge', 'e.g., EXTRUDED PELLETS · HIGH DENSITY' ],
		'_ar_prod_subtitle'     => [ 'Short Technical Summary', 'e.g., Cylindrical extruded solid CO₂ for rapid cooling, cold-chain packing, and industrial use' ],
		'_ar_prod_sizes'        => [ 'Available Sizes / Dimensions (Placeholder until verified)', 'e.g., Common diameters: 3 mm (1/8") to 16 mm (5/8") — Verify facility die sizes' ],
		'_ar_prod_packaging'    => [ 'Packaging & Container Options', 'e.g., Vented insulated totes, poly-lined cartons, or bulk palletized containers' ],
		'_ar_prod_moq'          => [ 'Minimum Order / Supply Cadence Note', 'e.g., Placeholder: Configure verified minimum order quantity & recurring schedule' ],
		'_ar_prod_applications' => [ 'Typical Use Cases (one per line)', '' ],
		'_ar_prod_handling'     => [ 'Storage & Sublimation Note', 'e.g., Sublimates at -78.5°C (-109.3°F); store in vented insulated containers only' ],
		'_ar_prod_cta_label'    => [ 'Primary Action Label', 'e.g., Request Quote for This Format' ],
		'_ar_prod_cta_url'      => [ 'Product Detail or Quote URL', 'e.g., /dry-ice-pellets/' ],
		'_ar_prod_spec_notice'  => [ 'Specification Verification Notice', 'Demo specification placeholder — confirm exact dimensions, density, and packaging options with dispatch.' ],
	];
	echo '<div style="display:grid;gap:14px;">';
	foreach ( $fields as $meta_key => $info ) {
		$val = get_post_meta( $post->ID, $meta_key, true );
		echo '<div><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html( $info[0] ) . '</label>';
		if ( $meta_key === '_ar_prod_applications' ) {
			echo '<textarea name="' . esc_attr( $meta_key ) . '" rows="4" class="large-text" placeholder="Food processing temperature control&#10;Pharmaceutical cold-chain transport">' . esc_textarea( (string) $val ) . '</textarea>';
		} else {
			echo '<input type="text" name="' . esc_attr( $meta_key ) . '" value="' . esc_attr( (string) $val ) . '" class="large-text" placeholder="' . esc_attr( $info[1] ) . '" />';
		}
		echo '</div>';
	}
	echo '</div>';
}

function ar_render_industry_metabox( WP_Post $post ): void {
	wp_nonce_field( 'ar_save_industry_meta', 'ar_industry_meta_nonce' );
	$fields = [
		'_ar_ind_code'      => 'Sector Code (e.g., SEC-01)',
		'_ar_ind_formats'   => 'Recommended Dry Ice Formats (e.g., Pellets, Nuggets, Cooling Blocks)',
		'_ar_ind_packaging' => 'Typical Packaging Configuration (e.g., Vented Insulated Totes / Poly-Lined Cartons)',
		'_ar_ind_use_cases' => 'Typical Sector Use Cases (one per line)',
		'_ar_ind_planning'  => 'Supply Planning & Delivery Coordination Notes',
		'_ar_ind_safety'    => 'Handling & Compliance Considerations',
		'_ar_ind_icon'      => 'SVG Icon Slug (snowflake, shield, flask, factory, truck, cube, award, package)',
	];
	echo '<div style="display:grid;gap:14px;">';
	foreach ( $fields as $meta_key => $label ) {
		$val = get_post_meta( $post->ID, $meta_key, true );
		echo '<div><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html( $label ) . '</label>';
		if ( $meta_key === '_ar_ind_use_cases' ) {
			echo '<textarea name="' . esc_attr( $meta_key ) . '" rows="4" class="large-text">' . esc_textarea( (string) $val ) . '</textarea>';
		} else {
			echo '<input type="text" name="' . esc_attr( $meta_key ) . '" value="' . esc_attr( (string) $val ) . '" class="large-text" />';
		}
		echo '</div>';
	}
	echo '</div>';
}

function ar_render_lead_metabox( WP_Post $post ): void {
	$keys = [
		'_ar_lead_type'         => 'Inquiry Type',
		'_ar_lead_name'         => 'Contact Name',
		'_ar_lead_company'      => 'Company / Organization',
		'_ar_lead_email'        => 'Email Address',
		'_ar_lead_phone'        => 'Phone Number',
		'_ar_lead_product'      => 'Requested Dry Ice Format',
		'_ar_lead_quantity'     => 'Estimated Quantity',
		'_ar_lead_frequency'    => 'Order Frequency / Schedule',
		'_ar_lead_location'     => 'Delivery Location / ZIP / Region',
		'_ar_lead_date'         => 'Required / Preferred Date',
		'_ar_lead_packaging'    => 'Packaging / Container Preference',
		'_ar_lead_fulfillment'  => 'Delivery vs. Collection Preference',
		'_ar_lead_source'       => 'Source Page URL',
	];
	echo '<table class="widefat striped" style="margin-top:8px;"><tbody>';
	foreach ( $keys as $k => $label ) {
		$val = get_post_meta( $post->ID, $k, true );
		if ( $val !== '' ) {
			echo '<tr><th style="width:240px;font-weight:600;">' . esc_html( $label ) . '</th><td>' . esc_html( (string) $val ) . '</td></tr>';
		}
	}
	echo '</tbody></table>';
}

add_action( 'save_post_ar_product', function ( int $post_id ) {
	if ( ! isset( $_POST['ar_product_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ar_product_meta_nonce'] ) ), 'ar_save_product_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	$keys = [
		'_ar_prod_badge',
		'_ar_prod_subtitle',
		'_ar_prod_sizes',
		'_ar_prod_packaging',
		'_ar_prod_moq',
		'_ar_prod_applications',
		'_ar_prod_handling',
		'_ar_prod_cta_label',
		'_ar_prod_cta_url',
		'_ar_prod_spec_notice',
	];
	foreach ( $keys as $k ) {
		if ( isset( $_POST[ $k ] ) ) {
			$val = $k === '_ar_prod_applications'
				? sanitize_textarea_field( wp_unslash( $_POST[ $k ] ) )
				: sanitize_text_field( wp_unslash( $_POST[ $k ] ) );
			update_post_meta( $post_id, $k, $val );
		}
	}
} );

add_action( 'save_post_ar_industry', function ( int $post_id ) {
	if ( ! isset( $_POST['ar_industry_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ar_industry_meta_nonce'] ) ), 'ar_save_industry_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	$keys = [
		'_ar_ind_code',
		'_ar_ind_formats',
		'_ar_ind_packaging',
		'_ar_ind_use_cases',
		'_ar_ind_planning',
		'_ar_ind_safety',
		'_ar_ind_icon',
	];
	foreach ( $keys as $k ) {
		if ( isset( $_POST[ $k ] ) ) {
			$val = $k === '_ar_ind_use_cases'
				? sanitize_textarea_field( wp_unslash( $_POST[ $k ] ) )
				: sanitize_text_field( wp_unslash( $_POST[ $k ] ) );
			update_post_meta( $post_id, $k, $val );
		}
	}
} );

/**
 * Custom Admin Columns for Quote & Supply Inquiries (`ar_lead`).
 */
add_filter( 'manage_ar_lead_posts_columns', function ( array $cols ): array {
	return [
		'cb'       => $cols['cb'] ?? '<input type="checkbox" />',
		'title'    => __( 'Inquiry Summary', 'arctic-resto' ),
		'type'     => __( 'Inquiry Type', 'arctic-resto' ),
		'company'  => __( 'Company', 'arctic-resto' ),
		'product'  => __( 'Product Format', 'arctic-resto' ),
		'quantity' => __( 'Est. Quantity', 'arctic-resto' ),
		'location' => __( 'Delivery Location', 'arctic-resto' ),
		'date'     => __( 'Submitted', 'arctic-resto' ),
	];
} );

add_action( 'manage_ar_lead_posts_custom_column', function ( string $col, int $post_id ): void {
	switch ( $col ) {
		case 'type':
			echo '<code>' . esc_html( (string) get_post_meta( $post_id, '_ar_lead_type', true ) ?: 'quote' ) . '</code>';
			break;
		case 'company':
			echo esc_html( (string) get_post_meta( $post_id, '_ar_lead_company', true ) ?: '—' );
			break;
		case 'product':
			echo esc_html( (string) get_post_meta( $post_id, '_ar_lead_product', true ) ?: '—' );
			break;
		case 'quantity':
			echo esc_html( (string) get_post_meta( $post_id, '_ar_lead_quantity', true ) ?: '—' );
			break;
		case 'location':
			echo esc_html( (string) get_post_meta( $post_id, '_ar_lead_location', true ) ?: '—' );
			break;
	}
}, 10, 2 );
