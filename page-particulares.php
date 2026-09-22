<?php
/**
 * Template Name: Particulares
 * Description: Template for Seguros para Particulares page matching Figma design.
 * Theme: Pacto 25
 * Strict Agency SOP: Modular sections, fully decoupled ACF fields, zero bloated dependencies.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<!-- 1. Hero: Seguros para Particulares -->
<?php get_template_part( 'template-parts/section', 'particulares-hero' ); ?>

<!-- 2. Grid de Seguros Particulares -->
<?php get_template_part( 'template-parts/section', 'particulares-seguros' ); ?>

<!-- 3. Banner CTA Final (Reusable Component) -->
<?php get_template_part( 'template-parts/section', 'banner-cta' ); ?>

<?php
get_footer();
