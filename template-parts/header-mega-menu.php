<?php
/**
 * Header Mega Menu: Particulares & Empresas
 * Theme: Pacto 25
 * 
 * Strict Agency SOP:
 * - Dynamic 4-column layout pulling directly from Custom Post Types (seguro_particular / seguro_empresa)
 * - Zero hardcoded URLs or static ACF dependency
 * - Equal column distribution matching Figma design
 * - Pixel-perfect baseline alignment across all columns
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_type = ! empty( $args['post_type'] ) ? $args['post_type'] : 'seguro_particular';
$eyebrow   = ! empty( $args['eyebrow'] ) ? $args['eyebrow'] : ( 'seguro_empresa' === $post_type ? 'EMPRESAS' : 'PARTICULARES' );
$menu_id   = ! empty( $args['id'] ) ? $args['id'] : ( 'seguro_empresa' === $post_type ? 'mega-menu-empresas' : 'mega-menu-particulares' );

// Strip any leading bullet symbols so CSS ::before creates exactly one styled red dot
$eyebrow = ltrim( trim( (string) $eyebrow ), "•\t\n\r\0\x0B*· " );

// Fetch dynamic CPT posts
$items = pacto_get_cpt_mega_menu_items( $post_type );

// If no published posts exist in database yet, fallback gracefully
if ( empty( $items ) ) {
    $items = pacto_get_cpt_mega_menu_fallback( $post_type );
}

// Distribute items across 4 columns
$columns = pacto_distribute_mega_menu_columns( $items, 4 );
?>

<div class="site-header__mega-menu" id="<?php echo esc_attr( $menu_id ); ?>" role="region" aria-label="<?php echo esc_attr( sprintf( __( 'Menu de Seguros para %s', 'pacto-25' ), $eyebrow ) ); ?>">
    <div class="site-container">
        <div class="mega-menu__grid">
            <?php foreach ( $columns as $col_index => $col_items ) : ?>
                <div class="mega-menu__col">
                    <div class="mega-menu__col-header<?php echo 0 !== $col_index ? ' mega-menu__col-header--empty' : ''; ?>" <?php echo 0 !== $col_index ? 'aria-hidden="true"' : ''; ?>>
                        <?php if ( 0 === $col_index && ! empty( $eyebrow ) ) : ?>
                            <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                        <?php endif; ?>
                    </div>

                    <?php if ( ! empty( $col_items ) && is_array( $col_items ) ) : ?>
                        <ul class="mega-menu__list">
                            <?php foreach ( $col_items as $item ) : ?>
                                <li>
                                    <a href="<?php echo esc_url( ! empty( $item['url'] ) ? $item['url'] : '#' ); ?>" class="mega-menu__link">
                                        <?php echo esc_html( ! empty( $item['title'] ) ? $item['title'] : '' ); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
