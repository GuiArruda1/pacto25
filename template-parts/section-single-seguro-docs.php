<?php
/**
 * Template Part: Single Seguro Particular - Documentos Legais
 * Theme: Pacto 25
 * Strict Agency SOP: Dynamic ACF bindings, 2x2 PDF document download grid, offset circular photo with ambient rings.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id     = get_the_ID();

$eyebrow     = pacto_get_field( 'seguro_docs_eyebrow', $post_id, 'LOREM IPSUM DOLOR SIT AMET' );
$title       = pacto_get_field( 'seguro_docs_title', $post_id, 'Documentos Legais' );
$description = pacto_get_field( 'seguro_docs_description', $post_id, 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.' );

$image       = pacto_get_field( 'seguro_docs_image', $post_id );
$default_img = get_template_directory_uri() . '/assets/images/single-seguro/seguro-docs-couple.png';

// Default documents list
$default_docs = array(
    array(
        'name' => 'Nome do Documento (2010-2023)',
        'file' => '#',
    ),
    array(
        'name' => 'Nome do Documento (2010-2023)',
        'file' => '#',
    ),
    array(
        'name' => 'Nome do Documento (2010-2023)',
        'file' => '#',
    ),
    array(
        'name' => 'Nome do Documento (2010-2023)',
        'file' => '#',
    ),
);

$docs = pacto_get_field( 'seguro_docs_list', $post_id, $default_docs );
if ( ! is_array( $docs ) || empty( $docs ) ) {
    $docs = $default_docs;
}
?>

<section class="section section-single-seguro-docs" aria-label="<?php echo esc_attr( $title ); ?>">
    <!-- Ambient Floating Red Rings (Left and Right) -->
    <div class="seguro-docs-ring seguro-docs-ring--left-small" aria-hidden="true"></div>
    <div class="seguro-docs-ring seguro-docs-ring--left-medium" aria-hidden="true"></div>
    <div class="seguro-docs-ring seguro-docs-ring--right-large" aria-hidden="true"></div>

    <div class="site-container">
        <div class="section-single-seguro-docs__layout">
            <!-- Left Visual Column (Photo with Red Backdrop Accent Bubble) -->
            <div class="section-single-seguro-docs__visual">
                <div class="seguro-docs-photo-wrap">
                    <div class="seguro-docs-backdrop-bubble" aria-hidden="true"></div>
                    <div class="seguro-docs-photo-circle">
                        <?php pacto_render_image( $image, 'large', 'seguro-docs-img', $default_img, true ); ?>
                    </div>
                </div>
            </div>

            <!-- Right Content & Documents Column -->
            <div class="section-single-seguro-docs__content">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h2 class="h2 section-single-seguro-docs__title"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                    <p class="section-single-seguro-docs__desc"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>

                <!-- 2x2 Documents Download Grid -->
                <div class="seguro-docs-grid">
                    <?php foreach ( $docs as $doc ) : 
                        $doc_name = ! empty( $doc['name'] ) ? $doc['name'] : 'Nome do Documento (2010-2023)';
                        $doc_file = ! empty( $doc['file'] ) ? ( is_array( $doc['file'] ) ? $doc['file']['url'] : $doc['file'] ) : '#';
                    ?>
                        <a href="<?php echo esc_url( $doc_file ); ?>" class="seguro-doc-card" target="_blank" rel="noopener noreferrer">
                            <div class="seguro-doc-card__icon" aria-hidden="true">
                                <?php echo pacto_get_svg( 'pdf' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </div>
                            <span class="seguro-doc-card__name"><?php echo esc_html( $doc_name ); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
