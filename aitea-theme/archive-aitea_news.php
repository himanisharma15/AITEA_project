<?php
get_header();
?>
<section class="content-section"><div class="content-section__inner">
    <p class="eyebrow"><?php echo esc_html( aitea_t( 'nav.news' ) ); ?></p>
    <h1><?php echo esc_html( aitea_t( 'news.title' ) ); ?></h1>
    <div class="card-grid">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article <?php post_class( 'content-card content-card--grid' ); ?>><h2><?php the_title(); ?></h2><p><?php echo esc_html( get_the_excerpt() ); ?></p><a href="<?php the_permalink(); ?>"><?php echo esc_html( aitea_t( 'home.readMore' ) ); ?></a></article>
        <?php endwhile; else : ?><p><?php echo esc_html( aitea_t( 'news.empty' ) ); ?></p><?php endif; ?>
    </div>
</div></section>
<?php get_footer(); ?>