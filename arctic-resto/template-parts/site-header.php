<?php
/**
 * ArcticRestoDRY ICE — Site Header Template Part.
 *
 * Includes top dry-ice information bar, brand logo ("ArcticRestoDRY ICE"),
 * responsive primary navigation with dropdowns, secondary "Bulk Orders" link,
 * and primary "Request a Quote" CTA button.
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$topbar_enable = (bool) ar_opt( 'topbar_enable', true );
$topbar_badge  = (string) ar_opt( 'topbar_badge', 'DRY ICE MANUFACTURING & SUPPLY' );
$topbar_text   = (string) ar_opt( 'topbar_text', 'Pellets, Nuggets & Blocks · Commercial & Bulk Supply · Vented Insulated Packaging' );
$cta_label     = (string) ar_opt( 'header_cta_label', 'Request a Quote' );
$cta_url       = ar_url( (string) ar_opt( 'header_cta_url', '/contact/#quote' ) );
$sec_label     = (string) ar_opt( 'header_sec_label', 'Bulk Orders' );
$sec_url       = ar_url( (string) ar_opt( 'header_sec_url', '/bulk-orders/' ) );
$has_phone     = ar_has_contact_value( 'phone' );
$phone_val     = (string) get_theme_mod( 'ar_phone', '' );
?>
<?php if ( $topbar_enable ) : ?>
<div class="ar-topbar" role="region" aria-label="<?php esc_attr_e( 'Dry Ice Supply Notice', 'arctic-resto' ); ?>">
	<div class="ar-container ar-topbar__inner">
		<div class="ar-topbar__left">
			<span class="ar-topbar__badge"><?php echo ar_svg( 'snowflake', 13 ); ?> <?php echo esc_html( $topbar_badge ); ?></span>
			<span class="ar-topbar__text"><?php echo esc_html( $topbar_text ); ?></span>
		</div>
		<div class="ar-topbar__right">
			<a href="<?php echo esc_url( ar_url( '/dry-ice-safety/' ) ); ?>" class="ar-topbar__link">
				<?php echo ar_svg( 'shield', 14 ); ?>
				<span><?php esc_html_e( 'Safety & Handling (-78.5°C)', 'arctic-resto' ); ?></span>
			</a>
			<a href="<?php echo esc_url( ar_url( '/delivery-areas/' ) ); ?>" class="ar-topbar__link">
				<?php echo ar_svg( 'truck', 14 ); ?>
				<span><?php esc_html_e( 'Delivery & Supply Areas', 'arctic-resto' ); ?></span>
			</a>
			<?php if ( $has_phone ) : ?>
				<a href="<?php echo esc_url( ar_tel_href( $phone_val ) ); ?>" class="ar-topbar__link ar-topbar__link--phone">
					<?php echo ar_svg( 'phone', 14 ); ?>
					<span><?php echo esc_html( $phone_val ); ?></span>
				</a>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php endif; ?>

<header id="masthead" class="ar-header" data-ar-header>
	<div class="ar-container ar-header__inner">
		<div class="ar-header__brand">
			<?php if ( has_custom_logo() ) : ?>
				<div class="ar-logo-custom"><?php the_custom_logo(); ?></div>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ar-brand" rel="home" aria-label="<?php echo esc_attr( ar_opt( 'brand_name', 'ArcticRestoDRY ICE' ) ); ?>">
					<span class="ar-brand__mark" aria-hidden="true">
						<?php echo ar_svg( 'snowflake', 22 ); ?>
					</span>
					<span class="ar-brand__text">
						<span class="ar-brand__title">ArcticResto<span class="ar-brand__pill">DRY ICE</span></span>
						<span class="ar-brand__sub"><?php esc_html_e( 'Manufacturing & Supply', 'arctic-resto' ); ?></span>
					</span>
				</a>
			<?php endif; ?>
		</div>

		<nav id="site-navigation" class="ar-nav" aria-label="<?php esc_attr_e( 'Primary Navigation', 'arctic-resto' ); ?>" data-ar-nav>
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( [
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'ar-nav__list',
					'fallback_cb'    => 'ar_fallback_menu',
					'depth'          => 2,
				] );
			} else {
				ar_fallback_menu();
			}
			?>
		</nav>

		<div class="ar-header__actions">
			<a href="<?php echo esc_url( $sec_url ); ?>" class="ar-btn ar-btn--ghost ar-btn--sm ar-hide-tablet">
				<?php echo ar_svg( 'package', 16 ); ?>
				<span><?php echo esc_html( $sec_label ); ?></span>
			</a>
			<a href="<?php echo esc_url( $cta_url ); ?>" class="ar-btn ar-btn--primary ar-btn--sm">
				<span><?php echo esc_html( $cta_label ); ?></span>
				<?php echo ar_svg( 'arrow-right', 16 ); ?>
			</a>
			<button type="button" class="ar-burger" aria-expanded="false" aria-controls="ar-mobile-drawer" aria-label="<?php esc_attr_e( 'Toggle navigation menu', 'arctic-resto' ); ?>" data-ar-burger>
				<?php echo ar_svg( 'menu', 22 ); ?>
			</button>
		</div>
	</div>

	<!-- Mobile Navigation Drawer -->
	<div id="ar-mobile-drawer" class="ar-drawer" hidden data-ar-drawer>
		<div class="ar-drawer__inner">
			<div class="ar-drawer__top">
				<span class="ar-brand__title">ArcticResto<span class="ar-brand__pill">DRY ICE</span></span>
				<button type="button" class="ar-drawer__close" aria-label="<?php esc_attr_e( 'Close navigation menu', 'arctic-resto' ); ?>" data-ar-drawer-close>
					<?php echo ar_svg( 'close', 22 ); ?>
				</button>
			</div>
			<div class="ar-drawer__nav">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu( [
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'ar-drawer__list',
						'fallback_cb'    => 'ar_fallback_menu',
						'depth'          => 2,
					] );
				} else {
					ar_fallback_menu();
				}
				?>
			</div>
			<div class="ar-drawer__cta">
				<a href="<?php echo esc_url( $cta_url ); ?>" class="ar-btn ar-btn--primary ar-btn--block">
					<span><?php echo esc_html( $cta_label ); ?></span>
					<?php echo ar_svg( 'arrow-right', 16 ); ?>
				</a>
				<a href="<?php echo esc_url( $sec_url ); ?>" class="ar-btn ar-btn--ghost ar-btn--block">
					<span><?php echo esc_html( $sec_label ); ?></span>
				</a>
			</div>
		</div>
	</div>
</header>
