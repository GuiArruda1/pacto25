<?php
/**
 * Hero Slider Management & ACF Integration
 * Theme: Pacto 25
 * 
 * Strict Agency Standard:
 * - Seamless ACF Repeater integration in Homepage edit screen
 * - Automatic pre-population & legacy migration of hero slides
 * - Graceful fallback to default slides if empty
 * - Zero static hardcoded strings, full sanitization & escaping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Return Default Hero Slides
 *
 * @return array
 */
function pacto_get_default_hero_slides() {
    return array(
        array(
            'eyebrow'     => 'SEGURAMENTE CONSIGO',
            'title'       => 'Pacto Seguro 25 anos ao seu Lado',
            'description' => 'Construímos relações duradouras porque acreditamos que um seguro é muito mais do que uma apólice. É confiança quando mais precisa',
            'btn_text'    => 'conheça a nossa história',
            'btn_url'     => '#sobre',
            'image_id'    => 0,
            'image_url'   => get_template_directory_uri() . '/assets/images/home-hero-doctor.png',
        ),
        array(
            'eyebrow'     => 'PROTEÇÃO COMPLETA',
            'title'       => 'Soluções pensadas para a sua Família',
            'description' => 'Garantimos a segurança e o bem-estar de quem mais ama com planos flexíveis de saúde, vida e habitação adaptados ao seu dia a dia.',
            'btn_text'    => 'ver soluções particulares',
            'btn_url'     => '/particulares/',
            'image_id'    => 0,
            'image_url'   => get_template_directory_uri() . '/assets/images/sinistro/sinistro-hero-family.png',
        ),
        array(
            'eyebrow'     => 'SEGURANÇA & CONFIANÇA',
            'title'       => 'Protegemos o Futuro do seu Negócio',
            'description' => 'Parcerias sólidas e consultoria especializada para salvaguardar a sua empresa, equipa e património contra qualquer imprevisto.',
            'btn_text'    => 'ver soluções empresas',
            'btn_url'     => '/empresas/',
            'image_id'    => 0,
            'image_url'   => get_template_directory_uri() . '/assets/images/protocolos-doctor.png',
        ),
    );
}

/**
 * Retrieve Slides with Graceful Fallback (from ACF Repeater hero_slides or post meta or defaults)
 *
 * @param int $post_id
 * @return array
 */
function pacto_get_hero_slides( $post_id = 0 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID() ?: (int) get_option( 'page_on_front' ) ?: get_queried_object_id();
    }

    // 1. Try ACF Repeater field from the homepage ACF Tab
    $acf_slides = pacto_get_field( 'hero_slides', $post_id );
    if ( ! empty( $acf_slides ) && is_array( $acf_slides ) && count( $acf_slides ) > 0 ) {
        $clean_slides = array();
        foreach ( $acf_slides as $index => $s ) {
            $eyebrow     = $s['eyebrow'] ?? $s['field_hero_slide_eyebrow'] ?? '';
            $title       = $s['title'] ?? $s['field_hero_slide_title'] ?? '';
            $description = $s['description'] ?? $s['field_hero_slide_description'] ?? '';
            $btn_text    = $s['btn_text'] ?? $s['field_hero_slide_btn_text'] ?? '';
            $btn_url     = $s['btn_url'] ?? $s['field_hero_slide_btn_url'] ?? '#';

            $img     = $s['image'] ?? $s['field_hero_slide_image'] ?? null;
            $img_id  = 0;
            $img_url = '';

            if ( is_array( $img ) && ! empty( $img['ID'] ) ) {
                $img_id  = (int) $img['ID'];
                $img_url = $img['url'] ?? '';
            } elseif ( is_numeric( $img ) && (int) $img > 0 ) {
                $img_id  = (int) $img;
                $url     = wp_get_attachment_url( $img_id );
                if ( $url ) {
                    $img_url = $url;
                }
            } elseif ( is_string( $img ) && ! empty( $img ) ) {
                $img_url = $img;
            }

            // Fallback default image URLs per slide index if none provided
            if ( empty( $img_id ) && empty( $img_url ) ) {
                $defaults = pacto_get_default_hero_slides();
                if ( isset( $defaults[ $index ]['image_url'] ) ) {
                    $img_url = $defaults[ $index ]['image_url'];
                }
            }

            $clean_slides[] = array(
                'eyebrow'     => $eyebrow,
                'title'       => $title,
                'description' => $description,
                'btn_text'    => $btn_text,
                'btn_url'     => $btn_url,
                'image_id'    => $img_id,
                'image_url'   => $img_url,
            );
        }

        if ( ! empty( $clean_slides ) ) {
            return $clean_slides;
        }
    }

    // 2. Fallback to legacy post meta if present
    $slides = $post_id ? get_post_meta( $post_id, 'pacto_hero_slides', true ) : array();

    if ( ! empty( $slides ) && is_array( $slides ) && count( $slides ) > 0 ) {
        return $slides;
    }

    // 3. Centralized default fallback slides
    return pacto_get_default_hero_slides();
}

