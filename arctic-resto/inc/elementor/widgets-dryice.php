<?php
/**
 * ArcticRestoDRY ICE — Dedicated Dry Ice Manufacturing, Product, Specification,
 * Industry, Safety & Cross-Promotion Elementor Widgets.
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
 * 1. Dry Ice Product Format Cards (`ar_products`)
 */
class W_Products extends Base_Widget {
	public function get_name() {
		return 'ar_products';
	}

	public function get_title() {
		return __( 'AR · Dry Ice Product Formats', 'arctic-resto' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	protected function register_controls() {
		$this->start_controls_section( 'sec_header', [
			'label' => __( 'Section Header & Disclaimer', 'arctic-resto' ),
		] );
		$this->register_header_controls(
			'DRY ICE PRODUCT FORMATS',
			'Engineered Dry Ice Formats for Commercial & Industrial Supply',
			'Select the solid carbon dioxide format matched to your cooling rate, transit duration, and equipment requirements.'
		);
		$this->add_control( 'source', [
			'label'   => __( 'Product Data Source', 'arctic-resto' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'repeater',
			'options' => [
				'repeater' => __( 'Custom Repeater Cards (Fully Editable in Elementor)', 'arctic-resto' ),
				'cpt'      => __( 'Dry Ice Products CPT (WP Admin → Dry Ice Products)', 'arctic-resto' ),
			],
		] );
		$this->add_control( 'columns', [
			'label'   => __( 'Desktop Columns', 'arctic-resto' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '2',
			'options' => [
				'2' => '2 Columns',
				'3' => '3 Columns',
				'4' => '4 Columns',
			],
		] );
		$this->add_control( 'spec_disclaimer', [
			'label'   => __( 'Specification Verification Banner', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 2,
			'default' => 'Note: Dimensions, pellet diameters, block weights, and packaging configurations shown below include editable industry placeholders. Contact our supply desk to confirm exact specifications and availability for your order.',
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'sec_cards', [
			'label' => __( 'Product Format Cards', 'arctic-resto' ),
		] );
		$rep = new Repeater();
		$rep->add_control( 'badge', [
			'label'   => __( 'Format Badge', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'EXTRUDED PELLETS',
		] );
		$rep->add_control( 'title', [
			'label'   => __( 'Product Format Name', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'Dry Ice Pellets',
		] );
		$rep->add_control( 'image_url', [
			'label'   => __( 'Product Image URL', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => AR_URI . '/assets/images/dry-ice-pellets.jpg',
		] );
		$rep->add_control( 'desc', [
			'label'   => __( 'Format Description', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => 'High-density cylindrical extruded solid CO₂ engineered for rapid heat transfer, uniform pack-around coverage in insulated shippers, and industrial blast supply.',
		] );
		$rep->add_control( 'sizes', [
			'label'   => __( 'Typical Sizes / Dimensions (Editable Placeholder)', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'Common diameters: 3 mm (1/8") to 16 mm (5/8") [Confirm facility dies]',
		] );
		$rep->add_control( 'packaging', [
			'label'   => __( 'Packaging Options', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'Vented insulated totes, poly-lined cartons, or scheduled bulk containers',
		] );
		$rep->add_control( 'use_cases', [
			'label'   => __( 'Primary Use Cases (pipe-separated | )', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 2,
			'default' => 'Food processing & cold-chain shipping | Pharmaceutical & specimen transport | Industrial blast media supply',
		] );
		$rep->add_control( 'detail_label', [
			'label'   => __( 'Detail Link Label', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'Explore Specifications',
		] );
		$rep->add_control( 'detail_url', [
			'label'   => __( 'Detail Page URL', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => '/dry-ice-pellets/',
		] );
		$rep->add_control( 'quote_label', [
			'label'   => __( 'Quote Button Label', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'Request Quote',
		] );
		$rep->add_control( 'quote_url', [
			'label'   => __( 'Quote Button URL', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => '/contact/#quote',
		] );

		$this->add_control( 'items', [
			'label'       => __( 'Product Formats', 'arctic-resto' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => [
				[
					'badge'        => 'HIGH-SURFACE-AREA FORMAT',
					'title'        => 'Dry Ice Pellets',
					'image_url'    => AR_URI . '/assets/images/dry-ice-pellets.jpg',
					'desc'         => 'Extruded cylindrical solid CO₂ pellets designed for fast cooling, easy pouring around irregular packages, food temperature control, and industrial blast supply.',
					'sizes'        => 'Typical diameters: 3 mm (1/8") to 9 mm (3/8") [Placeholder — confirm available dies]',
					'packaging'    => 'Vented insulated totes & poly-lined cartons',
					'use_cases'    => 'Cold-chain parcel & pallet shipping | Food mixing & chilling | Laboratory sample packing | Dry ice blasting media',
					'detail_label' => 'View Pellet Specifications',
					'detail_url'   => '/dry-ice-pellets/',
					'quote_label'  => 'Request Pellet Quote',
					'quote_url'    => '/contact/#quote',
				],
				[
					'badge'        => 'DENSE CYLINDRICAL FORMAT',
					'title'        => 'Dry Ice Nuggets',
					'image_url'    => AR_URI . '/assets/images/dry-ice-nuggets.jpg',
					'desc'         => 'Larger-diameter extruded dry ice cylinders offering a balanced compromise between pourable handling and slower sublimation for multi-day cold-chain transit.',
					'sizes'        => 'Typical diameters: 16 mm (5/8") to 19 mm (3/4") [Placeholder — confirm availability]',
					'packaging'    => 'Insulated commercial totes & bulk shipping containers',
					'use_cases'    => 'Extended cold-chain distribution | Airline & commercial catering | Industrial process cooling | Bulk tote replenishment',
					'detail_label' => 'View Nugget Specifications',
					'detail_url'   => '/dry-ice-blocks-nuggets/',
					'quote_label'  => 'Request Nugget Quote',
					'quote_url'    => '/contact/#quote',
				],
				[
					'badge'        => 'LOW-SUBLIMATION SOLID FORMAT',
					'title'        => 'Dry Ice Blocks & Slabs',
					'image_url'    => AR_URI . '/assets/images/dry-ice-blocks.jpg',
					'desc'         => 'High-density compressed solid CO₂ blocks and cut slabs with minimal surface-to-volume ratio for prolonged hold times and durable transport cooling.',
					'sizes'        => 'Standard & custom cut blocks/slabs [Placeholder — confirm block weights with dispatch]',
					'packaging'    => 'Protective Kraft/poly wrap inside vented insulated totes',
					'use_cases'    => 'Long-haul refrigerated freight backup | Food distribution | Shrink-fitting metal components | Extended cold storage',
					'detail_label' => 'View Block Specifications',
					'detail_url'   => '/dry-ice-blocks-nuggets/',
					'quote_label'  => 'Request Block Quote',
					'quote_url'    => '/contact/#quote',
				],
				[
					'badge'        => 'SUBJECT TO AVAILABILITY',
					'title'        => 'Custom & Application-Specific Supply',
					'image_url'    => AR_URI . '/assets/images/insulated-containers.jpg',
					'desc'         => 'Tailored packaging configurations, mixed-format pallet orders, and scheduled recurring tote rotations coordinated around your facility production calendar.',
					'sizes'        => 'Configured per order requirement (Subject to production scheduling)',
					'packaging'    => 'Dedicated insulated totes, palletized shippers, or customer-supplied vented containers',
					'use_cases'    => 'Standing weekly/monthly supply contracts | Multi-format industrial orders | Scheduled cold-chain dispatch',
					'detail_label' => 'Explore Bulk Orders',
					'detail_url'   => '/bulk-orders/',
					'quote_label'  => 'Inquire About Custom Supply',
					'quote_url'    => '/bulk-orders/#bulk-quote',
				],
			],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$cols  = in_array( $s['columns'] ?? '2', [ '2', '3', '4' ], true ) ? $s['columns'] : '2';
		$items = $s['items'] ?? [];

		if ( ( $s['source'] ?? 'repeater' ) === 'cpt' ) {
			$posts = get_posts( [
				'post_type'      => 'ar_product',
				'posts_per_page' => 8,
				'post_status'    => 'publish',
				'orderby'        => 'menu_order title',
				'order'          => 'ASC',
			] );
			if ( ! empty( $posts ) ) {
				$items = [];
				foreach ( $posts as $p ) {
					$apps = str_replace( "\n", ' | ', (string) get_post_meta( $p->ID, '_ar_prod_applications', true ) );
					$items[] = [
						'badge'        => get_post_meta( $p->ID, '_ar_prod_badge', true ) ?: 'DRY ICE FORMAT',
						'title'        => get_the_title( $p ),
						'image_url'    => get_the_post_thumbnail_url( $p->ID, 'ar-card' ) ?: ( AR_URI . '/assets/images/dry-ice-pellets.jpg' ),
						'desc'         => get_post_meta( $p->ID, '_ar_prod_subtitle', true ) ?: get_the_excerpt( $p ),
						'sizes'        => get_post_meta( $p->ID, '_ar_prod_sizes', true ),
						'packaging'    => get_post_meta( $p->ID, '_ar_prod_packaging', true ),
						'use_cases'    => $apps,
						'detail_label' => 'Format Details',
						'detail_url'   => get_post_meta( $p->ID, '_ar_prod_cta_url', true ) ?: get_permalink( $p ),
						'quote_label'  => get_post_meta( $p->ID, '_ar_prod_cta_label', true ) ?: 'Request Quote',
						'quote_url'    => '/contact/#quote',
					];
				}
			}
		}
		?>
		<section class="ar-w-sec ar-products-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>

				<div class="ar-grid ar-grid--<?php echo esc_attr( $cols ); ?>">
					<?php foreach ( $items as $item ) :
						$img   = ! empty( $item['image_url'] ) ? $item['image_url'] : ( AR_URI . '/assets/images/dry-ice-pellets.jpg' );
						$cases = array_filter( array_map( 'trim', explode( '|', (string) ( $item['use_cases'] ?? '' ) ) ) );
						?>
						<article class="ar-card ar-product-card">
							<div class="ar-product-card__media">
								<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $item['title'] ?? 'Dry Ice Format' ); ?>" loading="lazy" />
								<?php if ( ! empty( $item['badge'] ) ) : ?>
									<span class="ar-product-card__badge"><?php echo esc_html( $item['badge'] ); ?></span>
								<?php endif; ?>
							</div>
							<div class="ar-product-card__body">
								<h3 class="ar-product-card__title"><?php echo esc_html( $item['title'] ?? '' ); ?></h3>
								<p class="ar-product-card__desc"><?php echo esc_html( $item['desc'] ?? '' ); ?></p>

								<dl class="ar-product-card__specs">
									<?php if ( ! empty( $item['sizes'] ) ) : ?>
										<div>
											<dt><?php esc_html_e( 'Sizes / Format:', 'arctic-resto' ); ?></dt>
											<dd><?php echo esc_html( $item['sizes'] ); ?></dd>
										</div>
									<?php endif; ?>
									<?php if ( ! empty( $item['packaging'] ) ) : ?>
										<div>
											<dt><?php esc_html_e( 'Packaging:', 'arctic-resto' ); ?></dt>
											<dd><?php echo esc_html( $item['packaging'] ); ?></dd>
										</div>
									<?php endif; ?>
								</dl>

								<?php if ( ! empty( $cases ) ) : ?>
									<div class="ar-product-card__uses">
										<span class="ar-product-card__uses-label"><?php esc_html_e( 'Typical Applications:', 'arctic-resto' ); ?></span>
										<ul class="ar-check-list ar-check-list--compact">
											<?php foreach ( $cases as $c ) : ?>
												<li><?php echo ar_svg( 'check', 14 ); ?> <span><?php echo esc_html( $c ); ?></span></li>
											<?php endforeach; ?>
										</ul>
									</div>
								<?php endif; ?>

								<div class="ar-product-card__actions">
									<a href="<?php echo esc_url( ar_url( $item['quote_url'] ?? '/contact/#quote' ) ); ?>" class="ar-btn ar-btn--primary ar-btn--sm">
										<span><?php echo esc_html( $item['quote_label'] ?? 'Request Quote' ); ?></span>
										<?php echo ar_svg( 'arrow-right', 15 ); ?>
									</a>
									<?php if ( ! empty( $item['detail_url'] ) ) : ?>
										<a href="<?php echo esc_url( ar_url( $item['detail_url'] ) ); ?>" class="ar-btn ar-btn--ghost ar-btn--sm">
											<span><?php echo esc_html( $item['detail_label'] ?? 'Specifications' ); ?></span>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</article>
					<?php endforeach; ?>
				</div>

				<?php if ( ! empty( $s['spec_disclaimer'] ) ) : ?>
					<div class="ar-spec-disclaimer">
						<?php echo ar_svg( 'clipboard', 16 ); ?>
						<span><?php echo esc_html( $s['spec_disclaimer'] ); ?></span>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}

/**
 * 2. Dry Ice Technical Specification Table (`ar_spec_table`)
 */
class W_SpecTable extends Base_Widget {
	public function get_name() {
		return 'ar_spec_table';
	}

	public function get_title() {
		return __( 'AR · Dry Ice Specification Table', 'arctic-resto' );
	}

	public function get_icon() {
		return 'eicon-table';
	}

	protected function register_controls() {
		$this->start_controls_section( 'sec_head', [
			'label' => __( 'Header & Columns', 'arctic-resto' ),
		] );
		$this->register_header_controls(
			'TECHNICAL SPECIFICATIONS',
			'Dry Ice Physical Properties & Format Reference Table',
			'Physical properties of solid carbon dioxide (CO₂) alongside editable format and packaging parameters.'
		);
		$this->add_control( 'col1_label', [ 'label' => 'Column 1 Heading', 'type' => Controls_Manager::TEXT, 'default' => 'Parameter / Property' ] );
		$this->add_control( 'col2_label', [ 'label' => 'Column 2 Heading', 'type' => Controls_Manager::TEXT, 'default' => 'Dry Ice Pellets' ] );
		$this->add_control( 'col3_label', [ 'label' => 'Column 3 Heading', 'type' => Controls_Manager::TEXT, 'default' => 'Dry Ice Blocks & Nuggets' ] );
		$this->add_control( 'col4_label', [ 'label' => 'Column 4 Heading', 'type' => Controls_Manager::TEXT, 'default' => 'Handling / Verification Note' ] );
		$this->add_control( 'footnote', [
			'label'   => __( 'Verification Footnote', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 2,
			'default' => 'Physical constants (-78.5°C / -109.3°F sublimation point, molecular weight 44.01 g/mol) are standard properties of solid CO₂. Format dimensions, container weights, and minimum order quantities are editable placeholders that must be verified for your specific supply order.',
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'sec_rows', [
			'label' => __( 'Specification Rows', 'arctic-resto' ),
		] );
		$rep = new Repeater();
		$rep->add_control( 'param', [ 'label' => 'Parameter', 'type' => Controls_Manager::TEXT, 'default' => 'Surface Temperature' ] );
		$rep->add_control( 'val_a', [ 'label' => 'Column 2 Value', 'type' => Controls_Manager::TEXT, 'default' => '-78.5°C (-109.3°F) at 1 atm' ] );
		$rep->add_control( 'val_b', [ 'label' => 'Column 3 Value', 'type' => Controls_Manager::TEXT, 'default' => '-78.5°C (-109.3°F) at 1 atm' ] );
		$rep->add_control( 'note',  [ 'label' => 'Column 4 Note',  'type' => Controls_Manager::TEXT, 'default' => 'Standard physical property of solid CO₂' ] );

		$this->add_control( 'rows', [
			'label'       => __( 'Table Rows', 'arctic-resto' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ param }}}',
			'default'     => [
				[
					'param' => 'Chemical Composition',
					'val_a' => 'Solid Carbon Dioxide (CO₂)',
					'val_b' => 'Solid Carbon Dioxide (CO₂)',
					'note'  => 'Sublimates directly from solid to gas with zero water residue',
				],
				[
					'param' => 'Sublimation Temperature (1 atm)',
					'val_a' => '-78.5°C (-109.3°F)',
					'val_b' => '-78.5°C (-109.3°F)',
					'note'  => 'Requires insulated cryogenic gloves & eye protection',
				],
				[
					'param' => 'Latent Heat of Sublimation',
					'val_a' => '~571 kJ/kg (245 BTU/lb)',
					'val_b' => '~571 kJ/kg (245 BTU/lb)',
					'note'  => 'High cooling capacity per unit weight vs. water ice',
				],
				[
					'param' => 'Typical Format Geometry',
					'val_a' => 'Extruded cylindrical pellets (3 mm – 16 mm placeholder)',
					'val_b' => 'Compressed solid blocks, cut slabs, or 16–19 mm nuggets',
					'note'  => 'Editable placeholder — confirm available die/block sizes with dispatch',
				],
				[
					'param' => 'Relative Sublimation Profile',
					'val_a' => 'Faster cooling transfer (higher surface area)',
					'val_b' => 'Slower sublimation rate (lower surface-to-mass ratio)',
					'note'  => 'Depends on container insulation rating & ambient temperature',
				],
				[
					'param' => 'Standard Packaging Options',
					'val_a' => 'Poly-lined cartons & vented insulated totes',
					'val_b' => 'Kraft/poly wrapped blocks in vented insulated totes',
					'note'  => 'Never store in airtight or unvented sealed vessels',
				],
			],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s    = $this->get_settings_for_display();
		$rows = $s['rows'] ?? [];
		?>
		<section class="ar-w-sec ar-spec-table-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>
				<div class="ar-card ar-table-card">
					<div class="ar-table-scroll">
						<table class="ar-spec-table">
							<thead>
								<tr>
									<th><?php echo esc_html( $s['col1_label'] ?? 'Parameter' ); ?></th>
									<th><?php echo esc_html( $s['col2_label'] ?? 'Dry Ice Pellets' ); ?></th>
									<th><?php echo esc_html( $s['col3_label'] ?? 'Dry Ice Blocks & Nuggets' ); ?></th>
									<th><?php echo esc_html( $s['col4_label'] ?? 'Verification / Handling Note' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $rows as $r ) : ?>
									<tr>
										<td class="ar-spec-table__param"><?php echo esc_html( $r['param'] ?? '' ); ?></td>
										<td><?php echo esc_html( $r['val_a'] ?? '' ); ?></td>
										<td><?php echo esc_html( $r['val_b'] ?? '' ); ?></td>
										<td class="ar-spec-table__note"><?php echo esc_html( $r['note'] ?? '' ); ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<?php if ( ! empty( $s['footnote'] ) ) : ?>
						<div class="ar-table-card__foot">
							<?php echo ar_svg( 'shield', 15 ); ?>
							<span><?php echo esc_html( $s['footnote'] ); ?></span>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<?php
	}
}

/**
 * 3. Industries Served Matrix (`ar_industries`)
 */
class W_Industries extends Base_Widget {
	public function get_name() {
		return 'ar_industries';
	}

	public function get_title() {
		return __( 'AR · Industries We Serve Matrix', 'arctic-resto' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	protected function register_controls() {
		$this->start_controls_section( 'sec_head', [
			'label' => __( 'Section Header & Source', 'arctic-resto' ),
		] );
		$this->register_header_controls(
			'INDUSTRIES WE SERVE',
			'Dependable Dry Ice Supply Across Critical Commercial & Industrial Sectors',
			'From temperature-sensitive food processing and life-science cold chains to industrial shrink-fitting and manufacturing workflows.'
		);
		$this->add_control( 'source', [
			'label'   => __( 'Data Source', 'arctic-resto' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'repeater',
			'options' => [
				'repeater' => __( 'Custom Repeater Items (Editable in Elementor)', 'arctic-resto' ),
				'cpt'      => __( 'Industries CPT (WP Admin → Industries Served)', 'arctic-resto' ),
			],
		] );
		$this->add_control( 'columns', [
			'label'   => __( 'Desktop Columns', 'arctic-resto' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '4',
			'options' => [
				'2' => '2 Columns',
				'3' => '3 Columns',
				'4' => '4 Columns',
			],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'sec_items', [
			'label' => __( 'Industry Cards', 'arctic-resto' ),
		] );
		$rep = new Repeater();
		$rep->add_control( 'icon', [
			'label'   => __( 'Icon', 'arctic-resto' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'snowflake',
			'options' => $this->icon_choices(),
		] );
		$rep->add_control( 'code', [ 'label' => 'Sector Tag', 'type' => Controls_Manager::TEXT, 'default' => 'COLD-CHAIN & FOOD' ] );
		$rep->add_control( 'title', [ 'label' => 'Industry Name', 'type' => Controls_Manager::TEXT, 'default' => 'Food Processing & Food Logistics' ] );
		$rep->add_control( 'desc', [ 'label' => 'Use Case & Supply Summary', 'type' => Controls_Manager::TEXTAREA, 'rows' => 3 ] );
		$rep->add_control( 'formats', [ 'label' => 'Typical Formats Used', 'type' => Controls_Manager::TEXT, 'default' => 'Pellets, Nuggets & Cooling Blocks' ] );
		$rep->add_control( 'planning', [ 'label' => 'Supply & Safety Considerations', 'type' => Controls_Manager::TEXT, 'default' => 'Scheduled tote rotation & food-safe handling hygiene' ] );
		$rep->add_control( 'url', [ 'label' => 'Link URL', 'type' => Controls_Manager::TEXT, 'default' => '/industries/' ] );

		$this->add_control( 'items', [
			'label'       => __( 'Industries', 'arctic-resto' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => [
				[
					'icon'     => 'leaf',
					'code'     => 'SECTOR 01',
					'title'    => 'Food Processing & Food Logistics',
					'desc'     => 'Temperature regulation during meat, bakery, and prepared food mixing, plus pack-around cooling for perishable distribution without water melt mess.',
					'formats'  => 'Extruded Pellets & Solid Blocks',
					'planning' => 'Recurring production-aligned deliveries in clean poly-lined totes',
					'url'      => '/industries/#food-processing',
				],
				[
					'icon'     => 'flask',
					'code'     => 'SECTOR 02',
					'title'    => 'Pharmaceuticals & Life Sciences',
					'desc'     => 'Ultra-cold thermal protection (-78.5°C) for biologics, temperature-sensitive reagents, clinical trial materials, and validated cold-chain shippers.',
					'formats'  => 'High-Density Pellets & Nuggets',
					'planning' => 'Predictable dispatch timing & UN 1845 package labeling compliance',
					'url'      => '/industries/#pharmaceuticals',
				],
				[
					'icon'     => 'shield',
					'code'     => 'SECTOR 03',
					'title'    => 'Healthcare & Laboratory Environments',
					'desc'     => 'Reliable dry ice supply for hospital pathology labs, diagnostic specimen transport, biobanking backup, and benchtop cryo-procedures.',
					'formats'  => 'Small-Diameter Pellets & Cut Slabs',
					'planning' => 'Scheduled weekly/bi-weekly replenishment in vented lab totes',
					'url'      => '/industries/#healthcare-labs',
				],
				[
					'icon'     => 'factory',
					'code'     => 'SECTOR 04',
					'title'    => 'Manufacturing & Industrial Production',
					'desc'     => 'Process cooling, rubber/plastic deflashing, cold-trap condensation, and dry ice pellet supply for in-house maintenance blasting systems.',
					'formats'  => '3 mm Blast Pellets & Dense Blocks',
					'planning' => 'High-volume insulated totes matched to shift schedules',
					'url'      => '/industries/#manufacturing',
				],
				[
					'icon'     => 'wrench',
					'code'     => 'SECTOR 05',
					'title'    => 'Automotive & Engineering Applications',
					'desc'     => 'Thermal contraction (shrink-fitting) of bearings, bushings, and shafts, environmental chamber testing, and composite tooling support.',
					'formats'  => 'Pellets, Nuggets & Solid Blocks',
					'planning' => 'On-demand project batches or standing plant deliveries',
					'url'      => '/industries/#automotive',
				],
				[
					'icon'     => 'thermometer',
					'code'     => 'SECTOR 06',
					'title'    => 'Research & Testing Facilities',
					'desc'     => 'University laboratories, materials science testing, aerospace thermal cycling, and chemical synthesis cooling baths.',
					'formats'  => 'Extruded Pellets & Custom Blocks',
					'planning' => 'Flexible carton or tote quantities with safety SDS guidance',
					'url'      => '/industries/#research',
				],
				[
					'icon'     => 'truck',
					'code'     => 'SECTOR 07',
					'title'    => 'Cold-Chain Transportation & Shipping',
					'desc'     => 'Supplemental and primary dry ice cooling for regional freight carriers, e-commerce frozen fulfillment, and airline catering galleys.',
					'formats'  => 'Slow-Sublimating Blocks, Slabs & Nuggets',
					'planning' => 'Multi-tote dock deliveries timed to outbound departure waves',
					'url'      => '/industries/#cold-chain',
				],
				[
					'icon'     => 'cube',
					'code'     => 'SECTOR 08',
					'title'    => 'Commercial & Specialty Applications',
					'desc'     => 'Emergency refrigeration backup during power outages, commercial foodservice events, agricultural preservation, and specialty industrial uses.',
					'formats'  => 'Blocks, Nuggets & Pellets',
					'planning' => 'Coordinated pickup or delivery with insulated container options',
					'url'      => '/industries/#commercial',
				],
			],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$cols  = in_array( $s['columns'] ?? '4', [ '2', '3', '4' ], true ) ? $s['columns'] : '4';
		$items = $s['items'] ?? [];

		if ( ( $s['source'] ?? 'repeater' ) === 'cpt' ) {
			$posts = get_posts( [
				'post_type'      => 'ar_industry',
				'posts_per_page' => 12,
				'post_status'    => 'publish',
				'orderby'        => 'menu_order title',
				'order'          => 'ASC',
			] );
			if ( ! empty( $posts ) ) {
				$items = [];
				foreach ( $posts as $p ) {
					$items[] = [
						'icon'     => get_post_meta( $p->ID, '_ar_ind_icon', true ) ?: 'snowflake',
						'code'     => get_post_meta( $p->ID, '_ar_ind_code', true ) ?: 'INDUSTRY',
						'title'    => get_the_title( $p ),
						'desc'     => get_the_excerpt( $p ) ?: wp_trim_words( wp_strip_all_tags( $p->post_content ), 24 ),
						'formats'  => get_post_meta( $p->ID, '_ar_ind_formats', true ) ?: 'Pellets, Nuggets & Blocks',
						'planning' => get_post_meta( $p->ID, '_ar_ind_planning', true ) ?: 'Scheduled & on-demand supply',
						'url'      => '/industries/',
					];
				}
			}
		}
		?>
		<section class="ar-w-sec ar-industries-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>
				<div class="ar-grid ar-grid--<?php echo esc_attr( $cols ); ?>">
					<?php foreach ( $items as $it ) : ?>
						<article class="ar-card ar-industry-card">
							<div class="ar-industry-card__top">
								<span class="ar-icon-box"><?php echo ar_svg( $it['icon'] ?? 'snowflake', 20 ); ?></span>
								<span class="ar-industry-card__code"><?php echo esc_html( $it['code'] ?? '' ); ?></span>
							</div>
							<h3 class="ar-industry-card__title"><?php echo esc_html( $it['title'] ?? '' ); ?></h3>
							<p class="ar-industry-card__desc"><?php echo esc_html( $it['desc'] ?? '' ); ?></p>
							<div class="ar-industry-card__meta">
								<?php if ( ! empty( $it['formats'] ) ) : ?>
									<div class="ar-industry-card__row">
										<strong><?php esc_html_e( 'Formats:', 'arctic-resto' ); ?></strong>
										<span><?php echo esc_html( $it['formats'] ); ?></span>
									</div>
								<?php endif; ?>
								<?php if ( ! empty( $it['planning'] ) ) : ?>
									<div class="ar-industry-card__row">
										<strong><?php esc_html_e( 'Planning:', 'arctic-resto' ); ?></strong>
										<span><?php echo esc_html( $it['planning'] ); ?></span>
									</div>
								<?php endif; ?>
							</div>
							<a href="<?php echo esc_url( ar_url( $it['url'] ?? '/contact/#quote' ) ); ?>" class="ar-link">
								<span><?php esc_html_e( 'Discuss Sector Supply', 'arctic-resto' ); ?></span>
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
 * 4. Dry Ice Safety, PPE & Ventilation Notice (`ar_safety_notice`)
 */
class W_SafetyNotice extends Base_Widget {
	public function get_name() {
		return 'ar_safety_notice';
	}

	public function get_title() {
		return __( 'AR · Dry Ice Safety & Storage Callout', 'arctic-resto' );
	}

	public function get_icon() {
		return 'eicon-alert';
	}

	protected function register_controls() {
		$this->start_controls_section( 'sec_safety', [
			'label' => __( 'Safety & Storage Content', 'arctic-resto' ),
		] );
		$this->add_control( 'badge', [
			'label'   => __( 'Hazard Badge', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'CRITICAL DRY ICE SAFETY · -78.5°C (-109.3°F) · UN 1845',
		] );
		$this->add_control( 'title', [
			'label'   => __( 'Heading', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'Essential Dry Ice Handling, PPE, Ventilation & Vented Container Rules',
		] );
		$this->add_control( 'lead', [
			'label'   => __( 'Summary Paragraph', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => 'Dry ice is solid carbon dioxide (CO₂) at -78.5°C (-109.3°F). Instead of melting into liquid, it sublimates directly into carbon dioxide gas — expanding roughly 800 times its solid volume. Every facility, driver, and handler must follow strict thermal and ventilation precautions.',
		] );

		$rep = new Repeater();
		$rep->add_control( 'icon', [
			'label'   => __( 'Icon', 'arctic-resto' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'alert',
			'options' => $this->icon_choices(),
		] );
		$rep->add_control( 'heading', [ 'label' => 'Rule Title', 'type' => Controls_Manager::TEXT, 'default' => 'Never Store in Airtight Containers' ] );
		$rep->add_control( 'body', [ 'label' => 'Rule Explanation', 'type' => Controls_Manager::TEXTAREA, 'rows' => 2 ] );

		$this->add_control( 'rules', [
			'label'       => __( 'Safety Pillars', 'arctic-resto' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ heading }}}',
			'default'     => [
				[
					'icon'    => 'thermometer',
					'heading' => 'Prevent Severe Cold Burns (-78.5°C / -109.3°F)',
					'body'    => 'Never touch dry ice with bare skin. Always wear insulated cryogenic or leather handling gloves, eye protection, and closed-toe footwear, and use tongs or scoops when transferring pellets or blocks.',
				],
				[
					'icon'    => 'wind',
					'heading' => 'Ensure Continuous Ventilation (CO₂ Gas Displacement)',
					'body'    => 'Sublimating CO₂ gas is heavier than air and accumulates in low or confined spaces (walk-in coolers, basements, closed vans), displacing oxygen. Store and handle only in well-ventilated areas.',
				],
				[
					'icon'    => 'alert',
					'heading' => 'Use Vented Insulated Containers Only — Never Airtight',
					'body'    => 'Continuous sublimation builds rapid gas pressure inside sealed vessels, causing dangerous rupture or explosion. Use purpose-built vented insulated totes or poly-lined coolers that allow gas to escape.',
				],
				[
					'icon'    => 'truck',
					'heading' => 'Safe Vehicle Transport & SDS Readiness',
					'body'    => 'Transport dry ice in a cargo compartment separated from the driver cab or keep vehicle fresh-air ventilation active with windows slightly open. Keep a Carbon Dioxide (Solid) Safety Data Sheet (SDS) accessible.',
				],
			],
		] );

		$this->add_control( 'cta_label', [
			'label'   => __( 'Safety Guide Button Label', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'Read Complete Dry Ice Safety & Storage Guide',
		] );
		$this->add_control( 'cta_url', [
			'label'   => __( 'Safety Guide URL', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => '/dry-ice-safety/',
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$rules = $s['rules'] ?? [];
		?>
		<section class="ar-w-sec ar-safety-sec">
			<div class="ar-container">
				<div class="ar-card ar-safety-panel">
					<div class="ar-safety-panel__head">
						<div>
							<span class="ar-badge ar-badge--amber"><?php echo ar_svg( 'alert', 14 ); ?> <?php echo esc_html( $s['badge'] ?? '' ); ?></span>
							<h2 class="ar-safety-panel__title"><?php echo esc_html( $s['title'] ?? '' ); ?></h2>
							<p class="ar-safety-panel__lead"><?php echo esc_html( $s['lead'] ?? '' ); ?></p>
						</div>
						<?php if ( ! empty( $s['cta_label'] ) ) : ?>
							<div class="ar-safety-panel__cta">
								<a href="<?php echo esc_url( ar_url( $s['cta_url'] ?? '/dry-ice-safety/' ) ); ?>" class="ar-btn ar-btn--ghost">
									<span><?php echo esc_html( $s['cta_label'] ); ?></span>
									<?php echo ar_svg( 'arrow-right', 16 ); ?>
								</a>
							</div>
						<?php endif; ?>
					</div>

					<div class="ar-grid ar-grid--2 ar-safety-panel__grid">
						<?php foreach ( $rules as $r ) : ?>
							<div class="ar-safety-rule">
								<span class="ar-icon-box ar-icon-box--amber"><?php echo ar_svg( $r['icon'] ?? 'alert', 20 ); ?></span>
								<div>
									<h3 class="ar-safety-rule__title"><?php echo esc_html( $r['heading'] ?? '' ); ?></h3>
									<p class="ar-safety-rule__body"><?php echo esc_html( $r['body'] ?? '' ); ?></p>
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

/**
 * 5. Secondary Cross-Promotion Callout for Arctic Resto Cleaning Services (`ar_cross_promo`)
 */
class W_CrossPromo extends Base_Widget {
	public function get_name() {
		return 'ar_cross_promo';
	}

	public function get_title() {
		return __( 'AR · Secondary Cleaning Cross-Promo (ArcticResto.com)', 'arctic-resto' );
	}

	public function get_icon() {
		return 'eicon-external-link-square';
	}

	protected function register_controls() {
		$this->start_controls_section( 'sec_promo', [
			'label' => __( 'Cross-Promotion Content & Link', 'arctic-resto' ),
		] );
		$this->add_control( 'badge', [
			'label'   => __( 'Badge Label', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => (string) ar_opt( 'cross_promo_badge', 'Sister Division · Mobile Dry Ice Blasting Services' ),
		] );
		$this->add_control( 'heading', [
			'label'   => __( 'Heading', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => (string) ar_opt( 'cross_promo_heading', 'Need Professional Dry Ice Cleaning Services?' ),
		] );
		$this->add_control( 'body', [
			'label'   => __( 'Description', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => (string) ar_opt( 'cross_promo_body', 'ArcticRestoDRY ICE manufactures and supplies dry ice pellets, blocks, and nuggets. If you are looking for an on-site mobile crew to perform industrial dry ice blasting, equipment cleaning, or surface restoration, visit Arctic Resto.' ),
		] );
		$this->add_control( 'btn_label', [
			'label'   => __( 'Button Text', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => (string) ar_opt( 'cross_promo_btn_label', 'Visit Arctic Resto Cleaning Services' ),
		] );
		$this->add_control( 'btn_url', [
			'label'   => __( 'Destination URL', 'arctic-resto' ),
			'type'    => Controls_Manager::TEXT,
			'default' => (string) ar_opt( 'cross_promo_url', 'https://arcticresto.com/' ),
		] );
		$this->add_control( 'new_tab', [
			'label'        => __( 'Open Link in New Tab (with rel="noopener noreferrer")', 'arctic-resto' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => __( 'Yes', 'arctic-resto' ),
			'label_off'    => __( 'No', 'arctic-resto' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s       = $this->get_settings_for_display();
		$url     = ! empty( $s['btn_url'] ) ? $s['btn_url'] : 'https://arcticresto.com/';
		$new_tab = ( $s['new_tab'] ?? 'yes' ) === 'yes';
		?>
		<aside class="ar-w-sec ar-cross-promo" aria-label="<?php esc_attr_e( 'Related Mobile Dry Ice Cleaning Services', 'arctic-resto' ); ?>">
			<div class="ar-container">
				<div class="ar-card ar-cross-promo__card">
					<div class="ar-cross-promo__content">
						<span class="ar-badge ar-badge--subtle"><?php echo ar_svg( 'sparkles', 13 ); ?> <?php echo esc_html( $s['badge'] ?? '' ); ?></span>
						<h3 class="ar-cross-promo__title"><?php echo esc_html( $s['heading'] ?? '' ); ?></h3>
						<p class="ar-cross-promo__desc"><?php echo esc_html( $s['body'] ?? '' ); ?></p>
					</div>
					<div class="ar-cross-promo__action">
						<a href="<?php echo esc_url( $url ); ?>" class="ar-btn ar-btn--ghost" <?php echo $new_tab ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
							<span><?php echo esc_html( $s['btn_label'] ?? 'Visit Arctic Resto' ); ?></span>
							<?php echo ar_svg( 'external-link', 15 ); ?>
						</a>
					</div>
				</div>
			</div>
		</aside>
		<?php
	}
}
