<?php
/**
 * ArcticRestoDRY ICE — Interactive Visual Format Comparison, Sublimation Buffer
 * Estimator, Recurring Supply Planner & Technical Advisor Widgets.
 *
 * @package ArcticResto
 */

namespace ArcticResto\Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Visual Format Comparison (`ar_before_after`)
 */
class W_BeforeAfter extends Base_Widget {
	public function get_name() { return 'ar_before_after'; }
	public function get_title() { return __( 'AR · Visual Format Comparison (Pellets vs. Blocks)', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-image-before-after'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Visual Format Comparison', 'arctic-resto' ) ] );
		$this->register_header_controls(
			'VISUAL FORMAT COMPARISON',
			'Extruded Dry Ice Pellets vs. Solid Compressed Dry Ice Blocks',
			'Drag the comparison slider to inspect the structural difference between high-surface-area extruded pellets and low-sublimation solid blocks.'
		);
		$this->add_control( 'before_label', [ 'label' => 'Left Image Label',  'type' => Controls_Manager::TEXT, 'default' => 'Extruded Dry Ice Pellets (Rapid Cooling)' ] );
		$this->add_control( 'after_label',  [ 'label' => 'Right Image Label', 'type' => Controls_Manager::TEXT, 'default' => 'Compressed Solid Blocks (Extended Hold)' ] );
		$this->add_control( 'before_img',   [ 'label' => 'Left Image URL',    'type' => Controls_Manager::TEXT, 'default' => AR_URI . '/assets/images/dry-ice-pellets.jpg' ] );
		$this->add_control( 'after_img',    [ 'label' => 'Right Image URL',   'type' => Controls_Manager::TEXT, 'default' => AR_URI . '/assets/images/dry-ice-blocks.jpg' ] );
		$this->add_control( 'caption',      [ 'label' => 'Technical Caption', 'type' => Controls_Manager::TEXT, 'default' => 'Pellets pour around irregular items for rapid thermal transfer; solid blocks minimize surface area for slower sublimation over multi-day transit.' ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s  = $this->get_settings_for_display();
		$b  = ! empty( $s['before_img'] ) ? $s['before_img'] : ( AR_URI . '/assets/images/dry-ice-pellets.jpg' );
		$a  = ! empty( $s['after_img'] )  ? $s['after_img']  : ( AR_URI . '/assets/images/dry-ice-blocks.jpg' );
		?>
		<section class="ar-w-sec ar-ba-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>
				<div class="ar-card ar-ba-card" data-ar-ba>
					<div class="ar-ba-stage">
						<img class="ar-ba-img ar-ba-img--after" src="<?php echo esc_url( $a ); ?>" alt="<?php echo esc_attr( $s['after_label'] ?? 'Dry Ice Blocks' ); ?>" loading="lazy" />
						<div class="ar-ba-clip" data-ar-ba-clip style="width:50%;">
							<img class="ar-ba-img ar-ba-img--before" src="<?php echo esc_url( $b ); ?>" alt="<?php echo esc_attr( $s['before_label'] ?? 'Dry Ice Pellets' ); ?>" loading="lazy" />
						</div>
						<span class="ar-ba-tag ar-ba-tag--left"><?php echo esc_html( $s['before_label'] ?? 'Dry Ice Pellets' ); ?></span>
						<span class="ar-ba-tag ar-ba-tag--right"><?php echo esc_html( $s['after_label'] ?? 'Dry Ice Blocks' ); ?></span>
						<input type="range" class="ar-ba-range" min="5" max="95" value="50" aria-label="<?php esc_attr_e( 'Compare dry ice formats', 'arctic-resto' ); ?>" data-ar-ba-range />
					</div>
					<?php if ( ! empty( $s['caption'] ) ) : ?>
						<p class="ar-ba-caption"><?php echo esc_html( $s['caption'] ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<?php
	}
}

/**
 * 2. Dry Ice Sublimation & Buffer Weight Estimator (`ar_roi`)
 */
class W_Roi extends Base_Widget {
	public function get_name() { return 'ar_roi'; }
	public function get_title() { return __( 'AR · Dry Ice Sublimation & Buffer Estimator', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-calculator'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Estimator Settings', 'arctic-resto' ) ] );
		$this->register_header_controls(
			'SUBLIMATION PLANNING TOOL',
			'Estimate Dry Ice Sublimation Buffer for Storage & Transit',
			'Dry ice sublimates continuously at approximately 5%–10% per 24 hours in standard insulated containers. Use this planning tool to estimate total order weight before requesting a quote.'
		);
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<section class="ar-w-sec ar-calc-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>
				<div class="ar-card ar-calc-card" data-ar-sublimation-calc>
					<div class="ar-calc-grid">
						<div class="ar-calc-controls">
							<div class="ar-calc-field">
								<label><?php esc_html_e( 'Net Usable Dry Ice Needed at Destination / Use Point (lbs)', 'arctic-resto' ); ?></label>
								<input type="range" min="50" max="2000" step="25" value="300" data-ar-calc-net />
								<div class="ar-calc-val"><span data-ar-calc-net-out>300</span> lbs</div>
							</div>
							<div class="ar-calc-field">
								<label><?php esc_html_e( 'Storage + Transit Duration Prior to Final Use (Days)', 'arctic-resto' ); ?></label>
								<input type="range" min="1" max="5" step="1" value="2" data-ar-calc-days />
								<div class="ar-calc-val"><span data-ar-calc-days-out>2</span> day(s)</div>
							</div>
							<div class="ar-calc-field">
								<label><?php esc_html_e( 'Dry Ice Format & Container Profile', 'arctic-resto' ); ?></label>
								<select data-ar-calc-rate>
									<option value="0.06"><?php esc_html_e( 'Solid Blocks / Commercial Rotomolded Tote (~6%/day)', 'arctic-resto' ); ?></option>
									<option value="0.08" selected><?php esc_html_e( 'Dry Ice Nuggets / Insulated Shipping Container (~8%/day)', 'arctic-resto' ); ?></option>
									<option value="0.10"><?php esc_html_e( 'Dry Ice Pellets / Standard Poly-Lined Carton (~10%/day)', 'arctic-resto' ); ?></option>
								</select>
							</div>
						</div>
						<div class="ar-calc-results">
							<span class="ar-badge"><?php echo ar_svg( 'thermometer', 13 ); ?> <?php esc_html_e( 'ESTIMATED PLANNING ORDER WEIGHT', 'arctic-resto' ); ?></span>
							<div class="ar-calc-big"><span data-ar-calc-total>350</span> <small>lbs</small></div>
							<p class="ar-calc-sub"><?php esc_html_e( 'Includes estimated sublimation buffer of ', 'arctic-resto' ); ?><strong data-ar-calc-buffer>50 lbs</strong> <?php esc_html_e( 'over the selected hold period.', 'arctic-resto' ); ?></p>
							<p class="ar-placeholder-note" style="font-size:12px;margin:12px 0;">
								<?php esc_html_e( 'Planning estimate only: actual sublimation varies by ambient temperature, container R-value, and lid openings. Confirm exact shipment sizing with our supply team.', 'arctic-resto' ); ?>
							</p>
							<a href="<?php echo esc_url( ar_url( '/contact/#quote' ) ); ?>" class="ar-btn ar-btn--primary ar-btn--block">
								<span><?php esc_html_e( 'Request Quote for This Volume', 'arctic-resto' ); ?></span>
								<?php echo ar_svg( 'arrow-right', 16 ); ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}

