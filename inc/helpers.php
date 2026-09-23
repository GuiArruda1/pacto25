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
        'arrow-left' => '<svg class="' . $class . '" width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><polyline points="15 18 9 12 15 6"></polyline></svg>',
        
        'arrow-right' => '<svg class="' . $class . '" width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><polyline points="9 18 15 12 9 6"></polyline></svg>',
        
        'chevron-up' => '<svg class="' . $class . '" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><polyline points="18 15 12 9 6 15"></polyline></svg>',
        
        'whatsapp' => '<svg class="' . $class . '" width="22" height="22" viewBox="0 0 24 24" fill="currentColor" ' . $aria_hidden . ' ' . $aria_label . '><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.19 8.19 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24M8.53 7.33c-.16 0-.43.06-.66.31-.22.25-.86.84-.86 2.07 0 1.22.89 2.4 1.01 2.56.12.17 1.75 2.67 4.23 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.06-.1-.23-.17-.48-.29s-1.47-.73-1.7-.81c-.23-.09-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.15.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.12-.56-1.35-.77-1.85-.2-.49-.41-.42-.56-.43l-.48-.01z"/></svg>',
        
        'search' => '<svg class="' . $class . '" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        
        'instagram' => '<svg class="' . $class . '" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>',
        
        'linkedin' => '<svg class="' . $class . '" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" ' . $aria_hidden . ' ' . $aria_label . '><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 10.9v8.37H9.2V10.9H6.46M7.83 6.64c-.88 0-1.6.72-1.6 1.6 0 .88.72 1.6 1.6 1.6.88 0 1.6-.72 1.6-1.6 0-.88-.72-1.6-1.6-1.6z"/></svg>',
        
        'facebook' => '<svg class="' . $class . '" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" ' . $aria_hidden . ' ' . $aria_label . '><path d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z"/></svg>',

        'youtube' => '<svg class="' . $class . '" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" ' . $aria_hidden . ' ' . $aria_label . '><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',

        'phone' => '<svg class="' . $class . '" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>',

        'heart-check' => '<svg class="' . $class . '" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l4.5-4.5"></path><polyline points="15 10 18 13 22 8"></polyline></svg>',

        'clock-check' => '<svg class="' . $class . '" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline><path d="M16 18l2 2 4-4"></path></svg>',

        'shield-check' => '<svg class="' . $class . '" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 11 14 15 10"></polyline></svg>',

        'users-check' => '<svg class="' . $class . '" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><polyline points="16 11 18 13 22 9"></polyline></svg>',

        'chevron-left' => '<svg class="' . $class . '" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><polyline points="15 18 9 12 15 6"></polyline></svg>',

        'chevron-right' => '<svg class="' . $class . '" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><polyline points="9 18 15 12 9 6"></polyline></svg>',

        'pdf' => '<svg class="' . $class . '" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" ' . $aria_hidden . ' ' . $aria_label . '><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><text x="7.5" y="18" fill="currentColor" stroke="none" font-size="6" font-weight="bold" font-family="sans-serif">PDF</text></svg>',
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
                    'url'   => ! empty( $url ) ? $url : pacto_get_seguro_particular_url( sanitize_title( $title ) ),
                );
            }
        }
        if ( ! empty( $items ) ) {
            return $items;
        }
    }

    return $default_links;
}

/**
 * Resolves a dynamic URL for navigation items based on template or slug, with fallback.
 *
 * @param string $slug      Page slug (e.g., 'quem-somos', 'particulares', 'sinistro', 'empresas', 'contactos')
 * @param string $template  Page template filename (e.g., 'page-quem-somos.php', 'page-particulares.php', 'page-sinistro.php')
 * @param string $hash      Optional anchor hash fallback on home page (e.g., '#empresas')
 * @return string           Resolved URL
 */
function pacto_get_nav_url( $slug, $template = '', $hash = '' ) {
    // 1. Try finding page by template
    if ( ! empty( $template ) ) {
        $pages = get_pages( array(
            'meta_key'   => '_wp_page_template',
            'meta_value' => $template,
            'number'     => 1,
        ) );
        if ( ! empty( $pages[0] ) ) {
            return get_permalink( $pages[0]->ID );
        }
    }

    // 2. Try finding page by slug (including alternative slugs)
    $slugs_to_check = array( $slug );
    if ( $slug === 'quem-somos' ) {
        $slugs_to_check[] = 'institucional';
        $slugs_to_check[] = 'sobre';
    } elseif ( $slug === 'sinistro' ) {
        $slugs_to_check[] = 'em-caso-de-sinistro';
        $slugs_to_check[] = 'sinistros';
    } elseif ( $slug === 'particulares' ) {
        $slugs_to_check[] = 'seguros-particulares';
    }

    foreach ( $slugs_to_check as $s ) {
        $page = get_page_by_path( $s );
        if ( $page ) {
            return get_permalink( $page->ID );
        }
    }

    // 3. Check if hash fallback is given (prepend home url if not on front page or as absolute path)
    if ( ! empty( $hash ) ) {
        return home_url( '/' . ltrim( $hash, '/' ) );
    }

    // 4. Default to standard pretty permalink
    return home_url( '/' . trim( $slug, '/' ) . '/' );
}

/**
 * Resolves a dynamic URL for a Seguro Particular item.
 *
 * @param string $slug  Slug of the seguro (e.g. 'automovel', 'saude', 'seguro-automovel')
 * @return string       Resolved permalink or anchor
 */
function pacto_get_seguro_particular_url( $slug ) {
    $clean_slug = str_replace( 'seguro-', '', $slug );
    
    // Check if CPT post exists
    $post = get_page_by_path( $slug, OBJECT, 'seguro_particular' );
    if ( ! $post ) {
        $post = get_page_by_path( $clean_slug, OBJECT, 'seguro_particular' );
    }
    if ( ! $post ) {
        $post = get_page_by_path( 'seguro-' . $clean_slug, OBJECT, 'seguro_particular' );
    }

    if ( $post ) {
        return get_permalink( $post->ID );
    }

    // Check if Particulares page exists and link to anchor
    $particulares_url = pacto_get_nav_url( 'particulares', 'page-particulares.php' );
    return $particulares_url . '#' . $clean_slug;
}

