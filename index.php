<?php
/**
 * Main Fallback Template
 * Theme: Pacto 25
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<div class="site-container section">
    <?php if ( have_posts() ) : ?>
        <div class="posts-stream">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-entry' ); ?> style="margin-bottom: var(--space-xl);">
                    <h2 class="h2">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="entry-meta text-muted" style="margin-bottom: var(--space-sm); font-size: var(--fs-body-sm);">
                        <?php echo get_the_date(); ?>
                    </div>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>

            <div class="pagination">
                <?php the_posts_pagination(); ?>
            </div>
        </div>
    <?php else : ?>
        <div class="no-results text-center">
            <h1 class="h2"><?php esc_html_e( 'Nenhum conteúdo encontrado', 'pacto-25' ); ?></h1>
            <p><?php esc_html_e( 'Pedimos desculpa, mas a página solicitada não foi encontrada.', 'pacto-25' ); ?></p>
        </div>
    <?php endif; ?>
</div>

<?php
get_footer();
