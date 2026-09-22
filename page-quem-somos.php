<?php
/**
 * Template Name: Quem Somos
 * Description: Template for Quem Somos / Institucional page matching Figma design.
 * Theme: Pacto 25
 * Strict Agency SOP: Modular sections, fully decoupled ACF fields, zero bloated dependencies.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<!-- 1. Hero: Quem Somos Seguros à Medida -->
<?php get_template_part( 'template-parts/section', 'qs-hero' ); ?>

<!-- 2. Porque o fazemos? -->
<?php get_template_part( 'template-parts/section', 'qs-why' ); ?>

<!-- 3. Missão, Visão e Valores (Red Canopy Section) -->
<?php get_template_part( 'template-parts/section', 'qs-mission' ); ?>

<!-- 4. Porquê escolher-nos (Narrative & Red Circle Features Grid) -->
<?php get_template_part( 'template-parts/section', 'qs-reasons' ); ?>

<!-- 5. A Nossa Equipa (Staggered Constellation) -->
<?php get_template_part( 'template-parts/section', 'qs-team' ); ?>

<!-- 6. Banner CTA Final -->
<?php get_template_part( 'template-parts/section', 'qs-cta' ); ?>

<?php
get_footer();
