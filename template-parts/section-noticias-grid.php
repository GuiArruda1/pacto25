<?php
/**
 * Template Part: Section Notícias Grid (2-Column Cards + Dynamic Pagination)
 * Theme: Pacto 25
 * 
 * Strict Agency SOP:
 * - Dynamic WordPress loop listing real published posts (no hardcoded/mock posts)
 * - Exactly 6 posts per page with responsive 2-column layout
 * - Dynamic pagination (< 1 2 3 >) only displayed when total posts > 6
 * - Accessible markup and clean semantic structure
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$default_img = get_template_directory_uri() . '/assets/news-teresinha-summit.png';

global $wp_query;
$max_pages    = isset( $wp_query->max_num_pages ) ? (int) $wp_query->max_num_pages : 1;
$current_page = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
?>

<section class="section section-noticias-grid" aria-label="<?php esc_attr_e( 'Lista de Notícias', 'pacto-25' ); ?>">
    <div class="site-container">
        <div class="noticias-grid">
            <?php 
            if ( have_posts() ) : 
                while ( have_posts() ) : the_post(); 
                    $post_id    = get_the_ID();
                    $permalink  = get_permalink();
                    $title      = get_the_title() ?: __( '(Sem título)', 'pacto-25' );
                    $date       = get_the_date( 'd/m/Y' );
                    $has_thumb  = has_post_thumbnail( $post_id );
                    $thumb_id   = get_post_thumbnail_id( $post_id );
                    $thumb_alt  = $has_thumb ? ( get_post_meta( $thumb_id, '_wp_attachment_image_alt', true ) ?: $title ) : $title;
                    $thumb_url  = $has_thumb ? get_the_post_thumbnail_url( $post_id, 'large' ) : $default_img;
                    $excerpt    = get_the_excerpt();
                ?>
                    <article id="post-<?php echo esc_attr( $post_id ); ?>" <?php post_class( 'noticia-card' ); ?>>
                        <!-- Left Thumbnail Frame -->
                        <div class="noticia-card__media">
                            <a href="<?php echo esc_url( $permalink ); ?>" class="noticia-card__media-link">
                                <img src="<?php echo esc_url( $thumb_url ); ?>" 
                                     alt="<?php echo esc_attr( $thumb_alt ); ?>" 
                                     class="noticia-card__img" 
                                     loading="lazy" 
                                     decoding="async" />
                            </a>
                        </div>

                        <!-- Right Text Content -->
                        <div class="noticia-card__body">
                            <div class="noticia-card__date-wrap">
                                <span class="noticia-card__bullet" aria-hidden="true">•</span>
                                <time class="noticia-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                    <?php echo esc_html( $date ); ?>
                                </time>
                            </div>

                            <h2 class="noticia-card__title">
                                <a href="<?php echo esc_url( $permalink ); ?>" class="noticia-card__title-link">
                                    <?php echo esc_html( $title ); ?>
                                </a>
                            </h2>

                            <?php if ( ! empty( $excerpt ) ) : ?>
                                <p class="noticia-card__excerpt">
                                    <?php echo esc_html( wp_strip_all_tags( $excerpt ) ); ?>
                                </p>
                            <?php endif; ?>

                            <a href="<?php echo esc_url( $permalink ); ?>" class="noticia-card__link" aria-label="<?php echo esc_attr( sprintf( __( 'Saber mais sobre %s', 'pacto-25' ), $title ) ); ?>">
                                <?php esc_html_e( 'saber mais', 'pacto-25' ); ?>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="noticias-empty" style="grid-column: 1 / -1; padding: 48px 0; text-align: center; color: var(--color-text-muted, #8E8A8B);">
                    <p style="font-size: 1.1rem; margin: 0;"><?php esc_html_e( 'Não foram encontradas notícias publicadas.', 'pacto-25' ); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <?php if ( $max_pages > 1 ) : 
            $big = 999999999;
            if ( is_page() ) {
                $base = trailingslashit( get_permalink() ) . ( get_option( 'permalink_structure' ) ? 'page/%#%/' : '?paged=%#%' );
            } else {
                $base = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );
            }
        ?>
            <!-- Left-Aligned Pagination (< 1 2 3 >) -->
            <nav class="noticias-pagination" aria-label="<?php esc_attr_e( 'Navegação de páginas de notícias', 'pacto-25' ); ?>">
                <?php
                echo paginate_links( array(
                    'base'      => $base,
                    'format'    => '?paged=%#%',
                    'current'   => $current_page,
                    'total'     => $max_pages,
                    'prev_text' => '<span class="pagination-arrow pagination-arrow--prev" aria-hidden="true">&lsaquo;</span><span class="screen-reader-text">' . esc_html__( 'Página anterior', 'pacto-25' ) . '</span>',
                    'next_text' => '<span class="pagination-arrow pagination-arrow--next" aria-hidden="true">&rsaquo;</span><span class="screen-reader-text">' . esc_html__( 'Página seguinte', 'pacto-25' ) . '</span>',
                    'type'      => 'list',
                    'end_size'  => 1,
                    'mid_size'  => 2,
                ) );
                ?>
            </nav>
        <?php endif; ?>
    </div>
</section>