/**
 * 3. Recurring Supply Cadence Planner (`ar_franchise_calc`)
 */
class W_FranchiseCalc extends Base_Widget {
	public function get_name() { return 'ar_franchise_calc'; }
	public function get_title() { return __( 'AR · Recurring Bulk Supply Planner', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-calendar'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Planner Settings', 'arctic-resto' ) ] );
		$this->register_header_controls(
			'RECURRING SUPPLY PLANNER',
			'Plan Weekly or Monthly Dry Ice Delivery Cadence',
			'Coordinate standing deliveries around your production shifts to balance fresh dry ice availability against storage sublimation.'
		);
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<section class="ar-w-sec ar-planner-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>
				<div class="ar-card" style="padding:32px;">
					<div class="ar-grid ar-grid--3">
						<div>
							<span class="ar-badge"><?php esc_html_e( 'HIGH-FREQUENCY REPLENISHMENT', 'arctic-resto' ); ?></span>
							<h3 style="margin-top:12px;"><?php esc_html_e( '2–3x Weekly Deliveries', 'arctic-resto' ); ?></h3>
							<p><?php esc_html_e( 'Recommended for high-consumption food processing, continuous cold-chain fulfillment, and daily laboratory shipping where minimizing on-site sublimation loss is critical.', 'arctic-resto' ); ?></p>
						</div>
						<div>
							<span class="ar-badge"><?php esc_html_e( 'STANDARD COMMERCIAL CADENCE', 'arctic-resto' ); ?></span>
							<h3 style="margin-top:12px;"><?php esc_html_e( 'Weekly Scheduled Tote Rotation', 'arctic-resto' ); ?></h3>
							<p><?php esc_html_e( 'Full insulated totes delivered on a fixed weekday while empty totes from the prior cycle are rotated back for inspection and sanitizing.', 'arctic-resto' ); ?></p>
						</div>
						<div>
							<span class="ar-badge"><?php esc_html_e( 'BATCH & CAMPAIGN ORDERS', 'arctic-resto' ); ?></span>
							<h3 style="margin-top:12px;"><?php esc_html_e( 'Bi-Weekly, Monthly & Project Runs', 'arctic-resto' ); ?></h3>
							<p><?php esc_html_e( 'Planned around scheduled plant maintenance, clinical trial waves, or seasonal cold-chain peaks with advance production reservation.', 'arctic-resto' ); ?></p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}

