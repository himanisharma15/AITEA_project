<?php
get_header();
get_template_part( 'template-parts/expertise-intro' );
get_template_part( 'template-parts/expertise-notice' );
get_template_part(
    'template-parts/expertise-people',
    null,
    array(
        'id'         => 'board',
        'eyebrow'    => 'Leadership & Responsibility',
        'heading'    => 'Board',
        'subheading' => 'A clear focus on governance, community and meaningful collaboration.',
        'people'     => aitea_board_members(),
    )
);
?>
<?php get_footer(); ?>