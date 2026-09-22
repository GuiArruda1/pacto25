<?php
/**
 * Template Part: Single Seguro Particular - 3 Passos Section
 * Theme: Pacto 25
 * Strict Agency SOP: Dynamic ACF bindings, 3-column steps layout with staggered red backdrop bubble accents.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id = get_the_ID();

// Default 3 steps configuration
$default_steps = array(
    array(
        'title'       => '1º Passo',
        'description' => 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
        'image_file'  => 'passo-1.png',
        'accent_pos'  => 'top-left',
    ),
    array(
        'title'       => '2º Passo',
        'description' => 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
        'image_file'  => 'passo-2.png',
        'accent_pos'  => 'top-right',
    ),
    array(
        'title'       => '3º Passo',
        'description' => 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
        'image_file'  => 'passo-3.png',
        'accent_pos'  => 'bottom-left',
    ),
);

$step_1_title = pacto_get_field( 'seguro_step_1_title', $post_id, '1º Passo' );
$step_1_desc  = pacto_get_field( 'seguro_step_1_desc', $post_id, 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.' );
$step_1_img   = pacto_get_field( 'seguro_step_1_image', $post_id );

$step_2_title = pacto_get_field( 'seguro_step_2_title', $post_id, '2º Passo' );
$step_2_desc  = pacto_get_field( 'seguro_step_2_desc', $post_id, 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.' );
$step_2_img   = pacto_get_field( 'seguro_step_2_image', $post_id );

$step_3_title = pacto_get_field( 'seguro_step_3_title', $post_id, '3º Passo' );
$step_3_desc  = pacto_get_field( 'seguro_step_3_desc', $post_id, 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.' );
$step_3_img   = pacto_get_field( 'seguro_step_3_image', $post_id );

$steps_data = array(
    array(
        'title'       => $step_1_title,
        'description' => $step_1_desc,
        'image'       => $step_1_img,
        'default_img' => get_template_directory_uri() . '/assets/images/single-seguro/passos/passo-1.png',
        'accent_pos'  => 'top-left',
    ),
    array(
        'title'       => $step_2_title,
        'description' => $step_2_desc,
        'image'       => $step_2_img,
        'default_img' => get_template_directory_uri() . '/assets/images/single-seguro/passos/passo-2.png',
        'accent_pos'  => 'top-right',
    ),
    array(
        'title'       => $step_3_title,
        'description' => $step_3_desc,
        'image'       => $step_3_img,
        'default_img' => get_template_directory_uri() . '/assets/images/single-seguro/passos/passo-3.png',
        'accent_pos'  => 'bottom-left',
    ),
);
?>

<section class="section section-single-seguro-steps" aria-label="<?php esc_attr_e( 'Passos para subscrição', 'pacto-25' ); ?>">
    <!-- Ambient Floating Red Dots (Exact Figma Coordinates) -->
    <div class="seguro-steps-dot seguro-steps-dot--top-left" aria-hidden="true"></div>
    <div class="seguro-steps-dot seguro-steps-dot--top-mid" aria-hidden="true"></div>
    <div class="seguro-steps-dot seguro-steps-dot--center" aria-hidden="true"></div>
    <div class="seguro-steps-dot seguro-steps-dot--right-mid" aria-hidden="true"></div>
    <div class="seguro-steps-dot seguro-steps-dot--right-bot" aria-hidden="true"></div>

    <div class="site-container">
        <div class="seguro-steps-grid">
            <?php foreach ( $steps_data as $index => $step ) : ?>
                <div class="seguro-step-item seguro-step-item--<?php echo esc_attr( $index + 1 ); ?>">
                    <div class="seguro-step-item__photo-wrap">
                        <!-- Solid Red Backdrop Bubble Accent -->
                        <div class="seguro-step-item__backdrop-dot seguro-step-item__backdrop-dot--<?php echo esc_attr( $step['accent_pos'] ); ?>" aria-hidden="true"></div>
                        
                        <!-- Circular Photo -->
                        <div class="seguro-step-item__photo-circle">
                            <?php pacto_render_image( $step['image'], 'medium', 'seguro-step-img', $step['default_img'], true ); ?>
                        </div>
                    </div>

                    <div class="seguro-step-item__content">
                        <h3 class="seguro-step-item__title"><?php echo esc_html( $step['title'] ); ?></h3>
                        <p class="seguro-step-item__desc"><?php echo esc_html( $step['description'] ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
