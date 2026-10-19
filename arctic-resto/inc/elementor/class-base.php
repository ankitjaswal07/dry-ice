<?php
/**
 * ArcticRestoDRY ICE — Base Elementor Widget Class.
 *
 * Provides shared helpers (`section_header`, `icon_choices`) and automatically
 * attaches comprehensive Elementor Style tab controls (Typography, Colors,
 * Alignment, Card Styling, Button Styling, and Section Spacing) to every
 * `ar_*` widget.
 *
 * @package ArcticResto
 */

namespace ArcticResto\Elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Base_Widget extends Widget_Base {

	protected $ar_style_registered = false;

	public function get_categories() {
		return [ 'arctic-resto' ];
	}

	public function get_icon() {
		return 'eicon-snowflake';
	}

	protected function init_controls() {
		parent::init_controls();
		$this->register_universal_style_controls();
	}

	/**
	 * Shared header controls helper for widget Content tab.
	 */
	protected function register_header_controls( string $eyebrow = 'DRY ICE SUPPLY', string $title = 'Section Heading', string $sub = '' ): void {
		$this->add_control( 'eyebrow', [
			'label'   => __( 'Eyebrow Badge', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => $eyebrow,
		] );
		$this->add_control( 'title', [
			'label'   => __( 'Heading', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 2,
			'default' => $title,
		] );
		$this->add_control( 'subtitle', [
			'label'   => __( 'Subtitle / Lead Copy', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => $sub,
		] );
		$this->add_control( 'heading_tag', [
			'label'   => __( 'Heading HTML Tag', 'arctic-resto' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'h2',
			'options' => [
				'h1' => 'H1',
				'h2' => 'H2',
				'h3' => 'H3',
				'h4' => 'H4',
			],
		] );
	}

	/**
	 * Universal Elementor Style Tab Controls for all ArcticRestoDRY ICE widgets.
	 */
	protected function register_universal_style_controls(): void {
		if ( $this->ar_style_registered ) {
			return;
		}
		$this->ar_style_registered = true;

		// 1. Section Container & Spacing Style
		$this->start_controls_section( 'ar_style_section_wrap', [
			'label' => __( 'Section Container & Spacing', 'arctic-resto' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'ar_sec_bg_color', [
			'label'     => __( 'Section Background Color', 'arctic-resto' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .ar-w-sec, {{WRAPPER}} .ar-hero, {{WRAPPER}} .ar-cta-band, {{WRAPPER}} .ar-cross-promo' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'ar_sec_padding', [
			'label'      => __( 'Section Padding', 'arctic-resto' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .ar-w-sec, {{WRAPPER}} .ar-hero, {{WRAPPER}} .ar-cta-band, {{WRAPPER}} .ar-cross-promo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'ar_header_align', [
			'label'     => __( 'Header Alignment', 'arctic-resto' ),
			'type'      => Controls_Manager::CHOOSE,
			'options'   => [
				'left'   => [ 'title' => __( 'Left', 'arctic-resto' ),   'icon' => 'eicon-text-align-left' ],
				'center' => [ 'title' => __( 'Center', 'arctic-resto' ), 'icon' => 'eicon-text-align-center' ],
				'right'  => [ 'title' => __( 'Right', 'arctic-resto' ),  'icon' => 'eicon-text-align-right' ],
			],
			'selectors' => [
				'{{WRAPPER}} .ar-sec-head' => 'text-align: {{VALUE}};',
			],
		] );

		$this->end_controls_section();

		// 2. Typography & Text Colors
		$this->start_controls_section( 'ar_style_typography', [
			'label' => __( 'Typography & Text Colors', 'arctic-resto' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'ar_eyebrow_color', [
			'label'     => __( 'Eyebrow / Badge Text Color', 'arctic-resto' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .ar-badge, {{WRAPPER}} .ar-eyebrow' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'ar_eyebrow_bg', [
			'label'     => __( 'Eyebrow / Badge Background', 'arctic-resto' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .ar-badge, {{WRAPPER}} .ar-eyebrow' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'ar_heading_color', [
			'label'     => __( 'Heading Color', 'arctic-resto' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} h1, {{WRAPPER}} h2, {{WRAPPER}} .ar-sec-title, {{WRAPPER}} .ar-hero__title' => 'color: {{VALUE}};',
			],
		] );

		if ( class_exists( '\Elementor\Group_Control_Typography' ) ) {
			$this->add_group_control( Group_Control_Typography::get_type(), [
				'name'     => 'ar_heading_typo',
				'label'    => __( 'Heading Typography', 'arctic-resto' ),
				'selector' => '{{WRAPPER}} h1, {{WRAPPER}} h2, {{WRAPPER}} .ar-sec-title, {{WRAPPER}} .ar-hero__title',
			] );
		}

		$this->add_control( 'ar_body_color', [
			'label'     => __( 'Subtitle / Body Copy Color', 'arctic-resto' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .ar-sec-sub, {{WRAPPER}} .ar-hero__sub, {{WRAPPER}} p, {{WRAPPER}} li' => 'color: {{VALUE}};',
			],
		] );

		if ( class_exists( '\Elementor\Group_Control_Typography' ) ) {
			$this->add_group_control( Group_Control_Typography::get_type(), [
				'name'     => 'ar_body_typo',
				'label'    => __( 'Body Typography', 'arctic-resto' ),
				'selector' => '{{WRAPPER}} .ar-sec-sub, {{WRAPPER}} .ar-hero__sub, {{WRAPPER}} p',
			] );
		}

		$this->end_controls_section();

		// 3. Cards & Surface Styling
		$this->start_controls_section( 'ar_style_cards', [
			'label' => __( 'Card & Box Styling', 'arctic-resto' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'ar_card_bg', [
			'label'     => __( 'Card Background Color', 'arctic-resto' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .ar-card, {{WRAPPER}} .ar-faq-item, {{WRAPPER}} .ar-stat-card' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'ar_card_border_color', [
			'label'     => __( 'Card Border Color', 'arctic-resto' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .ar-card, {{WRAPPER}} .ar-faq-item, {{WRAPPER}} .ar-stat-card' => 'border-color: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'ar_card_radius', [
			'label'      => __( 'Card Border Radius (px)', 'arctic-resto' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
			'selectors'  => [
				'{{WRAPPER}} .ar-card, {{WRAPPER}} .ar-faq-item, {{WRAPPER}} .ar-stat-card' => 'border-radius: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'ar_card_padding', [
			'label'      => __( 'Card Inner Padding', 'arctic-resto' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .ar-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		// 4. Button Styling
		$this->start_controls_section( 'ar_style_buttons', [
			'label' => __( 'Buttons & CTAs', 'arctic-resto' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'ar_btn_bg', [
			'label'     => __( 'Primary Button Background', 'arctic-resto' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .ar-btn--primary' => 'background: {{VALUE}}; border-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'ar_btn_text_color', [
			'label'     => __( 'Primary Button Text Color', 'arctic-resto' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .ar-btn--primary' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'ar_btn_ghost_color', [
			'label'     => __( 'Secondary Button Text / Border Color', 'arctic-resto' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .ar-btn--ghost' => 'color: {{VALUE}}; border-color: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'ar_btn_radius', [
			'label'      => __( 'Button Border Radius (px)', 'arctic-resto' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
			'selectors'  => [
				'{{WRAPPER}} .ar-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();
	}

	/**
	 * Render standardized section header markup.
	 */
	protected function section_header( array $s ): void {
		$eyebrow = trim( (string) ( $s['eyebrow'] ?? '' ) );
		$title   = trim( (string) ( $s['title'] ?? '' ) );
		$sub     = trim( (string) ( $s['subtitle'] ?? '' ) );
		$tag     = in_array( $s['heading_tag'] ?? 'h2', [ 'h1', 'h2', 'h3', 'h4' ], true ) ? $s['heading_tag'] : 'h2';

		if ( $eyebrow === '' && $title === '' && $sub === '' ) {
			return;
		}
		echo '<div class="ar-sec-head">';
		if ( $eyebrow !== '' ) {
			echo '<span class="ar-badge">' . ar_svg( 'snowflake', 13 ) . ' <span>' . esc_html( $eyebrow ) . '</span></span>';
		}
		if ( $title !== '' ) {
			echo '<' . esc_attr( $tag ) . ' class="ar-sec-title">' . wp_kses_post( $title ) . '</' . esc_attr( $tag ) . '>';
		}
		if ( $sub !== '' ) {
			echo '<p class="ar-sec-sub">' . wp_kses_post( $sub ) . '</p>';
		}
		echo '</div>';
	}

	protected function icon_choices(): array {
		return [
			'snowflake'   => 'Snowflake / Cryo',
			'cube'        => 'Dry Ice Block / Cube',
			'package'     => 'Insulated Container / Package',
			'factory'     => 'Manufacturing Plant',
			'truck'       => 'Cold-Chain Delivery Truck',
			'shield'      => 'Safety & Quality Shield',
			'thermometer' => 'Cryogenic Temperature (-78.5°C)',
			'alert'       => 'Hazard / Safety Alert',
			'flask'       => 'Laboratory / Life Sciences',
			'wind'        => 'CO₂ Ventilation / Airflow',
			'clipboard'   => 'Specification / Checklist',
			'zap'         => 'Rapid Cooling / Energy',
			'leaf'        => 'Food-Grade / Zero-Water Residue',
			'award'       => 'Quality Commitment',
			'layers'      => 'Multi-Format Supply',
			'wrench'      => 'Industrial Engineering',
			'compass'     => 'Supply Coverage / Route',
			'users'       => 'Customer Coordination',
			'chart'       => 'Volume / Supply Planning',
			'sparkles'    => 'Specialty / Partner Service',
		];
	}
}
