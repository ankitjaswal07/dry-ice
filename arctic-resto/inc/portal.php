<?php
/**
 * ArcticRestoDRY ICE — Commercial Account & Recurring Supply Role Support.
 *
 * Registers the `ar_commercial_buyer` role (and preserves `ar_franchise_owner`
 * for backward compatibility) so B2B recurring supply customers or dispatch
 * coordinators can be managed cleanly in WordPress Admin.
 *
 * @package ArcticResto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {
	if ( ! get_role( 'ar_commercial_buyer' ) ) {
		add_role( 'ar_commercial_buyer', __( 'Commercial Dry Ice Buyer', 'arctic-resto' ), [
			'read' => true,
		] );
	}
} );
