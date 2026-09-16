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
                        // Fallback accessible menu list matching design
                        ?>
                        <ul class="site-header__nav-list">
                            <li class="site-header__nav-item"><a href="#institucional"><?php esc_html_e( 'institucional', 'pacto-25' ); ?></a></li>
                            <li class="site-header__nav-item site-header__nav-item--mega" data-mega-id="mega-menu-particulares">
                                <a href="#particulares" class="mega-menu-trigger" aria-haspopup="true" aria-expanded="false">
                                    <span class="nav-dot" aria-hidden="true"></span>
                                    <span><?php esc_html_e( 'particulares', 'pacto-25' ); ?></span>
                                </a>
                                <?php get_template_part( 'template-parts/header', 'mega-menu' ); ?>
                            </li>
                            <li class="site-header__nav-item"><a href="#empresas"><?php esc_html_e( 'empresas', 'pacto-25' ); ?></a></li>
                            <li class="site-header__nav-item"><a href="#sinistros"><?php esc_html_e( 'sinistros', 'pacto-25' ); ?></a></li>
                            <li class="site-header__nav-item"><a href="#protocolos"><?php esc_html_e( 'protocolos', 'pacto-25' ); ?></a></li>
                            <li class="site-header__nav-item"><a href="#contactos"><?php esc_html_e( 'contactos', 'pacto-25' ); ?></a></li>
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
                            <?php echo esc_html( $header_cta_text ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Backdrop Overlay -->
    <div class="site-header__backdrop" aria-hidden="true"></div>
</header>

<main id="primary-content" class="site-main">
