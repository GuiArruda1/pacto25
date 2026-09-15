<?php
/**
 * Template Part: Banner Quem Somos / Institucional
 * Theme: Pacto 25
 * Includes exact 5 red dots and circular photo with bottom-right red dot
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = pacto_get_field( 'qs_eyebrow', false, 'INSTITUCIONAL — PACTO SEGURO' );
$title       = pacto_get_field( 'qs_title', false, "Quem Somos\nSeguros à Medida" );
$description = pacto_get_field( 'qs_description', false, 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.' );
$image       = pacto_get_field( 'qs_image' );
?>

<section class="section section-banner-quem-somos" aria-label="<?php esc_attr_e( 'Banner Quem Somos', 'pacto-25' ); ?>">
    <!-- Exact 5 Red Dots Placement for Quem Somos -->
    <div class="qs-dot qs-dot--1" aria-hidden="true"></div>
    <div class="qs-dot qs-dot--2" aria-hidden="true"></div>
    <div class="qs-dot qs-dot--3" aria-hidden="true"></div>
    <div class="qs-dot qs-dot--4" aria-hidden="true"></div>
    <div class="qs-dot qs-dot--5" aria-hidden="true"></div>

    <div class="site-container" style="position: relative; z-index: 2; width: 100%;">
        <div class="split-layout">
            <!-- Content Column -->
            <div class="section-banner-quem-somos__content">
                <?php if ( $eyebrow ) : ?>
                    <div class="eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h1 class="h1" style="white-space: pre-line;"><?php echo esc_html( $title ); ?></h1>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                    <p class="lead"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>
            </div>

            <!-- Visual Column (Circular Portrait with Bottom-Right Red Dot) -->
            <div class="section-banner-quem-somos__visual">
                <div class="qs-circle-composition">
                    <!-- Red Dot behind Photo (bottom-right arc) -->
                    <div class="qs-circle-dot" aria-hidden="true"></div>

                    <!-- Main Photo Circle -->
                    <div class="qs-circle-photo">
                        <?php
                        // Default fallback team image
                        $default_img = 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&auto=format&fit=crop';
                        pacto_render_image( $image, 'large', 'qs-team-image', $default_img, true );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
