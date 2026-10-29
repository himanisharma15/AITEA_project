<?php
get_header();
?>
<section class="content-section"><div class="content-section__inner">
    <p class="eyebrow"><?php echo esc_html( aitea_t( 'nav.events' ) ); ?></p>
    <h1><?php echo esc_html( aitea_t( 'events.title' ) ); ?></h1>
    <?php if ( have_posts() ) : ?><div class="card-grid"><?php while ( have_posts() ) : the_post(); ?><article <?php post_class( 'content-card content-card--grid' ); ?>><h2><?php the_title(); ?></h2><p><?php echo esc_html( get_the_excerpt() ); ?></p><a href="<?php the_permalink(); ?>"><?php echo esc_html( aitea_t( 'events.register' ) ); ?></a></article><?php endwhile; ?></div><?php else : ?><p><?php echo esc_html( aitea_t( 'events.empty' ) ); ?></p><?php endif; ?>
</div></section>
<?php get_footer(); ?>