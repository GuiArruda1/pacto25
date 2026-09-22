<?php
/**
 * Template Part: Single Seguro Particular - "O que é o Seguro?" Section
 * Theme: Pacto 25
 * Strict Agency SOP: Dynamic ACF bindings, left-bleed large circular frame with red border.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id     = get_the_ID();
$post_title  = get_the_title();

$eyebrow     = pacto_get_field( 'seguro_about_eyebrow', $post_id, strtoupper( $post_title ) . ' — PACTO SEGURO' );
$title       = pacto_get_field( 'seguro_about_title', $post_id, 'O que é o Seguro?' );
$p1          = pacto_get_field( 'seguro_about_p1', $post_id, 'Um Seguro Multirriscos para a casa é uma opção muito completa de seguro que cobre vários riscos que podem afetar o seu imóvel e o seu recheio. Inclui cobertura para incêndios, inundações, danos por água, roubo, atos de vandalismo e danos causados por tempestades entre muitas outras coberturas.' );
$p2          = pacto_get_field( 'seguro_about_p2', $post_id, 'Além disso, também pode incluir cobertura para responsabilidade civil, o que significa que se alguém se magoar em sua propriedade, você estará protegido contra possíveis processos.' );

$btn_text    = pacto_get_field( 'seguro_about_btn_text', $post_id, 'pedir simulação' );
$btn_link    = pacto_get_field( 'seguro_about_btn_link', $post_id, '#simulacao' );

$image       = pacto_get_field( 'seguro_about_image', $post_id );
$default_img = get_template_directory_uri() . '/assets/images/single-seguro/seguro-about-couple.png';
?>

<section class="section section-single-seguro-about" aria-label="<?php echo esc_attr( $title ); ?>">
    <div class="site-container">
        <div class="section-single-seguro-about__layout">
            <!-- Left Visual Column (Large Circle Bleed with Red Border) -->
            <div class="section-single-seguro-about__visual">
                <div class="seguro-about-circle-wrap">
                    <div class="seguro-about-circle-frame">
                        <?php pacto_render_image( $image, 'full', 'seguro-about-img', $default_img, true ); ?>
                    </div>
                </div>
            </div>

            <!-- Right Narrative Column -->
            <div class="section-single-seguro-about__content">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h2 class="h2 section-single-seguro-about__title"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <div class="section-single-seguro-about__paragraphs">
                    <?php if ( $p1 ) : ?>
                        <p><?php echo esc_html( $p1 ); ?></p>
                    <?php endif; ?>

                    <?php if ( $p2 ) : ?>
                        <p><?php echo esc_html( $p2 ); ?></p>
                    <?php endif; ?>
                </div>

                <?php if ( $btn_text ) : ?>
                    <div class="section-single-seguro-about__btn-wrap">
                        <a href="<?php echo esc_url( $btn_link ); ?>" class="btn btn--dark section-single-seguro-about__btn">
                            <span><?php echo esc_html( $btn_text ); ?></span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
