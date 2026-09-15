<?php
/**
 * Footer Template
 * Theme: Pacto 25
 * Strict Agency SOP:
 * - Arched organic canopy dome
 * - Centered white brand logo with "siga-nos:" and social icons (Facebook, Instagram, LinkedIn, YouTube)
 * - Two-row navigation links on the left
 * - Phone pill button + fixed-network schedule info on the right + circular scroll-to-top button
 * - Regulatory legal disclaimer and copyright
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
</main><!-- #primary-content -->

<footer class="site-footer" role="contentinfo">
    <!-- Exact 2560x1280 Ellipse Canopy Background from Figma -->
    <div class="site-footer__ellipse" aria-hidden="true"></div>

    <div class="site-container site-footer__container">
        <!-- Top Row: Centered White Brand Logo & Social Links -->
        <div class="site-footer__top">
            <div class="site-footer__brand">
                <?php pacto_render_footer_logo(); ?>
            </div>

            <div class="site-footer__social-block">
                <span class="site-footer__social-label"><?php esc_html_e( 'siga-nos:', 'pacto-25' ); ?></span>
                <div class="site-footer__social-icons">
                    <a href="https://facebook.com" class="site-footer__social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Facebook', 'pacto-25' ); ?>">
                        <?php echo pacto_get_svg( 'facebook' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </a>
                    <a href="https://instagram.com" class="site-footer__social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Instagram', 'pacto-25' ); ?>">
                        <?php echo pacto_get_svg( 'instagram' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </a>
                    <a href="https://linkedin.com" class="site-footer__social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'LinkedIn', 'pacto-25' ); ?>">
                        <?php echo pacto_get_svg( 'linkedin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </a>
                    <a href="https://youtube.com" class="site-footer__social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'YouTube', 'pacto-25' ); ?>">
                        <?php echo pacto_get_svg( 'youtube' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Middle Row: Navigation Links (Left) + Phone Info & Scroll to top (Right) -->
        <div class="site-footer__middle">
            <nav class="site-footer__nav" aria-label="<?php esc_attr_e( 'Menu Rodapé', 'pacto-25' ); ?>">
                <ul class="site-footer__nav-row site-footer__nav-row--primary">
                    <li><a href="#institucional"><?php esc_html_e( 'institucional', 'pacto-25' ); ?></a></li>
                    <li><a href="#particulares"><?php esc_html_e( 'particulares', 'pacto-25' ); ?></a></li>
                    <li><a href="#empresas"><?php esc_html_e( 'empresas', 'pacto-25' ); ?></a></li>
                    <li><a href="#sinistros"><?php esc_html_e( 'sinistros', 'pacto-25' ); ?></a></li>
                    <li><a href="#protocolos"><?php esc_html_e( 'protocolos', 'pacto-25' ); ?></a></li>
                    <li><a href="#contactos"><?php esc_html_e( 'contactos', 'pacto-25' ); ?></a></li>
                </ul>
                <ul class="site-footer__nav-row site-footer__nav-row--secondary">
                    <li><a href="#noticias"><?php esc_html_e( 'notícias', 'pacto-25' ); ?></a></li>
                    <li><a href="#privacidade"><?php esc_html_e( 'política de privacidade', 'pacto-25' ); ?></a></li>
                    <li><a href="#cookies"><?php esc_html_e( 'cookies', 'pacto-25' ); ?></a></li>
                    <li><a href="#termos"><?php esc_html_e( 'termos e condições', 'pacto-25' ); ?></a></li>
                    <li><a href="https://www.livroreclamacoes.pt" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'livro de reclamações', 'pacto-25' ); ?></a></li>
                </ul>
            </nav>

            <div class="site-footer__contact-block">
                <?php
                $phone      = pacto_get_field( 'header_phone', false, '212 946 630' );
                $phone_link = pacto_get_field( 'header_phone_link', false, '' );
                if ( empty( $phone_link ) && ! empty( $phone ) ) {
                    $phone_link = 'tel:' . preg_replace( '/[^0-9+]/', '', $phone );
                }
                ?>
                <div class="site-footer__phone-wrap">
                    <a href="<?php echo esc_url( $phone_link ?: 'tel:212946630' ); ?>" class="site-footer__phone-btn">
                        <?php echo pacto_get_svg( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        <span><?php echo esc_html( $phone ?: '212 946 630' ); ?></span>
                    </a>
                    <div class="site-footer__phone-desc">
                        <span><?php esc_html_e( 'Chamada para a rede fixa nacional', 'pacto-25' ); ?></span>
                        <span><?php esc_html_e( 'Dias úteis: 09h00 as 18h00', 'pacto-25' ); ?></span>
                    </div>
                </div>

                <!-- Stacked Action Buttons: Scroll to Top & WhatsApp -->
                <div class="site-footer__actions">
                    <button type="button" class="site-footer__action-btn site-footer__scroll-top scroll-to-top" aria-label="<?php esc_attr_e( 'Voltar ao topo', 'pacto-25' ); ?>">
                        <?php echo pacto_get_svg( 'chevron-up' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </button>
                    <?php
                    $whatsapp_phone = pacto_get_field( 'whatsapp_number', false, '351212946630' );
                    $whatsapp_clean = preg_replace( '/[^0-9]/', '', $whatsapp_phone );
                    ?>
                    <a href="https://wa.me/<?php echo esc_attr( $whatsapp_clean ); ?>" class="site-footer__action-btn site-footer__whatsapp-btn" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'WhatsApp', 'pacto-25' ); ?>">
                        <?php echo pacto_get_svg( 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom Row: Legal Disclaimer & Copyright / Credit -->
        <div class="site-footer__bottom">
            <div class="site-footer__legal-text">
                <p>
                    <?php
                    echo wp_kses_post(
                        __( 'Mediador de seguros inscrito, em 27-01-2007, no registo da ASF – Autoridade de Supervisão de Seguros e Fundos de Pensões com a categoria de Agente de Seguros, sob o n.º 407149001/3, com autorização para os ramos Vida e Não Vida verificável em <a href="https://www.asf.com.pt" target="_blank" rel="noopener noreferrer">www.asf.com.pt</a>. NIPC/NIF: 503996070, Membro APROSE com o n.º 3271, verificável em <a href="https://www.aprose.pt" target="_blank" rel="noopener noreferrer">www.aprose.pt</a>. Em caso de litígio o reclamante pode recorrer ao Centro de Informação, Mediação e Provedoria de Seguros (CIMPAS), enquanto Entidade de Resolução Alternativa de Litígios de consumo. Mais informações em <a href="https://www.cimpas.pt" target="_blank" rel="noopener noreferrer">www.cimpas.pt</a> ou no Portal do Consumidor em <a href="https://www.consumidor.pt" target="_blank" rel="noopener noreferrer">www.consumidor.pt</a>', 'pacto-25' )
                    );
                    ?>
                </p>
            </div>

            <div class="site-footer__copyright">
                <span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php esc_html_e( 'Pacto Seguro · Designed by', 'pacto-25' ); ?> <a href="https://sanzza.pt" target="_blank" rel="noopener noreferrer">Sanzza</a></span>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
