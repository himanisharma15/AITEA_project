<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'admin_init', function () {
	register_setting( 'general', 'aitea_ga4_measurement_id', array(
		'type'              => 'string',
		'sanitize_callback' => function ( $value ) {
			$value = strtoupper( sanitize_text_field( $value ) );
			return preg_match( '/^G-[A-Z0-9]+$/', $value ) ? $value : '';
		},
		'default'           => '',
	) );
	add_settings_field( 'aitea_ga4_measurement_id', 'AITEA Google Analytics 4 Measurement ID', function () {
		printf( '<input class="regular-text" type="text" name="aitea_ga4_measurement_id" value="%s" placeholder="G-XXXXXXXXXX" />', esc_attr( get_option( 'aitea_ga4_measurement_id', '' ) ) );
		echo '<p class="description">Analytics loads only after visitor consent. Leave empty until the final ID is available.</p>';
	}, 'general' );
} );

function aitea_ga4_measurement_id() {
	return (string) get_option( 'aitea_ga4_measurement_id', '' );
}

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_script( 'aitea-consent', AITEA_CORE_URL . 'assets/consent-plugin.js', array(), AITEA_CORE_VERSION, true );
	wp_localize_script( 'aitea-consent', 'aiteaConsent', array(
		'measurementId' => aitea_ga4_measurement_id(),
		'cookieName'    => 'aitea_analytics_consent',
	) );
} );

add_action( 'wp_footer', function () {
	if ( ! function_exists( 'aitea_t' ) ) { return; }
	?>
	<section class="aitea-cookie-banner" data-cookie-banner hidden aria-labelledby="aitea-cookie-title">
		<div><h2 id="aitea-cookie-title"><?php echo esc_html( aitea_t( 'cookie.settings', 'Cookie settings' ) ); ?></h2><p><?php echo esc_html( aitea_t( 'cookie.text', '' ) ); ?></p></div>
		<div class="aitea-cookie-banner__actions"><button type="button" data-cookie-choice="reject"><?php echo esc_html( aitea_t( 'cookie.reject', 'Reject' ) ); ?></button><button type="button" data-cookie-choice="accept"><?php echo esc_html( aitea_t( 'cookie.accept', 'Accept' ) ); ?></button></div>
	</section>
	<?php
} );