<?php
/**
 * ArcticRestoDRY ICE — Site Footer Template Part.
 *
 * Includes dry ice product & solution navigation, configurable contact
 * placeholders, safety handling notice, and the secondary cross-promotion
 * link for Arctic Resto Dry Ice Cleaning Services (https://arcticresto.com/).
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$summary           = (string) ar_opt( 'footer_summary' );
$safety_note       = (string) ar_opt( 'footer_safety_note' );
$copyright_raw     = (string) ar_opt( 'footer_copyright' );
$copyright         = str_replace( '{year}', gmdate( 'Y' ), $copyright_raw );
$promo_enable      = (bool) ar_opt( 'cross_promo_enable', true );
$promo_badge       = (string) ar_opt( 'cross_promo_badge' );
$promo_heading     = (string) ar_opt( 'cross_promo_heading' );
$promo_body        = (string) ar_opt( 'cross_promo_body' );
$promo_btn         = (string) ar_opt( 'cross_promo_btn_label' );
$promo_url         = (string) ar_opt( 'cross_promo_url', 'https://arcticresto.com/' );
$promo_new_tab     = (bool) ar_opt( 'cross_promo_new_tab', true );
$sticky_cta        = (bool) ar_opt( 'enable_sticky_cta', true );
$sticky_label      = (string) ar_opt( 'sticky_cta_label', 'Request a Dry Ice Quote' );
?>
<footer id="colophon" class="ar-footer">
	<!-- Safety Reminder Strip -->
	<div class="ar-footer__safety">
		<div class="ar-container ar-footer__safety-inner">
			<span class="ar-footer__safety-icon"><?php echo ar_svg( 'alert', 18 ); ?></span>
			<p class="ar-footer__safety-text">
				<?php echo esc_html( $safety_note ); ?>
				<a href="<?php echo esc_url( ar_url( '/dry-ice-safety/' ) ); ?>"><?php esc_html_e( 'Read Full Safety & Storage Guide →', 'arctic-resto' ); ?></a>
			</p>
		</div>
	</div>

	<div class="ar-container ar-footer__main">
		<div class="ar-footer__grid">
			<!-- Col 1: Brand & Contact Placeholders -->
			<div class="ar-footer__col ar-footer__col--brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ar-brand" rel="home">
					<span class="ar-brand__mark" aria-hidden="true"><?php echo ar_svg( 'snowflake', 22 ); ?></span>
					<span class="ar-brand__text">
						<span class="ar-brand__title">ArcticResto<span class="ar-brand__pill">DRY ICE</span></span>
						<span class="ar-brand__sub"><?php echo esc_html( ar_opt( 'brand_tagline' ) ); ?></span>
					</span>
				</a>
				<p class="ar-footer__desc"><?php echo esc_html( $summary ); ?></p>

				<ul class="ar-footer__contact">
					<li>
						<?php echo ar_svg( 'phone', 16 ); ?>
						<?php if ( ar_has_contact_value( 'phone' ) ) : ?>
							<a href="<?php echo esc_url( ar_tel_href() ); ?>"><?php echo esc_html( ar_contact_display( 'phone' ) ); ?></a>
						<?php else : ?>
							<span class="ar-placeholder-note"><?php echo esc_html( ar_contact_display( 'phone' ) ); ?></span>
						<?php endif; ?>
					</li>
					<li>
						<?php echo ar_svg( 'mail', 16 ); ?>
						<?php if ( ar_has_contact_value( 'email' ) ) : ?>
							<a href="mailto:<?php echo esc_attr( ar_contact_display( 'email' ) ); ?>"><?php echo esc_html( ar_contact_display( 'email' ) ); ?></a>
						<?php else : ?>
							<span class="ar-placeholder-note"><?php echo esc_html( ar_contact_display( 'email' ) ); ?></span>
						<?php endif; ?>
					</li>
					<li>
						<?php echo ar_svg( 'map-pin', 16 ); ?>
						<span class="<?php echo ar_has_contact_value( 'address' ) ? '' : 'ar-placeholder-note'; ?>"><?php echo esc_html( ar_contact_display( 'address' ) ); ?></span>
					</li>
					<li>
						<?php echo ar_svg( 'clock', 16 ); ?>
						<span class="<?php echo ar_has_contact_value( 'hours' ) ? '' : 'ar-placeholder-note'; ?>"><?php echo esc_html( ar_contact_display( 'hours' ) ); ?></span>
					</li>
				</ul>
			</div>

			<!-- Col 2: Dry Ice Products & Manufacturing -->
			<div class="ar-footer__col">
				<h3 class="ar-footer__heading"><?php esc_html_e( 'Products & Manufacturing', 'arctic-resto' ); ?></h3>
				<?php
				if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu( [
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => 'ar-footer__links',
						'depth'          => 1,
					] );
				} else {
					ar_fallback_footer_menu( 'products' );
				}
				?>
			</div>

			<!-- Col 3: Industries, Applications & Safety -->
			<div class="ar-footer__col">
				<h3 class="ar-footer__heading"><?php esc_html_e( 'Applications & Safety', 'arctic-resto' ); ?></h3>
				<?php
				if ( has_nav_menu( 'footer_solutions' ) ) {
					wp_nav_menu( [
						'theme_location' => 'footer_solutions',
						'container'      => false,
						'menu_class'     => 'ar-footer__links',
						'depth'          => 1,
					] );
				} else {
					ar_fallback_footer_menu( 'solutions' );
				}
				?>
			</div>

			<!-- Col 4: Company & Quote Request -->
			<div class="ar-footer__col">
				<h3 class="ar-footer__heading"><?php esc_html_e( 'Company & Quote Desk', 'arctic-resto' ); ?></h3>
				<?php
				if ( has_nav_menu( 'footer_company' ) ) {
					wp_nav_menu( [
						'theme_location' => 'footer_company',
						'container'      => false,
						'menu_class'     => 'ar-footer__links',
						'depth'          => 1,
					] );
				} else {
					ar_fallback_footer_menu( 'company' );
				}
				?>
				<div class="ar-footer__cta-card">
					<p class="ar-footer__cta-title"><?php esc_html_e( 'Need Dry Ice Supply or Recurring Delivery?', 'arctic-resto' ); ?></p>
					<a href="<?php echo esc_url( ar_url( '/contact/#quote' ) ); ?>" class="ar-btn ar-btn--primary ar-btn--sm ar-btn--block">
						<span><?php esc_html_e( 'Request a Quote', 'arctic-resto' ); ?></span>
						<?php echo ar_svg( 'arrow-right', 15 ); ?>
					</a>
				</div>
			</div>
		</div>

		<?php if ( $promo_enable ) : ?>
		<!-- Visually Secondary Cross-Promotion Bar for Arctic Resto Cleaning Services -->
		<div class="ar-footer__cross-promo" role="complementary" aria-label="<?php esc_attr_e( 'Related Mobile Dry Ice Cleaning Services', 'arctic-resto' ); ?>">
			<div class="ar-footer__cross-promo-copy">
				<span class="ar-badge ar-badge--subtle"><?php echo ar_svg( 'sparkles', 13 ); ?> <?php echo esc_html( $promo_badge ); ?></span>
				<h4 class="ar-footer__cross-promo-title"><?php echo esc_html( $promo_heading ); ?></h4>
				<p class="ar-footer__cross-promo-desc"><?php echo esc_html( $promo_body ); ?></p>
			</div>
			<div class="ar-footer__cross-promo-action">
				<a href="<?php echo esc_url( $promo_url ); ?>" class="ar-btn ar-btn--ghost ar-btn--sm" <?php echo $promo_new_tab ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
					<span><?php echo esc_html( $promo_btn ); ?></span>
					<?php echo ar_svg( 'external-link', 15 ); ?>
				</a>
			</div>
		</div>
		<?php endif; ?>

		<div class="ar-footer__bottom">
			<p class="ar-footer__copy"><?php echo esc_html( $copyright ); ?></p>
			<div class="ar-footer__legal">
				<a href="<?php echo esc_url( ar_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'arctic-resto' ); ?></a>
				<a href="<?php echo esc_url( ar_url( '/dry-ice-safety/' ) ); ?>"><?php esc_html_e( 'Safety & Handling Disclaimers', 'arctic-resto' ); ?></a>
				<a href="<?php echo esc_url( ar_url( '/quality/' ) ); ?>"><?php esc_html_e( 'Specifications Notice', 'arctic-resto' ); ?></a>
				<a href="<?php echo esc_url( $promo_url ); ?>" <?php echo $promo_new_tab ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>><?php esc_html_e( 'Arctic Resto Cleaning Services ↗', 'arctic-resto' ); ?></a>
			</div>
		</div>
	</div>
</footer>

<?php if ( $sticky_cta ) : ?>
<div class="ar-sticky-cta" data-ar-sticky-cta>
	<a href="<?php echo esc_url( ar_url( '/contact/#quote' ) ); ?>" class="ar-sticky-cta__btn">
		<?php echo ar_svg( 'snowflake', 16 ); ?>
		<span><?php echo esc_html( $sticky_label ); ?></span>
		<?php echo ar_svg( 'arrow-right', 15 ); ?>
	</a>
</div>
<?php endif; ?>
