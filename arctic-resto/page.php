<?php
/**
 * ArcticRestoDRY ICE — Default Page Template (`page.php`).
 *
 * Renders Elementor-built pages full-width so every section, container, and
 * widget is editable inside Elementor, while providing a structured industrial
 * wrapper for standard WordPress editor pages.
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	if ( ar_is_elementor() ) :
		?>
		<div class="ar-elementor-canvas">
			<?php the_content(); ?>
		</div>
		<?php
	else :
		?>
		<section class="ar-page-hero">
			<div class="ar-container">
				<nav class="ar-breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'arctic-resto' ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'arctic-resto' ); ?></a>
					<span aria-hidden="true">/</span>
					<span><?php the_title(); ?></span>
				</nav>
				<h1 class="ar-page-hero__title"><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p class="ar-page-hero__sub"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
			</div>
		</section>
		<section class="ar-section">
			<div class="ar-container ar-prose">
				<?php the_content(); ?>
			</div>
		</section>
		<?php
	endif;
endwhile;

get_footer();
