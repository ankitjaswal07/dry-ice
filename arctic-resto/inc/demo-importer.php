<?php
/**
 * ArcticRestoDRY ICE — One-Click & Programmatic Demo Content Importer.
 *
 * Imports all 16 Elementor-built pages, 4 Dry Ice Product CPT entries,
 * 8 Industries Served CPT entries, 3 Editable Placeholder Delivery Zones,
 * 8 full-length technical Blog Articles, Media Library assets, Navigation
 * Menus, and Elementor Global Kit settings.
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once AR_DIR . '/inc/demo/content.php';
require_once AR_DIR . '/inc/demo/pages-more.php';
require_once AR_DIR . '/inc/demo/cpt-posts.php';

/**
 * Add Admin Page under Appearance → ArcticRestoDRY ICE Demo Import.
 */
add_action( 'admin_menu', function () {
	add_theme_page(
		__( 'ArcticRestoDRY ICE Demo Import', 'arctic-resto' ),
		__( 'Dry Ice Demo Import', 'arctic-resto' ),
		'manage_options',
		'ar-demo-import',
		'ar_render_demo_importer_page'
	);
} );

add_action( 'admin_enqueue_scripts', function ( string $hook ) {
	if ( strpos( $hook, 'ar-demo-import' ) === false ) {
		return;
	}
	wp_enqueue_style( 'ar-admin', AR_URI . '/assets/css/admin.css', [], AR_VERSION );
	wp_enqueue_script( 'ar-admin', AR_URI . '/assets/js/admin.js', [ 'jquery' ], AR_VERSION, true );
	wp_localize_script( 'ar-admin', 'ARAdmin', [
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'ar_demo_import' ),
		'homeUrl' => home_url( '/' ),
	] );
} );

function ar_render_demo_importer_page(): void {
	?>
	<div class="wrap ar-admin-wrap">
		<div class="ar-admin-card">
			<span class="ar-admin-badge">ARCTICRESTODRY ICE · ELEMENTOR DEMO IMPORTER</span>
			<h1><?php esc_html_e( 'ArcticRestoDRY ICE Complete Website & Elementor Importer', 'arctic-resto' ); ?></h1>
			<p><?php esc_html_e( 'This one-click importer provisions all 16 dry ice manufacturing & supply pages with valid Elementor Flexbox Container + Widget data, 4 Dry Ice Product CPT entries, 8 Industries Served entries, 3 editable Delivery Zone placeholders, 8 full-length technical blog articles, navigation menus, and Elementor Global Kit tokens.', 'arctic-resto' ); ?></p>

			<div class="ar-admin-actions" style="margin:24px 0;display:flex;gap:12px;align-items:center;">
				<button type="button" id="ar-run-import" class="button button-primary button-hero">
					<?php esc_html_e( 'Import / Refresh ArcticRestoDRY ICE Website Content', 'arctic-resto' ); ?>
				</button>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button button-secondary button-hero" target="_blank">
					<?php esc_html_e( 'Preview Live Frontend ↗', 'arctic-resto' ); ?>
				</a>
			</div>

			<div id="ar-import-progress" style="display:none;margin-top:20px;">
				<div style="background:#1e293b;border-radius:8px;overflow:hidden;height:14px;">
					<div id="ar-import-bar" style="background:#38bdf8;width:0%;height:100%;transition:width 0.3s ease;"></div>
				</div>
				<pre id="ar-import-log" style="background:#0f172a;color:#e2e8f0;padding:16px;border-radius:8px;margin-top:12px;max-height:320px;overflow:auto;font-size:12px;"></pre>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Import or locate bundled image in WordPress Media Library.
 */
function ar_import_bundled_image( string $filename, string $alt = '' ): int {
	$existing = get_posts( [
		'post_type'      => 'attachment',
		'posts_per_page' => 1,
		'post_status'    => 'inherit',
		'meta_key'       => '_ar_source_file',
		'meta_value'     => $filename,
		'fields'         => 'ids',
	] );
	if ( ! empty( $existing ) ) {
		return (int) $existing[0];
	}

	$src = AR_DIR . '/assets/images/' . $filename;
	if ( ! file_exists( $src ) ) {
		return 0;
	}

	$upload = wp_upload_bits( $filename, null, file_get_contents( $src ) );
	if ( ! empty( $upload['error'] ) ) {
		return 0;
	}

	$filetype = wp_check_filetype( $upload['file'], null );
	$attach   = [
		'post_mime_type' => $filetype['type'] ?: 'image/jpeg',
		'post_title'     => $alt !== '' ? $alt : ucwords( str_replace( [ '-', '.jpg', '.png' ], ' ', $filename ) ),
		'post_content'   => '',
		'post_status'    => 'inherit',
	];

	$attach_id = wp_insert_attachment( $attach, $upload['file'] );
	if ( ! is_wp_error( $attach_id ) && $attach_id ) {
		require_once ABSPATH . 'wp-admin/includes/image.php';
		$meta = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
		wp_update_attachment_metadata( $attach_id, $meta );
		update_post_meta( $attach_id, '_ar_source_file', $filename );
		update_post_meta( $attach_id, '_wp_attachment_image_alt', $alt !== '' ? $alt : $attach['post_title'] );
		return (int) $attach_id;
	}
	return 0;
}

/**
 * Save valid Elementor metadata on a post/page.
 */
function ar_save_elementor_tree( int $post_id, array $tree ): void {
	$el_version = defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : '3.25.0';
	update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( $tree ) ) );
	update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
	update_post_meta( $post_id, '_elementor_template_type', 'wp-page' );
	update_post_meta( $post_id, '_elementor_version', $el_version );
	if ( ! get_post_meta( $post_id, '_elementor_page_settings', true ) ) {
		update_post_meta( $post_id, '_elementor_page_settings', [ 'template' => 'default' ] );
	}
	delete_post_meta( $post_id, '_elementor_css' );
	delete_post_meta( $post_id, '_elementor_Element_cache' );
}

