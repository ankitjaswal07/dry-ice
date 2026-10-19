<?php
/**
 * ArcticRestoDRY ICE — Bento Grid, Format Comparison Matrix, FAQ Accordion,
 * Supply Tier Cards & Compliance Strip Widgets.
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
 * 1. Bento Feature Grid (`ar_bento`)
 */
class W_Bento extends Base_Widget {
	public function get_name() { return 'ar_bento'; }
	public function get_title() { return __( 'AR · Capability / Value Bento Grid', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-gallery-justified'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Bento Grid Content', 'arctic-resto' ) ] );
		$this->register_header_controls(
			'WHY CHOOSE ARCTICRESTODRY ICE',
			'Built Around Product Consistency, Disciplined Handling & Reliable Supply',
			'Whether you require recurring palletized totes for food processing or precision pellets for laboratory and industrial operations, we focus on dependable execution.'
		);
		$rep = new Repeater();
		$rep->add_control( 'icon',  [ 'label' => 'Icon', 'type' => Controls_Manager::SELECT, 'default' => 'snowflake', 'options' => $this->icon_choices() ] );
		$rep->add_control( 'tag',   [ 'label' => 'Badge / Tag', 'type' => Controls_Manager::TEXT, 'default' => 'MANUFACTURING DISCIPLINE' ] );
		$rep->add_control( 'title', [ 'label' => 'Card Title',  'type' => Controls_Manager::TEXT, 'default' => 'High-Density Extrusion & Block Forming' ] );
		$rep->add_control( 'desc',  [ 'label' => 'Description', 'type' => Controls_Manager::TEXTAREA, 'rows' => 3 ] );
		$rep->add_control( 'span',  [
			'label'   => 'Grid Span',
			'type'    => Controls_Manager::SELECT,
			'default' => '1',
			'options' => [ '1' => 'Standard (1 Col)', '2' => 'Wide (2 Cols)' ],
		] );

		$this->add_control( 'items', [
			'label'       => __( 'Bento Cards', 'arctic-resto' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => [
				[
					'icon'  => 'factory',
					'tag'   => 'PRODUCTION TIMING',
					'title' => 'Manufactured Close to Dispatch to Minimize Sublimation',
					'desc'  => 'Dry ice begins sublimating the moment it is formed. We coordinate pelletizing and block compression around outbound dispatch and pickup windows so your shipment arrives with maximum usable cooling mass.',
					'span'  => '2',
				],
				[
					'icon'  => 'cube',
					'tag'   => 'MULTI-FORMAT SUPPLY',
					'title' => 'Pellets, Nuggets & Solid Blocks',
					'desc'  => 'Choose extruded pellets for rapid chilling and blast media, dense nuggets for balanced hold time, or compressed solid blocks for prolonged transport cooling.',
					'span'  => '1',
				],
				[
					'icon'  => 'package',
					'tag'   => 'PACKAGING INTEGRITY',
					'title' => 'Vented Insulated Totes & Cartons',
					'desc'  => 'Supplied in commercial insulated storage totes or poly-lined cartons designed to slow heat ingress while safely venting sublimating CO₂ gas.',
					'span'  => '1',
				],
				[
					'icon'  => 'truck',
					'tag'   => 'SUPPLY CONTINUITY',
					'title' => 'Flexible Spot Orders & Standing Recurring Schedules',
					'desc'  => 'Support one-time project requirements, seasonal cold-chain peaks, or standing weekly and bi-weekly supply schedules tailored to your receiving dock.',
					'span'  => '2',
				],
			],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = $s['items'] ?? [];
		?>
		<section class="ar-w-sec ar-bento-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>
				<div class="ar-bento-grid">
					<?php foreach ( $items as $it ) :
						$wide = ( $it['span'] ?? '1' ) === '2' ? ' ar-bento-card--wide' : '';
						?>
						<div class="ar-card ar-bento-card<?php echo esc_attr( $wide ); ?>">
							<div class="ar-bento-card__top">
								<span class="ar-icon-box"><?php echo ar_svg( $it['icon'] ?? 'snowflake', 20 ); ?></span>
								<?php if ( ! empty( $it['tag'] ) ) : ?>
									<span class="ar-bento-card__tag"><?php echo esc_html( $it['tag'] ); ?></span>
								<?php endif; ?>
							</div>
							<h3 class="ar-bento-card__title"><?php echo esc_html( $it['title'] ?? '' ); ?></h3>
							<p class="ar-bento-card__desc"><?php echo esc_html( $it['desc'] ?? '' ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}
}

/**
 * 2. Technical Format / Cooling Comparison Matrix (`ar_comparison`)
 */
class W_Comparison extends Base_Widget {
	public function get_name() { return 'ar_comparison'; }
	public function get_title() { return __( 'AR · Dry Ice Format Comparison Matrix', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-table'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Comparison Table', 'arctic-resto' ) ] );
		$this->register_header_controls(
			'FORMAT SELECTION GUIDE',
			'Comparing Dry Ice Pellets, Nuggets, Solid Blocks & Water Ice',
			'Match the right cooling medium and geometry to your target temperature, hold duration, and handling workflow.'
		);
		$this->add_control( 'col_ar',  [ 'label' => 'Column 1 (Primary)', 'type' => Controls_Manager::TEXT, 'default' => 'Dry Ice Pellets' ] );
		$this->add_control( 'col_alt1',[ 'label' => 'Column 2',           'type' => Controls_Manager::TEXT, 'default' => 'Dry Ice Blocks & Nuggets' ] );
		$this->add_control( 'col_alt2',[ 'label' => 'Column 3',           'type' => Controls_Manager::TEXT, 'default' => 'Water / Gel Ice' ] );

		$rep = new Repeater();
		$rep->add_control( 'metric', [ 'label' => 'Criterion',      'type' => Controls_Manager::TEXT, 'default' => 'Operating Temperature' ] );
		$rep->add_control( 'ar',     [ 'label' => 'Col 1 Value',    'type' => Controls_Manager::TEXT, 'default' => '-78.5°C (-109.3°F)' ] );
		$rep->add_control( 'alt1',   [ 'label' => 'Col 2 Value',    'type' => Controls_Manager::TEXT, 'default' => '-78.5°C (-109.3°F)' ] );
		$rep->add_control( 'alt2',   [ 'label' => 'Col 3 Value',    'type' => Controls_Manager::TEXT, 'default' => '0°C (32°F) or phase-dependent' ] );

		$this->add_control( 'rows', [
			'label'       => __( 'Comparison Rows', 'arctic-resto' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ metric }}}',
			'default'     => [
				[ 'metric' => 'Surface Temperature',         'ar' => '-78.5°C (-109.3°F)',                     'alt1' => '-78.5°C (-109.3°F)',                       'alt2' => '0°C (32°F) standard melt point' ],
				[ 'metric' => 'Phase Transition & Residue',  'ar' => 'Sublimates to CO₂ gas (zero liquid mess)', 'alt1' => 'Sublimates to CO₂ gas (zero liquid mess)',   'alt2' => 'Melts into liquid water / requires drainage' ],
				[ 'metric' => 'Cooling Rate vs. Hold Time',  'ar' => 'Rapid heat transfer (high surface area)', 'alt1' => 'Extended hold duration (slower sublimation)', 'alt2' => 'Limited thermal capacity per pound' ],
				[ 'metric' => 'Pourability & Void Packing',  'ar' => 'Pourable around irregular containers',    'alt1' => 'Nuggets pourable; blocks stack neatly',      'alt2' => 'Rigid packs or wet crushed ice' ],
				[ 'metric' => 'Primary Applications',        'ar' => 'Food chilling, parcel cold-chain, blasting','alt1' => 'Long-haul freight, catering, cold storage', 'alt2' => 'Above-freezing chilled transit only' ],
			],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s    = $this->get_settings_for_display();
		$rows = $s['rows'] ?? [];
		?>
		<section class="ar-w-sec ar-comparison-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>
				<div class="ar-card ar-table-card">
					<div class="ar-table-scroll">
						<table class="ar-spec-table ar-comparison-table">
							<thead>
								<tr>
									<th><?php esc_html_e( 'Evaluation Criterion', 'arctic-resto' ); ?></th>
									<th class="is-highlight"><?php echo esc_html( $s['col_ar'] ?? 'Dry Ice Pellets' ); ?></th>
									<th><?php echo esc_html( $s['col_alt1'] ?? 'Dry Ice Blocks & Nuggets' ); ?></th>
									<th><?php echo esc_html( $s['col_alt2'] ?? 'Water / Gel Ice' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $rows as $r ) : ?>
									<tr>
										<td class="ar-spec-table__param"><?php echo esc_html( $r['metric'] ?? '' ); ?></td>
										<td class="is-highlight"><?php echo esc_html( $r['ar'] ?? '' ); ?></td>
										<td><?php echo esc_html( $r['alt1'] ?? '' ); ?></td>
										<td class="ar-spec-table__note"><?php echo esc_html( $r['alt2'] ?? '' ); ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}

/**
 * 3. FAQ Accordion + Truthful FAQPage Schema (`ar_faq`)
 */
class W_Faq extends Base_Widget {
	protected static $faq_schema_emitted = false;

	public function get_name() { return 'ar_faq'; }
	public function get_title() { return __( 'AR · Dry Ice FAQ Accordion', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-accordion'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'FAQ Items', 'arctic-resto' ) ] );
		$this->register_header_controls(
			'FREQUENTLY ASKED QUESTIONS',
			'Common Questions About Dry Ice Products, Storage, Sublimation & Ordering',
			'Straightforward answers for commercial buyers, logistics coordinators, laboratory managers, and facility operators.'
		);
		$rep = new Repeater();
		$rep->add_control( 'cat', [ 'label' => 'Topic Tag (optional)', 'type' => Controls_Manager::TEXT, 'default' => 'DRY ICE BASICS' ] );
		$rep->add_control( 'q',   [ 'label' => 'Question',             'type' => Controls_Manager::TEXT, 'default' => 'What is dry ice and how does it work?' ] );
		$rep->add_control( 'a',   [ 'label' => 'Answer',               'type' => Controls_Manager::TEXTAREA, 'rows' => 4 ] );

		$this->add_control( 'items', [
			'label'       => __( 'FAQs', 'arctic-resto' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ q }}}',
			'default'     => [
				[
					'cat' => 'FUNDAMENTALS',
					'q'   => 'What is dry ice and how does it differ from regular water ice?',
					'a'   => 'Dry ice is the solid form of carbon dioxide (CO₂). At atmospheric pressure it maintains a surface temperature of -78.5°C (-109.3°F) and sublimates directly from a solid into carbon dioxide gas without melting into liquid water. This makes it ideal for temperature-sensitive shipping, food processing, and industrial cooling where water residue is unacceptable.',
				],
				[
					'cat' => 'PRODUCT SELECTION',
					'q'   => 'What is the difference between dry ice pellets, nuggets, and blocks?',
					'a'   => 'Dry ice pellets are small cylindrical extrusions with high surface area for rapid cooling, easy pouring around packages, and industrial blast supply. Nuggets are larger-diameter extrusions that sublimate more slowly than small pellets while remaining pourable. Solid blocks have the lowest surface-area-to-volume ratio and sublimate slowest, making them ideal for prolonged transport or extended cooling.',
				],
				[
					'cat' => 'STORAGE & SUBLIMATION',
					'q'   => 'How long does dry ice last and how should it be stored?',
					'a'   => 'Dry ice sublimates continuously once manufactured — typically losing roughly 5% to 10% of its weight per 24 hours in a quality insulated container, depending on container insulation, ambient temperature, and how frequently the lid is opened. Store dry ice in a dedicated, vented insulated container in a cool, well-ventilated area. Never store dry ice in an airtight container or an unventilated walk-in freezer.',
				],
				[
					'cat' => 'SAFETY',
					'q'   => 'What safety precautions are required when handling dry ice?',
					'a'   => 'Always wear insulated cryogenic or leather gloves and eye protection to prevent frostbite or cold burns (-78.5°C / -109.3°F). Ensure adequate ventilation in storage rooms and vehicles because sublimating CO₂ gas can displace oxygen in confined spaces. Never seal dry ice inside glass, screw-top, or airtight containers, as gas pressure buildup can cause rupture.',
				],
				[
					'cat' => 'ORDERING',
					'q'   => 'How do I request a quote or set up recurring bulk dry ice deliveries?',
					'a'   => 'Submit your required format (pellets, blocks, or nuggets), estimated quantity, delivery location, and preferred schedule through our Request a Quote or Bulk Orders page. Our supply coordination team will confirm availability, insulated container options, and delivery or collection timing.',
				],
			],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = $s['items'] ?? [];
		if ( empty( $items ) ) {
			return;
		}
		$schema_entities = [];
		?>
		<section class="ar-w-sec ar-faq-sec">
			<div class="ar-container ar-faq-container">
				<?php $this->section_header( $s ); ?>
				<div class="ar-faq-list">
					<?php foreach ( $items as $idx => $it ) :
						$q = trim( (string) ( $it['q'] ?? '' ) );
						$a = trim( (string) ( $it['a'] ?? '' ) );
						if ( $q === '' ) {
							continue;
						}
						$schema_entities[] = [
							'@type'          => 'Question',
							'name'           => $q,
							'acceptedAnswer' => [
								'@type' => 'Answer',
								'text'  => wp_strip_all_tags( $a ),
							],
						];
						?>
						<details class="ar-faq-item" <?php echo $idx === 0 ? 'open' : ''; ?>>
							<summary class="ar-faq-item__q">
								<span class="ar-faq-item__q-wrap">
									<?php if ( ! empty( $it['cat'] ) ) : ?>
										<span class="ar-faq-item__cat"><?php echo esc_html( $it['cat'] ); ?></span>
									<?php endif; ?>
									<span class="ar-faq-item__q-text"><?php echo esc_html( $q ); ?></span>
								</span>
								<span class="ar-faq-item__chevron"><?php echo ar_svg( 'chevron-down', 18 ); ?></span>
							</summary>
							<div class="ar-faq-item__a">
								<p><?php echo wp_kses_post( nl2br( esc_html( $a ) ) ); ?></p>
							</div>
						</details>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
		if ( ! self::$faq_schema_emitted && ! empty( $schema_entities ) ) {
			self::$faq_schema_emitted = true;
			$faq_json = [
				'@context'   => 'https://schema.org',
				'@type'      => 'FAQPage',
				'mainEntity' => $schema_entities,
			];
			echo '<script type="application/ld+json">' . wp_json_encode( $faq_json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
		}
	}
}

/**
 * 4. Supply Programs & Order Tier Cards (`ar_pricing`)
 * Note: Displays order structures without fabricating unverified product prices.
 */
class W_Pricing extends Base_Widget {
	public function get_name() { return 'ar_pricing'; }
	public function get_title() { return __( 'AR · Supply Programs & Order Tiers', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-price-table'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Supply Programs', 'arctic-resto' ) ] );
		$this->register_header_controls(
			'ORDERING PROGRAMS',
			'Flexible Dry Ice Supply Options for Spot Orders & Recurring Accounts',
			'Pricing depends on product format, order weight, insulated packaging, and delivery distance. Select a supply program below to request a tailored quote.'
		);
		$rep = new Repeater();
		$rep->add_control( 'badge',    [ 'label' => 'Program Badge',       'type' => Controls_Manager::TEXT, 'default' => 'COMMERCIAL SPOT ORDER' ] );
		$rep->add_control( 'name',     [ 'label' => 'Program Name',        'type' => Controls_Manager::TEXT, 'default' => 'On-Demand & Spot Supply' ] );
		$rep->add_control( 'tier_tag', [ 'label' => 'Volume / Cadence Tag','type' => Controls_Manager::TEXT, 'default' => 'Quote-Based Per Batch' ] );
		$rep->add_control( 'desc',     [ 'label' => 'Program Summary',     'type' => Controls_Manager::TEXTAREA, 'rows' => 2 ] );
		$rep->add_control( 'features', [ 'label' => 'Included Capabilities (pipe-separated | )', 'type' => Controls_Manager::TEXTAREA, 'rows' => 3 ] );
		$rep->add_control( 'cta_label',[ 'label' => 'CTA Button Label',    'type' => Controls_Manager::TEXT, 'default' => 'Request Program Quote' ] );
		$rep->add_control( 'cta_url',  [ 'label' => 'CTA Button URL',      'type' => Controls_Manager::TEXT, 'default' => '/contact/#quote' ] );
		$rep->add_control( 'featured', [ 'label' => 'Highlight Card',      'type' => Controls_Manager::SWITCHER, 'default' => '' ] );

		$this->add_control( 'tiers', [
			'label'       => __( 'Supply Tiers', 'arctic-resto' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ name }}}',
			'default'     => [
				[
					'badge'     => 'ONE-TIME / PROJECT SUPPLY',
					'name'      => 'Spot & Project Dry Ice Orders',
					'tier_tag'  => 'Custom Quote by Weight',
					'desc'      => 'Ideal for single-shipment cold-chain dispatches, laboratory trials, maintenance turnarounds, or emergency refrigeration backup.',
					'features'  => 'Dry ice pellets, nuggets, or solid blocks | Poly-lined insulated cartons or totes | Coordinated delivery or local collection | Safety & storage handling instructions included',
					'cta_label' => 'Request Spot Order Quote',
					'cta_url'   => '/contact/#quote',
					'featured'  => '',
				],
				[
					'badge'     => 'MOST POPULAR FOR COMMERCIAL BUYERS',
					'name'      => 'Recurring Scheduled Supply Program',
					'tier_tag'  => 'Weekly / Bi-Weekly / Monthly',
					'desc'      => 'Designed for food processors, healthcare labs, pharmaceutical shippers, and plants requiring predictable recurring replenishment.',
					'features'  => 'Production aligned to your receiving days | Commercial insulated tote rotation options | Consistent pellet diameter or block format | Priority schedule coordination & account support',
					'cta_label' => 'Set Up Recurring Supply',
					'cta_url'   => '/bulk-orders/#bulk-quote',
					'featured'  => 'yes',
				],
				[
					'badge'     => 'HIGH-VOLUME INDUSTRIAL & DISTRIBUTION',
					'name'      => 'Bulk Pallet & Multi-Tote Accounts',
					'tier_tag'  => 'High-Volume Contract Quote',
					'desc'      => 'Engineered for regional cold-chain hubs, large-scale food manufacturing, and multi-shift industrial production facilities.',
					'features'  => 'Multi-tote & palletized bulk dispatch | Mixed-format orders (pellets + blocks/nuggets) | Dock-to-dock delivery planning | Dedicated dispatch & contingency planning',
					'cta_label' => 'Inquire About Bulk Supply',
					'cta_url'   => '/bulk-orders/#bulk-quote',
					'featured'  => '',
				],
			],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$tiers = $s['tiers'] ?? [];
		?>
		<section class="ar-w-sec ar-pricing-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>
				<div class="ar-grid ar-grid--3">
					<?php foreach ( $tiers as $t ) :
						$feat_cls = ( $t['featured'] ?? '' ) === 'yes' ? ' ar-tier-card--featured' : '';
						$feats    = array_filter( array_map( 'trim', explode( '|', (string) ( $t['features'] ?? '' ) ) ) );
						?>
						<div class="ar-card ar-tier-card<?php echo esc_attr( $feat_cls ); ?>">
							<?php if ( ! empty( $t['badge'] ) ) : ?>
								<span class="ar-badge"><?php echo esc_html( $t['badge'] ); ?></span>
							<?php endif; ?>
							<h3 class="ar-tier-card__name"><?php echo esc_html( $t['name'] ?? '' ); ?></h3>
							<div class="ar-tier-card__tag"><?php echo esc_html( $t['tier_tag'] ?? '' ); ?></div>
							<p class="ar-tier-card__desc"><?php echo esc_html( $t['desc'] ?? '' ); ?></p>
							<?php if ( ! empty( $feats ) ) : ?>
								<ul class="ar-check-list">
									<?php foreach ( $feats as $f ) : ?>
										<li><?php echo ar_svg( 'check', 15 ); ?> <span><?php echo esc_html( $f ); ?></span></li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
							<a href="<?php echo esc_url( ar_url( $t['cta_url'] ?? '/contact/#quote' ) ); ?>" class="ar-btn <?php echo $feat_cls ? 'ar-btn--primary' : 'ar-btn--ghost'; ?> ar-btn--block">
								<span><?php echo esc_html( $t['cta_label'] ?? 'Request Quote' ); ?></span>
								<?php echo ar_svg( 'arrow-right', 16 ); ?>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}
}

/**
 * 5. Cold-Chain & Handling Standards Strip (`ar_logos`)
 */
class W_Logos extends Base_Widget {
	public function get_name() { return 'ar_logos'; }
	public function get_title() { return __( 'AR · Handling Standards & Sector Strip', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-carousel'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Standards & Sector Pills', 'arctic-resto' ) ] );
		$this->add_control( 'label', [
			'label'   => __( 'Strip Label', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'DRY ICE HANDLING, PACKAGING & SECTOR FOCUS',
		] );
		$this->add_control( 'items', [
			'label'   => __( 'Items (pipe-separated | )', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 2,
			'default' => 'UN 1845 Carbon Dioxide Solid | -78.5°C (-109.3°F) Cryogenic Handling | Vented Insulated Totes | Food Processing & Cold-Chain | Life Sciences & Laboratories | Industrial Manufacturing',
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = array_filter( array_map( 'trim', explode( '|', (string) ( $s['items'] ?? '' ) ) ) );
		?>
		<section class="ar-w-sec ar-logos-strip">
			<div class="ar-container">
				<?php if ( ! empty( $s['label'] ) ) : ?>
					<p class="ar-logos-strip__label"><?php echo esc_html( $s['label'] ); ?></p>
				<?php endif; ?>
				<div class="ar-logos-strip__list">
					<?php foreach ( $items as $it ) : ?>
						<span class="ar-logos-strip__pill"><?php echo ar_svg( 'snowflake', 14 ); ?> <span><?php echo esc_html( $it ); ?></span></span>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}
}
