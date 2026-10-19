<?php
/**
 * ArcticRestoDRY ICE — Manufacturing Timeline, Quality & Handling Standards Strip,
 * Visual Walkthrough & Interactive Container/Process Hotspots Widgets.
 *
 * @package ArcticResto
 */

namespace ArcticResto\Elementor;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Dry Ice Manufacturing Process Timeline (`ar_timeline`)
 */
class W_Timeline extends Base_Widget {
	public function get_name() { return 'ar_timeline'; }
	public function get_title() { return __( 'AR · Dry Ice Manufacturing Process Timeline', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-history'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Process Timeline', 'arctic-resto' ) ] );
		$this->register_header_controls(
			'DRY ICE MANUFACTURING PROCESS',
			'From Liquid CO₂ Feedstock to High-Density Pellets, Nuggets & Blocks',
			'Understanding how solid carbon dioxide is formed, compressed, sized, and packed in vented insulated containers for reliable supply.'
		);
		$rep = new Repeater();
		$rep->add_control( 'year',  [ 'label' => 'Stage Tag',   'type' => Controls_Manager::TEXT, 'default' => 'STAGE 01' ] );
		$rep->add_control( 'title', [ 'label' => 'Stage Title', 'type' => Controls_Manager::TEXT, 'default' => 'Pressurized Liquid CO₂ Storage & Feed' ] );
		$rep->add_control( 'desc',  [ 'label' => 'Description', 'type' => Controls_Manager::TEXTAREA, 'rows' => 3 ] );

		$this->add_control( 'items', [
			'label'       => __( 'Timeline Stages', 'arctic-resto' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ year }}} — {{{ title }}}',
			'default'     => [
				[
					'year'  => 'STAGE 01 · FEEDSTOCK',
					'title' => 'Pressurized Liquid CO₂ Storage & Feed Control',
					'desc'  => 'Carbon dioxide is held in insulated bulk storage vessels under controlled pressure and refrigerated temperature as a liquid feedstock ready for production.',
				],
				[
					'year'  => 'STAGE 02 · PHASE EXPANSION',
					'title' => 'Rapid Pressure Drop & Carbon Dioxide Snow Formation',
					'desc'  => 'When liquid CO₂ expands through precision valves toward atmospheric pressure (below the triple point of 5.18 bar / -56.6°C), rapid evaporative cooling converts a portion of the stream into fine, porous solid CO₂ snow at -78.5°C (-109.3°F).',
				],
				[
					'year'  => 'STAGE 03 · COMPRESSION & EXTRUSION',
					'title' => 'Hydraulic Pelletizing, Nugget Extrusion, or Block Pressing',
					'desc'  => 'Hydraulic chambers compress the low-density CO₂ snow either through precision extrusion dies to produce dense cylindrical pellets and nuggets, or inside high-force block molds to form solid cooling blocks.',
				],
				[
					'year'  => 'STAGE 04 · SIZING & QUALITY CHECK',
					'title' => 'Format Inspection, Density Consistency & Batch Verification',
					'desc'  => 'Finished pellets, nuggets, and blocks are checked for uniform compaction, structural integrity, and clean handling prior to container loading.',
				],
				[
					'year'  => 'STAGE 05 · VENTED INSULATED PACKAGING',
					'title' => 'Thermal Protection in Vented Totes & Poly-Lined Cartons',
					'desc'  => 'Product is immediately transferred into insulated commercial totes or poly-lined shipping cartons engineered to minimize ambient heat transfer while allowing sublimating CO₂ gas to vent safely.',
				],
				[
					'year'  => 'STAGE 06 · DISPATCH ALIGNMENT',
					'title' => 'Production-Timed Staging, Collection & Route Delivery',
					'desc'  => 'Because sublimation begins immediately after pressing, production batches are scheduled closely with outbound delivery routes and customer pickup windows.',
				],
			],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = $s['items'] ?? [];
		?>
		<section class="ar-w-sec ar-timeline-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>
				<div class="ar-timeline">
					<?php foreach ( $items as $it ) : ?>
						<div class="ar-card ar-timeline__item">
							<span class="ar-timeline__stage"><?php echo esc_html( $it['year'] ?? '' ); ?></span>
							<h3 class="ar-timeline__title"><?php echo esc_html( $it['title'] ?? '' ); ?></h3>
							<p class="ar-timeline__desc"><?php echo esc_html( $it['desc'] ?? '' ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}
}

/**
 * 2. Quality, Packaging & Handling Standards Strip (`ar_cert_strip`)
 */