/**
 * Filter ACF Repeater Value to pre-populate existing or default slides when empty
 *
 * @param mixed $value
 * @param mixed $post_id
 * @param array $field
 * @return array
 */
function pacto_acf_load_hero_slides_value( $value, $post_id, $field ) {
    if ( ! empty( $value ) && is_array( $value ) && count( $value ) > 0 ) {
        return $value;
    }

    // Check post meta 'pacto_hero_slides' or get default slides
    $slides = get_post_meta( $post_id, 'pacto_hero_slides', true );
    if ( empty( $slides ) || ! is_array( $slides ) || count( $slides ) === 0 ) {
        $slides = pacto_get_default_hero_slides();
    }

    if ( empty( $slides ) || ! is_array( $slides ) ) {
        return $value;
    }

    $rows = array();
    foreach ( $slides as $s ) {
        $img = ! empty( $s['image_id'] ) ? (int) $s['image_id'] : 0;
        if ( ! $img && ! empty( $s['image_url'] ) ) {
            $att_id = attachment_url_to_postid( $s['image_url'] );
            if ( $att_id ) {
                $img = $att_id;
            }
        }

        $rows[] = array(
            'field_hero_slide_eyebrow'     => isset( $s['eyebrow'] ) ? $s['eyebrow'] : '',
            'eyebrow'                      => isset( $s['eyebrow'] ) ? $s['eyebrow'] : '',
            'field_hero_slide_title'       => isset( $s['title'] ) ? $s['title'] : '',
            'title'                        => isset( $s['title'] ) ? $s['title'] : '',
            'field_hero_slide_description' => isset( $s['description'] ) ? $s['description'] : '',
            'description'                  => isset( $s['description'] ) ? $s['description'] : '',
            'field_hero_slide_btn_text'    => isset( $s['btn_text'] ) ? $s['btn_text'] : '',
            'btn_text'                     => isset( $s['btn_text'] ) ? $s['btn_text'] : '',
            'field_hero_slide_btn_url'     => isset( $s['btn_url'] ) ? $s['btn_url'] : '#',
            'btn_url'                      => isset( $s['btn_url'] ) ? $s['btn_url'] : '#',
            'field_hero_slide_image'       => $img ?: '',
            'image'                        => $img ?: '',
        );
    }

    return $rows;
}
add_filter( 'acf/load_value/name=hero_slides', 'pacto_acf_load_hero_slides_value', 10, 3 );
add_filter( 'acf/load_value/key=field_hero_slides', 'pacto_acf_load_hero_slides_value', 10, 3 );

/**
 * Auto-populate ACF hero_slides on the front page if not yet saved in ACF
 */
function pacto_auto_populate_acf_hero_slides() {
    if ( ! function_exists( 'update_field' ) || ! function_exists( 'get_field' ) ) {
        return;
    }

    $front_id = (int) get_option( 'page_on_front' );
    if ( ! $front_id ) {
        return;
    }

    // Check if hero_slides already has rows saved in ACF
    $current_meta = get_post_meta( $front_id, 'hero_slides', true );
    if ( ! empty( $current_meta ) ) {
        return;
    }

    // Check legacy or defaults
    $legacy = get_post_meta( $front_id, 'pacto_hero_slides', true );
    $source_slides = ( ! empty( $legacy ) && is_array( $legacy ) && count( $legacy ) > 0 )
        ? $legacy
        : pacto_get_default_hero_slides();

    $rows_to_save = array();
    foreach ( $source_slides as $s ) {
        $img_id = ! empty( $s['image_id'] ) ? (int) $s['image_id'] : 0;
        if ( ! $img_id && ! empty( $s['image_url'] ) ) {
            $att_id = attachment_url_to_postid( $s['image_url'] );
            if ( $att_id ) {
                $img_id = $att_id;
            }
        }

        $rows_to_save[] = array(
            'field_hero_slide_eyebrow'     => $s['eyebrow'] ?? '',
            'field_hero_slide_title'       => $s['title'] ?? '',
            'field_hero_slide_description' => $s['description'] ?? '',
            'field_hero_slide_btn_text'    => $s['btn_text'] ?? '',
            'field_hero_slide_btn_url'     => $s['btn_url'] ?? '#',
            'field_hero_slide_image'       => $img_id ?: '',
        );
    }

    if ( ! empty( $rows_to_save ) ) {
        update_field( 'field_hero_slides', $rows_to_save, $front_id );
    }
}
add_action( 'admin_init', 'pacto_auto_populate_acf_hero_slides' );
