<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function aitea_register_post_types() {
	$defs = array(
		'aitea_news'     => array( 'News', 'News', 'news', 'dashicons-megaphone', array( 'title', 'editor', 'excerpt', 'thumbnail', 'author', 'revisions' ), true ),
		'aitea_event'    => array( 'Event', 'Events', 'events', 'dashicons-calendar-alt', array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ), true ),
		'aitea_download' => array( 'Download', 'Downloads', 'downloads', 'dashicons-media-document', array( 'title', 'editor', 'revisions' ), true ),
		'aitea_sponsor'  => array( 'Sponsor / Partner', 'Sponsors & Partners', 'sponsors', 'dashicons-heart', array( 'title', 'editor', 'thumbnail', 'page-attributes' ), false ),
	);

	foreach ( $defs as $slug => $d ) {
		list( $singular, $plural, $rewrite, $icon, $supports, $has_archive ) = $d;
		register_post_type( $slug, array(
			'labels' => array(
				'name'               => $plural,
				'singular_name'      => $singular,
				'add_new_item'       => "Add New $singular",
				'edit_item'          => "Edit $singular",
				'all_items'          => "All $plural",
				'search_items'       => "Search $plural",
				'not_found'          => "No $plural found",
			),
			'public'          => true,
			'show_in_rest'    => true,           // block editor + REST for headless/JS use
			'menu_icon'       => $icon,
			'supports'        => $supports,
			'has_archive'     => $has_archive,
			'rewrite'         => array( 'slug' => $rewrite, 'with_front' => false ),
			'capability_type' => 'post',         // Editors can manage these out of the box
			'menu_position'   => 20,
		) );
	}
}
add_action( 'init', 'aitea_register_post_types' );

function aitea_register_taxonomies() {
	
	register_taxonomy( 'aitea_objective', array( 'aitea_news', 'aitea_event' ), array(
		'labels'            => array( 'name' => 'Objectives', 'singular_name' => 'Objective' ),
		'hierarchical'      => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'objective' ),
	) );

	register_taxonomy( 'aitea_download_cat', array( 'aitea_download' ), array(
		'labels'            => array( 'name' => 'Download Categories', 'singular_name' => 'Download Category' ),
		'hierarchical'      => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'download-category' ),
	) );

	register_taxonomy( 'aitea_sponsor_type', array( 'aitea_sponsor' ), array(
		'labels'            => array( 'name' => 'Sponsor Types', 'singular_name' => 'Sponsor Type' ),
		'hierarchical'      => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'sponsor-type' ),
	) );
}
add_action( 'init', 'aitea_register_taxonomies' );


add_action( 'pre_get_posts', function ( $q ) {
	if ( is_admin() || ! $q->is_main_query() ) { return; }
	if ( $q->is_post_type_archive( 'aitea_event' ) ) {
		$q->set( 'meta_key', '_aitea_event_start' );
		$q->set( 'orderby', 'meta_value' );
		$q->set( 'order', 'ASC' );
		$q->set( 'meta_query', array( array(
			'key'     => '_aitea_event_start',
			'value'   => current_time( 'Y-m-d' ),
			'compare' => '>=',
			'type'    => 'DATE',
		) ) );
	}
	if ( $q->is_post_type_archive( 'aitea_sponsor' ) ) {
		$q->set( 'orderby', 'menu_order title' );
		$q->set( 'order', 'ASC' );
		$q->set( 'posts_per_page', -1 );
	}
} );
