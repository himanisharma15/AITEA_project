<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Roles
 *  - Administrator  : full access (built in)
 *  - Editor         : built in; manages all AITEA content (CPTs use 'post' caps), media, pages. No plugins/users/settings.
 *  - aitea_applicant: pending membership applicants (no access) - used by the Membership Portal (Member 3)
 *  - aitea_member   : approved members; may read members-only content - used by Member 3
 */
function aitea_add_roles() {
	add_role( 'aitea_applicant', 'AITEA Applicant', array( 'read' => false ) );
	add_role( 'aitea_member',    'AITEA Member',    array( 'read' => true, 'aitea_read_members_only' => true ) );

	// Admins and editors can always see members-only content.
	foreach ( array( 'administrator', 'editor' ) as $r ) {
		$role = get_role( $r );
		if ( $role ) { $role->add_cap( 'aitea_read_members_only' ); }
	}
}

/* Keep the Editor's menu clean. */
add_action( 'admin_menu', function () {
	if ( current_user_can( 'manage_options' ) ) { return; }
	remove_menu_page( 'tools.php' );
	remove_menu_page( 'edit-comments.php' );
}, 999 );

/* Keep non-admins out of the Dashboard clutter. */
add_action( 'wp_dashboard_setup', function () {
	if ( current_user_can( 'manage_options' ) ) { return; }
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
} );

/* Block wp-admin for members/applicants. */
add_action( 'admin_init', function () {
	if ( wp_doing_ajax() || ( defined( 'DOING_CRON' ) && DOING_CRON ) ) { return; }
	if ( isset( $GLOBALS['pagenow'] ) && 'admin-post.php' === $GLOBALS['pagenow'] ) { return; } // contact form posts here
	$u = wp_get_current_user();
	if ( array_intersect( array( 'aitea_member', 'aitea_applicant' ), (array) $u->roles ) ) {
		wp_safe_redirect( home_url( '/' ) );
		exit;
	}
} );
add_filter( 'show_admin_bar', function ( $show ) {
	$u = wp_get_current_user();
	return array_intersect( array( 'aitea_member', 'aitea_applicant' ), (array) $u->roles ) ? false : $show;
} );

/* Helper for M3 and templates. */
function aitea_user_can_read_members_only() {
	return is_user_logged_in() && current_user_can( 'aitea_read_members_only' );
}
