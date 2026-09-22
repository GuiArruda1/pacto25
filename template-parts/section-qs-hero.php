<?php
/**
 * Template Part: Quem Somos Hero Section
 * Theme: Pacto 25
 * Strict Agency SOP: Fully decoupled text & media via ACF with sensible fallbacks.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = pacto_get_field( 'qs_hero_eyebrow', false, 'INSTITUCIONAL — PACTO SEGURO' );
$title       = pacto_get_field( 'qs_hero_title', false, "Quem Somos\nSeguros à Medida" );
$description = pacto_get_field( 'qs_hero_description', false, 'Com mais de duas décadas de experiência no mercado segurador, temos vindo a consolidar o nosso papel como mediador de seguros de confiança para famílias e empresas.' );
$image       = pacto_get_field( 'qs_hero_image' );
$default_img = get_template_directory_uri() . '/assets/images/quem-somos/qs-hero-team.png';
?>

<section class="section section-qs-hero" aria-label="<?php esc_attr_e( 'Apresentação Quem Somos', 'pacto-25' ); ?>">
    <!-- Ambient Red Floating Dots (Strictly Scoped) -->
    <div class="qs-hero-dot qs-hero-dot--left" aria-hidden="true"></div>
    <div class="qs-hero-dot qs-hero-dot--top-large" aria-hidden="true"></div>
    <div class="qs-hero-dot qs-hero-dot--top-small" aria-hidden="true"></div>
    <div class="qs-hero-dot qs-hero-dot--mid-large" aria-hidden="true"></div>
    <div class="qs-hero-dot qs-hero-dot--mid-small" aria-hidden="true"></div>

    <div class="site-container">
        <div class="section-qs-hero__layout">
            <!-- Content Column -->
            <div class="section-qs-hero__content">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h1 class="h1 section-qs-hero__title"><?php echo nl2br( esc_html( $title ) ); ?></h1>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                    <p class="lead section-qs-hero__lead"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>
            </div>

            <!-- Visual Column: Circular Team Portrait with Bottom-Right Red Crescent Disc -->
            <div class="section-qs-hero__visual">
                <div class="qs-hero-composition">
                    <div class="qs-hero-accent-disc" aria-hidden="true"></div>
                    <div class="qs-hero-photo-wrap">
                        <?php pacto_render_image( $image, 'large', 'qs-hero-img', $default_img, true ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
