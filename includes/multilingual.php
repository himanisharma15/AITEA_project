<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }


add_filter( 'pll_get_post_types', function ( $types, $is_settings ) {
	foreach ( array( 'aitea_news', 'aitea_event', 'aitea_download', 'aitea_sponsor' ) as $t ) { $types[ $t ] = $t; }
	return $types;
}, 10, 2 );

add_filter( 'pll_get_taxonomies', function ( $taxes, $is_settings ) {
	foreach ( array( 'aitea_objective', 'aitea_download_cat', 'aitea_sponsor_type' ) as $t ) { $taxes[ $t ] = $t; }
	return $taxes;
}, 10, 2 );

/* Strings the theme/templates need translated (Languages > Translations in admin). */
add_action( 'init', function () {
	if ( ! function_exists( 'pll_register_string' ) ) { return; }
	$strings = array(
		'Read more', 'All News', 'All Events', 'Upcoming events', 'Download', 'Members only',
		'Apply for membership', 'Contact', 'Imprint', 'Data Protection', 'Statutes',
		'Our sponsors and partners', 'Webpage created by Zeta AI Labs',
	);
	foreach ( $strings as $s ) { pll_register_string( sanitize_title( $s ), $s, 'AITEA' ); }
} );


function aitea__( $s ) { return function_exists( 'pll__' ) ? pll__( $s ) : $s; }


add_action( 'admin_notices', function () {
	if ( function_exists( 'pll_languages_list' ) || ! current_user_can( 'activate_plugins' ) ) { return; }
	echo '<div class="notice notice-warning"><p><strong>AITEA Core:</strong> install and activate <em>Polylang</em>, then add German (default) and English under Languages. Hindi can be added later the same way.</p></div>';
} );
