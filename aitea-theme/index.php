<?php
get_header();
if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();
        ?>
        <article <?php post_class( 'content-card' ); ?>>
            <h1><?php the_title(); ?></h1>
            <div class="entry-content"><?php the_content(); ?></div>
        </article>
        <?php
    endwhile;
else :
    ?>
    <p><?php echo esc_html( aitea_t( 'notFound.text', 'Page not found.' ) ); ?></p>
    <?php
endif;
get_footer();
