<?php
/**
 * ArcticRestoDRY ICE — Demo Pages Part 1 (Pages 1–8).
 *
 * Builds valid Elementor Flexbox Container + Widget trees for:
 * 1. Home (/)
 * 2. About Us (/about-us/)
 * 3. Dry Ice Manufacturing (/dry-ice-manufacturing/)
 * 4. Dry Ice Products (/dry-ice-products/)
 * 5. Dry Ice Pellets (/dry-ice-pellets/)
 * 6. Dry Ice Blocks and Nuggets (/dry-ice-blocks-nuggets/)
 * 7. Bulk Dry Ice Orders (/bulk-orders/)
 * 8. Industries We Serve (/industries/)
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Helper to wrap a list of Elementor widget definitions inside valid top-level
 * Elementor Flexbox Containers so every page opens and edits cleanly in Free Elementor.
 */
function ar_el_page_tree( array $widgets ): array {
	$tree = [];
	foreach ( $widgets as $idx => $w ) {
		$cid    = substr( md5( 'ar_c_' . $idx . '_' . ( $w['widgetType'] ?? 'w' ) ), 0, 7 );
		$wid    = substr( md5( 'ar_w_' . $idx . '_' . ( $w['widgetType'] ?? 'w' ) ), 0, 7 );
		$tree[] = [
			'id'       => $cid,
			'elType'   => 'container',
			'isInner'  => false,
			'settings' => [
				'content_width' => 'full',
				'padding'       => [ 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ],
			],
			'elements' => [
				[
					'id'         => $wid,
					'elType'     => 'widget',
					'widgetType' => $w['widgetType'],
					'settings'   => $w['settings'] ?? [],
					'elements'   => [],
				],
			],
		];
	}
	return $tree;
}

/**
 * Return pages 1–8 definitions.
 */
