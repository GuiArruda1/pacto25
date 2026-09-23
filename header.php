<?php
/**
 * Header Template
 * Theme: Pacto 25
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="screen-reader-text" href="#primary-content">
    <?php esc_html_e( 'Saltar para o conteúdo principal', 'pacto-25' ); ?>
</a>

<header class="site-header" role="banner">
    <div class="site-container">
        <div class="site-header__inner">
            <!-- Branding / Logo (Customizable via ACF or WP Customizer) -->
            <div class="site-header__branding">
                <?php pacto_render_header_logo(); ?>
            </div>

            <!-- Mobile Navigation Toggle -->
            <button class="site-header__mobile-toggle" aria-expanded="false" aria-controls="primary-nav" aria-label="<?php esc_attr_e( 'Abrir Menu', 'pacto-25' ); ?>">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- Navigation Menu & Actions -->
            <div class="site-header__nav-wrapper" id="primary-nav">
                <nav class="site-header__nav" role="navigation" aria-label="<?php esc_attr_e( 'Menu Principal', 'pacto-25' ); ?>">
                    <?php
                    if ( has_nav_menu( 'primary' ) ) {
                        wp_nav_menu( array(
                            'theme_location' => 'primary',
                            'container'      => false,
                            'menu_class'     => 'site-header__nav-list',
                            'fallback_cb'    => false,
                            'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        ) );
                    } else {
                        // Dynamic Fallback menu list connecting all theme pages
                        $url_institucional = pacto_get_nav_url( 'quem-somos', 'page-quem-somos.php' );
                        $is_institucional  = is_page_template( 'page-quem-somos.php' ) || is_page( array( 'quem-somos', 'institucional', 'sobre' ) );

                        $url_particulares  = pacto_get_nav_url( 'particulares', 'page-particulares.php' );
                        $is_particulares   = is_page_template( 'page-particulares.php' ) || is_page( array( 'particulares', 'seguros-particulares' ) ) || is_singular( 'seguro_particular' );

                        $url_empresas      = pacto_get_nav_url( 'empresas', 'page-empresas.php', '#empresas' );
                        $is_empresas       = is_page( 'empresas' );

                        $url_sinistros     = pacto_get_nav_url( 'sinistro', 'page-sinistro.php' );
                        $is_sinistros      = is_page_template( 'page-sinistro.php' ) || is_page( array( 'sinistro', 'sinistros', 'em-caso-de-sinistro' ) );

                        $url_protocolos    = pacto_get_nav_url( 'protocolos', 'page-protocolos.php', '#protocolos' );
                        $is_protocolos     = is_page( 'protocolos' );

                        $url_contactos     = pacto_get_nav_url( 'contactos', 'page-contactos.php', '#contactos' );
                        $is_contactos      = is_page( array( 'contactos', 'contacto' ) );
                        ?>
                        <ul class="site-header__nav-list">
                            <li class="site-header__nav-item <?php echo $is_institucional ? 'current-menu-item' : ''; ?>">
                                <a href="<?php echo esc_url( $url_institucional ); ?>"><?php esc_html_e( 'institucional', 'pacto-25' ); ?></a>
                            </li>
                            <li class="site-header__nav-item site-header__nav-item--mega <?php echo $is_particulares ? 'current-menu-item' : ''; ?>" data-mega-id="mega-menu-particulares">
                                <a href="<?php echo esc_url( $url_particulares ); ?>" class="mega-menu-trigger" aria-haspopup="true" aria-expanded="false"><?php esc_html_e( 'particulares', 'pacto-25' ); ?></a>
                                <?php get_template_part( 'template-parts/header', 'mega-menu' ); ?>
                            </li>
                            <li class="site-header__nav-item <?php echo $is_empresas ? 'current-menu-item' : ''; ?>">
                                <a href="<?php echo esc_url( $url_empresas ); ?>"><?php esc_html_e( 'empresas', 'pacto-25' ); ?></a>
                            </li>
                            <li class="site-header__nav-item <?php echo $is_sinistros ? 'current-menu-item' : ''; ?>">
                                <a href="<?php echo esc_url( $url_sinistros ); ?>"><?php esc_html_e( 'sinistros', 'pacto-25' ); ?></a>
                            </li>
                            <li class="site-header__nav-item <?php echo $is_protocolos ? 'current-menu-item' : ''; ?>">
                                <a href="<?php echo esc_url( $url_protocolos ); ?>"><?php esc_html_e( 'protocolos', 'pacto-25' ); ?></a>
                            </li>
                            <li class="site-header__nav-item <?php echo $is_contactos ? 'current-menu-item' : ''; ?>">
                                <a href="<?php echo esc_url( $url_contactos ); ?>"><?php esc_html_e( 'contactos', 'pacto-25' ); ?></a>
                            </li>
                        </ul>
                        <?php
                    }
                    ?>
                </nav>

                <div class="site-header__actions">
                    <button type="button" class="search-trigger" aria-label="<?php esc_attr_e( 'Pesquisar', 'pacto-25' ); ?>" style="background: none; border: none; cursor: pointer; color: var(--color-dark); display: flex; align-items: center; padding: 8px;">
                        <?php echo pacto_get_svg( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </button>

                    <?php
                    $header_phone      = pacto_get_field( 'header_phone', false, '212 946 630' );
                    $header_phone_link = pacto_get_field( 'header_phone_link', false, '' );
                    if ( empty( $header_phone_link ) && ! empty( $header_phone ) ) {
                        $header_phone_link = 'tel:' . preg_replace( '/[^0-9+]/', '', $header_phone );
                    }
                    $header_cta_text = pacto_get_field( 'header_cta_text', false, '' );
                    $header_cta_url  = pacto_get_field( 'header_cta_url', false, '' );
                    ?>

                    <?php if ( ! empty( $header_phone ) ) : ?>
                        <a href="<?php echo esc_url( $header_phone_link ); ?>" class="btn btn--dark btn--sm site-header__phone-btn">
                            <?php echo pacto_get_svg( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            <span><?php echo esc_html( $header_phone ); ?></span>
                        </a>
                    <?php endif; ?>

                    <?php if ( ! empty( $header_cta_text ) && ! empty( $header_cta_url ) ) : ?>
                        <a href="<?php echo esc_url( $header_cta_url ); ?>" class="btn btn--primary btn--sm">
                            <span><?php echo esc_html( $header_cta_text ); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Backdrop Overlay -->
    <div class="site-header__backdrop" aria-hidden="true"></div>

    <!-- Accessible Search Modal Overlay -->
    <div class="site-search-modal" id="site-search-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Pesquisa no site', 'pacto-25' ); ?>">
        <div class="site-search-modal__backdrop" aria-hidden="true"></div>
        <div class="site-search-modal__dialog">
            <button type="button" class="site-search-modal__close" aria-label="<?php esc_attr_e( 'Fechar Pesquisa', 'pacto-25' ); ?>">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
            <form role="search" method="get" class="site-search-modal__form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <label for="modal-search-input" class="sr-only"><?php esc_html_e( 'Pesquisar', 'pacto-25' ); ?></label>
                <input type="search" id="modal-search-input" class="site-search-modal__input" placeholder="<?php esc_attr_e( 'O que procura? Ex: Seguro Automóvel, Sinistro...', 'pacto-25' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
                <button type="submit" class="site-search-modal__submit" aria-label="<?php esc_attr_e( 'Executar pesquisa', 'pacto-25' ); ?>">
                    <?php echo pacto_get_svg( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </button>
            </form>
        </div>
    </div>
</header>

<main id="primary-content" class="site-main">
