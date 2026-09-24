<?php
/**
 * Template Part: Section Notícias Hero ("Fique a par das nossas Notícias")
 * Theme: Pacto 25
 * 
 * Strict Agency SOP:
 * - Decoupled ACF fields with complete fallback defaults
 * - Top-right giant red canopy & floating ambient red bubble
 * - Eyebrow, H1 title, and introductory lead description
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page_id = get_the_ID() ?: get_queried_object_id();
if ( ! $page_id || is_home() || is_archive() ) {
    $news_page = get_page_by_path( 'noticias' );
    if ( $news_page ) {
        $page_id = $news_page->ID;
    }
}

// ACF Fields with Figma Fallback Defaults
$eyebrow     = pacto_get_field( 'noticias_archive_eyebrow', $page_id, '• NOTÍCIAS — PACTO SEGURO' );
$title       = pacto_get_field( 'noticias_archive_title', $page_id, 'Fique a par das nossas Notícias' );
$description = pacto_get_field( 'noticias_archive_description', $page_id, 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.' );

// If category/tag archive, dynamically adapt title if desired
if ( is_category() ) {
    $eyebrow = '• CATEGORIA — NOTÍCIAS';
    $title   = single_cat_title( '', false );
} elseif ( is_tag() ) {
    $eyebrow = '• TAG — NOTÍCIAS';
    $title   = single_tag_title( '', false );
}
?>

<section class="section section-noticias-hero" aria-label="<?php echo esc_attr( wp_strip_all_tags( $title ) ); ?>">
    <!-- Background Top-Right Giant Organic Red Canopy -->
    <div class="noticias-hero-canopy" aria-hidden="true"></div>

    <!-- Floating Ambient Solid Red Dot matching Figma -->
    <div class="noticias-hero-bubble" aria-hidden="true"></div>

    <div class="site-container">
        <div class="noticias-hero-content">
            <?php if ( $eyebrow ) : ?>
                <span class="eyebrow noticias-hero-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>

            <?php if ( $title ) : ?>
                <h1 class="h1 noticias-hero-title"><?php echo esc_html( $title ); ?></h1>
            <?php endif; ?>

            <?php if ( $description ) : ?>
                <p class="lead noticias-hero-description"><?php echo esc_html( $description ); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>
