<?php
/**
 * Template Part: About Section
 * Theme: Pacto 25
 * Exact match to Figma design:
 * - Left: Circle frame with bleed-over figure (assets/about-circle-woman.png)
 * - Right: Eyebrow with bullet, bold title, 25-years narrative text, dark pill button
 * - Decorative red accent circles transitioning into following section
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = pacto_get_field( 'about_eyebrow', false, 'QUEM SOMOS' );
$title       = pacto_get_field( 'about_title', false, 'Sobre a Pacto Seguro' );
$description = pacto_get_field(
    'about_description',
    false,
    'O privilégio de comemorar 25 anos de uma empresa é de assinalar e onde a Pacto Seguro chegou com talento, proximidade, resiliência, espírito de equipa, liderança e experiência. Hoje somos uma referência na mediação de seguros em Portugal, com uma enorme dedicação junto dos nossos Clientes que os mesmos reconhecem. Para todos os Clientes, Parceiros, Colaboradores e Amigos que participaram na nossa jornada, o nosso profundo agradecimento.'
);
$btn_text    = pacto_get_field( 'about_btn_text', false, 'conheça a nossa história' );
$btn_url     = pacto_get_field( 'about_btn_url', false, pacto_get_nav_url( 'quem-somos', 'page-quem-somos.php', '#sobre' ) );
$image       = pacto_get_field( 'about_image' );
$default_img = get_template_directory_uri() . '/assets/about-circle-woman.png';
$img_src     = pacto_get_image_url( $image, $default_img, 'large' );
$img_alt     = pacto_get_image_alt( $image, $title );
?>

<section class="section-about" id="sobre" aria-label="<?php esc_attr_e( 'Sobre a Empresa', 'pacto-25' ); ?>">
    <div class="site-container section-about__container">
        <div class="section-about__layout">
            <!-- Visual Column (Left) -->
            <div class="section-about__visual">
                <img src="<?php echo esc_url( $img_src ); ?>" 
                     alt="<?php echo esc_attr( $img_alt ); ?>" 
                     class="section-about__image" 
                     width="760" 
                     height="780" 
                     loading="lazy" />
            </div>

            <!-- Content Column (Right) -->
            <div class="section-about__content">
                <?php if ( $eyebrow ) : ?>
                    <div class="eyebrow section-about__eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h2 class="section-about__title"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                    <div class="section-about__desc">
                        <p><?php echo esc_html( $description ); ?></p>
                    </div>
                <?php endif; ?>

                <?php if ( $btn_text && $btn_url ) : ?>
                    <div class="section-about__btn-wrap">
                        <a href="<?php echo esc_url( $btn_url ); ?>" class="section-about__btn">
                            <?php echo esc_html( $btn_text ); ?>
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

