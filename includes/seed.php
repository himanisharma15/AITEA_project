<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function aitea_seed_messages( $language = 'de' ) {
	static $cache = array();
	if ( isset( $cache[ $language ] ) ) { return $cache[ $language ]; }
	$path = dirname( AITEA_CORE_DIR ) . '/content/' . sanitize_key( $language ) . '.json';
	$json = file_exists( $path ) ? file_get_contents( $path ) : false;
	$data = $json ? json_decode( $json, true ) : array();
	$cache[ $language ] = is_array( $data ) ? $data : array();
	return $cache[ $language ];
}

function aitea_seed_message( $language, $key, $fallback = '' ) {
	$value = aitea_seed_messages( $language );
	foreach ( explode( '.', $key ) as $segment ) {
		if ( ! is_array( $value ) || ! array_key_exists( $segment, $value ) ) { return $fallback; }
		$value = $value[ $segment ];
	}
	return is_scalar( $value ) ? (string) $value : $fallback;
}

/** Idempotent initial content: taxonomy terms and bilingual page skeleton. */
function aitea_seed_content() {
	$terms = array(
		'aitea_objective'     => array( 'Technology', 'Tourism', 'Education', 'Sports', 'Culture & Art', 'Gastronomy' ),
		'aitea_download_cat'  => array( 'Statutes', 'Membership Application', 'Other Documents' ),
		'aitea_sponsor_type'  => array( 'Sponsor', 'Partner', 'Embassy & Official' ),
	);
	foreach ( $terms as $tax => $list ) {
		foreach ( $list as $t ) {
			if ( ! term_exists( $t, $tax ) ) { wp_insert_term( $t, $tax ); }
		}
	}

	$pages = array(
		'home'       => array( 'home', 'nav.home' ),
		'about-us'   => array( 'about-us', 'nav.about' ),
		'objectives' => array( 'objectives', 'nav.objectives' ),
		'expertise'  => array( 'expertise', 'nav.expertise' ),
		'news'       => array( 'news', 'nav.news' ),
		'events'     => array( 'events', 'nav.events' ),
		'downloads'  => array( 'downloads-page', 'nav.downloads' ),
		'membership' => array( 'membership', 'nav.membership' ),
		'login'      => array( 'member-login', 'nav.login' ),
		'contact'    => array( 'contact', 'footer.contact' ),
		'statutes'   => array( 'statutes', 'downloads.statutes' ),
		'imprint'    => array( 'imprint', 'footer.imprint' ),
		'privacy'    => array( 'data-protection', 'footer.privacy' ),
	);
	$content = array(
		'contact'  => '[aitea_contact]',
		'statutes' => '[aitea_downloads category="statutes"]',
		'downloads' => '[aitea_downloads]',
	);
	$ids = array( 'de' => array(), 'en' => array() );
	foreach ( array( 'de', 'en' ) as $language ) {
		foreach ( $pages as $key => $page ) {
			$title = aitea_seed_message( $language, $page[1] );
			if ( ! $title ) { continue; }
			$existing = get_page_by_path( $page[0], OBJECT, 'page' );
			if ( 'en' === $language && $existing && function_exists( 'pll_get_post' ) ) {
				$existing_translation = pll_get_post( $existing->ID, 'en' );
				$existing = $existing_translation ? get_post( $existing_translation ) : false;
			}
			$post_id = $existing ? $existing->ID : wp_insert_post( array(
				'post_type' => 'page', 'post_status' => 'draft', 'post_title' => $title,
				'post_name' => $page[0], 'post_content' => $content[ $key ] ?? '',
			) );
			if ( is_wp_error( $post_id ) ) { continue; }
			$ids[ $language ][ $key ] = $post_id;
			if ( function_exists( 'pll_set_post_language' ) ) { pll_set_post_language( $post_id, $language ); }
		}
	}
	if ( function_exists( 'pll_save_post_translations' ) ) {
		foreach ( $pages as $key => $page ) {
			if ( ! empty( $ids['de'][ $key ] ) && ! empty( $ids['en'][ $key ] ) ) {
				pll_save_post_translations( array( 'de' => $ids['de'][ $key ], 'en' => $ids['en'][ $key ] ) );
			}
		}
	}

	if ( ! empty( $ids['de']['home'] ) && ! get_option( 'aitea_seeded' ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['de']['home'] );
		if ( ! empty( $ids['de']['privacy'] ) ) { update_option( 'wp_page_for_privacy_policy', $ids['de']['privacy'] ); }
		update_option( 'timezone_string', 'Europe/Vienna' );
		update_option( 'date_format', 'd.m.Y' );
		update_option( 'time_format', 'H:i' );
		update_option( 'start_of_week', 1 );
		update_option( 'permalink_structure', '/%postname%/' );
		update_option( 'aitea_seeded', 1 );
	}
}

/* Manual re-run: WP-CLI  ->  wp eval 'aitea_seed_content();' */
