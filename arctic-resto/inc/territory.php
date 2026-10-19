<?php
/**
 * ArcticRestoDRY ICE — Delivery & Supply Coverage System.
 *
 * Repurposes the territory engine into an admin-editable Dry Ice Delivery &
 * Supply Coverage system (`ar_territory`) with location lookup, local pickup
 * notes, bulk route notes, and shipping restriction notices.
 *
 * Important: Demo entries are explicitly marked as editable demo placeholders
 * and never claim unverified geographic coverage or guaranteed same-day/next-day transit.
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {
	register_post_type( 'ar_territory', [
		'labels' => [
			'name'               => __( 'Delivery & Supply Zones', 'arctic-resto' ),
			'singular_name'      => __( 'Delivery Zone', 'arctic-resto' ),
			'add_new_item'       => __( 'Add New Delivery / Supply Zone', 'arctic-resto' ),
			'edit_item'          => __( 'Edit Delivery / Supply Zone', 'arctic-resto' ),
			'all_items'          => __( 'All Delivery Zones', 'arctic-resto' ),
		],
		'public'       => true,
		'has_archive'  => false,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-location-alt',
		'rewrite'      => [ 'slug' => 'delivery-zone', 'with_front' => false ],
		'supports'     => [ 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'custom-fields' ],
	] );
} );

add_action( 'add_meta_boxes', function () {
	add_meta_box(
		'ar_territory_coverage_meta',
		__( 'Delivery & Supply Zone Parameters (Admin-Editable)', 'arctic-resto' ),
		'ar_render_territory_metabox',
		'ar_territory',
		'normal',
		'high'
	);
} );

function ar_render_territory_metabox( WP_Post $post ): void {
	wp_nonce_field( 'ar_save_territory_meta', 'ar_territory_meta_nonce' );
	$status = get_post_meta( $post->ID, '_ar_terr_status', true ) ?: 'placeholder';
	$fields = [
		'_ar_terr_code'         => 'Zone Identifier Code (e.g., ZONE-01 / DEMO-REGIONAL)',
		'_ar_terr_states'       => 'Supported Regions / States / Cities (Editable Placeholder until verified)',
		'_ar_terr_zips'         => 'Supported 3-Digit or 5-Digit ZIP Prefixes (comma-separated, leave blank if unconfirmed)',
		'_ar_terr_pickup'       => 'Local Pickup / Facility Collection Options',
		'_ar_terr_bulk_notes'   => 'Bulk & Recurring Route Delivery Notes',
		'_ar_terr_minimums'     => 'Order Minimums & Container Requirements',
		'_ar_terr_restrictions' => 'Sublimation & Transit Restrictions',
		'_ar_terr_cta_url'      => 'Inquiry Target URL (e.g., /delivery-areas/#area-inquiry)',
	];
	?>
	<div style="display:grid;gap:14px;">
		<div>
			<label style="display:block;font-weight:600;margin-bottom:4px;"><?php esc_html_e( 'Coverage Verification Status', 'arctic-resto' ); ?></label>
			<select name="_ar_terr_status" class="regular-text">
				<option value="placeholder" <?php selected( $status, 'placeholder' ); ?>><?php esc_html_e( 'Editable Demo Placeholder — Contact to Confirm Availability', 'arctic-resto' ); ?></option>
				<option value="active" <?php selected( $status, 'active' ); ?>><?php esc_html_e( 'Verified Active Supply Zone', 'arctic-resto' ); ?></option>
				<option value="scheduled" <?php selected( $status, 'scheduled' ); ?>><?php esc_html_e( 'Scheduled Commercial / Bulk Freight Route', 'arctic-resto' ); ?></option>
				<option value="pickup" <?php selected( $status, 'pickup' ); ?>><?php esc_html_e( 'Customer Pickup / Collection Point', 'arctic-resto' ); ?></option>
			</select>
		</div>
		<?php foreach ( $fields as $k => $label ) : ?>
			<div>
				<label style="display:block;font-weight:600;margin-bottom:4px;"><?php echo esc_html( $label ); ?></label>
				<input type="text" name="<?php echo esc_attr( $k ); ?>" value="<?php echo esc_attr( (string) get_post_meta( $post->ID, $k, true ) ); ?>" class="large-text" />
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

add_action( 'save_post_ar_territory', function ( int $post_id ) {
	if ( ! isset( $_POST['ar_territory_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ar_territory_meta_nonce'] ) ), 'ar_save_territory_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	$keys = [
		'_ar_terr_status',
		'_ar_terr_code',
		'_ar_terr_states',
		'_ar_terr_zips',
		'_ar_terr_pickup',
		'_ar_terr_bulk_notes',
		'_ar_terr_minimums',
		'_ar_terr_restrictions',
		'_ar_terr_cta_url',
	];
	foreach ( $keys as $k ) {
		if ( isset( $_POST[ $k ] ) ) {
			update_post_meta( $post_id, $k, sanitize_text_field( wp_unslash( $_POST[ $k ] ) ) );
		}
	}
} );

/**
 * Retrieve all configured Delivery & Supply Zones with fallback placeholder cards.
 */
