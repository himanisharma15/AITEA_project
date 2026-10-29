<?php
get_header();
?>
<section class="content-section"><div class="content-section__inner page-content">
    <p class="eyebrow"><?php echo esc_html( aitea_t( 'footer.contact' ) ); ?></p>
    <h1><?php echo esc_html( aitea_t( 'footer.contact' ) ); ?></h1>
    <?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
</div></section>
<?php get_footer(); ?>