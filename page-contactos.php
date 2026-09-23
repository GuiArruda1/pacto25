<?php
/**
 * Template Name: Contactos
 * Description: Page template for Contactos page.
 * Theme: Pacto 25
 * Strict Agency SOP: Modular sections, fully decoupled ACF fields, zero bloated dependencies.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<!-- 1. Hero: Entre em Contacto com a Pacto Seguro (Left Meta Info + Right Visual & Ambient Bubbles) -->
<?php get_template_part( 'template-parts/section', 'contactos-hero' ); ?>

<!-- 2. Como podemos ajudar? (Left Circular Photo + Right 2-Column Contact Form) -->
<?php get_template_part( 'template-parts/section', 'contactos-form' ); ?>

<?php
get_footer();
