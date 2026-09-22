<?php
/**
 * Template Part: Quem Somos - Porque o fazemos? Section
 * Theme: Pacto 25
 * Strict Agency SOP: Decoupled ACF fields, fluid layout, strict escaping.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = pacto_get_field( 'qs_why_eyebrow', false, 'PORQUE O FAZEMOS?' );
$title       = pacto_get_field( 'qs_why_title', false, 'Porque o fazemos?' );
$description = pacto_get_field( 'qs_why_description', false, 'Para provocar nas pessoas a responsabilidade e o sentido da melhor proteção das suas vidas e dos seus bens. Num mercado cada vez mais exigente, com um maior risco associado, entendemos sermos uma equipa multifacetada que acrescenta valor e credibilidade nas relações com os seus Clientes. Valorizamos as suas identidades, o seu negócio, o seu serviço com uma equipa especializada a cada caso. Trabalhamos sempre para prestar um serviço de alta qualidade com total independência e respeito por todos os intervenientes da relação.' );
$image       = pacto_get_field( 'qs_why_image' );
$default_img = get_template_directory_uri() . '/assets/images/quem-somos/qs-why-phone.png';
?>

<section class="section section-qs-why" aria-label="<?php esc_attr_e( 'Porque o fazemos?', 'pacto-25' ); ?>">
    <div class="site-container">
        <div class="section-qs-why__layout">
            <!-- Visual Column: Circular photo with thick red border ring -->
            <div class="section-qs-why__visual">
                <div class="qs-why-circle-frame">
                    <div class="qs-why-circle-ring" aria-hidden="true"></div>
                    <div class="qs-why-circle-photo">
                        <?php pacto_render_image( $image, 'large', 'qs-why-photo', $default_img, false ); ?>
                    </div>
                </div>
            </div>

            <!-- Content Column -->
            <div class="section-qs-why__content">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h2 class="h2 section-qs-why__title"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                    <p class="section-qs-why__text"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
