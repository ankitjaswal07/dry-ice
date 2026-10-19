<?php
/**
 * ArcticRestoDRY ICE — Demo Pages Part 2 (Pages 9–16).
 *
 * Builds valid Elementor Flexbox Container + Widget trees for:
 * 9.  Dry Ice Applications (/dry-ice-applications/)
 * 10. Delivery and Supply Areas (/delivery-areas/)
 * 11. Dry Ice Safety, Handling and Storage (/dry-ice-safety/)
 * 12. Quality and Product Specifications (/quality/)
 * 13. Frequently Asked Questions (/faq/)
 * 14. Request a Quote / Contact (/contact/)
 * 15. Blog and Resources (/blog/)
 * 16. Privacy Policy (/privacy-policy/)
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ar_demo_pages_part2(): array {
	$img = AR_URI . '/assets/images/';

	return [
		// 9. DRY ICE APPLICATIONS (/dry-ice-applications/)
		'dry-ice-applications' => [
			'title'   => 'Dry Ice Applications',
			'excerpt' => 'Practical guide to dry ice applications: cold-chain shipping, food temperature control, biological sample transport, shrink-fitting, and industrial process cooling.',
			'widgets' => [
				[
					'widgetType' => 'ar_breadcrumbs',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_hero',
					'settings'   => [
						'eyebrow'            => 'DRY ICE APPLICATIONS & USE CASES',
						'title'              => 'Practical Uses of Dry Ice in <em>Cooling, Transport & Industrial Operations</em>',
						'subtitle'           => 'Discover how product format geometry, insulated container selection, and replenishment frequency are matched to cold-chain shipping, food chilling, laboratory specimen transit, and industrial process cooling.',
						'cta1_label'         => 'Request an Application Quote',
						'cta1_url'           => '#quote',
						'cta2_label'         => 'Compare Product Formats',
						'cta2_url'           => '/dry-ice-products/',
						'image_url'          => $img . 'industry-pharma-lab.jpg',
						'media_badge_top'    => 'ZERO-WATER-RESIDUE COOLING',
						'media_badge_bottom' => 'Cold-Chain · Food Chilling · Specimen Transport · Shrink-Fitting',
						'badges'             => 'Temperature-Controlled Transport | Food Processing Cooling | Specimen & Reagent Shipping | Industrial Process Cooling',
					],
				],
				[
					'widgetType' => 'ar_services',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_cases',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_comparison',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_process',
					'settings'   => [
						'eyebrow'  => 'BUYER SPECIFICATION GUIDE',
						'title'    => 'How to Request the Right Dry Ice Format for Your Application',
						'subtitle' => 'Share these four operational details when submitting a quote so our team can recommend the right format and container.',
						'steps'    => [
							[ '_id' => 'ap1', 'step' => 'DETAIL 01', 'title' => 'Target Temperature & Application', 'desc' => 'Let us know whether you are packing frozen parcels, chilling food mixes, shipping clinical vials, or cooling industrial parts.' ],
							[ '_id' => 'ap2', 'step' => 'DETAIL 02', 'title' => 'Total Hold Duration (Hours or Days)', 'desc' => 'Specify how long the dry ice must maintain cooling between dispatch and final unpacking so sublimation buffer weight can be factored in.' ],
							[ '_id' => 'ap3', 'step' => 'DETAIL 03', 'title' => 'Preferred Format Geometry', 'desc' => 'Choose pellets for rapid cooling and void fill, nuggets for balanced pourable endurance, or solid blocks for slowest sublimation.' ],
							[ '_id' => 'ap4', 'step' => 'DETAIL 04', 'title' => 'Container & Replenishment Cadence', 'desc' => 'Indicate whether you need poly-lined cartons, commercial insulated totes, or a standing weekly/bi-weekly replenishment schedule.' ],
						],
					],
				],
				[
					'widgetType' => 'ar_lead_form',
					'settings'   => [
						'eyebrow'   => 'APPLICATION QUOTE DESK',
						'title'     => 'Get Format & Volume Recommendations for Your Application',
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

		// 10. DELIVERY AND SUPPLY AREAS (/delivery-areas/)
		'delivery-areas' => [
			'title'   => 'Delivery and Supply Areas',
			'excerpt' => 'Check dry ice delivery coverage, local collection options, recurring commercial route availability, and order minimum guidelines.',
			'widgets' => [
				[
					'widgetType' => 'ar_breadcrumbs',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_territory_hero',
					'settings'   => [
						'region' => 'DELIVERY & SUPPLY COVERAGE',
						'title'  => 'Dry Ice Delivery, Route Coordination & Collection Areas',
						'sub'    => 'Review our admin-editable delivery and collection framework below. Where coverage for your city, state, or postal code is not yet specified, contact our supply team directly to confirm availability.',
					],
				],
				[
					'widgetType' => 'ar_territory_checker',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_territory_grid',
					'settings'   => [
						'show_map_placeholder' => 'yes',
					],
				],
				[
					'widgetType' => 'ar_faq',
					'settings'   => [
						'eyebrow' => 'DELIVERY, PICKUP & TRANSIT FAQS',
						'title'   => 'Questions About Dry Ice Delivery Coverage, Collection & Transit Windows',
						'items'   => [
							[
								'_id' => 'dfq1',
								'cat' => 'COVERAGE CONFIRMATION',
								'q'   => 'How do I confirm if ArcticRestoDRY ICE delivers to my facility location?',
								'a'   => 'Because dry ice sublimates continuously in transit, delivery feasibility depends on your location, order volume, insulated container type, and route schedule. Submit your city, state, and ZIP code in the Service-Area Inquiry form below and our dispatch team will confirm coverage or collection options.',
							],
							[
								'_id' => 'dfq2',
								'cat' => 'LOCAL COLLECTION',
								'q'   => 'Can customers arrange local pickup / collection?',
								'a'   => 'Where local collection is offered, orders must be scheduled in advance and transported in approved vented insulated containers inside a well-ventilated vehicle cargo area. Contact our team to confirm collection procedures and hours.',
							],
							[
								'_id' => 'dfq3',
								'cat' => 'SUBLIMATION IN TRANSIT',
								'q'   => 'Why does transit distance affect minimum order quantities and packaging?',
								'a'   => 'Dry ice loses weight continuously through natural sublimation (typically 5%–10% per 24 hours in insulated containers). Longer transit routes require thicker-walled insulated totes or larger order weights to ensure sufficient usable dry ice arrives at your receiving dock.',
							],
						],
					],
				],
				[
					'widgetType' => 'ar_lead_form',
					'settings'   => [
						'eyebrow'      => 'SERVICE-AREA & DELIVERY INQUIRY',
						'title'        => 'Confirm Dry Ice Delivery or Collection Availability for Your Location',
						'subtitle'     => 'Enter your facility location, requested dry ice format, and estimated order volume so our dispatch team can confirm route coverage.',
						'form_type'    => 'service_area',
						'layout'       => 'split',
						'submit_label' => 'Check Delivery & Supply Availability',
					],
				],
			],
		],

		// 11. DRY ICE SAFETY, HANDLING AND STORAGE (/dry-ice-safety/)
		'dry-ice-safety' => [
			'title'   => 'Dry Ice Safety, Handling and Storage',
			'excerpt' => 'Essential dry ice safety, PPE, CO₂ ventilation, and storage guide. Learn why solid carbon dioxide (-78.5°C / -109.3°F) requires insulated gloves and vented containers.',
			'widgets' => [
				[
					'widgetType' => 'ar_breadcrumbs',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_hero',
					'settings'   => [
						'eyebrow'            => 'ESSENTIAL CRYOGENIC & CO₂ SAFETY GUIDE',
						'title'              => 'Dry Ice Safety, Handling, Ventilation & <em>Storage Best Practices</em>',
						'subtitle'           => 'Dry ice is solid carbon dioxide (CO₂) at -78.5°C (-109.3°F). Safe handling requires insulated personal protective equipment, continuous air ventilation, and non-airtight vented storage containers.',
						'cta1_label'         => 'Download / Request SDS Info',
						'cta1_url'           => '/quality/',
						'cta2_label'         => 'Contact Supply Desk',
						'cta2_url'           => '/contact/#quote',
						'image_url'          => $img . 'dry-ice-safety-ppe.jpg',
						'media_badge_top'    => 'HAZARD AWARENESS · UN 1845',
						'media_badge_bottom' => '-78.5°C (-109.3°F) · Insulated PPE · Vented Storage Only',
						'badges'             => 'Insulated Cryogenic Gloves & Eye PPE | Continuous Room & Vehicle Ventilation | Never Use Airtight Containers | SDS & Emergency Readiness',
					],
				],
				[
					'widgetType' => 'ar_safety_notice',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_bento',
					'settings'   => [
						'eyebrow'  => 'COMPREHENSIVE SAFETY & STORAGE PROTOCOLS',
						'title'    => 'Eight Critical Dry Ice Safety Rules for Facilities, Labs & Drivers',
						'subtitle' => 'Review these operational guidelines with every staff member who receives, stores, packs, or transports dry ice.',
						'items'    => [
							[
								'_id'   => 'sf1',
								'icon'  => 'wind',
								'tag'   => '1. CO₂ SUBLIMATION & CONFINED SPACES',
								'title' => 'Carbon Dioxide Gas Displaces Oxygen in Low & Enclosed Areas',
								'desc'  => 'As dry ice sublimates, 1 kg of solid CO₂ generates approximately 541 liters of cold carbon dioxide gas. Because CO₂ is roughly 1.5 times denser than air, it sinks and accumulates in pits, basements, walk-in coolers, and closed vehicle cabs. High CO₂ concentrations can cause dizziness, rapid breathing, unconsciousness, or asphyxiation.',
								'span'  => '2',
							],
							[
								'_id'   => 'sf2',
								'icon'  => 'thermometer',
								'tag'   => '2. CRYOGENIC BURN HAZARD',
								'title' => 'Extreme Cold (-78.5°C / -109.3°F) Causes Instant Frostbite',
								'desc'  => 'Direct skin or mouth contact with dry ice freezes tissue rapidly, causing severe thermal burns similar to heat burns. Never touch dry ice with bare hands and never ingest dry ice or place it directly in beverages.',
								'span'  => '1',
							],
							[
								'_id'   => 'sf3',
								'icon'  => 'shield',
								'tag'   => '3. REQUIRED PERSONAL PROTECTIVE EQUIPMENT',
								'title' => 'Insulated Gloves, Eye Protection & Handling Tools',
								'desc'  => 'Always wear loose-fitting insulated cryogenic or leather gloves, safety glasses or a face shield (especially when chipping or scooping), and closed-toe shoes. Use metal or heavy-duty scoops and tongs.',
								'span'  => '1',
							],
							[
								'_id'   => 'sf4',
								'icon'  => 'alert',
								'tag'   => '4. CONTAINER RUPTURE / EXPLOSION HAZARD',
								'title' => 'Why Airtight Containers Must Never Be Used',
								'desc'  => 'Sealing dry ice inside an airtight glass jar, screw-top plastic bottle, latched pressure vessel, or unvented cooler traps sublimating CO₂ gas. Internal pressure rises rapidly until the container ruptures or explodes violently.',
								'span'  => '2',
							],
							[
								'_id'   => 'sf5',
								'icon'  => 'package',
								'tag'   => '5. APPROVED STORAGE CONTAINERS',
								'title' => 'Use Purpose-Built Vented Insulated Totes & Coolers',
								'desc'  => 'Store dry ice in thick-walled polystyrene, polyurethane, or rotationally molded polyethylene insulated containers designed to let gas escape freely. Do not store dry ice inside airtight household freezers or unventilated walk-in coolers.',
								'span'  => '1',
							],
							[
								'_id'   => 'sf6',
								'icon'  => 'truck',
								'tag'   => '6. VEHICLE TRANSPORT SAFETY',
								'title' => 'Separate Cargo Area & Fresh-Air Ventilation',
								'desc'  => 'Transport dry ice in a truck bed or cargo van partitioned from the passenger compartment. If transporting in a vehicle without a sealed bulkhead, set climate control to fresh outside air (not recirculate) and keep windows slightly open.',
								'span'  => '1',
							],
							[
								'_id'   => 'sf7',
								'icon'  => 'flask',
								'tag'   => '7. FOOD, LAB & INDUSTRIAL HANDLING',
								'title' => 'Sector-Specific Hygiene & Disposal Practices',
								'desc'  => 'Use clean scoops for food-contact environments, label UN 1845 packages accurately for laboratory/air shipments, and allow unused dry ice remnants to sublimate in a secure, well-ventilated outdoor or exhaust-hood area — never dispose of dry ice in sinks, drains, or trash compactors.',
								'span'  => '2',
							],
						],
					],
				],
				[
					'widgetType' => 'ar_hotspots',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_spec_sheet',
					'settings'   => [
						'eyebrow'  => 'EMERGENCY RESPONSE & SDS SUMMARY',
						'title'    => 'First Aid, Exposure Response & Safety Data Sheet Reference',
						'subtitle' => 'Keep your facility Carbon Dioxide, Solid (UN 1845) Safety Data Sheet accessible in all receiving and storage areas.',
						'rows'     => [
							[ '_id' => 'em1', 'k' => 'Skin Contact / Frostbite First Aid', 'v' => 'Remove contact immediately. Warm affected area gently with lukewarm water (never hot water or dry heat); do not rub frozen tissue. Seek medical attention.' ],
							[ '_id' => 'em2', 'k' => 'CO₂ Inhalation / Dizziness Response', 'v' => 'Move affected person immediately to fresh air. If breathing is difficult or person is unresponsive, call emergency services and administer oxygen via trained personnel.' ],
							[ '_id' => 'em3', 'k' => 'Spill / Unused Dry Ice Disposal',     'v' => 'Ventilate area thoroughly. Using insulated gloves, transfer spilled dry ice into a vented container or allow it to sublimate in a well-ventilated, restricted area away from drains.' ],
							[ '_id' => 'em4', 'k' => 'UN Identification & Shipping Name',   'v' => 'UN 1845 — Carbon Dioxide, Solid (Dry Ice) · Hazard Class 9 (when transported by air/water)' ],
						],
					],
				],
				[
					'widgetType' => 'ar_author_box',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_cta',
					'settings'   => [],
				],
			],
		],

		// 12. QUALITY AND PRODUCT SPECIFICATIONS (/quality/)
		'quality' => [
			'title'   => 'Quality and Product Specifications',
			'excerpt' => 'Dry ice product specifications, compaction consistency, handling discipline, packaging integrity, and technical documentation request center.',
			'widgets' => [
				[
					'widgetType' => 'ar_breadcrumbs',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_hero',
					'settings'   => [
						'eyebrow'            => 'QUALITY CONTROL & TECHNICAL SPECIFICATIONS',
						'title'              => 'Dry Ice Product Specifications, <em>Compaction Consistency & Packaging Integrity</em>',
						'subtitle'           => 'Review physical properties of solid carbon dioxide, editable format parameters, packaging standards, and documentation placeholders.',
						'cta1_label'         => 'Request Spec Confirmation',
						'cta1_url'           => '#quote',
						'cta2_label'         => 'Safety & Storage Guide',
						'cta2_url'           => '/dry-ice-safety/',
						'image_url'          => $img . 'quality-control.jpg',
						'media_badge_top'    => 'QUALITY & HANDLING DISCIPLINE',
						'media_badge_bottom' => 'Consistent Compaction · Clean Liner Handling · Vented Packaging',
						'badges'             => 'Uniform Pellet & Block Compaction | Clean Poly-Lined Containers | Production-Timed Dispatch | Transparent Specifications',
					],
				],
				[
					'widgetType' => 'ar_cert_strip',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_spec_table',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_spec_sheet',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_lead_form',
					'settings'   => [
						'eyebrow'   => 'SPECIFICATION & DOCUMENTATION INQUIRY',
						'title'     => 'Request Batch Specifications, SDS Documentation, or a Supply Quote',
						'form_type' => 'quote',
						'layout'    => 'split',
					],
				],
			],
		],

		// 13. FREQUENTLY ASKED QUESTIONS (/faq/)
		'faq' => [
			'title'   => 'Frequently Asked Questions',
			'excerpt' => 'Complete answers to common questions about dry ice pellets, blocks, nuggets, sublimation rates, safe storage, minimum orders, bulk delivery, and PPE.',
			'widgets' => [
				[
					'widgetType' => 'ar_breadcrumbs',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_hero',
					'settings'   => [
						'eyebrow'            => 'DRY ICE KNOWLEDGE BASE & BUYER FAQS',
						'title'              => 'Frequently Asked Questions About <em>Dry Ice Supply, Storage & Safety</em>',
						'subtitle'           => 'Comprehensive answers covering dry ice formats, sublimation rates, safe container selection, order planning, bulk recurring programs, and handling PPE.',
						'cta1_label'         => 'Request a Quote',
						'cta1_url'           => '/contact/#quote',
						'cta2_label'         => 'Safety & Storage Guide',
						'cta2_url'           => '/dry-ice-safety/',
						'image_url'          => $img . 'insulated-containers.jpg',
						'media_badge_top'    => '12 CORE BUYER & SAFETY TOPICS',
						'media_badge_bottom' => 'Formats · Sublimation · Storage · Ordering · Safety',
						'badges'             => 'Pellets vs. Blocks vs. Nuggets | Sublimation & Hold Time | Vented Container Rules | Bulk & Recurring Supply',
					],
				],
				[
					'widgetType' => 'ar_faq',
					'settings'   => [
						'eyebrow'  => 'COMPLETE DRY ICE FAQ DIRECTORY',
						'title'    => '12 Essential Questions Every Dry Ice Buyer Should Know',
						'subtitle' => 'All FAQ items below are fully editable in Elementor.',
						'items'    => [
							[
								'_id' => 'fq1',
								'cat' => '1. DRY ICE BASICS',
								'q'   => 'What is dry ice and how does it work?',
								'a'   => 'Dry ice is the solid form of carbon dioxide (CO₂). At standard atmospheric pressure, it has a surface temperature of -78.5°C (-109.3°F). Instead of melting into a liquid as it absorbs heat, dry ice sublimates directly from a solid into cold carbon dioxide gas — providing powerful cooling capacity with zero liquid water residue.',
							],
							[
								'_id' => 'fq2',
								'cat' => '2. PRODUCT FORMATS',
								'q'   => 'What are the differences between dry ice pellets, blocks, and nuggets?',
								'a'   => 'Dry ice pellets are small cylindrical extrusions with high surface area for rapid cooling, pouring around irregular packages, and blast media supply. Dry ice nuggets are larger-diameter extrusions that remain pourable while sublimating more slowly than small pellets. Solid dry ice blocks have the lowest surface-to-mass ratio and sublimate slowest, making them ideal for long-haul transport and extended cooling.',
							],
							[
								'_id' => 'fq3',
								'cat' => '3. SUBLIMATION RATES',
								'q'   => 'How long does dry ice last and what is its typical sublimation rate?',
								'a'   => 'Dry ice sublimates continuously from the moment it is manufactured. In a well-insulated commercial container, dry ice typically sublimates at roughly 5% to 10% per 24 hours. Actual loss depends on container insulation thickness (R-value), ambient temperature, product format (blocks last longer than small pellets), and how often the container is opened.',
							],
							[
								'_id' => 'fq4',
								'cat' => '4. SAFE STORAGE',
								'q'   => 'How should dry ice be stored safely at our facility?',
								'a'   => 'Store dry ice inside a purpose-built, non-airtight insulated container or rotomolded tote placed in a cool, well-ventilated room. Keep containers out of direct sunlight and away from unventilated basements, walk-in coolers, or small closed rooms where sublimating CO₂ gas could accumulate.',
							],
							[
								'_id' => 'fq5',
								'cat' => '5. CONTAINERS TO USE & AVOID',
								'q'   => 'What containers should and should not be used for dry ice?',
								'a'   => 'USE: Vented rotationally molded insulated totes, thick-walled expanded polystyrene (EPS) or polyurethane coolers, and poly-lined insulated shipping cartons that allow gas to vent freely. DO NOT USE: Airtight glass jars, sealed metal cans, screw-top plastic containers, or latched pressure-tight coolers, as trapped CO₂ gas builds extreme pressure and can cause the vessel to rupture or explode. Also avoid placing dry ice directly onto bare tile or laminate countertops or inside airtight household freezers.',
							],
							[
								'_id' => 'fq6',
								'cat' => '6. ORDER SIZING',
								'q'   => 'How much dry ice should I order for common cooling or shipping needs?',
								'a'   => 'Order weight depends on payload mass, target temperature, container insulation, and total transit or storage duration. Always include a sublimation buffer for every 24 hours between pickup/delivery and final unpacking. Use our on-page Sublimation Estimator or share your transit timeline in our Quote Form for a tailored recommendation.',
							],
							[
								'_id' => 'fq7',
								'cat' => '7. MINIMUM ORDER QUANTITIES',
								'q'   => 'What is your minimum order quantity (MOQ)?',
								'a'   => '[Editable Placeholder: Minimum order quantities vary depending on product format (pellets, nuggets, or blocks) and whether the order is for local facility collection or route delivery. Contact our supply desk via the Request a Quote form to confirm current minimum order weights.]',
							],
							[
								'_id' => 'fq8',
								'cat' => '8. BULK & RECURRING ORDERS',
								'q'   => 'Do you offer bulk orders and recurring weekly or monthly supply programs?',
								'a'   => 'Yes. ArcticRestoDRY ICE supports commercial bulk orders, multi-tote pallet shipments, and standing recurring delivery schedules (weekly, bi-weekly, monthly, or custom multi-day cadences) aligned with your receiving dock and production shifts.',
							],
							[
								'_id' => 'fq9',
								'cat' => '9. DELIVERY & PICKUP OPTIONS',
								'q'   => 'What delivery and local pickup options are available?',
								'a'   => '[Editable Placeholder: Delivery route availability and local collection options depend on your facility location, order volume, and transit window. Visit our Delivery & Supply Areas page or submit a location inquiry to confirm fulfillment options for your address.]',
							],
							[
								'_id' => 'fq10',
								'cat' => '10. SAFETY PRECAUTIONS & PPE',
								'q'   => 'What safety precautions and personal protective equipment (PPE) are required?',
								'a'   => 'Always wear insulated cryogenic or leather gloves and eye protection when handling dry ice (-78.5°C / -109.3°F) to prevent severe frostbite. Use scoops or tongs rather than bare hands, ensure continuous room and vehicle ventilation, and keep a Carbon Dioxide, Solid (UN 1845) Safety Data Sheet accessible.',
							],
							[
								'_id' => 'fq11',
								'cat' => '11. INDUSTRY APPLICATIONS',
								'q'   => 'Which industries commonly use dry ice from ArcticRestoDRY ICE?',
								'a'   => 'We serve food processing and food logistics, pharmaceuticals and life sciences, healthcare and hospital laboratories, industrial manufacturing, automotive shrink-fitting and engineering, research institutions, cold-chain freight carriers, and commercial backup cooling.',
							],
							[
								'_id' => 'fq12',
								'cat' => '12. DRY ICE CLEANING SERVICES',
								'q'   => 'What if I need professional on-site dry ice cleaning or blasting services instead of dry ice supply?',
								'a'   => 'ArcticRestoDRY ICE focuses on manufacturing and supplying dry ice products (pellets, blocks, and nuggets). If you need a professional mobile crew to perform on-site dry ice blasting, equipment cleaning, or surface restoration, please visit our sister service division at https://arcticresto.com/.',
							],
						],
					],
				],
				[
					'widgetType' => 'ar_ai_assist',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_cta',
					'settings'   => [],
				],
			],
		],

		// 14. REQUEST A QUOTE / CONTACT (/contact/)
		'contact' => [
			'title'   => 'Request a Quote / Contact',
			'excerpt' => 'Request a dry ice quote, schedule recurring bulk supply, verify delivery coverage, or contact the ArcticRestoDRY ICE coordination team.',
			'widgets' => [
				[
					'widgetType' => 'ar_breadcrumbs',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_hero',
					'settings'   => [
						'eyebrow'            => 'REQUEST A QUOTE & SUPPLY DESK',
						'title'              => 'Request a Dry Ice Quote or <em>Contact Our Supply Team</em>',
						'subtitle'           => 'Submit a product quote request, bulk recurring supply inquiry, delivery coverage check, or general business question. Contact details in the side panel are controlled via Appearance → Customize.',
						'cta1_label'         => 'Jump to Quote Form',
						'cta1_url'           => '#quote',
						'cta2_label'         => 'Bulk Order Program',
						'cta2_url'           => '/bulk-orders/',
						'image_url'          => $img . 'bulk-supply-logistics.jpg',
						'media_badge_top'    => 'DIRECT QUOTE COORDINATION',
						'media_badge_bottom' => 'Product Quotes · Bulk Supply · Delivery Verification',
						'badges'             => 'Product Format Quotes | Recurring Supply Contracts | Delivery Area Checks | Responsive Coordination',
					],
				],
				[
					'widgetType' => 'ar_lead_form',
					'settings'   => [
						'eyebrow'   => 'QUOTE & INQUIRY FORM',
						'title'     => 'Tell Us About Your Dry Ice Requirements',
						'subtitle'  => 'Select your inquiry category, product format, estimated quantity, and delivery location below.',
						'form_type' => 'quote',
						'layout'    => 'split',
					],
				],
				[
					'widgetType' => 'ar_process',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_cross_promo',
					'settings'   => [],
				],
			],
		],

		// 15. BLOG AND RESOURCES (/blog/)
		'blog' => [
			'title'   => 'Blog and Resources',
			'excerpt' => 'Technical articles and buyer guides on dry ice manufacturing, pellets vs. blocks, sublimation management, cold-chain packaging, and safe CO₂ handling.',
			'widgets' => [
				[
					'widgetType' => 'ar_breadcrumbs',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_hero',
					'settings'   => [
						'eyebrow'            => 'DRY ICE TECHNICAL RESOURCE CENTER',
						'title'              => 'Dry Ice Guides, Cold-Chain Logistics & <em>Safety Resources</em>',
						'subtitle'           => 'Explore in-depth technical articles on how dry ice is manufactured, choosing between pellets and blocks, managing sublimation in transit, and safe CO₂ handling.',
						'cta1_label'         => 'Request a Supply Quote',
						'cta1_url'           => '/contact/#quote',
						'cta2_label'         => 'Safety & Storage Guide',
						'cta2_url'           => '/dry-ice-safety/',
						'image_url'          => $img . 'industry-pharma-lab.jpg',
						'media_badge_top'    => '8+ TECHNICAL GUIDES',
						'media_badge_bottom' => 'Manufacturing · Sublimation · Cold-Chain · Safety',
						'badges'             => 'Dry Ice Manufacturing | Pellets vs. Blocks | Sublimation Planning | Food & Pharma Cold-Chain',
					],
				],
				[
					'widgetType' => 'ar_posts',
					'settings'   => [
						'count' => 9,
					],
				],
				[
					'widgetType' => 'ar_ai_assist',
					'settings'   => [],
				],
				[
					'widgetType' => 'ar_cta',
					'settings'   => [],
				],
			],
		],

		// 16. PRIVACY POLICY (/privacy-policy/)
		'privacy-policy' => [
			'title'   => 'Privacy Policy',
			'excerpt' => 'Privacy Policy for ArcticRestoDRY ICE explaining how quote, bulk order, and contact form information is collected, used, and protected.',
			'widgets' => [
				[
					'widgetType' => 'ar_breadcrumbs',
					'settings'   => [],
				],
				[
					'widgetType' => 'text-editor',
					'settings'   => [
						'editor' => '<div class="ar-container ar-prose" style="padding:48px 0 72px;">'
							. '<h1>Privacy Policy &amp; Data Handling Notice</h1>'
							. '<p><strong>Admin Configuration Note:</strong> <em>This Privacy Policy template explains how the ArcticRestoDRY ICE website collects and processes quote, bulk order, and contact inquiry data. Please review and update with your verified legal entity name, business address, and jurisdiction-specific disclosures in Elementor or WordPress Editor before commercial launch.</em></p>'
							. '<h2>1. Information We Collect When You Request a Quote or Contact Us</h2>'
							. '<p>When you submit a Request a Quote form, Bulk Dry Ice Order form, Delivery &amp; Supply Area Inquiry, or General Contact form on this website, we collect the business and contact details you voluntarily provide, including:</p>'
							. '<ul>'
							. '<li>Full name, company or organization name, email address, and phone number;</li>'
							. '<li>Requested dry ice product format (pellets, nuggets, blocks, or custom formats), estimated quantity, order frequency, and preferred packaging;</li>'
							. '<li>Delivery location (city, state/region, postal/ZIP code), preferred fulfillment method (delivery vs. collection), target dates, and application notes;</li>'
							. '<li>Technical metadata necessary for security and spam prevention (submission timestamp, source page URL, and honeypot verification).</li>'
							. '</ul>'
							. '<h2>2. How We Use Your Inquiry Information</h2>'
							. '<p>We use the information submitted through our forms strictly to:</p>'
							. '<ul>'
							. '<li>Review and respond to your dry ice product quote, bulk supply, or service-area inquiry;</li>'
							. '<li>Confirm format availability, container options, minimum order requirements, and dispatch scheduling;</li>'
							. '<li>Provide relevant dry ice safety, handling, and storage documentation (such as SDS guidance);</li>'
							. '<li>Maintain internal B2B inquiry records within WordPress and route notifications to our designated supply coordination email.</li>'
							. '</ul>'
							. '<h2>3. Data Sharing &amp; Related Services</h2>'
							. '<p>We do not sell your personal or commercial inquiry information to third-party data brokers. If you follow an external link on our website to our sister service division, <a href="https://arcticresto.com/" target="_blank" rel="noopener noreferrer">Arctic Resto Dry Ice Cleaning Services (arcticresto.com)</a>, your visit to that external website is governed by its respective privacy policy.</p>'
							. '<h2>4. Cookies, Analytics &amp; Security</h2>'
							. '<p>This website uses standard WordPress session and security mechanisms to protect form submissions against automated spam. If analytics tracking is enabled by the site administrator in WordPress Customizer, usage data is processed in accordance with configured consent settings.</p>'
							. '<h2>5. Retaining or Updating Your Information</h2>'
							. '<p>To request access to, correction of, or deletion of a quote or contact inquiry you previously submitted, please contact our team using the contact details published on our <a href="' . esc_url( ar_url( '/contact/' ) ) . '">Request a Quote / Contact</a> page.</p>'
							. '</div>',
					],
				],
			],
		],
	];
}
