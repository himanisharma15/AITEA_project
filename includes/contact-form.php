<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }


add_shortcode( 'aitea_contact', function () {
	$status = isset( $_GET['aitea_status'] ) ? sanitize_key( $_GET['aitea_status'] ) : '';
	$msgs = array(
		'ok'      => array( 'success', 'Thank you! Your message has been sent.' ),
		'invalid' => array( 'error', 'Please fill in all fields correctly and accept the privacy notice.' ),
		'spam'    => array( 'error', 'Your message could not be sent. Please try again in a minute.' ),
		'fail'    => array( 'error', 'Sending failed. Please try again later.' ),
	);
	$out = '';
	if ( isset( $msgs[ $status ] ) ) {
		$out .= '<div class="aitea-notice aitea-' . esc_attr( $msgs[ $status ][0] ) . '" role="alert">' . esc_html( $msgs[ $status ][1] ) . '</div>';
	}
	ob_start(); ?>
	<form id="aitea-contact" class="aitea-contact" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="aitea_contact">
		<?php wp_nonce_field( 'aitea_contact', 'aitea_nonce' ); ?>
		<input type="hidden" name="aitea_ts" value="<?php echo esc_attr( time() ); ?>">
		<input type="hidden" name="aitea_back" value="<?php echo esc_url( get_permalink() ); ?>">
		<p style="position:absolute;left:-9999px" aria-hidden="true"><label>Leave empty <input type="text" name="aitea_website" tabindex="-1" autocomplete="off"></label></p>
		<p><label>Name *<br><input type="text" name="aitea_name" required maxlength="100"></label></p>
		<p><label>Email *<br><input type="email" name="aitea_email" required maxlength="150"></label></p>
		<p><label>Subject *<br><input type="text" name="aitea_subject" required maxlength="150"></label></p>
		<p><label>Message *<br><textarea name="aitea_message" rows="6" required maxlength="5000"></textarea></label></p>
		<p><label><input type="checkbox" name="aitea_consent" value="1" required>
			I agree that my data is processed to answer my request (see <a href="<?php echo esc_url( get_privacy_policy_url() ); ?>">Data Protection</a>). *</label></p>
		<p><button type="submit">Send</button></p>
	</form>
	<?php
	return $out . ob_get_clean();
} );

function aitea_contact_redirect( $back, $status ) {
	wp_safe_redirect( add_query_arg( 'aitea_status', $status, $back ?: home_url( '/' ) ) . '#aitea-contact' );
	exit;
}

function aitea_handle_contact() {
	$back = isset( $_POST['aitea_back'] ) ? esc_url_raw( wp_unslash( $_POST['aitea_back'] ) ) : home_url( '/' );

	if ( ! isset( $_POST['aitea_nonce'] ) || ! wp_verify_nonce( $_POST['aitea_nonce'], 'aitea_contact' ) ) { aitea_contact_redirect( $back, 'spam' ); }
	if ( ! empty( $_POST['aitea_website'] ) ) { aitea_contact_redirect( $back, 'spam' ); }                       // honeypot
	if ( time() - (int) ( $_POST['aitea_ts'] ?? 0 ) < 3 ) { aitea_contact_redirect( $back, 'spam' ); }           // too fast = bot

	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '';
	$key = 'aitea_rl_' . md5( $ip );                                                                            // max 3 per 10 min
	$n   = (int) get_transient( $key );
	if ( $n >= 3 ) { aitea_contact_redirect( $back, 'spam' ); }

	$name    = sanitize_text_field( wp_unslash( $_POST['aitea_name'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['aitea_email'] ?? '' ) );
	$subject = sanitize_text_field( wp_unslash( $_POST['aitea_subject'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['aitea_message'] ?? '' ) );
	if ( ! $name || ! is_email( $email ) || ! $subject || strlen( $message ) < 5 || empty( $_POST['aitea_consent'] ) ) {
		aitea_contact_redirect( $back, 'invalid' );
	}

	set_transient( $key, $n + 1, 10 * MINUTE_IN_SECONDS );

	$to      = defined( 'AITEA_CONTACT_TO' ) ? AITEA_CONTACT_TO : get_option( 'admin_email' );
	$headers = array( 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>' );
	$body    = "Name: $name\nEmail: $email\nConsent given: yes (" . current_time( 'Y-m-d H:i' ) . ")\n\n$message";
	$sent    = wp_mail( $to, '[AITEA website] ' . $subject, $body, $headers );

	aitea_contact_redirect( $back, $sent ? 'ok' : 'fail' );
}
add_action( 'admin_post_nopriv_aitea_contact', 'aitea_handle_contact' );
add_action( 'admin_post_aitea_contact', 'aitea_handle_contact' );
