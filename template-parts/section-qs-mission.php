<?php
/**
 * Component / Template Part: Left Ball Section (Organic Red Canopy on Left)
 * Theme: Pacto 25
 * Reusable across any page: Supports $args or defaults to ACF fields.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$prefix = isset( $args['prefix'] ) ? $args['prefix'] : 'qs_mission_';

$eyebrow     = isset( $args['eyebrow'] ) ? $args['eyebrow'] : pacto_get_field( $prefix . 'eyebrow', false, 'O PROPÓSITO DO NOSSO NEGÓCIO' );
$title       = isset( $args['title'] ) ? $args['title'] : pacto_get_field( $prefix . 'title', false, 'Missão, Visão e Valores' );
$description = isset( $args['desc_1'] ) ? $args['desc_1'] : pacto_get_field( $prefix . 'desc_1', false, 'A nossa missão é proporcionar tranquilidade e segurança através de soluções de seguros rigorosas, personalizadas e transparentes, adaptadas à realidade de cada cliente.' );
$desc_two    = isset( $args['desc_2'] ) ? $args['desc_2'] : pacto_get_field( $prefix . 'desc_2', false, 'Aspiramos a ser a referência de confiança no setor da mediação de seguros, pautando a nossa atuação pelo rigor ético, proximidade humana e inovação constante na resposta aos desafios dos nossos clientes.' );
$btn_text    = isset( $args['btn_text'] ) ? $args['btn_text'] : pacto_get_field( $prefix . 'btn_text', false, 'falar com um especialista' );
$btn_link    = isset( $args['btn_link'] ) ? $args['btn_link'] : pacto_get_field( $prefix . 'btn_link', false, '#contactos' );
$image       = isset( $args['image'] ) ? $args['image'] : pacto_get_field( $prefix . 'image' );
$default_img = get_template_directory_uri() . '/assets/images/quem-somos/qs-mission-team.png';
?>

<section class="section section-ball-left section-qs-mission missao-visao-section section-quem-somos" aria-label="<?php echo esc_attr( $title ); ?>">
    <!-- Self-Contained Left Red Ball Canopy -->
    <div class="ball-left-canopy big-orange-ball circle-bg-orange" aria-hidden="true"></div>

    <div class="site-container ball-left-container missao-visao-container">
        <!-- Content Column (Inside Red Ball) -->
        <div class="ball-left-content missao-visao-content">
            <?php if ( $eyebrow ) : ?>
                <span class="eyebrow eyebrow--light"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>

            <?php if ( $title ) : ?>
                <h2 class="h2 ball-left-title"><?php echo esc_html( $title ); ?></h2>
            <?php endif; ?>

            <?php if ( $description ) : ?>
                <p class="ball-left-text"><?php echo esc_html( $description ); ?></p>
            <?php endif; ?>

            <?php if ( $desc_two ) : ?>
                <p class="ball-left-text"><?php echo esc_html( $desc_two ); ?></p>
            <?php endif; ?>

            <?php if ( $btn_text ) : ?>
                <div class="ball-left-btn-wrap">
                    <a href="<?php echo esc_url( $btn_link ); ?>" class="btn ball-left-btn">
                        <span><?php echo esc_html( $btn_text ); ?></span>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Visual Column (Right Circular Photo on Burgundy) -->
        <div class="ball-left-visual missao-visao-image team-circle-wrap">
            <?php pacto_render_image( $image, 'large', 'ball-left-photo', $default_img, false ); ?>
        </div>
    </div>
</section>
