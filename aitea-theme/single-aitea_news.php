<?php
get_header();
while ( have_posts() ) : the_post();
    ?>
    <article <?php post_class( 'content-card page-content' ); ?>><h1><?php the_title(); ?></h1><p class="entry-meta"><?php echo esc_html( get_the_date() ); ?></p><div class="entry-content"><?php the_content(); ?></div><a href="<?php echo esc_url( get_post_type_archive_link( 'aitea_news' ) ); ?>"><?php echo esc_html( aitea_t( 'news.back' ) ); ?></a></article>
    <?php
endwhile;
get_footer();