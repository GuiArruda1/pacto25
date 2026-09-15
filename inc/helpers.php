<?php
/**
 * Helper Functions and SVG Renderers
 * Theme: Pacto 25
 * Strict Agency SOP: Strict data escaping, zero hardcoded values, accessible inline SVGs
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Safely retrieve an ACF field with a fallback value.
 *
 * @param string $field_name ACF Field Name
 * @param mixed  $post_id    Post ID or 'option'
 * @param mixed  $default    Fallback value if field is empty or ACF is inactive
 * @return mixed
 */
function pacto_get_field( $field_name, $post_id = false, $default = '' ) {
    if ( function_exists( 'get_field' ) ) {
        $value = get_field( $field_name, $post_id );
        if ( ! empty( $value ) ) {
            return $value;
        }
        if ( ! $post_id ) {
            $front_id = get_option( 'page_on_front' );
            if ( $front_id ) {
                $value = get_field( $field_name, $front_id );
                if ( ! empty( $value ) ) {
                    return $value;
                }
            }
        }
    }
    return $default;
}

/**
 * Renders an accessible inline SVG icon without external HTTP requests.
 *
 * @param string $icon_name Icon key
 * @param array  $args      Optional SVG attributes (class, aria-label, etc.)
 * @return string Inline SVG code
 */
function pacto_get_svg( $icon_name, $args = array() ) {
    $class = isset( $args['class'] ) ? 'pacto-icon ' . esc_attr( $args['class'] ) : 'pacto-icon';
    $aria_hidden = isset( $args['aria-label'] ) ? '' : 'aria-hidden="true"';
    $aria_label  = isset( $args['aria-label'] ) ? 'role="img" aria-label="' . esc_attr( $args['aria-label'] ) . '"' : '';

    $icons = array(
        'arrow-left' => '<svg class="' . $class . '" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><polyline points="15 18 9 12 15 6"></polyline></svg>',
        
        'arrow-right' => '<svg class="' . $class . '" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><polyline points="9 18 15 12 9 6"></polyline></svg>',
        
        'chevron-up' => '<svg class="' . $class . '" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><polyline points="18 15 12 9 6 15"></polyline></svg>',
        
        'search' => '<svg class="' . $class . '" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        
        'instagram' => '<svg class="' . $class . '" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>',
        
        'linkedin' => '<svg class="' . $class . '" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" ' . $aria_hidden . ' ' . $aria_label . '><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 10.9v8.37H9.2V10.9H6.46M7.83 6.64c-.88 0-1.6.72-1.6 1.6 0 .88.72 1.6 1.6 1.6.88 0 1.6-.72 1.6-1.6 0-.88-.72-1.6-1.6-1.6z"/></svg>',
        
        'facebook' => '<svg class="' . $class . '" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" ' . $aria_hidden . ' ' . $aria_label . '><path d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z"/></svg>',

        'youtube' => '<svg class="' . $class . '" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" ' . $aria_hidden . ' ' . $aria_label . '><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',

        'phone' => '<svg class="' . $class . '" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>',

        'whatsapp' => '<svg class="' . $class . '" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>',
    );

    return isset( $icons[ $icon_name ] ) ? $icons[ $icon_name ] : '';
}

/**
 * Render an image with explicit dimensions and lazy loading for Core Web Vitals.
 *
 * @param mixed  $image     ACF Image array or attachment ID or URL string
 * @param string $size      WP image size
 * @param string $class     CSS class
 * @param string $fallback  Fallback URL
 * @param bool   $is_lcp    Set to true for above-the-fold hero images to disable lazy loading
 */
function pacto_render_image( $image, $size = 'large', $class = '', $fallback = '', $is_lcp = false ) {
    $loading_attr = $is_lcp ? 'loading="eager" fetchpriority="high"' : 'loading="lazy" decoding="async"';

    if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
        echo wp_get_attachment_image( $image['ID'], $size, false, array(
            'class'         => esc_attr( $class ),
            'loading'       => $is_lcp ? 'eager' : 'lazy',
            'fetchpriority' => $is_lcp ? 'high' : 'auto',
            'decoding'      => 'async',
        ) );
        return;
    }

    if ( is_numeric( $image ) ) {
        echo wp_get_attachment_image( $image, $size, false, array(
            'class'         => esc_attr( $class ),
            'loading'       => $is_lcp ? 'eager' : 'lazy',
            'fetchpriority' => $is_lcp ? 'high' : 'auto',
            'decoding'      => 'async',
        ) );
        return;
    }

    $src = is_string( $image ) && ! empty( $image ) ? $image : $fallback;

    if ( ! empty( $src ) ) {
        printf(
            '<img src="%s" class="%s" alt="%s" width="600" height="600" %s />',
            esc_url( $src ),
            esc_attr( $class ),
            esc_attr__( 'Imagem Pacto Seguro', 'pacto-25' ),
            $loading_attr
        );
    }
}

