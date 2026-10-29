<?php
/**
 * AITEA theme setup and content helpers.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once get_template_directory() . '/config/links.php';
require_once get_template_directory() . '/inc/objectives.php';
require_once get_template_directory() . '/inc/people.php';

function aitea_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', array( 'height' => 48, 'width' => 160, 'flex-width' => true, 'flex-height' => true ) );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
    add_image_size( 'aitea-sponsor-logo', 480, 240, false );
    add_image_size( 'aitea-card', 720, 480, true );
    add_image_size( 'aitea-objective-photo', 720, 480, true );
    register_nav_menus(
        array(
            'primary' => aitea__( 'Primary navigation' ),
            'footer'  => aitea__( 'Footer navigation' ),
        )
    );
}
add_action( 'after_setup_theme', 'aitea_theme_setup' );

function aitea_theme_assets() {
    wp_enqueue_style( 'aitea-theme', get_stylesheet_uri(), array(), '1.0.0' );
    wp_enqueue_script( 'aitea-menu', get_template_directory_uri() . '/assets/js/menu.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'aitea_theme_assets' );

function aitea_enqueue_fonts() {
    wp_enqueue_style( 'aitea-inter', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), null );
}
add_action( 'wp_enqueue_scripts', 'aitea_enqueue_fonts' );

function aitea_expertise_url() {
    $page = get_page_by_path( 'expertise', OBJECT, 'page' );
    if ( $page && function_exists( 'pll_get_post' ) ) {
        $translation = pll_get_post( $page->ID, pll_current_language( 'slug' ) );
        if ( $translation ) {
            $page = get_post( $translation );
        }
    }

    return $page ? get_permalink( $page ) : home_url( '/expertise/' );
}

function aitea_redirect_people_pages() {
    if ( ! is_page( array( 'board', 'advisors' ) ) ) {
        return;
    }

    $anchor = is_page( 'board' ) ? 'board' : 'advisors';
    wp_safe_redirect( aitea_expertise_url() . '#' . $anchor, 301 );
    exit;
}
add_action( 'template_redirect', 'aitea_redirect_people_pages' );

function aitea_locale() {
    if ( function_exists( 'pll_current_language' ) ) {
        $language = pll_current_language( 'slug' );
        if ( in_array( $language, array( 'de', 'en' ), true ) ) {
            return $language;
        }
    }
    return 'de';
}

/**
 * Translate a visible theme string through Polylang when available.
 */
if ( ! function_exists( 'aitea__' ) ) {
    function aitea__( $text ) {
        if ( function_exists( 'pll__' ) ) {
            return pll__( $text );
        }

        return translate( $text, 'aitea-theme' );
    }
}

function aitea_message_data( $language ) {
    static $messages = array();
    if ( isset( $messages[ $language ] ) ) {
        return $messages[ $language ];
    }

    $path = get_template_directory() . '/../content/' . $language . '.json';
    $path = wp_normalize_path( realpath( $path ) ?: $path );
    $contents = file_exists( $path ) ? file_get_contents( $path ) : false;
    $decoded = $contents ? json_decode( $contents, true ) : array();
    $messages[ $language ] = is_array( $decoded ) ? $decoded : array();
    return $messages[ $language ];
}

function aitea_t( $key, $fallback = '' ) {
    $value = aitea_message_data( aitea_locale() );
    foreach ( explode( '.', $key ) as $segment ) {
        if ( ! is_array( $value ) || ! array_key_exists( $segment, $value ) ) {
            $value = aitea_message_data( 'de' );
            foreach ( explode( '.', $key ) as $fallback_segment ) {
                if ( ! is_array( $value ) || ! array_key_exists( $fallback_segment, $value ) ) {
                    return $fallback;
                }
                $value = $value[ $fallback_segment ];
            }
            break;
        }
        $value = $value[ $segment ];
    }
    return is_scalar( $value ) ? (string) $value : $fallback;
}

function aitea_data( $key, $fallback = array() ) {
    $value = aitea_message_data( aitea_locale() );
    foreach ( explode( '.', $key ) as $segment ) {
        if ( ! is_array( $value ) || ! array_key_exists( $segment, $value ) ) {
            $value = aitea_message_data( 'de' );
            foreach ( explode( '.', $key ) as $fallback_segment ) {
                if ( ! is_array( $value ) || ! array_key_exists( $fallback_segment, $value ) ) {
                    return $fallback;
                }
                $value = $value[ $fallback_segment ];
            }
            break;
        }
        $value = $value[ $segment ];
    }
    return $value;
}

