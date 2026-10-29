<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function aitea_config_links( $group = '' ) {
    $links = array(
        'official' => array(
            array( 'label' => 'Embassy of India in Vienna', 'href' => '' ), // TODO: verify URL before launch.
            array( 'label' => 'Austrian Foreign Ministry (BMEIA)', 'href' => '' ), // TODO: verify URL before launch.
            array( 'label' => 'Austrian Embassy in New Delhi', 'href' => '' ), // TODO: verify URL before launch.
            array( 'label' => 'Austrian Economic Chamber (WKO)', 'href' => '' ), // TODO: verify URL before launch.
            array( 'label' => 'ADVANTAGE AUSTRIA', 'href' => '' ), // TODO: verify URL before launch.
            array( 'label' => 'City of Vienna', 'href' => '' ), // TODO: verify URL before launch.
        ),
        'social' => array(),
        'partners' => array(),
    );
    return isset( $links[ $group ] ) ? $links[ $group ] : array();
}
