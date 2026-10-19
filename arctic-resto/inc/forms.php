<?php
/**
 * ArcticRestoDRY ICE — Quote, Bulk Order, Service-Area & Contact Form Engine.
 *
 * Provides accessible, validated, spam-protected B2B inquiry forms with
 * conditional fields (recurring vs. one-time, delivery vs. collection,
 * product format selection), CRM lead storage (`ar_lead`), and configurable
 * email routing.
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render an ArcticRestoDRY ICE inquiry form.
 *
 * @param string $type 'quote' | 'bulk' | 'service_area' | 'contact' | 'newsletter'
 * @param array  $args Optional overrides (submit_label, default_product, id_prefix, etc.).
 */
function ar_render_form( string $type = 'quote', array $args = [] ): string {
	$uid          = 'ar-form-' . esc_attr( $type ) . '-' . wp_rand( 100, 999 );
	$submit_label = $args['submit_label'] ?? '';
	$def_product  = $args['default_product'] ?? '';

	if ( $submit_label === '' ) {
		$labels = [
			'quote'        => 'Submit Dry Ice Quote Request',
			'bulk'         => 'Submit Bulk & Recurring Supply Inquiry',
			'service_area' => 'Check Delivery & Supply Availability',
			'contact'      => 'Send Inquiry to ArcticRestoDRY ICE',
			'newsletter'   => 'Subscribe',
		];
		$submit_label = $labels[ $type ] ?? 'Submit Request';
	}

	ob_start();

	if ( $type === 'newsletter' ) :
		?>
		<form id="<?php echo esc_attr( $uid ); ?>" class="ar-form ar-form--newsletter" data-ar-form="newsletter" novalidate>
			<input type="hidden" name="form_type" value="newsletter" />
			<input type="hidden" name="source_url" value="<?php echo esc_url( home_url( add_query_arg( [] ) ) ); ?>" />
			<input type="hidden" name="form_ts" value="<?php echo esc_attr( (string) time() ); ?>" />
			<div class="ar-hp" aria-hidden="true">
				<label>Leave this field blank<input type="text" name="website_url" tabindex="-1" autocomplete="off" /></label>
			</div>
			<div class="ar-form__inline">
				<label class="screen-reader-text" for="<?php echo esc_attr( $uid ); ?>-email"><?php esc_html_e( 'Work Email', 'arctic-resto' ); ?></label>
				<input id="<?php echo esc_attr( $uid ); ?>-email" type="email" name="email" required placeholder="<?php esc_attr_e( 'Enter your work email for cold-chain & safety guides…', 'arctic-resto' ); ?>" />
				<button type="submit" class="ar-btn ar-btn--primary"><?php echo esc_html( $submit_label ); ?> <?php echo ar_svg( 'arrow-right', 16 ); ?></button>
			</div>
			<div class="ar-form__status" role="status" aria-live="polite"></div>
		</form>
		<?php
		return ob_get_clean();
	endif;
	?>
	<form id="<?php echo esc_attr( $uid ); ?>" class="ar-form ar-form--<?php echo esc_attr( $type ); ?>" data-ar-form="<?php echo esc_attr( $type ); ?>" novalidate>
		<input type="hidden" name="form_type" value="<?php echo esc_attr( $type ); ?>" />
		<input type="hidden" name="source_url" value="<?php echo esc_url( home_url( add_query_arg( [] ) ) ); ?>" />
		<input type="hidden" name="form_ts" value="<?php echo esc_attr( (string) time() ); ?>" />
		<?php wp_nonce_field( 'ar_form_submit', 'ar_form_nonce', false ); ?>

		<!-- Honeypot spam protection -->
		<div class="ar-hp" aria-hidden="true">
			<label>Do not fill this out if you are human<input type="text" name="website_url" tabindex="-1" autocomplete="off" /></label>
		</div>

		<?php if ( $type === 'contact' || $type === 'quote' ) : ?>
			<div class="ar-form__group ar-form__group--full">
				<label class="ar-form__label" for="<?php echo esc_attr( $uid ); ?>-cat"><?php esc_html_e( 'Inquiry Category *', 'arctic-resto' ); ?></label>
				<div class="ar-form__pills" role="radiogroup" aria-label="<?php esc_attr_e( 'Inquiry Category', 'arctic-resto' ); ?>">
					<label class="ar-pill-choice">
						<input type="radio" name="inquiry_category" value="Product Quote Inquiry" checked />
						<span><?php esc_html_e( 'Dry Ice Product Quote', 'arctic-resto' ); ?></span>
					</label>
					<label class="ar-pill-choice">
						<input type="radio" name="inquiry_category" value="Bulk / Recurring Supply Inquiry" />
						<span><?php esc_html_e( 'Bulk / Recurring Supply Contract', 'arctic-resto' ); ?></span>
					</label>
					<label class="ar-pill-choice">
						<input type="radio" name="inquiry_category" value="Delivery Area / Pickup Inquiry" />
						<span><?php esc_html_e( 'Delivery Area / Pickup Check', 'arctic-resto' ); ?></span>
					</label>
					<label class="ar-pill-choice">
						<input type="radio" name="inquiry_category" value="General Business Inquiry" />
						<span><?php esc_html_e( 'General Business Inquiry', 'arctic-resto' ); ?></span>
					</label>
				</div>
			</div>
		<?php endif; ?>

		<div class="ar-form__grid">
			<div class="ar-form__group">
				<label class="ar-form__label" for="<?php echo esc_attr( $uid ); ?>-name"><?php esc_html_e( 'Full Name *', 'arctic-resto' ); ?></label>
				<input id="<?php echo esc_attr( $uid ); ?>-name" type="text" name="name" required placeholder="<?php esc_attr_e( 'Your full name', 'arctic-resto' ); ?>" autocomplete="name" />
			</div>

			<div class="ar-form__group">
				<label class="ar-form__label" for="<?php echo esc_attr( $uid ); ?>-company"><?php esc_html_e( 'Company / Organization', 'arctic-resto' ); ?><?php echo $type === 'bulk' ? ' *' : ''; ?></label>
				<input id="<?php echo esc_attr( $uid ); ?>-company" type="text" name="company" <?php echo $type === 'bulk' ? 'required' : ''; ?> placeholder="<?php esc_attr_e( 'Company, facility, or institution name', 'arctic-resto' ); ?>" autocomplete="organization" />
			</div>

			<div class="ar-form__group">
				<label class="ar-form__label" for="<?php echo esc_attr( $uid ); ?>-email"><?php esc_html_e( 'Email Address *', 'arctic-resto' ); ?></label>
				<input id="<?php echo esc_attr( $uid ); ?>-email" type="email" name="email" required placeholder="<?php esc_attr_e( 'name@company.com', 'arctic-resto' ); ?>" autocomplete="email" />
			</div>

			<div class="ar-form__group">
				<label class="ar-form__label" for="<?php echo esc_attr( $uid ); ?>-phone"><?php esc_html_e( 'Phone Number *', 'arctic-resto' ); ?></label>
				<input id="<?php echo esc_attr( $uid ); ?>-phone" type="tel" name="phone" required placeholder="<?php esc_attr_e( 'Direct phone for dispatch / quote follow-up', 'arctic-resto' ); ?>" autocomplete="tel" />
			</div>

			<div class="ar-form__group">
				<label class="ar-form__label" for="<?php echo esc_attr( $uid ); ?>-product"><?php esc_html_e( 'Dry Ice Product Format *', 'arctic-resto' ); ?></label>
				<select id="<?php echo esc_attr( $uid ); ?>-product" name="product_type" required data-ar-cond-trigger="product">
					<option value="" <?php selected( $def_product, '' ); ?>><?php esc_html_e( 'Select dry ice format…', 'arctic-resto' ); ?></option>
					<option value="Dry Ice Pellets" <?php selected( $def_product, 'pellets' ); ?>><?php esc_html_e( 'Dry Ice Pellets (High-Density Extruded)', 'arctic-resto' ); ?></option>
					<option value="Dry Ice Blocks" <?php selected( $def_product, 'blocks' ); ?>><?php esc_html_e( 'Dry Ice Blocks (Solid / Slow Sublimation)', 'arctic-resto' ); ?></option>
					<option value="Dry Ice Nuggets" <?php selected( $def_product, 'nuggets' ); ?>><?php esc_html_e( 'Dry Ice Nuggets (Dense Cylindrical Format)', 'arctic-resto' ); ?></option>
					<option value="Mixed Formats (Pellets + Blocks/Nuggets)" <?php selected( $def_product, 'mixed' ); ?>><?php esc_html_e( 'Mixed Formats (Pellets + Blocks / Nuggets)', 'arctic-resto' ); ?></option>
					<option value="Custom / Application-Specific Format" <?php selected( $def_product, 'custom' ); ?>><?php esc_html_e( 'Custom / Application-Specific (Subject to Availability)', 'arctic-resto' ); ?></option>
					<option value="Not Sure — Recommend Format"><?php esc_html_e( 'Not Sure — Need Format Recommendation', 'arctic-resto' ); ?></option>
				</select>
			</div>

			<div class="ar-form__group">
				<label class="ar-form__label" for="<?php echo esc_attr( $uid ); ?>-qty"><?php esc_html_e( 'Estimated Quantity (lbs / kg or totes) *', 'arctic-resto' ); ?></label>
				<input id="<?php echo esc_attr( $uid ); ?>-qty" type="text" name="estimated_quantity" required placeholder="<?php esc_attr_e( 'e.g., 250 lbs, 1,500 lbs, or 2 insulated totes', 'arctic-resto' ); ?>" />
			</div>

			<div class="ar-form__group">
				<label class="ar-form__label" for="<?php echo esc_attr( $uid ); ?>-freq"><?php esc_html_e( 'Order Frequency *', 'arctic-resto' ); ?></label>
				<select id="<?php echo esc_attr( $uid ); ?>-freq" name="order_frequency" required data-ar-cond-source="frequency">
					<option value="One-Time Order"><?php esc_html_e( 'One-Time / Spot Order', 'arctic-resto' ); ?></option>
					<option value="Weekly Recurring Supply" <?php echo $type === 'bulk' ? 'selected' : ''; ?>><?php esc_html_e( 'Weekly Recurring Supply', 'arctic-resto' ); ?></option>
					<option value="Bi-Weekly Recurring Supply"><?php esc_html_e( 'Bi-Weekly Recurring Supply', 'arctic-resto' ); ?></option>
					<option value="Monthly Recurring Supply"><?php esc_html_e( 'Monthly Recurring Supply', 'arctic-resto' ); ?></option>
					<option value="Custom / Multi-Day Schedule"><?php esc_html_e( 'Custom / Multi-Day Delivery Schedule', 'arctic-resto' ); ?></option>
				</select>
			</div>

			<div class="ar-form__group">
				<label class="ar-form__label" for="<?php echo esc_attr( $uid ); ?>-date"><?php esc_html_e( 'Required / Target Start Date', 'arctic-resto' ); ?></label>
				<input id="<?php echo esc_attr( $uid ); ?>-date" type="date" name="required_date" />
			</div>

			<div class="ar-form__group">
				<label class="ar-form__label" for="<?php echo esc_attr( $uid ); ?>-fulfillment"><?php esc_html_e( 'Fulfillment Preference', 'arctic-resto' ); ?></label>
				<select id="<?php echo esc_attr( $uid ); ?>-fulfillment" name="fulfillment_type" data-ar-cond-source="fulfillment">
					<option value="Delivery to Facility / Site"><?php esc_html_e( 'Delivery to Facility / Receiving Dock', 'arctic-resto' ); ?></option>
					<option value="Customer Collection / Pickup"><?php esc_html_e( 'Local Collection / Pickup (Where Available)', 'arctic-resto' ); ?></option>
					<option value="Compare Delivery vs. Pickup"><?php esc_html_e( 'Compare Delivery vs. Collection Options', 'arctic-resto' ); ?></option>
				</select>
			</div>

			<div class="ar-form__group" data-ar-cond-target="location">
				<label class="ar-form__label" for="<?php echo esc_attr( $uid ); ?>-loc"><?php esc_html_e( 'Delivery Location (City, State & ZIP) *', 'arctic-resto' ); ?></label>
				<input id="<?php echo esc_attr( $uid ); ?>-loc" type="text" name="delivery_location" required placeholder="<?php esc_attr_e( 'City, State, and Postal / ZIP Code', 'arctic-resto' ); ?>" />
			</div>

			<div class="ar-form__group ar-form__group--conditional" data-ar-cond-panel="recurring" <?php echo $type === 'bulk' ? '' : 'hidden'; ?>>
				<label class="ar-form__label" for="<?php echo esc_attr( $uid ); ?>-cadence"><?php esc_html_e( 'Preferred Delivery Days / Receiving Window', 'arctic-resto' ); ?></label>
				<input id="<?php echo esc_attr( $uid ); ?>-cadence" type="text" name="recurring_schedule_notes" placeholder="<?php esc_attr_e( 'e.g., Mondays & Thursdays before 9:00 AM, dock door available', 'arctic-resto' ); ?>" />
			</div>

			<div class="ar-form__group">
				<label class="ar-form__label" for="<?php echo esc_attr( $uid ); ?>-pack"><?php esc_html_e( 'Packaging / Insulated Container Preference', 'arctic-resto' ); ?></label>
				<select id="<?php echo esc_attr( $uid ); ?>-pack" name="packaging_preference">
					<option value="Recommend Appropriate Packaging"><?php esc_html_e( 'Recommend Appropriate Vented Container', 'arctic-resto' ); ?></option>
					<option value="Insulated Bulk Storage Totes"><?php esc_html_e( 'Insulated Bulk Storage Totes (Commercial)', 'arctic-resto' ); ?></option>
					<option value="Poly-Lined Insulated Cartons / Boxes"><?php esc_html_e( 'Poly-Lined Insulated Cartons / Boxes', 'arctic-resto' ); ?></option>
					<option value="Customer-Supplied Vented Containers"><?php esc_html_e( 'Customer-Supplied Vented Insulated Containers', 'arctic-resto' ); ?></option>
				</select>
			</div>
		</div>

		<div class="ar-form__group ar-form__group--full">
			<label class="ar-form__label" for="<?php echo esc_attr( $uid ); ?>-notes"><?php esc_html_e( 'Application Details, Pellet Size Preference, or Special Handling Notes', 'arctic-resto' ); ?></label>
			<textarea id="<?php echo esc_attr( $uid ); ?>-notes" name="message" rows="4" placeholder="<?php esc_attr_e( 'Describe your application (e.g., food processing temperature control, pharmaceutical cold-chain shipping, shrink-fitting, laboratory storage), preferred pellet diameter or block size, receiving dock access, or questions…', 'arctic-resto' ); ?>"></textarea>
		</div>

		<div class="ar-form__consent">
			<label class="ar-checkbox">
				<input type="checkbox" name="privacy_consent" value="1" required />
				<span>
					<?php
					printf(
						/* translators: %s: Privacy Policy URL */
						wp_kses_post( __( 'I consent to ArcticRestoDRY ICE collecting my contact and order inquiry details to respond to this request in accordance with the <a href="%s">Privacy Policy</a>. I understand dry ice requires vented storage and proper PPE handling.', 'arctic-resto' ) ),
						esc_url( ar_url( '/privacy-policy/' ) )
					);
					?>
				</span>
			</label>
		</div>

		<div class="ar-form__actions">
			<button type="submit" class="ar-btn ar-btn--primary ar-btn--lg">
				<span><?php echo esc_html( $submit_label ); ?></span>
				<?php echo ar_svg( 'arrow-right', 18 ); ?>
			</button>
			<p class="ar-form__micro">
				<?php echo ar_svg( 'shield', 15 ); ?>
				<span><?php esc_html_e( 'Direct B2B quote inquiry · No automated pricing assumptions · Specifications & delivery windows confirmed prior to dispatch.', 'arctic-resto' ); ?></span>
			</p>
		</div>

		<div class="ar-form__status" role="status" aria-live="polite"></div>
	</form>
	<?php
	return ob_get_clean();
}

