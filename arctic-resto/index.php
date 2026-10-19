<?php
/**
 * ArcticRestoDRY ICE — Blog & Resource Archive Template (`index.php`).
 *
 * Supports both Elementor-built Blog pages (even if assigned as `page_for_posts`
 * in Settings → Reading) and native WordPress archive/category/search views.
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$posts_page_id = (int) get_option( 'page_for_posts' );
if ( is_home() && ! is_front_page() && $posts_page_id > 0 && ar_is_elementor( $posts_page_id ) && class_exists( '\Elementor\Plugin' ) ) {
	echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $posts_page_id );
	get_footer();
	return;
}
?>
<section class="ar-page-hero">
	<div class="ar-container">
		<span class="ar-badge"><?php echo ar_svg( 'snowflake', 14 ); ?> <?php esc_html_e( 'DRY ICE TECHNICAL LIBRARY & BUYER GUIDES', 'arctic-resto' ); ?></span>
		<h1 class="ar-page-hero__title">
			<?php
			if ( is_category() || is_tag() || is_archive() ) {
				the_archive_title();
			} elseif ( is_search() ) {
				/* translators: %s: search query */
				printf( esc_html__( 'Search Results for "%s"', 'arctic-resto' ), get_search_query() );
			} else {
				esc_html_e( 'Dry Ice Resources, Cold-Chain Guides & Safety Insights', 'arctic-resto' );
			}
			?>
		</h1>
		<p class="ar-page-hero__sub">
			<?php esc_html_e( 'Practical technical guidance on dry ice pellets vs. blocks, sublimation management, insulated container selection, cold-chain logistics, and safe CO₂ handling.', 'arctic-resto' ); ?>
		</p>
	</div>
</section>

<section class="ar-section">
	<div class="ar-container">
		<?php if ( have_posts() ) : ?>
			<div class="ar-grid ar-grid--3">
				<?php
				while ( have_posts() ) :
					the_post();
					$thumb = get_the_post_thumbnail_url( get_the_ID(), 'ar-card' ) ?: ( AR_URI . '/assets/images/dry-ice-pellets.jpg' );
					$cats  = get_the_category();
					$cat   = ! empty( $cats ) ? $cats[0]->name : 'Dry Ice Guide';
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'ar-card ar-post-card' ); ?>>
						<a href="<?php the_permalink(); ?>" class="ar-post-card__media">
							<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" />
							<span class="ar-post-card__cat"><?php echo esc_html( $cat ); ?></span>
						</a>
						<div class="ar-post-card__body">
							<div class="ar-post-card__meta">
								<span><?php echo esc_html( get_the_date() ); ?></span>
								<span>·</span>
								<span><?php esc_html_e( 'Technical Resource', 'arctic-resto' ); ?></span>
							</div>
							<h2 class="ar-post-card__title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>
							<p class="ar-post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24, '…' ) ); ?></p>
							<a href="<?php the_permalink(); ?>" class="ar-link">
								<span><?php esc_html_e( 'Read Technical Article', 'arctic-resto' ); ?></span>
								<?php echo ar_svg( 'arrow-right', 15 ); ?>
							</a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<div class="ar-pagination">
				<?php the_posts_pagination( [ 'mid_size' => 2 ] ); ?>
			</div>
		<?php else : ?>
			<div class="ar-card" style="padding:36px;text-align:center;">
				<h2><?php esc_html_e( 'No articles matched your filter', 'arctic-resto' ); ?></h2>
				<p><?php esc_html_e( 'Explore our core dry ice product specifications, safety documentation, or request a custom supply quote.', 'arctic-resto' ); ?></p>
				<a href="<?php echo esc_url( ar_url( '/dry-ice-products/' ) ); ?>" class="ar-btn ar-btn--primary"><?php esc_html_e( 'Explore Dry Ice Products', 'arctic-resto' ); ?></a>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
