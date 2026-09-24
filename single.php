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
    $title     = get_the_title();
    $date      = get_the_date( 'd/m/Y' );
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
                    <?php the_content(); ?>
                </div>

                <!-- Partilhar (Share) -->
                <div class="single-noticia-share">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="single-noticia-share-link"
                       aria-label="<?php esc_attr_e( 'Partilhar no Facebook', 'pacto-25' ); ?>">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="18" cy="5" r="3"/>
                            <circle cx="6" cy="12" r="3"/>
                            <circle cx="18" cy="19" r="3"/>
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
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