class W_CertStrip extends Base_Widget {
	public function get_name() { return 'ar_cert_strip'; }
	public function get_title() { return __( 'AR · Quality & Handling Standards Strip', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-check-circle'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Quality Pillars', 'arctic-resto' ) ] );
		$rep = new Repeater();
		$rep->add_control( 'code',  [ 'label' => 'Standard / Pillar Tag', 'type' => Controls_Manager::TEXT, 'default' => 'UN 1845 PROTOCOL' ] );
		$rep->add_control( 'title', [ 'label' => 'Pillar Title',          'type' => Controls_Manager::TEXT, 'default' => 'Solid CO₂ Transport & Labeling Guidance' ] );
		$rep->add_control( 'desc',  [ 'label' => 'Pillar Summary',        'type' => Controls_Manager::TEXT, 'default' => 'Vented packaging & clear net-weight marking support' ] );

		$this->add_control( 'items', [
			'label'       => __( 'Pillars', 'arctic-resto' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ code }}} — {{{ title }}}',
			'default'     => [
				[ 'code' => 'HIGH COMPACTION',   'title' => 'Dense Pellet & Block Compaction',     'desc' => 'Controlled hydraulic compression to support predictable sublimation behavior' ],
				[ 'code' => 'VENTED CONTAINERS', 'title' => 'Insulated Tote & Carton Integrity',   'desc' => 'Clean poly-lined cartons and insulated totes that vent CO₂ gas safely' ],
				[ 'code' => 'DISPATCH TIMING',   'title' => 'Fresh Production Alignment',          'desc' => 'Manufactured close to dispatch or pickup to preserve usable weight' ],
				[ 'code' => 'SAFETY & SDS',      'title' => 'Cryogenic PPE & Ventilation Guidance','desc' => 'Clear -78.5°C (-109.3°F) handling & ventilation documentation' ],
			],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = $s['items'] ?? [];
		?>
		<section class="ar-w-sec ar-cert-sec">
			<div class="ar-container">
				<div class="ar-grid ar-grid--4">
					<?php foreach ( $items as $it ) : ?>
						<div class="ar-card ar-cert-card">
							<span class="ar-badge"><?php echo ar_svg( 'shield', 13 ); ?> <?php echo esc_html( $it['code'] ?? '' ); ?></span>
							<h3 class="ar-cert-card__title"><?php echo esc_html( $it['title'] ?? '' ); ?></h3>
							<p class="ar-cert-card__desc"><?php echo esc_html( $it['desc'] ?? '' ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}
}

/**
 * 3. Visual Manufacturing & Packaging Feature Card (`ar_video_modal`)
 */
