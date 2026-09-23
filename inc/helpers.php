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
    $target_id = $post_id;
    if ( ! $target_id && 'option' !== $target_id ) {
        $target_id = get_the_ID();
        if ( ! $target_id ) {
            $target_id = get_queried_object_id();
        }
    }

    // 1. Direct native post meta first (fastest and avoids ACF internal key mismatches)
    if ( $target_id && is_numeric( $target_id ) ) {
        $meta_val = get_post_meta( $target_id, $field_name, true );
        if ( '' !== $meta_val && false !== $meta_val && array() !== $meta_val ) {
            return $meta_val;
        }
    }

    // 2. Safe ACF get_field with error protection
    if ( function_exists( 'get_field' ) ) {
        try {
            $value = get_field( $field_name, $target_id ?: false );
            if ( ! empty( $value ) ) {
                return $value;
            }
        } catch ( \Throwable $e ) {
            // Silently ignore ACF field-key resolution errors
        }
    }

    // 3. Fallback to front page for global branding/header/footer fields
    if ( ! $post_id ) {
        $front_id = (int) get_option( 'page_on_front' );
        if ( $front_id && (int) $target_id !== $front_id ) {
            $meta_val = get_post_meta( $front_id, $field_name, true );
            if ( '' !== $meta_val && false !== $meta_val && array() !== $meta_val ) {
                return $meta_val;
            }
            if ( function_exists( 'get_field' ) ) {
                try {
                    $value = get_field( $field_name, $front_id );
                    if ( ! empty( $value ) ) {
                        return $value;
                    }
                } catch ( \Throwable $e ) {
                    // Silently ignore ACF field-key resolution errors
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

    // Check if an SVG file exists in assets/icons/
    $possible_files = array(
        $icon_name . '.svg',
    );
    if ( 'heart-check' === $icon_name ) {
        $possible_files[] = 'fast.svg';
    } elseif ( 'clock-check' === $icon_name ) {
        $possible_files[] = 'clock.svg';
    } elseif ( 'fast' === $icon_name ) {
        $possible_files[] = 'heart-check.svg';
    } elseif ( 'clock' === $icon_name ) {
        $possible_files[] = 'speedometer.svg';
    }

    foreach ( $possible_files as $file ) {
        $icon_file = PACTO_THEME_DIR . '/assets/icons/' . sanitize_file_name( $file );
        if ( file_exists( $icon_file ) ) {
            $svg_raw = file_get_contents( $icon_file ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
            if ( ! empty( $svg_raw ) ) {
                // Ensure SVG has appropriate class and accessibility attributes
                $replacement = '<svg class="' . $class . '" ' . $aria_hidden . ' ' . $aria_label . ' ';
                $output_svg = preg_replace( '/<svg\s+/', $replacement, $svg_raw, 1 );
                // Ensure currentColor or white fill is respected
                return $output_svg;
            }
        }
    }

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

        // Exact Figma Heart with Checkmark (Simples e Fácil)
        'heart-check' => '<svg class="' . $class . '" width="90" height="80" viewBox="0 0 90 80" fill="currentColor" ' . $aria_hidden . ' ' . $aria_label . '><path d="M59.2188 2.5C53.2812 2.5 47.8125 5.3125 44.375 10.1562L41.0938 14.6875C40.7812 15 40.4688 15.3125 40 15.3125C39.5312 15.3125 39.2188 15 39.0625 14.6875L35.625 10.1562C32.1875 5.3125 26.7188 2.5 20.7812 2.5C10.625 2.5 2.5 10.625 2.5 20.7812C2.5 30.1562 8.28125 38.9062 14.2188 46.25C21.0938 54.375 29.2188 61.5625 34.8438 65.7812C36.0938 66.7188 37.5 67.3438 39.2188 67.5C39.5312 68.2812 39.8438 69.2188 40.1562 70C40.1562 70 40.1562 70 40 70C37.6562 70 35.1562 69.2188 33.2812 67.8125C27.5 63.4375 19.2188 56.25 12.3438 47.8125C6.25 40.4688 0 31.0938 0 20.7812C0 9.375 9.375 0 20.7812 0C27.5 0 33.75 3.28125 37.6562 8.59375L40 11.875L42.3438 8.59375C46.25 3.28125 52.5 0 59.2188 0C70.625 0 80 9.375 80 20.7812C80 23.9062 79.5312 26.7188 78.5938 29.6875C77.8125 29.375 77.0312 29.0625 76.25 28.75C77.0312 26.25 77.5 23.5938 77.5 20.7812C77.5 10.7812 69.375 2.5 59.2188 2.5ZM67.5 77.5C78.5938 77.5 87.5 68.5938 87.5 57.5C87.5 46.4062 78.5938 37.5 67.5 37.5C56.4062 37.5 47.5 46.4062 47.5 57.5C47.5 68.5938 56.4062 77.5 67.5 77.5ZM67.5 35C80 35 90 45 90 57.5C90 70 80 80 67.5 80C55 80 45 70 45 57.5C45 45 55 35 67.5 35ZM77.0312 46.875C77.5 47.1875 77.6562 47.9688 77.3438 48.5938L64.8438 65.7812C64.5312 66.0938 64.2188 66.25 63.75 66.25C63.4375 66.25 63.125 66.0938 62.8125 65.7812L56.5625 58.2812C56.0938 57.8125 56.25 57.0312 56.7188 56.5625C57.1875 56.0938 57.9688 56.0938 58.4375 56.7188L63.75 62.9688L75.3125 47.0312C75.625 46.5625 76.4062 46.4062 77.0312 46.7188V46.875Z"/></svg>',
        'fast'        => '<svg class="' . $class . '" width="90" height="80" viewBox="0 0 90 80" fill="currentColor" ' . $aria_hidden . ' ' . $aria_label . '><path d="M59.2188 2.5C53.2812 2.5 47.8125 5.3125 44.375 10.1562L41.0938 14.6875C40.7812 15 40.4688 15.3125 40 15.3125C39.5312 15.3125 39.2188 15 39.0625 14.6875L35.625 10.1562C32.1875 5.3125 26.7188 2.5 20.7812 2.5C10.625 2.5 2.5 10.625 2.5 20.7812C2.5 30.1562 8.28125 38.9062 14.2188 46.25C21.0938 54.375 29.2188 61.5625 34.8438 65.7812C36.0938 66.7188 37.5 67.3438 39.2188 67.5C39.5312 68.2812 39.8438 69.2188 40.1562 70C40.1562 70 40.1562 70 40 70C37.6562 70 35.1562 69.2188 33.2812 67.8125C27.5 63.4375 19.2188 56.25 12.3438 47.8125C6.25 40.4688 0 31.0938 0 20.7812C0 9.375 9.375 0 20.7812 0C27.5 0 33.75 3.28125 37.6562 8.59375L40 11.875L42.3438 8.59375C46.25 3.28125 52.5 0 59.2188 0C70.625 0 80 9.375 80 20.7812C80 23.9062 79.5312 26.7188 78.5938 29.6875C77.8125 29.375 77.0312 29.0625 76.25 28.75C77.0312 26.25 77.5 23.5938 77.5 20.7812C77.5 10.7812 69.375 2.5 59.2188 2.5ZM67.5 77.5C78.5938 77.5 87.5 68.5938 87.5 57.5C87.5 46.4062 78.5938 37.5 67.5 37.5C56.4062 37.5 47.5 46.4062 47.5 57.5C47.5 68.5938 56.4062 77.5 67.5 77.5ZM67.5 35C80 35 90 45 90 57.5C90 70 80 80 67.5 80C55 80 45 70 45 57.5C45 45 55 35 67.5 35ZM77.0312 46.875C77.5 47.1875 77.6562 47.9688 77.3438 48.5938L64.8438 65.7812C64.5312 66.0938 64.2188 66.25 63.75 66.25C63.4375 66.25 63.125 66.0938 62.8125 65.7812L56.5625 58.2812C56.0938 57.8125 56.25 57.0312 56.7188 56.5625C57.1875 56.0938 57.9688 56.0938 58.4375 56.7188L63.75 62.9688L75.3125 47.0312C75.625 46.5625 76.4062 46.4062 77.0312 46.7188V46.875Z"/></svg>',

        // Exact Figma Speedometer (Rápidos)
        'clock-check' => '<svg class="' . $class . '" width="80" height="80" viewBox="0 0 80 80" fill="currentColor" ' . $aria_hidden . ' ' . $aria_label . '><path d="M40 2.5C19.2188 2.5 2.5 19.2188 2.5 40C2.5 60.7812 19.2188 77.5 40 77.5C60.7812 77.5 77.5 60.7812 77.5 40C77.5 19.2188 60.7812 2.5 40 2.5ZM40 80C17.9688 80 0 62.0312 0 40C0 17.9688 17.9688 0 40 0C62.0312 0 80 17.9688 80 40C80 62.0312 62.0312 80 40 80ZM42.5 12.5C42.5 13.9062 41.4062 15 40 15C38.5938 15 37.5 13.9062 37.5 12.5C37.5 11.0938 38.5938 10 40 10C41.4062 10 42.5 11.0938 42.5 12.5ZM32.5 55C32.5 59.2188 35.7812 62.5 40 62.5C44.2188 62.5 47.5 59.2188 47.5 55C47.5 50.7812 44.2188 47.5 40 47.5C35.7812 47.5 32.5 50.7812 32.5 55ZM50 55C50 60.4688 45.4688 65 40 65C34.5312 65 30 60.4688 30 55C30 49.5312 34.5312 45 40 45C41.0938 45 42.3438 45.1562 43.2812 45.625L56.4062 19.5312C56.7188 18.9062 57.5 18.5938 58.125 18.9062C58.75 19.2188 58.9062 20 58.5938 20.625L45.625 46.7188C48.2812 48.4375 50 51.5625 50 55ZM25 20C25 21.4062 23.9062 22.5 22.5 22.5C21.0938 22.5 20 21.4062 20 20C20 18.5938 21.0938 17.5 22.5 17.5C23.9062 17.5 25 18.5938 25 20ZM15 40C13.5938 40 12.5 38.9062 12.5 37.5C12.5 36.0938 13.5938 35 15 35C16.4062 35 17.5 36.0938 17.5 37.5C17.5 38.9062 16.4062 40 15 40ZM67.5 37.5C67.5 38.9062 66.4062 40 65 40C63.5938 40 62.5 38.9062 62.5 37.5C62.5 36.0938 63.5938 35 65 35C66.4062 35 67.5 36.0938 67.5 37.5Z"/></svg>',
        'clock'       => '<svg class="' . $class . '" width="80" height="80" viewBox="0 0 80 80" fill="currentColor" ' . $aria_hidden . ' ' . $aria_label . '><path d="M40 2.5C19.2188 2.5 2.5 19.2188 2.5 40C2.5 60.7812 19.2188 77.5 40 77.5C60.7812 77.5 77.5 60.7812 77.5 40C77.5 19.2188 60.7812 2.5 40 2.5ZM40 80C17.9688 80 0 62.0312 0 40C0 17.9688 17.9688 0 40 0C62.0312 0 80 17.9688 80 40C80 62.0312 62.0312 80 40 80ZM42.5 12.5C42.5 13.9062 41.4062 15 40 15C38.5938 15 37.5 13.9062 37.5 12.5C37.5 11.0938 38.5938 10 40 10C41.4062 10 42.5 11.0938 42.5 12.5ZM32.5 55C32.5 59.2188 35.7812 62.5 40 62.5C44.2188 62.5 47.5 59.2188 47.5 55C47.5 50.7812 44.2188 47.5 40 47.5C35.7812 47.5 32.5 50.7812 32.5 55ZM50 55C50 60.4688 45.4688 65 40 65C34.5312 65 30 60.4688 30 55C30 49.5312 34.5312 45 40 45C41.0938 45 42.3438 45.1562 43.2812 45.625L56.4062 19.5312C56.7188 18.9062 57.5 18.5938 58.125 18.9062C58.75 19.2188 58.9062 20 58.5938 20.625L45.625 46.7188C48.2812 48.4375 50 51.5625 50 55ZM25 20C25 21.4062 23.9062 22.5 22.5 22.5C21.0938 22.5 20 21.4062 20 20C20 18.5938 21.0938 17.5 22.5 17.5C23.9062 17.5 25 18.5938 25 20ZM15 40C13.5938 40 12.5 38.9062 12.5 37.5C12.5 36.0938 13.5938 35 15 35C16.4062 35 17.5 36.0938 17.5 37.5C17.5 38.9062 16.4062 40 15 40ZM67.5 37.5C67.5 38.9062 66.4062 40 65 40C63.5938 40 62.5 38.9062 62.5 37.5C62.5 36.0938 63.5938 35 65 35C66.4062 35 67.5 36.0938 67.5 37.5Z"/></svg>',
        'speedometer' => '<svg class="' . $class . '" width="80" height="80" viewBox="0 0 80 80" fill="currentColor" ' . $aria_hidden . ' ' . $aria_label . '><path d="M40 2.5C19.2188 2.5 2.5 19.2188 2.5 40C2.5 60.7812 19.2188 77.5 40 77.5C60.7812 77.5 77.5 60.7812 77.5 40C77.5 19.2188 60.7812 2.5 40 2.5ZM40 80C17.9688 80 0 62.0312 0 40C0 17.9688 17.9688 0 40 0C62.0312 0 80 17.9688 80 40C80 62.0312 62.0312 80 40 80ZM42.5 12.5C42.5 13.9062 41.4062 15 40 15C38.5938 15 37.5 13.9062 37.5 12.5C37.5 11.0938 38.5938 10 40 10C41.4062 10 42.5 11.0938 42.5 12.5ZM32.5 55C32.5 59.2188 35.7812 62.5 40 62.5C44.2188 62.5 47.5 59.2188 47.5 55C47.5 50.7812 44.2188 47.5 40 47.5C35.7812 47.5 32.5 50.7812 32.5 55ZM50 55C50 60.4688 45.4688 65 40 65C34.5312 65 30 60.4688 30 55C30 49.5312 34.5312 45 40 45C41.0938 45 42.3438 45.1562 43.2812 45.625L56.4062 19.5312C56.7188 18.9062 57.5 18.5938 58.125 18.9062C58.75 19.2188 58.9062 20 58.5938 20.625L45.625 46.7188C48.2812 48.4375 50 51.5625 50 55ZM25 20C25 21.4062 23.9062 22.5 22.5 22.5C21.0938 22.5 20 21.4062 20 20C20 18.5938 21.0938 17.5 22.5 17.5C23.9062 17.5 25 18.5938 25 20ZM15 40C13.5938 40 12.5 38.9062 12.5 37.5C12.5 36.0938 13.5938 35 15 35C16.4062 35 17.5 36.0938 17.5 37.5C17.5 38.9062 16.4062 40 15 40ZM67.5 37.5C67.5 38.9062 66.4062 40 65 40C63.5938 40 62.5 38.9062 62.5 37.5C62.5 36.0938 63.5938 35 65 35C66.4062 35 67.5 36.0938 67.5 37.5Z"/></svg>',

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

