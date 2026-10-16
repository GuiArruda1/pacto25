<?php
/**
 * Component: Porquê escolher-nos / Vantagens, Coberturas e Serviços Slider
 * Theme: Pacto 25
 * 
 * Reusable component for:
 * - Quem Somos (Institucional)
 * - Single Seguro Particular & Seguro Empresa
 * - Landing Page (Modelo Seguro)
 *
 * Strict Agency SOP: Fully decoupled via ACF, accessible vanilla JS carousel, zero hardcoded content.
 *
 * @param array $args Component arguments:
 *   - 'context'        : 'quem-somos' | 'single-seguro' | 'landing' | 'auto'
 *   - 'post_id'        : Specific post ID (defaults to current queried object or Quem Somos page)
 *   - 'eyebrow'        : Custom eyebrow override
 *   - 'title'          : Custom title override
 *   - 'p1', 'p2', 'p3' : Custom paragraphs override
 *   - 'btn_text'       : CTA button text (optional)
 *   - 'btn_link'       : CTA button URL (optional)
 *   - 'cards'          : Custom cards array override
 *   - 'show_dots'      : Whether to display ambient floating dots (default true)
 *   - 'section_class'  : Extra section class names
 *   - 'section_id'     : Optional HTML id attribute
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$args = isset( $args ) && is_array( $args ) ? $args : array();

// 1. Determine Context and Post ID
$context = ! empty( $args['context'] ) ? $args['context'] : 'auto';
$post_id = ! empty( $args['post_id'] ) ? (int) $args['post_id'] : ( get_the_ID() ?: get_queried_object_id() );

if ( 'auto' === $context ) {
    if ( is_page_template( 'page-quem-somos.php' ) || is_page( 'quem-somos' ) || is_page( 'institucional' ) || is_page( 'sobre' ) ) {
        $context = 'quem-somos';
    } elseif ( is_singular( 'seguro_particular' ) || is_singular( 'seguro_empresa' ) ) {
        $context = 'single-seguro';
    } elseif ( is_page_template( 'page-landing.php' ) || is_page( 'landing' ) || is_page( 'modelo-seguro' ) ) {
        $context = 'landing';
    } else {
        $context = 'quem-somos';
    }
}

if ( 'quem-somos' === $context && ! $post_id ) {
    $qs_page = get_page_by_path( 'quem-somos' ) ?: get_page_by_path( 'institucional' );
    if ( $qs_page ) {
        $post_id = $qs_page->ID;
    }
}

// 2. Default 8 Feature Cards (2 full slides of 4 cards each for interactive carousel)
$default_cards = array(
    // Slide 1
    array(
        'icon'        => 'heart-check',
        'title'       => 'Simples e Fácil',
        'description' => 'Connosco pode subscrever um seguro rápido e sem complicações. Comunicamos de forma clara e objetiva.',
        'link'        => '',
    ),
    array(
        'icon'        => 'clock-check',
        'title'       => 'Rápidos',
        'description' => 'Simulamos e emitimos um seguro em menos de 10 minutos.',
        'link'        => '',
    ),
    array(
        'icon'        => 'heart-check',
        'title'       => 'Seguro à Medida',
        'description' => 'Adaptamos cada solução e cobertura às necessidades específicas da sua vida e da sua família.',
        'link'        => '',
    ),
    array(
        'icon'        => 'clock-check',
        'title'       => 'Confiança & Rigor',
        'description' => 'Mais de 25 anos de experiência e solidez no setor, com acompanhamento próximo em cada etapa.',
        'link'        => '',
    ),
    // Slide 2
    array(
        'icon'        => 'heart-check',
        'title'       => 'Transparência Total',
        'description' => 'Sem letras pequenas nem surpresas. Condições transparentes e rigorosas em todas as fases.',
        'link'        => '',
    ),
    array(
        'icon'        => 'clock-check',
        'title'       => 'Apoio Contínuo',
        'description' => 'Linha dedicada para esclarecimento de dúvidas e resolução ágil e proativa de sinistros.',
        'link'        => '',
    ),
    array(
        'icon'        => 'heart-check',
        'title'       => 'Soluções Integradas',
        'description' => 'Parcerias com as maiores seguradoras do mercado para garantir as melhores condições e garantias.',
        'link'        => '',
    ),
    array(
        'icon'        => 'clock-check',
        'title'       => 'Proximidade Humana',
        'description' => 'Uma equipa experiente sempre acessível e disponível para lhe dar total tranquilidade no dia a dia.',
        'link'        => '',
    ),
);

// 3. Resolve Content based on Context or Overrides
if ( 'single-seguro' === $context || 'landing' === $context ) {
    $clean_name = get_the_title( $post_id );
    if ( empty( $clean_name ) || stripos( $clean_name, 'landing' ) !== false || stripos( $clean_name, 'modelo' ) !== false ) {
        $clean_name = 'Seguro Multirriscos Casa';
    }

    $default_eyebrow = strtoupper( $clean_name ) . ' — PACTO SEGURO';
    $default_title   = 'Vantagens, Coberturas e Serviços';

    $eyebrow  = isset( $args['eyebrow'] ) ? $args['eyebrow'] : pacto_get_field( 'seguro_features_eyebrow', $post_id, $default_eyebrow );
    $title    = isset( $args['title'] ) ? $args['title'] : pacto_get_field( 'seguro_features_title', $post_id, $default_title );
    $p1       = isset( $args['p1'] ) ? $args['p1'] : pacto_get_field( 'seguro_features_p1', $post_id, 'Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );
    $p2       = isset( $args['p2'] ) ? $args['p2'] : pacto_get_field( 'seguro_features_p2', $post_id, 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );
    $p3       = isset( $args['p3'] ) ? $args['p3'] : pacto_get_field( 'seguro_features_p3', $post_id, 'Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );
    $btn_text = isset( $args['btn_text'] ) ? $args['btn_text'] : pacto_get_field( 'seguro_features_btn_text', $post_id, 'pedir simulação' );
    $btn_link = isset( $args['btn_link'] ) ? $args['btn_link'] : pacto_get_field( 'seguro_features_btn_link', $post_id, '#simulacao' );

    $cards    = isset( $args['cards'] ) ? $args['cards'] : pacto_get_field( 'seguro_features_cards', $post_id, null );
    if ( ! is_array( $cards ) || empty( $cards ) ) {
        // Fallback to qs_reasons_cards if set, or default cards
        $cards = pacto_get_field( 'qs_reasons_cards', $post_id, $default_cards );
    }
} else {
    // Quem Somos / Generic Context
    $eyebrow  = isset( $args['eyebrow'] ) ? $args['eyebrow'] : pacto_clean_eyebrow( pacto_get_field( 'qs_reasons_eyebrow', $post_id, 'SEGURAMENTE CONSIGO' ) );
    $title    = isset( $args['title'] ) ? $args['title'] : pacto_get_field( 'qs_reasons_title', $post_id, 'Porquê escolher-nos' );
    $p1       = isset( $args['p1'] ) ? $args['p1'] : pacto_get_field( 'qs_reasons_p1', $post_id, 'Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );
    $p2       = isset( $args['p2'] ) ? $args['p2'] : pacto_get_field( 'qs_reasons_p2', $post_id, 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );
    $p3       = isset( $args['p3'] ) ? $args['p3'] : pacto_get_field( 'qs_reasons_p3', $post_id, 'Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );
    $btn_text = isset( $args['btn_text'] ) ? $args['btn_text'] : pacto_get_field( 'qs_reasons_btn_text', $post_id, '' );
    $btn_link = isset( $args['btn_link'] ) ? $args['btn_link'] : pacto_get_field( 'qs_reasons_btn_link', $post_id, '' );

    $cards    = isset( $args['cards'] ) ? $args['cards'] : pacto_get_field( 'qs_reasons_cards', $post_id, $default_cards );
}

if ( ! is_array( $cards ) || empty( $cards ) ) {
    $cards = $default_cards;
}

// 4. Chunk cards into 4 per slide (matching exact Figma 2x2 grid layout)
$card_slides = array_chunk( $cards, 4 );
$total_slides = count( $card_slides );

// 5. Classes and IDs
$show_dots      = isset( $args['show_dots'] ) ? (bool) $args['show_dots'] : true;
$extra_class    = ! empty( $args['section_class'] ) ? ' ' . esc_attr( $args['section_class'] ) : '';
$section_id_attr = ! empty( $args['section_id'] ) ? ' id="' . esc_attr( $args['section_id'] ) . '"' : '';

$context_class  = 'quem-somos' === $context ? 'section-qs-reasons' : 'section-single-seguro-features';
?>

<section class="section section-reasons <?php echo esc_attr( $context_class . $extra_class ); ?>"<?php echo $section_id_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> aria-label="<?php echo esc_attr( $title ); ?>">
    <?php if ( $show_dots ) : ?>
        <!-- Ambient Floating Red Dots -->
        <div class="reasons-dot reasons-dot--1 qs-reasons-dot qs-reasons-dot--1 seguro-features-dot seguro-features-dot--top-1" aria-hidden="true"></div>
        <div class="reasons-dot reasons-dot--2 qs-reasons-dot qs-reasons-dot--2 seguro-features-dot seguro-features-dot--top-2" aria-hidden="true"></div>
        <div class="reasons-dot reasons-dot--3 qs-reasons-dot qs-reasons-dot--3 seguro-features-dot seguro-features-dot--top-3" aria-hidden="true"></div>
        <?php if ( 'single-seguro' === $context || 'landing' === $context ) : ?>
            <div class="seguro-features-dot seguro-features-dot--bot-1" aria-hidden="true"></div>
            <div class="seguro-features-dot seguro-features-dot--bot-2" aria-hidden="true"></div>
            <div class="seguro-features-dot seguro-features-dot--bot-3" aria-hidden="true"></div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Giant 1600x1600 Red Circle Canopy on Right (Exact Figma Specification) -->
    <div class="reasons-canopy qs-reasons-canopy seguro-features-canopy" aria-hidden="true"></div>

    <div class="site-container reasons-container qs-reasons-container seguro-features-container">
        <div class="section-reasons__layout section-qs-reasons__layout section-single-seguro-features__layout">
            <!-- Left Narrative Column -->
            <div class="section-reasons__narrative section-qs-reasons__narrative section-single-seguro-features__narrative">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h2 class="h2 section-reasons__title section-qs-reasons__title section-single-seguro-features__title"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <div class="section-reasons__paragraphs section-qs-reasons__paragraphs section-single-seguro-features__paragraphs">
                    <?php if ( $p1 ) : ?>
                        <p><?php echo esc_html( $p1 ); ?></p>
                    <?php endif; ?>

                    <?php if ( $p2 ) : ?>
                        <p><?php echo esc_html( $p2 ); ?></p>
                    <?php endif; ?>

                    <?php if ( $p3 ) : ?>
                        <p><?php echo esc_html( $p3 ); ?></p>
                    <?php endif; ?>
                </div>

                <?php if ( ! empty( $btn_text ) ) : ?>
                    <div class="section-reasons__btn-wrap section-single-seguro-features__btn-wrap">
                        <a href="<?php echo esc_url( $btn_link ?: '#' ); ?>" class="btn btn--dark section-reasons__btn section-single-seguro-features__btn">
                            <span><?php echo esc_html( $btn_text ); ?></span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column: Interactive Reasons Carousel inside Giant Red Circle -->
            <div class="section-reasons__cards-wrap section-qs-reasons__cards-wrap section-single-seguro-features__cards-wrap">
                <div class="pacto-reasons-slider qs-reasons-slider seguro-features-slider" data-reasons-slider data-total-slides="<?php echo (int) $total_slides; ?>">
                    <div class="pacto-reasons-slider__track qs-reasons-slider-track seguro-features-slider-track">
                        <?php foreach ( $card_slides as $slide_idx => $slide_cards ) : ?>
                            <div class="pacto-reasons-slide qs-reasons-slide seguro-features-slide <?php echo 0 === $slide_idx ? 'is-active' : ''; ?>" data-slide-index="<?php echo (int) $slide_idx; ?>" role="group" aria-roledescription="slide" aria-label="<?php echo esc_attr( sprintf( __( 'Slide %1$d de %2$d', 'pacto-25' ), $slide_idx + 1, $total_slides ) ); ?>" <?php echo 0 === $slide_idx ? 'aria-hidden="false"' : 'aria-hidden="true"'; ?>>
                                <div class="pacto-reasons-cards-grid qs-reasons-cards-grid seguro-features-cards-grid">
                                    <?php foreach ( $slide_cards as $card ) : 
                                        $card_icon   = ! empty( $card['icon'] ) ? $card['icon'] : 'heart-check';
                                        $card_custom = ! empty( $card['custom_icon'] ) ? $card['custom_icon'] : '';
                                        $card_title  = ! empty( $card['title'] ) ? $card['title'] : '';
                                        $card_desc   = ! empty( $card['description'] ) ? $card['description'] : '';
                                        $card_link   = ! empty( $card['link'] ) ? $card['link'] : '';

                                        $tag        = ! empty( $card_link ) ? 'a' : 'div';
                                        $link_attr  = ! empty( $card_link ) ? ' href="' . esc_url( $card_link ) . '"' : '';
                                        $link_class = ! empty( $card_link ) ? ' pacto-reason-card--link qs-reason-card--link seguro-feature-card--link' : '';
                                    ?>
                                        <<?php echo $tag; ?> class="pacto-reason-card qs-reason-card seguro-feature-card<?php echo esc_attr( $link_class ); ?>"<?php echo $link_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                                            <div class="pacto-reason-card__icon qs-reason-card__icon seguro-feature-card__icon" aria-hidden="true">
                                                <?php 
                                                if ( ! empty( $card_custom ) ) {
                                                    if ( is_numeric( $card_custom ) ) {
                                                        echo wp_get_attachment_image( (int) $card_custom, 'thumbnail', false, array( 'class' => 'pacto-reason-card__icon-img qs-reason-card__icon-img' ) );
                                                    } else {
                                                        echo '<img src="' . esc_url( $card_custom ) . '" alt="" class="pacto-reason-card__icon-img qs-reason-card__icon-img" />';
                                                    }
                                                } else {
                                                    echo pacto_get_svg( $card_icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                }
                                                ?>
                                            </div>
                                            <?php if ( $card_title ) : ?>
                                                <h3 class="pacto-reason-card__title qs-reason-card__title seguro-feature-card__title"><?php echo esc_html( $card_title ); ?></h3>
                                            <?php endif; ?>
                                            <?php if ( $card_desc ) : ?>
                                                <p class="pacto-reason-card__desc qs-reason-card__desc seguro-feature-card__desc"><?php echo esc_html( $card_desc ); ?></p>
                                            <?php endif; ?>
                                        </<?php echo $tag; ?>>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Navigation Arrows -->
                    <div class="pacto-reasons-nav qs-reasons-nav seguro-features-nav" <?php echo $total_slides <= 1 ? 'style="display:none;"' : ''; ?> aria-label="<?php esc_attr_e( 'Navegação de destaques', 'pacto-25' ); ?>">
                        <button type="button" class="pacto-reasons-nav__btn qs-reasons-nav__btn seguro-features-nav__btn pacto-reasons-nav__btn--prev qs-reasons-nav__btn--prev seguro-features-nav__btn--prev" data-reasons-action="prev" aria-label="<?php esc_attr_e( 'Anterior', 'pacto-25' ); ?>">
                            <?php echo pacto_get_svg( 'chevron-left' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </button>
                        <button type="button" class="pacto-reasons-nav__btn qs-reasons-nav__btn seguro-features-nav__btn pacto-reasons-nav__btn--next qs-reasons-nav__btn--next seguro-features-nav__btn--next" data-reasons-action="next" aria-label="<?php esc_attr_e( 'Seguinte', 'pacto-25' ); ?>">
                            <?php echo pacto_get_svg( 'chevron-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
