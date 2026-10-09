<?php
/**
 * Template Part: Hero Section
 * Theme: Pacto 25
 * Strict Agency SOP: Fully decoupled text & repeater slides via WordPress native meta box API
 */

if (!defined('ABSPATH')) {
    exit;
}

$slides = pacto_get_hero_slides();
$slide_count = count($slides);
?>

<section class="section section-hero" aria-label="<?php esc_attr_e('Destaque Principal', 'pacto-25'); ?>"
    data-hero-slider>

    <div class="site-container hero-slider-container">
        <div class="hero-slider-track" id="heroSliderTrack">
            <?php foreach ($slides as $i => $slide):
                $eyebrow = isset($slide['eyebrow']) ? trim($slide['eyebrow']) : '';
                $title = isset($slide['title']) ? trim($slide['title']) : '';
                $description = isset($slide['description']) ? trim($slide['description']) : '';
                $btn_text = isset($slide['btn_text']) ? trim($slide['btn_text']) : '';
                $btn_url = isset($slide['btn_url']) ? trim($slide['btn_url']) : '#';
                $image_id = isset($slide['image_id']) ? (int) $slide['image_id'] : 0;
                $image_url = isset($slide['image_url']) ? trim($slide['image_url']) : '';
                $is_first = (0 === $i);
                $theme_doctor_img = get_template_directory_uri() . '/assets/images/home-hero-doctor.png';
                $theme_doctor_path = get_template_directory() . '/assets/images/home-hero-doctor.png';
                $fixed_doctor_img = $theme_doctor_img . ( file_exists( $theme_doctor_path ) ? '?v=' . filemtime( $theme_doctor_path ) : '' );

                $is_doctor_slide = ( 0 === $i ) || ( ! empty( $image_url ) && false !== strpos( $image_url, 'Group-7-1' ) );
                if ( ! $is_doctor_slide && $image_id > 0 ) {
                    $att_url = wp_get_attachment_url( $image_id );
                    if ( $att_url && false !== strpos( $att_url, 'Group-7-1' ) ) {
                        $is_doctor_slide = true;
                    }
                }

                $default_img = $fixed_doctor_img;
                $img_source = $is_doctor_slide ? $fixed_doctor_img : ( $image_id > 0 ? $image_id : ( ! empty( $image_url ) ? $image_url : $default_img ) );
                ?>
                <div class="hero-slide <?php echo $is_first ? 'is-active' : ''; ?>"
                    data-slide-index="<?php echo esc_attr($i); ?>"
                    aria-hidden="<?php echo $is_first ? 'false' : 'true'; ?>" role="group" aria-roledescription="slide"
                    aria-label="<?php echo esc_attr(sprintf(__('Slide %1$d de %2$d', 'pacto-25'), $i + 1, $slide_count)); ?>">
                    <div class="split-layout">
                        <!-- Content Column -->
                        <div class="section-hero__content">
                            <?php if (!empty($eyebrow)): ?>
                                <div class="eyebrow"><?php echo esc_html($eyebrow); ?></div>
                            <?php endif; ?>

                            <?php if (!empty($title)): ?>
                                <h1 class="h1"><?php echo esc_html($title); ?></h1>
                            <?php endif; ?>

                            <?php if (!empty($description)): ?>
                                <p class="lead"><?php echo esc_html($description); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($btn_text)): ?>
                                <div style="margin-top: var(--space-md);">
                                    <a href="<?php echo esc_url(pacto_format_url($btn_url)); ?>" class="btn btn--dark">
                                        <span><?php echo esc_html($btn_text); ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <!-- Slider arrows -->
                            <div class="slider-controls hero-slider-controls"
                                aria-label="<?php esc_attr_e('Navegação do slider hero', 'pacto-25'); ?>">
                                <button type="button" class="slider-btn hero-slider-btn hero-slider-btn--prev"
                                    data-hero-action="prev"
                                    aria-label="<?php esc_attr_e('Slide Anterior', 'pacto-25'); ?>">
                                    <?php echo pacto_get_svg('arrow-left'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                </button>
                                <button type="button" class="slider-btn hero-slider-btn hero-slider-btn--next"
                                    data-hero-action="next"
                                    aria-label="<?php esc_attr_e('Slide Seguinte', 'pacto-25'); ?>">
                                    <?php echo pacto_get_svg('arrow-right'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                </button>
                            </div>
                        </div>

                        <!-- Visual Column (bleeds to right viewport edge) -->
                        <div class="section-hero__visual">
                            <div class="section-hero__image-wrapper">
                                <?php
                                pacto_render_image($img_source, 'full', 'section-hero__image', $default_img, $is_first);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>