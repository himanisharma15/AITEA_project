<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_shortcode( 'aitea_downloads', function ( $atts ) {
	$a = shortcode_atts( array( 'category' => '', 'limit' => 50 ), $atts );
	$args = array(
		'post_type'      => 'aitea_download',
		'posts_per_page' => (int) $a['limit'],
		'orderby'        => 'title',
		'order'          => 'ASC',
	);
	if ( $a['category'] ) {
		$args['tax_query'] = array( array( 'taxonomy' => 'aitea_download_cat', 'field' => 'slug', 'terms' => sanitize_title( $a['category'] ) ) );
	}
	$q = new WP_Query( $args );
	if ( ! $q->have_posts() ) { return ''; }

	$out = '<ul class="aitea-downloads">';
	while ( $q->have_posts() ) {
		$q->the_post();
		$members = (bool) get_post_meta( get_the_ID(), '_aitea_members_only', true );
		if ( $members && ! aitea_user_can_read_members_only() ) { continue; }
		$fid = (int) get_post_meta( get_the_ID(), '_aitea_file_id', true );
		if ( ! $fid ) { continue; }
		$size = size_format( (int) @filesize( get_attached_file( $fid ) ) );
		$ext  = strtoupper( pathinfo( get_attached_file( $fid ), PATHINFO_EXTENSION ) );
		$url  = $members ? add_query_arg( 'aitea_dl', get_the_ID(), home_url( '/' ) ) : wp_get_attachment_url( $fid );
		$out .= sprintf( '<li><a href="%s" download>%s</a> <small>(%s, %s)</small>%s</li>',
			esc_url( $url ), esc_html( get_the_title() ), esc_html( $ext ), esc_html( $size ),
			$members ? ' <span class="aitea-badge">' . esc_html( aitea__( 'Members only' ) ) . '</span>' : '' );
	}
	wp_reset_postdata();
	return $out . '</ul>';
} );


add_action( 'template_redirect', function () {
	if ( empty( $_GET['aitea_dl'] ) ) { return; }
	$pid = absint( $_GET['aitea_dl'] );
	if ( 'aitea_download' !== get_post_type( $pid ) || 'publish' !== get_post_status( $pid ) ) { wp_die( 'Not found', '', 404 ); }

	if ( get_post_meta( $pid, '_aitea_members_only', true ) && ! aitea_user_can_read_members_only() ) {
		wp_safe_redirect( wp_login_url( home_url( '/?aitea_dl=' . $pid ) ) );
		exit;
	}
	$path = get_attached_file( (int) get_post_meta( $pid, '_aitea_file_id', true ) );
	if ( ! $path || ! file_exists( $path ) ) { wp_die( 'File missing', '', 404 ); }

	$mime = wp_check_filetype( $path )['type'] ?: 'application/octet-stream';
	nocache_headers();
	header( 'Content-Type: ' . $mime );
	header( 'Content-Disposition: attachment; filename="' . basename( $path ) . '"' );
	header( 'Content-Length: ' . filesize( $path ) );
	header( 'X-Content-Type-Options: nosniff' );
	readfile( $path );
	exit;
} );


add_filter( 'upload_mimes', function ( $m ) {
	$m['pdf']  = 'application/pdf';
	$m['docx'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
	$m['xlsx'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
	return $m;
} );
