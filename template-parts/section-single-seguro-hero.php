<?php
/**
 * Template Part: Single Seguro Particular - Hero Section
 * Theme: Pacto 25
 * Strict Agency SOP: Dynamic ACF bindings, right-bleed large circular frame with red border, floating accent dot.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id     = get_the_ID();
$post_title  = get_the_title();

$eyebrow     = pacto_get_field( 'seguro_hero_eyebrow', $post_id, strtoupper( $post_title ) . ' — PACTO SEGURO' );
$title       = pacto_get_field( 'seguro_hero_title', $post_id, 'Encontre o melhor ' . $post_title . ' para a sua casa.' );
$description = pacto_get_field( 'seguro_hero_description', $post_id, get_the_excerpt( $post_id ) );

if ( empty( $description ) ) {
    $description = 'Um Seguro Multirriscos para a casa é uma opção muito completa de seguro que cobre vários riscos que podem afetar o seu imóvel e o seu recheio. Inclui cobertura para incêndios, inundações, danos por água, roubo, atos de vandalismo e danos causados por tempestades entre muitas outras coberturas.';
}

$btn_text    = pacto_get_field( 'seguro_hero_btn_text', $post_id, 'pedir simulação' );
$btn_link    = pacto_get_field( 'seguro_hero_btn_link', $post_id, '#simulacao' );

$image       = pacto_get_field( 'seguro_hero_image', $post_id );
$default_img = get_template_directory_uri() . '/assets/images/single-seguro/seguro-hero-family.png';
?>

<section class="section section-single-seguro-hero" aria-label="<?php echo esc_attr( $title ); ?>">
    <div class="site-container">
        <div class="section-single-seguro-hero__layout">
            <!-- Left Narrative Column -->
            <div class="section-single-seguro-hero__content">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h1 class="h1 section-single-seguro-hero__title"><?php echo esc_html( $title ); ?></h1>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                    <p class="section-single-seguro-hero__lead"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>

                <?php if ( $btn_text ) : ?>
                    <div class="section-single-seguro-hero__btn-wrap">
                        <a href="<?php echo esc_url( $btn_link ); ?>" class="btn btn--dark section-single-seguro-hero__btn">
                            <span><?php echo esc_html( $btn_text ); ?></span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Visual Column (Large Circle Bleed with Red Border) -->
            <div class="section-single-seguro-hero__visual">
                <div class="seguro-hero-circle-wrap">
                    <div class="seguro-hero-circle-frame">
                        <?php pacto_render_image( $image, 'full', 'seguro-hero-img', $default_img, true ); ?>
                    </div>
                    <!-- Ambient Red Dot on Key / Center -->
                    <div class="seguro-hero-dot" aria-hidden="true"></div>
                </div>
            </div>
        </div>
    </div>
</section>
