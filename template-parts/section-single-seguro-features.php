<?php
/**
 * Template Part: Single Seguro Particular - "Vantagens, Coberturas e Serviços" Section
 * Theme: Pacto 25
 * Strict Agency SOP: Dynamic ACF bindings, reusable giant right red circle feature container, floating ambient dots.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id     = get_the_ID();
$post_title  = get_the_title();

$eyebrow     = pacto_get_field( 'seguro_features_eyebrow', $post_id, strtoupper( $post_title ) . ' — PACTO SEGURO' );
$title       = pacto_get_field( 'seguro_features_title', $post_id, 'Vantagens, Coberturas e Serviços' );

$p1          = pacto_get_field( 'seguro_features_p1', $post_id, 'Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );
$p2          = pacto_get_field( 'seguro_features_p2', $post_id, 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );
$p3          = pacto_get_field( 'seguro_features_p3', $post_id, 'Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );

$btn_text    = pacto_get_field( 'seguro_features_btn_text', $post_id, 'pedir simulação' );
$btn_link    = pacto_get_field( 'seguro_features_btn_link', $post_id, '#simulacao' );

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

$cards = pacto_get_field( 'seguro_features_cards', $post_id, $default_cards );
if ( ! is_array( $cards ) || empty( $cards ) ) {
    $cards = $default_cards;
}
?>

<section class="section section-single-seguro-features" aria-label="<?php echo esc_attr( $title ); ?>">
    <!-- Top Ambient Floating Red Dots -->
    <div class="seguro-features-dot seguro-features-dot--top-1" aria-hidden="true"></div>
    <div class="seguro-features-dot seguro-features-dot--top-2" aria-hidden="true"></div>
    <div class="seguro-features-dot seguro-features-dot--top-3" aria-hidden="true"></div>

    <!-- Bottom Ambient Floating Red Dots -->
    <div class="seguro-features-dot seguro-features-dot--bot-1" aria-hidden="true"></div>
    <div class="seguro-features-dot seguro-features-dot--bot-2" aria-hidden="true"></div>
    <div class="seguro-features-dot seguro-features-dot--bot-3" aria-hidden="true"></div>

    <!-- Giant Red Circle Canopy on Right -->
    <div class="seguro-features-canopy" aria-hidden="true"></div>

    <div class="site-container seguro-features-container">
        <div class="section-single-seguro-features__layout">
            <!-- Left Narrative Column -->
            <div class="section-single-seguro-features__narrative">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h2 class="h2 section-single-seguro-features__title"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <div class="section-single-seguro-features__paragraphs">
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

                <?php if ( $btn_text ) : ?>
                    <div class="section-single-seguro-features__btn-wrap">
                        <a href="<?php echo esc_url( $btn_link ); ?>" class="btn btn--dark section-single-seguro-features__btn">
                            <span><?php echo esc_html( $btn_text ); ?></span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Feature Cards Grid & Navigation inside Giant Red Circle -->
            <div class="section-single-seguro-features__cards-wrap">
                <div class="seguro-features-cards-grid">
                    <?php foreach ( $cards as $card ) : 
                        $card_icon  = ! empty( $card['icon'] ) ? $card['icon'] : 'heart-check';
                        $card_title = ! empty( $card['title'] ) ? $card['title'] : '';
                        $card_desc  = ! empty( $card['description'] ) ? $card['description'] : '';
                    ?>
                        <div class="seguro-feature-card">
                            <div class="seguro-feature-card__icon" aria-hidden="true">
                                <?php echo pacto_get_svg( $card_icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </div>
                            <h3 class="seguro-feature-card__title"><?php echo esc_html( $card_title ); ?></h3>
                            <p class="seguro-feature-card__desc"><?php echo esc_html( $card_desc ); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Navigation Arrows -->
                <div class="seguro-features-nav" aria-hidden="true">
                    <button type="button" class="seguro-features-nav__btn seguro-features-nav__btn--prev" aria-label="<?php esc_attr_e( 'Anterior', 'pacto-25' ); ?>">
                        <?php echo pacto_get_svg( 'chevron-left' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </button>
                    <button type="button" class="seguro-features-nav__btn seguro-features-nav__btn--next" aria-label="<?php esc_attr_e( 'Seguinte', 'pacto-25' ); ?>">
                        <?php echo pacto_get_svg( 'chevron-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
