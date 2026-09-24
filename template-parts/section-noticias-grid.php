<?php
/**
 * Template Part: Section Notícias Grid (2-Column Cards + Left-Aligned Pagination)
 * Theme: Pacto 25
 * 
 * Strict Agency SOP:
 * - Dynamic WordPress loop with high-fidelity fallback demo cards
 * - 2-column responsive layout with smooth rounded image frames
 * - Left-aligned pagination matching Figma design (< 1 2 3 4 >)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$default_img = get_template_directory_uri() . '/assets/news-teresinha-summit.png';
?>

<section class="section section-noticias-grid" aria-label="<?php esc_attr_e( 'Lista de Notícias', 'pacto-25' ); ?>">
    <div class="site-container">
        <div class="noticias-grid">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); 
                    $post_id    = get_the_ID();
                    $permalink  = get_permalink();
                    $title      = get_the_title();
                    $date       = get_the_date( 'd/m/Y' );
                    $has_thumb  = has_post_thumbnail( $post_id );
                    $thumb_id   = get_post_thumbnail_id( $post_id );
                    $thumb_alt  = $has_thumb ? ( get_post_meta( $thumb_id, '_wp_attachment_image_alt', true ) ?: $title ) : $title;
                    $thumb_url  = $has_thumb ? get_the_post_thumbnail_url( $post_id, 'large' ) : $default_img;
                    $excerpt    = get_the_excerpt();
                    if ( empty( $excerpt ) ) {
                        $excerpt = wp_trim_words( get_the_content(), 22, '...' );
                    }
                ?>
                    <article id="post-<?php echo esc_attr( $post_id ); ?>" <?php post_class( 'noticia-card' ); ?>>
                        <!-- Left Thumbnail Frame -->
                        <div class="noticia-card__media">
                            <a href="<?php echo esc_url( $permalink ); ?>" class="noticia-card__media-link" tabindex="-1" aria-hidden="true">
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
                                <a href="<?php echo esc_url( $permalink ); ?>">
                                    <?php echo esc_html( $title ); ?>
                                </a>
                            </h2>

                            <?php if ( $excerpt ) : ?>
                                <p class="noticia-card__excerpt">
                                    <?php echo esc_html( wp_strip_all_tags( $excerpt ) ); ?>
                                </p>
                            <?php endif; ?>

                            <a href="<?php echo esc_url( $permalink ); ?>" class="noticia-card__link">
                                <?php esc_html_e( 'saber mais', 'pacto-25' ); ?>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>

            <?php else : ?>
                <!-- Agency Fallback Demo Cards (Matches Figma Mockup Exactly) -->
                <?php
                $mock_posts = array(
                    array(
                        'date'    => '25/06/2026',
                        'title'   => 'Presença de Teresinha Pereira, CEO da Pacto Seguro no MAE Summit',
                        'excerpt' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
                    ),
                    array(
                        'date'    => '25/06/2026',
                        'title'   => 'Presença de Teresinha Pereira, CEO da Pacto Seguro no MAE Summit',
                        'excerpt' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
                    ),
                    array(
                        'date'    => '25/06/2026',
                        'title'   => 'Presença de Teresinha Pereira, CEO da Pacto Seguro no MAE Summit',
                        'excerpt' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
                    ),
                    array(
                        'date'    => '25/06/2026',
                        'title'   => 'Presença de Teresinha Pereira, CEO da Pacto Seguro no MAE Summit',
                        'excerpt' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
                    ),
                    array(
                        'date'    => '24/06/2026',
                        'title'   => 'Presença de Teresinha Pereira, CEO da Pacto Seguro no MAE Summit',
                        'excerpt' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
                    ),
                    array(
                        'date'    => '24/06/2026',
                        'title'   => 'Presença de Teresinha Pereira, CEO da Pacto Seguro no MAE Summit',
                        'excerpt' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
                    ),
                );

                foreach ( $mock_posts as $mock ) :
                ?>
                    <article class="noticia-card noticia-card--mock">
                        <div class="noticia-card__media">
                            <a href="#post-demo" class="noticia-card__media-link" tabindex="-1" aria-hidden="true">
                                <img src="<?php echo esc_url( $default_img ); ?>" 
                                     alt="<?php echo esc_attr( $mock['title'] ); ?>" 
                                     class="noticia-card__img" 
                                     loading="lazy" 
                                     decoding="async" />
                            </a>
                        </div>
                        <div class="noticia-card__body">
                            <div class="noticia-card__date-wrap">
                                <span class="noticia-card__bullet" aria-hidden="true">•</span>
                                <time class="noticia-card__date"><?php echo esc_html( $mock['date'] ); ?></time>
                            </div>
                            <h2 class="noticia-card__title">
                                <a href="#post-demo"><?php echo esc_html( $mock['title'] ); ?></a>
                            </h2>
                            <p class="noticia-card__excerpt"><?php echo esc_html( $mock['excerpt'] ); ?></p>
                            <a href="#post-demo" class="noticia-card__link">
                                <?php esc_html_e( 'saber mais', 'pacto-25' ); ?>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Left-Aligned Pagination (< 1 2 3 4 >) -->
        <nav class="noticias-pagination" aria-label="<?php esc_attr_e( 'Navegação de páginas de notícias', 'pacto-25' ); ?>">
            <?php
            global $wp_query;
            $max_pages = $wp_query->max_num_pages;

            if ( $max_pages > 1 ) :
                $current_page = max( 1, get_query_var( 'paged' ) );
                echo paginate_links( array(
                    'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                    'format'    => '?paged=%#%',
                    'current'   => $current_page,
                    'total'     => $max_pages,
                    'prev_text' => '<span class="pagination-arrow pagination-arrow--prev" aria-hidden="true">&lsaquo;</span><span class="screen-reader-text">' . esc_html__( 'Página anterior', 'pacto-25' ) . '</span>',
                    'next_text' => '<span class="pagination-arrow pagination-arrow--next" aria-hidden="true">&rsaquo;</span><span class="screen-reader-text">' . esc_html__( 'Página seguinte', 'pacto-25' ) . '</span>',
                    'type'      => 'list',
                    'end_size'  => 1,
                    'mid_size'  => 2,
                ) );
            else :
            ?>
                <!-- Static Fallback Pagination matching Figma design (< 1 2 3 4 >) -->
                <ul class="page-numbers">
                    <li><span class="prev page-numbers disabled" aria-hidden="true">&lsaquo;</span></li>
                    <li><span aria-current="page" class="page-numbers current">1</span></li>
                    <li><a class="page-numbers" href="#page-2">2</a></li>
                    <li><a class="page-numbers" href="#page-3">3</a></li>
                    <li><a class="page-numbers" href="#page-4">4</a></li>
                    <li><a class="next page-numbers" href="#page-2" aria-hidden="true">&rsaquo;</a></li>
                </ul>
            <?php endif; ?>
        </nav>
    </div>
</section>
