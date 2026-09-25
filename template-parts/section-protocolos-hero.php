<?php
/**
 * Template Part: Section Protocolos Hero
 * Theme: Pacto 25
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page_id = get_the_ID();

$eyebrow   = pacto_get_field( 'protocolos_hero_eyebrow', $page_id, 'PROTOCOLOS - PACTO SEGURO' );
$title     = pacto_get_field( 'protocolos_hero_title', $page_id, 'Os Protocolos da Pacto Seguro' );
$text      = pacto_get_field( 'protocolos_hero_text', $page_id, 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.' );

$image_obj = pacto_get_field( 'protocolos_hero_image', $page_id );
$image_url = pacto_get_image_url( $image_obj, get_template_directory_uri() . '/assets/images/protocolos-hero.png', 'full' );
$image_alt = pacto_get_image_alt( $image_obj, $title );
?>

<section class="section section-protocolos-hero" aria-label="<?php echo esc_attr( $title ); ?>">
    <div class="site-container">
        <div class="protocolos-hero-grid">
            
            <div class="protocolos-hero-content">
                <?php if ( $eyebrow ) : ?>
                    <span class="protocolos-hero-eyebrow"><span class="eyebrow-bullet">•</span> <?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>
                
                <h1 class="h1 protocolos-hero-title"><?php echo esc_html( $title ); ?></h1>
                
                <?php if ( $text ) : ?>
                    <div class="protocolos-hero-text">
                        <p><?php echo wp_kses_post( $text ); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="protocolos-hero-visual">
                <!-- Decorative Elements -->
                <div class="protocolos-hero-bubble-1" aria-hidden="true"></div>
                <div class="protocolos-hero-bubble-2" aria-hidden="true"></div>
                <div class="protocolos-hero-bubble-3" aria-hidden="true"></div>
                <div class="protocolos-hero-bubble-4" aria-hidden="true"></div>
                
                <!-- Transparent PNG Photo -->
                <div class="protocolos-hero-photo-wrap">
                    <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="protocolos-hero-photo" loading="eager" fetchpriority="high" />
                </div>
            </div>
            
        </div>
    </div>
</section>
