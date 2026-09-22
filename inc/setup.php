<?php
/**
 * Theme Setup and Asset Enqueues
 * Theme: Pacto 25
 * Strict Agency SOP: Privacy first, performant asset loading, zero render-blocking dependencies
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function pacto_25_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );

    // Switch default core markup to output valid HTML5.
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Add support for custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 96,
        'width'       => 280,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Register primary navigation menus
    register_nav_menus( array(
        'primary' => esc_html__( 'Menu Principal', 'pacto-25' ),
        'footer'  => esc_html__( 'Menu Rodapé', 'pacto-25' ),
    ) );
}
add_action( 'after_setup_theme', 'pacto_25_setup' );

/**
 * Enqueue scripts and styles.
 */
function pacto_25_scripts() {
    $theme_version = wp_get_theme()->get( 'Version' );
    $theme_uri     = get_template_directory_uri();

    // Modular CSS Architecture
    wp_enqueue_style( 'pacto-variables', $theme_uri . '/css/variables.css', array(), $theme_version );
    wp_enqueue_style( 'pacto-typography', $theme_uri . '/css/typography.css', array( 'pacto-variables' ), $theme_version );
    wp_enqueue_style( 'pacto-layout', $theme_uri . '/css/layout.css', array( 'pacto-typography' ), $theme_version );
    wp_enqueue_style( 'pacto-components', $theme_uri . '/css/components.css', array( 'pacto-layout' ), $theme_version );
    wp_enqueue_style( 'pacto-responsive', $theme_uri . '/css/responsive.css', array( 'pacto-components' ), $theme_version );

    // Theme root stylesheet
    wp_enqueue_style( 'pacto-style', get_stylesheet_uri(), array( 'pacto-responsive' ), $theme_version );

    // Quem Somos page styles
    if ( is_page_template( 'page-quem-somos.php' ) || is_page( 'quem-somos' ) ) {
        wp_enqueue_style( 'pacto-quem-somos', $theme_uri . '/css/quem-somos.css', array( 'pacto-style' ), $theme_version );
    }

    // Particulares page styles
    if ( is_page_template( 'page-particulares.php' ) || is_page( 'particulares' ) ) {
        wp_enqueue_style( 'pacto-particulares', $theme_uri . '/css/particulares.css', array( 'pacto-style' ), $theme_version );
    }

    // Single Seguro Particular styles
    if ( is_singular( 'seguro_particular' ) ) {
        wp_enqueue_style( 'pacto-single-seguro', $theme_uri . '/css/single-seguro.css', array( 'pacto-style' ), $theme_version );
    }

    // Sinistro page styles
    if ( is_page_template( 'page-sinistro.php' ) || is_page( 'sinistro' ) || is_page( 'em-caso-de-sinistro' ) ) {
        wp_enqueue_style( 'pacto-sinistro', $theme_uri . '/css/sinistro.css', array( 'pacto-style' ), $theme_version );
    }

    // Vanilla JavaScript (loaded in footer, deferred for optimal First Contentful Paint)
    wp_enqueue_script( 'pacto-main', $theme_uri . '/js/main.js', array(), $theme_version, array( 'strategy' => 'defer', 'in_footer' => true ) );
}
add_action( 'wp_enqueue_scripts', 'pacto_25_scripts' );

/**
 * Preconnect to Google Fonts resource origins for faster font discovery
 */
function pacto_25_resource_hints( $urls, $relation_type ) {
    if ( wp_dependencies_unique_hosts() && 'preconnect' === $relation_type ) {
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
            'crossorigin' => 'anonymous',
        );
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
    }
    return $urls;
}
add_filter( 'wp_resource_hints', 'pacto_25_resource_hints', 10, 2 );