/**
 * Generate semantic HTML fallback content from widget definitions so pages
 * render richly even if viewed via WP REST API, search excerpt, or without Elementor.
 */
function ar_render_widgets_fallback_html( array $widgets ): string {
	$html = '';
	foreach ( $widgets as $w ) {
		$type = $w['widgetType'] ?? '';
		$s    = $w['settings'] ?? [];
		if ( $type === 'text-editor' && ! empty( $s['editor'] ) ) {
			$html .= $s['editor'];
			continue;
		}
		if ( ! empty( $s['title'] ) ) {
			$tag   = ( $type === 'ar_hero' || $type === 'ar_territory_hero' ) ? 'h1' : 'h2';
			$html .= '<' . $tag . '>' . wp_kses_post( $s['title'] ) . '</' . $tag . '>';
		}
		if ( ! empty( $s['subtitle'] ) ) {
			$html .= '<p>' . wp_kses_post( $s['subtitle'] ) . '</p>';
		}
		if ( ! empty( $s['sub'] ) ) {
			$html .= '<p>' . wp_kses_post( $s['sub'] ) . '</p>';
		}
		if ( ! empty( $s['desc'] ) ) {
			$html .= '<p>' . wp_kses_post( $s['desc'] ) . '</p>';
		}
		if ( ! empty( $s['items'] ) && is_array( $s['items'] ) ) {
			$html .= '<ul>';
			foreach ( $s['items'] as $it ) {
				$t = $it['title'] ?? $it['q'] ?? $it['label'] ?? '';
				$d = $it['desc'] ?? $it['a'] ?? $it['body'] ?? $it['sub'] ?? '';
				if ( $t !== '' || $d !== '' ) {
					$html .= '<li><strong>' . esc_html( (string) $t ) . '</strong> ' . esc_html( (string) $d ) . '</li>';
				}
			}
			$html .= '</ul>';
		}
	}
	return $html;
}

