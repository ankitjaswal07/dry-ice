<?php
/**
 * ArcticRestoDRY ICE — Single Blog / Resource Article Template (`single.php`).
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
	$cats      = get_the_category();
	$cat_name  = ! empty( $cats ) ? $cats[0]->name : 'Dry Ice Technical Guide';
	$word_cnt  = str_word_count( wp_strip_all_tags( get_the_content() ) );
	$read_mins = max( 3, (int) ceil( $word_cnt / 200 ) );
	$thumb     = get_the_post_thumbnail_url( get_the_ID(), 'ar-hero' );
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'ar-single-article' ); ?>>
		<header class="ar-page-hero ar-page-hero--article">
			<div class="ar-container">
				<nav class="ar-breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'arctic-resto' ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'arctic-resto' ); ?></a>
					<span aria-hidden="true">/</span>
					<a href="<?php echo esc_url( ar_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog & Resources', 'arctic-resto' ); ?></a>
					<span aria-hidden="true">/</span>
					<span><?php the_title(); ?></span>
				</nav>
				<div class="ar-article-meta">
					<span class="ar-badge"><?php echo ar_svg( 'snowflake', 13 ); ?> <?php echo esc_html( $cat_name ); ?></span>
					<span class="ar-article-meta__item"><?php echo esc_html( get_the_date() ); ?></span>
					<span class="ar-article-meta__item"><?php echo esc_html( $read_mins . ' min read' ); ?></span>
				</div>
				<h1 class="ar-page-hero__title"><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p class="ar-page-hero__sub"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
			</div>
		</header>

		<div class="ar-section">
			<div class="ar-container ar-article-layout">
				<div class="ar-article-main">
					<?php if ( $thumb ) : ?>
						<figure class="ar-article-featured">
							<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" />
						</figure>
					<?php endif; ?>
					<div class="ar-prose">
						<?php the_content(); ?>
					</div>
				</div>

				<aside class="ar-article-sidebar" aria-label="<?php esc_attr_e( 'Dry Ice Supply & Safety Resources', 'arctic-resto' ); ?>">
					<div class="ar-card ar-sidebar-box">
						<span class="ar-badge"><?php echo ar_svg( 'cube', 13 ); ?> <?php esc_html_e( 'DRY ICE SUPPLY', 'arctic-resto' ); ?></span>
						<h3><?php esc_html_e( 'Need Pellets, Blocks, or Nuggets?', 'arctic-resto' ); ?></h3>
						<p><?php esc_html_e( 'Request specifications, insulated container options, or a recurring bulk delivery quote from ArcticRestoDRY ICE.', 'arctic-resto' ); ?></p>
						<a href="<?php echo esc_url( ar_url( '/contact/#quote' ) ); ?>" class="ar-btn ar-btn--primary ar-btn--block">
							<span><?php esc_html_e( 'Request a Quote', 'arctic-resto' ); ?></span>
							<?php echo ar_svg( 'arrow-right', 16 ); ?>
						</a>
						<a href="<?php echo esc_url( ar_url( '/dry-ice-products/' ) ); ?>" class="ar-btn ar-btn--ghost ar-btn--block" style="margin-top:10px;">
							<span><?php esc_html_e( 'Compare Dry Ice Formats', 'arctic-resto' ); ?></span>
						</a>
					</div>

					<div class="ar-card ar-sidebar-box ar-sidebar-box--safety">
						<span class="ar-badge ar-badge--amber"><?php echo ar_svg( 'alert', 13 ); ?> <?php esc_html_e( 'SAFETY REMINDER', 'arctic-resto' ); ?></span>
						<h4><?php esc_html_e( 'Solid CO₂ Handling (-78.5°C / -109.3°F)', 'arctic-resto' ); ?></h4>
						<p><?php esc_html_e( 'Always wear insulated cryogenic gloves, ensure room and vehicle ventilation, and store dry ice only in vented insulated containers.', 'arctic-resto' ); ?></p>
						<a href="<?php echo esc_url( ar_url( '/dry-ice-safety/' ) ); ?>" class="ar-link">
							<span><?php esc_html_e( 'View Full Safety & Storage Guide', 'arctic-resto' ); ?></span>
							<?php echo ar_svg( 'arrow-right', 14 ); ?>
						</a>
					</div>
				</aside>
			</div>
		</div>
	</article>
	<?php
endwhile;

get_footer();