/**
 * Renders the customizable header logo with smart hierarchy:
 * 1. ACF 'header_logo' field (front page or options)
 * 2. WordPress native Customizer logo (the_custom_logo)
 * 3. Default styled brand text
 */
function pacto_render_header_logo() {
    $front_page_id = get_option( 'page_on_front' );
    $acf_logo      = pacto_get_field( 'header_logo', $front_page_id );

    if ( ! empty( $acf_logo ) ) {
        $logo_url = is_array( $acf_logo ) ? $acf_logo['url'] : $acf_logo;
        $alt_text = is_array( $acf_logo ) && ! empty( $acf_logo['alt'] ) ? $acf_logo['alt'] : get_bloginfo( 'name' );
        printf(
            '<a href="%s" class="site-header__logo-link custom-logo-link" rel="home"><img src="%s" alt="%s" class="site-header__logo-img custom-logo" width="220" height="48" /></a>',
            esc_url( home_url( '/' ) ),
            esc_url( $logo_url ),
            esc_attr( $alt_text )
        );
        return;
    }

    if ( has_custom_logo() ) {
        the_custom_logo();
        return;
    }

    ?>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__logo-link" rel="home">
        <span class="site-header__brand-text">
            pacto<span class="text-primary">seguro</span> <span class="badge-25">25</span>
        </span>
    </a>
    <?php
}

/**
 * Renders the customizable footer logo:
 * 1. ACF 'footer_logo' field (front page or options)
 * 2. Default styled brand text
 */
function pacto_render_footer_logo() {
    $front_page_id = get_option( 'page_on_front' );
    $acf_logo      = pacto_get_field( 'footer_logo', $front_page_id );

    if ( ! empty( $acf_logo ) ) {
        $logo_url = is_array( $acf_logo ) ? $acf_logo['url'] : $acf_logo;
        $alt_text = is_array( $acf_logo ) && ! empty( $acf_logo['alt'] ) ? $acf_logo['alt'] : get_bloginfo( 'name' );
        printf(
            '<a href="%s" class="site-footer__logo-link" rel="home"><img src="%s" alt="%s" class="site-footer__logo-img" width="220" height="48" /></a>',
            esc_url( home_url( '/' ) ),
            esc_url( $logo_url ),
            esc_attr( $alt_text )
        );
        return;
    }

    $white_logo_url = get_template_directory_uri() . '/assets/logo-white.svg';
    printf(
        '<a href="%s" class="site-footer__logo-link" rel="home"><img src="%s" alt="%s" class="site-footer__logo-img" width="180" height="56" /></a>',
        esc_url( home_url( '/' ) ),
        esc_url( $white_logo_url ),
        esc_attr( get_bloginfo( 'name' ) )
    );
}

/**
 * Retrieves and parses mega menu column links.
 * Supports both textarea format (Title | URL) and ACF Repeater array format.
 *
 * @param int   $col_num       Column number (1, 2, 3, 4)
 * @param array $default_links Fallback links array
 * @return array Array of items with 'title' and 'url'
 */
function pacto_get_mega_menu_column( $col_num, $default_links = array() ) {
    $front_page_id = get_option( 'page_on_front' );
    $field_name    = 'mm_col' . intval( $col_num ) . '_links';
    $raw           = pacto_get_field( $field_name, $front_page_id, '' );

    // If already structured array (e.g. ACF Pro repeater)
    if ( is_array( $raw ) && ! empty( $raw ) ) {
        return $raw;
    }

    // Parse textarea format (one per line: Title | URL)
    if ( is_string( $raw ) && '' !== trim( $raw ) ) {
        $lines = explode( "\n", trim( $raw ) );
        $items = array();
        foreach ( $lines as $line ) {
            $line = trim( $line );
            if ( empty( $line ) ) {
                continue;
            }
            if ( strpos( $line, '|' ) !== false ) {
                $parts = explode( '|', $line, 2 );
                $title = trim( $parts[0] );
                $url   = trim( $parts[1] );
            } else {
                $title = $line;
                $url   = '#' . sanitize_title( $line );
            }
            if ( ! empty( $title ) ) {
                $items[] = array(
                    'title' => $title,
                    'url'   => ! empty( $url ) ? $url : '#',
                );
            }
        }
        if ( ! empty( $items ) ) {
            return $items;
        }
    }

    return $default_links;
}

