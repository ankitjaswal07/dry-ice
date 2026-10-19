<?php
/**
 * ArcticRestoDRY ICE — 404 Not Found Template (`404.php`).
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<section class="ar-page-hero" style="padding:96px 0;">
	<div class="ar-container" style="text-align:center;max-width:760px;">
		<span class="ar-badge"><?php echo ar_svg( 'snowflake', 14 ); ?> <?php esc_html_e( '404 · PAGE NOT FOUND', 'arctic-resto' ); ?></span>
		<h1 class="ar-page-hero__title"><?php esc_html_e( 'That Page Has Sublimated', 'arctic-resto' ); ?></h1>
		<p class="ar-page-hero__sub">
			<?php esc_html_e( 'The page you requested may have moved during our transition to ArcticRestoDRY ICE. Explore our dry ice product formats, bulk ordering options, or safety documentation below.', 'arctic-resto' ); ?>
		</p>
		<div style="display:flex;flex-wrap:wrap;gap:12px;justify-content:center;margin-top:28px;">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ar-btn ar-btn--primary">
				<span><?php esc_html_e( 'Return to Homepage', 'arctic-resto' ); ?></span>
				<?php echo ar_svg( 'arrow-right', 16 ); ?>
			</a>
			<a href="<?php echo esc_url( ar_url( '/dry-ice-products/' ) ); ?>" class="ar-btn ar-btn--ghost">
				<span><?php esc_html_e( 'Explore Dry Ice Products', 'arctic-resto' ); ?></span>
			</a>
			<a href="<?php echo esc_url( ar_url( '/bulk-orders/' ) ); ?>" class="ar-btn ar-btn--ghost">
				<span><?php esc_html_e( 'Bulk Dry Ice Orders', 'arctic-resto' ); ?></span>
			</a>
			<a href="<?php echo esc_url( ar_url( '/contact/#quote' ) ); ?>" class="ar-btn ar-btn--ghost">
				<span><?php esc_html_e( 'Request a Quote', 'arctic-resto' ); ?></span>
			</a>
		</div>
	</div>
</section>
<?php
get_footer();