/**
 * Step 1: Import bundled dry ice media assets.
 */
function ar_demo_step_media(): string {
	$assets = [
		'hero-manufacturing.jpg'      => 'ArcticRestoDRY ICE industrial dry ice pelletizer and manufacturing facility',
		'dry-ice-pellets.jpg'         => 'High-density extruded dry ice pellets in insulated commercial container',
		'dry-ice-blocks.jpg'          => 'Compressed solid dry ice blocks and cut cooling slabs',
		'dry-ice-nuggets.jpg'         => 'High-density cylindrical dry ice nuggets for cold-chain transit',
		'insulated-containers.jpg'    => 'Vented rotationally molded insulated dry ice storage totes',
		'bulk-supply-logistics.jpg'   => 'Bulk palletized dry ice supply staged at commercial loading dock',
		'dry-ice-safety-ppe.jpg'      => 'Technician handling dry ice with insulated cryogenic gloves and eye protection',
		'quality-control.jpg'         => 'Dry ice quality inspection and insulated container preparation',
		'industry-food-coldchain.jpg' => 'Dry ice temperature control for food processing and cold-chain logistics',
		'industry-pharma-lab.jpg'     => 'Dry ice packing for pharmaceutical and laboratory specimen transport',
		'industry-manufacturing.jpg'  => 'Industrial manufacturing and shrink-fitting dry ice application',
		'delivery-warehouse.jpg'      => 'Dry ice delivery route staging and insulated container dispatch',
	];
	$count = 0;
	foreach ( $assets as $file => $alt ) {
		if ( ar_import_bundled_image( $file, $alt ) ) {
			$count++;
		}
	}
	return sprintf( 'Imported/verified %d dry ice media assets in WordPress Media Library.', $count );
}

/**
 * Step 2: Import all 16 core Elementor pages.
 */
function ar_demo_step_pages(): string {
	// Remove obsolete legacy franchise pages if present from an older install
	$legacy_slugs = [ 'franchise', 'roi-calculator', 'case-studies', 'services', 'territories' ];
	foreach ( $legacy_slugs as $old_slug ) {
		$old_page = get_page_by_path( $old_slug );
		if ( $old_page ) {
			wp_delete_post( $old_page->ID, true );
		}
	}

	$pages = array_merge( ar_demo_pages_part1(), ar_demo_pages_part2() );
	$count = 0;

	foreach ( $pages as $slug => $cfg ) {
		$existing = get_page_by_path( $slug );
		$tree     = ar_el_page_tree( $cfg['widgets'] ?? [] );
		$fallback = ar_render_widgets_fallback_html( $cfg['widgets'] ?? [] );

		$post_arr = [
			'post_type'    => 'page',
			'post_name'    => $slug,
			'post_title'   => $cfg['title'],
			'post_excerpt' => $cfg['excerpt'] ?? '',
			'post_content' => $fallback,
			'post_status'  => 'publish',
			'menu_order'   => $count,
		];

		if ( $existing ) {
			$post_arr['ID'] = $existing->ID;
			$page_id        = wp_update_post( $post_arr );
		} else {
			$page_id = wp_insert_post( $post_arr );
		}

		if ( $page_id && ! is_wp_error( $page_id ) ) {
			ar_save_elementor_tree( (int) $page_id, $tree );
			update_post_meta( (int) $page_id, '_ar_meta_description', $cfg['excerpt'] ?? '' );
			$count++;
		}
	}

	return sprintf( 'Created/updated %d Elementor-built pages for ArcticRestoDRY ICE.', $count );
}

/**
 * Step 3: Import Dry Ice Products, Industries, Delivery Zones & 8 Blog Posts.
 */
