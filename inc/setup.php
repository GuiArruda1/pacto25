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
    $theme_dir     = get_template_directory();

    // Cache-busting with filemtime
    $var_ver    = file_exists( $theme_dir . '/css/variables.css' ) ? filemtime( $theme_dir . '/css/variables.css' ) : $theme_version;
    $typo_ver   = file_exists( $theme_dir . '/css/typography.css' ) ? filemtime( $theme_dir . '/css/typography.css' ) : $theme_version;
    $layout_ver = file_exists( $theme_dir . '/css/layout.css' ) ? filemtime( $theme_dir . '/css/layout.css' ) : $theme_version;
    $comp_ver   = file_exists( $theme_dir . '/css/components.css' ) ? filemtime( $theme_dir . '/css/components.css' ) : $theme_version;
    $resp_ver   = file_exists( $theme_dir . '/css/responsive.css' ) ? filemtime( $theme_dir . '/css/responsive.css' ) : $theme_version;
    $style_ver  = file_exists( $theme_dir . '/style.css' ) ? filemtime( $theme_dir . '/style.css' ) : $theme_version;

    // Modular CSS Architecture
    wp_enqueue_style( 'pacto-variables', $theme_uri . '/css/variables.css', array(), $var_ver );
    wp_enqueue_style( 'pacto-typography', $theme_uri . '/css/typography.css', array( 'pacto-variables' ), $typo_ver );
    wp_enqueue_style( 'pacto-layout', $theme_uri . '/css/layout.css', array( 'pacto-typography' ), $layout_ver );
    wp_enqueue_style( 'pacto-components', $theme_uri . '/css/components.css', array( 'pacto-layout' ), $comp_ver );
    wp_enqueue_style( 'pacto-responsive', $theme_uri . '/css/responsive.css', array( 'pacto-components' ), $resp_ver );

    // Theme root stylesheet
    wp_enqueue_style( 'pacto-style', get_stylesheet_uri(), array( 'pacto-responsive' ), $style_ver );

    // Quem Somos page styles
    if ( is_page_template( 'page-quem-somos.php' ) || is_page( 'quem-somos' ) ) {
        $qs_ver = file_exists( $theme_dir . '/css/quem-somos.css' ) ? filemtime( $theme_dir . '/css/quem-somos.css' ) : $theme_version;
        wp_enqueue_style( 'pacto-quem-somos', $theme_uri . '/css/quem-somos.css', array( 'pacto-style' ), $qs_ver );
    }

    // Particulares page styles
    if ( is_page_template( 'page-particulares.php' ) || is_page( 'particulares' ) ) {
        $part_ver = file_exists( $theme_dir . '/css/particulares.css' ) ? filemtime( $theme_dir . '/css/particulares.css' ) : $theme_version;
        wp_enqueue_style( 'pacto-particulares', $theme_uri . '/css/particulares.css', array( 'pacto-style' ), $part_ver );
    }

    // Empresas page styles
    if ( is_page_template( 'page-empresas.php' ) || is_page( 'empresas' ) ) {
        $emp_ver = file_exists( $theme_dir . '/css/empresas.css' ) ? filemtime( $theme_dir . '/css/empresas.css' ) : $theme_version;
        wp_enqueue_style( 'pacto-empresas', $theme_uri . '/css/empresas.css', array( 'pacto-style' ), $emp_ver );
    }

    // Single Seguro Particular and Empresa styles
    if ( is_singular( 'seguro_particular' ) || is_singular( 'seguro_empresa' ) ) {
        $single_ver = file_exists( $theme_dir . '/css/single-seguro.css' ) ? filemtime( $theme_dir . '/css/single-seguro.css' ) : $theme_version;
        wp_enqueue_style( 'pacto-single-seguro', $theme_uri . '/css/single-seguro.css', array( 'pacto-style' ), $single_ver );
    }

    // Sinistro page styles
    if ( is_page_template( 'page-sinistro.php' ) || is_page( 'sinistro' ) || is_page( 'em-caso-de-sinistro' ) ) {
        $sin_ver = file_exists( $theme_dir . '/css/sinistro.css' ) ? filemtime( $theme_dir . '/css/sinistro.css' ) : $theme_version;
        wp_enqueue_style( 'pacto-sinistro', $theme_uri . '/css/sinistro.css', array( 'pacto-style' ), $sin_ver );
    }

    // Contactos page styles
    if ( is_page_template( 'page-contactos.php' ) || is_page( 'contactos' ) ) {
        $contact_ver = file_exists( $theme_dir . '/css/contactos.css' ) ? filemtime( $theme_dir . '/css/contactos.css' ) : $theme_version;
        wp_enqueue_style( 'pacto-contactos', $theme_uri . '/css/contactos.css', array( 'pacto-style' ), $contact_ver );
    }

    // Protocolos page styles
    if ( is_page_template( 'page-protocolos.php' ) || is_page( 'protocolos' ) ) {
        $protocolos_ver = file_exists( $theme_dir . '/css/protocolos.css' ) ? filemtime( $theme_dir . '/css/protocolos.css' ) : $theme_version;
        wp_enqueue_style( 'pacto-protocolos', $theme_uri . '/css/protocolos.css', array( 'pacto-style' ), $protocolos_ver );
    }

    // Legal and standard text page styles
    if ( is_page() || is_privacy_policy() || is_page_template( 'page-legal.php' ) ) {
        $legal_ver = file_exists( $theme_dir . '/css/legal.css' ) ? filemtime( $theme_dir . '/css/legal.css' ) : $theme_version;
        wp_enqueue_style( 'pacto-legal', $theme_uri . '/css/legal.css', array( 'pacto-style' ), $legal_ver );
    }

    // Notícias archive and single post styles
    if ( is_home() || is_archive() || is_singular( 'post' ) || is_page( 'noticias' ) || is_page_template( 'page-noticias.php' ) ) {
        $noticias_ver = file_exists( $theme_dir . '/css/noticias.css' ) ? filemtime( $theme_dir . '/css/noticias.css' ) : $theme_version;
        wp_enqueue_style( 'pacto-noticias', $theme_uri . '/css/noticias.css', array( 'pacto-style' ), $noticias_ver );
    }

    // Vanilla JavaScript (loaded in footer, deferred for optimal First Contentful Paint)
    $js_ver = file_exists( $theme_dir . '/js/main.js' ) ? filemtime( $theme_dir . '/js/main.js' ) : $theme_version;
    wp_enqueue_script( 'pacto-main', $theme_uri . '/js/main.js', array(), $js_ver, array( 'strategy' => 'defer', 'in_footer' => true ) );
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
