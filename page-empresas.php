<?php
/**
 * Template Name: Empresas
 * Description: Template for Seguros para Empresas page matching Figma design.
 * Theme: Pacto 25
 * Strict Agency SOP: Modular sections, fully decoupled ACF fields, zero bloated dependencies.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<!-- 1. Hero: Seguros para Empresas -->
<?php get_template_part( 'template-parts/section', 'empresas-hero' ); ?>

<!-- 2. Grid de Seguros Empresas -->
<?php get_template_part( 'template-parts/section', 'empresas-seguros' ); ?>

<!-- 3. Banner CTA Final (Reusable Component) -->
<?php get_template_part( 'template-parts/section', 'banner-cta' ); ?>

<?php
get_footer();