function ar_demo_step_cpts(): string {
	// Clean up legacy cleaning services/posts if present
	$old_cpts = get_posts( [
		'post_type'      => [ 'ar_service', 'ar_case', 'ar_testimonial' ],
		'posts_per_page' => -1,
		'post_status'    => 'any',
		'fields'         => 'ids',
	] );
	foreach ( $old_cpts as $oid ) {
		wp_delete_post( (int) $oid, true );
	}

	// Remove default "Hello world!" post if present
	$hello = get_page_by_path( 'hello-world', OBJECT, 'post' );
	if ( $hello ) {
		wp_delete_post( $hello->ID, true );
	}

	// 1. Dry Ice Products (`ar_product`)
	$prod_count = 0;
	foreach ( ar_demo_products() as $idx => $prod ) {
		$existing = get_page_by_path( $prod['slug'], OBJECT, 'ar_product' );
		$arr      = [
			'post_type'    => 'ar_product',
			'post_name'    => $prod['slug'],
			'post_title'   => $prod['title'],
			'post_excerpt' => $prod['excerpt'],
			'post_content' => $prod['content'],
			'post_status'  => 'publish',
			'menu_order'   => $idx,
		];
		$pid = $existing ? wp_update_post( array_merge( $arr, [ 'ID' => $existing->ID ] ) ) : wp_insert_post( $arr );
		if ( $pid && ! is_wp_error( $pid ) ) {
			foreach ( $prod['meta'] as $mk => $mv ) {
				update_post_meta( (int) $pid, $mk, $mv );
			}
			$att_id = ar_import_bundled_image( $prod['image'], $prod['title'] );
			if ( $att_id ) {
				set_post_thumbnail( (int) $pid, $att_id );
			}
			$prod_count++;
		}
	}

	// 2. Industries Served (`ar_industry`)
	$ind_count = 0;
	foreach ( ar_demo_industries() as $idx => $ind ) {
		$existing = get_page_by_path( $ind['slug'], OBJECT, 'ar_industry' );
		$arr      = [
			'post_type'    => 'ar_industry',
			'post_name'    => $ind['slug'],
			'post_title'   => $ind['title'],
			'post_excerpt' => $ind['excerpt'],
			'post_content' => '<p>' . esc_html( $ind['excerpt'] ) . '</p>',
			'post_status'  => 'publish',
			'menu_order'   => $idx,
		];
		$iid = $existing ? wp_update_post( array_merge( $arr, [ 'ID' => $existing->ID ] ) ) : wp_insert_post( $arr );
		if ( $iid && ! is_wp_error( $iid ) ) {
			foreach ( $ind['meta'] as $mk => $mv ) {
				update_post_meta( (int) $iid, $mk, $mv );
			}
			$att_id = ar_import_bundled_image( $ind['image'], $ind['title'] );
			if ( $att_id ) {
				set_post_thumbnail( (int) $iid, $att_id );
			}
			$ind_count++;
		}
	}

	// 3. Editable Placeholder Delivery & Supply Zones (`ar_territory`)
	$old_zones = get_posts( [ 'post_type' => 'ar_territory', 'posts_per_page' => -1, 'post_status' => 'any', 'fields' => 'ids' ] );
	foreach ( $old_zones as $zid ) {
		wp_delete_post( (int) $zid, true );
	}
	$zone_count = 0;
	foreach ( ar_demo_delivery_zones() as $idx => $zone ) {
		$zid = wp_insert_post( [
			'post_type'    => 'ar_territory',
			'post_name'    => $zone['slug'],
			'post_title'   => $zone['title'],
			'post_excerpt' => $zone['excerpt'],
			'post_content' => '<p>' . esc_html( $zone['excerpt'] ) . '</p>',
			'post_status'  => 'publish',
			'menu_order'   => $idx,
		] );
		if ( $zid && ! is_wp_error( $zid ) ) {
			foreach ( $zone['meta'] as $mk => $mv ) {
				update_post_meta( (int) $zid, $mk, $mv );
			}
			$att_id = ar_import_bundled_image( $zone['image'], $zone['title'] );
			if ( $att_id ) {
				set_post_thumbnail( (int) $zid, $att_id );
			}
			$zone_count++;
		}
	}

	// 4. Blog Posts (`post`) — Remove legacy blasting posts & import 8 Dry Ice Supply articles
	$existing_posts = get_posts( [ 'post_type' => 'post', 'posts_per_page' => -1, 'post_status' => 'any' ] );
	$valid_slugs    = wp_list_pluck( ar_demo_blog_posts(), 'slug' );
	foreach ( $existing_posts as $ep ) {
		if ( ! in_array( $ep->post_name, $valid_slugs, true ) ) {
			wp_delete_post( $ep->ID, true );
		}
	}

	$post_count = 0;
	foreach ( ar_demo_blog_posts() as $idx => $art ) {
		$existing = get_page_by_path( $art['slug'], OBJECT, 'post' );
		$cat_term = wp_insert_term( $art['category'], 'category' );
		$cat_id   = is_wp_error( $cat_term ) ? (int) ( get_term_by( 'name', $art['category'], 'category' )->term_id ?? 1 ) : (int) $cat_term['term_id'];

		$arr = [
			'post_type'     => 'post',
			'post_name'     => $art['slug'],
			'post_title'    => $art['title'],
			'post_excerpt'  => $art['excerpt'],
			'post_content'  => $art['content'],
			'post_status'   => 'publish',
			'post_category' => [ $cat_id ],
		];
		$aid = $existing ? wp_update_post( array_merge( $arr, [ 'ID' => $existing->ID ] ) ) : wp_insert_post( $arr );
		if ( $aid && ! is_wp_error( $aid ) ) {
			$att_id = ar_import_bundled_image( $art['image'], $art['title'] );
			if ( $att_id ) {
				set_post_thumbnail( (int) $aid, $att_id );
			}
			$post_count++;
		}
	}

	return sprintf( 'Imported %d Dry Ice Products, %d Industries, %d Delivery Zones, and %d Blog Articles.', $prod_count, $ind_count, $zone_count, $post_count );
}

