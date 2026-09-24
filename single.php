<?php
/**
 * Single Post Template: Default WordPress Posts (Notícias)
 * Theme: Pacto 25
 * Strict Agency SOP: Modular sections, responsive layout, fluid typography
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$news_page = get_page_by_path( 'noticias' );
$news_url  = $news_page ? get_permalink( $news_page->ID ) : home_url( '/noticias' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-noticia-article' ); ?>>
    <!-- Background Top-Right Red Canopy -->
    <div class="noticias-hero-canopy" aria-hidden="true"></div>

    <div class="site-container">
        <header class="single-noticia-header">
            <div class="single-noticia-meta">
                <a href="<?php echo esc_url( $news_url ); ?>" class="single-noticia-eyebrow">
                    <?php esc_html_e( '• NOTÍCIAS — PACTO SEGURO', 'pacto-25' ); ?>
                </a>
                <span class="single-noticia-meta-sep" aria-hidden="true">|</span>
                <time class="single-noticia-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                    <?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?>
                </time>
            </div>

            <h1 class="h1 single-noticia-title"><?php the_title(); ?></h1>
        </header>

        <?php if ( has_post_thumbnail() ) : ?>
            <div class="single-noticia-featured-media">
                <?php the_post_thumbnail( 'full', array( 'class' => 'single-noticia-featured-img' ) ); ?>
            </div>
        <?php endif; ?>

        <div class="single-noticia-content-wrap">
            <div class="entry-content single-noticia-content">
                <?php
                while ( have_posts() ) :
                    the_post();
                    the_content();
                endwhile;
                ?>
            </div>

            <div class="single-noticia-footer-nav">
                <a href="<?php echo esc_url( $news_url ); ?>" class="btn btn-outline single-noticia-back-btn">
                    &larr; <?php esc_html_e( 'Ver todas as notícias', 'pacto-25' ); ?>
                </a>
            </div>
        </div>
    </div>
</article>

<?php
get_footer();
