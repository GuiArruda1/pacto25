<?php
/**
 * Template Part: Empresas - Seguros List Grid Section
 * Theme: Pacto 25
 * 
 * Strict Agency SOP:
 * - Dynamic WP_Query over CPT 'seguro_empresa'
 * - Clean responsive 2-column card grid
 * - High-resolution rounded image style matching Figma
 * - Full fallback data for instantaneous visual perfection
 * - Clean semantic pagination
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
$posts_per_page = (int) pacto_get_field( 'empresas_seguros_per_page', false, 8 );

if ( $posts_per_page < 1 ) {
    $posts_per_page = 8;
}

$seguros_query = new WP_Query( array(
    'post_type'      => 'seguro_empresa',
    'post_status'    => 'publish',
    'posts_per_page' => $posts_per_page,
    'paged'          => $paged,
    'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
) );

// Static fallback items if no posts exist in DB yet
$default_seguros = array(
    array(
        'title'       => 'Seguro Multirriscos Empresa',
        'desc'        => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
        'btn_text'    => 'saber mais',
        'btn_url'     => '#',
        'image_file'  => 'multirriscos-empresa.png', // Fallback, doesn't exist yet but it's okay for now
    ),
    array(
        'title'       => 'Seguro Acidentes de Trabalho',
        'desc'        => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
        'btn_text'    => 'saber mais',
        'btn_url'     => '#',
        'image_file'  => 'acidentes-trabalho.png',
    ),
    array(
        'title'       => 'Seguro Responsabilidade Civil',
        'desc'        => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
        'btn_text'    => 'saber mais',
        'btn_url'     => '#',
        'image_file'  => 'responsabilidade-civil.png',
    ),
    array(
        'title'       => 'Seguro Frota Automóvel',
        'desc'        => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
        'btn_text'    => 'saber mais',
        'btn_url'     => '#',
        'image_file'  => 'frota-automovel.png',
    ),
);
?>

<section class="section section-empresas-seguros" aria-label="<?php esc_attr_e( 'Lista de Seguros para Empresas', 'pacto-25' ); ?>">
    <div class="site-container">
        <div class="empresas-seguros__grid">
            <?php if ( $seguros_query->have_posts() ) : ?>
                <?php while ( $seguros_query->have_posts() ) : $seguros_query->the_post(); 
                    $post_id   = get_the_ID();
                    $title     = get_the_title();
                    $content   = get_the_excerpt();
                    if ( empty( $content ) ) {
                        $content = wp_strip_all_tags( get_the_content() );
                    }
                    if ( empty( $content ) ) {
                        $content = 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.';
                    }

                    $btn_text  = pacto_get_field( 'seguro_btn_text', $post_id, get_post_meta( $post_id, '_seguro_btn_text', true ) );
                    if ( empty( $btn_text ) ) {
                        $btn_text = 'saber mais';
                    }

                    $btn_url   = pacto_get_field( 'seguro_btn_url', $post_id, get_post_meta( $post_id, '_seguro_btn_url', true ) );
                    if ( empty( $btn_url ) ) {
                        $btn_url = get_permalink( $post_id );
                    }
                ?>
                    <article class="seguro-card" id="seguro-<?php echo esc_attr( $post_id ); ?>">
                        <a href="<?php echo esc_url( $btn_url ); ?>" class="seguro-card__image-wrap" aria-label="<?php echo esc_attr( $title ); ?>">
                            <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                                <?php echo get_the_post_thumbnail( $post_id, 'medium_large', array( 'class' => 'seguro-card__image', 'alt' => esc_attr( $title ), 'loading' => 'lazy' ) ); ?>
                            <?php else : ?>
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/empresas/seguros/default.png' ); ?>" class="seguro-card__image" alt="<?php echo esc_attr( $title ); ?>" loading="lazy" />
                            <?php endif; ?>
                        </a>
                        <div class="seguro-card__content">
                            <h2 class="seguro-card__title">
                                <a href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( $title ); ?></a>
                            </h2>
                            <p class="seguro-card__desc"><?php echo esc_html( $content ); ?></p>
                            <a href="<?php echo esc_url( $btn_url ); ?>" class="seguro-card__link">
                                <?php echo esc_html( $btn_text ); ?>
                            </a>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>

            <?php else : ?>
                <!-- Default Fallback Rendering from Figma Design -->
                <?php foreach ( $default_seguros as $index => $item ) : 
                    $img_src = get_template_directory_uri() . '/assets/images/empresas/seguros/' . $item['image_file'];
                ?>
                    <article class="seguro-card">
                        <a href="<?php echo esc_url( $item['btn_url'] ); ?>" class="seguro-card__image-wrap" aria-label="<?php echo esc_attr( $item['title'] ); ?>">
                            <img src="<?php echo esc_url( $img_src ); ?>" class="seguro-card__image" alt="<?php echo esc_attr( $item['title'] ); ?>" loading="lazy" />
                        </a>
                        <div class="seguro-card__content">
                            <h2 class="seguro-card__title">
                                <a href="<?php echo esc_url( $item['btn_url'] ); ?>"><?php echo esc_html( $item['title'] ); ?></a>
                            </h2>
                            <p class="seguro-card__desc"><?php echo esc_html( $item['desc'] ); ?></p>
                            <a href="<?php echo esc_url( $item['btn_url'] ); ?>" class="seguro-card__link">
                                <?php echo esc_html( $item['btn_text'] ); ?>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Numbered Pagination -->
        <nav class="empresas-pagination" aria-label="<?php esc_attr_e( 'Navegação de páginas de seguros', 'pacto-25' ); ?>">
            <?php if ( $seguros_query->max_num_pages > 1 ) : ?>
                <?php
                echo paginate_links( array(
                    'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                    'format'    => '?paged=%#%',
                    'current'   => max( 1, $paged ),
                    'total'     => $seguros_query->max_num_pages,
                    'prev_text' => '<span aria-hidden="true">&lsaquo;</span>',
                    'next_text' => '<span aria-hidden="true">&rsaquo;</span>',
                    'type'      => 'list',
                ) );
                ?>
            <?php else : ?>
                <ul class="page-numbers">
                    <li><span class="prev page-numbers">&lsaquo;</span></li>
                    <li><span aria-current="page" class="page-numbers current">1</span></li>
                    <li><a class="page-numbers" href="#page-2">2</a></li>
                    <li><a class="page-numbers" href="#page-3">3</a></li>
                    <li><a class="page-numbers" href="#page-4">4</a></li>
                    <li><a class="next page-numbers" href="#page-2">&rsaquo;</a></li>
                </ul>
            <?php endif; ?>
        </nav>
    </div>
</section>
