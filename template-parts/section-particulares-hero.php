<?php
/**
 * Template Part: Particulares - Hero Section
 * Theme: Pacto 25
 * Strict Agency SOP: Fully decoupled via ACF, responsive CSS grid, floating ambient dots.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = pacto_get_field( 'particulares_hero_eyebrow', false, 'PARTICULARES — PACTO SEGURO' );
$title       = pacto_get_field( 'particulares_hero_title', false, 'Seguros para Particulares' );
$description = pacto_get_field( 'particulares_hero_description', false, 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.' );
$image       = pacto_get_field( 'particulares_hero_image' );
$default_img = get_template_directory_uri() . '/assets/images/particulares/particulares-hero.png';
?>

<section class="section section-particulares-hero" aria-label="<?php echo esc_attr( $title ); ?>">
    <!-- Ambient Floating Red Dots (Matching Figma coordinates) -->
    <div class="particulares-dot particulares-dot--top-left" aria-hidden="true"></div>
    <div class="particulares-dot particulares-dot--mid-bottom" aria-hidden="true"></div>
    <div class="particulares-dot particulares-dot--center-bottom" aria-hidden="true"></div>
    <div class="particulares-dot particulares-dot--table-bottom" aria-hidden="true"></div>
    <div class="particulares-dot particulares-dot--right-large" aria-hidden="true"></div>
    <div class="particulares-dot particulares-dot--right-edge" aria-hidden="true"></div>

    <div class="site-container">
        <div class="section-particulares-hero__layout">
            <!-- Left Narrative Column -->
            <div class="section-particulares-hero__content">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h1 class="h1 section-particulares-hero__title"><?php echo esc_html( $title ); ?></h1>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                    <p class="lead section-particulares-hero__lead"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>
            </div>

            <!-- Right Visual Column (Family dining table top-down visual) -->
            <div class="section-particulares-hero__visual">
                <div class="particulares-hero-image-wrap">
                    <?php pacto_render_image( $image, 'full', 'particulares-hero-img', $default_img, true ); ?>
                </div>
            </div>
        </div>
    </div>
</section>
