<?php
/**
 * ArcticRestoDRY ICE — Breadcrumbs, Technical Review Box, Specification Sheet
 * & Sticky Quote CTA Widgets.
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
 * 1. Breadcrumbs (`ar_breadcrumbs`)
 */
class W_Breadcrumbs extends Base_Widget {
	public function get_name() { return 'ar_breadcrumbs'; }
	public function get_title() { return __( 'AR · Breadcrumb Trail', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-product-breadcrumbs'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Breadcrumbs', 'arctic-resto' ) ] );
		$this->add_control( 'parent_label', [ 'label' => 'Parent Page Label (optional)', 'type' => Controls_Manager::TEXT, 'default' => '' ] );
		$this->add_control( 'parent_url',   [ 'label' => 'Parent Page URL (optional)',   'type' => Controls_Manager::TEXT, 'default' => '' ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<div class="ar-w-sec ar-breadcrumbs-bar" style="padding:18px 0 0;">
			<div class="ar-container">
				<nav class="ar-breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'arctic-resto' ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'arctic-resto' ); ?></a>
					<?php if ( ! empty( $s['parent_label'] ) ) : ?>
						<span aria-hidden="true">/</span>
						<a href="<?php echo esc_url( ar_url( $s['parent_url'] ?? '/' ) ); ?>"><?php echo esc_html( $s['parent_label'] ); ?></a>
					<?php endif; ?>
					<span aria-hidden="true">/</span>
					<span><?php echo esc_html( get_the_title() ?: 'Current Page' ); ?></span>
				</nav>
			</div>
		</div>
		<?php
	}
}

/**
 * 2. Technical Review & Editorial Attribution Box (`ar_author_box`)
 */
class W_AuthorBox extends Base_Widget {
	public function get_name() { return 'ar_author_box'; }
	public function get_title() { return __( 'AR · Technical Guidance & SDS Box', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-person'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Guidance Box', 'arctic-resto' ) ] );
		$this->add_control( 'name', [ 'label' => 'Team / Desk Title', 'type' => Controls_Manager::TEXT, 'default' => 'ArcticRestoDRY ICE Technical & Supply Desk' ] );
		$this->add_control( 'role', [ 'label' => 'Subtitle',          'type' => Controls_Manager::TEXT, 'default' => 'Dry Ice Manufacturing, Cold-Chain Packaging & Safe CO₂ Handling Guidance' ] );
		$this->add_control( 'bio',  [
			'label'   => 'Summary Notice',
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => 'Technical guidance on this page reflects standard physical properties of solid carbon dioxide (CO₂) at -78.5°C (-109.3°F) and general industrial handling practices. Always consult your facility Safety Data Sheet (SDS) and confirm order-specific format dimensions and packaging with our supply desk.',
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<section class="ar-w-sec ar-author-sec">
			<div class="ar-container">
				<div class="ar-card ar-author-card">
					<span class="ar-icon-box"><?php echo ar_svg( 'shield', 22 ); ?></span>
					<div>
						<h3 class="ar-author-card__name"><?php echo esc_html( $s['name'] ?? '' ); ?></h3>
						<p class="ar-author-card__role"><?php echo esc_html( $s['role'] ?? '' ); ?></p>
						<p class="ar-author-card__bio"><?php echo esc_html( $s['bio'] ?? '' ); ?></p>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}

/**
 * 3. Technical Data & Documentation Sheet (`ar_spec_sheet`)
 */
class W_SpecSheet extends Base_Widget {
	public function get_name() { return 'ar_spec_sheet'; }
	public function get_title() { return __( 'AR · Technical Data & Documentation Card', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-document-file'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Specification Card', 'arctic-resto' ) ] );
		$this->register_header_controls(
			'TECHNICAL DATA & DOCUMENTATION',
			'Dry Ice Physical Properties & Documentation Placeholders',
			'Standard physical properties of solid carbon dioxide alongside editable placeholders for facility-specific documentation.'
		);
		$rep = new Repeater();
		$rep->add_control( 'k', [ 'label' => 'Parameter', 'type' => Controls_Manager::TEXT, 'default' => 'UN Hazard Class / Number' ] );
		$rep->add_control( 'v', [ 'label' => 'Value / Status', 'type' => Controls_Manager::TEXT, 'default' => 'UN 1845 · Carbon Dioxide, Solid (Class 9 Miscellaneous)' ] );

		$this->add_control( 'rows', [
			'label'       => __( 'Specification Rows', 'arctic-resto' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ k }}}',
			'default'     => [
				[ 'k' => 'Substance Name',               'v' => 'Carbon Dioxide, Solid (Dry Ice) — Formula: CO₂' ],
				[ 'k' => 'CAS Registry / UN Number',     'v' => 'CAS 124-38-9 · UN 1845 (Class 9 for Air/Regulated Freight)' ],
				[ 'k' => 'Sublimation Temperature',      'v' => '-78.5°C (-109.3°F) at 1 atm (101.3 kPa)' ],
				[ 'k' => 'Gas Expansion Ratio',          'v' => '~1 kg solid dry ice expands to ~541 liters of CO₂ gas at STP' ],
				[ 'k' => 'Safety Data Sheet (SDS)',      'v' => 'Available upon request — upload verified PDF in WP Media Library' ],
				[ 'k' => 'Product Specification Sheet',  'v' => 'Editable placeholder — confirm batch/format requirements via Quote Desk' ],
			],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s    = $this->get_settings_for_display();
		$rows = $s['rows'] ?? [];
		?>
		<section class="ar-w-sec ar-specsheet-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>
				<div class="ar-card ar-specsheet-card">
					<dl class="ar-specsheet-grid">
						<?php foreach ( $rows as $r ) : ?>
							<div class="ar-specsheet-row">
								<dt><?php echo esc_html( $r['k'] ?? '' ); ?></dt>
								<dd><?php echo esc_html( $r['v'] ?? '' ); ?></dd>
							</div>
						<?php endforeach; ?>
					</dl>
				</div>
			</div>
		</section>
		<?php
	}
}

/**
 * 4. Inline Sticky / Banner CTA (`ar_sticky_cta`)
 */
class W_StickyCta extends Base_Widget {
	public function get_name() { return 'ar_sticky_cta'; }
	public function get_title() { return __( 'AR · Inline Quote Action Bar', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-button'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Action Bar', 'arctic-resto' ) ] );
		$this->add_control( 'text',      [ 'label' => 'Prompt Text',  'type' => Controls_Manager::TEXT, 'default' => 'Need help calculating dry ice weight or selecting between pellets, nuggets, and blocks?' ] );
		$this->add_control( 'btn_label', [ 'label' => 'Button Label', 'type' => Controls_Manager::TEXT, 'default' => 'Request a Quote' ] );
		$this->add_control( 'btn_url',   [ 'label' => 'Button URL',   'type' => Controls_Manager::TEXT, 'default' => '/contact/#quote' ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<div class="ar-w-sec ar-inline-action">
			<div class="ar-container">
				<div class="ar-card ar-inline-action__bar">
					<p><?php echo esc_html( $s['text'] ?? '' ); ?></p>
					<a href="<?php echo esc_url( ar_url( $s['btn_url'] ?? '/contact/#quote' ) ); ?>" class="ar-btn ar-btn--primary ar-btn--sm">
						<span><?php echo esc_html( $s['btn_label'] ?? 'Request a Quote' ); ?></span>
						<?php echo ar_svg( 'arrow-right', 15 ); ?>
					</a>
				</div>
			</div>
		</div>
		<?php
	}
}
