<?php
/**
 * SVG Media Upload & Display Support
 * Theme: Pacto 25
 * 
 * Safely unlocks SVG file uploads in WordPress media library, fixes MIME detection,
 * handles viewBox dimensions, and renders previews in WP Admin & ACF.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Allow SVG MIME types in WordPress upload list.
 */
function pacto_enable_svg_upload_mimes( $mimes ) {
    $mimes['svg']  = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'pacto_enable_svg_upload_mimes' );

/**
 * Bypass WordPress strict real-mime check failure for SVGs in WP 5.0+.
 */
function pacto_fix_svg_filetype_and_ext( $data, $file, $filename, $mimes ) {
    $ext = pathinfo( $filename, PATHINFO_EXTENSION );

    if ( 'svg' === strtolower( $ext ) ) {
        $data['ext']  = 'svg';
        $data['type'] = 'image/svg+xml';
    } elseif ( 'svgz' === strtolower( $ext ) ) {
        $data['ext']  = 'svgz';
        $data['type'] = 'image/svg+xml';
    }

    return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'pacto_fix_svg_filetype_and_ext', 10, 4 );

/**
 * Extract SVG dimensions from viewBox or width/height attributes for media metadata.
 */
function pacto_svg_meta_dimensions( $metadata, $attachment_id ) {
    $mime = get_post_mime_type( $attachment_id );

    if ( 'image/svg+xml' === $mime ) {
        $file = get_attached_file( $attachment_id );
        if ( file_exists( $file ) && ( empty( $metadata['width'] ) || empty( $metadata['height'] ) ) ) {
            $xml = @simplexml_load_file( $file );
            if ( $xml ) {
                $attrs  = $xml->attributes();
                $width  = (string) $attrs->width;
                $height = (string) $attrs->height;

                if ( ( empty( $width ) || empty( $height ) ) && isset( $attrs->viewBox ) ) {
                    $viewbox = preg_split( '/[\s,]+/', (string) $attrs->viewBox );
                    if ( count( $viewbox ) === 4 ) {
                        $width  = $viewbox[2];
                        $height = $viewbox[3];
                    }
                }

                $metadata['width']  = intval( $width ) ?: 600;
                $metadata['height'] = intval( $height ) ?: 600;
            }
        }
    }

    return $metadata;
}
add_filter( 'wp_get_attachment_metadata', 'pacto_svg_meta_dimensions', 10, 2 );

/**
 * Fix SVG preview rendering in WordPress Admin Media Library and ACF Image fields.
 */
function pacto_svg_admin_preview_css() {
    echo '<style>
        /* Media Library Grid & Modal Previews */
        .attachment-266x266,
        .thumbnail img[src$=".svg"],
        .media-icon img[src$=".svg"],
        img[src$=".svg"].attachment-post-thumbnail {
            width: 100% !important;
            height: auto !important;
        }
        /* ACF Image Uploader Preview */
        .acf-image-uploader img[src$=".svg"] {
            width: auto !important;
            height: auto !important;
            max-width: 100% !important;
            max-height: 140px !important;
            object-fit: contain !important;
        }
    </style>';
}
add_action( 'admin_head', 'pacto_svg_admin_preview_css' );
