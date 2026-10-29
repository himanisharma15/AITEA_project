<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }


add_action( 'init', function () {
	$auth = function () { return current_user_can( 'edit_posts' ); };
	$str  = array( 'type' => 'string', 'single' => true, 'show_in_rest' => true, 'auth_callback' => $auth );

	register_post_meta( 'aitea_event', '_aitea_event_start',    $str + array( 'sanitize_callback' => 'sanitize_text_field' ) );
	register_post_meta( 'aitea_event', '_aitea_event_end',      $str + array( 'sanitize_callback' => 'sanitize_text_field' ) );
	register_post_meta( 'aitea_event', '_aitea_event_location', $str + array( 'sanitize_callback' => 'sanitize_text_field' ) );
	register_post_meta( 'aitea_event', '_aitea_event_link',     $str + array( 'sanitize_callback' => 'esc_url_raw' ) );

	register_post_meta( 'aitea_download', '_aitea_file_id',      array( 'type' => 'integer', 'single' => true, 'show_in_rest' => true, 'sanitize_callback' => 'absint', 'auth_callback' => $auth ) );
	register_post_meta( 'aitea_download', '_aitea_members_only', array( 'type' => 'boolean', 'single' => true, 'show_in_rest' => true, 'sanitize_callback' => 'rest_sanitize_boolean', 'auth_callback' => $auth ) );

	register_post_meta( 'aitea_sponsor', '_aitea_sponsor_url', $str + array( 'sanitize_callback' => 'esc_url_raw' ) );
} );

add_action( 'add_meta_boxes', function () {
	add_meta_box( 'aitea_event_details',    'Event details',    'aitea_mb_event',    'aitea_event',    'side', 'high' );
	add_meta_box( 'aitea_download_details', 'Download file',    'aitea_mb_download', 'aitea_download', 'normal', 'high' );
	add_meta_box( 'aitea_sponsor_details',  'Sponsor details',  'aitea_mb_sponsor',  'aitea_sponsor',  'side', 'default' );
} );

function aitea_mb_event( $post ) {
	wp_nonce_field( 'aitea_save_meta', 'aitea_meta_nonce' );
	$f = function ( $k ) use ( $post ) { return esc_attr( get_post_meta( $post->ID, $k, true ) ); };
	echo '<p><label>Start date<br><input type="date" name="aitea_event_start" value="' . $f( '_aitea_event_start' ) . '" class="widefat"></label></p>';
	echo '<p><label>End date<br><input type="date" name="aitea_event_end" value="' . $f( '_aitea_event_end' ) . '" class="widefat"></label></p>';
	echo '<p><label>Location<br><input type="text" name="aitea_event_location" value="' . $f( '_aitea_event_location' ) . '" class="widefat"></label></p>';
	echo '<p><label>Registration / info link<br><input type="url" name="aitea_event_link" value="' . $f( '_aitea_event_link' ) . '" class="widefat"></label></p>';
}

function aitea_mb_download( $post ) {
	wp_nonce_field( 'aitea_save_meta', 'aitea_meta_nonce' );
	wp_enqueue_media();
	$id   = (int) get_post_meta( $post->ID, '_aitea_file_id', true );
	$name = $id ? basename( get_attached_file( $id ) ) : 'No file selected';
	echo '<p><input type="hidden" id="aitea_file_id" name="aitea_file_id" value="' . esc_attr( $id ) . '">';
	echo '<span id="aitea_file_name">' . esc_html( $name ) . '</span> ';
	echo '<button type="button" class="button" id="aitea_pick_file">Choose / upload file</button></p>';
	echo '<p><label><input type="checkbox" name="aitea_members_only" value="1" ' . checked( (bool) get_post_meta( $post->ID, '_aitea_members_only', true ), true, false ) . '> Members only</label></p>';
	echo '<p class="description">Tip: set the post language (top right, Polylang). The Statutes are official in German only: publish that download in German only.</p>';
	?>
	<script>
	jQuery(function($){
		var frame;
		$('#aitea_pick_file').on('click', function(e){
			e.preventDefault();
			if(!frame){ frame = wp.media({ title:'Select file', multiple:false }); 
				frame.on('select', function(){
					var a = frame.state().get('selection').first().toJSON();
					$('#aitea_file_id').val(a.id); $('#aitea_file_name').text(a.filename);
				});
			}
			frame.open();
		});
	});
	</script>
	<?php
}

function aitea_mb_sponsor( $post ) {
	wp_nonce_field( 'aitea_save_meta', 'aitea_meta_nonce' );
	echo '<p><label>Website URL<br><input type="url" name="aitea_sponsor_url" value="' . esc_attr( get_post_meta( $post->ID, '_aitea_sponsor_url', true ) ) . '" class="widefat"></label></p>';
	echo '<p class="description">Set the logo as the Featured Image. Use "Order" in Page Attributes to arrange logos.</p>';
}

add_action( 'save_post', function ( $post_id ) {
	if ( ! isset( $_POST['aitea_meta_nonce'] ) || ! wp_verify_nonce( $_POST['aitea_meta_nonce'], 'aitea_save_meta' ) ) { return; }
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
	if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }

	$type = get_post_type( $post_id );
	if ( 'aitea_event' === $type ) {
		foreach ( array( 'start', 'end', 'location' ) as $k ) {
			if ( isset( $_POST[ "aitea_event_$k" ] ) ) {
				update_post_meta( $post_id, "_aitea_event_$k", sanitize_text_field( wp_unslash( $_POST[ "aitea_event_$k" ] ) ) );
			}
		}
		if ( isset( $_POST['aitea_event_link'] ) ) {
			update_post_meta( $post_id, '_aitea_event_link', esc_url_raw( wp_unslash( $_POST['aitea_event_link'] ) ) );
		}
	} elseif ( 'aitea_download' === $type ) {
		update_post_meta( $post_id, '_aitea_file_id', isset( $_POST['aitea_file_id'] ) ? absint( $_POST['aitea_file_id'] ) : 0 );
		update_post_meta( $post_id, '_aitea_members_only', ! empty( $_POST['aitea_members_only'] ) ? 1 : 0 );
	} elseif ( 'aitea_sponsor' === $type && isset( $_POST['aitea_sponsor_url'] ) ) {
		update_post_meta( $post_id, '_aitea_sponsor_url', esc_url_raw( wp_unslash( $_POST['aitea_sponsor_url'] ) ) );
	}
} );
