<?php
/**
 * Template Part: Section Sinistro Hero ("Em Caso de Sinistro")
 * Theme: Pacto 25
 * 
 * Strict Agency SOP:
 * - Dynamic ACF bindings with full fallback
 * - Left narrative + Right car boot family image with ambient red bubbles
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = pacto_get_field( 'sinistro_hero_eyebrow', false, 'INSTITUCIONAL — PACTO SEGURO' );
$title       = pacto_get_field( 'sinistro_hero_title', false, 'Em Caso de Sinistro' );
$description = pacto_get_field( 'sinistro_hero_description', false, 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );
$image_obj   = pacto_get_field( 'sinistro_hero_image', false );

// Default image fallback
$image_url = ! empty( $image_obj['url'] ) ? $image_obj['url'] : get_template_directory_uri() . '/assets/images/sinistro/sinistro-hero-family.png';
$image_alt = ! empty( $image_obj['alt'] ) ? $image_obj['alt'] : esc_attr( $title );
?>

<section class="section section-sinistro-hero" aria-label="<?php echo esc_attr( $title ); ?>">
    <!-- Ambient Floating Red Bubbles -->
    <div class="sinistro-hero-bubble sinistro-hero-bubble--1" aria-hidden="true"></div>
    <div class="sinistro-hero-bubble sinistro-hero-bubble--2" aria-hidden="true"></div>
    <div class="sinistro-hero-bubble sinistro-hero-bubble--3" aria-hidden="true"></div>
    <div class="sinistro-hero-bubble sinistro-hero-bubble--4" aria-hidden="true"></div>
    <div class="sinistro-hero-bubble sinistro-hero-bubble--5" aria-hidden="true"></div>
    <div class="sinistro-hero-bubble sinistro-hero-bubble--6" aria-hidden="true"></div>
    <div class="sinistro-hero-bubble sinistro-hero-bubble--7" aria-hidden="true"></div>
    <div class="sinistro-hero-bubble sinistro-hero-bubble--8" aria-hidden="true"></div>
    <div class="sinistro-hero-bubble sinistro-hero-bubble--9" aria-hidden="true"></div>
    <div class="sinistro-hero-bubble sinistro-hero-bubble--10" aria-hidden="true"></div>
    <div class="sinistro-hero-bubble sinistro-hero-bubble--11" aria-hidden="true"></div>
    <div class="sinistro-hero-bubble sinistro-hero-bubble--12" aria-hidden="true"></div>
    <div class="sinistro-hero-bubble sinistro-hero-bubble--13" aria-hidden="true"></div>

    <div class="site-container">
        <div class="sinistro-hero-grid">
            <!-- Left Text Column -->
            <div class="sinistro-hero-text">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow sinistro-hero-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h1 class="h1 sinistro-hero-title"><?php echo esc_html( $title ); ?></h1>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                    <p class="sinistro-hero-desc"><?php echo nl2br( esc_html( $description ) ); ?></p>
                <?php endif; ?>
            </div>

            <!-- Right Visual Column -->
            <div class="sinistro-hero-visual">
                <div class="sinistro-hero-img-wrap">
                    <img src="<?php echo esc_url( $image_url ); ?>" 
                         alt="<?php echo esc_attr( $image_alt ); ?>" 
                         loading="eager" 
                         fetchpriority="high" />
                </div>
            </div>
        </div>
    </div>
</section>
