<?php
/**
 * Template Part: Section Sinistro Steps ("Como Participar um Sinistro")
 * Theme: Pacto 25
 * 
 * Strict Agency SOP:
 * - Dynamic ACF bindings with fallback
 * - Left circular photo frame + Right 5-step checklist
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow   = pacto_get_field( 'sinistro_steps_eyebrow', false, '• SINISTROS — PACTO SEGURO' );
$title     = pacto_get_field( 'sinistro_steps_title', false, 'Como Participar um Sinistro' );
$image_obj = pacto_get_field( 'sinistro_steps_image', false );

$image_url = ! empty( $image_obj['url'] ) ? $image_obj['url'] : get_template_directory_uri() . '/assets/images/sinistro/sinistro-steps-couple.png';
$image_alt = ! empty( $image_obj['alt'] ) ? $image_obj['alt'] : esc_attr( $title );

$steps = pacto_get_field( 'sinistro_steps_list', false );
if ( empty( $steps ) || ! is_array( $steps ) ) {
    $steps = array(
        array( 'text' => '1. Contacte a Pacto Seguro: 229 039 777 ou teresa.sousa@pactoseguro.com' ),
        array( 'text' => '2. Envie a documentação necessária' ),
        array( 'text' => '3. Analisamos a participação' ),
        array( 'text' => '4. Acompanhamos todo o processo junto da seguradora' ),
        array( 'text' => '5. Mantemos o acompanhamento até à resolução' ),
    );
}
?>

<section class="section section-sinistro-steps" aria-label="<?php echo esc_attr( $title ); ?>">
    <div class="site-container">
        <div class="sinistro-steps-grid">
            <!-- Left Circular Photo Frame with Thick Red Ring -->
            <div class="paired-top-visual sinistro-steps-visual section-qs-why__visual">
                <div class="circle-frame--ring qs-why-circle-frame sinistro-steps-circle-frame">
                    <div class="circle-frame__ring qs-why-circle-ring" aria-hidden="true"></div>
                    <div class="circle-frame__photo qs-why-circle-photo">
                        <img src="<?php echo esc_url( $image_url ); ?>" 
                             alt="<?php echo esc_attr( $image_alt ); ?>" 
                             loading="lazy" />
                    </div>
                </div>
            </div>

            <!-- Right 5-Step Checklist -->
            <div class="sinistro-steps-content">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow sinistro-steps-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h2 class="h2 sinistro-steps-title"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( ! empty( $steps ) ) : ?>
                    <ol class="sinistro-steps-list">
                        <?php foreach ( $steps as $index => $step ) : 
                            $step_text = ! empty( $step['text'] ) ? $step['text'] : '';
                            if ( empty( $step_text ) ) continue;

                            if ( preg_match( '/^(\d+\.)\s*(.*)$/', $step_text, $matches ) ) {
                                $step_num  = $matches[1];
                                $step_desc = $matches[2];
                            } else {
                                $step_num  = ( $index + 1 ) . '.';
                                $step_desc = $step_text;
                            }
                        ?>
                            <li class="sinistro-steps-item">
                                <span class="sinistro-steps-num"><?php echo esc_html( $step_num ); ?></span>
                                <span class="sinistro-steps-text"><?php echo esc_html( $step_desc ); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