function ar_get_delivery_zones( int $limit = -1 ): array {
	$posts = get_posts( [
		'post_type'      => 'ar_territory',
		'posts_per_page' => $limit,
		'post_status'    => 'publish',
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
	] );

	if ( empty( $posts ) ) {
		return [
			[
				'id'           => 0,
				'title'        => 'Local Facility Pickup & Will-Call (Demo Placeholder)',
				'code'         => 'ZONE-PICKUP',
				'status'       => 'placeholder',
				'status_label' => 'Demo Placeholder — Configure in WP Admin',
				'states'       => '[Admin Placeholder: Enter facility city/state in Delivery Zones]',
				'pickup'       => 'Scheduled customer collection in approved vented insulated containers (confirm advance notice requirements).',
				'bulk_notes'   => 'Suitable for commercial accounts collecting pellets, nuggets, or blocks directly from dispatch.',
				'minimums'     => '[Placeholder: Set minimum pickup weight & container deposit policy]',
				'restrictions' => 'Closed passenger vehicles require adequate ventilation during transport; airtight containers are prohibited.',
				'url'          => ar_url( '/delivery-areas/#area-inquiry' ),
			],
			[
				'id'           => 0,
				'title'        => 'Regional Commercial Route Delivery (Demo Placeholder)',
				'code'         => 'ZONE-REGIONAL',
				'status'       => 'placeholder',
				'status_label' => 'Demo Placeholder — Configure in WP Admin',
				'states'       => '[Admin Placeholder: Enter supported cities, counties, or ZIP prefixes]',
				'pickup'       => 'Route delivery or dock drop-off by arrangement.',
				'bulk_notes'   => 'Recurring scheduled deliveries for food processors, laboratories, healthcare facilities, and industrial plants.',
				'minimums'     => '[Placeholder: Set route delivery minimum order quantity]',
				'restrictions' => 'Delivery windows are coordinated around production schedules to minimize sublimation loss in transit.',
				'url'          => ar_url( '/delivery-areas/#area-inquiry' ),
			],
			[
				'id'           => 0,
				'title'        => 'Contract Bulk & Palletized Freight (Demo Placeholder)',
				'code'         => 'ZONE-BULK',
				'status'       => 'placeholder',
				'status_label' => 'Demo Placeholder — Configure in WP Admin',
				'states'       => '[Admin Placeholder: Enter regional freight corridor coverage]',
				'pickup'       => 'Full-tote and multi-tote commercial dispatch.',
				'bulk_notes'   => 'High-volume insulated totes and recurring standing orders tailored to cold-chain and manufacturing operations.',
				'minimums'     => '[Placeholder: Set bulk tote / pallet minimum order quantity]',
				'restrictions'   => 'Transit distance is evaluated against sublimation rate and container insulation rating prior to order confirmation.',
				'url'          => ar_url( '/bulk-orders/#bulk-quote' ),
			],
		];
	}

	$status_labels = [
		'placeholder' => 'Demo Placeholder — Contact to Confirm Coverage',
		'active'      => 'Verified Active Supply Zone',
		'scheduled'   => 'Scheduled Commercial Route',
		'pickup'      => 'Facility Collection Available',
	];

	$out = [];
	foreach ( $posts as $p ) {
		$st = get_post_meta( $p->ID, '_ar_terr_status', true ) ?: 'placeholder';
		$out[] = [
			'id'           => $p->ID,
			'title'        => get_the_title( $p ),
			'excerpt'      => get_the_excerpt( $p ),
			'code'         => get_post_meta( $p->ID, '_ar_terr_code', true ) ?: 'SUPPLY-ZONE',
			'status'       => $st,
			'status_label' => $status_labels[ $st ] ?? $status_labels['placeholder'],
			'states'       => get_post_meta( $p->ID, '_ar_terr_states', true ) ?: '[Admin Placeholder: Specify covered cities/regions in WP Admin → Delivery & Supply Zones]',
			'zips'         => get_post_meta( $p->ID, '_ar_terr_zips', true ),
			'pickup'       => get_post_meta( $p->ID, '_ar_terr_pickup', true ) ?: 'Contact dispatch to confirm local collection procedures.',
			'bulk_notes'   => get_post_meta( $p->ID, '_ar_terr_bulk_notes', true ) ?: 'Recurring and bulk orders coordinated based on volume and container rotation.',
			'minimums'     => get_post_meta( $p->ID, '_ar_terr_minimums', true ) ?: '[Placeholder: Confirm minimum order quantity with sales]',
			'restrictions' => get_post_meta( $p->ID, '_ar_terr_restrictions', true ) ?: 'Transit duration and container insulation must account for natural CO₂ sublimation.',
			'url'          => ar_url( get_post_meta( $p->ID, '_ar_terr_cta_url', true ) ?: '/delivery-areas/#area-inquiry' ),
			'image'        => get_the_post_thumbnail_url( $p->ID, 'ar-card' ),
		];
	}
	return $out;
}

