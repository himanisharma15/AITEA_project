<?php
/**
 * Plugin Name: AITEA Core
 * Description: Backend/CMS layer for the AITEA website: content types (News, Events, Downloads, Sponsors), roles, multilingual (Polylang) support, contact form, initial content.
 * Version: 1.0.0
 * Author: Zeta AI Labs Pvt. Ltd
 * Text Domain: aitea-core
 * Requires PHP: 7.4
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'AITEA_CORE_VERSION', '1.0.0' );
define( 'AITEA_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'AITEA_CORE_URL', plugin_dir_url( __FILE__ ) );

foreach ( array( 'post-types', 'meta-boxes', 'roles', 'multilingual', 'downloads', 'contact-form', 'seed', 'tracking', 'seo' ) as $f ) {
	require_once AITEA_CORE_DIR . "includes/{$f}.php";
}

register_activation_hook( __FILE__, function () {
	aitea_register_post_types();
	aitea_register_taxonomies();
	aitea_add_roles();
	aitea_seed_content();
	flush_rewrite_rules();
} );

register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
