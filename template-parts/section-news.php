<?php
/**
 * Template Part: News & Events Spotlight Section
 * Theme: Pacto 25
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = pacto_get_field( 'news_eyebrow', false, 'NOTÍCIAS & EVENTOS' );
$title       = pacto_get_field( 'news_title', false, 'Presença de Rosalina Pereira CEO da Pacto Seguro no MAG Summit' );
$description = pacto_get_field( 'news_description', false, 'A CEO da Pacto Seguro partilhou a visão sobre o futuro do setor segurador e o papel da inovação na proximidade com os clientes.' );
$btn_text    = pacto_get_field( 'news_btn_text', false, 'LER MAIS NOTÍCIAS' );
$btn_url     = pacto_get_field( 'news_btn_url', false, '#noticias' );
$image       = pacto_get_field( 'news_image' );
?>

<section class="section section-news" id="noticias" aria-label="<?php esc_attr_e( 'Notícias e Eventos', 'pacto-25' ); ?>">
    <div class="site-container">
        <div class="split-layout">
            <!-- Visual Column (Left) -->
            <div class="section-news__visual" style="position: relative;">
                <!-- Decorative Shapes -->
                <div class="decorative-dot" style="width: 26px; height: 26px; top: 5%; right: 10%;"></div>
                <div class="decorative-ring" style="width: 36px; height: 36px; bottom: 10%; left: 5%;"></div>

                <div class="circle-frame circle-frame--ring-red circle-frame--ring-thick">
                    <div class="circle-frame__img-wrap">
                        <?php
                        $default_img = 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?q=80&w=800&auto=format&fit=crop';
                        pacto_render_image( $image, 'large', 'news-image', $default_img );
                        ?>
                    </div>
                </div>
            </div>

            <!-- Content Column (Right) -->
            <div class="section-news__content">
                <?php if ( $eyebrow ) : ?>
                    <div class="eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h2 class="h2"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                    <p class="lead"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>

                <!-- Slider arrows -->
                <div class="slider-controls" aria-label="<?php esc_attr_e( 'Navegação de notícias', 'pacto-25' ); ?>">
                    <button type="button" class="slider-btn" aria-label="<?php esc_attr_e( 'Notícia Anterior', 'pacto-25' ); ?>">
                        <?php echo pacto_get_svg( 'arrow-left' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </button>
                    <button type="button" class="slider-btn" aria-label="<?php esc_attr_e( 'Notícia Seguinte', 'pacto-25' ); ?>">
                        <?php echo pacto_get_svg( 'arrow-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </button>
                </div>

                <?php if ( $btn_text && $btn_url ) : ?>
                    <div style="margin-top: var(--space-md);">
                        <a href="<?php echo esc_url( $btn_url ); ?>" class="btn btn--dark">
                            <?php echo esc_html( $btn_text ); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
