<?php
/**
 * Front Page Template
 * Theme: Pacto 25
 * Assembles all modular homepage components matching the Figma landing page
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<!-- 1. Hero Section -->
<?php get_template_part( 'template-parts/section', 'hero' ); ?>

<!-- 2. About Section -->
<?php get_template_part( 'template-parts/section', 'about' ); ?>

<!-- 3. Prominent Full Circle Red Section (Soluções Globais & Empresas) -->
<section class="section-curved-red" aria-label="<?php esc_attr_e( 'Soluções de Seguros', 'pacto-25' ); ?>">
    <!-- Giant Full Circle bleeding out of container -->
    <div class="curved-red-bg-circle" aria-hidden="true">
        <div class="curved-red-deco curved-red-deco--top-right"></div>
        <div class="curved-red-deco curved-red-deco--dot-tr"></div>
        <div class="curved-red-deco curved-red-deco--bottom"></div>
        <div class="curved-red-deco curved-red-deco--dot-bl1"></div>
        <div class="curved-red-deco curved-red-deco--dot-bl2"></div>
    </div>

    <!-- 2 Rows 4 Columns inside Container -->
    <div class="site-container curved-red__inner">
        <?php get_template_part( 'template-parts/section', 'solutions-global' ); ?>
        <?php get_template_part( 'template-parts/section', 'solutions-business' ); ?>
    </div>
</section>

<!-- 4. Soluções para Particulares -->
<?php get_template_part( 'template-parts/section', 'solutions-personal' ); ?>

<!-- 5. Testemunhos de Clientes -->
<?php get_template_part( 'template-parts/section', 'testimonials' ); ?>

<!-- 6. Notícias & Eventos Spotlight -->
<?php get_template_part( 'template-parts/section', 'news' ); ?>

<!-- 7. Dicas & Subscrição Newsletter -->
<?php get_template_part( 'template-parts/section', 'newsletter' ); ?>

<?php
get_footer();
