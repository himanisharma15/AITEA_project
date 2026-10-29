<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function aitea_objectives() {
    $items = array(
        'technology' => array(
            'slug'        => 'technology',
            'number'      => '01',
            'icon'        => 'chip',
            'title'       => aitea__( 'Technology & Innovation' ),
            'short'       => aitea__( 'Technology, entrepreneurship and sustainable innovation.' ),
            'description' => aitea__( 'Create space for knowledge sharing in digital technology, entrepreneurship and sustainable innovation.' ),
            'tags'        => array( aitea__( 'Innovation dialogues' ), aitea__( 'Industry connections' ), aitea__( 'Knowledge exchange' ) ),
        ),
        'tourism' => array(
            'slug'        => 'tourism',
            'number'      => '02',
            'icon'        => 'compass',
            'title'       => aitea__( 'Tourism & Travel' ),
            'short'       => aitea__( 'Responsible travel and cultural discovery.' ),
            'description' => aitea__( 'Encourage a deeper understanding of both countries through responsible travel and cultural discovery.' ),
            'tags'        => array( aitea__( 'Destination exchange' ), aitea__( 'Responsible tourism' ), aitea__( 'Cultural discovery' ) ),
        ),
        'education' => array(
            'slug'        => 'education',
            'number'      => '03',
            'icon'        => 'graduation-cap',
            'title'       => aitea__( 'Education & Research' ),
            'short'       => aitea__( 'Learning, research and exchange.' ),
            'description' => aitea__( 'Support conversations between students, educators and researchers, with learning at the heart of exchange.' ),
            'tags'        => array( aitea__( 'Academic connections' ), aitea__( 'Research dialogue' ), aitea__( 'Lifelong learning' ) ),
        ),
        'sports' => array(
            'slug'        => 'sports',
            'number'      => '04',
            'icon'        => 'trophy',
            'title'       => aitea__( 'Sports' ),
            'short'       => aitea__( 'Participation, talent and a shared language.' ),
            'description' => aitea__( 'Use the shared language of sport to bring people together, encourage participation and nurture talent.' ),
            'tags'        => array( aitea__( 'Cricket' ), aitea__( 'Yoga' ), aitea__( 'Badminton' ), aitea__( 'Football' ) ),
        ),
        'culture-art' => array(
            'slug'        => 'culture-art',
            'number'      => '05',
            'icon'        => 'music-notes',
            'title'       => aitea__( 'Culture & Art/Music/Literature' ),
            'short'       => aitea__( 'Artistic expression and shared experiences.' ),
            'description' => aitea__( 'Make room for artistic expression and shared experiences in visual art, music, literature and performance.' ),
            'tags'        => array( aitea__( 'Artistic dialogue' ), aitea__( 'Music encounters' ), aitea__( 'Literary exchange' ) ),
        ),
        'gastronomy' => array(
            'slug'        => 'gastronomy',
            'number'      => '06',
            'icon'        => 'utensils',
            'title'       => aitea__( 'Gastronomy/Food & Beverages' ),
            'short'       => aitea__( 'Food cultures, traditions and hospitality.' ),
            'description' => aitea__( 'Explore the food cultures of Austria and India, and the people and traditions that shape them.' ),
            'tags'        => array( aitea__( 'Culinary encounters' ), aitea__( 'Food traditions' ), aitea__( 'Hospitality exchange' ) ),
        ),
    );

    return apply_filters( 'aitea_objectives', $items );
}
