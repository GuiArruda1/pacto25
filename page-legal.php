<?php
/**
 * Template Name: Página Legal / Texto
 * Description: Clean text layout for legal, policy, and compliance pages.
 * Theme: Pacto 25
 * 
 * Strict Agency SOP:
 * - Decoupled ACF fields with sensible fallbacks
 * - Strict escaping
 * - Fluid typography & semantic layout
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

while ( have_posts() ) :
    the_post();

    $post_id = get_the_ID();
    $eyebrow = pacto_get_field( 'eyebrow', $post_id, 'PACTO SEGURO' );
    if ( empty( $eyebrow ) ) {
        $eyebrow = 'PACTO SEGURO';
    }
    $page_title = pacto_get_field( 'page_title', $post_id, get_the_title() );
    if ( empty( $page_title ) ) {
        $page_title = get_the_title();
    }
?>

<div class="legal-page">
    <div class="legal-page__container">
        <div class="legal-page__inner">
            <?php if ( ! empty( $eyebrow ) ) : ?>
                <div class="legal-page__eyebrow">
                    <span class="legal-page__eyebrow-bullet" aria-hidden="true"></span>
                    <span class="legal-page__eyebrow-text"><?php echo esc_html( $eyebrow ); ?></span>
                </div>
            <?php endif; ?>

            <h1 class="legal-page__title"><?php echo esc_html( $page_title ); ?></h1>

            <div class="entry-content legal-page__content">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</div>

<?php
endwhile;

get_footer();
