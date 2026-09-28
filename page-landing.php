<?php
/**
 * Template Name: Landing Page (Modelo Seguro)
 * Description: Landing page template for single insurance matching Figma Modelo-Seguro.
 * Theme: Pacto 25
 * Strict Agency SOP: Modular sections, fully decoupled ACF fields, zero bloated dependencies.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<!-- 1. Hero: Encontre o melhor Seguro... (Right Circle Bleed) -->
<?php get_template_part( 'template-parts/section', 'single-seguro-hero' ); ?>

<!-- 2. O que é o Seguro? (Left Circle Bleed) -->
<?php get_template_part( 'template-parts/section', 'single-seguro-about' ); ?>

<!-- 3. Vantagens, Coberturas e Serviços (Right Giant Red Circle) -->
<?php get_template_part( 'template-parts/section', 'single-seguro-features' ); ?>

<!-- 4. Passos para Subscrição (3 Columns with Red Backdrop Bubbles) -->
<?php get_template_part( 'template-parts/section', 'single-seguro-steps' ); ?>

<!-- 5. Testemunhos (3D Cylindrical Arc Testimonial Layout) -->
<?php get_template_part( 'template-parts/section', 'testimonials' ); ?>

<!-- 6. Documentos Legais (PDF Downloads Grid + Offset Circle) -->
<?php get_template_part( 'template-parts/section', 'single-seguro-docs' ); ?>

<!-- 7. Questões Mais Frequentes (Reusable FAQs Accordion Component) -->
<?php get_template_part( 'template-parts/section', 'faq' ); ?>

<?php
get_footer();
