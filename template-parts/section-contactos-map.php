<?php
/**
 * Template Part: Section Contactos Map ("Onde Estamos")
 * Theme: Pacto 25
 * 
 * Strict Agency SOP:
 * - Decoupled ACF fields with complete fallback defaults
 * - Giant organic red ball canopy on the right (matching Quem Somos / Porquê escolher-nos component)
 * - Left circular map frame with embedded map / interactive fallback
 * - Right narrative & 2-column structured office contacts inside the red container
 * - Ambient floating bubble dots
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page_id = get_the_ID() ?: get_queried_object_id();
if ( ! $page_id ) {
    $contact_page = get_page_by_path( 'contactos' );
    if ( $contact_page ) {
        $page_id = $contact_page->ID;
    }
}

// ACF Fields with fallbacks matching Figma
$eyebrow     = pacto_get_field( 'contactos_loc_eyebrow', $page_id, 'ENTRE EM CONTACTO' );
$title       = pacto_get_field( 'contactos_loc_title', $page_id, 'Onde Estamos' );
$description = pacto_get_field( 'contactos_loc_desc', $page_id, 'Estamos em todo o lado, juntos de si.' );

// Left Info Column
$sede_title       = pacto_get_field( 'contactos_loc_sede_title', $page_id, 'SEDE PORTO' );
$sede_addr1       = pacto_get_field( 'contactos_loc_sede_addr1', $page_id, 'Rua José Coutinho 252,' );
$sede_addr2       = pacto_get_field( 'contactos_loc_sede_addr2', $page_id, '4465-180 S. Mamede de Infesta, Matosinhos' );

$comercial_email  = pacto_get_field( 'contactos_loc_comercial_email', $page_id, 'comercial.matosinhos@pactoseguro.com' );
$comercial_phone  = pacto_get_field( 'contactos_loc_comercial_phone', $page_id, '937 805 784' );

$sinistros_email  = pacto_get_field( 'contactos_loc_sinistros_email', $page_id, 'sinistros.matosinhos@pactoseguro.com' );
$sinistros_phone  = pacto_get_field( 'contactos_loc_sinistros_phone', $page_id, '913 135 186' );

// Right Info Column
$subscricao_email = pacto_get_field( 'contactos_loc_subscricao_email', $page_id, 'subscricao.matosinhos@pactoseguro.com' );
$subscricao_phone = pacto_get_field( 'contactos_loc_subscricao_phone', $page_id, '926 270 605' );

$recrutamento     = pacto_get_field( 'contactos_loc_recrutamento_email', $page_id, 'recrutamento@pactoseguro.com' );
$direcao          = pacto_get_field( 'contactos_loc_direcao_email', $page_id, 'teresa.sousa@pactoseguro.com' );
$geral            = pacto_get_field( 'contactos_loc_geral_email', $page_id, 'geral@pactoseguro.com' );

$map_url = 'https://maps.google.com/?q=' . rawurlencode( 'Rua José Coutinho 252, 4465-180 São Mamede de Infesta, Matosinhos' );
?>

<section class="section section-contactos-locations" id="onde-estamos" aria-label="<?php echo esc_attr( $title ); ?>">
    <!-- Giant Organic Red Ball Canopy on Right (Matching Porquê Escolher-nos Red Ball Component) -->
    <div class="contactos-loc-canopy" aria-hidden="true"></div>

    <!-- Ambient Floating Red Bubble Dots Matching Figma Composition -->
    <div class="contactos-loc-dot contactos-loc-dot--top-1" aria-hidden="true"></div>
    <div class="contactos-loc-dot contactos-loc-dot--top-2" aria-hidden="true"></div>
    <div class="contactos-loc-dot contactos-loc-dot--left-bottom" aria-hidden="true"></div>
    <div class="contactos-loc-dot contactos-loc-dot--bottom-center" aria-hidden="true"></div>

    <div class="site-container contactos-loc-container">
        <div class="contactos-loc-grid">
            <!-- Left Column: Circular Map Frame -->
            <div class="contactos-loc-visual">
                <div class="contactos-map-circle-frame">
                    <iframe 
                        class="contactos-map-iframe"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3002.5760882354316!2d-8.608343923363073!3d41.18739777132561!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd2464522c07ef21%3A0xe5a36395b0586e92!2sR.%20Jos%C3%A9%20Coutinho%20252%2C%204465-180%20S%C3%A3o%20Mamede%20de%20Infesta!5e0!3m2!1spt-PT!2spt!4v1700000000000!5m2!1spt-PT!2spt" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        title="<?php esc_attr_e( 'Mapa Pacto Seguro Matosinhos', 'pacto-25' ); ?>">
                    </iframe>
                    <a href="<?php echo esc_url( $map_url ); ?>" target="_blank" rel="noopener noreferrer" class="contactos-map-link-overlay" aria-label="<?php esc_attr_e( 'Abrir no Google Maps', 'pacto-25' ); ?>"></a>
                </div>
            </div>

            <!-- Right Column: Content & 2-Column Info inside the Red Ball Canopy -->
            <div class="contactos-loc-content">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow contactos-loc-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h2 class="h2 contactos-loc-title"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                    <p class="contactos-loc-desc"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>

                <!-- 2-Column Contact Info Blocks -->
                <div class="contactos-loc-blocks-grid">
                    <!-- Column 1 -->
                    <div class="contactos-loc-col">
                        <!-- Sede Porto -->
                        <div class="contactos-loc-block">
                            <span class="contactos-loc-label"><?php echo esc_html( $sede_title ); ?></span>
                            <div class="contactos-loc-values">
                                <span class="contactos-loc-text"><?php echo esc_html( $sede_addr1 ); ?></span>
                                <span class="contactos-loc-text"><?php echo esc_html( $sede_addr2 ); ?></span>
                            </div>
                        </div>

                        <!-- Comercial -->
                        <div class="contactos-loc-block">
                            <span class="contactos-loc-label"><?php esc_html_e( 'COMERCIAL', 'pacto-25' ); ?></span>
                            <div class="contactos-loc-values">
                                <?php if ( $comercial_email ) : ?>
                                    <a href="<?php echo esc_url( 'mailto:' . $comercial_email ); ?>" class="contactos-loc-link"><?php echo esc_html( $comercial_email ); ?></a>
                                <?php endif; ?>
                                <?php if ( $comercial_phone ) : ?>
                                    <div class="contactos-loc-phone-row">
                                        <a href="<?php echo esc_url( 'tel:' . preg_replace( '/\s+/', '', $comercial_phone ) ); ?>" class="contactos-loc-link"><?php echo esc_html( $comercial_phone ); ?></a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Sinistros -->
                        <div class="contactos-loc-block">
                            <span class="contactos-loc-label"><?php esc_html_e( 'SINISTROS', 'pacto-25' ); ?></span>
                            <div class="contactos-loc-values">
                                <?php if ( $sinistros_email ) : ?>
                                    <a href="<?php echo esc_url( 'mailto:' . $sinistros_email ); ?>" class="contactos-loc-link"><?php echo esc_html( $sinistros_email ); ?></a>
                                <?php endif; ?>
                                <?php if ( $sinistros_phone ) : ?>
                                    <div class="contactos-loc-phone-row">
                                        <a href="<?php echo esc_url( 'tel:' . preg_replace( '/\s+/', '', $sinistros_phone ) ); ?>" class="contactos-loc-link"><?php echo esc_html( $sinistros_phone ); ?></a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="contactos-loc-col">
                        <!-- Subscrição -->
                        <div class="contactos-loc-block">
                            <span class="contactos-loc-label"><?php esc_html_e( 'SUBSCRIÇÃO', 'pacto-25' ); ?></span>
                            <div class="contactos-loc-values">
                                <?php if ( $subscricao_email ) : ?>
                                    <a href="<?php echo esc_url( 'mailto:' . $subscricao_email ); ?>" class="contactos-loc-link"><?php echo esc_html( $subscricao_email ); ?></a>
                                <?php endif; ?>
                                <?php if ( $subscricao_phone ) : ?>
                                    <div class="contactos-loc-phone-row">
                                        <a href="<?php echo esc_url( 'tel:' . preg_replace( '/\s+/', '', $subscricao_phone ) ); ?>" class="contactos-loc-link"><?php echo esc_html( $subscricao_phone ); ?></a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Recrutamento -->
                        <div class="contactos-loc-block">
                            <span class="contactos-loc-label"><?php esc_html_e( 'RECRUTAMENTO', 'pacto-25' ); ?></span>
                            <div class="contactos-loc-values">
                                <?php if ( $recrutamento ) : ?>
                                    <a href="<?php echo esc_url( 'mailto:' . $recrutamento ); ?>" class="contactos-loc-link"><?php echo esc_html( $recrutamento ); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Direção -->
                        <div class="contactos-loc-block">
                            <span class="contactos-loc-label"><?php esc_html_e( 'DIREÇÃO', 'pacto-25' ); ?></span>
                            <div class="contactos-loc-values">
                                <?php if ( $direcao ) : ?>
                                    <a href="<?php echo esc_url( 'mailto:' . $direcao ); ?>" class="contactos-loc-link"><?php echo esc_html( $direcao ); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Geral -->
                        <div class="contactos-loc-block">
                            <span class="contactos-loc-label"><?php esc_html_e( 'GERAL', 'pacto-25' ); ?></span>
                            <div class="contactos-loc-values">
                                <?php if ( $geral ) : ?>
                                    <a href="<?php echo esc_url( 'mailto:' . $geral ); ?>" class="contactos-loc-link"><?php echo esc_html( $geral ); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
