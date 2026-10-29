<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function aitea_seo_value( $key, $fallback = '' ) {
	return function_exists( 'aitea_t' ) ? aitea_t( $key, $fallback ) : $fallback;
}

add_filter( 'pre_get_document_title', function ( $title ) {
	if ( is_front_page() ) { return aitea_seo_value( 'seo.home.title', $title ); }
	return $title;
} );

add_action( 'wp_head', function () {
	$description = aitea_seo_value( 'seo.home.description', get_bloginfo( 'description' ) );
	$canonical = function_exists( 'wp_get_canonical_url' ) ? wp_get_canonical_url() : get_permalink();
	if ( ! $canonical ) { $canonical = home_url( '/' ); }
	echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
	echo '<link rel="canonical" href="' . esc_url( $canonical ) . '">' . "\n";
	if ( function_exists( 'pll_the_languages' ) ) {
		foreach ( (array) pll_the_languages( array( 'raw' => true, 'hide_if_no_translation' => false ) ) as $language ) {
			if ( empty( $language['url'] ) || empty( $language['locale'] ) ) { continue; }
			echo '<link rel="alternate" hreflang="' . esc_attr( $language['slug'] ) . '" href="' . esc_url( $language['url'] ) . '">' . "\n";
		}
	}
	if ( is_front_page() ) {
		$data = array( '@context' => 'https://schema.org', '@type' => 'Organization', 'name' => aitea_seo_value( 'brand.name', 'AITEA' ), 'url' => home_url( '/' ) );
		echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
	}
	if ( is_singular( 'aitea_news' ) ) {
		$data = array( '@context' => 'https://schema.org', '@type' => 'Article', 'headline' => get_the_title(), 'datePublished' => get_the_date( DATE_W3C ), 'url' => get_permalink() );
		echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
	}
	if ( is_singular( 'aitea_event' ) ) {
		$data = array( '@context' => 'https://schema.org', '@type' => 'Event', 'name' => get_the_title(), 'url' => get_permalink() );
		$start = get_post_meta( get_the_ID(), '_aitea_event_start', true );
		if ( $start ) { $data['startDate'] = $start; }
		$location = get_post_meta( get_the_ID(), '_aitea_event_location', true );
		if ( $location ) { $data['location'] = array( '@type' => 'Place', 'name' => $location ); }
		echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
	}
} );

add_filter( 'wp_sitemaps_post_types', function ( $post_types ) { unset( $post_types['aitea_download'] ); return $post_types; } );