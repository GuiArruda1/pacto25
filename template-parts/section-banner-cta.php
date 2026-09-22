<?php
/**
 * Template Part: Reusable Banner CTA Section ("Temos uma equipa preparada...")
 * Theme: Pacto 25
 * 
 * Strict Agency SOP:
 * - Shared, reusable component for Quem Somos, Particulares, Protocolos, etc.
 * - Dynamic ACF bindings with page-specific overrides & custom $args support
 * - Centered conversion layout with ambient floating red rings and dots
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Check custom $args passed to get_template_part()
$eyebrow  = ! empty( $args['eyebrow'] )  ? $args['eyebrow']  : '';
$title    = ! empty( $args['title'] )    ? $args['title']    : '';
$subtitle = ! empty( $args['subtitle'] ) ? $args['subtitle'] : '';
$btn_text = ! empty( $args['btn_text'] ) ? $args['btn_text'] : '';
$btn_link = ! empty( $args['btn_link'] ) ? $args['btn_link'] : '';

// 2. Fallback to ACF fields if not passed in $args
if ( empty( $eyebrow ) ) {
    $eyebrow = pacto_get_field( 'cta_eyebrow', false, pacto_get_field( 'qs_cta_eyebrow', false, pacto_get_field( 'particulares_cta_eyebrow', false, 'EXPERIMENTE-NOS!' ) ) );
}
if ( empty( $title ) ) {
    $title = pacto_get_field( 'cta_title', false, pacto_get_field( 'qs_cta_title', false, pacto_get_field( 'particulares_cta_title', false, 'Temos uma equipa preparada para responder a todas as suas dúvidas.' ) ) );
}
if ( empty( $subtitle ) ) {
    $subtitle = pacto_get_field( 'cta_subtitle', false, pacto_get_field( 'qs_cta_subtitle', false, pacto_get_field( 'particulares_cta_subtitle', false, 'Convidamo-lo a partilhar as suas experiências para que possamos melhorar produtos e serviços. Faça-nos chegar a sua história.' ) ) );
}
if ( empty( $btn_text ) ) {
    $btn_text = pacto_get_field( 'cta_btn_text', false, pacto_get_field( 'qs_cta_btn_text', false, pacto_get_field( 'particulares_cta_btn_text', false, 'pedir simulação' ) ) );
}
if ( empty( $btn_link ) ) {
    $btn_link = pacto_get_field( 'cta_btn_link', false, pacto_get_field( 'qs_cta_btn_link', false, pacto_get_field( 'particulares_cta_btn_link', false, '#contactos' ) ) );
}
?>

<section class="section section-banner-cta section-qs-cta" aria-label="<?php esc_attr_e( 'Contacte a nossa equipa', 'pacto-25' ); ?>">
    <!-- Ambient Floating Rings and Dots (Exact Figma Layout) -->
    <div class="banner-cta-ring banner-cta-ring--bleed-left qs-cta-ring qs-cta-ring--bleed-left" aria-hidden="true"></div>
    <div class="banner-cta-ring banner-cta-ring--left-mid qs-cta-ring qs-cta-ring--left-mid" aria-hidden="true"></div>
    <div class="banner-cta-dot banner-cta-dot--center-left qs-cta-dot qs-cta-dot--center-left" aria-hidden="true"></div>
    <div class="banner-cta-ring banner-cta-ring--right-large qs-cta-ring qs-cta-ring--right-large" aria-hidden="true"></div>
    <div class="banner-cta-ring banner-cta-ring--right-small qs-cta-ring qs-cta-ring--right-small" aria-hidden="true"></div>
    <div class="banner-cta-ring banner-cta-ring--top-right qs-cta-ring qs-cta-ring--top-right" aria-hidden="true"></div>

    <div class="site-container">
        <div class="section-banner-cta__content section-qs-cta__content">
            <?php if ( $eyebrow ) : ?>
                <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>

            <?php if ( $title ) : ?>
                <h2 class="h2 section-banner-cta__title section-qs-cta__title"><?php echo esc_html( $title ); ?></h2>
            <?php endif; ?>

            <?php if ( $subtitle ) : ?>
                <p class="section-banner-cta__subtitle section-qs-cta__subtitle"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>

            <?php if ( $btn_text ) : ?>
                <div class="section-banner-cta__btn-wrap section-qs-cta__btn-wrap">
                    <a href="<?php echo esc_url( $btn_link ); ?>" class="btn btn--dark section-banner-cta__btn section-qs-cta__btn">
                        <span><?php echo esc_html( $btn_text ); ?></span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