function aitea_page_url( $slug ) {
    $page = get_page_by_path( $slug );
    return $page ? get_permalink( $page ) : home_url( '/' . trim( $slug, '/' ) . '/' );
}

function the_aitea_logo( $variant = 'dark' ) {
    $variant = 'light' === $variant ? 'light' : 'dark';
    $class = 'aitea-logo aitea-logo--' . $variant;
    $alt = aitea__( 'AITEA' );
    echo '<a class="' . esc_attr( $class ) . '" href="' . esc_url( home_url( '/' ) ) . '" aria-label="' . esc_attr( $alt ) . '">';
    if ( has_custom_logo() ) {
        echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'full', false, array( 'alt' => '' ) );
    } else {
        echo '<span class="aitea-logo__wordmark">AITEA<span class="aitea-logo__dot" aria-hidden="true">.</span></span>';
    }
    echo '</a>';
}

function aitea_primary_menu_fallback() {
    $items = array(
        'about-us'   => aitea__( 'About Us' ),
        'objectives' => aitea__( 'Objectives' ),
        'expertise'  => aitea__( 'Expertise' ),
        'news'       => aitea__( 'News' ),
        'events'     => aitea__( 'Events' ),
    );
    echo '<ul class="menu">';
    foreach ( $items as $slug => $label ) {
        echo '<li><a href="' . esc_url( aitea_page_url( $slug ) ) . '">' . esc_html( $label ) . '</a></li>';
    }
    echo '</ul>';
}

function aitea_footer_menu_fallback() {
    aitea_primary_menu_fallback();
}

function aitea_icon( $name ) {
    $paths = array(
        'arrow-up-right' => '<path d="M5 19 19 5M8 5h11v11" />',
        'arrow-right'    => '<path d="M4 12h16M13 5l7 7-7 7" />',
        'arrow-down'     => '<path d="M12 4v16m7-7-7 7-7-7" />',
        'info'           => '<circle cx="12" cy="12" r="9" /><path d="M12 10v6M12 7h.01" />',
    );
    $path = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['arrow-right'];
    return '<svg class="aitea-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $path . '</svg>';
}

function aitea_button( $label, $url, $variant = 'primary', $icon = 'arrow-up-right' ) {
    echo '<a class="button button--' . esc_attr( $variant ) . '" href="' . esc_url( $url ) . '"><span>' . esc_html( aitea__( $label ) ) . '</span><span class="button__icon">' . aitea_icon( $icon ) . '</span></a>';
}

function aitea_language_switcher() {
    $languages = function_exists( 'pll_the_languages' ) ? pll_the_languages( array( 'raw' => true, 'hide_if_no_translation' => false ) ) : array();
    echo '<nav class="language-switcher" aria-label="' . esc_attr( aitea__( 'Language' ) ) . '">';
    if ( ! empty( $languages ) ) {
        foreach ( $languages as $language ) {
            $label   = strtoupper( $language['slug'] );
            $classes = ! empty( $language['current_lang'] ) ? ' is-active' : '';
            echo '<a class="language-switcher__link' . esc_attr( $classes ) . '" href="' . esc_url( $language['url'] ) . '" hreflang="' . esc_attr( $language['slug'] ) . '" lang="' . esc_attr( $language['slug'] ) . '"' . ( ! empty( $language['current_lang'] ) ? ' aria-current="page"' : '' ) . '>' . esc_html( $label ) . '</a>';
        }
    }
    echo '<span class="language-switcher__link language-switcher__link--disabled" aria-disabled="true">' . esc_html( aitea__( 'HI' ) ) . '</span>';
    echo '</nav>';
}

function aitea_footer_links( $key ) {
    $links = aitea_config_links( $key );
    foreach ( $links as $link ) {
        if ( empty( $link['href'] ) ) {
            continue;
        }
        echo '<li><a href="' . esc_url( $link['href'] ) . '">' . esc_html( aitea__( $link['label'] ) ) . '</a></li>';
    }
}

function aitea_placeholder_flag( $country ) {
    $country = strtolower( sanitize_key( $country ) );
    return get_template_directory_uri() . '/assets/img/placeholders/flag-' . $country . '.svg';
}
