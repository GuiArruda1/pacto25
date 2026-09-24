<?php
/**
 * Template Name: Protocolos
 * Theme: Pacto 25
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

while ( have_posts() ) :
    the_post();

    // 1. Hero Section
    get_template_part( 'template-parts/section', 'protocolos-hero' );

    // 2. Condições Especiais Section
    get_template_part( 'template-parts/section', 'protocolos-condicoes' );

    // 3. Descubra as Condições (Accordion/FAQ) Section
    get_template_part( 'template-parts/section', 'protocolos-faq' );

    // 4. CTA Banner Section
    get_template_part( 'template-parts/section', 'protocolos-cta' );

endwhile;

get_footer();
