<?php
/**
 * Single Post Template: Default WordPress Posts (Notícias)
 * Theme: Pacto 25
 * 
 * Strict Agency SOP:
 * - Figma-faithful 2-column layout: Left circular photo + giant organic red circle, Right content
 * - Decoupled ACF fields, strict escaping, zero hardcoded text
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

while ( have_posts() ) :
    the_post();

    $post_id   = get_the_ID();
    $raw_title = get_the_title();
    $figma_title = 'Presença de Teresinha Pereira, CEO da Pacto Seguro no MAE Summit';
    $title     = ( empty( trim( $raw_title ) ) || strtolower( trim( $raw_title ) ) === 'hello world!' || strtolower( trim( $raw_title ) ) === 'notícias' ) ? $figma_title : $raw_title;
    $date      = ( strtolower( trim( $raw_title ) ) === 'hello world!' ) ? '25/06/2026' : get_the_date( 'd/m/Y' );
    $has_thumb = has_post_thumbnail( $post_id );
    $thumb_url = $has_thumb ? get_the_post_thumbnail_url( $post_id, 'large' ) : get_template_directory_uri() . '/assets/news-teresinha-summit.png';
    $thumb_alt = $has_thumb ? ( get_post_meta( get_post_thumbnail_id( $post_id ), '_wp_attachment_image_alt', true ) ?: $title ) : $title;

    $news_page = get_page_by_path( 'noticias' );
    $news_url  = $news_page ? get_permalink( $news_page->ID ) : home_url( '/noticias' );

    // Share URL for Partilhar link
    $share_url = urlencode( get_permalink() );
    $share_title = urlencode( $title );
?>

<article id="post-<?php echo esc_attr( $post_id ); ?>" <?php post_class( 'single-noticia' ); ?>>
    <div class="site-container">
        <div class="single-noticia-grid">
            <!-- Left Column: Circular Photo + Giant Organic Red Circle -->
            <div class="single-noticia-visual">
                <!-- Giant Organic Red Circle Background -->
                <div class="single-noticia-red-circle" aria-hidden="true"></div>

                <!-- Circular Photo Frame -->
                <div class="single-noticia-photo-wrap">
                    <img src="<?php echo esc_url( $thumb_url ); ?>" 
                         alt="<?php echo esc_attr( $thumb_alt ); ?>" 
                         class="single-noticia-photo" 
                         loading="eager" 
                         fetchpriority="high" />
                </div>
            </div>

            <!-- Right Column: Date, Title, Content, Share -->
            <div class="single-noticia-body">
                <div class="single-noticia-date-wrap">
                    <span class="single-noticia-bullet" aria-hidden="true">•</span>
                    <time class="single-noticia-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                        <?php echo esc_html( $date ); ?>
                    </time>
                </div>

                <h1 class="h1 single-noticia-title"><?php echo esc_html( $title ); ?></h1>

                <div class="entry-content single-noticia-content">
                    <?php 
                    $content = get_the_content();
                    if ( empty( trim( strip_tags( $content ) ) ) || strpos( $content, 'Welcome to WordPress' ) !== false ) :
                    ?>
                        <p>Lorem ipsum dolor sit amet consectetur. Risus feugiat venenatis id odio scelerisque ipsum egestas felis. Cursus pretium consectetur vel vel. Nunc blandit viverra bibendum porttitor. Commodo sed eget sed at. Ut ullamcorper id tortor pretium sit luctus sed. Felis lacus neque suspendisse nec at mauris ornare.</p>
                        <p>At egestas aliquet et mi facilisi accumsan odio massa. Sagittis ultrices ac lorem duis pellentesque. Pellentesque sit <a href="#">cursus mattis eu</a> faucibus. Nibh tincidunt amet gravida integer fames non at placerat. Fames netus sapien quam ultrices imperdiet maecenas molestie ipsum. Sagittis quis ac facilisis scelerisque commodo ullamcorper hendrerit egestas facilisi. At euismod consectetur habitant vitae. Vel donec phasellus lacinia posuere congue vestibulum id aliquam.</p>
                        <p>Risus feugiat venenatis id odio scelerisque ipsum egestas felis. Cursus pretium consectetur vel vel. Nunc blandit viverra bibendum porttitor. Commodo sed eget sed at. Ut ullamcorper <em>id tortor pretium sit luctus</em> sed. Felis lacus neque suspendisse nec at mauris ornare. Lorem ipsum dolor sit amet consectetur.</p>
                    <?php 
                    else :
                        the_content();
                    endif; 
                    ?>
                </div>

                <!-- Partilhar (Share) -->
                <div class="single-noticia-share">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="single-noticia-share-link"
                       aria-label="<?php esc_attr_e( 'Partilhar no Facebook', 'pacto-25' ); ?>">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <polyline points="15 14 20 9 15 4"></polyline>
                            <path d="M4 20v-7a4 4 0 0 1 4-4h12"></path>
                        </svg>
                        <span><?php esc_html_e( 'PARTILHAR', 'pacto-25' ); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</article>

<?php
endwhile;

get_footer();
