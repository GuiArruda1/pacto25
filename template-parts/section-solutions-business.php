<?php
/**
 * Template Part: Soluções de Seguros para Empresas
 * Theme: Pacto 25
 * Inside the prominent organic curved red section
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = pacto_get_field( 'solutions_biz_eyebrow', false, 'SEGURAMENTE CONSIGO' );
$title       = pacto_get_field( 'solutions_biz_title', false, 'Soluções de Seguros<br>para Empresas' );
$description = pacto_get_field( 'solutions_biz_description', false, "Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.\n\nAliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet." );
$btn_text    = pacto_get_field( 'solutions_biz_btn_text', false, 'soluções para empresas' );
$btn_url     = pacto_get_field( 'solutions_biz_btn_url', false, '#empresas' );

$default_hands = get_template_directory_uri() . '/assets/solutions-business-hands.png';
$hands_field   = pacto_get_field( 'solutions_biz_image' );
$hands_src     = $hands_field ? ( is_array( $hands_field ) ? $hands_field['url'] : $hands_field ) : $default_hands;
?>

<div class="section-solutions-business" id="empresas">
    <div class="section-solutions-business__layout">
        <!-- Visual Column (Left Circle of Hands) -->
        <div class="section-solutions-business__visual">
            <div class="solutions-hands-frame">
                <img src="<?php echo esc_url( $hands_src ); ?>"
                     alt="<?php echo esc_attr( wp_strip_all_tags( $title ) ); ?>"
                     class="solutions-hands-img"
                     width="740"
                     height="740"
                     loading="lazy" />
            </div>
        </div>

        <!-- Content Column (Right) -->
        <div class="section-solutions-business__content">
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
    </div>
</div>
