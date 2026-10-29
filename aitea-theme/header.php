<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#content"><?php echo esc_html( aitea__( 'Skip to content' ) ); ?></a>
<header class="site-header">
    <div class="site-header__inner">
        <?php the_aitea_logo( 'dark' ); ?>
        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="site-navigation" data-menu-toggle>
            <span class="screen-reader-text"><?php echo esc_html( aitea__( 'Menu' ) ); ?></span>
            <span aria-hidden="true"></span><span aria-hidden="true"></span><span aria-hidden="true"></span>
        </button>
        <div id="site-navigation" class="site-header__nav" data-menu-panel>
            <nav class="primary-nav" aria-label="<?php echo esc_attr( aitea__( 'Primary navigation' ) ); ?>">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_id'        => 'primary-menu',
                        'fallback_cb'    => 'aitea_primary_menu_fallback',
                    )
                );
                ?>
            </nav>
            <?php aitea_language_switcher(); ?>
            <div class="member-slot">
                <?php do_action( 'aitea_header_member_slot' ); ?>
            </div>
            <?php aitea_button( 'Become a Member', aitea_page_url( 'membership' ), 'primary', 'arrow-up-right' ); ?>
        </div>
    </div>
</header>
<div class="country-banner" aria-label="<?php echo esc_attr( aitea__( 'Austrian, European and Indian partners' ) ); ?>">
    <div class="country-banner__inner">
        <?php foreach ( array( 'at' => 'Austria', 'eu' => 'European Union', 'in' => 'India' ) as $country => $label ) : ?>
            <img src="<?php echo esc_url( aitea_placeholder_flag( $country ) ); ?>" alt="<?php echo esc_attr( aitea__( $label ) ); ?>" width="32" height="20">
        <?php endforeach; ?>
    </div>
</div>
<main id="content" class="site-main">
