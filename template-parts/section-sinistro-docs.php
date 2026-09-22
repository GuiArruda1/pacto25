<?php
/**
 * Template Part: Section Sinistro Documentos ("Documentos Necessários")
 * Theme: Pacto 25
 * 
 * Strict Agency SOP:
 * - Left photo with red backdrop bubble + Right 2x2 PDF Downloads Grid
 * - Fully ACF decoupled with fallbacks
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = pacto_get_field( 'sinistro_docs_eyebrow', false, 'LEGAL — PACTO SEGURO 25 ANOS' );
$title       = pacto_get_field( 'sinistro_docs_title', false, 'Documentos Necessários' );
$description = pacto_get_field( 'sinistro_docs_description', false, 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );
$image_obj   = pacto_get_field( 'sinistro_docs_image', false );

$image_url = ! empty( $image_obj['url'] ) ? $image_obj['url'] : get_template_directory_uri() . '/assets/images/single-seguro/seguro-docs-couple.png';
$image_alt = ! empty( $image_obj['alt'] ) ? $image_obj['alt'] : esc_attr( $title );

$docs_list = pacto_get_field( 'sinistro_docs_list', false );
if ( empty( $docs_list ) || ! is_array( $docs_list ) ) {
    $docs_list = array(
        array( 'name' => 'Nome do Documento (2010-2023)', 'file' => array( 'url' => '#' ) ),
        array( 'name' => 'Nome do Documento (2010-2023)', 'file' => array( 'url' => '#' ) ),
        array( 'name' => 'Nome do Documento (2010-2023)', 'file' => array( 'url' => '#' ) ),
        array( 'name' => 'Nome do Documento (2010-2023)', 'file' => array( 'url' => '#' ) ),
    );
}
?>

<section class="section section-sinistro-docs" aria-label="<?php echo esc_attr( $title ); ?>">
    <!-- Ambient Floating Red Rings -->
    <div class="sinistro-docs-ring sinistro-docs-ring--left" aria-hidden="true"></div>
    <div class="sinistro-docs-ring sinistro-docs-ring--mid-bottom" aria-hidden="true"></div>
    <div class="sinistro-docs-ring sinistro-docs-ring--right" aria-hidden="true"></div>

    <div class="site-container">
        <div class="sinistro-docs-grid">
            <!-- Left Photo with Offset Red Backdrop Bubble -->
            <div class="sinistro-docs-visual">
                <div class="sinistro-docs-photo-frame">
                    <img src="<?php echo esc_url( $image_url ); ?>" 
                         alt="<?php echo esc_attr( $image_alt ); ?>" 
                         loading="lazy" />
                </div>
            </div>

            <!-- Right Content & 2x2 PDF Downloads Grid -->
            <div class="sinistro-docs-content">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow sinistro-docs-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h2 class="h2 sinistro-docs-title"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                    <p class="sinistro-docs-desc"><?php echo nl2br( esc_html( $description ) ); ?></p>
                <?php endif; ?>

                <?php if ( ! empty( $docs_list ) ) : ?>
                    <div class="sinistro-docs-list">
                        <?php foreach ( $docs_list as $doc ) : 
                            $doc_name = ! empty( $doc['name'] ) ? $doc['name'] : 'Documento';
                            $file_url = ! empty( $doc['file']['url'] ) ? $doc['file']['url'] : '#';
                        ?>
                            <a href="<?php echo esc_url( $file_url ); ?>" class="sinistro-doc-item" target="_blank" rel="noopener noreferrer">
                                <span class="sinistro-doc-icon" aria-hidden="true">
                                    <?php echo pacto_get_svg( 'pdf' ); ?>
                                </span>
                                <span class="sinistro-doc-name"><?php echo esc_html( $doc_name ); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
