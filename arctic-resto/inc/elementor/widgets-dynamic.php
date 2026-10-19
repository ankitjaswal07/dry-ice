<?php
/**
 * ArcticRestoDRY ICE — Dynamic Solutions, Application Profiles, Supply Commitments
 * & Blog Resource Grid Widgets.
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
 * 1. Supply Solutions / Applications Grid (`ar_services`)
 */
class W_Services extends Base_Widget {
	public function get_name() { return 'ar_services'; }
	public function get_title() { return __( 'AR · Dry Ice Solutions & Applications Grid', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-posts-grid'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Solutions Grid', 'arctic-resto' ) ] );
		$this->register_header_controls(
			'DRY ICE SUPPLY SOLUTIONS',
			'Engineered Solid CO₂ Solutions for Cooling, Transport & Process Control',
			'Explore how different dry ice formats, packaging configurations, and replenishment schedules support commercial operations.'
		);
		$this->add_control( 'count', [
			'label'   => __( 'Number of Cards', 'arctic-resto' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 4,
		] );
		$rep = new Repeater();
		$rep->add_control( 'icon',  [ 'label' => 'Icon', 'type' => Controls_Manager::SELECT, 'default' => 'snowflake', 'options' => $this->icon_choices() ] );
		$rep->add_control( 'badge', [ 'label' => 'Badge', 'type' => Controls_Manager::TEXT, 'default' => 'APPLICATION' ] );
		$rep->add_control( 'title', [ 'label' => 'Title', 'type' => Controls_Manager::TEXT, 'default' => 'Cold-Chain & Perishable Shipping' ] );
		$rep->add_control( 'desc',  [ 'label' => 'Summary', 'type' => Controls_Manager::TEXTAREA, 'rows' => 3 ] );
		$rep->add_control( 'url',   [ 'label' => 'Link URL', 'type' => Controls_Manager::TEXT, 'default' => '/dry-ice-applications/' ] );

		$this->add_control( 'items', [
			'label'       => __( 'Solution Cards', 'arctic-resto' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => [
				[
					'icon'  => 'truck',
					'badge' => 'COLD-CHAIN LOGISTICS',
					'title' => 'Temperature-Controlled Freight & Parcel Shipping',
					'desc'  => 'Protect frozen foods, biologics, and temperature-critical shipments in transit using high-density pellets, nuggets, or slow-sublimating blocks.',
					'url'   => '/dry-ice-applications/#cold-chain',
				],
				[
					'icon'  => 'leaf',
					'badge' => 'FOOD PROCESSING',
					'title' => 'Food Mixing, Chilling & Line Temperature Control',
					'desc'  => 'Maintain strict product temperatures during meat blending, dough mixing, and batch packing without introducing liquid water.',
					'url'   => '/dry-ice-applications/#food-cooling',
				],
				[
					'icon'  => 'flask',
					'badge' => 'LIFE SCIENCES & LABS',
					'title' => 'Biological Sample Shipment & Cryo-Preservation',
					'desc'  => 'Reliable -78.5°C thermal protection for clinical specimens, reagents, research samples, and backup laboratory storage.',
					'url'   => '/dry-ice-applications/#lab-transport',
				],
				[
					'icon'  => 'wrench',
					'badge' => 'INDUSTRIAL & MANUFACTURING',
					'title' => 'Process Cooling, Shrink-Fitting & Blast Media Supply',
					'desc'  => 'Support metal shrink-fitting, cold traps, rubber deflashing, and in-house dry ice blasting equipment with consistent solid CO₂.',
					'url'   => '/dry-ice-applications/#process-cooling',
				],
			],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = $s['items'] ?? [];
		?>
		<section class="ar-w-sec ar-services-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>
				<div class="ar-grid ar-grid--2">
					<?php foreach ( $items as $it ) : ?>
						<article class="ar-card ar-solution-card">
							<div class="ar-solution-card__top">
								<span class="ar-icon-box"><?php echo ar_svg( $it['icon'] ?? 'snowflake', 20 ); ?></span>
								<?php if ( ! empty( $it['badge'] ) ) : ?>
									<span class="ar-badge ar-badge--subtle"><?php echo esc_html( $it['badge'] ); ?></span>
								<?php endif; ?>
							</div>
							<h3 class="ar-solution-card__title"><?php echo esc_html( $it['title'] ?? '' ); ?></h3>
							<p class="ar-solution-card__desc"><?php echo esc_html( $it['desc'] ?? '' ); ?></p>
							<a href="<?php echo esc_url( ar_url( $it['url'] ?? '/dry-ice-applications/' ) ); ?>" class="ar-link">
								<span><?php esc_html_e( 'Explore Application Details', 'arctic-resto' ); ?></span>
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
 * 2. Technical Application Profiles (`ar_cases`)
 * Note: Presents factual application comparisons rather than fabricated customer case studies.
 */
class W_Cases extends Base_Widget {
	public function get_name() { return 'ar_cases'; }
	public function get_title() { return __( 'AR · Dry Ice Application Profiles', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-info-box'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Application Profiles', 'arctic-resto' ) ] );
		$this->register_header_controls(
			'APPLICATION & PACKAGING PROFILES',
			'Matching Dry Ice Format, Container Type & Replenishment to the Task',
			'Different applications require distinct trade-offs between rapid heat absorption and multi-day hold duration.'
		);
		$rep = new Repeater();
		$rep->add_control( 'sector',  [ 'label' => 'Application Category', 'type' => Controls_Manager::TEXT, 'default' => 'COLD-CHAIN SHIPPING' ] );
		$rep->add_control( 'title',   [ 'label' => 'Scenario Title',       'type' => Controls_Manager::TEXT, 'default' => 'Multi-Day Insulated Parcel & Pallet Transit' ] );
		$rep->add_control( 'format',  [ 'label' => 'Recommended Format',   'type' => Controls_Manager::TEXT, 'default' => 'Dry Ice Nuggets or Solid Blocks' ] );
		$rep->add_control( 'pack',    [ 'label' => 'Container Approach',   'type' => Controls_Manager::TEXT, 'default' => 'Vented thick-walled insulated shippers (UN 1845)' ] );
		$rep->add_control( 'summary', [ 'label' => 'Technical Rationale',  'type' => Controls_Manager::TEXTAREA, 'rows' => 3 ] );

		$this->add_control( 'items', [
			'label'       => __( 'Profiles', 'arctic-resto' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => [
				[
					'sector'  => 'RAPID CHILLING & VOID FILL',
					'title'   => 'Food Processing & Short-Window Parcel Packing',
					'format'  => 'Extruded Dry Ice Pellets',
					'pack'    => 'Poly-lined cartons or insulated production totes',
					'summary' => 'Small cylindrical pellets maximize surface area per pound, delivering rapid thermal drawdown and pouring easily around irregular trays or pouches.',
				],
				[
					'sector'  => 'EXTENDED HOLD DURATION',
					'title'   => '48–96 Hour Cold-Chain Freight & Distribution',
					'format'  => 'Solid Dry Ice Blocks or Dense Nuggets',
					'pack'    => 'Heavy-duty rotationally molded vented insulated totes',
					'summary' => 'Higher mass-to-surface geometry slows sublimation velocity, preserving cooling mass across longer transit legs and warehouse staging.',
				],
				[
					'sector'  => 'SPECIMEN & REAGENT TRANSPORT',
					'title'   => 'Clinical, Biotech & Research Cold-Chain',
					'format'  => 'High-Density Pellets or Cut Slabs',
					'pack'    => 'Validated vented benchtop coolers & UN 1845 shippers',
					'summary' => 'Surrounding diagnostic vials or sample racks with uniform pellets maintains -78.5°C thermal stability without liquid phase contamination.',
				],
			],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = $s['items'] ?? [];
		?>
		<section class="ar-w-sec ar-cases-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>
				<div class="ar-grid ar-grid--3">
					<?php foreach ( $items as $it ) : ?>
						<article class="ar-card ar-profile-card">
							<span class="ar-badge ar-badge--subtle"><?php echo esc_html( $it['sector'] ?? '' ); ?></span>
							<h3 class="ar-profile-card__title"><?php echo esc_html( $it['title'] ?? '' ); ?></h3>
							<dl class="ar-spec-dl">
								<dt><?php esc_html_e( 'Preferred Format', 'arctic-resto' ); ?></dt>
								<dd><?php echo esc_html( $it['format'] ?? '' ); ?></dd>
								<dt><?php esc_html_e( 'Packaging Setup', 'arctic-resto' ); ?></dt>
								<dd><?php echo esc_html( $it['pack'] ?? '' ); ?></dd>
							</dl>
							<p class="ar-profile-card__desc"><?php echo esc_html( $it['summary'] ?? '' ); ?></p>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}
}

/**
 * 3. Supply & Quality Commitments (`ar_testimonials`)
 * Note: Replaces fabricated customer reviews with truthful operational commitments.
 */
class W_Testimonials extends Base_Widget {
	public function get_name() { return 'ar_testimonials'; }
	public function get_title() { return __( 'AR · Supply & Quality Commitments', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-shield'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Commitments', 'arctic-resto' ) ] );
		$this->register_header_controls(
			'OUR SUPPLY PHILOSOPHY',
			'What Commercial Buyers Can Expect from ArcticRestoDRY ICE',
			'Built around clear communication, realistic sublimation planning, and disciplined packaging rather than overpromised claims.'
		);
		$rep = new Repeater();
		$rep->add_control( 'pillar', [ 'label' => 'Commitment Pillar', 'type' => Controls_Manager::TEXT, 'default' => 'DISPATCH ALIGNMENT' ] );
		$rep->add_control( 'title',  [ 'label' => 'Title',             'type' => Controls_Manager::TEXT, 'default' => 'Production Timed to Your Order Window' ] );
		$rep->add_control( 'body',   [ 'label' => 'Explanation',       'type' => Controls_Manager::TEXTAREA, 'rows' => 3 ] );

		$this->add_control( 'items', [
			'label'       => __( 'Commitment Cards', 'arctic-resto' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => [
				[
					'pillar' => 'SUBLIMATION MANAGEMENT',
					'title'  => 'Production Scheduled Close to Dispatch',
					'body'   => 'Because solid CO₂ sublimates continuously, we prioritize fresh production runs aligned with scheduled collection and delivery windows.',
				],
				[
					'pillar' => 'TRANSPARENT SPECIFICATIONS',
					'title'  => 'Honest Format & Container Guidance',
					'body'   => 'We help buyers compare pellets, nuggets, and blocks objectively so you order the right format and realistic buffer weight for your transit time.',
				],
				[
					'pillar' => 'SAFETY-FIRST FULFILLMENT',
					'title'  => 'Vented Packaging & Clear Handling Protocols',
					'body'   => 'Every order emphasizes proper vented container usage, CO₂ ventilation awareness, and insulated PPE handling.',
				],
			],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = $s['items'] ?? [];
		?>
		<section class="ar-w-sec ar-commitments-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>
				<div class="ar-grid ar-grid--3">
					<?php foreach ( $items as $it ) : ?>
						<div class="ar-card ar-commitment-card">
							<span class="ar-badge"><?php echo ar_svg( 'shield', 13 ); ?> <?php echo esc_html( $it['pillar'] ?? '' ); ?></span>
							<h3 class="ar-commitment-card__title"><?php echo esc_html( $it['title'] ?? '' ); ?></h3>
							<p class="ar-commitment-card__body"><?php echo esc_html( $it['body'] ?? '' ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}
}

/**
 * 4. Blog & Technical Resource Articles Grid (`ar_posts`)
 */
class W_Posts extends Base_Widget {
	public function get_name() { return 'ar_posts'; }
	public function get_title() { return __( 'AR · Blog & Technical Articles Grid', 'arctic-resto' ); }
	public function get_icon() { return 'eicon-post-list'; }

	protected function register_controls() {
		$this->start_controls_section( 'c', [ 'label' => __( 'Blog Posts Grid', 'arctic-resto' ) ] );
		$this->register_header_controls(
			'TECHNICAL GUIDES & RESOURCES',
			'Dry Ice Manufacturing, Storage, Sublimation & Buyer Guides',
			'Practical articles explaining dry ice formats, cold-chain calculations, container selection, and safe CO₂ handling.'
		);
		$this->add_control( 'count', [
			'label'   => __( 'Posts to Display', 'arctic-resto' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 6,
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$count = max( 1, min( 18, (int) ( $s['count'] ?? 6 ) ) );
		$posts = get_posts( [
			'post_type'      => 'post',
			'posts_per_page' => $count,
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		] );
		?>
		<section class="ar-w-sec ar-posts-sec">
			<div class="ar-container">
				<?php $this->section_header( $s ); ?>
				<?php if ( ! empty( $posts ) ) : ?>
					<div class="ar-grid ar-grid--3">
						<?php foreach ( $posts as $p ) :
							$thumb = get_the_post_thumbnail_url( $p->ID, 'ar-card' ) ?: ( AR_URI . '/assets/images/dry-ice-pellets.jpg' );
							$cats  = get_the_category( $p->ID );
							$cat   = ! empty( $cats ) ? $cats[0]->name : 'Technical Guide';
							?>
							<article class="ar-card ar-post-card">
								<a href="<?php echo esc_url( get_permalink( $p ) ); ?>" class="ar-post-card__media">
									<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $p ) ); ?>" loading="lazy" />
									<span class="ar-post-card__cat"><?php echo esc_html( $cat ); ?></span>
								</a>
								<div class="ar-post-card__body">
									<div class="ar-post-card__meta">
										<span><?php echo esc_html( get_the_date( '', $p ) ); ?></span>
										<span>·</span>
										<span><?php esc_html_e( 'Dry Ice Resource', 'arctic-resto' ); ?></span>
									</div>
									<h3 class="ar-post-card__title">
										<a href="<?php echo esc_url( get_permalink( $p ) ); ?>"><?php echo esc_html( get_the_title( $p ) ); ?></a>
									</h3>
									<p class="ar-post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $p ), 22, '…' ) ); ?></p>
									<a href="<?php echo esc_url( get_permalink( $p ) ); ?>" class="ar-link">
										<span><?php esc_html_e( 'Read Full Guide', 'arctic-resto' ); ?></span>
										<?php echo ar_svg( 'arrow-right', 14 ); ?>
									</a>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
