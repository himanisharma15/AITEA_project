<?php
get_header();
?>
<section class="content-section"><div class="content-section__inner page-content">
    <p class="eyebrow"><?php echo esc_html( aitea_t( 'nav.membership' ) ); ?></p>
    <h1><?php echo esc_html( aitea_t( 'membership.title' ) ); ?></h1>
    <p><?php echo esc_html( aitea_t( 'membership.intro' ) ); ?></p>
    <h2><?php echo esc_html( aitea_t( 'membership.whoTitle' ) ); ?></h2><p><?php echo esc_html( aitea_t( 'membership.who' ) ); ?></p>
    <h2><?php echo esc_html( aitea_t( 'membership.benefitsTitle' ) ); ?></h2><ul><?php foreach ( aitea_data( 'membership.benefits' ) as $benefit ) : ?><li><?php echo esc_html( $benefit ); ?></li><?php endforeach; ?></ul>
    <h2><?php echo esc_html( aitea_t( 'membership.howTitle' ) ); ?></h2><ol><?php foreach ( aitea_data( 'membership.steps' ) as $step ) : ?><li><?php echo esc_html( $step ); ?></li><?php endforeach; ?></ol>
    <p><?php echo esc_html( aitea_t( 'membership.decision' ) ); ?></p><p><?php echo esc_html( aitea_t( 'membership.feesNote' ) ); ?></p>
</div></section>
<?php get_footer(); ?>