/**
 * 4. Interactive Dry Ice Format & Safety Advisor (`ar_ai_assist`)
 */
class W_AiAssist extends Base_Widget {
	public function get_name() { return 'ar_ai_assist'; }
	public function get_title() { return __( 'AR · Interactive Dry Ice Advisor', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-chat'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Advisor Settings', 'arctic-resto' ) ] );
		$this->register_header_controls(
			'DRY ICE FORMAT & SAFETY ADVISOR',
			'Have a Question About Pellets vs. Blocks, Sublimation, or Safe Storage?',
			'Select a topic or type a question below for immediate guidance on product formats, vented containers, and handling safety.'
		);
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<section class="ar-w-sec ar-advisor-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>
				<div class="ar-card ar-advisor-card" data-ar-advisor>
					<div class="ar-advisor-chips">
						<button type="button" class="ar-chip" data-ar-advisor-q="What is the difference between dry ice pellets, nuggets, and blocks?"><?php esc_html_e( 'Pellets vs. Blocks vs. Nuggets', 'arctic-resto' ); ?></button>
						<button type="button" class="ar-chip" data-ar-advisor-q="How should dry ice be stored safely and why are vented containers required?"><?php esc_html_e( 'Storage & Vented Containers', 'arctic-resto' ); ?></button>
						<button type="button" class="ar-chip" data-ar-advisor-q="How do I set up a bulk or recurring dry ice delivery order?"><?php esc_html_e( 'Bulk & Recurring Orders', 'arctic-resto' ); ?></button>
						<button type="button" class="ar-chip" data-ar-advisor-q="Where can I find mobile dry ice cleaning services?"><?php esc_html_e( 'Need Dry Ice Cleaning Services?', 'arctic-resto' ); ?></button>
					</div>
					<form class="ar-advisor-form" data-ar-advisor-form>
						<input type="text" name="prompt" placeholder="<?php esc_attr_e( 'Ask about dry ice formats, sublimation rate, PPE, or ordering…', 'arctic-resto' ); ?>" required />
						<button type="submit" class="ar-btn ar-btn--primary"><?php esc_html_e( 'Ask Advisor', 'arctic-resto' ); ?></button>
					</form>
					<div class="ar-advisor-output" data-ar-advisor-out>
						<p><?php esc_html_e( 'Tip: Dry ice sublimates at -78.5°C (-109.3°F) directly into CO₂ gas. Choose pellets for rapid cooling and void fill, or blocks/nuggets for extended multi-day hold duration.', 'arctic-resto' ); ?></p>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
