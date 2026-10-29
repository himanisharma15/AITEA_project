<?php
get_header();
$objectives = aitea_objectives();
?>
<section class="hero-section">
    <div class="hero-section__inner">
        <p class="eyebrow"><?php echo esc_html( aitea_t( 'brand.tagline' ) ); ?></p>
        <h1><?php echo esc_html( aitea_t( 'brand.short', 'AITEA' ) ); ?></h1>
        <p class="hero-section__subline"><?php echo esc_html( aitea_t( 'hero.subline' ) ); ?></p>
        <div class="button-row">
            <a class="button button--accent" href="<?php echo esc_url( aitea_page_url( 'membership' ) ); ?>"><?php echo esc_html( aitea_t( 'hero.cta1' ) ); ?></a>
            <a class="button button--light" href="<?php echo esc_url( aitea_page_url( 'about-us' ) ); ?>"><?php echo esc_html( aitea_t( 'hero.cta2' ) ); ?></a>
        </div>
    </div>
</section>
<section class="content-section">
    <div class="content-section__inner intro-grid">
        <p class="eyebrow"><?php echo esc_html( aitea_t( 'brand.short', 'AITEA' ) ); ?></p>
        <div><h2><?php echo esc_html( aitea_t( 'home.objectivesTitle' ) ); ?></h2><p><?php echo esc_html( aitea_t( 'home.p1' ) ); ?></p><p><?php echo esc_html( aitea_t( 'home.p2' ) ); ?></p></div>
    </div>
</section>
<section class="content-section content-section--muted">
    <div class="content-section__inner">
        <p class="eyebrow"><?php echo esc_html( aitea_t( 'home.objectivesTitle' ) ); ?></p>
        <h2><?php echo esc_html( aitea_t( 'objectives.title' ) ); ?></h2>
        <div class="card-grid">
            <?php foreach ( $objectives as $objective ) : ?>
                <article class="content-card content-card--grid"><h3><?php echo esc_html( $objective['title'] ?? '' ); ?></h3><p><?php echo esc_html( $objective['short'] ?? '' ); ?></p><a href="<?php echo esc_url( aitea_page_url( 'objectives' ) . '#' . sanitize_title( $objective['slug'] ) ); ?>"><?php echo esc_html( aitea__( 'Explore objective' ) ); ?></a></article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>