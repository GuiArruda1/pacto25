<?php
/**
 * Template Part: Section Protocolos CTA
 * Theme: Pacto 25
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page_id = get_the_ID();

$eyebrow   = pacto_get_field( 'protocolos_cta_eyebrow', $page_id, 'FALE COM UM DE NÓS' );
$title     = pacto_get_field( 'protocolos_cta_title', $page_id, 'Temos uma equipa preparada para responder a todas as suas dúvidas.' );
$text      = pacto_get_field( 'protocolos_cta_text', $page_id, 'Com décadas de experiência, os nossos consultores garantem um acompanhamento ágil e profissional.' );
$btn_text  = pacto_get_field( 'protocolos_cta_btn_text', $page_id, 'Contacte-nos' );
$btn_url   = pacto_get_field( 'protocolos_cta_btn_url', $page_id, '/contactos/' );
?>

<section class="section section-protocolos-cta" aria-label="<?php echo esc_attr( $title ); ?>">
    <!-- Decorative Rings -->
    <div class="protocolos-cta-ring-1" aria-hidden="true"></div>
    <div class="protocolos-cta-ring-2" aria-hidden="true"></div>
    <div class="protocolos-cta-ring-3" aria-hidden="true"></div>
    <div class="protocolos-cta-ring-4" aria-hidden="true"></div>
    <div class="protocolos-cta-ring-5" aria-hidden="true"></div>
    <div class="protocolos-cta-ring-6" aria-hidden="true"></div>

    <div class="site-container">
        <div class="protocolos-cta-content">
            <?php if ( $eyebrow ) : ?>
                <span class="protocolos-cta-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>
            
            <h2 class="h2 protocolos-cta-title"><?php echo esc_html( $title ); ?></h2>
            
            <?php if ( $text ) : ?>
                <div class="protocolos-cta-text">
                    <p><?php echo wp_kses_post( $text ); ?></p>
                </div>
            <?php endif; ?>
            
            <?php if ( $btn_text && $btn_url ) : ?>
                <a href="<?php echo esc_url( $btn_url ); ?>" class="protocolos-cta-btn"><?php echo esc_html( $btn_text ); ?></a>
            <?php endif; ?>
        </div>
    </div>
</section>
