<?php
/**
 * Template Part: Quem Somos - Porquê escolher-nos Section
 * Theme: Pacto 25
 * Strict Agency SOP: Fully decoupled via ACF, interactive carousel/grid inside red circular container.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page_id = get_the_ID() ?: get_queried_object_id();
if ( ! $page_id ) {
    $qs_page = get_page_by_path( 'quem-somos' ) ?: get_page_by_path( 'institucional' );
    if ( $qs_page ) {
        $page_id = $qs_page->ID;
    }
}

$eyebrow     = pacto_clean_eyebrow( pacto_get_field( 'qs_reasons_eyebrow', $page_id, 'SEGURAMENTE CONSIGO' ) );
$title       = pacto_get_field( 'qs_reasons_title', $page_id, 'Porquê escolher-nos' );
$paragraph_1 = pacto_get_field( 'qs_reasons_p1', $page_id, 'Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );
$paragraph_2 = pacto_get_field( 'qs_reasons_p2', $page_id, 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );
$paragraph_3 = pacto_get_field( 'qs_reasons_p3', $page_id, 'Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );

// Default feature cards
$default_cards = array(
    array(
        'icon'        => 'heart-check',
        'title'       => 'Simples e Fácil',
        'description' => 'Connosco pode subscrever um seguro rápido e sem complicações. Comunicamos de forma clara e objetiva.',
    ),
    array(
        'icon'        => 'clock-check',
        'title'       => 'Rápidos',
        'description' => 'Simulamos e emitimos um seguro em menos de 10 minutos.',
    ),
    array(
        'icon'        => 'heart-check',
        'title'       => 'Simples e Fácil',
        'description' => 'Connosco pode subscrever um seguro rápido e sem complicações. Comunicamos de forma clara e objetiva.',
    ),
    array(
        'icon'        => 'clock-check',
        'title'       => 'Rápidos',
        'description' => 'Simulamos e emitimos um seguro em menos de 10 minutos.',
    ),
);

$cards = pacto_get_field( 'qs_reasons_cards', $page_id, $default_cards );
if ( ! is_array( $cards ) || empty( $cards ) ) {
    $cards = $default_cards;
}
?>

<section class="section section-qs-reasons" aria-label="<?php esc_attr_e( 'Porquê escolher-nos', 'pacto-25' ); ?>">
    <!-- 3 Ambient Floating Dots above Narrative -->
    <div class="qs-reasons-dot qs-reasons-dot--1" aria-hidden="true"></div>
    <div class="qs-reasons-dot qs-reasons-dot--2" aria-hidden="true"></div>
    <div class="qs-reasons-dot qs-reasons-dot--3" aria-hidden="true"></div>

    <!-- Giant 1600x1600 Red Circle Canopy on Right (Exact Figma 1600x1600 Specification) -->
    <div class="qs-reasons-canopy" aria-hidden="true"></div>

    <div class="site-container qs-reasons-container">
        <div class="section-qs-reasons__layout">
            <!-- Left Narrative Column -->
            <div class="section-qs-reasons__narrative">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h2 class="h2 section-qs-reasons__title"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <div class="section-qs-reasons__paragraphs">
                    <?php if ( $paragraph_1 ) : ?>
                        <p><?php echo esc_html( $paragraph_1 ); ?></p>
                    <?php endif; ?>

                    <?php if ( $paragraph_2 ) : ?>
                        <p><?php echo esc_html( $paragraph_2 ); ?></p>
                    <?php endif; ?>

                    <?php if ( $paragraph_3 ) : ?>
                        <p><?php echo esc_html( $paragraph_3 ); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Column: Feature Cards Grid & Nav inside the 1600x1600 Red Circle -->
            <div class="section-qs-reasons__cards-wrap">
                <div class="qs-reasons-cards-grid">
                    <?php foreach ( $cards as $card ) : 
                        $card_icon   = ! empty( $card['icon'] ) ? $card['icon'] : 'heart-check';
                        $card_custom = ! empty( $card['custom_icon'] ) ? $card['custom_icon'] : '';
                        $card_title  = ! empty( $card['title'] ) ? $card['title'] : '';
                        $card_desc   = ! empty( $card['description'] ) ? $card['description'] : '';
                        $card_link   = ! empty( $card['link'] ) ? $card['link'] : '';

                        $tag         = ! empty( $card_link ) ? 'a' : 'div';
                        $link_attr   = ! empty( $card_link ) ? ' href="' . esc_url( $card_link ) . '"' : '';
                        $link_class  = ! empty( $card_link ) ? ' qs-reason-card--link' : '';
                    ?>
                        <<?php echo $tag; ?> class="qs-reason-card<?php echo esc_attr( $link_class ); ?>"<?php echo $link_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                            <div class="qs-reason-card__icon" aria-hidden="true">
                                <?php 
                                if ( ! empty( $card_custom ) ) {
                                    if ( is_numeric( $card_custom ) ) {
                                        echo wp_get_attachment_image( (int) $card_custom, 'thumbnail', false, array( 'class' => 'qs-reason-card__icon-img' ) );
                                    } else {
                                        echo '<img src="' . esc_url( $card_custom ) . '" alt="" class="qs-reason-card__icon-img" />';
                                    }
                                } else {
                                    echo pacto_get_svg( $card_icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                }
                                ?>
                            </div>
                            <?php if ( $card_title ) : ?>
                                <h3 class="qs-reason-card__title"><?php echo esc_html( $card_title ); ?></h3>
                            <?php endif; ?>
                            <?php if ( $card_desc ) : ?>
                                <p class="qs-reason-card__desc"><?php echo esc_html( $card_desc ); ?></p>
                            <?php endif; ?>
                        </<?php echo $tag; ?>>
                    <?php endforeach; ?>
                </div>

                <!-- Navigation Arrows -->
                <div class="qs-reasons-nav" aria-hidden="true">
                    <button type="button" class="qs-reasons-nav__btn qs-reasons-nav__btn--prev" aria-label="<?php esc_attr_e( 'Anterior', 'pacto-25' ); ?>">
                        <?php echo pacto_get_svg( 'chevron-left' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </button>
                    <button type="button" class="qs-reasons-nav__btn qs-reasons-nav__btn--next" aria-label="<?php esc_attr_e( 'Seguinte', 'pacto-25' ); ?>">
                        <?php echo pacto_get_svg( 'chevron-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
