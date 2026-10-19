<?php
/**
 * Single service. Built with Elementor by default; falls back to a themed layout.
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
while ( have_posts() ) {
	the_post();
	if ( ar_is_elementor() ) {
		the_content();
		continue;
	}
	$m = ar_service_meta( get_the_ID() );
	?>
	<section class="ar-sec ar-phero ar-t-void">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="ar-hero__bg"><?php the_post_thumbnail( 'ar-hero', array( 'loading' => 'eager', 'fetchpriority' => 'high', 'alt' => '' ) ); ?></div>
		<?php endif; ?>
		<div class="ar-hero__shade"></div><div class="ar-hero__grid"></div>
		<div class="ar-wrap ar-phero__inner">
			<?php echo ar_breadcrumbs(); // phpcs:ignore ?>
			<?php if ( $m['tagline'] ) : ?><p class="ar-eyebrow"><i></i><?php echo esc_html( $m['tagline'] ); ?></p><?php endif; ?>
			<h1 class="ar-phero__title"><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?><p class="ar-phero__sub"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
		</div>
	</section>
	<section class="ar-sec ar-t-light ar-pad-lg">
		<div class="ar-wrap ar-wrap--narrow">
			<div class="ar-prose ar-prose--article"><?php the_content(); ?></div>
			<?php if ( $m['points'] ) : ?>
				<ul class="ar-checks"><?php foreach ( $m['points'] as $pt ) { echo '<li>' . ar_svg( 'check' ) . '<span>' . esc_html( $pt ) . '</span></li>'; } // phpcs:ignore ?></ul>
			<?php endif; ?>
		</div>
	</section>
	<?php
}
get_footer();
