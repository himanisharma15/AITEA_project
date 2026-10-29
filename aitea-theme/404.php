<?php
get_header();
?>
<section class="not-found content-card">
    <h1><?php echo esc_html( aitea_t( 'notFound.title', 'Page not found' ) ); ?></h1>
    <p><?php echo esc_html( aitea_t( 'notFound.text', '' ) ); ?></p>
    <a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( aitea_t( 'notFound.home', 'Home' ) ); ?></a>
</section>
<?php
get_footer();
