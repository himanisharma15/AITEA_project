<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function aitea_board_members() {
    $members = array(
        array(
            'name'        => aitea__( 'Alex Morgan' ),
            'initials'     => 'AM',
            'focus'        => aitea__( 'Governance & strategy' ),
            'description' => aitea__( 'Sample profile illustrating experience in nonprofit governance and cross-border community building.' ),
            'tags'        => array( aitea__( 'Governance' ), aitea__( 'Exchange' ) ),
            'image'       => '',
            'sample'      => true,
        ),
        array(
            'name'        => aitea__( 'Priya Shah' ),
            'initials'     => 'PS',
            'focus'       => aitea__( 'Culture & community' ),
            'description' => aitea__( 'Sample profile illustrating a focus on creative participation, inclusive programming and cultural dialogue.' ),
            'tags'        => array( aitea__( 'Culture' ), aitea__( 'Participation' ) ),
            'image'       => '',
            'sample'      => true,
        ),
        array(
            'name'        => aitea__( 'Daniel Weber' ),
            'initials'     => 'DW',
            'focus'       => aitea__( 'Partnerships & programmes' ),
            'description' => aitea__( 'Sample profile illustrating experience in connecting institutions and shaping collaborative programmes.' ),
            'tags'        => array( aitea__( 'Partnerships' ), aitea__( 'Programmes' ) ),
            'image'       => '',
            'sample'      => true,
        ),
    );

    return apply_filters( 'aitea_board_members', $members );
}

function aitea_advisors() {
    $advisors = array(
        array(
            'name'        => aitea__( 'Maya Rao' ),
            'initials'     => 'MR',
            'focus'       => aitea__( 'Education & research' ),
            'description' => aitea__( 'Sample advisor profile with a focus on academic exchange and opportunities for shared learning.' ),
            'tags'        => array( aitea__( 'Research' ), aitea__( 'Education' ) ),
            'image'       => '',
            'sample'      => true,
        ),
        array(
            'name'        => aitea__( 'Thomas Keller' ),
            'initials'     => 'TK',
            'focus'       => aitea__( 'Technology & innovation' ),
            'description' => aitea__( 'Sample advisor profile with a focus on entrepreneurship, emerging technology and knowledge transfer.' ),
            'tags'        => array( aitea__( 'Innovation' ), aitea__( 'Enterprise' ) ),
            'image'       => '',
            'sample'      => true,
        ),
        array(
            'name'        => aitea__( 'Anika Mehta' ),
            'initials'     => 'AM',
            'focus'       => aitea__( 'Sports & wellbeing' ),
            'description' => aitea__( 'Sample advisor profile with a focus on participation in community sport and intercultural wellbeing.' ),
            'tags'        => array( aitea__( 'Sports' ), aitea__( 'Community' ) ),
            'image'       => '',
            'sample'      => true,
        ),
    );

    return apply_filters( 'aitea_advisors', $advisors );
}