class W_VideoModal extends Base_Widget {
	public function get_name() { return 'ar_video_modal'; }
	public function get_title() { return __( 'AR · Manufacturing & Packaging Visual Feature', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-image-rollover'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Visual Feature', 'arctic-resto' ) ] );
		$this->add_control( 'eyebrow',    [ 'label' => 'Eyebrow',    'type' => Controls_Manager::TEXT,     'default' => 'INSIDE DRY ICE PRODUCTION & HANDLING' ] );
		$this->add_control( 'title',      [ 'label' => 'Title',      'type' => Controls_Manager::TEXT,     'default' => 'Controlled Compression, Clean Handling & Vented Insulated Packaging' ] );
		$this->add_control( 'desc',       [ 'label' => 'Summary',    'type' => Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Every batch of dry ice pellets, nuggets, and blocks requires disciplined temperature management and immediate insulated packing to minimize sublimation before arrival.' ] );
		$this->add_control( 'poster_url', [ 'label' => 'Image URL',  'type' => Controls_Manager::TEXT,     'default' => AR_URI . '/assets/images/quality-control.jpg' ] );
		$this->add_control( 'cta_label',  [ 'label' => 'CTA Label',  'type' => Controls_Manager::TEXT,     'default' => 'Explore Manufacturing Process' ] );
		$this->add_control( 'cta_url',    [ 'label' => 'CTA URL',    'type' => Controls_Manager::TEXT,     'default' => '/dry-ice-manufacturing/' ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s   = $this->get_settings_for_display();
		$img = ! empty( $s['poster_url'] ) ? $s['poster_url'] : ( AR_URI . '/assets/images/quality-control.jpg' );
		?>
		<section class="ar-w-sec ar-feature-split-sec">
			<div class="ar-container">
				<div class="ar-card ar-feature-split">
					<div class="ar-feature-split__media">
						<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $s['title'] ?? 'Dry Ice Quality & Packaging' ); ?>" loading="lazy" />
					</div>
					<div class="ar-feature-split__copy">
						<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
							<span class="ar-badge"><?php echo ar_svg( 'factory', 13 ); ?> <?php echo esc_html( $s['eyebrow'] ); ?></span>
						<?php endif; ?>
						<h2 class="ar-feature-split__title"><?php echo esc_html( $s['title'] ?? '' ); ?></h2>
						<p class="ar-feature-split__desc"><?php echo esc_html( $s['desc'] ?? '' ); ?></p>
						<?php if ( ! empty( $s['cta_label'] ) ) : ?>
							<a href="<?php echo esc_url( ar_url( $s['cta_url'] ?? '/dry-ice-manufacturing/' ) ); ?>" class="ar-btn ar-btn--primary">
								<span><?php echo esc_html( $s['cta_label'] ); ?></span>
								<?php echo ar_svg( 'arrow-right', 16 ); ?>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}

/**
 * 4. Interactive Container & Sublimation Anatomy Diagram (`ar_hotspots`)
 */
class W_Hotspots extends Base_Widget {
	public function get_name() { return 'ar_hotspots'; }
	public function get_title() { return __( 'AR · Insulated Container & Handling Anatomy', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-image-hotspot'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Container & Handling Anatomy', 'arctic-resto' ) ] );
		$this->register_header_controls(
			'PACKAGING & STORAGE ANATOMY',
			'How Vented Insulated Containers Protect Dry Ice & Personnel',
			'Proper dry ice storage balances thermal insulation against safe, continuous CO₂ gas pressure relief.'
		);
		$this->add_control( 'image_url', [
			'label'   => __( 'Diagram Image URL', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => AR_URI . '/assets/images/insulated-containers.jpg',
		] );
		$rep = new Repeater();
		$rep->add_control( 'num',   [ 'label' => 'Callout Number', 'type' => Controls_Manager::TEXT, 'default' => '01' ] );
		$rep->add_control( 'title', [ 'label' => 'Callout Title',  'type' => Controls_Manager::TEXT, 'default' => 'Non-Airtight Vented Lid Design' ] );
		$rep->add_control( 'desc',  [ 'label' => 'Explanation',    'type' => Controls_Manager::TEXTAREA, 'rows' => 2 ] );

		$this->add_control( 'points', [
			'label'       => __( 'Anatomy Points', 'arctic-resto' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ num }}} — {{{ title }}}',
			'default'     => [
				[
					'num'   => '01',
					'title' => 'Non-Airtight Vented Gasket / Lid Path',
					'desc'  => 'Allows sublimating CO₂ gas (~800x expansion ratio) to escape continuously without dangerous internal pressure buildup.',
				],
				[
					'num'   => '02',
					'title' => 'Thick-Walled Insulated Core',
					'desc'  => 'Reduces ambient thermal transfer into the -78.5°C (-109.3°F) dry ice payload, slowing daily sublimation loss.',
				],
				[
					'num'   => '03',
					'title' => 'Food-Grade / Poly-Lined Interior',
					'desc'  => 'Protects pellets, nuggets, and blocks from external moisture and debris while facilitating clean unloading.',
				],
				[
					'num'   => '04',
					'title' => 'Forklift & Pallet-Ready Base',
					'desc'  => 'Enables safe mechanical dock handling and reduces manual lifting during bulk commercial deliveries.',
				],
			],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$img    = ! empty( $s['image_url'] ) ? $s['image_url'] : ( AR_URI . '/assets/images/insulated-containers.jpg' );
		$points = $s['points'] ?? [];
		?>
		<section class="ar-w-sec ar-hotspots-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>
				<div class="ar-card ar-anatomy-card">
					<div class="ar-anatomy-card__media">
						<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $s['title'] ?? 'Insulated Dry Ice Container' ); ?>" loading="lazy" />
					</div>
					<div class="ar-anatomy-card__list">
						<?php foreach ( $points as $pt ) : ?>
							<div class="ar-anatomy-point">
								<span class="ar-anatomy-point__num"><?php echo esc_html( $pt['num'] ?? '01' ); ?></span>
								<div>
									<h3 class="ar-anatomy-point__title"><?php echo esc_html( $pt['title'] ?? '' ); ?></h3>
									<p class="ar-anatomy-point__desc"><?php echo esc_html( $pt['desc'] ?? '' ); ?></p>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