/**
 * Process incoming Quote, Bulk Order, Service-Area & Contact submissions via REST API.
 */
add_action( 'rest_api_init', function () {
	register_rest_route( 'ar/v1', '/lead', [
		'methods'             => 'POST',
		'permission_callback' => '__return_true',
		'callback'            => 'ar_handle_lead_submission',
	] );
} );

function ar_handle_lead_submission( WP_REST_Request $req ): WP_REST_Response {
	$params = $req->get_params();

	// 1. Honeypot check
	if ( ! empty( $params['website_url'] ) ) {
		return new WP_REST_Response( [
			'ok'      => true,
			'message' => __( 'Thank you. Your inquiry has been logged.', 'arctic-resto' ),
		], 200 );
	}

	$form_type = sanitize_key( $params['form_type'] ?? 'quote' );
	$email     = sanitize_email( $params['email'] ?? '' );

	if ( ! is_email( $email ) ) {
		return new WP_REST_Response( [
			'ok'      => false,
			'message' => __( 'Please enter a valid email address so our supply team can respond.', 'arctic-resto' ),
		], 400 );
	}

	if ( $form_type === 'newsletter' ) {
		$lead_id = wp_insert_post( [
			'post_type'   => 'ar_lead',
			'post_status' => 'publish',
			'post_title'  => sprintf( '[Resource Updates] %s', $email ),
		] );
		if ( $lead_id && ! is_wp_error( $lead_id ) ) {
			update_post_meta( $lead_id, '_ar_lead_type', 'newsletter' );
			update_post_meta( $lead_id, '_ar_lead_email', $email );
		}
		return new WP_REST_Response( [
			'ok'      => true,
			'message' => __( 'You are subscribed to ArcticRestoDRY ICE technical & safety updates.', 'arctic-resto' ),
		], 200 );
	}

	$name        = sanitize_text_field( $params['name'] ?? '' );
	$company     = sanitize_text_field( $params['company'] ?? '' );
	$phone       = sanitize_text_field( $params['phone'] ?? '' );
	$category    = sanitize_text_field( $params['inquiry_category'] ?? ucfirst( $form_type ) );
	$product     = sanitize_text_field( $params['product_type'] ?? 'Unspecified' );
	$quantity    = sanitize_text_field( $params['estimated_quantity'] ?? '' );
	$frequency   = sanitize_text_field( $params['order_frequency'] ?? 'One-Time Order' );
	$location    = sanitize_text_field( $params['delivery_location'] ?? '' );
	$req_date    = sanitize_text_field( $params['required_date'] ?? '' );
	$fulfillment = sanitize_text_field( $params['fulfillment_type'] ?? '' );
	$packaging   = sanitize_text_field( $params['packaging_preference'] ?? '' );
	$cadence     = sanitize_text_field( $params['recurring_schedule_notes'] ?? '' );
	$message     = sanitize_textarea_field( $params['message'] ?? '' );
	$source_url  = esc_url_raw( $params['source_url'] ?? '' );
	$consent     = ! empty( $params['privacy_consent'] );

	if ( $name === '' || $phone === '' ) {
		return new WP_REST_Response( [
			'ok'      => false,
			'message' => __( 'Please provide your full name, email address, and phone number.', 'arctic-resto' ),
		], 400 );
	}

	if ( ! $consent ) {
		return new WP_REST_Response( [
			'ok'      => false,
			'message' => __( 'Please confirm the privacy & dry ice handling acknowledgment to submit your request.', 'arctic-resto' ),
		], 400 );
	}

	$summary_title = sprintf(
		'[%s] %s — %s (%s)',
		strtoupper( $form_type ),
		$company !== '' ? $company : $name,
		$product,
		$quantity !== '' ? $quantity : 'Qty TBD'
	);

	$body_lines = [
		"Inquiry Type: {$category} ({$form_type})",
		"Contact Name: {$name}",
		"Company: {$company}",
		"Email: {$email}",
		"Phone: {$phone}",
		"Product Format: {$product}",
		"Estimated Quantity: {$quantity}",
		"Order Frequency: {$frequency}",
		"Recurring Schedule Notes: {$cadence}",
		"Fulfillment Preference: {$fulfillment}",
		"Delivery Location: {$location}",
		"Required Date: {$req_date}",
		"Packaging Preference: {$packaging}",
		"Source URL: {$source_url}",
		"",
		"Additional Notes / Requirements:",
		$message,
	];

	$lead_id = wp_insert_post( [
		'post_type'    => 'ar_lead',
		'post_status'  => 'publish',
		'post_title'   => $summary_title,
		'post_content' => implode( "\n", $body_lines ),
	] );

	if ( $lead_id && ! is_wp_error( $lead_id ) ) {
		update_post_meta( $lead_id, '_ar_lead_type', $form_type );
		update_post_meta( $lead_id, '_ar_lead_name', $name );
		update_post_meta( $lead_id, '_ar_lead_company', $company );
		update_post_meta( $lead_id, '_ar_lead_email', $email );
		update_post_meta( $lead_id, '_ar_lead_phone', $phone );
		update_post_meta( $lead_id, '_ar_lead_product', $product );
		update_post_meta( $lead_id, '_ar_lead_quantity', $quantity );
		update_post_meta( $lead_id, '_ar_lead_frequency', $frequency );
		update_post_meta( $lead_id, '_ar_lead_location', $location );
		update_post_meta( $lead_id, '_ar_lead_date', $req_date );
		update_post_meta( $lead_id, '_ar_lead_packaging', $packaging );
		update_post_meta( $lead_id, '_ar_lead_fulfillment', $fulfillment );
		update_post_meta( $lead_id, '_ar_lead_source', $source_url );
	}

	// Send notification email to configured recipient (falls back to WP admin email)
	$recipient = sanitize_email( (string) ar_opt( 'notify_email', '' ) );
	if ( ! is_email( $recipient ) ) {
		$recipient = get_option( 'admin_email' );
	}
	if ( is_email( $recipient ) ) {
		$headers = [ 'Reply-To: ' . $name . ' <' . $email . '>' ];
		@wp_mail(
			$recipient,
			'ArcticRestoDRY ICE Inquiry: ' . $summary_title,
			implode( "\n", $body_lines ),
			$headers
		);
	}

	return new WP_REST_Response( [
		'ok'      => true,
		'lead_id' => (int) $lead_id,
		'message' => __( 'Thank you — your dry ice inquiry has been received. Our supply coordination team will review your product format, quantity, and location details and follow up promptly.', 'arctic-resto' ),
	], 200 );
}
