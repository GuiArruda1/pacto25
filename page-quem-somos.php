<?php
/**
 * Template Name: Quem Somos
 * Description: Page template for the Quem Somos / Institucional page.
 * Theme: Pacto 25
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<!-- 1. Banner Principal Quem Somos -->
<?php get_template_part( 'template-parts/section', 'banner-quem-somos' ); ?>

<!-- 2. Secção Sobre / História -->
<?php get_template_part( 'template-parts/section', 'about' ); ?>

<!-- 3. Testemunhos de Clientes -->
<?php get_template_part( 'template-parts/section', 'testimonials' ); ?>

<!-- 4. Subscrição Newsletter -->
<?php get_template_part( 'template-parts/section', 'newsletter' ); ?>

<?php
get_footer();
