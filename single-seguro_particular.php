<?php
/**
 * Single Template: Seguros Particulares
 * Description: Single page template for Seguros Particulares matching Figma Modelo-Seguro.
 * Theme: Pacto 25
 * Strict Agency SOP: Modular sections, fully decoupled ACF fields, zero bloated dependencies.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main single-seguro-main">
    <!-- 1. Hero: Encontre o melhor Seguro... (Right Circle Bleed) -->
    <?php get_template_part( 'template-parts/section', 'single-seguro-hero' ); ?>

    <!-- 2. O que é o Seguro? (Left Circle Bleed) -->
    <?php get_template_part( 'template-parts/section', 'single-seguro-about' ); ?>

    <!-- 3. Vantagens, Coberturas e Serviços (Right Giant Red Circle) -->
    <?php get_template_part( 'template-parts/section', 'single-seguro-features' ); ?>

    <!-- 4. Passos para Subscrição (3 Columns with Red Backdrop Bubbles) -->
    <?php get_template_part( 'template-parts/section', 'single-seguro-steps' ); ?>

    <!-- 5. Formulário de Simulação (Left Form + Right Clean Red Circle) -->
    <?php get_template_part( 'template-parts/section', 'single-seguro-form' ); ?>

    <!-- 6. Documentos Legais (PDF Downloads Grid + Offset Circle) -->
    <?php get_template_part( 'template-parts/section', 'single-seguro-docs' ); ?>

    <!-- 7. Questões Mais Frequentes (Reusable FAQs Accordion Component) -->
    <?php get_template_part( 'template-parts/section', 'faq' ); ?>
</main>

<?php
get_footer();
