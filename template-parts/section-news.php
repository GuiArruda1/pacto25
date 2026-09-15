<?php
/**
 * Template Part: News & Events Spotlight Section
 * Theme: Pacto 25
 * Matches Figma design with full-height guidelines, decorative red rings, solid red offset circle, and chevrons
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = pacto_get_field( 'news_eyebrow', false, 'NOTÍCIAS MAIS RECENTES' );
$title       = pacto_get_field( 'news_title', false, 'Presença de Teresinha Pereira, CEO da Pacto Seguro no MAE Summit' );
$description = pacto_get_field( 'news_description', false, 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.' );
$btn_text    = pacto_get_field( 'news_btn_text', false, 'ver todas as notícias' );
$btn_url     = pacto_get_field( 'news_btn_url', false, '#noticias' );
$image       = pacto_get_field( 'news_image' );
$default_img = get_template_directory_uri() . '/assets/news-teresinha-summit.png';
?>

<section class="section section-news" id="noticias" aria-label="<?php esc_attr_e( 'Notícias e Eventos', 'pacto-25' ); ?>">
    <!-- Full-Height Vertical Guidelines -->
    <div class="news-guideline news-guideline--left" aria-hidden="true"></div>
    <div class="news-guideline news-guideline--right" aria-hidden="true"></div>

    <!-- Decorative Red Rings -->
    <div class="news-ring news-ring--bl" aria-hidden="true"></div>
    <div class="news-ring news-ring--br" aria-hidden="true"></div>

    <div class="site-container">
        <div class="news-layout">
            <!-- Visual Column (Left) -->
            <div class="news-visual">
                <!-- Large Solid Red Offset Circle behind Photo -->
                <div class="news-visual__circle-bg" aria-hidden="true"></div>

                <!-- Circular Photo Frame -->
                <div class="news-visual__photo-wrap">
                    <?php if ( ! empty( $image ) ) : ?>
                        <?php pacto_render_image( $image, 'large', 'news-image', $default_img ); ?>
                    <?php else : ?>
                        <img src="<?php echo esc_url( $default_img ); ?>" class="news-image" alt="<?php echo esc_attr( $title ); ?>" width="370" height="370" loading="lazy" decoding="async" />
                    <?php endif; ?>
                </div>
            </div>

            <!-- Content Column (Right) -->
            <div class="news-content">
                <?php if ( $eyebrow ) : ?>
                    <div class="news-eyebrow">
                        <span class="news-eyebrow__prefix" aria-hidden="true">+</span>
                        <span><?php echo esc_html( $eyebrow ); ?></span>
                    </div>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h2 class="h2 news-title"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                    <p class="lead news-description"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>

                <!-- Minimalist Chevrons Navigation -->
                <div class="news-nav" aria-label="<?php esc_attr_e( 'Navegação de notícias', 'pacto-25' ); ?>">
                    <button type="button" class="news-nav__btn" data-news-nav="prev" aria-label="<?php esc_attr_e( 'Notícia Anterior', 'pacto-25' ); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M15 18l-6-6 6-6"/>
                        </svg>
                    </button>
                    <button type="button" class="news-nav__btn" data-news-nav="next" aria-label="<?php esc_attr_e( 'Notícia Seguinte', 'pacto-25' ); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M9 18l6-6-6-6"/>
                        </svg>
                    </button>
                </div>

                <!-- CTA Button -->
                <?php if ( $btn_text && $btn_url ) : ?>
                    <div class="news-cta-wrap">
                        <a href="<?php echo esc_url( $btn_url ); ?>" class="btn news-btn">
                            <?php echo esc_html( $btn_text ); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
