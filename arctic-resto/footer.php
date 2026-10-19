<?php
/**
 * ArcticRestoDRY ICE — Theme Footer Wrapper (`footer.php`).
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</main>
<?php
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
	get_template_part( 'template-parts/site-footer' );
}
wp_footer();
?>
</body>
</html>
