<?php
/**
 * ArcticRestoDRY ICE — Hero, Key Facts Strip, Process Steps & CTA Band Widgets.
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
 * 1. Hero Banner (`ar_hero`)
 */
class W_Hero extends Base_Widget {
	public function get_name() { return 'ar_hero'; }
	public function get_title() { return __( 'AR · Dry Ice Hero Banner', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-banner'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Hero Content & Media', 'arctic-resto' ) ] );
		$this->add_control( 'eyebrow', [
			'label'   => __( 'Eyebrow Badge', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'DRY ICE MANUFACTURING & COMMERCIAL SUPPLY',
		] );
		$this->add_control( 'title', [
			'label'   => __( 'Headline (supports <em> for Ice Blue highlight)', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => 'Quality Dry Ice. <em>Reliable Supply.</em> Flexible Solutions.',
		] );
		$this->add_control( 'subtitle', [
			'label'   => __( 'Lead Paragraph', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => 'ArcticRestoDRY ICE manufactures and supplies solid carbon dioxide pellets, nuggets, and blocks for commercial, industrial, food processing, healthcare, and cold-chain applications.',
		] );
		$this->add_control( 'cta1_label', [ 'label' => 'Primary CTA Label', 'type' => Controls_Manager::TEXT, 'default' => 'Request a Quote' ] );
		$this->add_control( 'cta1_url',   [ 'label' => 'Primary CTA URL',   'type' => Controls_Manager::TEXT, 'default' => '/contact/#quote' ] );
		$this->add_control( 'cta2_label', [ 'label' => 'Secondary CTA Label', 'type' => Controls_Manager::TEXT, 'default' => 'Explore Dry Ice Products' ] );
		$this->add_control( 'cta2_url',   [ 'label' => 'Secondary CTA URL',   'type' => Controls_Manager::TEXT, 'default' => '/dry-ice-products/' ] );
		$this->add_control( 'image_url', [
			'label'   => __( 'Hero Visual Image URL', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => AR_URI . '/assets/images/hero-manufacturing.jpg',
		] );
		$this->add_control( 'media_badge_top', [
			'label'   => __( 'Visual Overlay Tag (Top)', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'SOLID CO₂ · -78.5°C (-109.3°F)',
		] );
		$this->add_control( 'media_badge_bottom', [
			'label'   => __( 'Visual Overlay Summary (Bottom)', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'Extruded Pellets · Dense Nuggets · Solid Cooling Blocks',
		] );
		$this->add_control( 'badges', [
			'label'   => __( 'Capability Pills (pipe-separated | )', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 2,
			'default' => 'Dry Ice Pellets, Nuggets & Blocks | Vented Insulated Packaging | Commercial & Bulk Supply | Recurring Delivery Programs',
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$img    = ! empty( $s['image_url'] ) ? $s['image_url'] : ( AR_URI . '/assets/images/hero-manufacturing.jpg' );
		$badges = array_filter( array_map( 'trim', explode( '|', (string) ( $s['badges'] ?? '' ) ) ) );
		?>
		<section class="ar-hero">
			<div class="ar-container ar-hero__grid">
				<div class="ar-hero__copy">
					<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
						<span class="ar-badge"><?php echo ar_svg( 'snowflake', 14 ); ?> <span><?php echo esc_html( $s['eyebrow'] ); ?></span></span>
					<?php endif; ?>
					<h1 class="ar-hero__title"><?php echo wp_kses_post( $s['title'] ?? '' ); ?></h1>
					<?php if ( ! empty( $s['subtitle'] ) ) : ?>
						<p class="ar-hero__sub"><?php echo wp_kses_post( $s['subtitle'] ); ?></p>
					<?php endif; ?>

					<div class="ar-hero__actions">
						<?php if ( ! empty( $s['cta1_label'] ) ) : ?>
							<a href="<?php echo esc_url( ar_url( $s['cta1_url'] ?? '/contact/#quote' ) ); ?>" class="ar-btn ar-btn--primary ar-btn--lg">
								<span><?php echo esc_html( $s['cta1_label'] ); ?></span>
								<?php echo ar_svg( 'arrow-right', 18 ); ?>
							</a>
						<?php endif; ?>
						<?php if ( ! empty( $s['cta2_label'] ) ) : ?>
							<a href="<?php echo esc_url( ar_url( $s['cta2_url'] ?? '/dry-ice-products/' ) ); ?>" class="ar-btn ar-btn--ghost ar-btn--lg">
								<span><?php echo esc_html( $s['cta2_label'] ); ?></span>
							</a>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $badges ) ) : ?>
						<ul class="ar-hero__pills">
							<?php foreach ( $badges as $b ) : ?>
								<li><?php echo ar_svg( 'check', 15 ); ?> <span><?php echo esc_html( $b ); ?></span></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>

				<div class="ar-hero__visual">
					<div class="ar-hero__frame">
						<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( (string) ( $s['title'] ?? 'ArcticRestoDRY ICE Manufacturing & Supply' ) ) ); ?>" fetchpriority="high" />
						<?php if ( ! empty( $s['media_badge_top'] ) ) : ?>
							<div class="ar-hero__chip ar-hero__chip--top">
								<?php echo ar_svg( 'thermometer', 15 ); ?>
								<span><?php echo esc_html( $s['media_badge_top'] ); ?></span>
							</div>
						<?php endif; ?>
						<?php if ( ! empty( $s['media_badge_bottom'] ) ) : ?>
							<div class="ar-hero__chip ar-hero__chip--bottom">
								<?php echo ar_svg( 'cube', 16 ); ?>
								<span><?php echo esc_html( $s['media_badge_bottom'] ); ?></span>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}

/**
 * 2. Technical Facts / Key Parameters Strip (`ar_stats`)
 */
class W_Stats extends Base_Widget {
	public function get_name() { return 'ar_stats'; }
	public function get_title() { return __( 'AR · Dry Ice Technical Facts Strip', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-counter'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Technical Facts / Parameters', 'arctic-resto' ) ] );
		$rep = new Repeater();
		$rep->add_control( 'num',   [ 'label' => 'Primary Value / Parameter', 'type' => Controls_Manager::TEXT, 'default' => '-78.5°C' ] );
		$rep->add_control( 'label', [ 'label' => 'Fact Title',                'type' => Controls_Manager::TEXT, 'default' => 'Sublimation Temperature (-109.3°F)' ] );
		$rep->add_control( 'sub',   [ 'label' => 'Technical Explanation',     'type' => Controls_Manager::TEXT, 'default' => 'Direct solid-to-gas phase transition at 1 atm' ] );

		$this->add_control( 'items', [
			'label'       => __( 'Facts', 'arctic-resto' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ num }}} — {{{ label }}}',
			'default'     => [
				[ 'num' => '-78.5°C',  'label' => 'Sublimation Point (-109.3°F)', 'sub' => 'Solid CO₂ transitions directly to gas with zero water melt' ],
				[ 'num' => '3 Formats', 'label' => 'Pellets, Nuggets & Blocks',   'sub' => 'Matched to rapid chilling, parcel shipping, or long-haul hold' ],
				[ 'num' => 'UN 1845',  'label' => 'Vented Container Handling',    'sub' => 'Insulated poly-lined cartons & commercial storage totes' ],
				[ 'num' => 'Flexible', 'label' => 'Spot & Recurring Supply',      'sub' => 'One-time batches or standing weekly/monthly schedules' ],
			],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = $s['items'] ?? [];
		?>
		<section class="ar-w-sec ar-stats-band">
			<div class="ar-container">
				<div class="ar-grid ar-grid--4 ar-stats-grid">
					<?php foreach ( $items as $it ) : ?>
						<div class="ar-stat-card">
							<div class="ar-stat-card__val"><?php echo esc_html( $it['num'] ?? '' ); ?></div>
							<div class="ar-stat-card__label"><?php echo esc_html( $it['label'] ?? '' ); ?></div>
							<?php if ( ! empty( $it['sub'] ) ) : ?>
								<div class="ar-stat-card__sub"><?php echo esc_html( $it['sub'] ); ?></div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}
}

/**
 * 3. Process Workflow Steps (`ar_process`)
 */
class W_Process extends Base_Widget {
	public function get_name() { return 'ar_process'; }
	public function get_title() { return __( 'AR · Manufacturing / Ordering Steps', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-time-line'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Workflow Steps', 'arctic-resto' ) ] );
		$this->register_header_controls(
			'ORDERING & FULFILLMENT WORKFLOW',
			'How Dry Ice Ordering, Production Timing & Delivery Coordination Work',
			'Because dry ice sublimates continuously from the moment it is produced, we align manufacturing and container packing closely with your dispatch window.'
		);
		$rep = new Repeater();
		$rep->add_control( 'step',  [ 'label' => 'Step Number / Tag', 'type' => Controls_Manager::TEXT, 'default' => 'STEP 01' ] );
		$rep->add_control( 'title', [ 'label' => 'Step Heading',      'type' => Controls_Manager::TEXT, 'default' => 'Specify Format, Volume & Application' ] );
		$rep->add_control( 'desc',  [ 'label' => 'Step Description',  'type' => Controls_Manager::TEXTAREA, 'rows' => 3 ] );

		$this->add_control( 'steps', [
			'label'       => __( 'Steps', 'arctic-resto' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ step }}} — {{{ title }}}',
			'default'     => [
				[
					'step'  => 'STEP 01',
					'title' => 'Submit Product Format & Volume Requirements',
					'desc'  => 'Select dry ice pellets, nuggets, or solid blocks, estimate your required weight or tote count, and share your delivery address or pickup preference.',
				],
				[
					'step'  => 'STEP 02',
					'title' => 'Confirm Specifications, Packaging & Schedule',
					'desc'  => 'Our supply desk reviews your application, recommends vented insulated totes or poly-lined cartons, and confirms one-time or recurring delivery cadence.',
				],
				[
					'step'  => 'STEP 03',
					'title' => 'Production-Timed Pelletizing & Block Compression',
					'desc'  => 'Dry ice is manufactured close to dispatch time to maximize usable product weight and minimize natural sublimation loss prior to arrival.',
				],
				[
					'step'  => 'STEP 04',
					'title' => 'Insulated Packing, Dispatch & Safe Receiving',
					'desc'  => 'Orders are packed in vented insulated containers and staged for route delivery, freight dispatch, or scheduled facility collection.',
				],
			],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$steps = $s['steps'] ?? [];
		?>
		<section class="ar-w-sec ar-process-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>
				<div class="ar-grid ar-grid--4 ar-process-grid">
					<?php foreach ( $steps as $st ) : ?>
						<div class="ar-card ar-process-card">
							<span class="ar-process-card__num"><?php echo esc_html( $st['step'] ?? '' ); ?></span>
							<h3 class="ar-process-card__title"><?php echo esc_html( $st['title'] ?? '' ); ?></h3>
							<p class="ar-process-card__desc"><?php echo esc_html( $st['desc'] ?? '' ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}
}

/**
 * 4. Call-to-Action Conversion Band (`ar_cta`)
 */
class W_Cta extends Base_Widget {
	public function get_name() { return 'ar_cta'; }
	public function get_title() { return __( 'AR · Quote Conversion CTA Band', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-call-to-action'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'CTA Content', 'arctic-resto' ) ] );
		$this->add_control( 'eyebrow', [ 'label' => 'Eyebrow Badge', 'type' => Controls_Manager::TEXT, 'default' => 'READY TO COORDINATE YOUR DRY ICE SUPPLY?' ] );
		$this->add_control( 'title',   [ 'label' => 'Heading',       'type' => Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => 'Request a Quote for Dry Ice Pellets, Blocks, Nuggets, or Recurring Bulk Supply' ] );
		$this->add_control( 'sub',     [ 'label' => 'Subheadline',   'type' => Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => 'Share your required format, estimated weight, delivery location, and schedule. Our supply team will confirm availability, insulated container options, and dispatch timing.' ] );
		$this->add_control( 'cta1_label', [ 'label' => 'Primary Button Label',   'type' => Controls_Manager::TEXT, 'default' => 'Request a Quote' ] );
		$this->add_control( 'cta1_url',   [ 'label' => 'Primary Button URL',     'type' => Controls_Manager::TEXT, 'default' => '/contact/#quote' ] );
		$this->add_control( 'cta2_label', [ 'label' => 'Secondary Button Label', 'type' => Controls_Manager::TEXT, 'default' => 'Bulk & Recurring Orders' ] );
		$this->add_control( 'cta2_url',   [ 'label' => 'Secondary Button URL',   'type' => Controls_Manager::TEXT, 'default' => '/bulk-orders/' ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<section class="ar-w-sec ar-cta-band">
			<div class="ar-container">
				<div class="ar-card ar-cta-card">
					<div class="ar-cta-card__copy">
						<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
							<span class="ar-badge"><?php echo ar_svg( 'snowflake', 13 ); ?> <?php echo esc_html( $s['eyebrow'] ); ?></span>
						<?php endif; ?>
						<h2 class="ar-cta-card__title"><?php echo wp_kses_post( $s['title'] ?? '' ); ?></h2>
						<?php if ( ! empty( $s['sub'] ) ) : ?>
							<p class="ar-cta-card__sub"><?php echo wp_kses_post( $s['sub'] ); ?></p>
						<?php endif; ?>
					</div>
					<div class="ar-cta-card__actions">
						<?php if ( ! empty( $s['cta1_label'] ) ) : ?>
							<a href="<?php echo esc_url( ar_url( $s['cta1_url'] ?? '/contact/#quote' ) ); ?>" class="ar-btn ar-btn--primary ar-btn--lg">
								<span><?php echo esc_html( $s['cta1_label'] ); ?></span>
								<?php echo ar_svg( 'arrow-right', 18 ); ?>
							</a>
						<?php endif; ?>
						<?php if ( ! empty( $s['cta2_label'] ) ) : ?>
							<a href="<?php echo esc_url( ar_url( $s['cta2_url'] ?? '/bulk-orders/' ) ); ?>" class="ar-btn ar-btn--ghost ar-btn--lg">
								<span><?php echo esc_html( $s['cta2_label'] ); ?></span>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
