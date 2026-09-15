<?php
/**
 * Template Part: Testimonials Section
 * Theme: Pacto 25
 * 3D Cylindrical Arc Testimonial Layout matching Figma
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = pacto_get_field( 'testimonials_eyebrow', false, 'PORQUÊ ESCOLHER-NOS' );
$title       = pacto_get_field( 'testimonials_title', false, "O que dizem sobre a\nPacto Seguro" );
$description = pacto_get_field( 'testimonials_description', false, 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.' );

$testimonials = pacto_get_testimonials_list();
?>

<section class="section section-testimonials" id="testemunhos" aria-label="<?php esc_attr_e( 'Testemunhos de Clientes', 'pacto-25' ); ?>">
    <!-- Top Decorative Red Circle Dot -->
    <div class="testimonials-top-dot" aria-hidden="true"></div>

    <div class="site-container testimonials-header text-center">
        <?php if ( $eyebrow ) : ?>
            <div class="eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
        <?php endif; ?>

        <?php if ( $title ) : ?>
            <h2 class="h2 testimonials-title"><?php echo wp_kses_post( nl2br( $title ) ); ?></h2>
        <?php endif; ?>

        <?php if ( $description ) : ?>
            <p class="lead testimonials-lead">
                <?php echo esc_html( $description ); ?>
            </p>
        <?php endif; ?>
    </div>

    <!-- SVG Clip Path for 8000x8000 Ellipse Curvature on Top and Bottom -->
    <svg width="0" height="0" class="sr-only" aria-hidden="true" style="position: absolute; width: 0; height: 0; pointer-events: none;">
        <defs>
            <clipPath id="testimonials-arc-clip" clipPathUnits="objectBoundingBox">
                <path d="M 0,0 Q 0.5,0.3682 1,0 L 1,1 Q 0.5,0.6318 0,1 Z" />
            </clipPath>
        </defs>
    </svg>

    <!-- Curvature Stage & Arc Mask Wrapper -->
    <div class="testimonials-stage">
        <div class="testimonials-arc-wrapper">
            <div class="testimonials-track" data-testimonials-track>
                <?php foreach ( $testimonials as $index => $item ) : ?>
                    <article class="testimonial-card" data-card-index="<?php echo esc_attr( $index ); ?>">
                        <div class="testimonial-card__avatar">
                            <img src="<?php echo esc_url( $item['avatar'] ); ?>" alt="<?php echo esc_attr( $item['name'] ); ?>" width="64" height="64" loading="lazy" />
                        </div>
                        <blockquote class="testimonial-card__quote">
                            <?php echo esc_html( $item['quote'] ); ?>
                        </blockquote>
                        <div class="testimonial-card__footer">
                            <div class="testimonial-card__author"><?php echo esc_html( $item['name'] ); ?></div>
                            <div class="testimonial-card__role"><?php echo esc_html( $item['role'] ); ?></div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Centered Navigation Chevrons (< and >) -->
    <div class="testimonials-nav">
        <button type="button" class="testimonials-nav__btn" data-testimonials-nav="prev" aria-label="<?php esc_attr_e( 'Testemunho Anterior', 'pacto-25' ); ?>">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M15 18l-6-6 6-6"/>
            </svg>
        </button>
        <button type="button" class="testimonials-nav__btn" data-testimonials-nav="next" aria-label="<?php esc_attr_e( 'Testemunho Seguinte', 'pacto-25' ); ?>">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M9 18l6-6-6-6"/>
            </svg>
        </button>
    </div>
</section>
