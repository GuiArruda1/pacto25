<?php
/**
 * Template Part: Empresas - Hero Section
 * Theme: Pacto 25
 * Strict Agency SOP: Fully decoupled via ACF, responsive CSS grid, floating ambient dots.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = pacto_get_field( 'empresas_hero_eyebrow', false, 'EMPRESAS — PACTO SEGURO' );
$title       = pacto_get_field( 'empresas_hero_title', false, 'Seguros para Empresas' );
$description = pacto_get_field( 'empresas_hero_description', false, 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.' );
$image       = pacto_get_field( 'empresas_hero_image' );
$default_img = get_template_directory_uri() . '/assets/images/empresas/empresas-hero.png';
?>

<section class="section section-empresas-hero" aria-label="<?php echo esc_attr( $title ); ?>">
    <!-- Ambient Floating Red Dots (Matching Figma coordinates) -->
    <div class="empresas-dot empresas-dot--top-left" aria-hidden="true"></div>
    <div class="empresas-dot empresas-dot--mid-bottom" aria-hidden="true"></div>
    <div class="empresas-dot empresas-dot--center-bottom" aria-hidden="true"></div>
    <div class="empresas-dot empresas-dot--table-bottom" aria-hidden="true"></div>
    <div class="empresas-dot empresas-dot--right-large" aria-hidden="true"></div>
    <div class="empresas-dot empresas-dot--right-edge" aria-hidden="true"></div>

    <div class="site-container">
        <div class="section-empresas-hero__layout">
            <!-- Left Narrative Column -->
            <div class="section-empresas-hero__content">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h1 class="h1 section-empresas-hero__title"><?php echo esc_html( $title ); ?></h1>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                    <p class="lead section-empresas-hero__lead"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>
            </div>

            <!-- Right Visual Column (Family dining table top-down visual) -->
            <div class="section-empresas-hero__visual">
                <div class="empresas-hero-image-wrap">
                    <?php pacto_render_image( $image, 'full', 'empresas-hero-img', $default_img, true ); ?>
                </div>
            </div>
        </div>
    </div>
</section>
