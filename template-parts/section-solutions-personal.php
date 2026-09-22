<?php
/**
 * Template Part: Soluções de Seguros para Particulares
 * Theme: Pacto 25
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = pacto_get_field( 'solutions_part_eyebrow', false, 'AS MAIS ADEQUADAS À SUA REALIDADE' );
$title       = pacto_get_field( 'solutions_part_title', false, 'Soluções de Seguros para Particulares' );
$description = pacto_get_field( 'solutions_part_description', false, 'A tranquilidade de quem mais ama com seguros de saúde, vida, habitação e automóvel adaptados à realidade da sua família.' );
$btn_text    = pacto_get_field( 'solutions_part_btn_text', false, 'encontrar a solução ideal' );
$btn_url     = pacto_get_field( 'solutions_part_btn_url', false, '#particulares' );
$image       = pacto_get_field( 'solutions_part_image' );
?>

<section class="section section-solutions-personal" id="particulares" aria-label="<?php esc_attr_e( 'Seguros para Particulares', 'pacto-25' ); ?>">
    <!-- Decorative Red Circles Matching Figma Design -->
    <div class="particulares-deco particulares-deco--left-bleed" aria-hidden="true"></div>
    <div class="particulares-deco particulares-deco--tl-sm" aria-hidden="true"></div>
    <div class="particulares-deco particulares-deco--tl-med" aria-hidden="true"></div>
    <div class="particulares-deco particulares-deco--mid-dot" aria-hidden="true"></div>
    <div class="particulares-deco particulares-deco--right-bleed" aria-hidden="true"></div>
    <div class="particulares-deco particulares-deco--bl-med" aria-hidden="true"></div>
    <div class="particulares-deco particulares-deco--br-sm" aria-hidden="true"></div>

    <div class="site-container">
        <div class="split-layout">
            <!-- Content Column (Left) -->
            <div class="section-solutions-personal__content">
                <?php if ( $eyebrow ) : ?>
                    <div class="eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h2 class="h2"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                    <p class="lead"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>

                <?php if ( $btn_text && $btn_url ) : ?>
                    <div class="section-solutions-personal__btn-wrap">
                        <a href="<?php echo esc_url( $btn_url ); ?>" class="btn btn--dark">
                            <span><?php echo esc_html( $btn_text ); ?></span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Visual Column (Right) -->
            <div class="section-solutions-personal__visual">
                <div class="solutions-personal__visual-wrap">
                    <?php
                    $default_img = get_template_directory_uri() . '/assets/home/01-Homepage/home-seguros-particulares-pacto-seguro.webp';
                    pacto_render_image( $image, 'large', 'solutions-part-image', $default_img );
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