/**
 * Step 4: Configure Navigation Menus, Reading Settings & Elementor Kit.
 */
function ar_demo_step_menus_and_settings(): string {
	// Set Site Title & Tagline
	update_option( 'blogname', 'ArcticRestoDRY ICE' );
	update_option( 'blogdescription', 'Quality Dry Ice. Reliable Supply. Flexible Solutions.' );

	// Set Front Page to Home
	$home = get_page_by_path( 'home' );
	if ( $home ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home->ID );
		update_option( 'page_for_posts', 0 );
	}

	// Ensure Elementor Container experiment & CPT support are active
	update_option( 'elementor_experiment-container', 'active' );
	update_option( 'elementor_cpt_support', [ 'page', 'post', 'ar_product', 'ar_industry', 'ar_service' ] );
	update_option( 'elementor_disable_color_schemes', 'yes' );
	update_option( 'elementor_disable_typography_schemes', 'yes' );

	// Build Primary Navigation Menu
	$primary_name = 'ArcticRestoDRY ICE Primary Navigation';
	$existing_menu = wp_get_nav_menu_object( $primary_name );
	if ( $existing_menu ) {
		wp_delete_nav_menu( $existing_menu->term_id );
	}
	$menu_id = wp_create_nav_menu( $primary_name );

	if ( ! is_wp_error( $menu_id ) ) {
		$add_page_item = function ( string $slug, string $title, int $parent = 0 ) use ( $menu_id ): int {
			$p = get_page_by_path( $slug );
			if ( $p ) {
				return (int) wp_update_nav_menu_item( $menu_id, 0, [
					'menu-item-title'     => $title,
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $p->ID,
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
					'menu-item-parent-id' => $parent,
				] );
			}
			return (int) wp_update_nav_menu_item( $menu_id, 0, [
				'menu-item-title'     => $title,
				'menu-item-url'       => home_url( '/' . trim( $slug, '/' ) . '/' ),
				'menu-item-type'      => 'custom',
				'menu-item-status'    => 'publish',
				'menu-item-parent-id' => $parent,
			] );
		};

		$add_page_item( 'home', 'Home' );
		$add_page_item( 'about-us', 'About Us' );

		$prod_parent = $add_page_item( 'dry-ice-products', 'Dry Ice Products' );
		$add_page_item( 'dry-ice-products', 'All Dry Ice Products', $prod_parent );
		$add_page_item( 'dry-ice-pellets', 'Dry Ice Pellets', $prod_parent );
		$add_page_item( 'dry-ice-blocks-nuggets', 'Dry Ice Blocks & Nuggets', $prod_parent );
		$add_page_item( 'quality', 'Quality & Specifications', $prod_parent );

		$add_page_item( 'dry-ice-manufacturing', 'Manufacturing' );
		$add_page_item( 'bulk-orders', 'Bulk Orders' );

		$ind_parent = $add_page_item( 'industries', 'Industries & Uses' );
		$add_page_item( 'industries', 'Industries We Serve', $ind_parent );
		$add_page_item( 'dry-ice-applications', 'Dry Ice Applications', $ind_parent );
		$add_page_item( 'delivery-areas', 'Delivery & Supply Areas', $ind_parent );

		$safe_parent = $add_page_item( 'dry-ice-safety', 'Safety & Resources' );
		$add_page_item( 'dry-ice-safety', 'Dry Ice Safety, Handling & Storage', $safe_parent );
		$add_page_item( 'quality', 'Quality & Product Specifications', $safe_parent );
		$add_page_item( 'faq', 'Frequently Asked Questions', $safe_parent );
		$add_page_item( 'blog', 'Blog & Technical Guides', $safe_parent );

		$add_page_item( 'contact', 'Request a Quote' );

		$locations            = get_theme_mod( 'nav_menu_locations', [] );
		$locations['primary'] = (int) $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	if ( function_exists( 'ar_sync_elementor_kit' ) ) {
		ar_sync_elementor_kit();
	}
	if ( class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->files_manager ) ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
	}

	update_option( 'permalink_structure', '/%postname%/' );
	flush_rewrite_rules();
	update_option( 'ar_dryice_demo_seeded_v2', '1' );

	return 'Configured Primary Navigation, Front Page, Permalinks, and Elementor Global Kit.';
}

