<?php
/**
 * Header Mega Menu: Particulares
 * Theme: Pacto 25
 * 
 * Strict Agency SOP:
 * - 4-column layout matching Figma design
 * - Decoupled content via ACF with defaults
 * - Zero hardcoded URLs or titles
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$front_page_id = get_option( 'page_on_front' );
$eyebrow_raw   = pacto_get_field( 'mm_particulares_eyebrow', $front_page_id, 'PARTICULARES' );
// Strip any manually typed leading bullets or stars so the CSS pseudo-element renders exactly one red dot
$eyebrow       = ltrim( trim( (string) $eyebrow_raw ), "•\t\n\r\0\x0B*· " );

// Default Column 1 links
$default_col1 = array(
    array( 'title' => 'seguro automóvel', 'url' => pacto_get_seguro_particular_url( 'automovel' ) ),
    array( 'title' => 'seguro multirriscos casa', 'url' => pacto_get_seguro_particular_url( 'multirriscos-casa' ) ),
    array( 'title' => 'seguro multirriscos condomínio', 'url' => pacto_get_seguro_particular_url( 'multirriscos-condominio' ) ),
    array( 'title' => 'seguro poupança reforma', 'url' => pacto_get_seguro_particular_url( 'poupanca-reforma' ) ),
    array( 'title' => 'seguro embarcações de recreio', 'url' => pacto_get_seguro_particular_url( 'embarcacoes-recreio' ) ),
);

// Default Column 2 links
$default_col2 = array(
    array( 'title' => 'seguro de vida', 'url' => pacto_get_seguro_particular_url( 'vida' ) ),
    array( 'title' => 'seguro empregada doméstica', 'url' => pacto_get_seguro_particular_url( 'empregada-domestica' ) ),
    array( 'title' => 'seguro acidentes pessoais', 'url' => pacto_get_seguro_particular_url( 'acidentes-pessoais' ) ),
    array( 'title' => 'seguro de saúde', 'url' => pacto_get_seguro_particular_url( 'saude' ) ),
);

// Default Column 3 links
$default_col3 = array(
    array( 'title' => 'seguro para desporto', 'url' => pacto_get_seguro_particular_url( 'desporto' ) ),
    array( 'title' => 'seguro de viagem', 'url' => pacto_get_seguro_particular_url( 'viagem' ) ),
    array( 'title' => 'seguro de reposição salarial', 'url' => pacto_get_seguro_particular_url( 'reposicao-salarial' ) ),
    array( 'title' => 'seguro erasmus', 'url' => pacto_get_seguro_particular_url( 'erasmus' ) ),
);

// Default Column 4 links
$default_col4 = array(
    array( 'title' => 'seguro para animais de estimação', 'url' => pacto_get_seguro_particular_url( 'animais-estimacao' ) ),
    array( 'title' => 'seguro caçadores e porte de arma', 'url' => pacto_get_seguro_particular_url( 'cacadores-porte-arma' ) ),
    array( 'title' => 'seguro alojamento local', 'url' => pacto_get_seguro_particular_url( 'alojamento-local' ) ),
    array( 'title' => 'seguro senhorios', 'url' => pacto_get_seguro_particular_url( 'senhorios' ) ),
);

$col1 = pacto_get_mega_menu_column( 1, $default_col1 );
$col2 = pacto_get_mega_menu_column( 2, $default_col2 );
$col3 = pacto_get_mega_menu_column( 3, $default_col3 );
$col4 = pacto_get_mega_menu_column( 4, $default_col4 );
?>

<div class="site-header__mega-menu" id="mega-menu-particulares" role="region" aria-label="<?php esc_attr_e( 'Menu de Seguros para Particulares', 'pacto-25' ); ?>">
    <div class="site-container">
        <div class="mega-menu__grid">
            <!-- Column 1 (with Eyebrow) -->
            <div class="mega-menu__col">
                <div class="mega-menu__col-header">
                    <?php if ( ! empty( $eyebrow ) ) : ?>
                        <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                    <?php endif; ?>
                </div>

                <?php if ( ! empty( $col1 ) && is_array( $col1 ) ) : ?>
                    <ul class="mega-menu__list">
                        <?php foreach ( $col1 as $item ) : ?>
                            <li>
                                <a href="<?php echo esc_url( ! empty( $item['url'] ) ? $item['url'] : '#' ); ?>" class="mega-menu__link">
                                    <?php echo esc_html( ! empty( $item['title'] ) ? $item['title'] : '' ); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Column 2 (aligned with Column 1 links) -->
            <div class="mega-menu__col">
                <div class="mega-menu__col-header mega-menu__col-header--empty" aria-hidden="true"></div>

                <?php if ( ! empty( $col2 ) && is_array( $col2 ) ) : ?>
                    <ul class="mega-menu__list">
                        <?php foreach ( $col2 as $item ) : ?>
                            <li>
                                <a href="<?php echo esc_url( ! empty( $item['url'] ) ? $item['url'] : '#' ); ?>" class="mega-menu__link">
                                    <?php echo esc_html( ! empty( $item['title'] ) ? $item['title'] : '' ); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Column 3 -->
            <div class="mega-menu__col">
                <div class="mega-menu__col-header mega-menu__col-header--empty" aria-hidden="true"></div>

                <?php if ( ! empty( $col3 ) && is_array( $col3 ) ) : ?>
                    <ul class="mega-menu__list">
                        <?php foreach ( $col3 as $item ) : ?>
                            <li>
                                <a href="<?php echo esc_url( ! empty( $item['url'] ) ? $item['url'] : '#' ); ?>" class="mega-menu__link">
                                    <?php echo esc_html( ! empty( $item['title'] ) ? $item['title'] : '' ); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Column 4 -->
            <div class="mega-menu__col">
                <div class="mega-menu__col-header mega-menu__col-header--empty" aria-hidden="true"></div>

                <?php if ( ! empty( $col4 ) && is_array( $col4 ) ) : ?>
                    <ul class="mega-menu__list">
                        <?php foreach ( $col4 as $item ) : ?>
                            <li>
                                <a href="<?php echo esc_url( ! empty( $item['url'] ) ? $item['url'] : '#' ); ?>" class="mega-menu__link">
                                    <?php echo esc_html( ! empty( $item['title'] ) ? $item['title'] : '' ); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
