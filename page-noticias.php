<?php
/**
 * Template Name: Notícias
 * Description: Page template for Notícias archive page.
 * Theme: Pacto 25
 * Strict Agency SOP: Modular sections, fully decoupled ACF fields, zero bloated dependencies.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Setup global query for posts if on a static page template
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
$news_query = new WP_Query( array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => get_option( 'posts_per_page', 6 ),
    'paged'          => $paged,
) );

// Temporarily set $wp_query to $news_query so template parts and pagination work seamlessly
global $wp_query;
$temp_query = $wp_query;
$wp_query   = $news_query;
?>

<!-- 1. Hero: Fique a par das nossas Notícias (Top-Right Canopy + Ambient Bubble) -->
<?php get_template_part( 'template-parts/section', 'noticias-hero' ); ?>

<!-- 2. Grid: 2-Column Post Cards + Left-Aligned Pagination -->
<?php get_template_part( 'template-parts/section', 'noticias-grid' ); ?>

<?php
// Restore original query
$wp_query = $temp_query;
wp_reset_postdata();

get_footer();