/**
 * REST endpoint `/wp-json/ar/v1/territory-check` for interactive Delivery Area Lookup.
 */
add_action( 'rest_api_init', function () {
	register_rest_route( 'ar/v1', '/territory-check', [
		'methods'             => [ 'GET', 'POST' ],
		'permission_callback' => '__return_true',
		'callback'            => function ( WP_REST_Request $req ) {
			$query = sanitize_text_field( (string) ( $req->get_param( 'zip' ) ?: $req->get_param( 'location' ) ?: '' ) );
			$query = trim( $query );
			if ( $query === '' ) {
				return new WP_REST_Response( [
					'matched' => false,
					'status'  => 'unconfirmed',
					'title'   => 'Enter a City, Region, or Postal / ZIP Code',
					'message' => 'Please enter your delivery location or submit a service-area inquiry so our dispatch team can confirm supply coverage, minimum order requirements, and transit options.',
					'cta_url' => ar_url( '/delivery-areas/#area-inquiry' ),
				], 200 );
			}

			$prefix3 = substr( preg_replace( '/[^0-9]/', '', $query ), 0, 3 );
			$zones   = get_posts( [
				'post_type'      => 'ar_territory',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
			] );

			foreach ( $zones as $zone ) {
				$status = get_post_meta( $zone->ID, '_ar_terr_status', true ) ?: 'placeholder';
				$zips   = (string) get_post_meta( $zone->ID, '_ar_terr_zips', true );
				$states = (string) get_post_meta( $zone->ID, '_ar_terr_states', true );
				$zip_list = array_filter( array_map( 'trim', explode( ',', $zips ) ) );

				$matched_zip   = ( $prefix3 !== '' && in_array( $prefix3, $zip_list, true ) ) || in_array( $query, $zip_list, true );
				$matched_state = $states !== '' && stripos( $states, $query ) !== false && $status !== 'placeholder';

				if ( $matched_zip || $matched_state ) {
					return new WP_REST_Response( [
						'matched'      => true,
						'status'       => $status,
						'title'        => get_the_title( $zone ),
						'code'         => get_post_meta( $zone->ID, '_ar_terr_code', true ),
						'states'       => $states,
						'pickup'       => get_post_meta( $zone->ID, '_ar_terr_pickup', true ),
						'minimums'     => get_post_meta( $zone->ID, '_ar_terr_minimums', true ),
						'restrictions' => get_post_meta( $zone->ID, '_ar_terr_restrictions', true ),
						'message'      => 'Location matches a configured supply zone. Contact our team to confirm current production scheduling, container options, and order minimums for your delivery address.',
						'cta_url'      => ar_url( get_post_meta( $zone->ID, '_ar_terr_cta_url', true ) ?: '/contact/#quote' ),
					], 200 );
				}
			}

			return new WP_REST_Response( [
				'matched' => false,
				'status'  => 'inquiry_required',
				'title'   => 'Coverage Verification Required for "' . esc_html( $query ) . '"',
				'message' => 'Specific route coverage for "' . esc_html( $query ) . '" is not yet listed in our public lookup table. Because dry ice sublimates continuously in transit, we evaluate delivery feasibility based on order volume, insulated packaging format, and transit distance. Please submit the Delivery & Supply Area Inquiry form below to confirm availability or collection options.',
				'cta_url' => ar_url( '/delivery-areas/#area-inquiry' ),
			], 200 );
		},
	] );
} );
