<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
</main>
<footer class="site-footer">
    <div class="site-footer__grid">
        <section class="footer-brand" aria-labelledby="footer-brand-title">
            <?php the_aitea_logo( 'light' ); ?>
            <h2 id="footer-brand-title" class="screen-reader-text"><?php echo esc_html( aitea__( 'AITEA' ) ); ?></h2>
            <p class="footer-brand__name"><?php echo esc_html( aitea__( 'Austrian-Indian Talent Exchange Association' ) ); ?></p>
            <p><?php echo esc_html( aitea__( 'Connecting people. Creating possibilities. Vienna, Austria' ) ); ?></p>
            <a class="footer-brand__site" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( aitea__( 'www.aitea.at' ) ); ?> <span aria-hidden="true">↗</span></a>
        </section>
        <section class="footer-section" aria-labelledby="footer-explore-title">
            <h2 id="footer-explore-title"><?php echo esc_html( aitea__( 'Explore' ) ); ?></h2>
            <?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'fallback_cb' => 'aitea_footer_menu_fallback', 'menu_id' => 'footer-menu' ) ); ?>
        </section>
        <section class="footer-section footer-section--cta" aria-labelledby="footer-member-title">
            <h2 id="footer-member-title"><?php echo esc_html( aitea__( 'Be part of the exchange' ) ); ?></h2>
            <h3><?php echo esc_html( aitea__( 'Your next connection starts here.' ) ); ?></h3>
            <?php aitea_button( 'Become a Member', aitea_page_url( 'membership' ), 'light', 'arrow-up-right' ); ?>
        </section>
    </div>
    <div class="site-footer__bottom">
        <p><?php echo esc_html( sprintf( aitea__( '© %s AITEA. A Vienna-based nonprofit.' ), gmdate( 'Y' ) ) ); ?></p>
        <nav class="footer-legal" aria-label="<?php echo esc_attr( aitea__( 'Legal links' ) ); ?>">
            <a href="<?php echo esc_url( aitea_page_url( 'data-protection' ) ); ?>"><?php echo esc_html( aitea__( 'Privacy notice' ) ); ?></a>
            <a href="<?php echo esc_url( aitea_page_url( 'imprint' ) ); ?>"><?php echo esc_html( aitea__( 'Legal notice' ) ); ?></a>
            <a href="<?php echo esc_url( aitea_page_url( 'contact' ) ); ?>"><?php echo esc_html( aitea__( 'Contact' ) ); ?></a>
            <?php get_template_part( 'template-parts/social-icons' ); ?>
            <span><?php echo esc_html( aitea__( 'Webpage created by Zeta AI Labs Pvt. Ltd' ) ); ?></span>
        </nav>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
