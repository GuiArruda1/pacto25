<?php
/**
 * Template Name: Notícias (Blog Archive)
 * Description: Main archive template for WordPress Posts / Notícias.
 * Theme: Pacto 25
 * Strict Agency SOP: Modular sections, fully decoupled ACF fields, zero bloated dependencies.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<!-- 1. Hero: Fique a par das nossas Notícias (Top-Right Canopy + Ambient Bubble) -->
<?php get_template_part( 'template-parts/section', 'noticias-hero' ); ?>

<!-- 2. Grid: 2-Column Post Cards + Left-Aligned Pagination -->
<?php get_template_part( 'template-parts/section', 'noticias-grid' ); ?>

<?php
get_footer();
