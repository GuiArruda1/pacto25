<?php
/**
 * Template Part: Soluções Globais
 * Theme: Pacto 25
 * Inside the prominent organic curved red section
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = pacto_get_field( 'solutions_global_eyebrow', false, 'O PROPÓSITO DO NOSSO NEGÓCIO' );
$title       = pacto_get_field( 'solutions_global_title', false, 'Conheça as nossas<br>Soluções Globais' );
$description = pacto_get_field( 'solutions_global_description', false, "Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.\n\nAliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet." );
$btn_text    = pacto_get_field( 'solutions_global_btn_text', false, 'ver todas as soluções' );
$btn_url     = pacto_get_field( 'solutions_global_btn_url', false, '#solucoes' );

// 5 Bubble Images (with ACF back-office support & crisp defaults)
$img_center = pacto_get_field( 'solutions_bubble_center' );
$img_tl     = pacto_get_field( 'solutions_bubble_top_left' );
$img_tr     = pacto_get_field( 'solutions_bubble_top_right' );
$img_bl     = pacto_get_field( 'solutions_bubble_bottom_left' );
$img_br     = pacto_get_field( 'solutions_bubble_bottom_right' );

$src_center = $img_center ? ( is_array( $img_center ) ? $img_center['url'] : $img_center ) : get_template_directory_uri() . '/assets/bubble-center.jpg';
$src_tl     = $img_tl ? ( is_array( $img_tl ) ? $img_tl['url'] : $img_tl ) : get_template_directory_uri() . '/assets/bubble-dog.jpg';
$src_tr     = $img_tr ? ( is_array( $img_tr ) ? $img_tr['url'] : $img_tr ) : get_template_directory_uri() . '/assets/bubble-businessman.jpg';
$src_bl     = $img_bl ? ( is_array( $img_bl ) ? $img_bl['url'] : $img_bl ) : get_template_directory_uri() . '/assets/bubble-couple.jpg';
$src_br     = $img_br ? ( is_array( $img_br ) ? $img_br['url'] : $img_br ) : get_template_directory_uri() . '/assets/bubble-car.jpg';
?>

<div class="section-solutions-global" id="solucoes-globais">
    <div class="section-solutions-global__layout">
        <!-- Content Column (Left) -->
        <div class="section-solutions-global__content">
            <?php if ( $eyebrow ) : ?>
                <div class="eyebrow eyebrow--white"><?php echo esc_html( $eyebrow ); ?></div>
            <?php endif; ?>

            <?php if ( $title ) : ?>
                <h2 class="section-curved-red__heading"><?php echo wp_kses_post( $title ); ?></h2>
            <?php endif; ?>

            <?php if ( $description ) : ?>
                <div class="section-curved-red__desc">
                    <?php
                    $paragraphs = explode( "\n\n", str_replace( "\r", '', $description ) );
                    foreach ( $paragraphs as $p ) :
                        if ( trim( $p ) ) :
                    ?>
                        <p><?php echo esc_html( trim( $p ) ); ?></p>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </div>
            <?php endif; ?>

            <?php if ( $btn_text && $btn_url ) : ?>
                <div class="section-curved-red__btn-wrap">
                    <a href="<?php echo esc_url( $btn_url ); ?>" class="btn btn--dark">
                        <span><?php echo esc_html( $btn_text ); ?></span>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Visual Column (5 Bubble Cluster with Interactive Hover) -->
        <div class="section-solutions-global__visual">
            <div class="bubble-cluster">
                <!-- Center Main Bubble -->
                <div class="bubble-cluster__bubble bubble-cluster__bubble--center" tabindex="0" role="img" aria-label="<?php esc_attr_e( 'Soluções Globais Integradas', 'pacto-25' ); ?>">
                    <img src="<?php echo esc_url( $src_center ); ?>" alt="<?php esc_attr_e( 'Reunião e Gestão Global', 'pacto-25' ); ?>" width="490" height="490" loading="lazy" />
                </div>

                <!-- Top Left: Animal / Pet -->
                <div class="bubble-cluster__bubble bubble-cluster__bubble--top-left" tabindex="0" role="img" aria-label="<?php esc_attr_e( 'Seguro Animal de Estimação', 'pacto-25' ); ?>">
                    <img src="<?php echo esc_url( $src_tl ); ?>" alt="<?php esc_attr_e( 'Proteção Animal de Estimação', 'pacto-25' ); ?>" width="254" height="254" loading="lazy" />
                </div>

                <!-- Top Right: Businessman / Profissional -->
                <div class="bubble-cluster__bubble bubble-cluster__bubble--top-right" tabindex="0" role="img" aria-label="<?php esc_attr_e( 'Seguro Profissional', 'pacto-25' ); ?>">
                    <img src="<?php echo esc_url( $src_tr ); ?>" alt="<?php esc_attr_e( 'Soluções Profissionais e Negócios', 'pacto-25' ); ?>" width="240" height="240" loading="lazy" />
                </div>

                <!-- Bottom Left: Couple / Família -->
                <div class="bubble-cluster__bubble bubble-cluster__bubble--bottom-left" tabindex="0" role="img" aria-label="<?php esc_attr_e( 'Proteção Familiar e Sénior', 'pacto-25' ); ?>">
                    <img src="<?php echo esc_url( $src_bl ); ?>" alt="<?php esc_attr_e( 'Proteção Familiar e Sénior', 'pacto-25' ); ?>" width="180" height="180" loading="lazy" />
                </div>

                <!-- Bottom Right: Car / Viagem -->
                <div class="bubble-cluster__bubble bubble-cluster__bubble--bottom-right" tabindex="0" role="img" aria-label="<?php esc_attr_e( 'Seguro Automóvel e Viagem', 'pacto-25' ); ?>">
                    <img src="<?php echo esc_url( $src_br ); ?>" alt="<?php esc_attr_e( 'Seguro Automóvel e Viagem', 'pacto-25' ); ?>" width="190" height="190" loading="lazy" />
                </div>

                <!-- Decorative Floating White Rings -->
                <div class="bubble-cluster__ring bubble-cluster__ring--top" aria-hidden="true"></div>
                <div class="bubble-cluster__ring bubble-cluster__ring--bottom" aria-hidden="true"></div>
            </div>
        </div>
    </div>
</div>
