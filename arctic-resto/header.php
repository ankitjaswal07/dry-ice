<?php
/**
 * Header. Uses an Elementor Theme Builder header when one exists.
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#061325">
	<script>(function(){var h=document.documentElement;h.className+=' ar-js';setTimeout(function(){if(h.className.indexOf('ar-ready')<0){h.className+=' ar-failsafe';}},4000);}());</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="ar-skip" href="#content"><?php esc_html_e( 'Skip to content', 'arctic-resto' ); ?></a>
<div class="ar-progress" aria-hidden="true"><i></i></div>
<?php
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
	get_template_part( 'template-parts/site-header' );
}
?>
<main id="content" class="ar-main">
