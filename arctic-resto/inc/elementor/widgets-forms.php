<?php
/**
 * ArcticRestoDRY ICE — Quote, Bulk Order, Service-Area & Contact Form Widget.
 *
 * @package ArcticResto
 */

namespace ArcticResto\Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class W_LeadForm extends Base_Widget {
	public function get_name() { return 'ar_lead_form'; }
	public function get_title() { return __( 'AR · Dry Ice Quote & Order Form', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-form-horizontal'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Form Configuration', 'arctic-resto' ) ] );
		$this->register_header_controls(
			'REQUEST A DRY ICE QUOTE',
			'Submit Your Dry Ice Product, Bulk Supply, or Delivery Inquiry',
			'Provide your required dry ice format, estimated quantity, delivery location, and preferred schedule. Our team will respond with specifications and fulfillment options.'
		);
		$this->add_control( 'form_type', [
			'label'   => __( 'Form Workflow Type', 'arctic-resto' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'quote',
			'options' => [
				'quote'        => __( 'Dry Ice Product & Supply Quote Form', 'arctic-resto' ),
				'bulk'         => __( 'Bulk & Recurring Commercial Supply Form', 'arctic-resto' ),
				'service_area' => __( 'Delivery & Service-Area Coverage Inquiry', 'arctic-resto' ),
				'contact'      => __( 'General Contact & Business Inquiry Form', 'arctic-resto' ),
				'newsletter'   => __( 'Technical & Cold-Chain Resource Updates', 'arctic-resto' ),
			],
		] );
		$this->add_control( 'default_product', [
			'label'   => __( 'Pre-Selected Product Format (Optional)', 'arctic-resto' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '',
			'options' => [
				''        => __( 'User Selects Format', 'arctic-resto' ),
				'pellets' => __( 'Dry Ice Pellets', 'arctic-resto' ),
				'blocks'  => __( 'Dry Ice Blocks', 'arctic-resto' ),
				'nuggets' => __( 'Dry Ice Nuggets', 'arctic-resto' ),
				'mixed'   => __( 'Mixed Formats', 'arctic-resto' ),
				'custom'  => __( 'Custom / Application-Specific', 'arctic-resto' ),
			],
		] );
		$this->add_control( 'layout', [
			'label'   => __( 'Section Layout', 'arctic-resto' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'split',
			'options' => [
				'split'    => __( 'Two-Column Split (Contact & Dispatch Panel + Form)', 'arctic-resto' ),
				'centered' => __( 'Single-Column Full Form Card', 'arctic-resto' ),
			],
		] );
		$this->add_control( 'submit_label', [
			'label'   => __( 'Custom Submit Button Text (optional)', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => '',
		] );
		$this->add_control( 'side_heading', [
			'label'   => __( 'Side Panel Heading', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'Supply Desk & Dispatch Coordination',
		] );
		$this->add_control( 'side_note', [
			'label'   => __( 'Side Panel Guidance Note', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => 'To help us prepare an accurate quote, include your target dry ice format (pellets, nuggets, or blocks), estimated weight or tote count, delivery ZIP/city, and whether your requirement is a one-time order or a recurring schedule.',
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$type   = in_array( $s['form_type'] ?? 'quote', [ 'quote', 'bulk', 'service_area', 'contact', 'newsletter' ], true ) ? $s['form_type'] : 'quote';
		$layout = $s['layout'] ?? 'split';
		$args   = [
			'submit_label'    => $s['submit_label'] ?? '',
			'default_product' => $s['default_product'] ?? '',
		];
		?>
		<section class="ar-w-sec ar-lead-sec" id="quote">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>

				<?php if ( $layout === 'split' && $type !== 'newsletter' ) : ?>
					<div class="ar-lead-split">
						<aside class="ar-card ar-lead-side">
							<span class="ar-badge"><?php echo ar_svg( 'snowflake', 13 ); ?> <?php esc_html_e( 'DIRECT B2B & COMMERCIAL SUPPLY', 'arctic-resto' ); ?></span>
							<h3 class="ar-lead-side__title"><?php echo esc_html( $s['side_heading'] ?? 'Supply Desk & Dispatch Coordination' ); ?></h3>
							<p class="ar-lead-side__note"><?php echo esc_html( $s['side_note'] ?? '' ); ?></p>

							<div class="ar-lead-side__contacts">
								<div class="ar-lead-side__item">
									<span class="ar-icon-box"><?php echo ar_svg( 'phone', 18 ); ?></span>
									<div>
										<strong><?php esc_html_e( 'Phone / Dispatch Desk', 'arctic-resto' ); ?></strong>
										<?php if ( ar_has_contact_value( 'phone' ) ) : ?>
											<a href="<?php echo esc_url( ar_tel_href() ); ?>"><?php echo esc_html( ar_contact_display( 'phone' ) ); ?></a>
										<?php else : ?>
											<span class="ar-placeholder-note"><?php echo esc_html( ar_contact_display( 'phone' ) ); ?></span>
										<?php endif; ?>
									</div>
								</div>

								<div class="ar-lead-side__item">
									<span class="ar-icon-box"><?php echo ar_svg( 'mail', 18 ); ?></span>
									<div>
										<strong><?php esc_html_e( 'Quote & Order Email', 'arctic-resto' ); ?></strong>
										<?php if ( ar_has_contact_value( 'email' ) ) : ?>
											<a href="mailto:<?php echo esc_attr( ar_contact_display( 'email' ) ); ?>"><?php echo esc_html( ar_contact_display( 'email' ) ); ?></a>
										<?php else : ?>
											<span class="ar-placeholder-note"><?php echo esc_html( ar_contact_display( 'email' ) ); ?></span>
										<?php endif; ?>
									</div>
								</div>

								<div class="ar-lead-side__item">
									<span class="ar-icon-box"><?php echo ar_svg( 'map-pin', 18 ); ?></span>
									<div>
										<strong><?php esc_html_e( 'Production & Collection Address', 'arctic-resto' ); ?></strong>
										<span class="<?php echo ar_has_contact_value( 'address' ) ? '' : 'ar-placeholder-note'; ?>"><?php echo esc_html( ar_contact_display( 'address' ) ); ?></span>
									</div>
								</div>

								<div class="ar-lead-side__item">
									<span class="ar-icon-box"><?php echo ar_svg( 'clock', 18 ); ?></span>
									<div>
										<strong><?php esc_html_e( 'Operating & Dispatch Hours', 'arctic-resto' ); ?></strong>
										<span class="<?php echo ar_has_contact_value( 'hours' ) ? '' : 'ar-placeholder-note'; ?>"><?php echo esc_html( ar_contact_display( 'hours' ) ); ?></span>
									</div>
								</div>
							</div>

							<div class="ar-lead-side__urgent">
								<strong><?php echo ar_svg( 'alert', 15 ); ?> <?php esc_html_e( 'Urgent & Recurring Supply Coordination', 'arctic-resto' ); ?></strong>
								<p><?php echo esc_html( (string) ar_opt( 'urgent_supply_note' ) ); ?></p>
							</div>
						</aside>

						<div class="ar-card ar-lead-card">
							<?php echo ar_render_form( $type, $args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					</div>
				<?php else : ?>
					<div class="ar-card ar-lead-card ar-lead-card--centered">
						<?php echo ar_render_form( $type, $args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
