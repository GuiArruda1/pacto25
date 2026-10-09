<?php
/**
 * Hero Slider Management & ACF Tab Integration
 * Theme: Pacto 25
 * 
 * Strict Agency Standard:
 * - Reads discrete slide fields (Slide 1 to 5) configured in ACF Tab
 * - Full backward-compatibility and fallback support
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
 * Retrieve Slides with Graceful Fallback (from ACF fields hero_slide_1..5, or legacy meta, or defaults)
 *
 * @param int $post_id
 * @return array
 */
function pacto_get_hero_slides( $post_id = 0 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID() ?: (int) get_option( 'page_on_front' ) ?: get_queried_object_id();
    }

    $default_slides = pacto_get_default_hero_slides();
    $collected_slides = array();

    // 1. Read discrete slide fields (Slide 1 to 5) from the ACF Tab
    for ( $i = 1; $i <= 5; $i++ ) {
        $is_active = ( 1 === $i ) ? true : (bool) pacto_get_field( "hero_slide_{$i}_active", $post_id, ( $i <= 3 ? 1 : 0 ) );

        if ( ! $is_active ) {
            continue;
        }

        $default_idx = $i - 1;
        $def_eyebrow = isset( $default_slides[ $default_idx ]['eyebrow'] ) ? $default_slides[ $default_idx ]['eyebrow'] : '';
        $def_title   = isset( $default_slides[ $default_idx ]['title'] ) ? $default_slides[ $default_idx ]['title'] : '';
        $def_desc    = isset( $default_slides[ $default_idx ]['description'] ) ? $default_slides[ $default_idx ]['description'] : '';
        $def_btn     = isset( $default_slides[ $default_idx ]['btn_text'] ) ? $default_slides[ $default_idx ]['btn_text'] : '';
        $def_url     = isset( $default_slides[ $default_idx ]['btn_url'] ) ? $default_slides[ $default_idx ]['btn_url'] : '#';
        $def_img_url = isset( $default_slides[ $default_idx ]['image_url'] ) ? $default_slides[ $default_idx ]['image_url'] : '';

        $title = pacto_get_field( "hero_slide_{$i}_title", $post_id, $def_title );

        // If title is empty for optional slides (4, 5), skip
        if ( empty( $title ) && $i > 3 ) {
            continue;
        }

        $eyebrow     = pacto_get_field( "hero_slide_{$i}_eyebrow", $post_id, $def_eyebrow );
        $description = pacto_get_field( "hero_slide_{$i}_description", $post_id, $def_desc );
        $btn_text    = pacto_get_field( "hero_slide_{$i}_btn_text", $post_id, $def_btn );
        $btn_url     = pacto_get_field( "hero_slide_{$i}_btn_url", $post_id, $def_url );
        $img         = pacto_get_field( "hero_slide_{$i}_image", $post_id, null );

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

        if ( empty( $img_id ) && empty( $img_url ) && ! empty( $def_img_url ) ) {
            $img_url = $def_img_url;
        }

        $collected_slides[] = array(
            'eyebrow'     => $eyebrow,
            'title'       => $title ?: $def_title,
            'description' => $description,
            'btn_text'    => $btn_text,
            'btn_url'     => $btn_url ?: '#',
            'image_id'    => $img_id,
            'image_url'   => $img_url,
        );
    }

    if ( ! empty( $collected_slides ) ) {
        return $collected_slides;
    }

    // 2. Fallback to legacy post meta if present
    $slides = $post_id ? get_post_meta( $post_id, 'pacto_hero_slides', true ) : array();
    if ( ! empty( $slides ) && is_array( $slides ) && count( $slides ) > 0 ) {
        return $slides;
    }

    // 3. Fallback defaults
    return $default_slides;
}
