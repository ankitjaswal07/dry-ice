<?php
/**
 * ArcticRestoDRY ICE — Single Dry Ice Product Format Template (`single-ar_product.php`).
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	if ( ar_is_elementor() ) {
		echo '<div class="ar-elementor-canvas">';
		the_content();
		echo '</div>';
		continue;
	}
	$id           = get_the_ID();
	$badge        = get_post_meta( $id, '_ar_prod_badge', true ) ?: 'DRY ICE FORMAT';
	$subtitle     = get_post_meta( $id, '_ar_prod_subtitle', true ) ?: get_the_excerpt();
	$sizes        = get_post_meta( $id, '_ar_prod_sizes', true ) ?: 'Placeholder — confirm available dimensions with dispatch';
	$packaging    = get_post_meta( $id, '_ar_prod_packaging', true ) ?: 'Vented insulated totes or poly-lined cartons';
	$moq          = get_post_meta( $id, '_ar_prod_moq', true ) ?: 'Placeholder — confirm minimum order quantity with sales';
	$handling     = get_post_meta( $id, '_ar_prod_handling', true ) ?: 'Store at -78.5°C (-109.3°F) in vented insulated containers; handle with insulated gloves.';
	$spec_notice  = get_post_meta( $id, '_ar_prod_spec_notice', true ) ?: 'Specifications shown are general industry reference placeholders and should be verified against your facility supply order.';
	$apps_raw     = (string) get_post_meta( $id, '_ar_prod_applications', true );
	$apps         = array_filter( array_map( 'trim', explode( "\n", $apps_raw ) ) );
	$thumb        = get_the_post_thumbnail_url( $id, 'ar-hero' ) ?: ( AR_URI . '/assets/images/dry-ice-pellets.jpg' );
	?>
	<section class="ar-page-hero">
		<div class="ar-container">
			<nav class="ar-breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'arctic-resto' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'arctic-resto' ); ?></a>
				<span aria-hidden="true">/</span>
				<a href="<?php echo esc_url( ar_url( '/dry-ice-products/' ) ); ?>"><?php esc_html_e( 'Dry Ice Products', 'arctic-resto' ); ?></a>
				<span aria-hidden="true">/</span>
				<span><?php the_title(); ?></span>
			</nav>
			<span class="ar-badge"><?php echo ar_svg( 'cube', 13 ); ?> <?php echo esc_html( $badge ); ?></span>
			<h1 class="ar-page-hero__title"><?php the_title(); ?></h1>
			<p class="ar-page-hero__sub"><?php echo esc_html( $subtitle ); ?></p>
		</div>
	</section>

	<section class="ar-section">
		<div class="ar-container ar-article-layout">
			<div class="ar-article-main">
				<figure class="ar-article-featured">
					<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" />
				</figure>
				<div class="ar-prose">
					<?php the_content(); ?>
				</div>
				<?php if ( ! empty( $apps ) ) : ?>
					<div class="ar-card" style="padding:28px;margin-top:28px;">
						<h3><?php esc_html_e( 'Typical Commercial & Industrial Applications', 'arctic-resto' ); ?></h3>
						<ul class="ar-check-list">
							<?php foreach ( $apps as $app ) : ?>
								<li><?php echo ar_svg( 'check', 16 ); ?> <span><?php echo esc_html( $app ); ?></span></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
			</div>

			<aside class="ar-article-sidebar">
				<div class="ar-card ar-sidebar-box">
					<h3><?php esc_html_e( 'Format Parameters (Editable)', 'arctic-resto' ); ?></h3>
					<dl class="ar-spec-dl">
						<dt><?php esc_html_e( 'Dimensions / Sizes', 'arctic-resto' ); ?></dt>
						<dd><?php echo esc_html( $sizes ); ?></dd>
						<dt><?php esc_html_e( 'Packaging Options', 'arctic-resto' ); ?></dt>
						<dd><?php echo esc_html( $packaging ); ?></dd>
						<dt><?php esc_html_e( 'Order Minimums', 'arctic-resto' ); ?></dt>
						<dd><?php echo esc_html( $moq ); ?></dd>
						<dt><?php esc_html_e( 'Storage & Handling', 'arctic-resto' ); ?></dt>
						<dd><?php echo esc_html( $handling ); ?></dd>
					</dl>
					<p class="ar-placeholder-note" style="margin-top:12px;font-size:12px;"><?php echo esc_html( $spec_notice ); ?></p>
					<a href="<?php echo esc_url( ar_url( '/contact/#quote' ) ); ?>" class="ar-btn ar-btn--primary ar-btn--block" style="margin-top:16px;">
						<span><?php esc_html_e( 'Request Quote for This Format', 'arctic-resto' ); ?></span>
						<?php echo ar_svg( 'arrow-right', 16 ); ?>
					</a>
				</div>
			</aside>
		</div>
	</section>
	<?php
endwhile;

get_footer();