function ar_demo_pages_part1(): array {
	$img = AR_URI . '/assets/images/';

	return [
		// 1. HOME (/)
		'home' => [
			'title'   => 'Home',
			'excerpt' => 'ArcticRestoDRY ICE manufactures and supplies dry ice pellets, nuggets, and blocks for commercial, industrial, food processing, healthcare, and cold-chain applications.',
			'widgets' => [
				[
					'widgetType' => 'ar_hero',
					'settings'   => [
						'eyebrow'            => 'DRY ICE MANUFACTURING & COMMERCIAL SUPPLY',
						'title'              => 'Quality Dry Ice. <em>Reliable Supply.</em> Flexible Solutions.',
						'subtitle'           => 'ArcticRestoDRY ICE manufactures and supplies high-density dry ice pellets, nuggets, and solid cooling blocks for commercial, industrial, food processing, life-science, and cold-chain logistics operations.',
						'cta1_label'         => 'Request a Quote',
						'cta1_url'           => '/contact/#quote',
						'cta2_label'         => 'Explore Dry Ice Products',
						'cta2_url'           => '/dry-ice-products/',
						'image_url'          => $img . 'hero-manufacturing.jpg',
						'media_badge_top'    => 'SOLID CO₂ · -78.5°C (-109.3°F)',
						'media_badge_bottom' => 'Dry Ice Pellets · Dense Nuggets · Solid Cooling Blocks',
						'badges'             => 'Extruded Pellets, Nuggets & Blocks | Vented Insulated Packaging | Commercial & Bulk Supply | Recurring Delivery Programs',
					],
				],
				[
					'widgetType' => 'ar_stats',
					'settings'   => [
						'items' => [
							[ '_id' => 's1', 'num' => '-78.5°C',   'label' => 'Sublimation Point (-109.3°F)', 'sub' => 'Direct solid-to-gas phase transition with zero water residue' ],
							[ '_id' => 's2', 'num' => '3 Formats', 'label' => 'Pellets, Nuggets & Blocks',    'sub' => 'Engineered for rapid chilling, void fill, or multi-day transit' ],
							[ '_id' => 's3', 'num' => 'UN 1845',   'label' => 'Vented Insulated Packaging',   'sub' => 'Poly-lined cartons & commercial storage totes for safe venting' ],
							[ '_id' => 's4', 'num' => 'Flexible',  'label' => 'Spot & Recurring Supply',      'sub' => 'One-time batch fulfillment or standing weekly/monthly schedules' ],
						],
					],
				],
				[
					'widgetType' => 'ar_video_modal',
					'settings'   => [
						'eyebrow'    => 'ABOUT ARCTICRESTODRY ICE',
						'title'      => 'Dedicated to Dependable Dry Ice Manufacturing & Commercial Supply',
						'desc'       => 'Dry ice is not a shelf-stable warehouse commodity — it begins sublimating the moment it is formed. ArcticRestoDRY ICE focuses on disciplined solid CO₂ production, clean handling, vented insulated container preparation, and responsive dispatch coordination so commercial buyers receive reliable cooling capacity when they need it.',
						'poster_url' => $img . 'quality-control.jpg',
						'cta_label'  => 'Explore Our Manufacturing Process',
						'cta_url'    => '/dry-ice-manufacturing/',
					],
				],
				[
					'widgetType' => 'ar_products',
					'settings'   => [
						'eyebrow'         => 'DRY ICE PRODUCT CATEGORIES',
						'title'           => 'Dry Ice Pellets, Nuggets, Solid Blocks & Custom Supply Options',
						'subtitle'        => 'Select the solid carbon dioxide geometry suited to your thermal transfer rate, transit duration, and equipment specifications.',
						'source'          => 'repeater',
						'columns'         => '2',
						'spec_disclaimer' => 'Specification Note: Pellet diameters, block dimensions, and container weights shown above include editable industry placeholders. Contact our supply desk to verify exact specifications for your order.',
					],
				],
				[
					'widgetType' => 'ar_cert_strip',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_pricing',
					'settings'   => [
						'eyebrow'  => 'BULK SUPPLY & RECURRING ORDERS',
						'title'    => 'Flexible Ordering Programs for Spot Needs & Standing Commercial Accounts',
						'subtitle' => 'From single-batch project orders to weekly insulated tote rotation programs aligned with your production calendar.',
					],
				],
				[
					'widgetType' => 'ar_industries',
					'settings'   => [
						'eyebrow'  => 'INDUSTRIES WE SERVE',
						'title'    => 'Supporting Cold-Chain, Food, Life-Science & Industrial Operations',
						'subtitle' => 'Tailored dry ice formats and packaging configurations for temperature-critical commercial sectors.',
						'source'   => 'repeater',
						'columns'  => '4',
					],
				],
				[
					'widgetType' => 'ar_process',
					'settings'   => [
						'eyebrow'  => 'HOW ORDERING & DELIVERY WORK',
						'title'    => 'Streamlined Dry Ice Ordering, Production Timing & Fulfillment',
						'subtitle' => 'Four coordinated steps designed to minimize sublimation loss between production and your point of use.',
					],
				],
				[
					'widgetType' => 'ar_hotspots',
					'settings'   => [
						'eyebrow'   => 'PACKAGING & STORAGE INTEGRITY',
						'title'     => 'Engineered Vented Insulated Containers for Safe Sublimation Management',
						'subtitle'  => 'Every dry ice shipment must balance high thermal insulation with continuous CO₂ gas pressure relief.',
						'image_url' => $img . 'insulated-containers.jpg',
					],
				],
				[
					'widgetType' => 'ar_bento',
					'settings'   => [
						'eyebrow'  => 'WHY CHOOSE ARCTICRESTODRY ICE',
						'title'    => 'Operational Discipline Across Production, Packaging & Scheduling',
						'subtitle' => 'We focus on practical execution: consistent compaction, honest format guidance, and responsive order communication.',
					],
				],
				[
					'widgetType' => 'ar_safety_notice',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_faq',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_lead_form',
					'settings'   => [
						'eyebrow'   => 'REQUEST A DRY ICE QUOTE',
						'title'     => 'Get a Quote for Dry Ice Products, Bulk Orders, or Recurring Supply',
						'subtitle'  => 'Share your required format, estimated weight, delivery location, and schedule below.',
						'form_type' => 'quote',
						'layout'    => 'split',
					],
				],
				[
					'widgetType' => 'ar_cross_promo',
					'settings'   => [],
				],
			],
		],

		// 2. ABOUT US (/about-us/)
		'about-us' => [
			'title'   => 'About Us',
			'excerpt' => 'Learn about ArcticRestoDRY ICE — our focus on dry ice manufacturing, product consistency, disciplined handling, and customer-focused commercial supply.',
			'widgets' => [
				[
					'widgetType' => 'ar_breadcrumbs',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_hero',
					'settings'   => [
						'eyebrow'            => 'ABOUT ARCTICRESTODRY ICE',
						'title'              => 'Focused on Quality Dry Ice Manufacturing & <em>Dependable Supply</em>',
						'subtitle'           => 'ArcticRestoDRY ICE exists to provide commercial, industrial, and cold-chain buyers with consistent solid carbon dioxide products, practical packaging solutions, and reliable order coordination.',
						'cta1_label'         => 'Request a Supply Quote',
						'cta1_url'           => '/contact/#quote',
						'cta2_label'         => 'Our Manufacturing Process',
						'cta2_url'           => '/dry-ice-manufacturing/',
						'image_url'          => $img . 'quality-control.jpg',
						'media_badge_top'    => 'MANUFACTURING & SUPPLY',
						'media_badge_bottom' => 'Pellets · Nuggets · Solid Cooling Blocks',
						'badges'             => 'Product Consistency | Disciplined Packaging | Responsive Dispatch | Safety-First Culture',
					],
				],
				[
					'widgetType' => 'ar_bento',
					'settings'   => [
						'eyebrow'  => 'COMPANY PURPOSE & BUSINESS MODEL',
						'title'    => 'How We Approach Dry Ice Production & Commercial Fulfillment',
						'subtitle' => 'Unlike non-perishable industrial supplies, dry ice requires tight coordination between production timing, insulated container preparation, and customer receiving schedules.',
						'items'    => [
							[
								'_id'   => 'ab1',
								'icon'  => 'factory',
								'tag'   => 'MANUFACTURING APPROACH',
								'title' => 'Controlled Pelletizing, Nugget Extrusion & Block Compression',
								'desc'  => 'We focus on producing dense, uniform dry ice formats from liquid CO₂ feedstock using hydraulic compression and precision extrusion dies matched to commercial cooling and industrial requirements.',
								'span'  => '2',
							],
							[
								'_id'   => 'ab2',
								'icon'  => 'shield',
								'tag'   => 'QUALITY COMMITMENT',
								'title' => 'Compaction Density & Clean Container Handling',
								'desc'  => 'Higher compaction density helps reduce premature crumbling and supports more predictable sublimation behavior during storage and transit.',
								'span'  => '1',
							],
							[
								'_id'   => 'ab3',
								'icon'  => 'users',
								'tag'   => 'CUSTOMER COORDINATION',
								'title' => 'Clear Communication on Timing, Volumes & Containers',
								'desc'  => 'We work directly with procurement teams, lab managers, and logistics coordinators to align order weights and packaging with actual usage windows.',
								'span'  => '1',
							],
							[
								'_id'   => 'ab4',
								'icon'  => 'truck',
								'tag'   => 'SUPPLY PHILOSOPHY',
								'title' => 'Practical Flexibility for Spot Orders & Recurring Accounts',
								'desc'  => 'Whether you need a single batch for a cold-chain shipment or a standing weekly delivery schedule, our workflow is structured for clarity and dependability.',
								'span'  => '2',
							],
						],
					],
				],
				[
					'widgetType' => 'ar_testimonials',
					'settings'   => [
						'eyebrow'  => 'OPERATIONAL STANDARDS',
						'title'    => 'Core Principles Guiding Every Dry Ice Order',
						'subtitle' => 'Editable operational pillars that define how ArcticRestoDRY ICE serves commercial and industrial customers.',
					],
				],
				[
					'widgetType' => 'ar_cross_promo',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_cta',
					'settings'   => [],
				],
			],
		],

		// 3. DRY ICE MANUFACTURING (/dry-ice-manufacturing/)
		'dry-ice-manufacturing' => [
			'title'   => 'Dry Ice Manufacturing',
			'excerpt' => 'How ArcticRestoDRY ICE produces solid CO₂ pellets, nuggets, and blocks through controlled liquid CO₂ expansion, hydraulic compression, sizing, and insulated packaging.',
			'widgets' => [
				[
					'widgetType' => 'ar_breadcrumbs',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_hero',
					'settings'   => [
						'eyebrow'            => 'DRY ICE MANUFACTURING PROCESS',
						'title'              => 'How Solid Carbon Dioxide Is <em>Manufactured, Compressed & Packed</em>',
						'subtitle'           => 'From pressurized liquid CO₂ feedstock to high-density extruded pellets, nuggets, and solid blocks — explore the thermodynamic stages and quality controls behind reliable dry ice supply.',
						'cta1_label'         => 'Request a Supply Quote',
						'cta1_url'           => '/contact/#quote',
						'cta2_label'         => 'View Product Specifications',
						'cta2_url'           => '/quality/',
						'image_url'          => $img . 'hero-manufacturing.jpg',
						'media_badge_top'    => 'LIQUID CO₂ TO SOLID CO₂',
						'media_badge_bottom' => 'Expansion · Snow Formation · Hydraulic Compression',
						'badges'             => 'Liquid CO₂ Feedstock | Rapid Phase Expansion | Hydraulic Pelletizing & Block Pressing | Vented Insulated Staging',
					],
				],
				[
					'widgetType' => 'ar_timeline',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_bento',
					'settings'   => [
						'eyebrow'  => 'PRODUCTION & SUBLIMATION MANAGEMENT',
						'title'    => 'Distinguishing General Dry Ice Thermodynamics from Order-Specific Capabilities',
						'subtitle' => 'Below we outline the physical principles of dry ice production alongside how ArcticRestoDRY ICE coordinates order fulfillment.',
						'items'    => [
							[
								'_id'   => 'mf1',
								'icon'  => 'thermometer',
								'tag'   => 'THERMODYNAMIC PRINCIPLE',
								'title' => 'Why Liquid CO₂ Forms Solid Snow Below 5.18 bar (-56.6°C)',
								'desc'  => 'Carbon dioxide cannot exist as a liquid at standard atmospheric pressure. When pressurized liquid CO₂ expands across an orifice to atmospheric pressure, the Joule-Thomson cooling effect converts part of the liquid into -78.5°C (-109.3°F) solid snow and cold CO₂ vapor.',
								'span'  => '2',
							],
							[
								'_id'   => 'mf2',
								'icon'  => 'cube',
								'tag'   => 'MECHANICAL COMPACTION',
								'title' => 'Extrusion Dies vs. Block Compression Chambers',
								'desc'  => 'Loose CO₂ snow is porous and sublimates rapidly. Hydraulic presses compact the snow either through perforated extrusion dies (forming pellets and nuggets) or inside rectangular molds (forming dense blocks).',
								'span'  => '1',
							],
							[
								'_id'   => 'mf3',
								'icon'  => 'clock',
								'tag'   => 'DISPATCH SYNCHRONIZATION',
								'title' => 'Managing Sublimation Between Press and Receiving Dock',
								'desc'  => 'Because sublimation cannot be halted completely, scheduling production runs close to dispatch and pre-chilling or insulating storage totes preserves net usable weight.',
								'span'  => '1',
							],
						],
					],
				],
				[
					'widgetType' => 'ar_spec_table',
					'settings'   => [
						'eyebrow'  => 'PROCESS & FORMAT PARAMETERS',
						'title'    => 'Manufacturing Output Formats & Reference Parameters',
						'subtitle' => 'General physical constants of solid CO₂ alongside editable format placeholders.',
					],
				],
				[
					'widgetType' => 'ar_faq',
					'settings'   => [
						'eyebrow'  => 'MANUFACTURING FAQS',
						'title'    => 'Questions About Dry Ice Production, Density & Sublimation',
						'subtitle' => 'Technical answers on how dry ice is made and why production timing matters for commercial buyers.',
						'items'    => [
							[
								'_id' => 'mfq1',
								'cat' => 'PRODUCTION',
								'q'   => 'Why is dry ice manufactured close to the time of delivery or pickup?',
								'a'   => 'Unlike water ice stored in a mechanical freezer, dry ice (-78.5°C / -109.3°F) is colder than standard commercial freezers and sublimates continuously even inside insulated containers. Producing dry ice close to dispatch maximizes the usable weight delivered to your facility.',
							],
							[
								'_id' => 'mfq2',
								'cat' => 'COMPACTION',
								'q'   => 'How does hydraulic compression affect dry ice quality?',
								'a'   => 'Loose carbon dioxide snow has low bulk density and high trapped gas volume, causing it to sublimate very quickly. Compressing snow under hydraulic pressure into dense pellets, nuggets, or solid blocks reduces internal voids and slows sublimation.',
							],
							[
								'_id' => 'mfq3',
								'cat' => 'SPECIFICATIONS',
								'q'   => 'How can I confirm exact pellet diameters, block weights, or grade requirements?',
								'a'   => 'Because die sizes, block dimensions, and documentation requirements vary by application, contact our supply desk via the quote form so we can confirm verified specifications for your order.',
							],
						],
					],
				],
				[
					'widgetType' => 'ar_lead_form',
					'settings'   => [
						'eyebrow'   => 'DISCUSS YOUR SUPPLY REQUIREMENTS',
						'title'     => 'Request a Manufacturing & Supply Quote',
						'form_type' => 'quote',
						'layout'    => 'split',
					],
				],
			],
		],

		// 4. DRY ICE PRODUCTS (/dry-ice-products/)
		'dry-ice-products' => [
			'title'   => 'Dry Ice Products',
			'excerpt' => 'Explore dry ice pellets, solid dry ice blocks, high-density nuggets, and custom format options supplied by ArcticRestoDRY ICE.',
			'widgets' => [
				[
					'widgetType' => 'ar_breadcrumbs',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_hero',
					'settings'   => [
						'eyebrow'            => 'DRY ICE PRODUCTS & FORMATS',
						'title'              => 'Dry Ice Pellets, Nuggets, Solid Blocks & <em>Custom Supply Formats</em>',
						'subtitle'           => 'Compare solid carbon dioxide formats engineered for rapid food chilling, pharmaceutical cold-chain shipping, extended freight hold times, and industrial applications.',
						'cta1_label'         => 'Request a Product Quote',
						'cta1_url'           => '/contact/#quote',
						'cta2_label'         => 'Compare Format Specs',
						'cta2_url'           => '/quality/',
						'image_url'          => $img . 'dry-ice-pellets.jpg',
						'media_badge_top'    => 'MULTI-FORMAT SOLID CO₂',
						'media_badge_bottom' => 'Pellets · Nuggets · Blocks · Vented Packaging',
						'badges'             => 'Dry Ice Pellets | Dry Ice Nuggets | Solid Dry Ice Blocks | Custom & Scheduled Supply',
					],
				],
				[
					'widgetType' => 'ar_products',
					'settings'   => [
						'source'  => 'repeater',
						'columns' => '2',
					],
				],
				[
					'widgetType' => 'ar_comparison',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_before_after',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_roi',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_lead_form',
					'settings'   => [
						'eyebrow'   => 'PRODUCT QUOTE DESK',
						'title'     => 'Request Specifications & Pricing for Your Dry Ice Format',
						'form_type' => 'quote',
						'layout'    => 'split',
					],
				],
			],
		],

		// 5. DRY ICE PELLETS (/dry-ice-pellets/)
		'dry-ice-pellets' => [
			'title'   => 'Dry Ice Pellets',
			'excerpt' => 'High-density extruded dry ice pellets for food processing, cold-chain shipping, laboratory sample packing, and industrial blast supply.',
			'widgets' => [
				[
					'widgetType' => 'ar_breadcrumbs',
					'settings'   => [
						'parent_label' => 'Dry Ice Products',
						'parent_url'   => '/dry-ice-products/',
					],
				],
				[
					'widgetType' => 'ar_hero',
					'settings'   => [
						'eyebrow'            => 'EXTRUDED DRY ICE PELLETS',
						'title'              => 'High-Density Dry Ice Pellets for <em>Rapid Cooling, Cold-Chain & Industrial Use</em>',
						'subtitle'           => 'Cylindrical extruded solid CO₂ pellets designed for fast thermal transfer, easy pouring around temperature-sensitive packages, laboratory sample packing, and blast media supply.',
						'cta1_label'         => 'Request a Pellet Quote',
						'cta1_url'           => '#quote',
						'cta2_label'         => 'Compare Blocks & Nuggets',
						'cta2_url'           => '/dry-ice-blocks-nuggets/',
						'image_url'          => $img . 'dry-ice-pellets.jpg',
						'media_badge_top'    => 'EXTRUDED SOLID CO₂ PELLETS',
						'media_badge_bottom' => 'Pourable Geometry · High Surface Area · Zero Water Melt',
						'badges'             => 'Fast Thermal Transfer | Easy Void-Fill Packing | Poly-Lined Cartons & Vented Totes | Spot & Recurring Orders',
					],
				],
				[
					'widgetType' => 'ar_bento',
					'settings'   => [
						'eyebrow'  => 'PELLET FORMAT ADVANTAGES & APPLICATIONS',
						'title'    => 'Where Commercial Buyers Use Dry Ice Pellets',
						'subtitle' => 'Extruded pellets offer a high surface-area-to-mass ratio, making them the preferred choice when uniform coverage and rapid heat absorption are required.',
						'items'    => [
							[
								'_id'   => 'pl1',
								'icon'  => 'leaf',
								'tag'   => 'FOOD & PERISHABLE LOGISTICS',
								'title' => 'Food Processing Chilling & Parcel Cold-Chain Packing',
								'desc'  => 'Pellets pour smoothly around frozen pouches, meal kits, and insulated shippers, delivering immediate cooling without water runoff.',
								'span'  => '2',
							],
							[
								'_id'   => 'pl2',
								'icon'  => 'flask',
								'tag'   => 'LABORATORY & HEALTHCARE',
								'title' => 'Specimen Vial Packing & Benchtop Cryo Baths',
								'desc'  => 'Fine and standard pellets pack closely around cryovials, diagnostic tubes, and clinical sample boxes.',
								'span'  => '1',
							],
							[
								'_id'   => 'pl3',
								'icon'  => 'wrench',
								'tag'   => 'INDUSTRIAL & BLAST SUPPLY',
								'title' => 'In-House Dry Ice Blasting & Deflashing Media',
								'desc'  => 'Dense extruded pellets supply plant maintenance and manufacturing equipment requiring consistent solid CO₂ media.',
								'span'  => '1',
							],
						],
					],
				],
				[
					'widgetType' => 'ar_spec_table',
					'settings'   => [
						'eyebrow'    => 'EDITABLE PELLET SPECIFICATIONS',
						'title'      => 'Dry Ice Pellet Format & Packaging Reference Table',
						'subtitle'   => 'Physical constants of solid CO₂ alongside editable pellet size and packaging placeholders.',
						'col1_label' => 'Specification Parameter',
						'col2_label' => 'Fine / Blast Pellets (Placeholder)',
						'col3_label' => 'Standard Cooling Pellets (Placeholder)',
						'col4_label' => 'Verification / Handling Note',
						'rows'       => [
							[ '_id' => 'pr1', 'param' => 'Typical Diameter Range', 'val_a' => '~3 mm (1/8") [Placeholder — confirm die]', 'val_b' => '~6 mm – 9 mm (1/4" – 3/8") [Placeholder]', 'note' => 'Editable placeholder — verify available die diameters with dispatch' ],
							[ '_id' => 'pr2', 'param' => 'Surface Temperature',    'val_a' => '-78.5°C (-109.3°F)',                       'val_b' => '-78.5°C (-109.3°F)',                       'note' => 'Standard sublimation point of solid CO₂ at 1 atm' ],
							[ '_id' => 'pr3', 'param' => 'Primary Use Case',       'val_a' => 'Precision lab packing & blast equipment',  'val_b' => 'Cold-chain parcel packing & food chilling', 'note' => 'Higher surface area = faster initial heat absorption' ],
							[ '_id' => 'pr4', 'param' => 'Packaging Options',      'val_a' => 'Vented insulated totes & lined cartons',   'val_b' => 'Vented insulated totes & lined cartons',    'note' => 'Order close to use time to minimize sublimation loss' ],
							[ '_id' => 'pr5', 'param' => 'Minimum Order Quantity', 'val_a' => '[Placeholder: Confirm MOQ with sales]',    'val_b' => '[Placeholder: Confirm MOQ with sales]',     'note' => 'Editable in Elementor or WP Admin' ],
						],
					],
				],
				[
					'widgetType' => 'ar_safety_notice',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_faq',
					'settings'   => [
						'eyebrow' => 'DRY ICE PELLET FAQS',
						'title'   => 'Frequently Asked Questions About Dry Ice Pellets',
						'items'   => [
							[
								'_id' => 'pfq1',
								'cat' => 'SUBLIMATION',
								'q'   => 'Do dry ice pellets sublimate faster than solid dry ice blocks?',
								'a'   => 'Yes. Because pellets have a higher exposed surface area per pound than a solid block, they absorb heat more rapidly and sublimate faster. Pellets are ideal for rapid cooling and void-fill packing, whereas blocks or large nuggets are preferred when maximizing multi-day hold time is the primary goal.',
							],
							[
								'_id' => 'pfq2',
								'cat' => 'PACKAGING',
								'q'   => 'How are dry ice pellets packaged for delivery or pickup?',
								'a'   => 'Pellets are typically packed in poly-lined insulated cartons or commercial rotationally molded insulated totes that slow heat transfer while allowing CO₂ gas to vent safely.',
							],
							[
								'_id' => 'pfq3',
								'cat' => 'ORDERING',
								'q'   => 'Can we schedule recurring weekly deliveries of dry ice pellets?',
								'a'   => 'Yes. Many commercial buyers schedule recurring weekly or multi-day deliveries timed to their production or outbound shipping waves so pellets are as fresh as possible when used.',
							],
						],
					],
				],
				[
					'widgetType' => 'ar_lead_form',
					'settings'   => [
						'eyebrow'         => 'ORDER DRY ICE PELLETS',
						'title'           => 'Request a Quote for Dry Ice Pellets',
						'form_type'       => 'quote',
						'default_product' => 'pellets',
						'layout'          => 'split',
					],
				],
			],
		],

		// 6. DRY ICE BLOCKS AND NUGGETS (/dry-ice-blocks-nuggets/)
		'dry-ice-blocks-nuggets' => [
			'title'   => 'Dry Ice Blocks and Nuggets',
			'excerpt' => 'Solid dry ice blocks, cut slabs, and high-density nuggets for extended cooling duration, cold-chain transport, and industrial applications.',
			'widgets' => [
				[
					'widgetType' => 'ar_breadcrumbs',
					'settings'   => [
						'parent_label' => 'Dry Ice Products',
						'parent_url'   => '/dry-ice-products/',
					],
				],
				[
					'widgetType' => 'ar_hero',
					'settings'   => [
						'eyebrow'            => 'SOLID BLOCKS, SLABS & DENSE NUGGETS',
						'title'              => 'Dry Ice Blocks & Nuggets for <em>Extended Hold Duration & Transport Cooling</em>',
						'subtitle'           => 'Engineered with lower surface-to-mass geometry to slow sublimation velocity across long-haul freight, commercial catering, cold storage backup, and industrial cooling.',
						'cta1_label'         => 'Request Block / Nugget Quote',
						'cta1_url'           => '#quote',
						'cta2_label'         => 'Compare with Pellets',
						'cta2_url'           => '/dry-ice-pellets/',
						'image_url'          => $img . 'dry-ice-blocks.jpg',
						'media_badge_top'    => 'EXTENDED COOLING DURATION',
						'media_badge_bottom' => 'Compressed Solid Blocks · Cut Slabs · Dense Nuggets',
						'badges'             => 'Slower Sublimation Rate | Stackable Solid Blocks | Pourable Dense Nuggets | Vented Insulated Totes',
					],
				],
				[
					'widgetType' => 'ar_products',
					'settings'   => [
						'eyebrow'  => 'SOLID & HIGH-DENSITY FORMATS',
						'title'    => 'Separately Configurable Block, Slab & Nugget Options',
						'subtitle' => 'Each solid format below can be edited independently in Elementor to reflect your facility’s verified dimensions, weights, packaging, and minimum order quantities.',
						'columns'  => '2',
						'items'    => [
							[
								'_id'          => 'bn1',
								'badge'        => 'COMPRESSED SOLID FORMAT',
								'title'        => 'Solid Dry Ice Blocks & Cut Slabs',
								'image_url'    => $img . 'dry-ice-blocks.jpg',
								'desc'         => 'High-density hydraulic-pressed solid carbon dioxide blocks and cut slabs. Compact geometry minimizes exposed surface area to deliver the slowest sublimation rate among dry ice formats.',
								'sizes'        => '[Editable Placeholder: Configure standard full-block weight & custom cut slab dimensions]',
								'packaging'    => 'Kraft / poly-bagged blocks packed inside vented insulated totes or pallet containers',
								'use_cases'    => 'Long-haul refrigerated freight backup | Airline & commercial catering galleys | Prolonged cold-chain hold | Emergency freezer backup',
								'detail_label' => 'View Quality & Specs',
								'detail_url'   => '/quality/',
								'quote_label'  => 'Request Block Quote',
								'quote_url'    => '#quote',
							],
							[
								'_id'          => 'bn2',
								'badge'        => 'LARGE-DIAMETER EXTRUDED FORMAT',
								'title'        => 'High-Density Dry Ice Nuggets',
								'image_url'    => $img . 'dry-ice-nuggets.jpg',
								'desc'         => 'Dense cylindrical dry ice nuggets extruded through larger-diameter dies. Combines longer hold duration than small pellets with easy scooping and void distribution.',
								'sizes'        => '[Editable Placeholder: Configure nugget diameter & length, e.g., 16 mm – 19 mm (5/8" – 3/4")]',
								'packaging'    => 'Vented insulated totes & heavy-duty poly-lined shipping cartons',
								'use_cases'    => 'Multi-day cold-chain distribution | Foodservice & commissary transport | Industrial process cooling baths | Bulk tote rotation',
								'detail_label' => 'View Quality & Specs',
								'detail_url'   => '/quality/',
								'quote_label'  => 'Request Nugget Quote',
								'quote_url'    => '#quote',
							],
						],
					],
				],
				[
					'widgetType' => 'ar_spec_table',
					'settings'   => [
						'eyebrow'    => 'BLOCKS VS. NUGGETS COMPARISON',
						'title'      => 'Technical & Operational Comparison: Blocks vs. Nuggets',
						'col1_label' => 'Characteristic',
						'col2_label' => 'Solid Dry Ice Blocks / Slabs',
						'col3_label' => 'Dry Ice Nuggets',
						'col4_label' => 'Buyer Selection Note',
						'rows'       => [
							[ '_id' => 'bnr1', 'param' => 'Sublimation Endurance', 'val_a' => 'Slowest sublimation (lowest surface-to-volume)', 'val_b' => 'Moderate-slow sublimation (denser than small pellets)', 'note' => 'Choose blocks for longest hold; nuggets for pourable endurance' ],
							[ '_id' => 'bnr2', 'param' => 'Loading & Handling',    'val_a' => 'Stacked manually or with tongs/gloves',         'val_b' => 'Scooped or poured around containers',                   'note' => 'Always wear insulated gloves & eye protection' ],
							[ '_id' => 'bnr3', 'param' => 'Format Availability',   'val_a' => '[Editable Placeholder — Confirm with dispatch]','val_b' => '[Editable Placeholder — Confirm with dispatch]',        'note' => 'Subject to production scheduling & order volume' ],
							[ '_id' => 'bnr4', 'param' => 'Minimum Order (MOQ)',   'val_a' => '[Editable Placeholder — Set verified MOQ]',     'val_b' => '[Editable Placeholder — Set verified MOQ]',             'note' => 'Contact sales desk for spot or recurring minimums' ],
						],
					],
				],
				[
					'widgetType' => 'ar_safety_notice',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_lead_form',
					'settings'   => [
						'eyebrow'         => 'ORDER BLOCKS OR NUGGETS',
						'title'           => 'Request a Quote for Dry Ice Blocks or Nuggets',
						'form_type'       => 'quote',
						'default_product' => 'blocks',
						'layout'          => 'split',
					],
				],
			],
		],

		// 7. BULK DRY ICE ORDERS (/bulk-orders/)
		'bulk-orders' => [
			'title'   => 'Bulk Dry Ice Orders',
			'excerpt' => 'Request bulk dry ice supply, standing recurring deliveries, commercial insulated tote rotation programs, and multi-pallet orders from ArcticRestoDRY ICE.',
			'widgets' => [
				[
					'widgetType' => 'ar_breadcrumbs',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_hero',
					'settings'   => [
						'eyebrow'            => 'COMMERCIAL & INDUSTRIAL BULK SUPPLY',
						'title'              => 'Bulk Dry Ice Orders & <em>Recurring Supply Programs</em>',
						'subtitle'           => 'Coordinated high-volume dry ice pellets, nuggets, and blocks supplied in commercial insulated totes or palletized containers — scheduled around your receiving dock and production calendar.',
						'cta1_label'         => 'Submit Bulk Order Inquiry',
						'cta1_url'           => '#quote',
						'cta2_label'         => 'Check Delivery Coverage',
						'cta2_url'           => '/delivery-areas/',
						'image_url'          => $img . 'bulk-supply-logistics.jpg',
						'media_badge_top'    => 'STANDING & HIGH-VOLUME ACCOUNTS',
						'media_badge_bottom' => 'Weekly · Bi-Weekly · Monthly · Custom Tote Rotation',
						'badges'             => 'Commercial Insulated Totes | Standing Delivery Schedules | Multi-Format Pallet Orders | Dedicated Dispatch Coordination',
					],
				],
				[
					'widgetType' => 'ar_pricing',
					'settings'   => [
						'eyebrow'  => 'COMMERCIAL SUPPLY PROGRAMS',
						'title'    => 'Structured Bulk & Recurring Dry Ice Fulfillment Programs',
						'subtitle' => 'Compare spot bulk fulfillment, standing recurring schedules, and high-volume multi-tote commercial programs.',
					],
				],
				[
					'widgetType' => 'ar_franchise_calc',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_bento',
					'settings'   => [
						'eyebrow'  => 'BULK LOGISTICS & CONTAINER MANAGEMENT',
						'title'    => 'How Commercial Tote Rotation, Packaging & Advance Planning Work',
						'subtitle' => 'High-volume dry ice buyers rely on disciplined container insulation and predictable delivery windows.',
						'items'    => [
							[
								'_id'   => 'bk1',
								'icon'  => 'package',
								'tag'   => 'INSULATED TOTE ROTATION',
								'title' => 'Heavy-Duty Rotomolded Insulated Totes & Pallet Shippers',
								'desc'  => 'Bulk orders can be supplied in heavy-duty vented insulated totes that minimize daily sublimation loss and allow forklift handling at your receiving dock.',
								'span'  => '2',
							],
							[
								'_id'   => 'bk2',
								'icon'  => 'clock',
								'tag'   => 'ADVANCE PLANNING',
								'title' => 'Production Reserved for Your Scheduled Delivery Days',
								'desc'  => 'Standing accounts lock in recurring production slots so fresh dry ice is pressed and packed immediately prior to route departure.',
								'span'  => '1',
							],
							[
								'_id'   => 'bk3',
								'icon'  => 'truck',
								'tag'   => 'DELIVERY OR COLLECTION',
								'title' => 'Dock-to-Dock Delivery or Scheduled Will-Call Pickup',
								'desc'  => 'Choose scheduled route delivery to your facility dock or arrange timed collection in approved vented insulated containers.',
								'span'  => '1',
							],
						],
					],
				],
				[
					'widgetType' => 'ar_roi',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_faq',
					'settings'   => [
						'eyebrow' => 'PROCUREMENT & BULK ORDER FAQS',
						'title'   => 'Questions from Commercial Buyers & Operations Managers',
						'items'   => [
							[
								'_id' => 'bkf1',
								'cat' => 'RECURRING ORDERS',
								'q'   => 'Can we adjust our weekly dry ice volume during seasonal cold-chain peaks?',
								'a'   => 'Yes. Standing commercial accounts can coordinate volume adjustments in advance of seasonal shipping peaks, production campaigns, or planned plant turnarounds.',
							],
							[
								'_id' => 'bkf2',
								'cat' => 'CONTAINERS',
								'q'   => 'Do you supply insulated bulk totes or can we use our own vented containers?',
								'a'   => 'We can coordinate supply in commercial insulated totes, poly-lined pallet cartons, or approved customer-owned vented insulated containers after verifying container condition and venting safety.',
							],
							[
								'_id' => 'bkf3',
								'cat' => 'MIXED FORMATS',
								'q'   => 'Can a single bulk order include both dry ice pellets and solid blocks?',
								'a'   => 'Yes. Select "Mixed Formats (Pellets + Blocks/Nuggets)" in the bulk inquiry form below and note the approximate breakdown in the requirements field.',
							],
						],
					],
				],
				[
					'widgetType' => 'ar_lead_form',
					'settings'   => [
						'eyebrow'      => 'BULK & RECURRING SUPPLY QUOTE FORM',
						'title'        => 'Submit Your Bulk Dry Ice or Standing Account Inquiry',
						'subtitle'     => 'Complete the procurement form below with your product format, estimated volume, required date, order frequency, and delivery location.',
						'form_type'    => 'bulk',
						'layout'       => 'split',
						'submit_label' => 'Submit Bulk & Recurring Supply Request',
					],
				],
			],
		],

		// 8. INDUSTRIES WE SERVE (/industries/)
		'industries' => [
			'title'   => 'Industries We Serve',
			'excerpt' => 'Dry ice supply solutions for food processing, pharmaceuticals, healthcare, laboratories, manufacturing, automotive engineering, and cold-chain logistics.',
			'widgets' => [
				[
					'widgetType' => 'ar_breadcrumbs',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_hero',
					'settings'   => [
						'eyebrow'            => 'COMMERCIAL, LIFE-SCIENCE & INDUSTRIAL SECTORS',
						'title'              => 'Industries Served by <em>ArcticRestoDRY ICE</em>',
						'subtitle'           => 'Each industry places distinct demands on dry ice format geometry, packaging hygiene, sublimation buffer planning, and delivery timing.',
						'cta1_label'         => 'Request an Industry Quote',
						'cta1_url'           => '#quote',
						'cta2_label'         => 'Explore Applications',
						'cta2_url'           => '/dry-ice-applications/',
						'image_url'          => $img . 'industry-food-coldchain.jpg',
						'media_badge_top'    => '8 CORE COMMERCIAL SECTORS',
						'media_badge_bottom' => 'Food · Pharma · Healthcare · Manufacturing · Cold-Chain',
						'badges'             => 'Food Processing | Pharmaceuticals & Biotech | Healthcare & Labs | Industrial Manufacturing | Cold-Chain Freight',
					],
				],
				[
					'widgetType' => 'ar_industries',
					'settings'   => [
						'source'  => 'repeater',
						'columns' => '4',
					],
				],
				[
					'widgetType' => 'ar_cases',
					'settings'   => [
						'eyebrow'  => 'SECTOR SUPPLY & PACKAGING CONSIDERATIONS',
						'title'    => 'How Format Selection & Supply Planning Vary by Sector',
						'subtitle' => 'Review typical format pairings and container strategies across food, pharmaceutical, and industrial environments.',
					],
				],
				[
					'widgetType' => 'ar_safety_notice',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_lead_form',
					'settings'   => [
						'eyebrow'   => 'SECTOR SUPPLY COORDINATION',
						'title'     => 'Request a Dry Ice Quote for Your Industry',
						'form_type' => 'quote',
						'layout'    => 'split',
					],
				],
			],
		],
	];
}
