<?php
/**
 * Template Name: Em Caso de Sinistro
 * Description: Page template for Sinistro management and claim reporting.
 * Theme: Pacto 25
 * Strict Agency SOP: Modular sections, fully decoupled ACF fields, zero bloated dependencies.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<!-- 1. Hero: Em Caso de Sinistro (Left Text + Right Visual & Ambient Bubbles) -->
<?php get_template_part( 'template-parts/section', 'sinistro-hero' ); ?>

<!-- 2. Como Participar um Sinistro (Left Circular Photo + Right 5-Step Checklist) -->
<?php get_template_part( 'template-parts/section', 'sinistro-steps' ); ?>

<!-- 3. Participar Sinistro (Left Giant Red Circle Form + Right Circular Photo) -->
<?php get_template_part( 'template-parts/section', 'sinistro-form' ); ?>

<!-- 4. Documentos Necessários (Left Circular Photo + Right 2x2 PDF Downloads Grid) -->
<?php get_template_part( 'template-parts/section', 'sinistro-docs' ); ?>

<!-- 5. Questões Mais Frequentes (Reusable FAQs Accordion Component) -->
<?php get_template_part( 'template-parts/section', 'faq' ); ?>

<?php
get_footer();
