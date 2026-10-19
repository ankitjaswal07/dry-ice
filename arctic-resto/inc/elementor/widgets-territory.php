<?php
/**
 * ArcticRestoDRY ICE — Delivery & Supply Area Coverage Widgets.
 *
 * Repurposes the territory widgets into an admin-editable Dry Ice Delivery &
 * Supply Coverage system (`ar_territory_checker`, `ar_territory_grid`,
 * `ar_territory_hero`).
 *
 * @package ArcticResto
 */

namespace ArcticResto\Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Delivery & Supply Coverage Lookup (`ar_territory_checker`)
 */
class W_TerritoryChecker extends Base_Widget {
	public function get_name() { return 'ar_territory_checker'; }
	public function get_title() { return __( 'AR · Delivery & Supply Area Lookup', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-search'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Lookup Configuration', 'arctic-resto' ) ] );
		$this->register_header_controls(
			'DELIVERY & COLLECTION COVERAGE CHECK',
			'Check Dry Ice Supply & Delivery Availability by Location',
			'Enter your city, state/region, or postal/ZIP code below. Because dry ice sublimates continuously in transit, delivery feasibility depends on order volume, container insulation, and route distance. Where coverage is not yet listed, contact our team directly to confirm availability.'
		);
		$this->add_control( 'placeholder', [
			'label'   => __( 'Input Placeholder', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'Enter City, State, or Postal / ZIP Code…',
		] );
		$this->add_control( 'btn_label', [
			'label'   => __( 'Button Label', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'Check Location',
		] );
		$this->add_control( 'coverage_note', [
			'label'   => __( 'Coverage Verification Notice', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 2,
			'default' => 'Admin Note: Supported regions, states, cities, and ZIP prefixes are editable in WP Admin → Delivery & Supply Zones. Customers in unlisted locations should submit the Delivery & Supply Area Inquiry form below to confirm service availability.',
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<section class="ar-w-sec ar-terr-checker-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>
				<div class="ar-card ar-terr-checker" data-ar-terr-checker>
					<form class="ar-terr-checker__form" data-ar-terr-form>
						<label class="screen-reader-text" for="ar-terr-zip-input"><?php esc_html_e( 'City, State, or ZIP Code', 'arctic-resto' ); ?></label>
						<input id="ar-terr-zip-input" type="text" name="zip" placeholder="<?php echo esc_attr( $s['placeholder'] ?? 'Enter City, State, or ZIP Code…' ); ?>" required />
						<button type="submit" class="ar-btn ar-btn--primary">
							<?php echo ar_svg( 'map-pin', 16 ); ?>
							<span><?php echo esc_html( $s['btn_label'] ?? 'Check Location' ); ?></span>
						</button>
					</form>
					<div class="ar-terr-checker__result" data-ar-terr-result aria-live="polite">
						<p class="ar-placeholder-note" style="margin:0;"><?php echo esc_html( $s['coverage_note'] ?? '' ); ?></p>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}

/**
 * 2. Delivery & Supply Zone Cards (`ar_territory_grid`)
 */
class W_TerritoryGrid extends Base_Widget {
	public function get_name() { return 'ar_territory_grid'; }
	public function get_title() { return __( 'AR · Delivery & Supply Zone Cards', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-google-maps'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Delivery Zones Grid', 'arctic-resto' ) ] );
		$this->register_header_controls(
			'FULFILLMENT & COVERAGE OPTIONS',
			'Admin-Editable Delivery, Collection & Bulk Freight Zones',
			'Manage supported regions, local pickup options, bulk route notes, and order minimum guidelines in WP Admin → Delivery & Supply Zones.'
		);
		$this->add_control( 'show_map_placeholder', [
			'label'        => __( 'Show Editable Coverage Map / Overview Diagram', 'arctic-resto' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => __( 'Yes', 'arctic-resto' ),
			'label_off'    => __( 'No', 'arctic-resto' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$zones = function_exists( 'ar_get_delivery_zones' ) ? ar_get_delivery_zones() : [];
		?>
		<section class="ar-w-sec ar-terr-grid-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>

				<?php if ( ( $s['show_map_placeholder'] ?? 'yes' ) === 'yes' ) : ?>
					<div class="ar-card ar-coverage-overview" style="margin-bottom:28px;">
						<div class="ar-coverage-overview__grid">
							<div class="ar-coverage-overview__visual">
								<img src="<?php echo esc_url( AR_URI . '/assets/images/bulk-supply-logistics.jpg' ); ?>" alt="<?php esc_attr_e( 'Dry ice delivery and insulated container staging', 'arctic-resto' ); ?>" loading="lazy" />
							</div>
							<div class="ar-coverage-overview__copy">
								<span class="ar-badge ar-badge--amber"><?php echo ar_svg( 'compass', 13 ); ?> <?php esc_html_e( 'ADMIN-CONFIGURABLE COVERAGE FRAMEWORK', 'arctic-resto' ); ?></span>
								<h3><?php esc_html_e( 'How Dry Ice Delivery & Collection Coverage Is Determined', 'arctic-resto' ); ?></h3>
								<p><?php esc_html_e( 'Unlike shelf-stable freight, dry ice (-78.5°C / -109.3°F) sublimates continuously from the moment of production. We evaluate delivery routes, container insulation thickness, and order weight together so your shipment arrives with dependable usable cooling capacity.', 'arctic-resto' ); ?></p>
								<ul class="ar-check-list">
									<li><?php echo ar_svg( 'check', 15 ); ?> <span><?php esc_html_e( 'Supported Regions / Cities: Editable via WP Admin → Delivery & Supply Zones', 'arctic-resto' ); ?></span></li>
									<li><?php echo ar_svg( 'check', 15 ); ?> <span><?php esc_html_e( 'Local Pickup / Will-Call: Available by arrangement with approved vented containers', 'arctic-resto' ); ?></span></li>
									<li><?php echo ar_svg( 'check', 15 ); ?> <span><?php esc_html_e( 'Commercial Route & Bulk Delivery: Scheduled around production and receiving windows', 'arctic-resto' ); ?></span></li>
									<li><?php echo ar_svg( 'check', 15 ); ?> <span><?php esc_html_e( 'Unlisted Locations: Contact our supply desk to verify coverage for your facility', 'arctic-resto' ); ?></span></li>
								</ul>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<div class="ar-grid ar-grid--3">
					<?php foreach ( $zones as $z ) : ?>
						<article class="ar-card ar-zone-card">
							<div class="ar-zone-card__top">
								<span class="ar-badge <?php echo ( $z['status'] ?? 'placeholder' ) === 'active' ? '' : 'ar-badge--amber'; ?>">
									<?php echo ar_svg( 'map-pin', 13 ); ?>
									<span><?php echo esc_html( $z['status_label'] ?? 'Demo Placeholder' ); ?></span>
								</span>
								<code class="ar-zone-card__code"><?php echo esc_html( $z['code'] ?? 'ZONE' ); ?></code>
							</div>
							<h3 class="ar-zone-card__title"><?php echo esc_html( $z['title'] ?? '' ); ?></h3>
							<dl class="ar-spec-dl">
								<dt><?php esc_html_e( 'Regions / Coverage Scope', 'arctic-resto' ); ?></dt>
								<dd><?php echo esc_html( $z['states'] ?? '' ); ?></dd>
								<dt><?php esc_html_e( 'Fulfillment / Collection', 'arctic-resto' ); ?></dt>
								<dd><?php echo esc_html( $z['pickup'] ?? '' ); ?></dd>
								<dt><?php esc_html_e( 'Bulk & Recurring Notes', 'arctic-resto' ); ?></dt>
								<dd><?php echo esc_html( $z['bulk_notes'] ?? '' ); ?></dd>
								<dt><?php esc_html_e( 'Order Minimums', 'arctic-resto' ); ?></dt>
								<dd><?php echo esc_html( $z['minimums'] ?? '' ); ?></dd>
								<dt><?php esc_html_e( 'Shipping & Transit Notes', 'arctic-resto' ); ?></dt>
								<dd><?php echo esc_html( $z['restrictions'] ?? '' ); ?></dd>
							</dl>
							<a href="<?php echo esc_url( $z['url'] ?? ar_url( '/delivery-areas/#area-inquiry' ) ); ?>" class="ar-btn ar-btn--ghost ar-btn--sm ar-btn--block" style="margin-top:16px;">
								<span><?php esc_html_e( 'Confirm Availability for Your Location', 'arctic-resto' ); ?></span>
								<?php echo ar_svg( 'arrow-right', 14 ); ?>
							</a>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}
}

/**
 * 3. Delivery & Supply Area Hero (`ar_territory_hero`)
 */
class W_TerritoryHero extends Base_Widget {
	public function get_name() { return 'ar_territory_hero'; }
	public function get_title() { return __( 'AR · Delivery Area Hero Banner', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-banner'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Hero Content', 'arctic-resto' ) ] );
		$this->add_control( 'region', [ 'label' => 'Badge', 'type' => Controls_Manager::TEXT, 'default' => 'DELIVERY & SUPPLY COVERAGE' ] );
		$this->add_control( 'title',  [ 'label' => 'Title', 'type' => Controls_Manager::TEXT, 'default' => 'Dry Ice Delivery, Route Coordination & Collection Areas' ] );
		$this->add_control( 'sub',    [ 'label' => 'Subtitle', 'type' => Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => 'Contact our dispatch team to verify delivery coverage, minimum order quantities, and insulated container options for your facility location.' ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<section class="ar-page-hero">
			<div class="ar-container">
				<span class="ar-badge"><?php echo ar_svg( 'truck', 14 ); ?> <?php echo esc_html( $s['region'] ?? '' ); ?></span>
				<h1 class="ar-page-hero__title"><?php echo esc_html( $s['title'] ?? '' ); ?></h1>
				<p class="ar-page-hero__sub"><?php echo esc_html( $s['sub'] ?? '' ); ?></p>
			</div>
		</section>
		<?php
	}
}
