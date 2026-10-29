<?php
get_header();
?>
<section class="content-section"><div class="content-section__inner page-content">
    <p class="eyebrow"><?php echo esc_html( aitea_t( 'nav.downloads' ) ); ?></p>
    <h1><?php echo esc_html( aitea_t( 'downloads.title' ) ); ?></h1>
    <?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
</div></section>
<?php get_footer(); ?>