/**
 * Run all 4 demo import steps programmatically.
 */
function ar_run_full_demo_import(): array {
	return [
		'media'    => ar_demo_step_media(),
		'pages'    => ar_demo_step_pages(),
		'cpts'     => ar_demo_step_cpts(),
		'settings' => ar_demo_step_menus_and_settings(),
	];
}

/**
 * AJAX Handler for One-Click Admin Importer.
 */
add_action( 'wp_ajax_ar_demo_import_step', function () {
	check_ajax_referer( 'ar_demo_import', 'nonce' );
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( [ 'message' => 'Insufficient permissions.' ], 403 );
	}

	$step = sanitize_key( $_POST['step'] ?? 'all' );
	switch ( $step ) {
		case 'media':
			wp_send_json_success( [ 'log' => ar_demo_step_media() ] );
			break;
		case 'pages':
			wp_send_json_success( [ 'log' => ar_demo_step_pages() ] );
			break;
		case 'cpts':
			wp_send_json_success( [ 'log' => ar_demo_step_cpts() ] );
			break;
		case 'settings':
		case 'menus':
			wp_send_json_success( [ 'log' => ar_demo_step_menus_and_settings() ] );
			break;
		default:
			$res = ar_run_full_demo_import();
			wp_send_json_success( [ 'log' => implode( "\n", $res ) ] );
	}
} );
