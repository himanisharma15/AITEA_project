<?php
get_header();
while ( have_posts() ) : the_post();
    ?>
    <article <?php post_class( 'content-card page-content' ); ?>><h1><?php the_title(); ?></h1><div class="entry-content"><?php the_content(); ?></div><a href="<?php echo esc_url( get_post_type_archive_link( 'aitea_event' ) ); ?>"><?php echo esc_html( aitea_t( 'home.allEvents' ) ); ?></a></article>
    <?php
endwhile;
get_footer();